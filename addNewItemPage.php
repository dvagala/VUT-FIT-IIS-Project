<?php
    include "header.php";
    if($globalUserState!='admin' and $globalUserState!='operator'){
        echo("<script>location.href ='index.php?popUp=insufficientPermissions'</script>");
        return;
    }
    ?>

<div class="main-page-container">

<h3>Add a new item</h3>

<form action="processAddNewItem.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="restaurantId" value=<?php echo "\"".$_GET["restaurantId"]."\""; ?>>
    <table>
        <tr>
            <td><label>Name</label></td>
            <td><input type="text" name="name" required placeholder="Name"></td>
        </tr>
        <tr>
            <td><label>Description</label></td>
            <td><input type="text" name="description" placeholder="Description" required></td>
        </tr>
        <tr>
            <td><label>Picture</label></td>
            <td><input type="file" accept="image/*" name="pictureToUpload" required></td>
        </tr>
        <tr>
            <td><label>Price</label></td>
            <td><input type="number" name="price"  step="0.01" required placeholder="price"> €</td>

        </tr>
        <tr>
            <td><label>Item category</label></td>
            <td><input type="radio" name="type" value="dailyMenu" required>Daily menu<br></td>
        </tr>          
        <tr>
            <td></td>
            <td><input type="radio" name="type" value="meal" checked="checked"  required>Meal<br></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="radio" name="type" value="sidedish" required>Sidedish<br></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="radio" name="type" value="sauce" required>Sauce<br></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="radio" name="type" value="beverage" required >Beverage<br></td>
        </tr>      
        <tr>
            <td><label>Tags</label></td>
            <td><input type="checkbox" name="isVegan">Vegan<br></td>
        </tr>   
        <tr>
            <td></td>
            <td><input type="checkbox" name="isGlutenFree">Gluten free<br></td>
        </tr>                     
        <tr>
            <td></td>
            <td><button type="submit">Save</button></td>
        </tr>                               
    </table>
</form>

</div>
