<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = $_POST['passwd']; 

      $sql = "SELECT Password FROM Admin WHERE Email = '$myusername'";

      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['Password'];
      $count = mysqli_num_rows($result);

      if($count == 1) {
         if ($mypassword==$active) {
             //Verified
            $_SESSION['login_user'] = $myusername;
            header("location: adminHomePage.php");
         }
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<html>
   
   <head>
      <title>Admin Login</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         
         .box {
            border:#666666 solid 1px;
         }

      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;text-align: center; "><b>KTCS Admin Login</b></div>
				
            <div style = "margin:10px">
               
               <form action = "" method = "post" >
                  <label>Email :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password :</label><input type = "password" name = "passwd" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit " class="buttonHolder" /><br />
               </form>
            </div>
            <h4 align ="center"><a href = "Login.php">User Sign In</a></h4>
         </div>
			
      </div>

   </body>
</html>