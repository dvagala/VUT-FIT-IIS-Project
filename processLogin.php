<?php
    session_start();
    include "dbConnect.php";

    
    $previousUrl = basename($_SERVER['HTTP_REFERER']);

    if($previousUrl == "signUpPage.php"){
        $previousUrl = "index.php";
    }

    $stmt = $pdo->prepare("SELECT personId, hashedPassword FROM person WHERE mail = ?");
    $stmt->execute(array($_POST["userEmail"]));
    $person = $stmt->fetch(PDO::FETCH_ASSOC);

    if(empty($person)){
        if (strpos($previousUrl, 'loginError=wrongEmail') !== false) {
            header("location: ".$previousUrl);
        }else if (strpos($previousUrl, '?') === false) {
            header("location: ".$previousUrl."?loginError=wrongEmail");
        }else{
            header("location: ".$previousUrl."&loginError=wrongEmail");
        }
        return;
    }

    if(!password_verify($_POST["userPassword"], $person["hashedPassword"])){

        if (strpos($previousUrl, 'loginError=wrongPassword') !== false) {
            header("location: ".$previousUrl);
        }else if (strpos($previousUrl, '?') === false) {
            header("location: ".$previousUrl."?loginError=wrongPassword&userEmail={$_POST["userEmail"]}");
        }else{
            header("location: ".$previousUrl."&loginError=wrongPassword&userEmail={$_POST["userEmail"]}");
        }
        return;
    }

    $_SESSION["userId"] = $person["personId"];


    header("location: ".$previousUrl);
?>