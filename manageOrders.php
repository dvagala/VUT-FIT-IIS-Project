<link rel="stylesheet" href="styles/manage-orders-style.css">
<div class="main-page-container">
<?php
include "header.php";
include "dbConnect.php";
$orders = $pdo->query("SELECT R.name as r_name,R.town as r_town,R.street as r_street,R.zip as r_zip, orderId, `order`.state as state,P.Name,P.Town,P.Street,P.ZIP,P.personId,`order`.additionalInfo FROM `order` LEFT JOIN person D on `order`.driverId = D.personId INNER JOIN person P on `order`.dinerId = P.personId JOIN restaurant R on R.restaurantId=`order`.restaurantId where D.personId={$_SESSION['userId']}")->fetchAll(PDO::FETCH_ASSOC);
print_orders($orders);

if (isset($_POST['picked_up'])){
    $pdo->query("UPDATE `order` SET state='delivery' WHERE orderId={$_POST['orderId']}");
    echo "<meta http-equiv='refresh' content='0'>";
}
if (isset($_POST['delivered'])){
    $pdo->query("DELETE FROM orderHasItem WHERE orderId={$_POST['orderId']}");
    $pdo->query("DELETE FROM `order` WHERE orderId={$_POST['orderId']}");
    echo "<meta http-equiv='refresh' content='0'>";
}

function print_orders($orders){

    foreach($orders as $order){
        $id = $order['orderId'];
        echo <<<HTML
        <table class="restaurant-table">
        <tr><td class="restaurant-td">{$order['r_name']}</td></tr>
        <tr><td class="order-td">Address: {$order['r_town']}, {$order['r_street']}, {$order['r_zip']}</td></tr>
        <tr><td class="order-td">Name: {$order['Name']}</td></tr>
        <tr><td class="order-td">Address: {$order['Town']}, {$order['Street']}, {$order['ZIP']}</td></tr>
        <tr><td class="info-td">Info: {$order['additionalInfo']}</td></tr>
        <form action="#" method="post">
        <tr>
        <td class="button-td"> <input type="hidden" name="orderId" value=$id>
HTML;
        if($order['state'] == 'confirmed'){
            echo "<input id=$id type=\"submit\" name=\"picked_up\" value=\"Picked up\"></td>";
        }
        else{
            echo "<input id=$id type=\"submit\" name=\"delivered\" value=\"Delivered\"></td>";
        }
        echo <<<HTML
        </tr>
        </form>
        </table>
        <br>
HTML;

    }

}


?>
</div>
