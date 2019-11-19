<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Most voted");
/* Hole alle Umfragen sortiert nach der Anzahl der Votes absteigend */
$sql = "SELECT survey.*, category.name AS category_name, COUNT(sr.id) AS anzahl FROM survey INNER JOIN category ON survey.category_id = category.id LEFT JOIN survey_result AS sr ON survey.id = sr.survey_id  GROUP BY survey.id ORDER BY count(sr.id) DESC";
$res = mysqli_query($mysqli, $sql);
?>
<div class="button-group">
    <a class="btn btn-primary" href="/admin.php" role="button">Zurück</a>
</div>
<table class="table" style="width:80%; margin:0 auto; cursor:default">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Titel</th>
      <th scope="col">Anzahl Votes</th>
      <th scope="col">Kategorie</th>
      <th scope="col">Auswertung</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
<?php
/* In der Datenbank werden die Daten als "DATE" gespeichert. Mit php kann man diese Format
erzeigen indem man die Funktion date() benutzt, dass Format als ersten Parameter übergibt und als
zweiten den derzeitigen Unix-Timestamp mittels time()-Methode.
Wird benutzt um die Hintergrundsfarbe der Zeilen zu ändern. Rot, wenn die Umfrage bereits zu ende ist,
grün, wenn sie noch aktiv ist */
$currentDate = date('Y-m-d', time());
while ($survey = mysqli_fetch_assoc($res)):?> 
    <tr style="background-color:<?php echo $survey['end_date'] > $currentDate ? 'rgba(0, 255, 0, 0.2)' : 'rgba(255, 0, 0, 0.2)'?>">
        <td><?=$survey['id']?></td>
        <td><?=$survey['title']?></td>
        <td><?=$survey['anzahl']?></td>
        <td scope="row"><?=$survey['title']?></td>
        <td style="text-align:center;"><a href='/survey/result.php?id=<?=$survey['id']?>'><i class="fas fa-clipboard" style="font-size:25px"></i></a></td>
        <td><?php echo $survey['end_date'] > $currentDate ? 'aktiv' : 'inaktiv'?></td>
    </tr>
<?php 
endwhile;
createFooter();
?>