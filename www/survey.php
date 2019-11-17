<?php
require 'SurveyData.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "You did not pass in an ID.";
    exit;
}
$surveyData = new SurveyData();
$survey = $surveyData->getSingleSurvey($_GET['id']);
if ($survey === false) {
    echo "Survey not found!";
    exit;
}

echo "<h3>" .$survey->title. " (ID: " .$survey->id. ")</h3>";
echo "<p>";
echo nl2br($survey->description);
echo "</p>";
echo "<form action='/action_page.php'>";
echo "<h4> Questions: </h4>";
foreach ($survey->questions as $question) {
   echo "<div>";
   echo "<p>".$question->title."</p>";
   foreach($question->answers as $answer){
       echo "<input type='radio' name='".$question->id." value='".$answer->id."'>".$answer->title."<br>";
   }
   echo "</div>";
}
echo "<input type='submit' value='Absenden'>
      </form>";

?>