<?php
include "header.php";
echo <<<HTML
<head>
<link rel="stylesheet" href="styles/manage-users-style.css">
<title>Manage Users</title>

</head>
<table class="person-table">

HTML;
$data = $pdo->query("SELECT * FROM person")->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['submit']) && $_POST['ChangeRole']!=''){
    $roleAndId = explode('_',$_POST['ChangeRole']);
    $sql = "UPDATE person SET state='$roleAndId[0]' WHERE personId=$roleAndId[1]";
    $pdo->query($sql);
    echo "<meta http-equiv='refresh' content='0'>";

}

    foreach ($data as $person) {
        $id = $person['personId'];
        echo <<<HTML
            <tr>
                <td class="person-td">ID: $id</td>
                <td class="person-td">Name: {$person['Name']}</td>
                <td class="person-td">Mail: {$person['mail']}</td>
                <td class="person-td">Role: {$person['state']}</td>
                <td >
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
                <td><input type="submit" name="submit" value="Save"></td>
                </form>
            </tr>    
            
HTML;

}

echo <<<HTML

</table>
HTML;


?>

