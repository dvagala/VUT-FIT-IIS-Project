<?php
    session_start();
    include "dbConnect.php";

    if(empty($_POST["name"]) || empty($_POST["description"]) || empty($_POST["price"]) || empty($_POST["type"]) || empty($_POST["restaurantId"]) || empty($_FILES['pictureToUpload']['name'])){
        header("location: index.php?popUp=error");
        return;
    }

    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($_FILES['pictureToUpload']['name'],PATHINFO_EXTENSION));
    $target_file = $target_dir.pathinfo($_FILES['pictureToUpload']['name'], PATHINFO_FILENAME).time().".".$imageFileType;

    $check = getimagesize($_FILES["pictureToUpload"]["tmp_name"]);
    if($check === false) {
        header("location: index.php?popUp=error");
        return;
    }

    move_uploaded_file($_FILES["pictureToUpload"]["tmp_name"], $target_file);
    chmod($target_file, 0744);

    $isVegan = false;
    $isGlutenFree = false;

    if(isset($_POST["isVegan"])){
        $isVegan = true;
    }

    if(isset($_POST["isGlutenFree"])){
        $isGlutenFree = true;
    }   

    $stmt = $pdo->prepare("INSERT INTO item (name, description, picture, price, type, isVegan, isGlutenFree) VALUES (?, ?, ?, ?, ?, ?, ?);");
    $stmt->execute(array($_POST["name"], $_POST["description"], $target_file, $_POST["price"], $_POST["type"], intval($isVegan), intval($isGlutenFree)));

    $itemId = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO restaurantHasItem VALUES (?, ?);");
    $stmt->execute(array($_POST["restaurantId"], $itemId));
 
    header("location: index.php?popUp=addItemSuccess");
?>