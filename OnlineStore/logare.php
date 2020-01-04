<?php
// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
{
	header("location:index.php");
	exit;
}

require_once "conectdb.php";

$username=$password="";
$username_err=$password_err="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
	if(empty(trim($_POST["username"]))){
		$username_err="Please enter username";
	}
	else{
		$username= trim($_POST["username"]);
	}
	if(empty(trim($_POST["password"]))){
		$password_err= "Please enter your password";
	}
	else{
		$password=trim($_POST["password"]);
	}
	if(empty($username_err) && empty($password_err)){
		$sql="SELECT client_id, username, password FROM client WHERE username=?";
		if($stmt = $mysqli ->prepare($sql)){
			// Bind variables to the prepared statement as parameters
			$stmt->bind_param("s", $param_username);
			//Set parameters
			$param_username=$username;

			if($stmt->execute()){
				//Store result
				$stmt->store_result();

				//Check if username exists, if yes then verify password
				if($stmt->num_rows==1)
				{
					$stmt->bind_result($id, $username, $hashed_password);
					if($stmt->fetch()){
						if(password_verify($password, $hashed_password)){
							session_start();

							//Store data in session variables
							$_SESSION["loggedin"]=true;
							$_SESSION["client_id"]=$id;
							$_SESSION["username"]=$username;

							if($_SESSION["username"]=="admin"){
							//Redirect user to welcome page
							header("location:adminpage.html");
						} else{
							header("location:index.php");
						}
						}
						else{
							// Display an error message if password is not valid
							$password_err="The password you entered was not valid";
						}
					}
					}	else{
							//Display an error message if username doesn't exist
							$username_err="No account found with that username.";
						}
						} else{
							echo "Oops! Something went wrong. Please try again later.";
						}
					}
					//Close statement
					$stmt->close();
				}
				//Close connection
				$mysqli->close();
			}
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
    echo "<a class='active' href='logare.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Login</a>";
    echo "<a href='register.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Sign up</a>";
  }
  ?>
  <a href="cart.php" style="float: right;"><i class="fa fa-cart-plus" aria-hidden="true" ></i>Cart</a>
</div>
	<br/><div style="border:4px ridge #53c9c7; border-radius: 4px; margin-top: 30px; margin-bottom: 20px;" class="wrapper">
		<img class="imglogo" src="logo.png">
		<h2 style="text-align: center; background-color: #555; color: white; padding: 4px; border-radius: 4px;">Login</h2>
		<p style="text-align: center; color: white;">Please fill in your credetials to login.</p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
			<!-- pagina 4 in HTML -->
			<div id="divid" class="form-group <?php echo(!empty($username_err))? 'has-error' : '';?> ">
				<label  style="margin-left: 10px; color: white;">Username</label>
				<input type="text" name="username" class="form-control" value="<?php echo $username;?>">
				<span class="help-block"><?php echo $username_err;?></span>
			</div>
			<div class="form-group <?php echo (!empty($password_err))? 'has-error' : '';?>">
				<label style="margin-left: 10px; color: white;">Password</label>
				<input type="password" name="password" class="form-control">
				<span class="help-block"><?php echo $password_err; ?></span>
			</div>
			<div class="form-group">
				<input style="background-color: #555;"  type="submit" class="btn btn-primary" value="Login">
			</div>
			<p style="color: white;">Don't have an account? <a href="register.php">Sign up now</p>
		</form>
	</div>
</body>
</html>