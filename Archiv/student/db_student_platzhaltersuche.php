<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>

<?php
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php';
   $sql = "SELECT student.matrikelnummer, student.name FROM student"
      . " WHERE name LIKE '" . $_POST["anfang"] . "%'";
   $res = mysqli_query($con, $sql);
   $num = mysqli_num_rows($res);
   if($num > 0) echo "Ergebnis:<br>";
   else         echo "Keine Ergebnisse<br>";

   while ($dsatz = mysqli_fetch_assoc($res))
      echo $dsatz["matrikelnummer"] . ", " . $dsatz["name"] . "<br>";

   mysqli_close($con);
?>

</body></html>
