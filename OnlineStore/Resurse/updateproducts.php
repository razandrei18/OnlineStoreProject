<?php
	$error = '';
	include("conectdb.php");
	if(!empty($_POST['produs_id']))
	{
		if(isset($_POST['submit']))
		{
			if(is_numeric($_POST['produs_id']))
			{
				$produs_id = $_POST['produs_id'];
				$nume = htmlentities($_POST['produs_nume'], ENT_QUOTES);
				$pret = htmlentities($_POST['pret'], ENT_QUOTES);
				$imagine = htmlentities($_POST['imagine'], ENT_QUOTES);
				$categorie = htmlentities($_POST['categorie_produs'], ENT_QUOTES);
				$descriere = htmlentities($_POST['descriere'], ENT_QUOTES);
				if( $nume == "" || $pret == "" || $imagine == "" || $categorie == "" || $descriere == "")
				{
					echo "<div>ERROR: Please complete all the fields! </div>";
				}
				else
				{
					if ($stmt = $mysqli->prepare("UPDATE produse SET produs_nume=?, pret=?, imagine=?, categorie=?, descriere=? WHERE produs_id='".$produs_id."'"))
					{
						$stmt->bind_param("sdsss", $nume, $pret, $imagine, $categorie, $descriere);
						$stmt->execute();
						$stmt->close();
					}
					else
					{
						echo "ERROR: The update operation cannot be executed!";
					}
				}
			}
			else
			{
				echo "Incorrect ID!";
			}
		}
	}
?>
<!DOCTYPE html>
<html> 
	<head>
	<title><?php if ($_GET['produs_id'] != '') {echo "Modify record";}?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
		<h1><?php 
		//if(isset($_GET['id']))
		//{
		if ($_GET['produs_id'] != '') { echo "Modify record"; }//}
		?></h1>
		<?php 
		if ($error != '') 
		{
		echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error. "</div>";
		} 
		?>
		<!--<form action="" method="post">-->
		<!--<input type="number" name="id" value=""/>--> <!-- Added by me -->
		<!--<input type="submit" name="submit_value" value="Submit" />-->
		<form action="" method="post">
		<div>
		<?php 
		$_POST['produs_id'] = '';
		if ($_POST['produs_id'] != '')?>
		<?php
		{
		?>
			<input type="hidden" name="produs_id" value="<?php echo $_GET['produs_id']; ?>" />
			<p>ID: <?php echo $_GET['produs_id'] ;?></p>
			<?php if ($result = $mysqli->query("SELECT * FROM produse WHERE produs_id='".$_GET['produs_id']."'"))
			{
				if ( $result -> num_rows > 0)
				{
				?>
				<?php $row = $result->fetch_object();?>
				<strong>Nume produs: </strong> <input type="text" name="produs_nume" value="<?php echo $row->produs_nume; ?>"/><br/>
				<strong>Pret: </strong> <input type="text" name="pret" value="<?php echo $row->pret; ?>"/><br/>
				<strong>Imagine: </strong> <input type="text" name="imagine" value="<?php echo $row->imagine; ?>"/><br/>
				<strong>Categorie: </strong> <input type="text" name="categorie" value="<?php echo $row->categorie;?>"/><br/>	
				<strong>Descriere: </strong> <input type="text" name="descriere" value="<?php echo $row->descriere;?>"/><br/>
				<input type="submit" name="submit" value="Submit" />
				<a href="viewproducts.php">View the watches</a>
				<?php
				}
			}
		}
		$mysqli->close();
		?>
		</div>
		</form>
	</body> 
</html>