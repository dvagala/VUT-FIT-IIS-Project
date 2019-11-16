<link rel="stylesheet" type="text/css" href="style.css">


<div id="restaurantCards">
    <div id="restaurantCard">
        <h3>Purynka</h3>
        <p>Sweet uni canteen</p>
        <p>Brno</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Purynka</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>
    <div id="restaurantCard">
        <h3>Stary pivovar</h3>
        <p>Sweet uni canteen</p>
        <p>10:00 - 16:00</p>
        <button>Enter</button>
    </div>    
</div>


<?php
$servername = "localhost";
$username = "iisUser";
$password = "iisPassword";
$dbName = "iisDb";


class Restaurant{
    public $restaurantId;
    public $name;
    public $town;
    public $street;
    public $zip;
    public $ordersClosure;
}


try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"."<br>";

    $myvar = 'restaurant';

    // $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND status=?');
    // $stmt->execute([$email, $status]);
    // $user = $stmt->fetch();

    // $stmt = $pdo->query('SELECT name FROM restaurant');
    // $stmt = $pdo->prepare('SELECT * FROM restaurant');
    // $stmt->execute([$myvar]);

    // PDO::FETCH_ASSOC

    // $row = $stmt->fetch();

    $data = $pdo->query("SELECT name, town FROM restaurant")->fetchAll(PDO::FETCH_ASSOC);

    // print_r($data);

    foreach ($data as $restaurant){
        print_r($restaurant);
    }


    // echo "<br><br>";

    // while ($row = $stmt->fetch())
    // {
    //     echo $row['name']."<br>";
    // }

    }
catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
?>