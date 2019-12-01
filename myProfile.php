<?php
include "header.php";


$userData = $pdo->query("SELECT Name, Surname, Town, Street, ZIP, phoneNumber, hashedPassword FROM person WHERE personId = {$_SESSION["userId"]}")->fetch(PDO::FETCH_ASSOC);


?>
<div class="main-page-container">
    <h2>My Profile:</h2><br>
    <form action="#" method="post">
        <table>
            <tr>
                <td><label >Name: </label></td>
                <td><input type="text" value=
                    <?php echo "\"";
                    if(isset($userData["Name"])) {
                        echo $userData["Name"];
                    }
                    echo "\""; ?>
                    name="userName"  placeholder="Name" required></td>
            </tr>
            <tr>
                <td><label >Surname: </label></td>
                <td><input type="text" value=
                    <?php echo "\"";
                    if(isset($userData["Surname"])) {
                        echo $userData["Surname"];
                    }
                    echo "\""; ?>
                    name="userSurname"  placeholder="Surname" required></td>
            </tr>
            <tr>
                <td><label >Town: </label></td>
                <td><input type="text" value=
                    <?php echo "\"";
                    if(isset($userData["Town"])) {
                        echo $userData["Town"];
                    }
                    echo "\""; ?>
                    name="userTown"  placeholder="Town" required></td>
            </tr>
            <tr>
                <td><label >Street: </label</td>
                <td><input type="text" value=
                    <?php echo "\"";
                    if(isset($userData["Street"])) {
                        echo $userData["Street"];
                    }
                    echo "\""; ?>
                    name="userStreet"  placeholder="Street" required></td>
            </tr>
            <tr>
                <td><label>ZIP: </label></td>
                <td><input type="text" pattern="\d{5}" value=
                    <?php echo "\"";
                    if(isset($userData["ZIP"])) {
                        echo $userData["ZIP"];
                    }
                    echo "\""; ?>
                    name="userZIP"  placeholder="ZIP (Eg.: 61200)" required></td>
            </tr>
            <tr>
                <td><label >Phone: </label></td>
                <td><input type="tel" value=
                    <?php echo "\"";
                    if(isset($userData["phoneNumber"])) {
                        echo $userData["phoneNumber"];
                    }
                    echo "\""; ?>
                    name="userPhoneNumber"  placeholder="PhoneNumber" required></td>
            </tr>
            <tr style="text-align: left"><td></td><td style="padding-top: 25px; padding-bottom: 25px"><input  type="submit" name="changeProfile" value="Save" ></td></tr>
            <?php
                if(isset($_POST['changeProfile'])){
                    if($userData['Name']!=$_POST['userName'] || $userData['Surname']!=$_POST['userSurname'] || $userData['Town']!=$_POST['userTown'] || $userData['Street']!=$_POST['userStreet'] || $userData['ZIP']!=$_POST['userZIP'] || $userData['phoneNumber']!=$_POST["userPhoneNumber"]){
                        $stmt = $pdo->prepare("UPDATE person SET Name = ?, Surname = ?, Town = ?, Street = ?, ZIP = ?, phoneNumber = ? WHERE personId = ?;");
                        $stmt->execute(array($_POST["userName"], $_POST["userSurname"], $_POST["userTown"], $_POST["userStreet"], intval($_POST["userZIP"]), $_POST["userPhoneNumber"], $_SESSION['userId']));
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                }
            ?>


<!--PASSWORD CHANGE-->
            <tr><td><h3>Change password:</h3></td></tr>
            <tr><td style="height:15px"></td></tr>
            <tr>
                <td><label >Old password:</label></td>
                <td><input type="password" name="userPassword" placeholder="Old password"></td>
            </tr>
            <tr>
                <td><label >New password:</label></td>
                <td><input type="password" name="newUserPassword" placeholder="New password"></td>
            </tr>
            <tr>
                <td><label >Once again:</label></td>
                <td><input type="password" name="newUserPasswordAgain" placeholder="New password again"></td>
            </tr>

            <tr style="text-align: left"><td></td><td style="padding-top: 25px; padding-bottom: 25px"><input  type="submit" name="changePassword" value="Change" ></td></tr>
            <?php
            if(isset($_POST['changePassword'])){
                if(password_verify($_POST["userPassword"], $userData["hashedPassword"])){
                    if(isset($_POST['newUserPassword'])){
                        if($_POST['newUserPasswordAgain'] == $_POST['newUserPassword']){
                            $stmt = $pdo->prepare("UPDATE person SET hashedPassword = ? WHERE personId= ? ");
                            $stmt->execute(array(password_hash($_POST["newUserPassword"],PASSWORD_DEFAULT),$_SESSION["userId"]));
                            echo"<tr style='text-align: right'><td></td><td>Passwords changed Successfully!</td></tr>";
                        }
                        else{
                            echo"<tr style='text-align: right'><td></td><td>Passwords don't match!</td></tr>";
                        }

                    }
                }
                else{
                    echo"<tr style='text-align: right'><td></td><td>Wrong password!</td></tr>";
                }
            }
            ?>
        </table>
    </form>
</div>
