<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Umfrage-Tool");

/* Hole alle Kategorien um sie in einer Tabelle darzustellen */
$sql = "SELECT * FROM category";
$res = mysqli_query($mysqli, $sql);
?>
<a class="btn btn-primary" href="/admin/createCategory.php" role="button">Neue Kategorie erstellen</a>
<table class="table" style="width:80%; margin:0 auto; cursor:default">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Namen ändern</th>
    </tr>
  </thead>
  <tbody>
<?php
/* Erstelle eine Tabellenzeile für jede Kategorie mit jeweiligen Link zur Bearbeitung */
while ($category = mysqli_fetch_assoc($res)): ?>
    <tr>
        <td scope="row"><?=$category['id']?></td>
        <td><?=$category['name']?></td>
        <td><a href='/admin/editCategory.php?id=<?=$category['id']?>'><i class="fas fa-pen" style="font-size:25px"></i></a></td>
    </tr>
<?php 
endwhile;
createFooter();
?>