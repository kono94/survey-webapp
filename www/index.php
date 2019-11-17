<?php
require 'controller/SurveyData.php';
require 'template/TemplateFactory.php';

$surveyData = new SurveyData();
$surveys = $surveyData->getAllSurveys();

TemplateFactory::createDefaultHeader("kek");

foreach ($surveys as $survey) {
    echo "<h3><a href='vote.php?id=".$survey->id."'>".$survey->title. " (ID: ".$survey->id.")</a></h3>";
    echo "<p>";
    echo nl2br($survey->description);
    echo "</p>";
}
TemplateFactory::createDefaultFooter();
?>