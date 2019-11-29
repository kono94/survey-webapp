<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Kategorie bearbeiten");

/* Formular wurde ausgefüllt und abgeschickt */
if (isset($_POST['category_id']) && !empty($_POST['category_id']) 
    && isset($_POST['new_name']) && !empty($_POST['new_name'])
    && isset($_POST['new_color']) && !empty($_POST['new_color']) ) {
    /* Update den Namen der Kategorie */
    $sql = "UPDATE category SET name = ?, color = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    /* Es ist möglich mehrere Parameter zu "binden". Die Reihenfolge ist dabei entscheidend.
    "ssi" beudetet, dass die ersten zwei Fragezeichen als String geparsed werden soll und "i", dass
    es als Ganzzahl geparsed werden soll. Dadurch können keine schädlich SQL Statements
    ausgeführt werden */
    $stmt->bind_param("ssi", $_POST['new_name'], $_POST['new_color'], $_POST['category_id']);
     /* Beim Updaten muss die passende Zeile bearbeitet worden sein, sonst
    waren die neuen Werte genauso wie die alten Werte oder die ID wurde nicht gefunden */
    if(!$stmt->execute() || $stmt->affected_rows === 0){
        echo "<span class='fail-text'>Beim Updaten der Kategorie ist ein Fehler passiert</span>";
    }else{
        echo "<span class='success-text'>Kategorie wurde erfolgreich angepasst!</span>";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/manageCategories.php" role="button">Zurück</a>';
    createFooter();
    exit;
}

/* Eine ID muss angegeben sein*/
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Keine ID angegeben!";
}else{
    /* Hole alle Informationen zu der Kategorie, die angezeigt werden soll. Das LIMIT 1
    ist redundant, aber sagt aus, dass nur maximal ein Eintrag geholt werden soll. */
    $sql = "SELECT * FROM category WHERE id = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    if(!$stmt->execute()){
        echo "<span class='fail-text'>Konnte Kategorie mit ID ".$_GET['id']." nicht finden</span>";
    }else{
        $res = $stmt->get_result();
        if($res->num_rows === 0){
            echo "<span class='fail-text'>Keine Kategorie mit der ID ".$_GET['id']." gefunden</span>";
            exit;
        }
        /* Wir wissen, dass nur maximal ein Eintrag im "result" auftreten wird,
        deswegen reicht es einmal "fetch_assoc()" aufzurufen */ 
        $category = $res->fetch_assoc();
        ?>
        <form class='create-form' action='editCategory.php' method='POST'>
            <label for="new-name">Name:</label>
            <input type="text" id='new-name' name='new_name' value='<?=$category['name']?>' />

            <label for="new-color">Name:</label>
            <input type="color" id='new-color' name='new_color' value="<?=$category['color']?>">

            <input type='hidden' name='category_id' value='<?= $category['id'] ?>' />
            <input type='submit' class="btn btn-primary" value='Absenden'>
        </form>
        <?php
    }
}
createFooter();
?>