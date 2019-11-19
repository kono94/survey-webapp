<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Umfrage löschen");

/* Die ID der Umfrage muss gegeben sein */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Keine ID angegeben!";
}else{
    /* Lösche Umfrage mit der gegebenen ID. Das Ganze als prepared statement, da die ID
    direkt vom Benutzer über die URL anegegen werden kann und somit auch schädlicher SQL-Code.
    Es reicht nur den Eintrag aus der "survey" Tabelle zu löschen, da alle Verbindungen zu jener Umfrage
    über foreign keys geregelt sind mit der Anweisung "ON DELETE cascade". Dies bedeuted, dass
    sich Rows, in der sich dieser foreign key befinden automatisch mitgelöscht werden, wenn der
    referenzierte primary key gelöscht wird. Dadurch erspart man sich weiter DELETE Anweisungen 
    und die Datenbank bleibt konsistenz durch restriktives Design */
    $sql = "DELETE FROM survey WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    /* Das "i" steht für Integer, einer Ganzzahl, wie die ID eine ist */
    $stmt->bind_param("i", $_GET['id']);
    if(!$stmt->execute()){
        echo "Etwas ist beim Löschen schiefgelaufen :(";
    }else{
        echo "Umfrage mit der ID '".$_GET['id']."' wurde erfolgreich gelöscht";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin.php" role="button">Zurück</a>';
}
?>

<?php
createFooter();
?>