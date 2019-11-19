<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<p>Treffen Sie Ihre Auswahl:</p>
<form action = "db_einzel_veranstaltung_b.php" method = "post">
<?php
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php';  
    $res = mysqli_query($con, "SELECT * FROM veranstaltung");

   // Tabellenbeginn
   echo "<table border='1'>";

   // Überschrift
   echo "<tr> <td>VeranstaltingsID</td> <td>Bezeichnung</td>";
   
   while ($dsatz = mysqli_fetch_assoc($res))
   {
      echo "<tr>";
      echo "<td><input type='radio' name='auswahl'";
      echo " value='" . $dsatz["veranstaltungsID"] . "'></td>";
      echo "<td>" . $dsatz["bezeichnung"] . "</td>";
      echo "</tr>";
   }

   // Tabellenende
   echo "</table>";
   
   mysqli_close($con);
?>
<p><input type="submit" value="Datensatz anzeigen"></p>
</form>
</body></html>
