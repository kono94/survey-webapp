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
        echo "<div class='alert alert-success' style='width:500px'>".$_GET['msg']."</div>";
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
    $index = 0;
    foreach ($survey->questions as $question) :
        $index++; 
        $totalVotes = $voteMap["questionTotalVotes"][$question->id]?>
        <div class="question">
            <h5><?= $index.". ".$question->title ?> (<?=$totalVotes?> insgesamt)</h5>
            <div>
                <? foreach ($question->answers as $answer) : 
                    $answerVotes = $voteMap["votes"][$answer->questionAnswerOptionID]?>
                    <div style="width:500px">
                        <?= $answer->title ?> (<?=$answerVotes?> votes)
                        <div class="result-bar" style= "width:<?=@round(($answerVotes/$totalVotes)*100)?>%">
                         <?=@round(($answerVotes/$totalVotes)*100)?>%
                </div>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    <? endforeach ?>
<?
TemplateFactory::createDefaultFooter();
?>