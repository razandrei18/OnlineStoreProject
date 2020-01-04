<?php
require_once('conectdb.php');
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
  <a href="produse.php"><i class="fa fa-mobile" aria-hidden="true"></i> Produse</a>
  <a href="contact.php"><i class="fa fa-fw fa-envelope"></i> Contact</a>
  <?php
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
  {
    echo "<a href='logout.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Logout</a>";
    echo "<a href='resetpassword.php' style='float: right;'><i  class='fa fa-check-square-o' aria-hidden='true'></i> Resset Password</a>";

  }
  else{
    echo "<a class='active' href='logare.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Login</a>";
    echo "<a href='register.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Sign up</a>";
  }
  ?>
  <a href="cart.php" style="float: right;"><i class="fa fa-cart-plus" aria-hidden="true" ></i>Cart</a>
</div>
<?php
$searchvalue='';
$error='';
if(!empty($_POST['search']))
			{
				if(isset($_POST['searchbtn']))
				{
					$searchvalue = $_POST['search'];
				}
			}
			else
			{
				echo "Please insert a search term";
			}
			if($result=$mysqli->query("SELECT * FROM produse WHERE produs_nume LIKE '%".$searchvalue."%'"))
			{
				if($result->num_rows > 0)
				{
					while($row = $result->fetch_object())
					{
					?>
					 <div align="center" class="col-md-4">
        			<form method="post" style="width: 340px; height: 500px;margin-top: 10px; margin-left: 1px; " action="cart.php?action=add&produs_id=<?php echo $row["produs_id"]; ?>">
          			<div style="border:2px ridge #53c9c7; background-color:white; border-radius:10px; padding:16px; " align="center">
            		<h4 class="text-info"><?php echo $row["produs_nume"]; ?></h4>
            		<img src="Resurse\<?php echo $row["imagine"]; ?>" width=200px; height=200px; class="img-responsive" id="imgprod" /><br />
            		<h4 class="text-danger"><?php echo $row["pret"]; ?> Lei</h4>
            		<p ><?php echo $row["descriere"]; ?></p>

           			 <p>Cantitate: <input type="text" name="cantitate" value="1"  /></p>

           			 <input type="hidden" name="hidden_name" value="<?php echo $row["produs_nume"]; ?>" />

            		<input type="hidden" name="hidden_price" value="<?php echo $row["pret"]; ?>" />

            		<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

         		 </div>

        		</form>

     		 </div>
					<?php
					}
					?>
				<?php
				}
				else
				{
					echo "No product found.";
				}
			}
			else
			{
				echo "Error:".$mysqli->error();
			}
		$mysqli->close();
			?>
</body>
</html>