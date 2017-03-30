<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
include("config.php");
if($_SERVER["REQUEST_METHOD"] == "POST") {
  // Required field names

  $required = array('NFirst', 'NLast', 'ALine', 'PCode', 'Cit', 'Prov', 'Countr', 'PNumber', 'Emaili', 'DLicense', 'Paswd', 'CCard');
  // Loop over field names, make sure each one exists and is not empty
  $error = false;
  foreach($required as $field) {
    if(!isset($_POST[$field]) || empty($_POST[$field])) {
      echo 'You are missing '.$field.'<br />'; //Display error with field
      $error = true; //Yup there are errors
    }
  }
  $Membershipfee=30.00;

  if(!$error){
    $newemail = mysqli_real_escape_string($db,$_POST['Emaili']); 
    $sql = "SELECT Email FROM KTCS_Member WHERE Email = '$newemail'";
    $result = mysqli_query($db,$sql);

    if (!($result->num_rows===0)) {
      echo'Email has already been register please insert new email';
    }
    else{
      $sql = "SELECT MAX(MemberID) FROM KTCS_Member";
      $tresult = mysqli_query($db,$sql);
      // get the query result without the while loop
      $row = mysqli_fetch_array($tresult);
      $topidcount = $row['MAX(MemberID)']+1;
      $pas=$_POST['Paswd'];
      $hashAndSalt = password_hash($pas, PASSWORD_BCRYPT);

      $sql = "INSERT into KTCS_Member (MemberID,NameFirst,NameLast,AddressLine,PostalCode,Province,City,Country,PhoneNumber,Email,DriverLicense,Membershipfee,Password,Credit_Card) VALUES ('$topidcount','$_POST[NFirst]', '$_POST[NLast]', '$_POST[ALine]', '$_POST[PCode]', '$_POST[Prov]', '$_POST[Cit]', '$_POST[Countr]', '$_POST[PNumber]', '$_POST[Emaili]', '$_POST[DLicense]','$Membershipfee', '$hashAndSalt' , '$_POST[CCard]')";
      
      $quer=mysqli_query($db, $sql);
      if($quer){
        header("Location:login.php");
      }
      else{
        echo "Something went wrong";
      }
    }
  }
}
?>  
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;text-align: center; "><b>Register</b></div>
        
            <div style = "margin:10px">
               
               <form action = "" method = "post" >
                  <label>First Name:</label><input type = "text" name = "NFirst" class = "box"/><br /><br />
                  <label>Last Name:</label><input type = "text" name = "NLast" class = "box"/><br /><br />
                  <label>Address:</label><input type = "text" name = "ALine" class = "box"/><br /><br />
                  <label>Postal Code:</label><input type = "text" name = "PCode" class = "box"/><br /><br />
                  <label>City:</label><input type = "text" name = "Cit" class = "box"/><br /><br />
                  <label>Province:</label><input type = "text" name = "Prov" class = "box"/><br /><br />
                  <label>Country:</label><input type = "text" name = "Countr" class = "box"/><br /><br />
                  <label>Phone Number:</label><input type = "number" name = "PNumber" class = "box"/><br /><br />
                  <label>Email :</label><input type = "email" name = "Emaili" class = "box"/><br /><br />
                  <label>Driver License:</label><input type = "text" name = "DLicense" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "Paswd" class = "box" /><br/><br />
                  <label>Credit Card  :</label><input type = "number" name = "CCard" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit " class="buttonHolder" /><br />
               </form>
            </div>
            <h4 align ="center"><a href = "Login.php">Login</a></h4>
            
         </div>
      
      </div>
</body>
</html>