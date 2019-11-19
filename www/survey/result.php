<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";
/* use $con to access the database */
require "../includes/dbConnection.inc.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "You did not pass in an ID.";
    exit;
}

$sql = "SELECT survey.*, category.name AS category_name FROM survey INNER JOIN category ON survey.category_id = category.id WHERE survey.id = ? LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$survey = $stmt->get_result()->fetch_assoc();

createHeader("Resultat - ".$survey['title']);
?>

<h3>
    <?= $survey['title'] ?> (ID: <?= $survey['id'] ?>)
</h3>
<p> 
    <?= $survey['description_text'] ?> 
</p>


<? 
    $sql = "SELECT q.id, q.title, qt.name AS question_type_name FROM survey_question AS sq LEFT JOIN question AS q ON sq.id = q.id INNER JOIN question_type AS qt ON q.question_type_id = qt.id WHERE sq.survey_id = ".$survey['id'];
    $questions = mysqli_query($mysqli, $sql);
    $index = 0;
    foreach ($questions as $question): 
        $index++;
        $sql = "SELECT count(*) AS totalVotes FROM survey_result AS sr LEFT JOIN question_answer_option AS qao ON sr.question_answer_option_id = qao.id WHERE sr.survey_id = ".$survey['id']." AND qao.question_id = ".$question['id'];
        $totalVotes = mysqli_query($mysqli, $sql)->fetch_assoc()['totalVotes'];
    ?>
        <div class="question">
            <h5><?= $index.". ".$question['title'] ?> (<?=$totalVotes?> insgesamt)</h5>
            <div>
                <? 
                $sql = "SELECT count(*) AS answerVotes, a.title AS totalVotes FROM survey_result AS sr LEFT JOIN question_answer_option AS qao ON sr.question_answer_option_id = qao.id LEFT JOIN answer AS a ON qao.answer_id = a.id WHERE sr.survey_id = ".$survey['id']." AND qao.question_id = ".$question['id']." GROUP BY a.id";
                $answers = mysqli_query($mysqli, $sql);
                foreach ($answers as $answer): 
                    $answerVotes = $answer['answerVotes'];?>
                    <div style="width:500px">
                        <?= $answer['title'] ?> (<?=$answerVotes?> votes)
                        <div class="result-bar" style= "width:<?=@round(($answerVotes/$totalVotes)*100)?>%">
                         <?=@round(($answerVotes/$totalVotes)*100)?>%
                </div>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    <? endforeach ?>
<?php
createFooter();
?>