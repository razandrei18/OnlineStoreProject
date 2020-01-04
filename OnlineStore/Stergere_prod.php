<?php
require_once "conectdb.php";
if(isset($_GET['produs_id']) && is_numeric($_GET['produs_id']))
{
	$id=$_GET['produs_id'];

	if($stmt = $mysqli->prepare("DELETE FROM produse WHERE produs_id=? LIMIT 1"))
	{
		$stmt->bind_param("i", $id);
		$stmt -> execute();
		$stmt -> close();
	}
	else
	{
		echo "ERROR: Stergerea nu poate fi realizata!";
	}
	$mysqli->close();

	echo "<div>Inregistrarea a fost stearsa</div>";
}
echo "<p><a href='Viz_prod.php'>Index</a></p>";
?>