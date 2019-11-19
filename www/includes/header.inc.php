<?php
/* Simple Funktion, die den HTML-Code für den Kopf der Webseite ausgibt. Man
kann den Titel der Webseite übergeben, dieser wird oben im Tab angezeigt.
Bootstrap für besseres Aussehen und Fontawesome für Icons wird mit eingebunden */
function createHeader($title){
?>
<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title> <?=$title?></title>
            <link href="/style/style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
        <nav class="navtop" style="margin-bottom:40px; margin-top:20px">
            <div style="text-align:center">
                <h1>Umfrage-Tool</h1>
                <a href="/index.php"><i class="fas fa-poll-h"></i>Alle Umfragen</a>
                <a href="/admin.php"><i class="fas fa-user"></i>Admin</a>
            </div>
        </nav>
<?php
}
?>