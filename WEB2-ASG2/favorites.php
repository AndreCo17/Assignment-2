<?php 

require_once './api/config.inc.php';
session_start();

if(isset($_SESSION['loggin']) && $_SESSION['loggin'] == true) {
   $paintingID = $_GET['paintingID'];
   $file = '';
   $title = '';
   
   $_SESSION['favorite'] = array();
   $userID = $_SESSION['id'];
   
      array_push($_SESSION['favorite'], $paintingID);
   //}

   if(isset($_SESSION['Title'])) {
      $title = $_SESSION['Title'];
      array_push($_SESSION['favorite'], $title);
   }

   if(isset($_SESSION['file'])){
      $file = $_SESSION['file'];
      array_push($_SESSION['favorite'], $file);
   }
   
   
   array_push($_SESSION['favorite'], $userID, $title, $file); //from favorites.php line72 https://www.plus2net.com/php_tutorial/array-session.php
   
   if(isset($_SESSION['favorited'])) {
      if($_SESSION['favorited'] == true) {
         
         $_SESSION['favorites'] = array();
         
         array_push($_SESSION['favorites'], $_SESSION['favorite']);
         $pageID = $paintingID;
         $page = 'single-painting.php?paintingID=' . $_GET['paintingID'];
         
         header("location:" .$page);
      }
   }

   if(isset($_SESSION['favorites'])) {
      if(count($_SESSION['favorites']) == 0) {
         echo '<p> Favorites are empty </p>';
      } else {
         foreach($_SESSION['favorites'] as $favorites){
            foreach($_SESSION['favorite'] as $favorite) {
               $fileName = "images/paintings/square/" . $favorite['ImageFileName'];
               echo '<ul>';
               echo '<li>';
               echo '<a href="single-painting.php?PaintingID="'.$favorite['PaintingID'].'"">';
               echo "'<img src='" .$fileName.".jpg' width='100'>'"; 
               echo '<form method="post">';
               echo '<input type="submit" name="single" id="single">';
               echo '</form>';
               echo '</a>';
               echo '</li>';
               echo '</ul>';
   
               if(isset($_POST['single'])) {
                  unset($_SESSION['favorites'][$favorite]);
               }
            }
         }
      }
   
   }




}
?>