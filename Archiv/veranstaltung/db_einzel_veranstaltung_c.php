<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<?php
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php'; 
   $bezeichnung = $_POST["bezeichnung"];
   $veranstaltungsID = $_POST["veranstaltungsID"];
  
   $sql = "UPDATE veranstaltung SET bezeichnung = '$bezeichnung' WHERE veranstaltungsID = $veranstaltungsID";
   mysqli_query($con, $sql);

   $num = mysqli_affected_rows($con);
   if($num > 0) echo "Betroffen: $num<br>";
   else         echo "Betroffen: 0<br>";

   mysqli_close($con);
?>
<p>Zur <a href="db_einzel_veranstaltung_a.php">Auswahl</a></p>
</body></html>
