<?php
    include "dbConnect.php";

    session_start();

    if(empty($_POST["userName"]) || empty($_POST["userSurname"]) || empty($_POST["userTown"]) || empty($_POST["userStreet"]) || empty($_POST["userZIP"]) || empty($_POST["userPhoneNumber"]) || empty($_POST["userEmail"]) || empty($_POST["userPassword"])){
        header("location: signUpPage.php?signUpError=emptyField&userName={$_POST["userName"]}&userSurname={$_POST["userSurname"]}&userTown={$_POST["userTown"]}&userStreet={$_POST["userStreet"]}&userZIP={$_POST["userZIP"]}&userPhoneNumber={$_POST["userPhoneNumber"]}&userEmail={$_POST["userEmail"]}");      
        return;
    }

    // If User with this email already exists
    $stmt = $pdo->prepare("SELECT personId FROM person WHERE mail = ?");
    $stmt->execute([$_POST["userEmail"]]);
    $person = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($person)){
        header("location: signUpPage.php?signUpError=takenEmail&userName={$_POST["userName"]}&userSurname={$_POST["userSurname"]}&userTown={$_POST["userTown"]}&userStreet={$_POST["userStreet"]}&userZIP={$_POST["userZIP"]}&userPhoneNumber={$_POST["userPhoneNumber"]}&userEmail=");
        return;
    }
    
    // Add new user to Db
    if(isset($_COOKIE["userId"])){
        $stmt = $pdo->prepare("UPDATE person SET Name = ?, Surname = ?, Town = ?, Street = ?, ZIP = ?, phoneNumber = ?, mail = ?, hashedPassword = ?, state = \"diner\" WHERE personId = ?;");
        $stmt->execute([$_POST["userName"], $_POST["userSurname"], $_POST["userTown"], $_POST["userStreet"], intval($_POST["userZIP"]), $_POST["userPhoneNumber"], $_POST["userEmail"], password_hash($_POST["userPassword"], PASSWORD_DEFAULT), intval($_COOKIE["userId"])]);
        $_SESSION["userId"] = $_COOKIE["userId"];
        setcookie("userId", "", time() - 1);
    }else{
        $stmt = $pdo->prepare("INSERT INTO person (Name, Surname, Town, Street, ZIP, phoneNumber, mail, hashedPassword, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, \"diner\");");
        $stmt->execute([$_POST["userName"], $_POST["userSurname"], $_POST["userTown"], $_POST["userStreet"], $_POST["userZIP"], $_POST["userPhoneNumber"], $_POST["userEmail"], password_hash($_POST["userPassword"], PASSWORD_DEFAULT)]);
        $_SESSION["userId"] = $pdo->lastInsertId();
    }

    header("location: index.php?popUp=signUpSuccess");
?>