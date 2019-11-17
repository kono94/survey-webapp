<?php
require 'controller/SurveyData.php';
require 'template/TemplateFactory.php';

TemplateFactory::createDefaultHeader("kek");

$surveyData = new SurveyData();
$surveys = $surveyData->getAllSurveys();

foreach ($surveys as $survey) {
    echo "<h3><a href='vote.php?id=".$survey->id."'>".$survey->title. " (ID: ".$survey->id.")</a></h3>";
    echo "<p>";
    echo nl2br($survey->description);
    echo "</p>";
}
TemplateFactory::createDefaultFooter();
?>