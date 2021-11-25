<!DOCTYPE html>
<html lang="en">


<?php
require_once 'includes/databaseHandler.inc.php';
require_once 'includes/functions.inc.php';

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--link to ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--link to css-->
    <link rel="stylesheet" href="header&footer.css">


    <!--link font-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!--link bootsrap CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!--link to jquery-->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script> -->
    <!--link for back to top-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <title>Fanciado Foodo</title>
</head>

<body>
    <div class="header">
        <div class="container">
            <!--navigation bar-->
            <div class="navbar">
                <div class="logo">
                    <img src="images/logo/logo.png" class="logo" alt="error logo image">
                </div>
                <nav>
                    <ul id="menuitems">
                        <?php
                        if (isset($_SESSION["userEmail"])) {
                            echo "<li><a href='coinLog.php' style='padding:5px 10px;border: 2px double white;'>" . checkCoinBalance($conn, $_SESSION["userEmail"]) . " coin(s) </a></li>";
                        }
                        ?>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="product.php">Products</a></li>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="wishlist.php">Wishlist</a></li>
                        <li><a href="bidding.php">Bidding</a></li>

                        <?php
                        if (isset($_SESSION["userEmail"])) {
                            echo "<li><a href='user_profile.php'>Profile</a></li>";
                            echo "<li><a href='includes/logout.inc.php'>Log out</a></li>";
                            //echo "<li>". include_once 'notification.php'."</li>";

                            include_once 'notification.php';
                        } else {
                            echo "<li><a href='login.php'>Log in</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
                <a href="verifier.php"><img src="images/images/cart.png" width="30px" height="30px" alt=""></a>
                <img src="images/images/menu.png" class="menu-icon" onclick="toggleMenu()">
            </div>

            <!--back to top-->
            <a id="button"></a>