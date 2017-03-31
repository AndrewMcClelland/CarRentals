<?php
   include('config.php');
   // Need to confirm if admin or user
   if ($_SESSION["isAdmin"] == "FALSE")
   {
     if(!isset($_SESSION['login_user'])){
        header("location:login.php");
     }
   }
   else
   {
     // Is admin
     if(!isset($_SESSION['adminCode'])){
        header("location:login.php");
     }
   }
?>
