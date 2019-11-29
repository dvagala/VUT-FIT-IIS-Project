<?php
    include "dbConnect.php";

    session_start();

    $stmt = $pdo->prepare("SELECT personId, hashedPassword FROM person WHERE mail = ?");
    $stmt->execute([$_POST["userEmail"]]);
    $person = $stmt->fetch(PDO::FETCH_ASSOC);

    if(empty($person)){
        header("location: index.php?loginError=wrongEmail");
        return;
    }

    if(!password_verify($_POST["userPassword"], $person["hashedPassword"])){
        header("location: index.php?loginError=wrongPassword&userEmail={$_POST["userEmail"]}");
        return;        
    }
    
    if(isset($_COOKIE["userId"])){
        $stmt = $pdo->prepare("DELETE from person WHERE personId = ?;");
        $stmt->execute([$_COOKIE["userId"]]);
        setcookie("userId", "", time() - 1);
    }

    $_SESSION["userId"] = $person["personId"];
    $_SESSION["userEmail"] = $_POST["userEmail"];
    header("location: index.php");

?>