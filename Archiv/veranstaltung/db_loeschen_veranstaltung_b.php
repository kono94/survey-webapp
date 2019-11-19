<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php
if (isset($_POST["auswahl"]))
{
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php';  
    
   $sql = "DELETE FROM veranstaltung WHERE"
     . " veranstaltungsID = " . $_POST["auswahl"];
   mysqli_query($con, $sql);

   $num = mysqli_affected_rows($con);
   if($num > 0) echo "Betroffen: $num<br>";
   else         echo "Betroffen: 0<br>";

   mysqli_close($con);
}
else
   echo "<p>Keine Auswahl getroffen</p>";
?>
<p>Zur <a href="db_loeschen_veranstaltung_a.php">Auswahl</a></p>
</body></html>
