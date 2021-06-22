<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstoredb";

try {
    //code...
    $connection = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection Failed ".$e->getMessage();
}



?>