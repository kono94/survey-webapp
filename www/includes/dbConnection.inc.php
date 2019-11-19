<?php
    $dbHost = "mysql";
    $dbDatabase = "test";
    $dbUser = "root";
    $dbPassword = "root";

    /* Erstelle eine Verbindung zur Datenbank */
    $mysqli = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbDatabase);
?>