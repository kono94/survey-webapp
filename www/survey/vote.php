<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";
/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

/* Wenn dieser POST-Parameter gesetzt ist, dann wurde abgestimmt und das Formular übermittelt.
Es wird jetzt also versucht, die Bewertungen zu speichern */
if (isset($_POST['survey_id'])) {
    /* Es muss mindestens eine Antwort gewählt worden sein. "> 2", da "survey_id" und "single_select" auch schon
     Keys in POST-Data sind */
    if (sizeof($_POST) < 2) {
        echo "<span class='fail-text'>You must select at least one answer</span>";
        exit;
    }

    /* 
    Wenn die Umfrage single select ist, dann versteckt sich die survey_answer_option_id
    hinter dem Key der eigentlichen survey_id.
    Bei multi select werden die survey_answer_option_id als Key geschickt mit dem value 'on', der 
    default-Wert bei Checkboxen.
    Um zu wissen, um welche Variante es sich handelt, wird ein zusätzlicher
    hidden input versendet "single_select", der angibt, ob es sich um eine single select oder
    multi select Umfrage handelt.
    
    $_POST-Data:
    single select:
        {
            "survey_id": 4,
            "single_select": 1,
            "4": "429"             // <<survey_id>> : <<survey_answer_option_id>>>
        }
    multi select:
        {
            "survey_id": 4,
            "single_select": 0,
            "429": "on",
            "430": "on",
        }
        */


    
    if(!isset($_POST['single_select'])){
        echo "Fehlerhafter Input; 'single_select' fehlt";
        exit;
    }

    $sql = " INSERT INTO survey_voting 
            (survey_id)
            VALUES
            (?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_POST['survey_id']);
    if (!$stmt->execute()) {
        echo "Fehler beim Speichern des Votings";
        exit;
    }

    $votingID = $stmt->insert_id;
    $error = false;
    $atLeastOneAnswer = false;
    if($_POST['single_select'] == 1){
        if(isset($_POST[$_POST['survey_id']])){
            $surveyAnswerOptionID = $_POST[$_POST['survey_id']];
            $sql = " INSERT INTO survey_voting_answer
            (survey_voting_id, survey_answer_option_id)
            VALUES
            (?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", $votingID, $surveyAnswerOptionID);
            if (!$stmt->execute()) {
                $error = true;
            }else{
                $atLeastOneAnswer = true;
            }
        }else{
            $error = true;
        }
    }else{
        foreach(array_keys($_POST) as $surveyAnswerOptionID){
            /* Wie bereit oben angemerkt, muss man aufpassen, da "survey_id" und "single_selecg" auch Keys in
             POST-Data ist. Diese Fälle überspringen wir einfach mit "continue" und die
             Schleife wird fortgesetzt */
            if($surveyAnswerOptionID === 'survey_id' || $surveyAnswerOptionID === 'single_select'){
                continue;
            }

            $sql = " INSERT INTO survey_voting_answer
            (survey_voting_id, survey_answer_option_id)
            VALUES
            (?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", $votingID, $surveyAnswerOptionID);
            if (!$stmt->execute()) {
                $error = true;
            }else{
                $atLeastOneAnswer = true;
            }
        }
    }
    
    if($error || !$atLeastOneAnswer){
        $sql = "DELETE FROM survey_voting WHERE id".$votingID;
        $res = mysqli_query($mysqli, $sql);
        echo "Fehler beim Speichern einer Antwort, lösche komplette Abstimmung wieder";
        exit;
    }

    /* Wird eine Abstimmung erfolgreich gespeichert, so wird man weitergeleitet auf
    eine Seite mit den bisherigen Resultaten dieser Umfrage. Um einfach eine Nachricht auf
    der nächsten Seite anzuzeigen wird zusätzlich ein paramter "msg" angeben, der
    auf der "result.php" Seite als erfolgreiche Nachricht interpretiert und angezeigt wird */
    header('Location: result.php?id='.$_POST['survey_id'].'&msg=Umfrage erfolgreich abgeschlossen');
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "You did not pass in an ID.";
    exit;
}

/* Hole Umfrage, die angezeigt werden soll. Verwende prepared statement, da der Benutzer
über die URL einfach die ID angeben kann, auch Strings, die schädlich sein könnten, wenn sie
direkt in die Query hineingesetzt werden (SQL-Injection) */
$sql = "SELECT survey.*, category.name AS category_name, category.color AS category_color FROM survey INNER JOIN category ON survey.category_id = category.id WHERE survey.id = ? LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$res = $stmt->get_result();
/* Gebe Fehlernachricht aus, wenn keine Umfrage mit angegebener ID existiert */
if($res->num_rows === 0){
    echo "Keine passende Umfrage mit der ID ".$_GET['id']." gefunden";
    exit;
}
 /* Wir wissen, dass nur maximal ein Eintrag im "result" auftreten wird,
    deswegen reicht es einmal "fetch_assoc()" aufzurufen */ 
$survey = $res->fetch_assoc();

createHeader("Umfrage-Tool");
?>
<div style="margin: 0 auto;
    width: 80%;
    text-align: center;">
<h3>
    <?= $survey['title'] ?> (ID: <?= $survey['id']?>, Kategorie: <span style="font-weigt:700; color:<?= $survey['category_color']?>"><?=$survey['category_name']?></span>)
</h3>
<p style="margin-bottom:40px"> 
    <?= $survey['description_text'] ?> 
</p>
<form action='vote.php' method='POST'>
    <div style="border-top: 10px solid <?= $survey['category_color']?>;
                padding-top: 20px;">
        <div class="question">
            <?php 
            /* Hole alle Antwortmöglichkeiten zu dieser Frage. Über die Kreuztabelle
                survey_answer_option, werden Umfragen mit Antwortmöglichkeiten verbunden.
                Man muss sich also nur alle Einträge dieser Tabelle holen, wo die survey_id mit der ID der 
                Umfrage gleich ist und alle Antworten dazu holen (LEFT JOIN), um ihren "title" zu bekommen */
            $sql = "SELECT a.id, a.title, a.description_text, sao.id AS sao_id FROM survey_answer_option AS sao LEFT JOIN answer AS a ON sao.answer_id = a.id WHERE sao.survey_id =".$survey['id'];
            $answerResult = mysqli_query($mysqli, $sql);
            while ($answer = mysqli_fetch_assoc($answerResult)):?>
                <div>
                    <?php if($survey['single_select'] === 1): ?>
                        <input type='radio' id="<?=$answer['sao_id']?>" name='<?= $survey['id'] ?>' value='<?= $answer['sao_id'] ?>'>
                    <?php else:?>
                        <input type='checkbox' id="<?=$answer['sao_id']?>" name='<?= $answer['sao_id'] ?>'>
                    <?php endif; ?>
                    <label for="<?=$answer['sao_id']?>"><?= $answer['title'] ?></label>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <input type='hidden' name='survey_id' value='<?= $survey['id'] ?>' />
    <input type='hidden' name='single_select' value='<?= $survey['single_select'] ?>' />
    <input type='submit' class="btn btn-primary" value='Absenden' style="background-color: <?= $survey['category_color']?>; border-color: <?= $survey['category_color']?>">
</form>
</div>
<?php
createFooter();
?>