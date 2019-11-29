<?php

include "header.php";

if(isset($_SESSION["userId"])){
    $stmt = $pdo->prepare("SELECT Name, Surname, Town, Street, ZIP, phoneNumber FROM person WHERE personId = ?");
    $stmt->execute([intval($_SESSION["userId"])]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<div class="main-page-container">
    <h2>Specify the contact details for order</h2>
    <br>
    <form action="processPlaceOrder.php" method="post">
        <table>
            <tr>
                <td><label type="text" >Name</input></td>
                <td><input type="text" required value=
                <?php echo "\"";
                    if(isset($userData["Name"])) {
                        echo $userData["Name"];
                    }
                    echo "\""; ?> 
                name="userName"  placeholder="Name" required></td>
            </tr>
            <tr>
                <td><label type="text">Surname</input></td>
                <td><input type="text" value=
                <?php echo "\"";
                    if(isset($userData["Surname"])) {
                        echo $userData["Surname"];
                    }
                    echo "\""; ?> 
                name="userSurname"  placeholder="Surname" required></td>
            </tr>
            <tr>
                <td><label type="text">Town</input></td>
                <td><input type="text" value=
                <?php echo "\"";
                    if(isset($userData["Town"])) {
                        echo $userData["Town"];
                    }
                    echo "\""; ?> 
                name="userTown"  placeholder="Town" required></td>
            </tr>
            <tr>
                <td><label type="text">Street</input></td>
                <td><input type="text" value=
                <?php echo "\"";
                    if(isset($userData["Street"])) {
                        echo $userData["Street"];
                    }
                    echo "\""; ?> 
                name="userStreet"  placeholder="Street" required></td>
            </tr>
            <tr>
                <td><label type="text">ZIP</input></td>
                <td><input type="text" pattern="\d{5}" value=
                <?php echo "\"";
                    if(isset($userData["ZIP"])) {
                        echo $userData["ZIP"];
                    }
                    echo "\""; ?> 
                name="userZIP"  placeholder="ZIP (Eg.: 61200)" required></td>
            </tr>
            <tr>
                <td><label type="text">Phone number</input></td>
                <td><input type="tel" value=
                <?php echo "\"";
                    if(isset($userData["phoneNumber"])) {
                        echo $userData["phoneNumber"];
                    }
                    echo "\""; ?> 
                name="userPhoneNumber"  placeholder="PhoneNumber" required></td>
            </tr>
            <tr>
                <td><label type="text">Order additional info</input></td>
                <td><textarea name="AdditionalInfo" cols="25" rows="3"></textarea></td>
            </tr>            
            <tr>
                <td><?php if(isset($_GET["checkoutError"])){echo "Error!";} ?></td>
                <td><button type="submit">Place the order</button></td>
            </tr>
        </table>
    </form> 
</div>
