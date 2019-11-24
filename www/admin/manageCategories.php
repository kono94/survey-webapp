<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Umfrage-Tool");

/* Hole alle Kategorien und die Anzahl, wie oft jede einzelne einer
Umfrage zugeordnet ist, um sie in einer Tabelle darzustellen. */
$sql = "SELECT category.id, category.name, category.color, count(survey.id) AS anzahl FROM category
       LEFT JOIN survey
       ON category.id = survey.category_id
       GROUP BY category.id";
$res = mysqli_query($mysqli, $sql);
?>
<div class="button-group">
  <a class="btn btn-primary" href="/admin/createCategory.php" role="button">Neue Kategorie erstellen</a>
</div>
<table class="table" style="width:80%; margin:0 auto; cursor:default">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Farbe</th>
      <th scope="col">Anzahl Umfragen</th>
      <th scope="col">Bearbeiten</th>
      <th scope="col">Löschen</th>
    </tr>
  </thead>
  <tbody>
<?php
/* Erstelle eine Tabellenzeile für jede Kategorie mit jeweiligen Link zur Bearbeitung */
while ($category = mysqli_fetch_assoc($res)): ?>
    <tr>
        <td scope="row"><?=$category['id']?></td>
        <td><?=$category['name']?></td>
        <td><input type="color" value="<?=$category['color']?>"></td>
        <td><?=$category['anzahl']?></td>
        <td><a href='/admin/editCategory.php?id=<?=$category['id']?>'><i class="fas fa-pen" style="font-size:25px"></i></a></td>
        <td>
          <?php
          if($category['anzahl'] == 0):?>
            <a href='/admin/deleteCategory.php?id=<?=$category['id']?>'><i class="fas fa-trash" style="font-size:25px"></i></a>
          <?php endif; ?>
        </td>
    </tr>
<?php 
endwhile;
createFooter();
?>