<?php
    session_start();
    session_unset();
    session_destroy();

    $previousUrl = basename($_SERVER['HTTP_REFERER']);

    if($previousUrl == "manageDrivers.php" || $previousUrl == "manageOrders.php" || $previousUrl == "manageUsers.php"){
        $previousUrl = "index.php";
    }

    header("location: ".$previousUrl);
?>