<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Kategorie löschen");

/* Die ID der Umfrage muss gegeben sein */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Keine ID angegeben!";
}else{
    $sql = "SELECT count(survey.id) AS anzahl FROM category
       LEFT JOIN survey
       ON category.id = survey.category_id
       WHERE category.id = ?
       GROUP BY category.id";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows == 0){
        echo "Keine Kategorie mit der ID '".$_GET['id']."' gefunden";
        exit;
    }
    
    /* Die Löschung einer Kategorie ist nur möglich, wenn es keine Umfragen gibt,
    die dieser Kategorie zugeordnet sind */
    if($category['anzahl'] != 0){
        echo "Es existieren Umfragen, die diese Kategorie haben, löschen verboten!";
        exit;
    }

     /* Lösche Kategorie */
    $sql = "DELETE FROM category WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    /* Das "i" steht für Integer, einer Ganzzahl, wie die ID eine ist */
    $stmt->bind_param("i", $_GET['id']);
    if(!$stmt->execute()){
        echo "<span class='fail-text'>Etwas ist beim Löschen der Kategorie schiefgelaufen :(</span>";
    }else{
        echo "<span class='success-text'>Kategorie mit der ID '".$_GET['id']."' wurde erfolgreich gelöscht</span>";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/manageCategories.php" role="button">Zurück</a>';
}
createFooter();
?>