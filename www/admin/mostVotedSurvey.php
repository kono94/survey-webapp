<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Most voted");
/* Hole alle Umfragen sortiert nach der Anzahl der Votes absteigend */
$sql = "SELECT survey.*, category.name AS category_name, COUNT(sva.id) AS totalVotes FROM survey INNER JOIN category ON survey.category_id = category.id LEFT JOIN survey_voting AS sv ON survey.id = sv.survey_id  LEFT JOIN survey_voting_answer AS sva ON sva.survey_voting_id = sv.id GROUP BY survey.id ORDER BY count(sva.id) DESC";
$res = mysqli_query($mysqli, $sql);
?>
<div class="button-group">
    <a class="btn btn-primary" href="/admin.php" role="button">Zurück</a>
    <h5 style="margin-top:40px">Beliebteste Umfragen, sortiert nach Gesamtanzahl der Votes</h5>
</div>

<table class="table" style="width:80%; margin:0 auto; cursor:default">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Titel</th>
      <th scope="col">Anzahl Votes</th>
      <th scope="col">Durschnittliche Votes</th>
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
while ($survey = mysqli_fetch_assoc($res)):
    $isActive = $survey['start_date'] < $currentDate && $survey['end_date'] > $currentDate;
    $sql = "SELECT COUNT(*) AS voteSessionCount FROM survey_voting AS sv WHERE sv.survey_id = ".$survey['id'];
    $voteSessionCountResult = mysqli_query($mysqli, $sql);
    $voteSessionCount = mysqli_fetch_assoc($voteSessionCountResult)['voteSessionCount'];
    /* Damit man später nicht durch 0 teilt, wird hier die 0 zu einer 1*/
    if($voteSessionCount == 0){
        $voteSessionCount = 1;
    } ?>
    <tr style="background-color:<?php echo $isActive ? 'rgba(0, 255, 0, 0.2)' : 'rgba(255, 0, 0, 0.2)'?>">
        <td><?=$survey['id']?></td>
        <td><?=$survey['title']?></td>
        <td><?=$survey['totalVotes']?></td>
        <td><?= 
        /* Maximal 3 Nachkommastellen */
        number_format($survey['totalVotes'] / $voteSessionCount, 3)?></td>
        <td scope="row"><?=$survey['category_name']?></td>
        <td style="text-align:center;"><a href='/survey/result.php?id=<?=$survey['id']?>'><i class="fas fa-clipboard" style="font-size:25px"></i></a></td>
        <td><?php echo $isActive ? 'aktiv' : 'inaktiv'?></td>
    </tr>
<?php 
endwhile;
createFooter();
?>