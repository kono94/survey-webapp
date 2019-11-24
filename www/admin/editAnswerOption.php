<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Antwortmöglichkeit bearbeiten");

/* Formular wurde ausgefüllt und abgeschickt */
if (isset($_POST['answer_id']) && !empty($_POST['answer_id']) 
    && isset($_POST['new_title']) && !empty($_POST['new_title'])
    && isset($_POST['new_description']) && !empty($_POST['new_description']) ) {
    /* Update den Titel und Beschreibung der Antwortmöglichkeit */
    $sql = "UPDATE answer SET title = ?, description_text = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    /* Es ist möglich mehrere Parameter zu "binden". Die Reihenfolge ist dabei entscheidend.
    "ssi" beudetet, dass die ersten zwei Fragezeichen als String geparsed werden soll und "i", dass
    es als Ganzzahl geparsed werden soll. Dadurch können keine schädlich SQL Statements
    ausgeführt werden */
    $stmt->bind_param("ssi", $_POST['new_title'], $_POST['new_description'], $_POST['answer_id']);
    if(!$stmt->execute() || $stmt->affected_rows === 0){
        echo "<span class='fail-text'>Beim Updaten der Antwortmöglichkeit ist ein Fehler passiert</span>";
    }else{
        echo "<span class='success-text'>Antwortmöglichkeit wurde erfolgreich angepasst!</span>";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/manageCategories.php" role="button">Zurück</a>';
    createFooter();
    exit;
}

/* Eine ID muss angegeben sein*/
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Keine ID angegeben!";
}else{
    /* Hole alle Informationen zu der Antwortmöglichkeit, die angezeigt werden soll. Das LIMIT 1
    ist redundant, aber sagt aus, dass nur maximal ein Eintrag geholt werden soll. */
    $sql = "SELECT * FROM answer WHERE id = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    if(!$stmt->execute()){
        echo "<span class='fail-text'>Konnte Antwortmöglichkeit mit ID ".$_GET['id']." nicht finden (Query-Error)</span>";
    }else{
        $res = $stmt->get_result();
        if($res->num_rows === 0){
            echo "<span class='fail-text'>Keine Antwortmöglichkeit mit der ID ".$_GET['id']." gefunden</span>";
            exit;
        }
        /* Wir wissen, dass nur maximal ein Eintrag im "result" auftreten wird,
        deswegen reicht es einmal "fetch_assoc()" aufzurufen */ 
        $answer = $res->fetch_assoc();
        ?>
        <form style="text-align:center" action='editAnswerOption.php' method='POST'>
            <input type="text" name='new_title' value='<?=$answer['title']?>' />
            <input type="text" name='new_description' value="<?=$answer['description']?>">

            <input type='hidden' name='answer_id' value='<?= $answer['id'] ?>' />
            <input type='submit' class="btn btn-primary" value='Speichern'>
        </form>
        <?php
    }
}
createFooter();
?>