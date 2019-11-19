<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<?php
 
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php';

   /* SQL-Abfrage ausführen */
   $res = mysqli_query($con, "SELECT * FROM veranstaltung");

   /* Anzahl Datensätze ermitteln und ausgeben */
   $num = mysqli_num_rows($res);
   if($num > 0) echo "Ergebnis:<br>";
   else         echo "Keine Ergebnisse<br>";

   /* Datensätze aus Ergebnis ermitteln, */
   /* in Array speichern und ausgeben    */
   while ($dsatz = mysqli_fetch_assoc($res))
   {
      echo $dsatz["veranstaltungsID"] . ", "
         . $dsatz["bezeichnung"] .  "<br>";
   }
   
   /* Verbindung schließen */
   mysqli_close($con);
?>
</body></html>
