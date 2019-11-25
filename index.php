<?php

include "header.php";
include "dbConnect.php";

$data = $pdo->query("SELECT name, description, town, TIME_FORMAT(openingTime, '%H:%i'), TIME_FORMAT(closureTime, '%H:%i')  FROM restaurant")->fetchAll(PDO::FETCH_ASSOC); ?>
    

<div class="main-page-container">
    <div id="restaurantCards">

    <?php foreach ($data as $restaurant){
        echo <<<HTML

            <div id="restaurantCard">
                <h3>{$restaurant['name']}</h3>
                <p>{$restaurant['description']}</p>
                <p>{$restaurant['town']}</p>
                <p>{$restaurant["TIME_FORMAT(openingTime, '%H:%i')"]} - {$restaurant["TIME_FORMAT(closureTime, '%H:%i')"]}</p>
                <button>Enter</button>
            </div>
HTML;
    }?>
    </div>
</div>



<!-- // $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND status=?');
    // $stmt->execute([$email, $status]);
    // $user = $stmt->fetch();

    // $stmt = $pdo->query('SELECT name FROM restaurant');
    // $stmt = $pdo->prepare('SELECT * FROM restaurant');
    // $stmt->execute([$myvar]);

    // PDO::FETCH_ASSOC

    // $row = $stmt->fetch();
    // SELECT TIME_FORMAT(`openingTime`, '%H:%i') FROM `restaurant`; -->