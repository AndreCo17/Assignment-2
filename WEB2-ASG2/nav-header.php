<?php
require_once 'api/config.inc.php';
require_once 'api/ASG2-classes.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ASG 2</title>
    <link rel="stylesheet" href="css/nav.css">
</head>

<body>
    <header>
        <!-- Top Navigation Menu -->
        <div class="topnav small">
            <a href="#home" class="active"></a>
            <!-- Navigation links (hidden by default) -->
            <img id="logo" src="images/logo.jpg">
            <ul class="links">
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="galleries.php">Galleries</a></li>
                <li><a href="browse-paintings.php">Browse</a></li>
                <li><a class="logged-in" href="favorites.php">Favorites</a></li> <!-- only available when logged in -->
                <li><a class="logged-in" href="logout.php">Logout</a></li>
                <li><a class="logged-out" href="logout.php">Login</a></li>
            </ul>

            <!-- "Hamburger menu" to toggle the navigation links -->
            <div class="hamIcon" id="hamIcon">
                <h1>&#9776;</h1>
            </div>
        </div>
    </header>
    <script src="js/nav.js"> </script>

</html>