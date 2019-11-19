    <!DOCTYPE html>
<html>
    <head>
   		<meta charset="utf-8">
   		<link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
	<body>
    	<div class="grid">
            <?php  include '../homelink.inc.php';?>
            <?php  include '../dbconnect.inc.php';?>
           
            <nav class="nav">
             <?php   
                if (isset($_GET["vid"]))
                    {
                            echo "Testausgabe des übergebenen Parameters: ".$_GET["vid"] ;
                             /* Wenn diese Seite mit einem Parameter vid=...
                             * aufgerufen wird, wird folgender Code ausgeführt.
                             * 
                             * Parameter wird entgegengenommen  */
                            $vid= $_GET["vid"];                  
                          /* SQL-Abfrage ausführen
                           * Wird nur ausgeführt, wenn auf einen Link in der Tabelle geklickt wurde
                           * und dieser Seite über die URL ein Parameter angehängt wurde.*/                       
                            $resStVer = mysqli_query($con, "select student.matrikelnummer,student.name, veranstaltung.bezeichnung from veranstaltung inner join
                                                    ( student inner join studentBesuchtVeranstaltung 
                                                      on student.matrikelnummer = studentBesuchtVeranstaltung.student ) 
                                                      on veranstaltung.veranstaltungsID= studentBesuchtVeranstaltung.veranstaltung
                                                      where veranstaltung.veranstaltungsID=".$vid);
                            /* Anzahl Datensätze ermitteln */
                            $numStVer = mysqli_num_rows($resStVer);
                    } /* Ende der if-Verzweigung
                    
                    
                        /* SQL-Abfrage ausführen für die Auflistung der Veranstaltungen */
                        $resV = mysqli_query($con, "SELECT  veranstaltungsID, bezeichnung from veranstaltung");
                        
                        /* Anzahl Datensätze ermitteln und ausgeben */
                        $numV = mysqli_num_rows($resV);
                        if($numV == 0) // Ist die Anzahl der Veranstaltungen gleich 0, dann...
                        {
                       
                                //... wird ein Hinweis ausgegeben.
                            echo "<br>Es sind keine Veranstaltungen eingetragen.<br>";
                        }
                        else // ... ansonsten werden die...
                        {
                            // Veranstaltungen ausgeben
                                echo "<p>Für die Anzeige der teilnehmenden Studieren klicken Sie auf eine Veranstaltung.</p>";
                                // Tabellenbeginn
                                echo "<table border='1'>";   
                                // Überschrift
                                echo "<tr> <td>VeranstaltungsID</td> <td>Veranstaltung</td>";
                                /* Datensätze aus Ergebnis ermitteln, */
                                /* in Array speichern und ausgeben    */
                                while ($dsatz = mysqli_fetch_assoc($resV))
                                {
                                    echo "<tr>";
                                    echo "<td>". $dsatz["veranstaltungsID"] ."</td>";
                                    /* Link wird generiert. vid ist der Parameter. Ihm wird der Primärschlüssel übergeben. */
                                    echo '<td><a href="db_welcherStudentBesuchtWelcheVeranstaltung.php?vid='.$dsatz["veranstaltungsID"].'">' . $dsatz["bezeichnung"] . '</td>';
                                    echo "</tr>";
                                }            
                                // Tabellenende
                                echo "</table>";
                            // Veranstaltungen ausgeben
                 
                        } // Ende der if-Verzweigung.
                        ?>            
               </nav>
               <content class="content">
                <?php
                  /* Dieser Bereich wird nur ausgeführt, wenn ein Parameter vid übergeben wurde. */                       
               
                 
                 if (isset($_GET["vid"]))
                        {
                            if($numStVer > 0) 
                                {
                                    echo "<p>Ergebnis für:</p>";
                                }
                                else      
                                    {
                                        echo "<p>Es sind keine Studenten eingetragen.</p>"; 
                                    }
                            // Teilnehmende Studenten ausgeben
                                // Tabellenbeginn
                                echo "<table border='1'>";               
                                // Überschrift
                                echo "<tr> <td>MatrikelNummer</td> <td>Name</td>";
                                /* Datensätze aus Ergebnis ermitteln, */
                                /* in Array speichern und ausgeben    */
                                while ($dsatzStVer = mysqli_fetch_assoc($resStVer))
                                {
                                    echo "<tr>";
                                    echo "<td>".$dsatzStVer["matrikelnummer"]."</td>";
                                    echo "<td>".$dsatzStVer["name"] ."</td>";
                                    echo "</tr>";
                                }                        
                                // Tabellenende
                                echo "</table>";
                            // Teilnehmende Studenten ausgeben
                ;
                         }        
               /* Verbindung schließen */
               mysqli_close($con);
            ?>
            </content>
        </div>
    </body>
</html>
