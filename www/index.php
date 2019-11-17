<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
require 'SurveyData.php';

$surveyData = new SurveyData();
$surveys = $surveyData->getAllSurveys();

foreach ($surveys as $survey) {
    echo "<h3>" .$survey->title. " (ID: " .$survey->id. ")</h3>";
    echo "<p>";
    echo nl2br($survey->description);
    echo "</p>";
}
?>
</body>
</html>