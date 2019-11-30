<?php
    include "dbConnect.php";
    session_start();

    
    $previousUrl = basename($_SERVER['HTTP_REFERER']);

    if($previousUrl == "signUpPage.php"){
        $previousUrl = "index.php";
    }

    $stmt = $pdo->prepare("SELECT personId, hashedPassword FROM person WHERE mail = ?");
    $stmt->execute([$_POST["userEmail"]]);
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
    
    if(isset($_COOKIE["userId"])){
        $stmt = $pdo->prepare("DELETE from person WHERE personId = ?;");
        $stmt->execute([$_COOKIE["userId"]]);
        setcookie("userId", "", time() - 1);
    }

    $_SESSION["userId"] = $person["personId"];


    // $previousUrl = str_replace("world","Peter",$previousUrl);

    header("location: ".$previousUrl);
?>