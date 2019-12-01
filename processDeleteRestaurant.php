<?php
    session_start();
    include "dbConnect.php";

    if(empty($_GET["restaurantId"])){
        header("location: index.php?popUp=error");
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM restaurant WHERE restaurantId = ?;");
    $stmt->execute(array($_GET["restaurantId"]));

    $stmt = $pdo->prepare("DELETE item, restaurantHasItem FROM item inner join restaurantHasItem on item.itemId = restaurantHasItem.itemId WHERE restaurantHasItem.restaurantId = ?;");
    $stmt->execute(array($_GET["restaurantId"]));

    header("location: index.php?popUp=deleteRestaruantSuccess");


?>