<?php
    include "dbConnect.php";
    session_start();

    if(empty($_GET["restaurantId"]) || empty($_GET["name"]) || empty($_GET["town"]) || empty($_GET["street"]) || empty($_GET["zip"]) || empty($_GET["phoneNumber"]) || empty($_GET["openingTime"]) || empty($_GET["closureTime"]) || !isset($_GET["description"])){
        header("location: index.php?popUp=error");
        return;
    }

    $stmt = $pdo->prepare("UPDATE restaurant SET name = ?, description = ?, town = ?, street = ?, zip = ?, phoneNumber = ?, openingTime = ?, closureTime = ? WHERE restaurantId = ?;");
    $stmt->execute([$_GET["name"], $_GET["description"], $_GET["town"], $_GET["street"], intval($_GET["zip"]), $_GET["phoneNumber"], strtotime($_GET["openingTime"]), strtotime($_GET["closureTime"]), intval($_GET["restaurantId"])]);


    // $restaurantId = $_GET["restaurantId"];
    // $stmt = $pdo->prepare("SELECT name, description, town, street, zip, phoneNumber, TIME_FORMAT(openingTime, '%H:%i'), TIME_FORMAT(closureTime, '%H:%i') FROM restaurant WHERE restaurantId = ?");
    // $stmt->execute([$restaurantId]);
    // $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

?>