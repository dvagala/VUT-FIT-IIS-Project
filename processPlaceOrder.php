<?php

include "header.php";

if(empty($_POST["userName"]) || empty($_POST["userSurname"]) || empty($_POST["userTown"]) || empty($_POST["userStreet"]) || empty($_POST["userZIP"]) || empty($_POST["userPhoneNumber"])){
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


$stmt = $pdo->prepare("UPDATE `order` SET state = \"placedButNotAssignedToDriver\", additionalInfo = ? WHERE orderId = ?;");
$stmt->execute([$_POST["additionalInfo"], $_POST["orderId"]]);

echo "Order succesfully placed";

return;

?>