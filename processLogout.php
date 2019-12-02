<?php
    session_start();
    session_unset();
    session_destroy();

    $previousUrl = basename($_SERVER['HTTP_REFERER']);

    if($previousUrl == "manageDrivers.php" || $previousUrl == "manageOrders.php" || $previousUrl == "manageUsers.php"){
        $previousUrl = "index.php";
    }

    // Little workaround if site is accessed without index.php in url
    if($previousUrl == "IIS"){
        $previousUrl = "index.php";
    }

    header("location: ".$previousUrl);
?>