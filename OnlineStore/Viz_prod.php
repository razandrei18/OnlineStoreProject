<!DOCTYPE html>
<html>
<head>
	<title>Vizualizare Inregistrari</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<h1>Inregistrarile din tabela Produse</h1>
	<p><b> Toate inregistrarile din produse</b></p>
	<?php
	include("conectdb.php");
	if($result=$mysqli->query("SELECT * FROM produse ORDER BY produs_id"))
	{
		if($result->num_rows>0)
		{
			echo "<table border='1' cellpadding='10'>";
			echo "<tr><th>ID</th><th>Nume</th><th>Prenume</th><th>an</th><th>grupa</th><th></th><th></th></tr>";

			while ($row=$result->fetch_object()) {

				echo "<tr>";
				echo "<td>".$row->produs_id."</td>";
				echo "<td>".$row->produs_nume."</td>";
				echo "<td>".$row->pret."</td>";
				echo "<td>".$row->categorie_produs."</td>";
				echo "<td>".$row->descriere."</td>";
				echo "<td><a href='Update_prod.php?id="  .   $row->produs_id  .  "'>Modificare </a></td>";
				echo "<td><a href='Stergere_prod.php?produs_id="  .   $row->produs_id  .  "'>Stergere </a></td>";
				echo "</tr>";

			}
			echo "</table>";
		}
		else
		{
			echo "Nu sunt inregistrari in tabela!";
		}

	}
	else {echo "Error:".$mysqli->error();}
	$mysqli->close();
	?>
	<br>
	<a href="Inserare_prod.php"> Adaugarea unei noi inregistrari </a><br/>
	<a href="adminpage.html">Home</a>
		
	

</body>
</html>