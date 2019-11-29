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

    /* Schaue nach wieviele Stimmen insgesamt für diese Umfrage abgegeben worden sind */
    $sql = "SELECT count(sva.id) AS totalVotes FROM survey_voting AS sv LEFT JOIN survey_voting_answer AS sva ON sv.id = sva.survey_voting_id WHERE sv.survey_id = ".$survey['id'];
    /* fetch_assoc() returnt ein Array, auf das man direkt zugreifen kann, das spart unnötige Variablen */
    $totalVotesResult = mysqli_query($mysqli, $sql);
    $totalVotes = mysqli_fetch_assoc($totalVotesResult)['totalVotes'];
    
    $sql = "SELECT COUNT(*) AS voteSessionCount FROM survey_voting AS sv WHERE sv.survey_id = ".$survey['id'];
    $voteSessionCountResult = mysqli_query($mysqli, $sql);
    $voteSessionCount = mysqli_fetch_assoc($voteSessionCountResult)['voteSessionCount'];
    $votesSessionCount =  $stats['voteSessionsCount'];
    /* Verhindere, dass später durch 0 geteilt wird */
    if($totalVotes == 0){
        $totalVotes = 1;
    }
    ?>
    <div>
       
        <div class="question" style="margin-left: 20%;">
        <span style="display:block;margin-bottom:50px"><b style="font-size:25px"><?= $totalVotes?></b> Gesamtstimmen in <b style="font-size:25px"><?= $voteSessionCount?> </b>Sessions gesammelt:</span>
            <?php 
            /* Hole alle Antwortmöglichkeiten, die zu der Umfrage gehören */
            $sql = "SELECT a.id, a.title, a.description_text, sao.id AS sao_id FROM survey_answer_option AS sao LEFT JOIN answer AS a ON sao.answer_id = a.id WHERE sao.survey_id =".$survey['id'];
            $answerResult = mysqli_query($mysqli, $sql);
            /* Gehe durch alle Antworten und zeige diese an. Wir haben die Gesamtanzahl der Stimmen für
            diese Frage und für jede einzelne Antwort, somit können wir den Anteil jeder Antwortmöglichkeit berechnen.
            Die Prozentanzahl kann man zudem als Wert für "width" verwenden, um eine result bar anzeigen zu lassen */
            while ($answer = mysqli_fetch_assoc($answerResult)):
                /* Gib die Anzahl an votes für die jeweilige Antwortmöglichkeit zurück */
                $sql = "SELECT COUNT(*) AS answerVotes FROM survey_voting_answer AS sva  WHERE sva.survey_answer_option_id = ".$answer['sao_id'];
                $voteResult = mysqli_query($mysqli, $sql);
                $answerVotes = mysqli_fetch_assoc($voteResult)['answerVotes'];
                ?>
                <div style="width:500px">
                    <?= $answer['title'] ?> (<?=$answerVotes?> Stimmen)
                    <div class="result-bar" style= "width:<?=@round(($answerVotes/$totalVotes)*100)?>%; background-color: <?= $survey['category_color']?>">
                            <?=@round(($answerVotes/$totalVotes)*100)?>%
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php
createFooter();
?>