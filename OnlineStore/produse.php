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
      'product_id'      =>  $_GET["produs_id"],
      'product_name'    =>  $_POST["hidden_name"],
      'product_price'   =>  $_POST["hidden_price"],
      'item_quantity'   =>  $_POST["cantitate"]
      );
      $_SESSION["shopping_cart"][$count] = $item_array;
    }
    else
    {
      echo '<script>alert("Item Already Added")</script>';
    }
  }
  else
  {
    $item_array = array(
       'product_id'     =>  $_GET["produs_id"],
      'product_name'      =>  $_POST["hidden_price"],
      'product_price'   =>  $_POST["hidden_price"],
      'item_quantity'   =>  $_POST["cantitate"]
    );
    $_SESSION["shopping_cart"][0] = $item_array;
  }
} 
?>


<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tech Store</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 	<link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
 	<link rel="stylesheet" type="text/css" href="style.css">
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body  style="background-image: url('backgr.jpg');">
	<div class="topnav" style=" background-image: url('coverr.jpg');">
		<span><img src="logo.png" width="200" height="200"></span>
		<span><input style="border:2px ridge #53c9c7;" type="text" placeholder="Search.."></span>
	</div>
	<div class="navbar">
  <a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
  <a href="produse.php" class="active" ><i class="fa fa-mobile" aria-hidden="true"></i> Products</a>
  <a href="contact.php"><i class="fa fa-fw fa-envelope"></i>Contact</a>
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
<br>
<div style="text-align: center; color: white; font-style: bold; font-size: 20px;">
  <?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
  {
    echo "Hello, ". htmlspecialchars($_SESSION["username"]). "! Welcome to Tech Store!";
  }
    ?>
</div>
<br>
<h2 style="color:  white; text-align: center; font-family: times new roman; font-style: bold;">Smartphone</h2>
<?php
        $query = "SELECT * FROM produse WHERE categorie_produs='Mobile' ORDER BY produs_id ASC";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_array($result))
          {
        ?>
      <div align="center" class="col-md-4">
        <form method="post" style="width: 340px; height: 550px;margin-top: 10px; margin-left: 1px; " action="cart.php?action=add&produs_id=<?php echo $row["produs_id"]; ?>">
          <div style="border:2px ridge #53c9c7; background-color:white; border-radius:10px; padding:16px; " align="center">
            <h4 class="text-info"><?php echo $row["produs_nume"]; ?></h4>
            <img src="Resurse\<?php echo $row["imagine"]; ?>" width=200px; height=200px; class="img-responsive" id="imgprod" /><br />
            <h4 class="text-danger"><?php echo $row["pret"]; ?> Lei</h4>
            <p ><?php echo $row["descriere"]; ?></p>
            <p style="color: red"><?php if ($row["cantitate"] > 2){ echo "Available";} else { echo  "This product is not available.";} ?></p>
            <p>Cantitate: <input type="text" name="cantitate" value="1"  /></p>

            <input type="hidden" name="hidden_name" value="<?php echo $row["produs_nume"]; ?>" />

            <input type="hidden" name="hidden_price" value="<?php echo $row["pret"]; ?>" />

            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

          </div>

        </form>

      </div>
      <?php
          }
        }
      ?>

      <!--A doua categorie de produse-->
      <h2 style="color:  white; text-align: center; font-family: times new roman; font-style: bold;">Laptop</h2>
<?php
        $query = "SELECT * FROM produse WHERE categorie_produs='Laptop' ORDER BY produs_id ASC";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_array($result))
          {
        ?>
      <div align="center" class="col-md-4">
        <form method="post" style="width: 340px; height: 550px; margin-top: 10px; margin-left: 1px;" action="cart.php?action=add&produs_id=<?php echo $row["produs_id"]; ?>">
          <div style="border:2px ridge #53c9c7; background-color:white; border-radius:10px; padding:16px;" align="center">
            

            <h4 class="text-info"><?php echo $row["produs_nume"]; ?></h4>
            <img src="Resurse\<?php echo $row["imagine"]; ?>" width=200px; height=200px; class="img-responsive" id="imgprod" /><br />
            <h4 class="text-danger"><?php echo $row["pret"]; ?> Lei</h4>
            <p style="height: 75px;"><?php echo $row["descriere"]; ?></p>
            <p style="color: red"><?php if ($row["cantitate"] > 2){ echo "Available";} else { echo  "This product is not available.";} ?></p>
            <p>Cantitate: <input type="text" name="cantitate" value="1"  /></p>

            <input type="hidden" name="hidden_name" value="<?php echo $row["produs_nume"]; ?>" />

            <input type="hidden" name="hidden_price" value="<?php echo $row["pret"]; ?>" />

            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

          </div>
        </form>
      </div>

      <?php
          }
        }
      ?>

      <!--A treia categorie de produse-->
      <h2 style="color:  white; text-align: center; font-family: times new roman; font-style: bold;">Tableta</h2>
<?php
        $query = "SELECT * FROM produse WHERE categorie_produs='Tableta' ORDER BY produs_id ASC";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_array($result))
          {
        ?>
      <div align="center" class="col-md-4">
        <form method="post" style="width: 340px; height: 550px;margin-top: 10px; margin-left: 1px;" action="cart.php?action=add&produs_id=<?php echo $row["produs_id"]; ?>">
          <div style="border:2px ridge #53c9c7; background-color:white; border-radius:10px; padding:16px;" align="center">
            

            <h4 class="text-info"><?php echo $row["produs_nume"]; ?></h4>
            <img src="Resurse\<?php echo $row["imagine"]; ?>" width=200px; height=200px; class="img-responsive" id="imgprod" /><br />
            <h4 class="text-danger"><?php echo $row["pret"]; ?> Lei</h4>
            <p ><?php echo $row["descriere"]; ?></p>
            <p style="color: red"><?php if ($row["cantitate"] > 2){ echo "Available";} else { echo  "This product is not available.";} ?></p>
            <p>Cantitate: <input type="text" name="cantitate" value="1"  /></p>

            <input type="hidden" name="hidden_name" value="<?php echo $row["produs_nume"]; ?>" />

            <input type="hidden" name="hidden_price" value="<?php echo $row["pret"]; ?>" />

            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

          </div>
          
        </form>

      </div>
      <?php
          }
        }
      ?>


      <!--Categoria Audio,Video-->

      <h2 style="color:  white; text-align: center; font-family: times new roman; font-style: bold;">TV & Audio</h2>
<?php
        $query = "SELECT * FROM produse WHERE categorie_produs='Tv' ORDER BY produs_id ASC";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_array($result))
          {
        ?>
      <div align="center" class="col-md-4">
        <form method="post" style="width: 340px; height: 550px;margin-top: 10px; margin-left: 1px; margin-bottom: 28px;" action="cart.php?action=add&produs_id=<?php echo $row["produs_id"]; ?>">
          <div style="border:2px ridge #53c9c7; background-color:white; border-radius:10px; padding:16px;" align="center">
            

            <h4 class="text-info" style="height: 40px;"><?php echo $row["produs_nume"]; ?></h4>
            <img src="Resurse\<?php echo $row["imagine"]; ?>" width=240px; height=200px; class="img-responsive" id="imgprod" /><br />
            <h4 class="text-danger"><?php echo $row["pret"]; ?> Lei</h4>
            <p ><?php echo $row["descriere"]; ?></p>
            <p style="color: red"><?php if ($row["cantitate"] > 2){ echo "Available";} else { echo  "This product is not available.";} ?></p>
            <p>Cantitate: <input type="text" name="cantitate" value="1"  /></p>

            <input type="hidden" name="hidden_name" value="<?php echo $row["produs_nume"]; ?>" />

            <input type="hidden" name="hidden_price" value="<?php echo $row["pret"]; ?>" />

            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

          </div>
          
        </form>

      </div>
      <?php
          }
        }
      ?>

      <!-- Accesorii PC & Gaming-->

      <h2 style="color:  white; text-align: center; font-family: times new roman; font-style: bold;">Accesorii PC & Gaming</h2>
<?php
        $query = "SELECT * FROM produse WHERE categorie_produs='Accesorii' ORDER BY produs_id ASC";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_array($result))
          {
        ?>
      <div align="center" class="col-md-4">
        <form method="post" style="width: 340px; height: 550px;margin-top: 10px; margin-left: 1px; margin-bottom: 28px;" action="cart.php?action=add&produs_id=<?php echo $row["produs_id"]; ?>">
          <div style="border:2px ridge #53c9c7; background-color:white; border-radius:10px; padding:16px;" align="center">
            

            <h4 class="text-info" style="height: 40px;"><?php echo $row["produs_nume"]; ?></h4>
            <img src="Resurse\<?php echo $row["imagine"]; ?>" width=240px; height=200px; class="img-responsive" id="imgprod" /><br />
            <h4 class="text-danger"><?php echo $row["pret"]; ?> Lei</h4>
            <p style="height: 35px;"><?php echo $row["descriere"]; ?></p>
            <p style="color: red"><?php if ($row["cantitate"] > 2){ echo "Available";} else { echo  "This product is not available.";} ?></p>
            <p>Cantitate: <input type="text" name="cantitate" value="1"  /></p>

            <input type="hidden" name="hidden_name" value="<?php echo $row["produs_nume"]; ?>" />

            <input type="hidden" name="hidden_price" value="<?php echo $row["pret"]; ?>" />

            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

          </div>
          
        </form>

      </div>
      <?php
          }
        }
      ?>

</body>
</html>