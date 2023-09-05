<?php
     $host = "localhost";
     $name = "root";
     $password = "";
     $dbname = "Интернет-магазин";

    $connect = mysqli_connect($host, $name, $password, $dbname);

    if (!$connect){
        die('Error connect to database');
    }
?>