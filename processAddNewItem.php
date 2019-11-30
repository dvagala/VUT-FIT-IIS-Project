<?php
    include "dbConnect.php";
    session_start();

    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($_FILES['pictureToUpload']['name'],PATHINFO_EXTENSION));
    $target_file = $target_dir.pathinfo($_FILES['pictureToUpload']['name'], PATHINFO_FILENAME).time().".".$imageFileType;

    $check = getimagesize($_FILES["pictureToUpload"]["tmp_name"]);
    if($check === false) {
        header("location: index.php?popUp=error");
        return;
    }

    move_uploaded_file($_FILES["pictureToUpload"]["tmp_name"], $target_file);

    // CREATE TABLE item (
    //     itemId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    //     name TINYTEXT,
    //     description TEXT,
    //     picture TEXT,
    //     price DECIMAL(6,2),
    //     type ENUM("dailyMenu", "meal","sidedish", "sauce", "beverage"),
    //     isInMenu BOOLEAN DEFAULT FALSE,
    //     isVegan BOOLEAN DEFAULT FALSE,
    //     isGlutenFree BOOLEAN DEFAULT FALSE
    //   );

    $stmt = $pdo->prepare("INSERT INTO item (name, description, picture, price, type, isVegan, isGlutenFree) VALUES (?, ?, ?, ?, ?, ?, ?);");
    $stmt->execute([$_GET["restaurantId"]]);

?>