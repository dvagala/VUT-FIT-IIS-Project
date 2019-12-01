<?php

include "header.php";
include "dbConnect.php";

?>

<div class="main-page-container">

<h3>Create a new restaurant</h3>

<form action="processCreateRestaurant.php" method="get">
    <table>
        <tr>
            <td><label>Name</label></td>
            <td><input type="text" name="name" required placeholder="Name"></td>
        </tr>
        <tr>
            <td><label>Description</label></td>
            <td><input type="text" name="description" placeholder="Description"></td>
        </tr>
        <tr>
            <td><label>Town</label></td>
            <td><input type="text" name="town" required placeholder="Town"></td>
        </tr>
        <tr>
            <td><label>Street</label></td>
            <td><input type="text" name="street" required placeholder="Street"></td>
        </tr>
        <tr>
            <td><label>ZIP</label></td>
            <td><input type="text" name="zip"  pattern="\d{5}" required placeholder="ZIP (Eg.: 61200)"></td>
        </tr>    
        <tr>
            <td><label>Phone number</label></td>
            <td><input type="text" name="phoneNumber" required placeholder="Phone number"></td>
        </tr>
        <tr>
            <td><label>Opening time</label></td>
            <td><input type="time" step="60" name="openingTime" value="08:00" required placeholder="Opening time"></td>
        </tr>         
        <tr>
            <td><label>Closure time</label></td>
            <td><input type="time" step="60"  name="closureTime"  value="18:00"  required placeholder="Closure time"></td>
        </tr>    
        <tr>
            <td></td>
            <td><button type="submit">Create restaurant</button></td>
        </tr>                               
    </table>
</form>

</div>