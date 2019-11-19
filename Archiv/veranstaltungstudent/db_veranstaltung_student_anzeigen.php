<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<?php
 
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php';

   /* SQL-Abfrage ausführen */
   $res = mysqli_query($con, "select student.name, veranstaltung.bezeichnung from veranstaltung inner join 
( student inner join studentBesuchtVeranstaltung 
on student.matrikelnummer = studentBesuchtVeranstaltung.student ) 
on veranstaltung.veranstaltungsID= studentBesuchtVeranstaltung.veranstaltung");

   /* Anzahl Datensätze ermitteln und ausgeben */
   $num = mysqli_num_rows($res);
   if($num > 0) echo "Ergebnis:<br>";
   else         echo "Keine Ergebnisse<br>";

   // Tabellenbeginn
   echo "<table border='1'>";
   
   // Überschrift
   echo "<tr> <td>Name</td> <td>Veranstaltung</td>";
   
   
   /* Datensätze aus Ergebnis ermitteln, */
   /* in Array speichern und ausgeben    */
   while ($dsatz = mysqli_fetch_assoc($res))
   {
       echo "<tr>";
       echo "<td>". $dsatz["name"] ."</td>";
       echo "<td>" . $dsatz["bezeichnung"] . "</td>";
       echo "</tr>";
   }
   
   // Tabellenende
   echo "</table>";
   
   /* Verbindung schließen */
   mysqli_close($con);
?>
</body></html>
