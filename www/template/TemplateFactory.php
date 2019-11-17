<?php
class TemplateFactory{

    public static function createDefaultHeader($title){
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title> <?=$title?></title>
            <link href="style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
        <nav class="navtop">
            <div>
                <h1>Voting & Poll System</h1>
                <a href="index.php"><i class="fas fa-poll-h"></i>Polls</a>
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