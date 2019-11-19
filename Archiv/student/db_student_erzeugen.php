<!DOCTYPE html><html><head><meta charset="utf-8">
<?php
   if (isset($_POST["gesendet"]))
   {
       /* Verbindung aufnehmen und Datenbank auswählen */
       /* Include der Datei mit den Datenbankzugriffen */
       include '../dbconnect.inc.php';
  
      $name = $_POST["name"];
      $vorname = $_POST["vorname"];
      $sql = "INSERT INTO student(name, vorname) VALUES('$name','$vorname')";
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
    <p>Geben Sie bitte einen Datensatz ein<br>
    und senden Sie das Formular ab:</p>
    <form action = "db_student_erzeugen.php" method = "post">
       <p><input name="name"> Name</p>
       <p><input name="vorname"> Vorname</p>
       <p><input name="gt"> Geburtsdatum (in JJJJ-MM-TT)</p>
     
		<p>
			<input type="submit" name="gesendet">
			<input type="reset">
		</p>
    </form>
    
    <p>Alle <a href="db_student_tabelle.php">anzeigen</a></p>
    </body></html>
