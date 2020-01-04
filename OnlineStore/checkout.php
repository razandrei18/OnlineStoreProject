<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
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
    echo "<a href='resetpassword.php' style='float: right;'><i  class='fa fa-check-square-o' aria-hidden='true'></i> Resset Password</a>";

  }
  else{
    echo "<a href='logare.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Login</a>";
    echo "<a href='register.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Sign up</a>";
  }
  ?>
  <a class='active' href="cart.php" style="float: right;"><i class="fa fa-cart-plus" aria-hidden="true" ></i>Cart</a>
</div>
	<?php
	if(empty($_SESSION["shopping_cart"]))
	{
		echo "<h3 style='text-align: center; color: white'> The cart is empty! Please go back and add some products to cart..</h3>";
	}
	else
	{
	?>
	<form  style="margin-left: 70px; color: white; font-size: 20px; margin-top: 50px;">
	<strong>Numele dumneavoastra: </strong><br>
	<input style="width: 300px; color: black;" type="text" name="numeclient" required="true"><br>
	<br>
	<strong>Adresa de email: </strong><br>
	<input style="width: 300px; color: black;"type="email" name="emailclient" required="true"><br>
	<br>
	<strong>Adresa de livrare: </strong><br>
	<input style="width: 300px; color: black;" type="text" name="adresaclient" placeholder="Strada, Numar, Bloc, Ap., Oras, Judet.." required="true"><br>
	<br>
	<br>
	<strong>Metoda de plata: </strong><br>
	<input type="radio" name="plata" value="ramburs"> Ramburs la livrare<br>
	<input type="radio" name="plata" value="card"> Card<br>
	<br>

	<button  type="submit" name="placeorder" style="margin-top:16px; background-color: #4CAF50; border: none; color: white; padding: 12px 28px; text-decoration: none; display: block; font-size: 20px; border-radius: 12px;">Place Order</button>
	</form>
	<?php
	}
	?>
</body>
</html>