<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php  include '../homelink.inc.php';?>
 


<?php 
/* Verbindung aufnehmen und Datenbank auswählen */
/* Include der Datei mit den Datenbankzugriffen */
include '../dbconnect.inc.php';

/* SQL-Abfrage ausführen */
$res = mysqli_query($con, "select student.matrikelnummer, student.name from student");
$res1 = mysqli_query($con, "select veranstaltung.veranstaltungsID, veranstaltung.bezeichnung from veranstaltung");

?>

</head>

<body>

<form action="db_veranstaltung_student_erzeugen.php" method="post" enctype="multipart/form-data">
<table  border="0">
 
    <tr>
        <td>Studierende einer Veranstaltung zuordnen</td>
        <td>&nbsp;</td>
        <td>
        	<select name="matrikelnummer" id="matrikelnummer">  
        	  	<?php
            	  	while ($dsatz = mysqli_fetch_assoc($res))
            		    echo "<option value='".$dsatz["matrikelnummer"]."'>" . $dsatz["name"]  ."</option>";     
                ?>
    		</select> 
    	</td>
    	<td>besucht: </td>
    	<td>
    		<select name="veranstaltungsID" id="veranstaltungsID">  
        	  	<?php
            	  	while ($dsatz1 = mysqli_fetch_assoc($res1))
            		    echo "<option value='".$dsatz1["veranstaltungsID"]."'>" . $dsatz1["bezeichnung"]  ."</option>";     
                ?>
    		</select>	
    	</td>		
	 </tr>     
  </table>
</p>
  <p>
    <input type="submit" name="gesendet"  value="Senden" />
    <input type="reset" name="reset"  value="Zurücksetzen" />
  </p>

</form>



</body>
</html>