<!DOCTYPE html><html><head><meta charset="utf-8">
<?php
   if (isset($_POST["gesendet"]))
   {
       /* Verbindung aufnehmen und Datenbank auswählen */
       /* Include der Datei mit den Datenbankzugriffen */
       include '../dbconnect.inc.php';
  
       $veranstaltungsID = $_POST["veranstaltungsID"];
       $matrikelnummer = $_POST["matrikelnummer"];
      
      $sql = "INSERT INTO studentBesuchtVeranstaltung(student, veranstaltung) VALUES('$matrikelnummer','$veranstaltungsID')";
      mysqli_query($con, $sql);

      $num = mysqli_affected_rows($con);
      if ($num>0)
      {
         echo "<p><font color='#00aa00'>";
         echo "Ein Datensatz hinzugefügt";
         echo "</font></p>";
      }
      else
      {
         echo "<p><font color='#ff0000'>";
         echo "Es ist ein Fehler aufgetreten, ";
         echo "es ist kein Datensatz hinzugekommen";
         echo "</font></p>";
      }

      mysqli_close($con);
   }
?>
</head>
<body>
<?php  include '../homelink.inc.php';?>
</body></html>
