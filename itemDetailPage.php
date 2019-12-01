<link rel="stylesheet" type="text/css" href="styles/my-orders-style.css">
<div class="main-page-container">
<?php
include "header.php";
$item = $pdo->query("SELECT * from item where itemId={$_GET['itemId']}")->fetch(PDO::FETCH_ASSOC);
echo <<<HTML
    <div class="row">
        <div class="column">
        
        <p class='order-td'>{$item['name']}</p>
        <table style="padding-left: 20px">
        <tr><td class="item-detail-td">Type:</td><td>
HTML;
echo get_type_name($item['type']);
echo <<<HTML
</td></tr>
        <tr><td class="item-detail-td">Vegan:</td><td class="item-detail-td">
        
    
HTML;
if($item["isVegan"]){
    echo "Yes";
}
else{
    echo "No";
}
echo "</td><tr><td class=\"item-detail-td\">Gluten free:</td><td class=\"item-detail-td\">";

if($item["isGlutenFree"]){
    echo "Yes";
}
else{
    echo "No";
}
echo <<<HTML
        </td></tr>
        <tr><td class="item-detail-td">Price:</td><td> {$item['price']}€</td></tr>
        </table><br>
        <p style="padding-left: 20px" class="item-detail-td">{$item['description']}</p>
        </div>
        <div class="column">
        <p><img style="width:300px;height:300px; border:5px solid darkcyan" src={$item['picture']} alt={$item['name']} ></p>
        </div>
    </div>
HTML;

if(isset($_SESSION['userId'])){
    $state = $pdo->query("SELECT state FROM person WHERE personId={$_SESSION['userId']}")->fetch(PDO::FETCH_ASSOC);
    $state=$state['state'];
    if($state=='admin' or $state=='operator'){
        edit_item($item);
    }
}

function edit_item($item){
    echo <<<HTML
    <div class="row">
        <div class="column"><br><br><br>
            <p class='order-td'>Edit item:</p>
            <form  method="post">
            <table style="padding-left: 20px">
                <tr>
                    <td><label>Name</label></td>
                    <td><input type="text" name="name" required placeholder="Name" value='{$item['name']}'></td></tr>
                <tr>
                    <td><label>Description</label></td>
                    <td><input type="text" name="description" placeholder="Description" required value='{$item['description']}'></td>
                </tr>
                <tr>
                    <td><label>Price</label></td>
                    <td><input type="number" name="price"  step="0.01" required placeholder="price" value={$item['price']}> €</td>
        
                </tr>
                <tr>
                    <td><label>Item category</label></td>
                </tr>
HTML;
    foreach([0,1,2,3,4] as $option){
        print_radio_option($option,$item['type']);
    }
    echo <<<HTML
                <tr>
                    <td><label>Tags</label></td>
                    <td><input type="checkbox" name="isVegan"
HTML;
    if($item["isVegan"]){
        echo" checked";
    }
    echo <<<HTML
    >Vegan<br></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="checkbox" name="isGlutenFree"
HTML;
    if($item["isGlutenFree"]){
        echo" checked";
    }
    echo <<<HTML
    >Gluten free<br></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input  type="submit" name="editItem" value="Update" ></td>
                </tr>
            </table>
            </form>
        </div>
        <div class="column" >
            <form method="post" enctype="multipart/form-data" >
                <p>    
                    <input type="file" accept="image/*" name="pictureToUpload" required >
                </p>    
                <input type="submit" name="changePicture" value="Change Picture">
            </form>
        </div>        
    </div>        

HTML;


}

if(isset($_POST['changePicture'])){
    if(isset($_FILES['pictureToUpload'])){

        $target_dir = 'uploads/';
        $imageFileType = strtolower(pathinfo($_FILES['pictureToUpload']['name'],PATHINFO_EXTENSION));
        $target_file = $target_dir . $_FILES['pictureToUpload']['name'];

        $check = getimagesize($_FILES["pictureToUpload"]["tmp_name"]);
        if($check === false) {
            header("location: index.php?popUp=error");
            return;
        }
        var_dump($target_file);
        move_uploaded_file($_FILES['pictureToUpload']['tmp_name'], $target_file);

        $pdo->query("UPDATE item SET picture='$target_file' where itemId={$item['itemId']}");
        echo "<meta http-equiv='refresh' content='0'>";
    }
}

if(isset($_POST['editItem'])){
    $isVegan = false;
    $isGlutenFree = false;

    if(isset($_POST["isVegan"])){
        $isVegan = true;
    }

    if(isset($_POST["isGlutenFree"])){
        $isGlutenFree = true;
    }
    $stmt = $pdo->prepare("UPDATE item SET name = ?, description = ?,price = ?, type = ?, isVegan = ?, isGlutenFree = ? where itemId = ?");
    $stmt->execute([$_POST["name"], $_POST["description"], $_POST["price"], $_POST["type"], intval($isVegan), intval($isGlutenFree),$item['itemId']]);
    echo "<meta http-equiv='refresh' content='0'>";

}

function get_type_name($type){
    $enum = ["dailyMenu", "meal","sidedish", "sauce", "beverage"];
    $options = ['Daily menu','Meal','Sidedish','Sauce','Beverage'];
    return $options[array_search($type,$enum)];
}

function print_radio_option($idx,$type){
    $enum = ["dailyMenu", "meal","sidedish", "sauce", "beverage"];
    $options = ['Daily menu','Meal','Sidedish','Sauce','Beverage'];
    echo "<tr><td></td><td><input type=\"radio\" name=\"type\" value={$enum[$idx]} required ";
    if($type == $enum[$idx]){
        echo"checked";
    }
    echo ">{$options[$idx]}<br</td></tr>";
}

?>


</div>

