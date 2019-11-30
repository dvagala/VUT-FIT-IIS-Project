
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/header-style.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"> 
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <script src="vendor/jquery-3.4.1.js"></script>

    <title>Document</title>
</head>
<body>
    <div class="main-page-container">
        <div class="main-header">
            <p><a href="index.php">Food delivery</a></p>

            <?php session_start();

            include "dbConnect.php";

            if(!isset($_COOKIE["userId"]) && !isset($_SESSION["userId"])){
                $pdo->query("INSERT INTO person (state) VALUES (\"unregistered\");");
                setcookie("userId", $pdo->lastInsertId(), time() + (10 * 365 * 24 * 60 * 60));
            } ?>

            <div class="header-nav">
                <?php if(!isset($_SESSION["userId"])){?>
                    <a class="login-nav-link" href="#">Login</a>
                    <a href="signUpPage.php">Sign up</a>
                <?php } ?>

                <a class="menu-nav-link"  href="#">Menu</a>
            </div>
                <div class="login-dropdown">
                    <form class="login-form" action="processLogin.php" method="post">
                         <input type="email" name="userEmail" placeholder="Email" class="display-block" required value=
                         <?php echo "\"";
                            if(isset($_GET["userEmail"])) {
                                echo $_GET["userEmail"];
                            }
                            echo "\""; ?>>
                         <input type="password" name="userPassword" placeholder="Password" required class="display-block">
                        <button class="login-form-button">Login</button>
                        <?php if(isset($_GET['loginError'])){ ?>
                                <style>
                                    .login-dropdown{
                                        display: block ; 
                                    }
                                </style>

                            <?php if($_GET['loginError'] == "wrongEmail"){ ?>
                                <label class="error-label">Wrong email!</label>
                            <?php }
                            if($_GET['loginError'] == "wrongPassword"){ ?>
                                <label class="error-label">Wrong password!</label>
                            <?php }
                        } ?>
                    </form>
                </div>
                <div class="menu-dropdown">
                    <ul>
                        <li><a href="myOrders.php">My orders</a></li>
                        <?php if(isset($_SESSION["userId"])){
                            include "dbConnect.php";
                            $state = $pdo->query("SELECT state FROM person WHERE personId={$_SESSION['userId']}")->fetchAll(PDO::FETCH_ASSOC);
                            $state = $state[0]['state'];?>

                            <li><a href="myProfile.php">My profile</a></li>
                            <?php if($state=='driver' or $state=='admin'){?>
                            <li><a href="manageOrders.php">Manage orders</a></li>
                            <?php }if($state=='operator' or $state=='admin'){?>
                            <li><a href="manageDrivers.php">Manage drivers</a></li>
                            <?php }if($state=='admin'){?>
                            <li><a href="manageUsers.php">Manage users</a></li>
                            <?php } ?>
                            <li><a href="processLogout.php">Logout</a></li>
                        <?php } ?>
                    </ul>
                </div>
        </div>
    </div>
</body>

<script>

$(function(){

    $(".login-nav-link").click(function(){
        $(".login-dropdown").fadeToggle(200);    
    });
    
    $(".menu-nav-link").click(function(){
        $(".menu-dropdown").fadeToggle(200);    
    });

    $(document).mousedown(function(e){ 
        if($(e.target).closest(".login-nav-link").length === 0){
            if ($(e.target).closest(".login-dropdown").length === 0){ 

                // To remove any login errors from url and refresh page
                <?php if(isset($_GET['loginError'])){?>
                    var urlParams = window.location.search;
                    var modedUrlParams = urlParams.replace(/\&?loginError=(wrongEmail|wrongPassword)/g, "");
                    modedUrlParams = modedUrlParams.replace(/\&?userEmail=[^&]*/g, "");

                    location.href = window.location.pathname + modedUrlParams;
                <?php }
                else { ?>
                    $(".login-dropdown").fadeOut(200); 
                <?php } ?>
            } 
        }
        
        if($(e.target).closest(".menu-nav-link").length === 0){
            if ($(e.target).closest(".menu-dropdown").length === 0){ 
                $(".menu-dropdown").fadeOut(200); 
            } 
        }
    }); 
});

</script>
</html>