<?php

$servername = "localhost";
$username = "iisUser";
$password = "iisPassword";
$dbName = "iisDb";

try {
    // If we are on merlin
    if($_SERVER['SERVER_ADDR'] == "147.229.176.14"){
        $pdo = new PDO("mysql:dbname=xvagal00;port=/var/run/mysql/mysql.sock", 'xvagal00', 'acimgi8r');
        // $pdo = new PDO("mysql:dbname=xvagal00;unix_socket=/var/run/mysql/mysql.sock", 'xvagal00', 'acimgi8r');
    }else{
        $pdo = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    }


    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
?>