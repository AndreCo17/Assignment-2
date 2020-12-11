<?php 
session_start();
if(session_destroy()) {
    header("Location: index.php");
}//similar code found on https://stackoverflow.com/questions/3512507/proper-way-to-logout-from-a-session-in-php/3512570
?>