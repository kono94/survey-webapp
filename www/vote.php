<?php
require 'controller/SurveyData.php';
require 'template/TemplateFactory.php';

TemplateFactory::createDefaultHeader("kek");

$surveyData = new SurveyData();
# At least one answers has to be posted
if (isset($_POST['survey_id'])) {
    if (sizeof($_POST) < 1) {
        echo "You must select at least one answer";
        exit;
    }
    if ($surveyData->saveSurveyResults($_POST)) {
        echo "Umfrage erfolgreich abgeschlossen";
    } else {
        echo "An error occured";
    }
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "You did not pass in an ID.";
    exit;
}
$survey = $surveyData->getSingleSurvey($_GET['id']);
if ($survey === false) {
    echo "Survey not found!";
    exit;
} ?>

<h3>
    <?= $survey->title ?> (ID: <?= $survey->id ?>)
</h3>
<p> 
    <?= $survey->description ?> 
</p>
<form action='vote.php' method='POST'>
    <h4> Questions: </h4>

    <? foreach ($survey->questions as $question) : ?>
        <div>
            <p><?= $question->title ?></p>
            <div>
                <? foreach ($question->answers as $answer) : ?>
                    <div>
                        <input type='radio' name='<?= $question->id ?>' value='<?= $answer->questionAnswerOptionID ?>'>
                        <?= $answer->title ?>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    <? endforeach ?>

    <input type='hidden' name='survey_id' value='<?= $survey->id ?>' />
    <input type='submit' value='Absenden'>
</form>

<?
TemplateFactory::createDefaultFooter();
?>