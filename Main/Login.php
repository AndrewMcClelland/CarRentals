<?php
   include("config.php");

  if($_SERVER["REQUEST_METHOD"] == "POST") {
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = $_POST['passwd'];
      // Check to see if logging in as user or as Admin
      $adminCodeVar = "FALSE";
      $adminCodeValue = $_POST["adminCode"];
      if (empty($_POST["adminCode"]) == false)
      {
        $sql = "SELECT `AdminCode`, `Email`, `Password` FROM `Admin` WHERE `AdminCode`='$adminCodeValue' and `Email`='$myusername' and `Password`='$mypassword'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if($count == 1)
        {
            // Verified
            $_SESSION["isAdmin"] = "TRUE";
            $_SESSION["adminCode"] = $adminCodeValue;
            $_SESSION["adminEmail"] = $row["Email"];
            header("location: adminHomePage.php");
          }
          else
          {
            $error = "Your Login Name or Password is invalid";
          }
      }
      else
      {
        $sql = "SELECT * FROM KTCS_Member WHERE Email = '$myusername'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $active = $row['Password'];
        $fName = $row['NameFirst'];
        $memberIDVal = $row['MemberID'];
        $count = mysqli_num_rows($result);
        if($count == 1) {
          if (password_verify($mypassword, $active)) {
              // Verified
              $_SESSION['login_user'] = $myusername;
              $_SESSION["memberID"] = $memberIDVal;
              $_SESSION["firstName"] = $fName;
              $_SESSION["isAdmin"] = $adminCodeVar;
              header("location: homepageform.php");
            }
          }
          else {
            $error = "Your Login Name or Password is invalid";
            echo $error;
          }
      }
  }
   else {
  }
?>
<html>

   <head>
      <title>Login</title>

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
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;text-align: center; "><b>KTCS Login</b></div>

            <div style = "margin:10px">

               <form action = "" method = "POST" >
                  <label>Email    :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "passwd" class = "box" /><br/><br />
                  <label> Admin Code: </label><input type="adminCode" name="adminCode" class = "box" /><br /><br />
                  <input type = "submit" value = " Submit " class="buttonHolder" /><br />
               </form>
            </div>
            <h4 align ="center"><a href = "Register.php">Register</a></h4>

         </div>

      </div>

   </body>
</html>
