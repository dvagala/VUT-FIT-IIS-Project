<?php

include "header.php";
include "dbConnect.php";

$data = $pdo->query("SELECT name, description, town, TIME_FORMAT(openingTime, '%H:%i'), TIME_FORMAT(closureTime, '%H:%i'), isVegan, isGlutenFree FROM restaurant")->fetchAll(PDO::FETCH_ASSOC); ?>
    

<div class="main-page-container">

    <input type="text" id="restaurantSearchInput" placeholder="Find restaruant">

    <div id="restaurantCards">

    <?php foreach ($data as $restaurant){
        echo <<<HTML

            <div class="restaurantCard" id={$restaurant['isVegan']}>
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

data-animal-type

<script>

$("#restaurantSearchInput").keyup(function(){
    // $(".restaurantCard").{
    //     this.css("background-color", "yellow");
    // }

    alert($(".restaurantCard").attr("id"));
});

</script>

<!-- // $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND status=?');
    // $stmt->execute([$email, $status]);
    // $user = $stmt->fetch();

    // $stmt = $pdo->query('SELECT name FROM restaurant');
    // $stmt = $pdo->prepare('SELECT * FROM restaurant');
    // $stmt->execute([$myvar]);

    // PDO::FETCH_ASSOC

    // $row = $stmt->fetch();
    // SELECT TIME_FORMAT(`openingTime`, '%H:%i') FROM `restaurant`; -->