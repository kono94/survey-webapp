<?php
require "includes/header.inc.php";
require "includes/footer.inc.php";

/* use $con to access the database */
require "includes/dbConnection.inc.php";

createHeader("Umfrage-Tool");

$sql = "SELECT survey.*, category.name AS category_name FROM survey INNER JOIN category ON survey.category_id = category.id";
$res = mysqli_query($mysqli, $sql);
?>
<table class="table" style="width:80%; margin:0 auto; cursor:default">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Category</th>
      <th scope="col">Vote</th>
    </tr>
  </thead>
  <tbody>
<?php
$i = 0;
foreach ($res as $survey): $i++;?>
    <tr>
        <td><?=$i?></td>
        <td scope="survey$survey"><?=$survey['title']?></td>
        <td><?=$survey['description_text']?></td>
        <td><?=$survey['category_name']?></td>
        <td><a href='/survey/vote.php?id=<?=$survey['id']?>'><i class="fas fa-poll" style="font-size:25px"></i></a></td>
    </tr>
<?php 
endforeach;
createFooter();
?>