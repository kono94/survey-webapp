<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";
/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

/* Die ID der Umfrage muss in der URL angegeben werden*/
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "You did not pass in an ID.";
    exit;
}

createHeader("Resultat");

/* Hole die Umfrage, zu der die Ergebnisse angezeigt werden sollen mit der dazugehörigen Kategorie  */
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
?>
<div style="margin: 0 auto;
    width: 80%;
    text-align: center;">
<h3>
    <?= $survey['title'] ?> (ID: <?= $survey['id'] ?>, Kategorie: <span style="font-weigt:700; color:<?= $survey['category_color']?>"><?=$survey['category_name']?></span>)
</h3>
<span>Beschreibung:</span>
<p style="margin-bottom:40px"> 
    <?= $survey['description_text'] ?> 
</p>
<?php 

    /* Hole alle Fragen, die zu dieser Umfrage gehören mit dem jeweiligen question_typ,
     um zwischen vorgebenen Antwortmöglichkeiten (radio-button-fragen) und Freitexteingaben
     der Benutzer zu unterscheiden */
    $sql = "SELECT q.id, q.title, qt.name AS question_type_name FROM survey_question AS sq LEFT JOIN question AS q ON sq.id = q.id INNER JOIN question_type AS qt ON q.question_type_id = qt.id WHERE sq.survey_id = ".$survey['id'];
    $res = mysqli_query($mysqli, $sql);
    /* Index um die Fragen zu Nummerieren */
    $index = 0;
    while ($question = mysqli_fetch_assoc($res)):
        $index++;
        /* Schaue nach wieviele Stimmen insgesamt für diese Frage abgegeben worden sind */
        $sql = "SELECT count(*) AS totalVotes FROM survey_result AS sr LEFT JOIN question_answer_option AS qao ON sr.question_answer_option_id = qao.id WHERE sr.survey_id = ".$survey['id']." AND qao.question_id = ".$question['id'];
        /* fetch_assoc() returnt ein Array, auf das man direkt zugreifen kann, das spart unnötige Variablen */
        $totalVotesResult = mysqli_query($mysqli, $sql);
        $totalVotes = mysqli_fetch_assoc($totalVotesResult)['totalVotes'];
        /* Verhindere, dass später durch 0 geteilt wird */
        if($totalVotes == 0){
            $totalVotes = 1;
        }
    ?>
    <div>
            <h5><?= $index.". ".$question['title'] ?> (<?=$totalVotes?> insgesamt)</h5>
            <div class="question" style="margin-left: 20%;">
                <?php 
                /* Hole alle Antwortmöglichkeiten, die zu der Frage gehören */
                $sql = "SELECT a.id, a.title FROM question_answer_option AS qao INNER JOIN answer AS a ON a.id = qao.answer_id WHERE qao.question_id = ".$question['id'];
                $answerResult = mysqli_query($mysqli, $sql);
                /* Gehe durch alle Antworten und zeige diese an. Wir haben die Gesamtanzahl der Stimmen für
                diese Frage und für jede einzelne Antwort, somit können wir den Anteil jeder Antwortmöglichkeit berechnen.
                Die Prozentanzahl kann man zudem als Wert für "width" verwenden, um eine result bar anzeigen zu lassen */
                while ($answer = mysqli_fetch_assoc($answerResult)):
                    /* Gib die Anzahl an votes für die jeweilige Antwortmöglichkeit zurück */
                    $sql = "SELECT COUNT(*) AS answerVotes FROM survey_result AS sr LEFT JOIN  question_answer_option AS qao ON sr.question_answer_option_id = qao.id WHERE qao.answer_id = ".$answer['id'];
                    $voteResult = mysqli_query($mysqli, $sql);
                    $answerVotes = mysqli_fetch_assoc($voteResult)['answerVotes'];
                    ?>
                    <div style="width:500px">
                        <?= $answer['title'] ?> (<?=$answerVotes?> votes)
                        <div class="result-bar" style= "width:<?=@round(($answerVotes/$totalVotes)*100)?>%; background-color: <?= $survey['category_color']?>">
                             <?=@round(($answerVotes/$totalVotes)*100)?>%
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
                </div>
    <?php endwhile; ?>
</div>
<?php
createFooter();
?>