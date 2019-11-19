<?php
require "includes/header.inc.php";
require "includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "includes/dbConnection.inc.php";

createHeader("Adminbereich");
/* Hole alle Umfragen sortiert nach dem Datum an dem sie ablaufen absteigend (DESC) */
$sql = "SELECT survey.*, category.name AS category_name FROM survey INNER JOIN category ON survey.category_id = category.id ORDER BY survey.end_date DESC";
$res = mysqli_query($mysqli, $sql);
?>
<a class="btn btn-primary" href="/admin/createSurvey.php" role="button">Umfrage erstellen</a>
<a class="btn btn-primary" href="/admin/manageCategories.php" role="button">Kategorien verwalten</a>

<table class="table" style="width:80%; margin:0 auto; cursor:default">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Titel</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Kategorie</th>
      <th scope="col">Beginn</th>
      <th scope="col">Ende</th>
      <th scope="col">Bearbeiten</th>
      <th scope="col">Votes zurücksetzen</th>
      <th scope="col">Umfrage löschen</th>
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
    <tr style="background-color:<?php echo $survey['end_date'] > $currentDate ? 'rgba(0, 255, 0, 0.3)' : 'rgba(255, 0, 0, 0.3)'?>">
        <td><?=$survey['id']?></td>
        <td scope="row"><?=$survey['title']?></td>
        <td><?=$survey['description_text']?></td>
        <td><?=$survey['category_name']?></td>
        <td><?=$survey['start_date']?></td>
        <td><?=$survey['end_date']?></td>
        <td><a href='/admin/editSurvey.php?id=<?=$survey['id']?>'><i class="fas fa-pen" style="font-size:25px"></i></a></td>
        <td><a href='/admin/clearVotes.php?id=<?=$survey['id']?>'><i class="fas fa-broom" style="font-size:25px"></i></a></td>
        <td><a href='/admin/deleteSurvey.php?id=<?=$survey['id']?>'><i class="fas fa-trash-alt" style="font-size:25px"></i></a></td>
    </tr>
<?php 
endwhile;
createFooter();
?>