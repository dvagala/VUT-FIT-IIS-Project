<?php
    include "header.php";
?>

<div class="main-page-container">

<h3>Add a new item</h3>

<!-- itemId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name TINYTEXT,
  description TEXT,
  picture TEXT,
  price DECIMAL(6,2),
  type ENUM("dailyMenu", "meal","sidedish", "sauce", "beverage"),
  isInMenu BOOLEAN DEFAULT FALSE,
  isVegan BOOLEAN DEFAULT FALSE,
  isGlutenFree BOOLEAN DEFAULT FALSE -->

  <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form> -->

<form action="processAddNewItem.php" method="post" enctype="multipart/form-data">
    <table>

        <!-- <select>
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="mercedes">Mercedes</option>
            <option value="audi">Audi</option>
        </select>
     -->
        <tr>
            <td><label>Name</label></td>
            <td><input type="text" name="name" required placeholder="Name"></td>
        </tr>
        <tr>
            <td><label>Description</label></td>
            <td><input type="text" name="description" placeholder="Description"></td>
        </tr>
        <tr>
            <td><label>Picture</label></td>
            <td><input type="file" accept="image/*" name="pictureToUpload" required></td>
        </tr>
        <tr>
            <td><label>Price</label></td>
            <td><input type="number" name="price" required placeholder="price"></td>
        </tr>
        <tr>
            <td><label>Item category</label></td>
            <td><input type="radio" name="gender" value="male">Meal<br></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="radio" name="gender" value="female">Sidedish<br></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="radio" name="gender" value="male">Sauce<br></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="radio" name="gender" value="male" >Beverage<br></td>
        </tr>      
        <tr>
            <td></td>
            <td><input type="radio" name="gender" value="male" id="daily-menu-radio">Daily menu<br></td>
        </tr>       
        <tr id="daily-menu-date-row" style="visibility:collapse;">
            <td><label>Set daily menu's date</label></td>
            <td><input type="date" name="description"></td>
        </tr>             
        <!-- <tr>
            <td><label>Tags</label></td>
            <td><input type="checkbox" name="isInMenu" value="isInMenu">Show in restaurant menu<br></td>
        </tr>       -->
        <tr>
            <td><label>Tags</label></td>
            <td><input type="checkbox" name="isVegan" value="isVegan">Vegan<br></td>
        </tr>   
        <tr>
            <td></td>
            <td><input type="checkbox" name="isGlutenFree" value="isGlutenFree">Gluten free<br></td>
        </tr>                     
        <tr>
            <td></td>
            <td><button type="submit">Add new item</button></td>
        </tr>                               
    </table>
</form>

</div>

<script>
$("input[type='radio']").not('#daily-menu-radio').click(function(){
    $("#daily-menu-date-row").css("visibility", "collapse");
});

$('#daily-menu-radio').click(function(){
    $("#daily-menu-date-row").css("visibility", "visible");
});
</script>