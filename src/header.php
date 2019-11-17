<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/header-style.css">
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="main-page-container">
        <div class="main-header">
            <p>Food delivery</p>
            <div class="header-nav">
                <a class="login-nav-button" href="#">Login</a>
                <a href="#">Sign up</a>
                <a href="#">Menu</a>
                <div class="login-dropdown">
                    <form class="login-form" action="" method="post">
                        <input type="text" placeholder="Email">
                        <input type="text" placeholder="Password">
                        <button>Login</button>
                    </form>
                </div>
                <div class="menu-dropdown">
                    <ul>
                        <li><a href="">My profile</a></li>
                        <li><a href="">My orders</a></li>
                        <li><a href="">Manage drivers</a></li>
                        <li><a href="">Manage users</a></li>
                        <li><a href="">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

<script>

// var loginDropDown = document.querySelector(".login-dropdown");
// var menuDropDown = document.querySelector(".menu-dropdown");
// loginDropDown.style.display = "none";
// menuDropDown.style.display = "none";


// function loginDropdownClicked(){
//     if(loginDropDown.style.display == "none"){
//         loginDropDown.style.display = "block";
//         menuDropDown.style.display = "none";
//     }else{
//         loginDropDown.style.display = "none";
//     }
// }

// function menuDropdownClicked(){
//     if(menuDropDown.style.display == "none"){
//         menuDropDown.style.display = "block";
//         loginDropDown.style.display = "none";
//     }else{
//         menuDropDown.style.display = "none";
//     }
// }

$(function(){
    $(".login-nav-button").click(function(){
        $(".login-dropdown").fadeToggle(200);    
    });
    
    $(document).mouseup(function(e){ 
        if($(e.target).closest(".login-nav-button").length === 0){
            if ($(e.target).closest(".login-dropdown").length === 0){ 
                $(".login-dropdown").fadeOut(200); 
            } 
        }
    }); 
});


</script>
</html>