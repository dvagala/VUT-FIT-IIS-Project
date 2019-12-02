<?php

try {
    $pdo = new PDO("mysql:dbname=xvagal00;port=/var/run/mysql/mysql.sock", 'xvagal00', 'acimgi8r');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
?>