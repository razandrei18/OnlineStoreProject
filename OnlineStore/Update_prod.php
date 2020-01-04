<?php //conectare la bazadedate
include("conectdb.php");
//Modificarea datelor
// se preia id din pagina vizualizare
if(!empty($_POST['produs_id']))
{
	if (isset($_POST['submit']))
	{
		if (is_numeric($_POST['produs_id']))
		{
			//preluam variabilele din URL/form
			$id= $_POST['produs_id'];
			$nume = htmlentities($_POST['produs_nume'], ENT_QUOTES);
			$pret = htmlentities($_POST['pret'], ENT_QUOTES);
			$imagine = htmlentities($_POST['imagine'], ENT_QUOTES);
			$categorie= htmlentities($_POST['categorie_produs'], ENT_QUOTES);
			$descriere= htmlentities($_POST['descriere'], ENT_QUOTES);
			if($nume=='' || $pret=='' || $imagine=='' || $categorie=='' || $descriere==''){
				echo "<div>ERROR: Completati campurile obligatorii!</div>";
			}
			else{
				if($stmt = $mysqli -> prepare("UPDATE produse SET produs_nume=?, pret=?, imagine=?, categorie_produs=?, descriere=? WHERE produs_id='".$id."'"))
				{
					$stmt -> bind_param("sisss", $nume, $pret, $imagine, $categorie, $descriere);
					$stmt-> execute();
					$stmt-> close();
				}
				//mesaj de eroare in caz ca nu se poate face UPDATE
				else{
					echo "ERROR: nu se poate face update.";
				}
			}
		}
		//daca variabila 'id' nu este valida, afisam mesaj de eroare
		else{echo "id incorect!";}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>
		<?php if($_GET['produs_id'] !='') 
	{
		echo "Modificare inregistrare";
	} 
	?>
	</title>
	<meta http-equiv="Content-Type" context="text/html; charset=utf-8"/>
</head>
<body>
	<h1>
		<?php if($_GET['produs_id']!='')
	 {
	 	echo "Modificare Inregistrare";
	 }
	 ?> 
	</h1>
	<?php 
	if ($error !=''){
		echo "<div style='padding:4px;border:1px solid red; color: red;'>".$error."</div>";
	} ?>
	<form action="" method="post">
		<div>
			<?php if($_GET['produs_id'] !='') {?>
				<input type="hidden" name="produs_id" value="<?php $_GET['produs_id']; ?>"/>
				<p>ID: <?php echo $_GET['produs_id'];
				if($result= $mysqli->query("SELECT * FROM produse WHERE produs_id='".$_GET['produs_id']."'"))
				{
					if ($resut->num_rows> 0){
						$row =$result->fetch_object();	
					}
				}?>
				</p>	
			
				<strong>Nume Produs: </strong> <input type="text" name="produs_nume" value="<?php echo $row->produs_nume; ?>"/><br/>
				<strong>Pret: </strong> <input type="text" name="pret" value="<?php echo $row->pret; ?>"/><br/>
				<strong>Imagine: </strong> <input type="text" name="imagine" value="<?php echo $row->imagine; ?>"/><br/>
				<strong>Categorie: </strong> <input type="text" name="categorie_produs" value="<?php echo $row->categorie; ?>"/><br/>
				<strong>Descriere: </strong> <input type="text" name="descriere" value="<?php echo $row->descriere; ?>"/><br/>	
				<input type="submit" name="submit" value="Submit"/>
				<a href="Viz_prod.php">Index</a>
		</div>
	</form>
</body>
</html>