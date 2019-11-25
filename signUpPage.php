<?php

include "header.php";
include "dbConnect.php"; ?>

<link rel="stylesheet" type="text/css" href="styles/signUpPageStyle.css">


<div class="main-page-container">
    <form class="signUp-form" action="processSignUp.php" method="post">
        <div class="display-block signUpRow">
            <label type="text">Name</input>
            <input type="text" name="userName" placeholder="Name">
        </div>
        <div class="display-block signUpRow">
            <label type="text">Surname</input>
            <input type="text" name="userSurname" placeholder="Surname">
        </div>
        <div class="display-block signUpRow">
            <label type="text">Town</input>
            <input type="text" name="userTown" placeholder="Town">
        </div>
        <div class="display-block signUpRow">
            <label type="text">Address</input>
            <input type="text" name="userAddress" placeholder="Address">
        </div>
        <div class="display-block signUpRow">
            <label type="text">ZIP</input>
            <input type="text" name="userZIP" placeholder="ZIP">
        </div>
        <div class="display-block signUpRow">
            <label type="text">Email</input>
            <input type="text" name="userEmail" placeholder="Email">
        </div>
        <div class="display-block signUpRow">
            <label type="text">Phone number</input>
            <input type="number" name="userPhoneNumber" placeholder="PhoneNumber">
        </div>
        <div class="display-block signUpRow">
            <label type="text">Password</input>
            <input type="password" name="userPassword" placeholder="Password">
        </div>

        <button >Sign up</button>
    </form>
</div>