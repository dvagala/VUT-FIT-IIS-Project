<?php

include "header.php";
?>

<link rel="stylesheet" type="text/css" href="styles/signUpPageStyle.css">

<div class="main-page-container">
    <form action="processSignUp.php" method="post">
        <table>
            <tr>
                <td><label type="text" >Name</input></td>
                <td><input type="text" value=
                <?php echo "\"";
                    if(isset($_GET["userName"])) {
                        echo $_GET["userName"];
                    }
                    echo "\""; ?> 
                name="userName" placeholder="Name"></td>
            </tr>
            <tr>
                <td><label type="text">Surname</input></td>
                <td><input type="text" value=
                <?php echo "\"";
                    if(isset($_GET["userSurname"])) {
                        echo $_GET["userSurname"];
                    }
                    echo "\""; ?> 
                name="userSurname" placeholder="Surname"></td>
            </tr>
            <tr>
                <td><label type="text">Town</input></td>
                <td><input type="text" value=
                <?php echo "\"";
                    if(isset($_GET["userTown"])) {
                        echo $_GET["userTown"];
                    }
                    echo "\""; ?> 
                name="userTown" placeholder="Town"></td>
            </tr>
            <tr>
                <td><label type="text">Street</input></td>
                <td><input type="text" value=
                <?php echo "\"";
                    if(isset($_GET["userStreet"])) {
                        echo $_GET["userStreet"];
                    }
                    echo "\""; ?> 
                name="userStreet" placeholder="Street"></td>
            </tr>
            <tr>
                <td><label type="text">ZIP</input></td>
                <td><input type="text" pattern="\d{5}" value=
                <?php echo "\"";
                    if(isset($_GET["userZIP"])) {
                        echo $_GET["userZIP"];
                    }
                    echo "\""; ?> 
                name="userZIP" placeholder="ZIP (Eg.: 61200)"></td>
            </tr>
            <tr>
                <td><label type="text">Phone number</input></td>
                <td><input type="tel" value=
                <?php echo "\"";
                    if(isset($_GET["userPhoneNumber"])) {
                        echo $_GET["userPhoneNumber"];
                    }
                    echo "\""; ?> 
                name="userPhoneNumber" placeholder="PhoneNumber"></td>
            </tr>
            <tr>
                <td><label type="text">Email</input></td>
                <td><input type="email" value=
                <?php echo "\"";
                    if(isset($_GET["userEmail"])) {
                        echo $_GET["userEmail"];
                    }
                    echo "\""; ?> 
                name="userEmail" placeholder="Email"></td>
            </tr>
            <tr>
                <td><label type="text">Password</input></td>
                <td><input type="password" name="userPassword" placeholder="Password"></td>
            </tr>

            <?php if(isset($_GET['signUpError'])){ ?>
                <?php if($_GET['signUpError'] == "emptyField"){ ?>
                    <tr>
                        <td></td>
                        <td><label>Fill in all fields!</label></td>
                    </tr>
                <?php } ?>

                <?php if($_GET['signUpError'] == "takenEmail"){ ?>
                    <tr>
                        <td></td>
                        <td><label>User with this email already exists!</label></td>
                    </tr>
                <?php }
            } ?>

            <tr>
                <td></td>
                <td><button >Sign up</button></td>
            </tr>
        </table>
    </form> 
</div>
