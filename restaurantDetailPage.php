
<link rel="stylesheet" type="text/css" href="styles/restaurantDetailPageStyle.css">

<?php

include "header.php";
include "dbConnect.php";

$restaurantId = $_GET["restaurantId"];
$stmt = $pdo->prepare("SELECT name, description, town, street, zip, phoneNumber, TIME_FORMAT(openingTime, '%H:%i'), TIME_FORMAT(closureTime, '%H:%i') FROM restaurant WHERE restaurantId = ?");
$stmt->execute([$restaurantId]);
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

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
    $stmt->execute([$_SESSION["userId"]]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user["state"] == "admin" || $user["state"] == "operator"){ ?>
    <form action="editRestaurantPage.php" method="get">
        <input type="hidden" name="restaurantId" value=<?php echo "\"".$restaurantId."\""; ?>>
        <button>Edit restaurant details</button>
    </form>
    <?php }
}


?><table class="items-table"><?php

$itemTypes = array("dailyMenu", "meal","sidedish", "sauce", "beverage");

foreach ($itemTypes as $itemType) {
    $stmt = $pdo->prepare("SELECT * from item inner join restaurantHasItem on item.itemId = restaurantHasItem.itemId where restaurantHasItem.restaurantId = ? and item.type = ?");
    $stmt->execute([$restaurantId, $itemType]);
    $groupedItems = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if(!empty($groupedItems)){
        echo "<tr><td><h3>{$itemType}</h3></td></tr>";

        foreach ($groupedItems as $item){
        echo <<<HTML
            <tr>
                <td>{$item["name"]}</td>
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
                <td><button onclick="additemToShoppingCart('{$item["name"]}','{$item["price"]}','{$item["itemId"]}')">&#128722;</button></td>
            </tr>
HTML;
        }
    }
}?>

    </table>
    <div class="shopping-cart">
        <Label>Shopping cart</Label>
        <table class="shopping-cart-table">
        <tr><td>Total</td><td>0.00€</td><td></td></tr>
        </table>

        <button onclick="goToCheckout()" id="ckeckout-button" type="submit" disabled>Go to checkout</button>
    </div>
</div> 

<script>

itemsInShoppingCart = [];

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
