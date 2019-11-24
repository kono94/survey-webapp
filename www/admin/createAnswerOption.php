<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Antwortmöglichkeit erstellen");

/* Formular wurde ausgefüllt und abgeschickt, der Title der neuen Antwort muss gegeben sein */
if (isset($_POST['survey_id']) && !empty($_POST['survey_id'])){
    if(!isset($_POST['answer_description'])){
        echo "<span class='fail-text'>Fehler: Beschreibung nicht ausgefüllt!</span>";
        exit;
    }

    if(!isset($_POST['answer_title']) || empty($_POST['answer_title'])){
        echo "<span class='fail-text'>Fehler: Titel nicht ausgefüllt!</span>";
        exit;
    }

    /* Füge neue Antwort hinzu  */
    $sql = "INSERT INTO answer (title, description_text) VALUES (?,?)";
    $stmt = $mysqli->prepare($sql);
    /* Das "ss" steht für zwei Strings, eine Zeichenkette wie der Titel der Antwort, die das 
    erste Fragezeichen in der Query ersetzen soll */
    $stmt->bind_param("ss", $_POST['answer_title'], $_POST['answer_description']);
    if(!$stmt->execute()){
        echo "<span class='fail-text'>Fehler beim Erstellen der Antwort</span>";
        exit;
    }else{
        /* Verlinke zuvor erstellten Antwortmöglichkeit mit einer Umfrage, die angegeben worden ist */
        $insertedAnswerID = $stmt->insert_id;
        $sql = "INSERT INTO survey_answer_option (survey_id, answer_id) VALUES (?,?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $_POST['survey_id'], $insertedAnswerID);
        if(!$stmt->execute()){
            /* Verlinkung ist fehlgeschlagen, lösche Antwort wieder, damit die Datenbank nicht vollmüllt */
            $sql = "DELETE FROM answer WHERE id =".$insertedAnswerID;
            $res = mysqli_query($mysqli, $sql);
        }else{
            echo "<span class='success-text'>Neue Antwortmöglichkeit '".$_POST['answer_titel']."' wurde erfolgreich erstellt und mit Umfrage ".$_POST['survey_id']." verknüpft!</span>";
        }
    }

    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/editSurvey.php?id='.$_POST['survey_id'].'" role="button">Zurück</a>';
    createFooter();
    exit;
}
?>
    <form class='create-form' action='createAnswerOption.php' method='POST'>
       
        <label for="answer-title">Titel:</label>
        <input type="text" id='answer-title' name='answer_title' size="40" />

        <label for="answer-description">Beschreibung:</label>
        <textarea id='answer-description' name="answer_description" rows="3" cols="40"></textarea>
    
        <label for="survey-id">Umfrage:</label>
        <select id="survey-id" name="survey_id">
            <?php
            /* Erzeuge eine drop-down Liste aller Kategorien. Hierbei ist die ID der Kategorie
            das ausschlaggebende "value", welches durch die Form übersendet wird */
            $sql = "SELECT id, title FROM survey";
            $res = mysqli_query($mysqli, $sql);
            while($survey = mysqli_fetch_assoc($res)){
                $selected = "";
                /* Wenn eine Umfragen-ID gegeben ist, dann schauen, ob diese Umfrage in
                der Liste enthalten ist. Wenn ja, dann wird diese als default ausgewählt. */
                if(isset($_GET['id']) && !empty($_GET['id']) && $survey['id'] == $_GET['id']){
                    $selected = "selected";
                }
                echo '<option value="'.$survey['id'].'" '.$selected.'>'.$survey['title'].'</option>';
            }
            ?>
        </select>
        <input type='submit' class="btn btn-primary" value='Erstellen' style="margin-top:30px">
    </form>  
<?php
createFooter();
?>