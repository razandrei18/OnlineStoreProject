<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "storedb");

if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "produs_id");
		if(!in_array($_GET["produs_id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'product_id'			=>	$_GET["produs_id"],
			'product_name'			=>	$_POST["hidden_name"],
			'product_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["cantitate"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
			echo '<script>window.location="cart.php"</script>';
		}
		else
		{
			echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
			'product_id'			=>	$_GET["produs_id"],
			'product_name'			=>	$_POST["hidden_name"],
			'product_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["cantitate"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["product_id"] == $_GET["produs_id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="cart.php"</script>';
			}
		}
	}
}?>
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
    echo "<a href='resetpassword.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Resset Password</a>";
  }
  else{
    echo "<a href='register.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Sign up</a>";
  }
  ?>
  <a class="active" href="cart.php" style="float: right;"><i class="fa fa-cart-plus" aria-hidden="true" ></i>Cart</a>
</div>
<div style="text-align: center; color: white; font-style: bold; font-size: 20px;">
  <?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
  {
    echo "Hello, ". htmlspecialchars($_SESSION["username"]). "! Welcome to Tech Store!";
  }
    ?>
</div>
<div  style="clear:both"></div>
			<br />
			<h3 style="color: white; text-align: center;">Order Details</h3>
			<br/>
			<div style="margin-left: 20px;">
				<table style="background-color: #555555">
					<tr>
						<th width="40%" style="color: white; border:2px solid;">Item Name</th>
						<th width="10%" style="color: white; border:2px solid;">Quantity</th>
						<th width="20%" style="color: white; border:2px solid;">Price</th>
						<th width="15%" style="color: white; border:2px solid; ">Total</th>
						<th width="5%" style="color: white; border:2px solid;">Action</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td style="color: white; border:2px solid;  text-align: center;"><?php echo $values["product_name"]; ?></td>
						<td style="color: white; border:2px solid;  text-align: center;"><?php echo $values["item_quantity"]; ?></td>
						<td style="color: white; border:2px solid;  text-align: center;"><?php echo $values["product_price"]; ?> Lei</td>
						<td style="color: white; border:2px solid;  text-align: center;"> <?php echo number_format($values["item_quantity"] * $values["product_price"], 2);?></td>
						<td ><a style="color: white; " href="cart.php?action=delete&produs_id=<?php echo $values["product_id"]; ?>"><span>Remove</span></a></td>
					</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["product_price"]);
						}
					?>
					<tr>

						<th style="color: white; background-color: #4CAF50; border:2px solid; font-size: 20px; font-style: italic;"  colspan="3" align="right">Total</td>
						<td style="color: white; background-color: #4CAF50; border:2px solid; font-size: 20px; font-style: italic;" align="center"> <?php echo number_format($total, 2); ?> Lei</td>
						<td></td>
					</tr>
					<?php
					}
					?>
						
				</table>
				 <button  type="submit" name="checkout" style="margin-top:25px; background-color: #4CAF50; border: none; color: white; padding: 12px 28px; text-align: center; text-decoration: none; display: block; font-size: 20px; border-radius: 12px; float: right; margin-right: 180px;"><a style="text-decoration: none; color: white;" href="checkout.php">Checkout</a></button>
			</div>
			
		</div>
	</body>