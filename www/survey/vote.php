<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";
/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

/* Wenn dieser POST-Parameter gesetzt ist, dann wurde abgestimmt und das Formular übermittelt.
Es wird jetzt also versucht, die Bewertungen zu speichern */
if (isset($_POST['survey_id'])) {
    /* Es muss mindestens eine Antwort gewählt worden sein. > 1, da "survey_id" auch schon
    ein Key in POST-Data ist */
    if (sizeof($_POST) < 1) {
        echo "You must select at least one answer";
        exit;
    }

    /* Die Fragen mit ihren jeweiligen Antworten wurden in einer Map gespeichert.
    questionID -> question_answer_option_id 
    Der Befehl "array_keys" wandelt alle Keys dieser Map in ein Array um, sodass
    man ein Array mit allen questionIDs bekommt */ 
    foreach(array_keys($_POST) as $questionID){
        /* Wie bereit oben angemerkt, muss man aufpassen, da "survey_id" auch ein Key in
         POST-Data ist. Diesen Fall überspringen wir einfach mit "continue" und die
         Schleife wird fortgesetzt */
        if($questionID === 'survey_id'){
            continue;
        }
        
        /* Speichere eine Antwort zu einer Frage in die Datenbank.
        Question_answer_option_id ist dabei die ID der Kreuztabelle, die
        Fragen mit Antwortmöglichkeiten verbindet. Diese ID reicht also in Verbindung
        mit der survey_id, um später zurückverfolgen zu können, um welche Frage und Antwort es sich
        bei dieser Stimme gehandelt hat*/ 
        $sql = " INSERT INTO survey_result 
        (survey_id, question_answer_option_id)
        VALUES
        (?, ?)";
        $stmt = $mysqli->prepare($sql);
        /* Binde zwei Integer-Werte an die beiden Fragezeichen in der Query */
        $stmt->bind_param("ii", $_POST['survey_id'],  $_POST[$questionID]);
        if (!$stmt->execute()) {
            /* Dies kann man auskommentieren, um eine detaillierte Fehlermeldung zu bekommen.
            Sollte man aber nur während der Entwicklung machen */
            # echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            echo "Fehler beim Speichern der Antworten";
            exit;
        }
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
$sql = "SELECT survey.*, category.name AS category_name FROM survey INNER JOIN category ON survey.category_id = category.id WHERE survey.id = ? LIMIT 1";
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

<h3>
    <?= $survey['title'] ?> (ID: <?= $survey['id'] ?>)
</h3>
<p style="margin-bottom:40px"> 
    <?= $survey['description_text'] ?> 
</p>
<form action='vote.php' method='POST'>
    <?php 
     /* Hole alle Fragen, die zu dieser Umfrage gehören mit dem jeweiligen question_typ,
     um zwischen vorgebenen Antwortmöglichkeiten (radio-button-fragen) und Freitexteingaben
     der Benutzer zu unterscheiden */
    $sql = "SELECT q.id, q.title, qt.name AS question_type_name FROM survey_question AS sq LEFT JOIN question AS q ON sq.id = q.id INNER JOIN question_type AS qt ON q.question_type_id = qt.id WHERE sq.survey_id = ".$survey['id'];
    $res = mysqli_query($mysqli, $sql);
    /* Index um die Fragen zu Nummerieren */
    $index = 0;
    while ($question = mysqli_fetch_assoc($res)): $index++;?>
        <div>
            <h5><?= $index.". ".$question['title'] ?></h5>
            <div class="question">
                <?php 
                /* Hole alle Antwortmöglichkeiten zu dieser Frage. Über die Kreuztabelle
                 question_answer_option, werden Fragen mit Antwortmöglichkeiten verbunden.
                 Man muss sich also nur alle Einträge dieser Tabelle holen, wo die question_id mit ID der 
                 Frage gleich ist und alle Antworten dazu holen (LEFT JOIN), um ihren "title" zu kommen */
                $sql = "SELECT a.id, a.title, qao.id AS qao_id FROM question_answer_option AS qao LEFT JOIN answer AS a ON qao.answer_id = a.id WHERE qao.question_id =".$question['id'];
                $answerResult = mysqli_query($mysqli, $sql);
                while ($answer = mysqli_fetch_assoc($answerResult)):?>
                    <div>
                        <input id="<?=$answer['qao_id']?>" type='radio' name='<?= $question['id'] ?>' value='<?= $answer['qao_id'] ?>'>
                        <label for="<?=$answer['qao_id']?>"><?= $answer['title'] ?></label>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endwhile; ?>

    <input type='hidden' name='survey_id' value='<?= $survey['id'] ?>' />
    <input type='submit' class="btn btn-primary" value='Absenden'>
</form>
<?php
createFooter();
?>