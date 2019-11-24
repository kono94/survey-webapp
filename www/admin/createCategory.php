<?php
require "../includes/header.inc.php";
require "../includes/footer.inc.php";

/* Ab hier kann man $mysqli benutzen um mit der Datenbank zu interagieren */
require "../includes/dbConnection.inc.php";

createHeader("Kategorie erstellen");

/* Formular wurde ausgefüllt und abgeschickt, der Name der neuen
Kategorie muss gegeben sein */
if (isset($_POST['category_name']) && !empty($_POST['category_name'])
    && isset($_POST['category_color']) && !empty($_POST['category_color'])) {
    /* Füge neue Kategorie hinzu  */
    $sql = "INSERT INTO category (name, color) VALUES (?,?)";
    $stmt = $mysqli->prepare($sql);
    /* Das "ss" steht für zwei Strings, zwei Zeichenkettem wie der Name der Kategorie und die Farbe (in Hexcode),
     die die zwei Fragezeichen in der Query ersetzen sollen */
    $stmt->bind_param("ss", $_POST['category_name'], $_POST['category_color']);
    if(!$stmt->execute()){
        echo "<span class='fail-text'>Fehler beim Erstellen der Kategorie</span>";
    }else{
        echo "<span class='success-text'>Neue Kategorie '".$_POST['category_name']."' wurde erfolgreich erstellt!</span>";
    }
    echo '<a class="btn btn-primary" style="margin-left:40px" href="/admin/manageCategories.php" role="button">Zurück</a>';
    createFooter();
    exit;
}
?>
    <form class='create-form' style="margin-top: 80px" action='createCategory.php' method='POST'>
        <label for="category-name">Name:</label>
        <input type="text" id='category-name' name='category_name' placeholder="Name der Kategorie" />

        <label for="category-color">Farbe:</label>
        <input type="color" id='category-color' name='category_color' value="<?=$category['color']?>">
        <input type='submit' class="btn btn-primary" value='Erstellen' style="margin-top:40px">
    </form>  
<?php
createFooter();
?>