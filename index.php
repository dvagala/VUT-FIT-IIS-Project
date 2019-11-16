<?php
$servername = "localhost";
$username = "iisUser";
$password = "L3tmeinn";

class Restaurant{
    public $restaurantId;
    public $name;
    public $town;
    public $street;
    public $zip;
    public $ordersClosure;
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=iisDb", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"."<br>";

    $dbName = 1;

    // $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND status=?');
    // $stmt->execute([$email, $status]);
    // $user = $stmt->fetch();

    // $stmt = $pdo->query('SELECT name FROM restaurant');
    $stmt = $pdo->prepare('SELECT * FROM restaurant');
    $stmt->execute([$dbName]);

    // PDO::FETCH_ASSOC

    $row = $stmt->fetch(PDO::FETCH_CLASS);
    // print_r($row);

    echo "<br><br>";
    echo 4;

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