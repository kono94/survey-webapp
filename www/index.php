<?php
require "includes/header.inc.php";
require "includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "includes/dbConnection.inc.php";

createHeader("Umfrage-Tool");

/* Besorge alle Umfragen, die aktiv sind, d.h. das jetzige Datum liegt zwischen
Startdatum und Enddatum der Umfrage */ 
$sql = "SELECT survey.*, category.name AS category_name, category.color AS category_color FROM survey INNER JOIN category ON survey.category_id = category.id WHERE survey.start_date < NOW() AND survey.end_date > NOW()";
$res = mysqli_query($mysqli, $sql);
?>
<table class="table" style="width:80%; margin:0 auto; cursor:default">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Titel</th>
      <th scope="col">Beschreibung</th>
      <th scope="col">Kategorie</th>
      <th scope="col">Vote</th>
    </tr>
  </thead>
  <tbody>
<?php
while ($survey = mysqli_fetch_assoc($res)):?>
    <tr>
        <td><?=$survey['id']?></td>
        <td scope="row"><?=$survey['title']?></td>
        <td><?=$survey['description_text']?></td>
        <td style="color:<?=$survey['category_color']?>; text-decoration:underline;font-weight:700;"><?=$survey['category_name']?></td>
        <td><a href='/survey/vote.php?id=<?=$survey['id']?>'><i class="fas fa-poll" style="font-size:25px"></i></a></td>
    </tr>
<?php 
endwhile;
createFooter();
?>