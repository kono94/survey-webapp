<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<?php
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php';
   $res = mysqli_query($con, "SELECT * FROM veranstaltung");

   // Tabellenbeginn
   echo "<table border='1'>";

   // Überschrift
   echo "<tr> <td>VeranstaltungsID.</td> <td>Bezeichnung</td></tr>";

   while ($dsatz = mysqli_fetch_assoc($res))
   {
      echo "<tr>";
      echo "<td>" . $dsatz["veranstaltungsID"] . "</td>";
      echo "<td>" . $dsatz["bezeichnung"] . "</td>";
      echo "</tr>";

   }

   // Tabellenende
   echo "</table>";

   mysqli_close($con);
?>
</body></html>
