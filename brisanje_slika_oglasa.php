<?php 
	session_start();
	require "includes/dbh.inc.php";
	$id_slika = $_GET['idsl'];
	$id_oglas = $_GET['id'];
	$putanja = $_GET['filename'];

	if($_GET['action'] && $_GET['action'] == 'delete') {
		$query = "DELETE FROM slike_oglasa WHERE id_slika = ".$id_slika.";";
		$result = mysqli_query($conn, $query);

		if($result){
			unlink($putanja);
		}
		
		header("Location: uredi_oglas.php?id=".$id_oglas);	
	}