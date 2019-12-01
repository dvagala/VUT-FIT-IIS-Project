<?php

$servername = "localhost";
$username = "iisUser";
$password = "iisPassword";
$dbName = "iisDb";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
?>