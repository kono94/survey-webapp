<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";
/* use $con to access the database */
require "../includes/dbConnection.inc.php";

# At least one answers has to be posted
if (isset($_POST['survey_id'])) {
    if (sizeof($_POST) < 1) {
        echo "You must select at least one answer";
        exit;
    }

    foreach(array_keys($_POST) as $questionID){
        if($questionID === 'survey_id'){
            continue;
        }
        
        $sql = " INSERT INTO survey_result 
        (survey_id, question_answer_option_id)
        VALUES
        (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $_POST['survey_id'],  $_POST[$questionID]);
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            echo "Fehler beim Speichern der Antworten";
            exit;
        }
    }

    header('Location: result.php?id='.$_POST['survey_id'].'&msg=Umfrage erfolgreich abgeschlossen');
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "You did not pass in an ID.";
    exit;
}

$sql = "SELECT survey.*, category.name AS category_name FROM survey INNER JOIN category ON survey.category_id = category.id WHERE survey.id = ? LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$survey = $stmt->get_result()->fetch_assoc();

createHeader("Umfrage-Tool");
?>

<h3>
    <?= $survey['title'] ?> (ID: <?= $survey['id'] ?>)
</h3>
<p> 
    <?= $survey['description_text'] ?> 
</p>
<form action='vote.php' method='POST'>
    <? 
    $sql = "SELECT q.id, q.title, qt.name AS question_type_name FROM survey_question AS sq LEFT JOIN question AS q ON sq.id = q.id INNER JOIN question_type AS qt ON q.question_type_id = qt.id WHERE sq.survey_id = ".$survey['id'];
    $questions = mysqli_query($mysqli, $sql);
    $index = 0;
    foreach ($questions as $question): $index++;?>
        <div>
            <h5><?= $index.". ".$question['title'] ?></h5>
            <div class="question">
                <? 
                $sql = "SELECT a.id, a.title, qao.id AS qao_id FROM question_answer_option AS qao LEFT JOIN answer AS a ON qao.answer_id = a.id WHERE qao.question_id =".$question['id'];
                $res = mysqli_query($mysqli, $sql);
                foreach ($res as $answer) : ?>
                    <div>
                        <input id="<?=$answer['qao_id']?>" type='radio' name='<?= $question['id'] ?>' value='<?= $answer['qao_id'] ?>'>
                        <label for="<?=$answer['qao_id']?>"><?= $answer['title'] ?></label>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    <? endforeach ?>

    <input type='hidden' name='survey_id' value='<?= $survey['id'] ?>' />
    <input type='submit' class="btn btn-primary" value='Absenden'>
</form>
<?php
createFooter();
?>