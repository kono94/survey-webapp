<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Umfrage löschen");

/* Formular wurde ausgefüllt und abgeschickt */
if (isset($_POST['survey_id']) && !empty($_POST['survey_id'])) {
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
    /* Update Umfrage */
    $sql = "UPDATE survey SET title = ?, description_text = ?, start_date = ?, end_date = ?, category_id = ?, single_select = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    /* Es ist möglich mehrere Parameter zu "binden". Die Reihenfolge ist dabei entscheidend.
    "ssssii" beudetet, dass die ersten vier Fragezeichen als String geparsed werden soll und die letzte
    zwei Fragezeichen als Integer. Dadurch können keine schädlich SQL Statements ausgeführt werden */
    $stmt->bind_param("ssssiii", $_POST['title'], $_POST['description'], $_POST['start_date'], $_POST['end_date'], $_POST['category_id'], $singleSelect, $_POST['survey_id']);
    if(!$stmt->execute() || $stmt->affected_rows === 0){
        echo "<span class='fail-text'>Beim Updaten der Umfrage ist ein Fehler passiert</span>";
    }else{
        echo "<span class='success-text'>Die Umfrage wurde erfolgreich angepasst!</span>";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/editSurvey.php?id='.$_POST['survey_id'].'" role="button">Zurück</a>';
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

            <label for="single-select">Ende:</label>
            <input id="single-select" type="checkbox" name='single_select' <?php
            if($survey['single_select'] == 1){
                echo "checked";
            }?>/>

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
        <h5 style="text-align:center; margin-top:40px">Antwortmöglichkeiten:</h5>
        <div class="button-group">
            <a class="btn btn-primary" href="/admin/createAnswerOption.php?id=<?= $survey['id']?>" role="button">Neue Antwortmöglichkeit hinzufügen</a>
        </div>
        <table class="table" style="width:60%; margin:0 auto; cursor:default">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Titel</th>
                <th scope="col">Beschreibung</th>
                <th scope="col">Bearbeiten</th>
                <th scope="col">Löschen</th>
            </thead>
            <tbody>
        <?php
        /* Hole alle Antwortmöglichkeiten für diese Umfrage und liste sie in einer Tabelle auf.
        Die Kreuztabelle "survey_answer_option" beinhaltet alle Umfragen und deren Verknüpfungen zu Antwortmöglichkeiten.
        Besorgt man sich also alle Zeilen mit der passenden survey_id, dann muss man nurnoch die "answer" Tabelle
        dazu "joinen", um an den jeweiligen titel, id und Beschreibung der Antwort zu kommen*/
         $sql = "SELECT a.id, a.title, a.description_text, sao.id AS sao_id FROM survey_answer_option AS sao LEFT JOIN answer AS a ON sao.answer_id = a.id WHERE sao.survey_id =".$survey['id'];
         $answerResult = mysqli_query($mysqli, $sql);
         while ($answer = mysqli_fetch_assoc($answerResult)):?>
          <tr>
            <td><?=$answer['id']?></td>
            <td scope="row"><?=$answer['title']?></td>
            <td><?=$answer['description_text']?></td>
            <td style="text-align:center;"><a href='/admin/editAnswerOption.php?id=<?=$answer['id']?>&survey_id=<?=$survey['id']?>'><i class="fas fa-pen" style="font-size:25px"></i></a></td>
            <td style="text-align:center;"><a href='/admin/deleteAnswerOption.php?id=<?=$answer['id']?>&survey_id=<?=$survey['id']?>'><i class="fas fa-trash" style="font-size:25px"></i></a></td>
         </tr>
      
      <?php endwhile;?>
            </tbody>
         </table>
      <?php
    }
}
createFooter();
?>