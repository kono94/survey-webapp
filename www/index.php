<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
require 'SurveyData.php';

$data = new SurveyData();
$data->connect();
$topics = $data->getAllSurveys();
foreach ($topics as $topic) {
   
    echo "<h3>" .$topic['title']. " (ID: " .$topic['id']. ")</h3>";
    echo "<p>";
    echo nl2br($topic['description_text']);
    echo "</p>";
}
echo "kekW"
?>
</body>
</html>