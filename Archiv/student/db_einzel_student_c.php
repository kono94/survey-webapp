<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<?php
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php'; 
   $name = $_POST["name"];
   $matrikelnummer = $_POST["matrikelnummer"];
  
   $sql = "UPDATE student SET name = '$name' WHERE matrikelnummer = $matrikelnummer";
   mysqli_query($con, $sql);

   $num = mysqli_affected_rows($con);
   if($num > 0) echo "Betroffen: $num<br>";
   else         echo "Betroffen: 0<br>";

   mysqli_close($con);
?>
<p>Zur <a href="db_einzel_student_a.php">Auswahl</a></p>
</body></html>
