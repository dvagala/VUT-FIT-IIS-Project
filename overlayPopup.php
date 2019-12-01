
<link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"> 
<script src="vendor/jquery-3.4.1.js"></script>
<link rel="stylesheet" href="styles/overlayPopupStyle.css">

<?php

if(isset($_GET["popUp"])){ ?>
    
    <div id="popupOverlay">
        <div id="popup-box">
            <div id="popup-box-child">
            <div id="close-button">x</div>

            <?php if($_GET["popUp"] == "placedOrderSuccess"){ ?>
                <div id="popupText">
                    <h3>Order successfully placed!</h3>
                    <small>Menu - My orders to see more</small>
                </div>
            <?php }
            else if($_GET["popUp"] == "signUpSuccess"){ ?>
                <div id="popupText">
                    <h3>You have signed up successfully!</h3>
                </div>
            <?php }
                        else if($_GET["popUp"] == "signUpSuccess"){ ?>
                <div id="popupText">
                    <h3>You have signed up successfully!</h3>
                </div>
            <?php }
            else if($_GET["popUp"] == "createRestaruantSuccess"){ ?>
                <div id="popupText">
                    <h3>Restaurant created successfully!</h3>
                </div>
            <?php }
            else if($_GET["popUp"] == "deleteRestaruantSuccess"){ ?>
                <div id="popupText">
                    <h3>Restaurant deleted successfully!</h3>
                </div>
            <?php }      
            else if($_GET["popUp"] == "addItemSuccess"){ ?>
                <div id="popupText">
                    <h3>Item added successfully!</h3>
                </div>
            <?php }                       
            else if($_GET["popUp"] == "error"){ ?>
                <div id="popupText">
                    <h3>An error happend!</h3>
                    <small>Sorry</small>
                </div>
            <?php }
            else if($_GET["popUp"] == "insufficientPermissions"){ ?>
                <div id="popupText">
                    <h3>Insufficient permissions!</h3>
                    <small>Sorry about that...</small>
                </div>
            <?php }?>
            
            </div>
        </div>
        <div id="background-overlay"></div>
    </div>
    
<script>

$(document).mousedown(function(e){ 
    if($(e.target).closest("#popup-box").length === 0 || $(e.target).closest("#close-button").length !== 0 ){
        location.href = "index.php";
    }
}); 

</script>

<?php } ?>

