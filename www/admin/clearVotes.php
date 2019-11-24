<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Umfrageergebnisse löschen");

/* Die ID der Umfrage muss gegeben sein */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Keine ID angegeben!";
}else{
    /* Lösche alle Eintrage aus der Kreuztabelle, die die abgegebenen Stimmen
    speichert. Prepared statement, da der User die ID einfach über die ID angegeben kann */
    $sql = "DELETE FROM survey_voting WHERE survey_id = ?";
    $stmt = $mysqli->prepare($sql);
    /* Das "i" steht für Integer, also einem numerisch Wert wie der survey_id. Das erste
    Fragezeichen in der Query wird also als Integer geparsed */
    $stmt->bind_param("i", $_GET['id']);
    if(!$stmt->execute()){
        echo "<span class='fail-text'>Etwas ist beim Löschen schiefgelaufen :(</span>";
        # echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }else{
        echo "<span class='success-text'>Alle Votes für die Umfrage mit der ID '".$_GET['id']."' wurden erfolgreich gelöscht</span>";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin.php" role="button">Zurück</a>';
}
createFooter();
?>