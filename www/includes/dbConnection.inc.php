<?php
/*
    $dbHost = "localhost";
    $dbDatabase = "m5132_44";
    $dbUser = "m5132-44";
    $dbPassword = "hs2CXBK7P";
    */

    $dbHost = "mysql";
    $dbDatabase = "test";
    $dbUser = "root";
    $dbPassword = "root";

    /* Erstelle eine Verbindung zur Datenbank */
    $mysqli = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbDatabase);
?>