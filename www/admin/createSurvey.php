<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Kategorie erstellen");

/* Formular wurde ausgefüllt und abgeschickt, versuche neue Umfrage zu erstellen */
if (isset($_POST['title']) && !empty($_POST['title'])){
    /* Mache erst gar nicht weiter, wenn wichtige Informationen nicht gegeben sind */
    if(!isset($_POST['description']) || empty($_POST['description'])){
        echo "Fehler: Beschreibung nicht ausgefüllt!";
        exit;
    }
    if(!isset($_POST['start_date']) || empty($_POST['start_date'])){
        echo "Fehler: Startdatum nicht gegeben!";
        exit;
    }
    if(!isset($_POST['end_date']) || empty($_POST['end_date'])){
        echo "Fehler: Enddatum nicht gegeben!";
        exit;
    }
    if(!isset($_POST['category_id']) || empty($_POST['category_id'])){
        echo "Fehler: Kategorie nicht gegeben!";
        exit;
    }

    /* Erstelle neue Umfrage */
    $sql = "INSERT INTO survey (title, description_text, start_date, end_date, category_id) VALUES (?,?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    /* Der erste Parameter der Funktion bind_param() sagt aus, welchen Typ das jeweilige Fragezeichen in der Query
    haben soll. Die Reihenfolge ist dabei entscheidend. Übergeben werden 4 Strings und eine ID (Integer) */
    $stmt->bind_param("ssssi", $_POST['title'],$_POST['description'], $_POST['start_date'],$_POST['end_date'],$_POST['category_id']);
    if(!$stmt->execute()){
        echo "Fehler beim Erstellen der Umfrage";
    }else{
        echo "Neue Umfrage wurde erfolgreich erstellt!<br>";
    }
    echo "Fragen und Antworten:<br>";
    
     /* Hole die ID, jener Umfrage, die gerade erstellt worden ist */
    $latestSurveyID = $stmt->insert_id;
    /* Wenn irgendwo im Laufe der Erstellung von Fragen und Antworten ein Fehler passiert
        wird Error auf "true" gesetzt, damit am Ende die zuvor erstellte Umfrage
        wieder gelöscht werden kann, da sie nicht den Erwartungen entspricht */
    $error = false;
    /* Wenn keine Frage bzw. insgesamt keine Antwortmöglichkeit erstellt wird, dann bleibt
    dieser Wert auf "false" und die Umfrage wird wieder gelöscht, da sie unvollständig ist */
    $atLeastOneValidAnswerOption = false;
    /* Laufe durch alle potentielle Fragen und Antwortmöglichkeiten */
    for($i=1; $i < 6; $i++){
        if(isset($_POST['question_titel'.$i]) && !empty($_POST['question_titel'.$i])
            && isset($_POST['answers_'.$i]) && !empty($_POST['answers_'.$i]) ){
                /* Erstelle eine neue Frage bislang immer nur eine "Radio-Button" Frage, 
                deswegen "1" als question_type_id. Prepared Statement, da der User
                den Titel eingegeben hat */
                $sql = "INSERT INTO question (title, question_type_id) VALUES (?,1)";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("s", $_POST['question_titel'.$i]);
                if(!$stmt->execute()){
                    echo 'Fehler beim Erstellen der Frage "'.$_POST['question_titel'.$i].'", lösche Umfrage wieder';
                    $error = true;
                    /* Unterbreche den Prozess des Erstellens*/  
                    break;  
                }else{
                    /* Hole die ID der Frage, die gerade erstellt worden ist */
                    $latestQuestionID =  $stmt->insert_id;
                    echo 'Frage "'.$_POST['question_titel'.$i].'"  mit ID '.$latestQuestionID.' erfolgreich erstellt <br>';
                    /* Verbinde die erstellte Frage mit der Umfrage über die Kreuztabelle "survey_question" */
                    $sql = "INSERT INTO survey_question (survey_id, question_id) VALUES ($latestSurveyID, $latestQuestionID)";
                    $res = mysqli_query($mysqli, $sql);
                    if(!$res){
                        echo "Fehler beim Verbinden von Frage mit Umfrage..<br>";
                        $error = true;
                        /* Unterbreche den Prozess des Erstellens. */  
                         break;
                    }
                    /* Die Antworten werden mittels "textarea" übergeben. Jede Zeile
                    spiegelt hierbei eine Antwortmöglichkeit dar. Die Methode explode() sorgt dafür,
                    dass jede Zeile an eine Stelle in einem Array gespeichert wird. $answers ist somit
                    ein Array aller Antwortmöglichkeit... */
                    $answers = explode(PHP_EOL, $_POST['answers_'.$i]);
                    /* ... über das man iterieren kann */
                    foreach($answers as $answer){
                        /* Erstelle eine neue Antwort. Auch wieder mit prepared statements, da User input */
                        $sql = "INSERT INTO answer (title) VALUES (?)";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("s", $answer);
                        if(!$stmt->execute()){
                            echo 'Fehler beim Erstellen der Antwort "'.$answer.'"';
                            $error = true;
                            /* Unterbreche den Prozess des Erstellens. Die 2 sagt aus, dass aus
                            der äußeren Loop herausgebrochen werden soll. */  
                            break 2;  
                        }else{
                            /* Hole ID der gerade erstellten Antwort */
                            $latestAnswerID = $stmt->insert_id;
                            /* Verbinde die Frage mit der jeweiligen Antwortmöglichkeit über
                            die Kreuztablle "question_answer_option". Prepared Statement ist nicht nötig,
                            da die IDs von mysql direkt ausgegeben worden. */
                            $sql = "INSERT INTO question_answer_option (question_id, answer_id) VALUES ($latestQuestionID, $latestAnswerID)";
                            $res = mysqli_query($mysqli, $sql);
                            if(!$res){
                                echo "Fehler beim Verbinden von Antwort mit Frage, lösche Antwort wieder..<br>";
                                $sql = "DELETE FROM answer WHERE id = $latestAnswerID";
                                $res = mysqli_query($mysqli, $sql);
                                $error = true;
                                /* Unterbreche den Prozess des Erstellens. Die 2 sagt aus, dass aus
                                   der äußeren Loop herausgebrochen werden soll. */  
                               break 2; 
                            }else{ 
                                /* Es wurde mindestens eine Frage mit mindestens einer Antwortmöglichkeit 
                                verbunden.*/
                                $atLeastOneValidAnswerOption = true;
                                echo 'Antwort "'.$answer.'" mit ID "'.$latestAnswerID.'" erfolgreich zur Frage mit ID "'.$latestQuestionID.'" hinzugefügt!<br>';
                            }
                        }
                    }
                }
        }
    }

    /* Es es im Laufe des Erstellens der Fragen und der jeweiligen Antwortmöglichkeiten zu 
    einem Fehler gekommen, so wird die Umfrage wieder aus der Datenbank entfernt, damit diese
    nicht vollmüllt */
    if($error || !$atLeastOneValidAnswerOption){
        echo "Lösche Umfrage wieder, da es zu einem Fehler während der Erstellung gekommen ist<br>";
        $sql = "DELETE FROM survey WHERE id = $latestSurveyID";
        $res = mysqli_query($mysqli, $sql); 
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/manageCategories.php" role="button">Zurück</a>';
    createFooter();
    exit;
}
?>

    <form id="create-survey-form" action='createSurvey.php' method='POST'>
        <label for="title">Titel:</label>
        <input id="title" type="text" name='title' value="" size="50" />

        <label for="descriotion">Beschreibung:</label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea>


        <label for="start-date">Start:</label>
        <input id="start-date" type="date" name='start_date'/>

        <label for="end-date">Ende:</label>
        <input id="end-date" type="date" name='end_date'/>


        <label for="category-id">Kategorie:</label>
        <select id="category-id" name="category_id">
            <?php
            /* Erzeuge eine drop-down Liste aller Kategorien. Hierbei ist die ID der Kategorie
            das ausschlaggebende "value", welches durch die Form übersendet wird */
            $sql = "SELECT * FROM category";
            $res = mysqli_query($mysqli, $sql);
            while($category = mysqli_fetch_assoc($res)){
                echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
            }
            ?>
        </select>

        <h5>Fragen (maximal 5, Leere Felder werden ignoriert. Jede Zeile ist eine Antwortmöglichkeit)</h5>

        <?php
        /* Um kein Javascript zu verwenden, welches dynamisch immer wieder Inputfelder für weitere
        Fragen und Antwortmöglichkeiten erzeugt, erzeugen wir einfach eine feste Anzahl, in diesem Fall
        5. Erster Input ist der Fragetext und zweiter Input sind die Antwortmöglichkeiten. Hierbei
        entspricht jede Zeile der Textarea einer Antwortmöglichkeit */
        for($i=1; $i < 6; $i++){
         echo '<label for="question-titel-'.$i.'">'.$i.'. Fragetext:</label>';
         echo '<textarea id="question-titel-'.$i.'" name="question_titel'.$i.'" rows="3" cols="50"></textarea>';
 
         echo '<label for="answers-'.$i.'">'.$i.'. Antwortmöglichkeiten:</label>';
         echo '<textarea id="answers-'.$i.'" name="answers_'.$i.'" rows="5" cols="50"></textarea>';
        }
        ?>
        <input type='submit' class="btn btn-primary" value='Erstellen'>
    </form>  
<?php
createFooter();
?>