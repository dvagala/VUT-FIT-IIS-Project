<?php
include "header.php";
include "dbConnect.php";
echo <<<HTML
<head>
<link rel="stylesheet" href="styles/manage-users-style.css">
<title>Manage Users</title>

</head>


HTML;
if(!isset($_POST['filter'])){
    $data = $pdo->query("SELECT * FROM person")->fetchAll(PDO::FETCH_ASSOC);
    print_Persons($data);

}
if(isset($_POST['submit']) && $_POST['ChangeRole']!=''){
    $roleAndId = explode('_',$_POST['ChangeRole']);
    $sql = "UPDATE person SET state='$roleAndId[0]' WHERE personId=$roleAndId[1]";
    $pdo->query($sql);
    echo "<meta http-equiv='refresh' content='0'>";
}

if(isset($_POST['filter'])){
    $data = $pdo->query("SELECT * FROM person")->fetchAll(PDO::FETCH_ASSOC);
    $final_data = [];
    if($_POST['Role']=="All" and $_POST['nameLookup']=='' and $_POST['idLookup']==''){

    }
    else{

        if($_POST['Role']!="All"){
            foreach($data as $row){
                if(in_array($_POST['Role'], $row)){
                    array_push($final_data,$row);
                }

            }
            $data = $final_data;
            $final_data = [];
        }
        if($_POST['nameLookup']!=''){
            foreach($data as $row){

                if(in_array($_POST['nameLookup'], $row)){
                    array_push($final_data,$row);
                }

            }
            $data = $final_data;
            $final_data = [];
        }
        if($_POST['idLookup']!=''){

            foreach($data as $row){


                if(in_array($_POST['idLookup'], $row)){
                    array_push($final_data,$row);
                }

            }
            $data = $final_data;
            $final_data = [];
        }

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
                <td class="person-td">Name: {$person['Name']}</td>
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

