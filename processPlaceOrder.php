<?php

include "header.php";

if(empty($_POST["userName"]) || empty($_POST["userSurname"]) || empty($_POST["userTown"]) || empty($_POST["userStreet"]) || empty($_POST["userZIP"]) || empty($_POST["userPhoneNumber"]) || !isset($_POST["additionalInfo"]) || !isset($_SESSION["restaurantId"]) || !isset($_SESSION["items"])){
    header("location: checkoutPage.php?checkoutError");      
    return;
}

if(isset($_SESSION["userId"])){
    $userId = $_SESSION["userId"];
}
else if(isset($_COOKIE["userId"])){
    $userId = $_COOKIE["userId"];
}else{
    header("location: checkoutPage.php?checkoutError");      
    return;    
}


$stmt = $pdo->prepare("UPDATE person SET Name = ?, Surname = ?, Town = ?, Street = ?, ZIP = ?, phoneNumber = ? WHERE personId = ?;");
$stmt->execute([$_POST["userName"], $_POST["userSurname"], $_POST["userTown"], $_POST["userStreet"], $_POST["userZIP"], $_POST["userPhoneNumber"], $userId]);

$stmt = $pdo->prepare("INSERT INTO `order` (dinerId, restaurantId, additionalInfo, state) VALUES (?, ?, ?, \"placedButNotAssignedToDriver\");");
$stmt->execute([$userId, $_SESSION["restaurantId"], $_POST["additionalInfo"]]);

$orderId = $pdo->lastInsertId();

foreach ($_SESSION["items"] as $itemId) {
    $stmt = $pdo->prepare("INSERT INTO orderHasItem (orderId, itemId) VALUES (?, ?);");
    $stmt->execute([intval($orderId), $itemId]);
}

unset($_SESSION["items"]);
unset($_SESSION["restaurantId"]);

echo "Order succesfully placed";


return;

?>