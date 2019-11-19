<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<p>Treffen Sie eine Auswahl:</p>
<form action = "db_loeschen_student_b.php" method = "post">

<?php
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php';  
   $res = mysqli_query($con, "SELECT * FROM student");
   $num = mysqli_num_rows($res);

   // Tabellenbeginn
   echo "<table border='1'>";

   // Überschrift
   echo "<tr> <td>Auswahl</td> <td>Name</td> </tr>";

   while ($dsatz = mysqli_fetch_assoc($res))
   {
      echo "<tr>";
      echo "<td><input type='radio' name='auswahl'";
      echo " value='" . $dsatz["matrikelnummer"] . "'></td>";
      echo "<td>" . $dsatz["name"] . "</td>";
      echo "</tr>";
   }

   // Tabellenende
   echo "</table>";
   
   mysqli_close($con);
?>
<p><input type="submit" value="Datensatz entfernen"></p>
</form>
</body></html>
