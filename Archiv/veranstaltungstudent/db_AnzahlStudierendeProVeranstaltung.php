<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<?php
 
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php';

   /* SQL-Abfrage ausführen */
   $res = mysqli_query($con, "SELECT  veranstaltung.bezeichnung as Veranstaltung, COUNT(studentBesuchtVeranstaltung.student) as AnzStud FROM studentBesuchtVeranstaltung inner join veranstaltung on studentBesuchtVeranstaltung.veranstaltung = veranstaltung.veranstaltungsID
group by studentBesuchtVeranstaltung.veranstaltung");

   /* Anzahl Datensätze ermitteln und ausgeben */
   $num = mysqli_num_rows($res);
   if($num > 0) echo "Ergebnis:<br>";
   else         echo "Keine Ergebnisse<br>";

   // Tabellenbeginn
   echo "<table border='1'>";
   
   // Überschrift
   echo "<tr> <td>Veranstaltung</td> <td>Anzahl eingeschr. Studierende</td>";
   
   
   /* Datensätze aus Ergebnis ermitteln, */
   /* in Array speichern und ausgeben    */
   while ($dsatz = mysqli_fetch_assoc($res))
   {
       echo "<tr>";
       echo "<td>". $dsatz["Veranstaltung"] ."</td>";
       echo "<td>" . $dsatz["AnzStud"] . "</td>";
       echo "</tr>";
   }
   
   // Tabellenende
   echo "</table>";
   
   /* Verbindung schließen */
   mysqli_close($con);
?>
</body></html>
