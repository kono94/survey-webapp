<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Kategorie erstellen");

/* Formular wurde ausgefüllt und abgeschickt, der Name der neuen
Kategorie muss gegeben sein */
if (isset($_POST['category_name']) && !empty($_POST['category_name'])) {
    /* Füge neue Kategorie hinzu  */
    $sql = "INSERT INTO category (name) VALUES (?)";
    $stmt = $mysqli->prepare($sql);
    /* Das "s" steht für String, eine Zeichenkette wie der Name der Kategorie, die das 
    erste Fragezeichen in der Query ersetzen soll */
    $stmt->bind_param("s", $_POST['category_name']);
    if(!$stmt->execute()){
        echo "Fehler beim Erstellen der Kategorie";
    }else{
        echo "Neue Kategorie '".$_POST['category_name']."' wurde erfolgreich erstellt!";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/manageCategories.php" role="button">Zurück</a>';
    createFooter();
    exit;
}
?>
    <form style="text-align: center; margin-top: 80px" action='createCategory.php' method='POST'>
        <input type="text" name='category_name' placeholder="Name der Kategorie" />
        <input type='submit' class="btn btn-primary" value='Erstellen'>
    </form>  
<?php
createFooter();
?>