<?php 
require 'includes/dbh.inc.php';
if(isset($_SESSION['id_slika'])){
	if(isset($_SESSION['id_slika'])){
		if(isset($_POST['slikeDEL'])){
			$imeSL = "uploads\oglasi".$_SESSION['id_slika']."*";
			echo $imeSL;
			$infoSL = glob($imeSL); #traži file koji ima dio imena koji se pretražuje
			echo $infoSL;
			$extSL = explode(".", $infoSL[0]); #potreban je prvi reuzltat (id 1 i id 11)
			echo $extSL;
			$actualextSL = $extSL[1]; #drugi rezultat je ekstenzija slike
			echo $actualextSL;

		#BRISANJE SLIKE IZ FOLDERA
			$slika = "uploads/oglasi".$_SESSION['id_slika'].".".$actualextSL;
			echo $slika;
			if(!unlink($slika)){
				echo"<h3>Slika nije izbrisana!</h3>";
			}
			$sql = "DELETE FROM slike_oglasa WHERE id_slike = ".$_SESSION['id_slika'].";";
			mysqli_query($conn, $sql);
			#header("Location: uredi_oglas.php?id=".$_SESSION['id_oglas']);
		}
	}
}
 ?>