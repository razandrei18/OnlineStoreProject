<?php 
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tech Store</title>
 	<link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
 	<link rel="stylesheet" type="text/css" href="style.css">
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 	<link rel="stylesheet" type="text/css" href="slidestyle.css">
</head>
<body style="background-image: url('backgr.jpg');">
	<div class="topnav" style=" background-image: url('coverr.jpg');">
		<span><img src="logo.png" width="200" height="200"></span>
		<span><input style="border:2px ridge #53c9c7;" type="text" placeholder="Search.."></span>
	</div>
	<div class="navbar">
  <a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
  <a href="produse.php"><i class="fa fa-mobile" aria-hidden="true"></i> Products</a>
  <a href="contact.php" class="active"><i class="fa fa-fw fa-envelope"></i> Contact</a>
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
    echo "<a href='resetpassword.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Resset Password</a>";
  }
  else{
    echo "<a href='register.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Sign up</a>";
  }
  ?>
  <a href="cart.php" style="float: right;"><i class="fa fa-cart-plus" aria-hidden="true" ></i>Cart</a>
</div>
<div style="text-align: center; color: white; font-style: bold; font-size: 20px;">
  <?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
  {
    echo "Hello, ". htmlspecialchars($_SESSION["username"]). "! Welcome to Tech Store!";
  }
    ?>
</div>
<br>
<div >
	<form  action="mail.php" style="color: white; text-align: center; margin-top: 20px;" method="post">
		<strong>Numele dvs. :</strong><br>
		<br>
		<input style="width: 250px;" type="text" name="nume"><br>
		<br>
		<strong>Adresa de email:</strong> <br>
		<br>
		<input style="width: 250px;" type="email" name="email"><br>
		<br>
		<strong>Mesajul dvs. :</strong><br>
		<br>
		<textarea name="message" style="width: 250px; height: 60px;"></textarea><br>
		<br>
		<button style="background-color: #4CAF50; color: white; padding: 8px; text-align: center; width: 80px;" type="submit" name="send_message_btn">Send</button>
	</form>
</div>
</body>
</html>