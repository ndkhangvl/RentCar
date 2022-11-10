<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rentCar";
    $conn = new mysqli($servername, $username,$password, $dbname)
        or die ("Connection failed " . $conn->connect_error);
?>