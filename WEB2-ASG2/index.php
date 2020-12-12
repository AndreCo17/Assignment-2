<?php
session_start();

require_once 'api/config.inc.php';
require_once 'api/ASG2-classes.php';
include 'logout-header.php';



try {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * from CustomerLogon WHERE UserName= '" . $_POST['email'] . "'";
        $result = $pdo->query($sql);
        $row = $result->fetch();

        if (isset($row) && count($row) > 0) {

            $customerSalt = $row['Salt'];
            echo $customerSalt;
            echo $_POST['password'];
            $_SESSION['email'] = $row['UserName'];


            $digest = password_hash($_POST['password'], PASSWORD_BCRYPT, array("cost" => 12, "salt" => $customerSalt));

            if (password_verify($_POST['password'], $digest)) { //from https://www.php.net/manual/en/function.password-verify.php

                //session_start();
                echo 'Login successful';
                $_SESSION["loggin"] = true;
                $_SESSION["email"] = $row['UserName'];
                $_SESSION["id"] = $row['CustomerID'];
                header("location: home.php");
            }
        }
    }
    $pdo = null;
} catch (Exception $e) {
    die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang=en>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/notLogged.css">
</head>

<body>
    <main>
        <div>
            <form class="login" method="post" action="">
                <h3>Login</h3>
                <div class="loginEmail">
                    <label for="email">email</label></br>
                    <input type="email" placeholder="Enter Email" name="email" required>
                </div>
                <div class="loginPass">
                    <label for="password">password</label></br>
                    <input type="password" placeholder="Enter password" name="password" required>
                </div>
                <button type="submit">Login</button>
                <div>
                    <form method="post" class="searchBar">
                        <a class="browse" href="browse-paintings.php"><input type="text" placeholder="Search a painting" name="search" /></a>
                </div>
            </form>
        </div>
    </main>
</body>

</html>