<?php

    $userEmail = $_POST["userEmail"];
    // echo $userEmail;

    session_start();
    $_SESSION["userId"] = $_POST["userEmail"];

    header("location: index.php");

?>