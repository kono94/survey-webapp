<?php
require 'controller/SurveyData.php';
require 'template/TemplateFactory.php';

$surveyData = new SurveyData();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "You did not pass in an ID.";
    exit;
}

$survey = $surveyData->getSingleSurvey($_GET['id']);
if ($survey === false) {
    echo "Survey not found!";
    exit;
} 
TemplateFactory::createDefaultHeader("Result");

    if(isset($_GET['msg'])){
        echo "<h2 style='color: green'>".$_GET['msg']."</h2>";
    }
    ?>
<h3>
    <?= $survey->title ?> (ID: <?= $survey->id ?>)
</h3>
<p> 
    <?= $survey->description ?> 
</p>
    <h4> Results: </h4>

    <?
    $voteMap = $surveyData->getAnswerVotes($survey);
    foreach ($survey->questions as $question) : 
        $totalVotes = $voteMap["questionTotalVotes"][$question->id]?>
        <div>
            <p><?= $question->title ?> Total number of votes: <?=$totalVotes?></p>
            <div>
                <? foreach ($question->answers as $answer) : 
                    $answerVotes = $voteMap["votes"][$answer->questionAnswerOptionID]?>
                    <div style="width:500px">
                        <?= $answer->title ?> (<?=$answerVotes?> votes)
                        <div class="result-bar" style= "width:<?=@round(($answerVotes/$totalVotes)*100)?>%">
                         <?=@round(($answerVotes/$totalVotes)*100)?>%
                    </div>
                <? endforeach ?>
            </div>
        </div>
    <? endforeach ?>
<?
TemplateFactory::createDefaultFooter();
?>