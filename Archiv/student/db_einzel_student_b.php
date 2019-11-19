<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php  include '../homelink.inc.php';?>
<?php
if (isset($_POST["auswahl"]))
{
    /* Verbindung aufnehmen und Datenbank auswählen */
    /* Include der Datei mit den Datenbankzugriffen */
    include '../dbconnect.inc.php'; 
   $sql = "SELECT * FROM student WHERE matrikelnummer = "
      . $_POST["auswahl"];
   $res = mysqli_query($con, $sql);
   $dsatz = mysqli_fetch_assoc($res);

   echo "<p>Bitte neue Inhalte eintragen und speichern:</p>";
   echo "<form action = 'db_einzel_student_c.php' method = 'post'>";

   echo "<p><input name='name' value='"
      . $dsatz["name"] . "'> Nachname</p>";
   
   echo "<p><input name='matrikelnummer' value='"
      . $_POST["auswahl"] . "'> Matrikelnummer</p>";
   
   echo "<p><input type='submit' value='Speichern'>";
   echo " <input type='reset'></p>";
   echo "</form>";
   
   mysqli_close($con);
}
else
   echo "<p>Keine Auswahl getroffen</p>";
?>
</body></html>
