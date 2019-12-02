<?php 
include "header.php";
include "dbConnect.php"; ?>

<link rel="stylesheet" href="styles/manage-users-style.css">
<div class="main-page-container">

<?php
if($globalUserState!='admin'){
    echo("<script>location.href ='index.php?popUp=insufficientPermissions'</script>");
    return;
}
echo <<<HTML

HTML;
if(!isset($_POST['filter'])){
    $data = $pdo->query("SELECT personId,Name,Surname,mail,state FROM person where state <> 'unregistered'")->fetchAll(PDO::FETCH_ASSOC);
    print_Persons($data);

}
if(isset($_POST['submit']) && $_POST['ChangeRole']!=''){
    $roleAndId = explode('_',$_POST['ChangeRole']);
    $sql = "UPDATE person SET state='$roleAndId[0]' WHERE personId=$roleAndId[1]";
    $pdo->query($sql);
    echo "<meta http-equiv='refresh' content='0'>";
}

if(isset($_POST['delete'])){

    //Change driver to null in orders where deleted person is driver
    $sql = "UPDATE `order` SET driverId=0 where driverId='{$_POST['userId']}'";
    $pdo->query($sql);
    //get all orders
    $orders = $pdo->query("SELECT orderId FROM `order` where dinerId={$_POST['userId']}")->fetchAll(PDO::FETCH_ASSOC);

    //delete everything from orderHasItem table for every order he has active, if user is going to be deleted
    foreach($orders as $order){
        $sql = "DELETE FROM orderHasItem WHERE orderId='{$order['orderId']}'";
        $pdo->query($sql);
    }
    //delete all orders
    $sql = "DELETE FROM `order` WHERE dinerId='{$_POST['userId']}'";
    $pdo->query($sql);
    //finally delete person
    $sql = "DELETE FROM person WHERE personId='{$_POST['userId']}'";
    $pdo->query($sql);
    echo "<meta http-equiv='refresh' content='0'>";
}

if(isset($_POST['filter'])){


    $final_data = [];

    if($_POST['Role']=="All" and $_POST['nameLookup']=='' and $_POST['idLookup']==''){
        $data = $pdo->query("SELECT personId,Name,Surname,mail,state FROM person where state <> 'unregistered'")->fetchAll(PDO::FETCH_ASSOC);

    }
    else{
        $data = $pdo->query("SELECT personId,Name,Surname,mail,state FROM person")->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $row){
            if($_POST['Role']!='unregistered'){
                if($row['state']=='unregistered'){
                    continue;
                }
    }
            $search_row = array_map('strtolower', $row);
            $role_push = false;
            $name_push = false;
            $id_push = false;

            if($_POST['Role']!="All") {
                if ($_POST['Role'] ==  $row['state']) {
                    $role_push = true;
                }
            }
            else{
                $role_push = true;
            }
            if($_POST['nameLookup']!=''){
                if(strpos($search_row["Name"],strtolower($_POST['nameLookup'])) !== false || strpos($search_row["Surname"],strtolower($_POST['nameLookup'])) !== false ){
                   $name_push = true;
                }
            }
            else{
                $name_push = true;
            }
            if($_POST['idLookup']!=''){
                if($_POST['idLookup'] == $row['personId']){
                    $id_push = true;
                }
            }
            else{
                $id_push = true;
            }
            if($role_push and $name_push and $id_push){
                array_push($final_data, $row);
            }

        }
        $data = $final_data;

    }
    print_Persons($data);
}


function print_Persons($data){
    echo <<<HTML
    <table class="person-table">
    <tr>
    <td></td>
    <td class="person-td">Role</td>
    <td class="person-td">Name</td>
    <td class="person-td">ID</td>
    </tr>
    <tr>
        <td class="person-td">Filter by:</td>
        <td class="person-td"><form action="#" method="post">
            <select name="Role"> 
            <option value="All" >All</option>
            <option value="unregistered">Unregistered</option>
            <option value="diner">Diner</option>
            <option value="driver">Driver</option>
            <option value="operator">Operator</option>
            <option value="admin">Admin</option>
            </select>   
            </td>  
            <td class="person-td"><input type="text" name="nameLookup" size="10"></td>               
            <td class="person-td"><input type="text" name="idLookup" size="5"></td>               
            <td class="person-td"><input type="submit" name="filter" value="Search"></td>
        </form>    
    </tr>
    <tr><td height="30"></td></tr>
HTML;

    foreach ($data as $person) {
        $id = $person['personId'];
        echo <<<HTML
            
            <tr>
                <td class="person-td">ID: $id</td>
                <td class="person-td">Name: {$person['Name']} {$person['Surname']}</td>
                <td class="person-td">Mail: {$person['mail']}</td>
                <td class="person-td">Role: {$person['state']}</td>
                <td class="person-td">
                    <form action="#" method="post">
                    <select name="ChangeRole"> 
                        <option value="" selected disabled hidden>Change role</option>
                        <option value="unregistered_$id">Unregistered</option>
                        <option value="diner_$id">Diner</option>
                        <option value="driver_$id">Driver</option>
                        <option value="operator_$id">Operator</option>
                        <option value="admin_$id">Admin</option>
                    </select>
                    
                </td>
                <td class="person-td"><input type="submit" name="submit" value="Save"></td>
                <td class="person-td"><input type="hidden" name="userId" value=$id><input style="background: red" type="submit" name="delete" value="Delete"></td>
                </form>
            </tr>    
            
HTML;

    }
    if(empty($data)){
        echo"<td class=\"person-td\">No results!</td>";
    }
    echo "</table>";

}

?>

</div>