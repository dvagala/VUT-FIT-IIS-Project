<?php
    include "dbConnect.php";
    session_start();

    if(empty($_GET["name"]) || empty($_GET["town"]) || empty($_GET["street"]) || empty($_GET["zip"]) || empty($_GET["phoneNumber"]) || empty($_GET["openingTime"]) || empty($_GET["closureTime"]) || !isset($_GET["description"])){
        header("location: index.php?popUp=error");
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO restaurant (name, description, town, street, zip, phoneNumber, openingTime, closureTime) VALUES (?, ?, ?, ?, ?, ?, TIME_FORMAT(?, '%H:%i'), TIME_FORMAT(?, '%H:%i'));");
    $stmt->execute([$_GET["name"], $_GET["description"], $_GET["town"], $_GET["street"], intval($_GET["zip"]), $_GET["phoneNumber"], $_GET["openingTime"], $_GET["closureTime"]]);

    header("location: index.php");
    return;
?>