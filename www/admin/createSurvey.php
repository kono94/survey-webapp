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
   
    /* Dieser boolische Wert wird durch eine checkbox ermittelt.
    Wenn der Haken in der checkbox gesetzt wird, so wird der Key "single_select"
    gepostet mit dem value 'on'. Wenn der Haken nicht gesetzt ist (unchecked), dann wird erst gar nichts
    unter diesem Key übertragen. Man muss also nur schauen, ob der Key "single_select" existiert, dann
    wurde der Haken nämlich gesetzt und die Umfrage soll single select sein. 
    In der Datenbank gibt es kein wirklichen Datentyp "Boolean". Dieser wird mit 0 und 1 dargestellt.
    1 => true, 0 => false */
    $singleSelect = 0;
    if(isset($_POST['single_select']) && !empty($_POST['single_select'])){
        $singleSelect = 1;
    }
   
    /* Erstelle neue Umfrage */
    $sql = "INSERT INTO survey (title, description_text, start_date, end_date, category_id, single_select) VALUES (?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    /* Der erste Parameter der Funktion bind_param() sagt aus, welchen Typ das jeweilige Fragezeichen in der Query
    haben soll. Die Reihenfolge ist dabei entscheidend. Übergeben werden 4 Strings und zwei Integer */
    $stmt->bind_param("ssssii", $_POST['title'],$_POST['description'], $_POST['start_date'],$_POST['end_date'],$_POST['category_id'], $singleSelect);
    if(!$stmt->execute()){
        echo "<span class='fail-text'>Fehler beim Erstellen der Umfrage</span>";
    }else{
        echo "<span class='success-text'>Neue Umfrage wurde erfolgreich erstellt! <br>Nun füge Antworten hinzu.</span><br>";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin.php" role="button">Zurück</a>';

    createFooter();
    exit;
}
?>

    <form class="survey-form" style="width:500px; margin:0 auto;" action='createSurvey.php' method='POST'>
        <label for="title">Titel:</label>
        <input id="title" type="text" name='title' value="" size="50" />

        <label for="descriotion">Beschreibung:</label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea>


        <label for="start-date">Start:</label>
        <input id="start-date" type="date" name='start_date'/>

        <label for="end-date">Ende:</label>
        <input id="end-date" type="date" name='end_date'/>

        <label for="single-select">Single Select:</label>
        <input id="single-select" type="checkbox" name="single_select" checked="checked" />

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
        <input type='submit' class="btn btn-primary" value='Erstellen' style="margin-top:20px"></input>
    </form>  
<?php
createFooter();
?>