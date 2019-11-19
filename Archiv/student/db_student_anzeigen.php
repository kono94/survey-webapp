<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<?php
 
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php';

   /* SQL-Abfrage ausführen */
   $res = mysqli_query($con, "SELECT * FROM student");

   /* Anzahl Datensätze ermitteln und ausgeben */
   $num = mysqli_num_rows($res);
   if($num > 0) echo "Ergebnis:<br>";
   else         echo "Keine Ergebnisse<br>";

   echo "<table border='1'>";
   
   // Überschrift
   echo "<tr> <td>Mat. Nr.</td> <td>Name</td></tr>";
   
   
   
   /* Datensätze aus Ergebnis ermitteln, */
   /* in Array speichern und ausgeben    */
   
   while ($dsatz = mysqli_fetch_assoc($res))
   {
       echo "<tr>";
       echo "<td>" . $dsatz["matrikelnummer"] . "</td>";
       echo "<td>" . $dsatz["name"] . "</td>";
       echo "</tr>";
   }
   
   /* Verbindung schließen */
   mysqli_close($con);
?>
</body></html>
