<?php
/* session_start();
require_once '../php/api/config.inc.php';
require_once '../php/api/ASG2-classes.php';
include '../php/nav-header.php'
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// define("PRODUCTNAME", 1);

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : '';
$eventURL = isset($_SESSION['event_url_blackout']) ? $_SESSION['event_url_blackout'] : '';
$itemcount = isset($_SESSION['itemcount']) ? $_SESSION['itemcount'] : 0;
$strHTML = "";

if ($itemcount == 0)
{
   $strHTML = "<font class='noItem'>No Favourites added yet.  </font>";
   $imageSRC = 'favNEE';
}
else
{
   $strHTML = "<div style=\"overflow:auto; height=358px;\">"."\n";
   $strHTML .= "<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\"     width=\"100%\">"."\n";

   for ($i=0; $i<$itemcount; $i++)
   {
      $strHTML .= "<tr>"."\n";
      //needs to be replaced
      $strHTML .= "<td><a href='".$cart[PRODUCTNAME][$i]['savelink']."'     class='bewaardeItems'>".$cart[PRODUCTNAME][$i]['eventnaam']."</a></td>"."\n";
      $strHTML .= "</tr>"."\n";
   }

   $strHTML .= "</table>"."\n";
   $strHTML .= "</div>"."\n";
};

if ($eventURL == "favJA"){
    $imageSRC = 'favJA';
} else {
            $imageSRC = 'favNEE';
      }
//https://stackoverflow.com/questions/22621357/how-to-store-favorites-using-session */
require_once 'config.inc.php';
session_start();
if (isset($_SESSION['loggin']) && $_SESSION['loggin'] == true) {
   $userID = $_SESSION['id'];
}



try {
   $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $sql = "CREATE TABLE IF NOT EXISTS customer_fav (
         CustomerID INTEGER(50),
         PaintingID INTEGER(100),
         Title VARCHAR(255),
         PRIMARY KEY (CustomerID)
      ) ENGINE=innodb DEFAULT CHARSET=utf8";
   $pdo->exec($sql); // found from https://www.tutorialrepublic.com/php-tutorial/php-mysql-create-table.php
   //}  
   $sql = "SELECT *  from customer_fav INNER JOIN Paintings ON customer_fav.PaintingID = Paintings.PaintingID WHERE CustomerID= '" . $userID . "'";
   $result = $pdo->query($sql);
   $favorites = $result->fetchAll(PDO::FETCH_ASSOC);

   foreach ($favorites as $row) {
      $fileName = "images/paintings/square/" . $row['ImageFileName'];
      echo '<ul>';
      echo '<li>';
      echo '<a href="single-painting.php?PaintingID="' . $row['PaintingID'] . '"">';
      echo "'<img src='" . $fileName . ".jpg' width='100'>'";
      echo '<form method="post">';
      echo '<input type="submit" name="single" id="single">';
      echo '</form>';
      echo '</a>';
      echo '</li>';
      echo '</ul>';
   }

   if (array_key_exists('single', $_POST)) { //similar code from https://stackoverflow.com/questions/32824360/run-php-function-on-button-click
      removeSingle($userID, $pdo, $row['PaintingID']);
   }

   if (array_key_exists('all', $_POST)) {
      removeAll($userID, $pdo);
   }
} catch (Exception $e) {
   die($e->getMessage());
}
echo '<form method="post">';
echo '<input type="submit" name="all" id="all" value="Remove All Favorites">';
echo '</form>';

function addToFavorites($pdo, $userID,  $paintingID, $title)
{
   $sql = "INSERT INTO customer_fav (CustomerID, PaintingID, Title) VALUES (':CustomerID', ':PaintingID', ':Title')";
   $statement = $pdo->prepare($sql);
   $statement->bindValue(':CustomerID', $userID);
   $statement->bindValue(':PaintingID', $paintingID);
   $statement->bindValue(':Title', $title);
   $statement->execute();
}

function removeSingle($userID, $pdo, $paintingID)
{
   $sql = "DELETE from customer_fav WHERE CustomerID='" . $userID . "' AND PaintingID='" . $paintingID . "'"; //similar code from https://www.w3schools.com/php/php_mysql_delete.asp
   $pdo->exec($sql);
}

function removeAll($userID, $pdo)
{
   $sql = "DELETE from customer_fav WHERE CustomerID='" . $userID . "'";
   $pdo->exec($sql);
}
