 <?php
//Include config file
require_once "conectdb.php";

//Define variables and initialize with empty values

$username = $password = $confirm_password=$email=$nume_client=$adresa="";
$username_err= $password_err = $confirm_password_err=$email_err=$nume_client_err=$adresa_err= "";

//Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//validate name
	if(empty(trim($_POST["client_nume"]))){
		$nume_client_err="Please enter your first name & last name.";
	}
	else{
		$sql="SELECT client_id FROM client WHERE client_nume=?";
		if($stmt = $mysqli->prepare($sql)){
			$stmt->bind_param("s", $param_nume_client);

			$param_nume_client=trim($_POST["client_nume"]);
			if($stmt->execute()){
				if($stmt->num_rows==1){
					$nume_client_err="This name is already used.";
				}
				else{
					$nume_client=trim($_POST["client_nume"]);
				}
			}else{
				echo "Oops! Something went wrong, please try again later.";
			}
		}
		$stmt -> close();
	}
	//validate username
	if(empty(trim($_POST["username"]))){
		$username_err= "Please enter a username.";
	} 
	else {
		//Prepare sql statement
		$sql ="SELECT client_id FROM client WHERE username=?";
		if($stmt= $mysqli->prepare($sql)){
			//Bind variables to the prepared statement as parameters
			$stmt->bind_param("s", $param_username);

			//Set parameters
			$param_username= trim($_POST["username"]);

			//Attempt to execute the prepared statement
			if($stmt->execute()){
				//store result
				if($stmt->num_rows == 1){
					$username_err= "This username is already taken.";
				}else {
					$username= trim($_POST["username"]);
				}
			}else{ 
				echo "Oops! Something went wrong. Please try again later.";
			}
		}

		$stmt->close();
	}
	//Validate password
	if(empty(trim($_POST["password"])))
	{
		$password_err = "Please enter a password.";
	}
	elseif (strlen(trim($_POST["password"]))<8)
	 {
		$password_err = "Password must have at least 8 characters.";
	}else
	{
		$password=trim($_POST["password"]);
	}

	//Validate confirm password
	if(empty(trim($_POST["confirm_password"])))
	{
		$confirm_password_err= "Please confirm password";
	}
	else
		{
			$confirm_password=trim($_POST["confirm_password"]);
			if(empty($password_err) && ($password != $confirm_password)){
				$confirm_password_err= "Password did not match.";
			}
		}

	//Validate email
	
	if(empty(trim($_POST["email"]))){
		$email_err= "Please enter your email adress.";
	} 
	else {
		//Prepare sql statement
		$sql ="SELECT client_id FROM client WHERE email=?";
		if($stmt= $mysqli->prepare($sql)){
			//Bind variables to the prepared statement as parameters
			$stmt->bind_param("s", $param_email);

			//Set parameters
			$param_email= trim($_POST["email"]);

			//Attempt to execute the prepared statement
			if($stmt->execute()){
				//store result
				if($stmt->num_rows == 1){
					$email_err= "This email is already used.";
				}else {
					$email= trim($_POST["email"]);
				}
			}else{ 
				echo "Oops! Something went wrong. Please try again later.";
			}
		}

		$stmt->close();
	}
	//validate adress
	if(empty(trim($_POST["adresa"]))){
		$adresa_err="Please enter your address.";
	}
	else{
		$sql="SELECT client_id FROM client WHERE adresa=?";
		if($stmt = $mysqli->prepare($sql)){
			$stmt->bind_param("s", $adresa);

			$param_adresa=trim($_POST["adresa"]);
			if($stmt->execute()){
				if($stmt->num_rows==1){
					$adresa_err="This address is already used.";
				}
				else{
					$address=trim($_POST["adresa"]);
				}
			}else{
				echo "Oops! Something went wrong, please try again later.";
			}
		}
		$stmt -> close();
	}


	//Check input errors before inserting in database

		if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($adresa_err)){

			//Prepare an insert statement
			$sql = "INSERT INTO client (username, password, email, adresa, client_nume) VALUES (?, ?, ?, ?, ?)";
			if($stmt = $mysqli->prepare($sql)){
				//Bind variables to the prepared statement as parameters
				$stmt->bind_param("sssss", $param_username, $param_password, $param_email, $param_adresa, $param_nume_client);

				//Set parameters
				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); //Creates a password hash
				$param_email = $email;
				$param_adresa = $adresa;
				$param_nume_client=$nume_client;
				// Atempt to execute the prepared statement
				if ($stmt->execute())
				{
					header ("location: logare.php");
				}else
				 {
					echo "Something went wrong. Please try again later.";
				}
			}
		
		//Close statement
			$stmt->close();

		}
		$mysqli->close();
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign up</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style.css">
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		body{font: 14px sans-serif;}
		.wrapper{width: 350px; padding: 20px;}
		div{margin: auto;}
	</style>
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
    echo "<a class='active' href='register.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Sign up</a>";
  }
  ?>
  <a href="cart.php" style="float: right;"><i class="fa fa-cart-plus" aria-hidden="true" ></i>Cart</a>
</div>
	<div style="border:4px ridge #53c9c7; border-radius: 4px; margin-top: 60px; margin-bottom: 20px; " class="wrapper">
		<img class="imglogo" src="logo.png">
		<h2 style="text-align: center; background-color: #555; color: white; padding: 4px; border-radius: 4px;">Sign up</h2>
		<p style="text-align: center; color: white;">Please fill this form to create an account</p><br>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<div class="form-group <?php echo (!empty($nume_client_err)) ? 'has-error' : '';?>">
				<label style="margin-left: 10px; color: white;">Enter your First name and Last name</label>
				<input type="text" name="client_nume" class="form-control" value="<?php echo $nume_client;?>">
				<span class="help-block"><?php echo $nume_client_err;?></span>
			</div>
			<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : '';?>">
				<label style="margin-left: 10px; color: white;">Username</label>
				<input type="text" name="username" class="form-control" value="<?php echo $username;?>">
				<span class="help-block"><?php echo $username_err;?></span>
			</div>
			<!--Pagina 7- la al 2lea div din HTML-->
			<div class="form-group <?php echo (!empty($password_err) )? 'has-error' :''; ?> ">
				<label style="margin-left: 10px; color: white;">Password</label>
				<input type="password" name="password" class="form-control" value="<?php echo $password;?>">
				<span class="help-block"><?php echo $password_err;?></span>
			</div>	
			<div class="form-group <?php (!empty($confirm_password_err)) ? 'has-error':'';?>">
				<label style="margin-left: 10px; color: white;">Confirm Password</label>
				<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password;?>">
				<span class="help-block"><?php echo $confirm_password_err;?></span>
			</div>
			<div class="form-group <?php (!empty($email_err)) ? 'has-error':'';?>">
				<label style="margin-left: 10px; color: white;">Email</label>
				<input type="email" name="email" class="form-control" value="<?php echo $email;?>">
				<span class="help-block"><?php echo $email_err;?></span>
			</div>
			<div class="form-group <?php echo (!empty($adresa_err)) ? 'has-error' : '';?>">
				<label style="margin-left: 10px; color: white;">Enter your address</label>
				<input type="text" name="adresa" class="form-control" placeholder="Strada, numarul, orasul, judetul, tara.." value="<?php echo $adresa;?>">
				<span class="help-block"><?php echo $adresa_err;?></span>
			</div>
			<div>
			<input type="submit" name="btn btn-primary" value="Submit">
			<input type="reset" name="btn btn-default" value= "Reset">
			</div>
			<br/><p style="color: white;">Already have an account? <a href="logare.php">Login here.</a></p>
		</form>
	</div>
</body>
</html>