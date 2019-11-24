<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Antwortmöglichkeit löschen");

/* Die ID der Antwort muss gegeben sein */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<span class='fail-text'>Keine ID angegeben!</span>";
}else{
     /* Lösche Antwort */
    $sql = "DELETE FROM answer WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    /* Das "i" steht für Integer, einer Ganzzahl, wie die ID eine ist */
    $stmt->bind_param("i", $_GET['id']);
    if(!$stmt->execute()){
        echo "<span class='fail-text'>Etwas ist beim Löschen der Antwort schiefgelaufen :(</span>";
    }else{
        echo "<span class='success-text'>Antwort mit der ID '".$_GET['id']."' wurde erfolgreich gelöscht</span>";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/editSurvey.php?id='.$_GET['survey_id'].'" role="button">Zurück</a>';
}
createFooter();
?>