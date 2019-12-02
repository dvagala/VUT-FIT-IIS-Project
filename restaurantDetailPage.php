<?php include "header.php"; ?>

<link rel="stylesheet" type="text/css" href="styles/restaurantDetailPageStyle.css">

<?php

$restaurantId = $_GET["restaurantId"];
$stmt = $pdo->prepare("SELECT name, description, town, street, zip, phoneNumber, TIME_FORMAT(openingTime, '%H:%i'), TIME_FORMAT(closureTime, '%H:%i') FROM restaurant WHERE restaurantId = ?");
$stmt->execute(array($restaurantId));
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
$vegan = false;
$glutenFree=false;

echo <<<HTML
<div class="main-page-container">

    <h2>{$restaurant["name"]}</h2>
    <p>{$restaurant["description"]}</p>
    <p>{$restaurant["street"]}, {$restaurant["town"]}, {$restaurant["zip"]}</p>
    <p>{$restaurant["phoneNumber"]}</p>
    <p>{$restaurant["TIME_FORMAT(openingTime, '%H:%i')"]} - {$restaurant["TIME_FORMAT(closureTime, '%H:%i')"]}</p>
HTML;

if(isset($_SESSION["userId"])){
    $stmt = $pdo->prepare("SELECT state FROM person WHERE personId = ?");
    $stmt->execute(array($_SESSION["userId"]));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user["state"] == "admin" || $user["state"] == "operator"){ ?>
    <form action="editRestaurantPage.php" method="get">
        <input type="hidden" name="restaurantId" value=<?php echo "\"".$restaurantId."\""; ?>>
        <button>Edit restaurant</button>
    </form>
    <?php }
}


?>
<br><table class="items-table" >
    <form action="#" method="post">
    <tr>
        <td ><label style="font-weight: bold">Filter by:</label></td>
        <td><label>Vegan</label><input type="checkbox" name="isVegan"></td>
        <td><label>GlutenFree</label><input type="checkbox" name="isGlutenFree"></td>
        <td></td><td><input type="submit" name="filter" value="Filter"></td>
    </tr>
    </form>
    <?php
if(isset($_POST['filter'])){
    if(isset($_POST['isVegan'])){
        $vegan=true;
    }
    else{
        $vegan = false;
    }
    if(isset($_POST['isGlutenFree'])){
        $glutenFree = true;
    }
    else{
        $glutenFree = false;
    }
}

$itemTypes = array("dailyMenu", "meal","sidedish", "sauce", "beverage");

foreach ($itemTypes as $itemType) {
    $stmt = $pdo->prepare("SELECT * from item inner join restaurantHasItem on item.itemId = restaurantHasItem.itemId where restaurantHasItem.restaurantId = ? and item.type = ?");
    $stmt->execute(array($restaurantId, $itemType));
    $groupedItems = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if(!empty($groupedItems)){
        if($itemType == "dailyMenu"){
            echo "<tr><td><h3>Today's menu</h3></td></tr>";
        }else{
            echo "<tr><td><h3>{$itemType}</h3></td></tr>";
        }

        foreach ($groupedItems as $item){
            if($vegan){
                if(!$item['isVegan']){
                    continue;
                }
            }
            if($glutenFree){
                if(!$item['isGlutenFree']){
                    continue;
                }
            }
            echo <<<HTML
                <tr >
                    <td class="item-td" onclick="showItemDetail('{$item['itemId']}')">{$item["name"]}</td>
                    <td>
HTML;
                    if($item["isVegan"]){
                        echo "Vegan";
                    }
                    echo "</td><td>";
                    if($item["isGlutenFree"]){
                        echo "Gluten free";
                    }
                    echo <<<HTML
                    </td>
                    <td>{$item["price"]} €</td>
           
                    <td id="btn"><button onclick="additemToShoppingCart('{$item["name"]}','{$item["price"]}','{$item["itemId"]}')">&#128722;</button></td>
                </tr>  
           
HTML;
        }
    }
}?>

<?php if(isset($_SESSION["userId"])){

    if($user["state"] == "admin" || $user["state"] == "operator"){ ?>
        <tr><td></td><td>
            <form action="addNewItemPage.php" method="get">
                <input type="hidden" name="restaurantId" value=<?php echo "\"".$restaurantId."\""; ?>>
                <button type="submit">Add a new item</button>
            </form>
        </td></tr>
    <?php }
} ?>

</table> 




    <div class="shopping-cart">
        <Label>Shopping cart</Label>
        <table class="shopping-cart-table">
        <tr><td>Total</td><td>0.00€</td><td></td></tr>
        </table>

        <button onclick="goToCheckout()" class="btn btn-primary" id="ckeckout-button" type="submit" disabled>Go to checkout</button>
    </div>
</div> 

<script>

itemsInShoppingCart = [];

function showItemDetail(itemId){
    location.href = "itemDetailPage.php?itemId=" + itemId;
}

function additemToShoppingCart(name, price, itemId){
    var newItem = {name:name, price:price, itemId:itemId};
    itemsInShoppingCart.push(newItem);
    updateShoppingCart();
}

function updateShoppingCart(){
    $(".shopping-cart-table tr").remove();

    var orderedItemsHTML = "";
    var sumUpPrice = 0;

    itemsInShoppingCart.forEach(function(item, index){
        orderedItemsHTML += "<tr><td>" + item["name"] + "</td><td>" + item["price"] + "€</td><td><button onClick=\"deleteItemInShoppingCart(" + index + ")\">x</button></td></tr>"
        sumUpPrice += parseFloat(item["price"]);
    });

    if(itemsInShoppingCart.length == 0){
        $('#ckeckout-button').attr("disabled", true);
    }else{
        $('#ckeckout-button').attr("disabled", false);
    }

    $(".shopping-cart-table").append(orderedItemsHTML); 
    $(".shopping-cart-table").append("<tr><td>Total</td><td>" + sumUpPrice.toFixed(2) +"€</td><td></td></tr>"); 
}   

function deleteItemInShoppingCart(index){
    itemsInShoppingCart.splice(index, 1);
    updateShoppingCart();
}

function goToCheckout(){
    var parameters = window.location.search.substring(1) + "&";


    itemsInShoppingCart.forEach(function(item, index){
        parameters += "items[]=" + item["itemId"];
        
        if(index < itemsInShoppingCart.length - 1){
            parameters += "&";
        }

    });    

    location.href = "checkoutPage.php?" + parameters;
}


</script>
