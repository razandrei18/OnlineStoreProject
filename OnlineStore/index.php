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
    <form action="searchpage.php" method="post">
		<span><img src="logo.png" width="200" height="200"></span>
		<span><input name="search" style="border:2px ridge #53c9c7;" type="text" placeholder="Search.."></span>
    <!-- <span><input name="searchbtn" type="submit" value="Search"></span> -->
  </form>

	</div>
	<div class="navbar">
  <a class="active" href="#"><i class="fa fa-fw fa-home"></i> Home</a>
  <a href="produse.php"><i class="fa fa-mobile" aria-hidden="true"></i> Products</a>
  <a href="contact.php"><i class="fa fa-fw fa-envelope"></i> Contact</a>
   <?php
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
  {
    echo "<a href='logout.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Logout</a>";
    echo "<a href='resetpassword.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Resset Password</a>";

  }
  else{
    echo "<a href='logare.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Login</a>";
    echo "<a href='register.php' style='float: right;'><i class='fa fa-check-square-o' aria-hidden='true'></i> Sign up</a>";
  }
  ?>
  <a href="cart.php" style="float: right;"><i class="fa fa-cart-plus" aria-hidden="true" ></i>Cart</a>
</div >
<div style="text-align: center; color: white; font-style: bold; font-size: 20px;">
<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
  {
    echo "Hello, ". htmlspecialchars($_SESSION["username"]). "! Welcome to Tech Store!";
  }
    ?>
</div>
<div>
	<p style="text-align: center; color: white; font-style: bold; font-family: times new roman; font-size: 35px; font-style: italic;">Bringing technology to life.</p>
</div>
<!-- Slideshow -->
 <div style="margin-top: 20px;" class="slideshow-container">
<div>
	
</div>
<div class="mySlides fade">
  <img src="img1.jpg" style="width:900px; height: 450px; border:3px ridge #53c9c7;">
</div>

<div class="mySlides fade">
  <img src="img2.jpg" style="width:900px; height: 450px; border:3px ridge #53c9c7;">
</div>

<div class="mySlides fade">
  <img src="img3.jpg" style="width:900px; height: 450px; border:3px ridge #53c9c7;">
</div>
<div class="mySlides fade">
  <img src="img4.jpg" style="width:900px; height: 450px; border:3px ridge #53c9c7;">
</div>
<div class="mySlides fade">
  <img src="img5.jpg" style="width:900px; height: 450px; border:3px ridge #53c9c7;">
</div>
<div style="text-align: center;">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span>
  <span class="dot"></span>
</div>
<br>


<script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" activedot", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " activedot";
  setTimeout(showSlides, 3000); // Change image every 2 seconds
}
</script>
</body>
</html>