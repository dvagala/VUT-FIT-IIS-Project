
<link rel="stylesheet" type="text/css" href="styles/my-orders-style.css">
<div class="main-page-container">
<?php
    include "header.php";
    echo"<h2>My orders:</h2><br>";

    $userId = null;
    if(isset($_SESSION['userId'])) {
        $myOrders = $pdo->query("SELECT R.name as r_name,orderId,O.state FROM `order` O INNER JOIN person P on P.personId=O.dinerId LEFT JOIN restaurant R on O.restaurantId=R.restaurantId WHERE dinerId={$_SESSION['userId']}")->fetchAll(PDO::FETCH_ASSOC);
        $userId = $_SESSION['userId'];
    }
    else if(isset($_COOKIE['userId'])){
        $myOrders = $pdo->query("SELECT R.name as r_name,orderId,O.state FROM `order` O INNER JOIN person P on P.personId=O.dinerId LEFT JOIN restaurant R on O.restaurantId=R.restaurantId WHERE dinerId={$_COOKIE["userId"]}")->fetchAll(PDO::FETCH_ASSOC);
        $userId = $_COOKIE['userId'];
    }


    if($userId!=null and !empty($myOrders)){

        echo "<table style=\"border-collapse: collapse; margin-left: 20px\">";
        foreach($myOrders as $order){
            $price = 0.0;
            echo <<<HTML
            
            <tr><td class='order-td'>Order from: {$order['r_name']}</td></tr>
            <tr style="border-bottom: 1px dotted darkcyan;">
            <td class="item-td" style="padding-right: 20px">Item</td>
            <td class="item-td" style="padding-right: 20px">Vegan</td>
            <td class="item-td" style="padding-right: 20px">Gluten free</td>
            <td class="item-td">Price</td>
            </tr>
            
HTML;

            $items = $pdo->query("SELECT i.name,i.description,picture,price, isVegan,isGlutenFree FROM `order` O NATURAL JOIN orderHasItem NATURAL JOIN item i  where orderId = {$order['orderId']}")->fetchAll(PDO::FETCH_ASSOC);
            foreach($items as $item){
                $price += $item['price'];
                echo <<<HTML
            <tr>
                <td class="item-td">{$item["name"]}</td>
                <td class="item-td">
HTML;
                if($item["isVegan"]){
                    echo "Yes";
                }
                else{
                    echo"No";
                }
                echo "</td><td class=\"item-td\">";
                if($item["isGlutenFree"]){
                    echo "Yes";
                }
                else{
                    echo "No";
                }
                echo <<<HTML
                </td>
                <td class="item-td">{$item["price"]} €
            </tr>
HTML;


            }
            echo <<<HTML
            <tr style="border-top: 1px dotted darkcyan;">
            <td class="item-td">Summary</td>
            <td class="item-td"></td>
            <td class="item-td"></td>
            <td class="item-td">$price €</td>
            </tr>
            <tr><td style="padding-top: 25px"></td></tr>
            <tr style="border-bottom: 1pt solid black"><td class="item-td" style="font-weight: bold">State:  {$order['state']}</td>
            </tr>
            <tr><td style="padding-top: 25px"></td></tr>
            
            
HTML;

        }
        echo"</table>";
    }
    else{
        echo"<p>You have no orders at the moment!</p>";
    }


    ?>

</div>
