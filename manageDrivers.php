<link rel="stylesheet" href="styles/manage-users-style.css">
<div class="main-page-container">
<?php
include "header.php";
include "dbConnect.php";



$orders = $pdo->query("SELECT orderId,O.state,Name FROM `order` O LEFT JOIN person on driverId = personId")->fetchAll(PDO::FETCH_ASSOC);
$drivers = $pdo->query("SELECT personId,Name, COUNT(orderId) as pocet FROM person LEFT JOIN `order` on person.personId = `order`.driverId where person.state='driver' group by personId,Name order by Count(orderId)
")->fetchAll(PDO::FETCH_ASSOC);

print_orders_and_drivers($orders,$drivers);

if(isset($_POST['submit']) && $_POST['AssignDriver']!=''){
    $ids = explode('_',$_POST['AssignDriver']);// $ids[1] =orderId, $ids[2] = driver_Id
    $pdo->query("UPDATE `order` SET state='confirmed' WHERE orderId=$ids[1]");
    $pdo->query("UPDATE `order` SET driverId=$ids[2] WHERE orderId=$ids[1]");
    echo "<meta http-equiv='refresh' content='0'>";

}


function print_orders_and_drivers($orders,$drivers){
    echo "<p class='orders-p'>Unassigned orders</p><br>";
    echo "<table class=\"person-table\"> ";
    $unnasigned = [];
    foreach ($orders as $order) {
        if ($order['state']=='unconfirmed'){
            print_order($order,$drivers,false);
        }
        else{
            array_push($unnasigned,$order);
        }
    }
    echo "</table><br>";

    echo "<p class='orders-p'>Assigned orders</p><br>";
    echo "<table class=\"person-table\"> ";
    foreach ($unnasigned as $order){
        print_order($order,$drivers,true);
    }
    echo "</table>";
        }

function print_order($order,$drivers,$assigned){
    $order_id = $order['orderId'];
            echo <<<HTML
            
            <tr>
                <td class="person-td">ID: $order_id</td>
                <td class="person-td">State: {$order['state']}</td>
HTML;
                if($assigned){
                echo "<td class=\"person-td\">Assigned to: {$order['Name']}</td>";
                }
echo <<<HTML

                <td class="person-td">
                    <form action="#" method="post">
                    <select name="AssignDriver"> 
                        <option value="" selected disabled hidden>Select Driver</option>
HTML;
            print_drivers_options($drivers,$order_id);
            echo <<<HTML
                    </select>
                    
                </td>
                <td class="person-td"><input type="submit" name="submit" value="Save"></td>
                </form>
            </tr>    
            
HTML;
}


function print_drivers_options($drivers,$order_id){

    foreach ($drivers as $driver) {
        $person_id = $driver['personId'];
        echo <<<HTML
            <option value="driver_{$order_id}_$person_id">{$driver['Name']} {$driver['pocet']}</option>
HTML;

    }
}
?>
</div>
