<?php

include "header.php";


if(isset($_SESSION["userId"])){
    $stmt = $pdo->prepare("SELECT Name, Surname, Town, Street, ZIP, phoneNumber FROM person WHERE personId = ?");
    $stmt->execute([intval($_SESSION["userId"])]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
}


if(isset($_SESSION["userId"])){
    $stmt = $pdo->prepare("INSERT INTO `order` (dinerId, restaurantId, state) VALUES (?, ?, \"notYetPlaced\");");
    $stmt->execute([$_SESSION["userId"], $_GET["restaurantId"]]);
}else if(isset($_COOKIE["userId"])){
    $stmt = $pdo->prepare("INSERT INTO `order` (dinerId, restaurantId, state) VALUES (?, ?, \"notYetPlaced\");");
    $stmt->execute([$_COOKIE["userId"], $_GET["restaurantId"]]);
}else{
    header("location: checkoutPage.php?checkoutError");      
    return;
}

$orderId = $pdo->lastInsertId();

foreach ($_GET["items"] as $itemId) {
    $stmt = $pdo->prepare("INSERT INTO orderHasItem (orderId, itemId) VALUES (?, ?);");
    $stmt->execute([intval($orderId), $itemId]);
}



?>

<div class="main-page-container">
    <h2>Specify the contact details for order</h2>
    <br>
    <form action="processPlaceOrder.php" method="post">
        <input type="hidden" name="orderId" value=<?php echo "\"".$orderId."\"";?>>
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
                <td><textarea name="additionalInfo" cols="25" rows="3"></textarea></td>
            </tr>            
            <tr>
                <td><?php if(isset($_GET["checkoutError"])){echo "Error!";} ?></td>
                <td><button type="submit">Place the order</button></td>
                <td><button id="cancel-order-button" type="button">Cancel order</button></td>
            </tr>
        </table>
    </form> 
</div>

<script>

$("#cancel-order-button").click(function(){
    location.href = "checkoutPage.php?" + parameters;
});

</script>