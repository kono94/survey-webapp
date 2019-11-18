<?php
class TemplateFactory{

    public static function createDefaultHeader($title){
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title> <?=$title?></title>
            <link href="style/style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
        <nav class="navtop">
            <div>
                <h1>Umfrage-Tool</h1>
                <a href="index.php"><i class="fas fa-poll-h"></i>Alle Umfragen</a>
            </div>
        </nav>
     <?php
    }


    public static function createDefaultFooter(){
        ?>
        </body>
        </html>
        <?php
    }
}
?>