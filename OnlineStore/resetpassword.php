<?php 
 // Initialize the session
session_start();
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
 header("location: login.php");
 exit;
}
// Include config file
require_once "conectdb.php";
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 // Validate new password
 if(empty(trim($_POST["new_password"]))){
 $new_password_err = "Please enter the new password.";
 } elseif(strlen(trim($_POST["new_password"])) < 6){
 $new_password_err = "Password must have atleast 6 characters.";
 } else{
 $new_password = trim($_POST["new_password"]);
 }

 // Validate confirm password
 if(empty(trim($_POST["confirm_password"]))){
 $confirm_password_err = "Please confirm the password.";
 } else{
 $confirm_password = trim($_POST["confirm_password"]);
 if(empty($new_password_err) && ($new_password != $confirm_password)){
 $confirm_password_err = "Password did not match.";
 }
 }
 
 // Check input errors before updating the database
 if(empty($new_password_err) && empty($confirm_password_err)){
 // Prepare an update statement
 $sql = "UPDATE client SET password = ? WHERE client_id = ?";

 if($stmt = $mysqli->prepare($sql)){
 // Bind variables to the prepared statement as parameters
 $stmt->bind_param("si", $param_password, $param_id);

 // Set parameters
 $param_password = password_hash($new_password, PASSWORD_DEFAULT);
 $param_id = $_SESSION["client_id"];

 // Attempt to execute the prepared statement
 if($stmt->execute()){
 // Password updated successfully. Destroy the session, and redirect to login page
 session_destroy();
 header("location: logare.php");
 exit();
 } else{
 echo "Oops! Something went wrong. Please try again later.";
 }
 }

 // Close statement
 $stmt->close();
 }

 // Close connection
 $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Tech Store</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
 	<link rel="stylesheet" type="text/css" href="style.css">
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
	body{font: 14px sans-serif;}
	div{margin: auto; }
	.wrapper{ width: 350px; padding:20px; }		
	</style>
</head>
<body style="background-image: url('backgr.jpg');">
 
 <!--Codul pentru header-->
<div class="topnav" style=" background-image: url('coverr.jpg');">
		<span><img src="logo.png" width="200" height="200"></span>
		<span><input style="border:2px ridge #53c9c7;" type="text" placeholder="Search.."></span>
	</div>
	<div class="navbar">
  <a  href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
  <a href="produse.php"><i class="fa fa-mobile" aria-hidden="true"></i> Products</a>
  <a href="contact.php"><i class="fa fa-fw fa-envelope"></i> Contact</a>
  <?php
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
  {
    echo "<a href='logout.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Logout</a>";
  }
  else{
    echo "<a href='logare.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Login</a>";
  }
  ?>
  <?php
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
  {
    echo "<a class='active' href='resetpassword.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Resset Password</a>";
  }
  else{
    echo "<a href='register.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Sign up</a>";
  }
  ?>
  <a href="cart.php" style="float: right;"><i class="fa fa-cart-plus" aria-hidden="true" ></i>Cart</a>
</div>
<br/>
<div style="text-align: center; color: white; font-style: bold; font-size: 20px;">
  <?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
  {
    echo "Hello, ". htmlspecialchars($_SESSION["username"]). "! Welcome to Tech Store!";
  }
    ?>
</div>

 <div style="border:4px ridge #53c9c7; border-radius: 4px; margin-top: 60px;" class="wrapper">
 	<img class="imglogo" src="logo.png">
 <h2 style="text-align: center; background-color: #555; color: white; padding: 4px; border-radius: 4px;">Reset Password</h2>
 <p style="text-align: center; color: white;">Please fill out this form to reset your password.</p>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
 <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
 <label style="margin-left: 10px; color: white;">New Password</label>
 <input type="password" name="new_password" class="form-control" value="<?php echo
$new_password; ?>">
 <span class="help-block"><?php echo $new_password_err; ?></span>
 </div>
 <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
 <label style="margin-left: 10px; color: white;">Confirm Password</label>
 <input type="password" name="confirm_password" class="form-control">
 <span class="help-block"><?php echo $confirm_password_err; ?></span>
 </div>
 <div class="form-group">
 <input style="background-color: #555;" type="submit" class="btn btn-primary" value="Submit">
 <a class="btn btn-link" href="welcome.php" style="color: white;">Cancel</a>
 </div>
 </form>
 </div>
</body>
</html>