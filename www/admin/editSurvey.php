<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Umfrage löschen");

/* Formular wurde ausgefüllt und abgeschickt */
if (isset($_POST['survey_id']) && !empty($_POST['survey_id'])) {
    /* Update den Namen der Kategorie */
    $sql = "UPDATE survey SET title = ?, description_text = ?, start_date = ?, end_date = ?, category_id = ?  WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    /* Es ist möglich mehrere Parameter zu "binden". Die Reihenfolge ist dabei entscheidend.
    "ssssii" beudetet, dass die ersten vier Fragezeichen als String geparsed werden soll und die letzte
    zwei Fragezeichen als Integer. Dadurch können keine schädlich SQL Statements ausgeführt werden */
    $stmt->bind_param("ssssii", $_POST['title'], $_POST['description'], $_POST['start_date'], $_POST['end_date'], $_POST['category_id'], $_POST['survey_id']);
    if(!$stmt->execute() || $stmt->affected_rows === 0){
        echo "<span class='fail-text'>Beim Updaten der Umfrage ist ein Fehler passiert</span>";

    }else{
        echo "<span class='success-text'>Die Umfrage wurde erfolgreich angepasst!</span>";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/manageCategories.php" role="button">Zurück</a>';
    createFooter();
    exit;
}

/* Eine ID muss angegeben sein*/
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Keine ID angegeben!";
}else{
    /* Hole alle Informationen zu der Umfrage, die angezeigt werden soll. Das LIMIT 1
    ist redundant, aber sagt aus, dass nur maximal eine Umfrage geholt werden soll. */
    $sql = "SELECT * FROM survey WHERE id = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    if(!$stmt->execute()){
        echo "<span class='fail-text'>Konnte Umfrage mit ID ".$_GET['id']." nicht finden</span>";
    }else{
        $res = $stmt->get_result();
        if($res->num_rows === 0){
            echo "<span class='fail-text'>Keine Umfrage mit der ID ".$_GET['id']." gefunden</span>";
            exit;
        }
        /* Wir wissen, dass nur maximal ein Eintrag im "result" auftreten wird,
        deswegen reicht es einmal "fetch_assoc()" aufzurufen */ 
        $survey = $res->fetch_assoc();
        ?>
        <form class="survey-form"  style="width:500px; margin:0 auto;" action='editSurvey.php' method='POST'>
            <label for="title">Titel:</label>
            <input id="title" type="text" name='title' value="<?= $survey['title']?>" size="50" />

            <label for="descriotion">Beschreibung:</label>
            <textarea id="description" name="description" rows="4" cols="50"><?=$survey['description_text']?></textarea>

            <label for="start-date">Start:</label>
            <input id="start-date" type="date" name='start_date' value="<?= $survey['start_date']?>"/>

            <label for="end-date">Ende:</label>
            <input id="end-date" type="date" name='end_date' value="<?= $survey['end_date']?>"/>


            <label for="category-id">Kategorie:</label>
            <select id="category-id" name="category_id" style="margin-bottom:40px">
                <?php
                /* Erzeuge eine drop-down Liste aller Kategorien. Hierbei ist die ID der Kategorie
                das ausschlaggebende "value", welches durch die Form übersendet wird */
                $sql = "SELECT * FROM category";
                $res = mysqli_query($mysqli, $sql);
                while($category = mysqli_fetch_assoc($res)){
                    $selectedString = $category['id'] === $survey['category_id'] ? 'selected' : '';
                    echo '<option value="'.$category['id'].' '.$selectedString.'">'.$category['name'].'</option>';
                }
                ?>
            </select>

            <input type='hidden' name='survey_id' value='<?= $survey['id'] ?>' />
            <input type='submit' class="btn btn-primary" value='Speichern'>
        </form>
        <?
    }
}
createFooter();
?>