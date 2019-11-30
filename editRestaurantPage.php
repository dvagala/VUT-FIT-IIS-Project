<?php

include "header.php";
include "dbConnect.php";

$restaurantId = $_GET["restaurantId"];
$stmt = $pdo->prepare("SELECT name, description, town, street, zip, phoneNumber, TIME_FORMAT(openingTime, '%H:%i'), TIME_FORMAT(closureTime, '%H:%i') FROM restaurant WHERE restaurantId = ?");
$stmt->execute([$restaurantId]);
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<div class="main-page-container">

<h3>Edit restaurant details</h3>

<form action="processEditRestaurant.php" method="get">
    <input type="hidden" name="restaurantId" value=<?php echo "\"".$restaurantId."\"" ?>>
    <table>
        <tr>
            <td><label>Name</label></td>
            <td><input type="text" name="name" required value=<?php echo "\"".$restaurant["name"]."\"" ?>></td>
        </tr>
        <tr>
            <td><label>Description</label></td>
            <td><input type="text" name="description" value=<?php echo "\"".$restaurant["description"]."\"" ?>></td>
        </tr>
        <tr>
            <td><label>Town</label></td>
            <td><input type="text" name="town" required value=<?php echo "\"".$restaurant["town"]."\"" ?>></td>
        </tr>
        <tr>
            <td><label>Street</label></td>
            <td><input type="text" name="street" required value=<?php echo "\"".$restaurant["street"]."\"" ?>></td>
        </tr>
        <tr>
            <td><label>ZIP</label></td>
            <td><input type="text" name="zip"  pattern="\d{5}" required value=<?php echo "\"".$restaurant["zip"]."\"" ?>></td>
        </tr>    
        <tr>
            <td><label>Phone number</label></td>
            <td><input type="text" name="phoneNumber" required value=<?php echo "\"".$restaurant["phoneNumber"]."\"" ?>></td>
        </tr>
        <tr>
            <td><label>Opening time</label></td>
            <td><input type="time" step="60" name="openingTime" required value=<?php echo "\"".$restaurant["TIME_FORMAT(openingTime, '%H:%i')"]."\"" ?>></td>
        </tr>         
        <tr>
            <td><label>Closure time</label></td>
            <td><input type="time" step="60"  name="closureTime" required value=<?php echo "\"".$restaurant["TIME_FORMAT(closureTime, '%H:%i')"]."\"" ?>></td>
        </tr>    
        <tr>
            <td></td>
            <td><button type="submit">Save changes</button></td>
        </tr>                               
    </table>
</form>

</div>