<?php 
session_start();
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
//https://stackoverflow.com/questions/22621357/how-to-store-favorites-using-session
?>