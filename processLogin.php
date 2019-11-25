<?php
    include "dbConnect.php";

    session_start();

    $stmt = $pdo->prepare("SELECT personId FROM person WHERE mail = ?");
    $stmt->execute([$_POST["userEmail"]]);
    $person = $stmt->fetch(PDO::FETCH_ASSOC);

    if(empty($person)){
        // echo "Not existing user!";
        header("location: index.php?error=wrongEmail");
    }else{
        $_SESSION["userId"] = $person["personId"];
        $_SESSION["userEmail"] = $_POST["userEmail"];
        header("location: index.php");
    }

?>