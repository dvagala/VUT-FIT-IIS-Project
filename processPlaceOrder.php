<?php

include "header.php";

if(empty($_POST["userName"]) || empty($_POST["userSurname"]) || empty($_POST["userTown"]) || empty($_POST["userStreet"]) || empty($_POST["userZIP"]) || empty($_POST["userPhoneNumber"])){
    header("location: checkoutPage.php?checkoutError");      
    return;
}



// $stmt = $pdo->prepare("UPDATE person SET Name = ?, Surname = ?, Town = ?, Street = ?, ZIP = ?, phoneNumber = ?, mail = ?, hashedPassword = ?, state = \"diner\" WHERE personId = ?;");
// $stmt->execute([$_POST["userName"], $_POST["userSurname"], $_POST["userTown"], $_POST["userStreet"], intval($_POST["userZIP"]), $_POST["userPhoneNumber"], $_POST["userEmail"], password_hash($_POST["userPassword"], PASSWORD_DEFAULT), intval($_COOKIE["userId"])]);
// $_SESSION["userId"] = $_COOKIE["userId"];
// setcookie("userId", "", time() - 1);

?>