<?php

//for connection to database

$servername = "localhost"; //for DB running on local machine
$username = "YOURUSERNAME";
$password = "YOURPASSWORD";

try {
    $conn = new PDO("mysql:host=$servername;dbname=carshop", $username, $password);
    // set the PDO error mode to exception
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " .$e->getMessage();
}

?>