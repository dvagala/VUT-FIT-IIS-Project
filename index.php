<?php

include "header.php";
include "dbConnect.php";

$data = $pdo->query("SELECT restaurantId, name, description, town, TIME_FORMAT(openingTime, '%H:%i'), TIME_FORMAT(closureTime, '%H:%i') FROM restaurant")->fetchAll(PDO::FETCH_ASSOC); ?>
    

<div class="main-page-container">
    <input type="text" id="restaurantSearchInput" placeholder="Find restaruant">
    <div id="restaurantCards">

    <?php foreach ($data as $restaurant){
        echo <<<HTML
            <a href="restaurantDetailPage.php?restaurantId={$restaurant['restaurantId']}" class="restaurantCard" data-restaurant-name="{$restaurant['name']}">
                <h3>{$restaurant['name']}</h3>
                <p>{$restaurant['description']}</p>
                <p>{$restaurant['town']}</p>
                <p>{$restaurant["TIME_FORMAT(openingTime, '%H:%i')"]} - {$restaurant["TIME_FORMAT(closureTime, '%H:%i')"]}</p>
            </a>
HTML;
    }?>
    </div>
</div>


<script>

$("#restaurantSearchInput").keyup(function(){
    $(".restaurantCard").each(function(){
        if ($(this).attr("data-restaurant-name").indexOf($("#restaurantSearchInput").val()) >= 0) {
            $(this).css("display", "block");
        }else{
            $(this).css("display", "none");
        }
    });
});

</script>
