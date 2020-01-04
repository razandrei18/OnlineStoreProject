<?php
include("conectdb.php");
if (isset($_POST['submit']))
{
	$produs_nume= htmlentities($_POST['produs_nume'], ENT_QUOTES);
	$pret = htmlentities($_POST['pret'], ENT_QUOTES);
	$imagine =  htmlentities($_POST['imagine'], ENT_QUOTES);
	$categorie_produs =  htmlentities($_POST['categorie_produs'], ENT_QUOTES);
	$descriere =  htmlentities($_POST['descriere'], ENT_QUOTES);
	$cantitate =  htmlentities($_POST['cantitate'], ENT_QUOTES);
	//verificam daca datele sunt completate
	if ( $produs_nume=='' || $pret=='' || $imagine=='' || $categorie_produs=='' || $descriere=='' || $cantitate=='')
	{
		//daca sunt goale se afiseaza un mesaj
		$error = 'ERROR: Campuri goale';
	}
	else{
		//insert
		if ($stmt = $mysqli->prepare("INSERT INTO produse( produs_nume,pret,imagine,categorie_produs, descriere, cantitate) VALUES (?,?,?,?,?,?)"))
		{
			$stmt->bind_param("sdsssi", $produs_nume, $pret, $imagine, $categorie_produs, $descriere, $cantitate);
			$stmt->execute();
			$stmt->close();
		}
		else{
			echo "ERROR: Nu se poate executa insert-ul!";
		}
	}
}
$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo "Inserare inregistrare";?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<h1><?php echo "Inserare Produs"?></h1>
	<?php 
		$error='';
		if($error !=''){
		echo "<div style='padding: 4px; border: 1px solid red; color:red'>".$error. "</div>";}?>
		<form action="" method="post">
			<div>
		<strong>Nume Produs: </strong><br>
		<input type="text" name="produs_nume" value=""/><br/>
		<strong>Pret: </strong><br>
		<input type="text" name="pret" value=""><br/>
		<strong>Imagine: </strong><br>
		<input type="imagine" name="imagine" value=""><br/>
		<strong>Categorie: </strong><br>
		<input type="text" name="categorie_produs" value=""><br/>
		<strong>Descriere: </strong><br>
		<input type="text" name="descriere" value=""><br/>
		<strong>Cantitate: </strong><br>
		<input type="text" name="cantitate" value=""><br/>
		<input type="submit" name="submit" value="Submit"/><br>
		<a href="Viz_prod.php">Index</a><br/>
	</div></form></body></html>

	

</body>
</html>