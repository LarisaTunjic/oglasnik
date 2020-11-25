<?php
	require "header.php";
?>
<div class="kategorije">
<div class="container">
<div class='pb-5'>
<ul>
<?php
if (!isset($_SESSION['kor_id']) && !isset($_SESSION['kor_ime'])){		#PRIKAZ ZA ANONIMNOG KORISNIKA
	$sql = "SELECT id_kategorija as kat, naziv, slika  FROM kategorija WHERE nadkategorija_id IS NULL ;";   #ISPIS GLAVNIH KATEGORIJA        
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$kat = $row['kat'];
			echo "<li><a href='podkategorije.php?id=". $kat. "'>
				<i class='pin'></i>";
				$velicina = strlen($row['naziv']);
				if($velicina > 15){
					echo "<b>".$row['naziv']."</b>";
				}else{
				echo"<h2>" . $row['naziv'] . "</h2>"; 
				}
				if($row['slika'] == 0){
					echo "<p><img class='slProf1' src='uploads/kategorije/kategorija.png' /></p>";
				}else{
					$imeSL = "uploads/kategorije/kategorija".$kat."*";
					$infoSL = glob($imeSL);
					$extSL = explode(".", $infoSL[0]); 
					$actualextSL = $extSL[1]; 
					echo"<p><img class='slProf1' src='uploads/kategorije/kategorija".$kat.".".$actualextSL."'/></p>";
				}"</p>";
			$sql2 ="SELECT id_oglas, COUNT(*)as broj FROM oglas WHERE aktivan = 1 AND (id_kategorija = ".$kat." || id_nadkategorija = ".$kat." || id_nadkategorija2 = ".$kat.");";
			$result2 = mysqli_query($conn, $sql2);
			$resultCheck = mysqli_num_rows($result2);
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result2)) {
					echo "<p class='br_ogl'>broj oglasa: " . $row['broj']." </p>";
					echo"</a></li>";
					
				}				
			}
		}
	}
}elseif($_SESSION['id_tip']=='0'){			#ADMIN PRIKAZ
	echo"<form class='button-wrapper' action=dodaj_kategoriju.php method='post'> 
	<div class='row'>
	<div class='col-md-6'><h1 style='font-family:Satisfy;'>Kategorije</h1></div>
	<div class='col-md-6 text-right'><button class='dodaj_kat1' type='submit' name='dodaj_kat1' style='font-family:Satisfy;'> Dodaj kategoriju</button></form></h1></div>
	</div>";
	$sql = "SELECT id_kategorija as kat, naziv, slika  FROM kategorija WHERE nadkategorija_id IS NULL ;";                                                  #KOLIKO IMA KATEGORIJA?
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$kat = $row['kat'];
			echo "<li><a href='uredi_kategoriju.php?id=". $kat. "'>
				<i class='pin'></i>";
				$velicina = strlen($row['naziv']);
				if($velicina > 15){
					echo "<b>".$row['naziv']."</b>";
				}else{
				echo"<h2>" . $row['naziv'] . "</h2>"; 
				}
				if($row['slika'] == 0){
					echo "<p><img class='slProf1' src='uploads/kategorije/kategorija.png' /></p>";
				}else{
					$imeSL = "uploads/kategorije/kategorija".$kat."*";
					$infoSL = glob($imeSL);
					$extSL = explode(".", $infoSL[0]); 
					$actualextSL = $extSL[1]; 
					echo"<p><img class='slProf1' src='uploads/kategorije/kategorija".$kat.".".$actualextSL."'/></p>";
				}
			
			echo "<p><i>Uredi kategoriju</i></p>";
				echo"</a></li>";
		}
	}
}elseif($_SESSION['id_tip']=='1'){			#PRIKAZ ULOGIRANOG KORISNIKA
	$sql = "SELECT id_kategorija as kat, naziv, slika  FROM kategorija WHERE nadkategorija_id IS NULL ;";                                                  #KOLIKO IMA KATEGORIJA?
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$kat = $row['kat'];
			echo "<li><a href='podkategorije.php?id=". $kat. "'>
				<i class='pin'></i>";
				$velicina = strlen($row['naziv']);
				if($velicina > 15){
					echo "<b>".$row['naziv']."</b>";
				}else{
				echo"<h2>" . $row['naziv'] . "</h2>"; 
				}
				if($row['slika'] == 0){
					echo "<p><img class='slProf1' src='uploads/kategorije/kategorija.png' /></p>";
				}else{
					$imeSL = "uploads/kategorije/kategorija".$kat."*";
					$infoSL = glob($imeSL);
					$extSL = explode(".", $infoSL[0]); 
					$actualextSL = $extSL[1]; 
					echo"<p><img class='slProf1' src='uploads/kategorije/kategorija".$kat.".".$actualextSL."'/></p>";
				}"</p>";
				$sql2 ="SELECT id_oglas, COUNT(*)as broj FROM oglas WHERE aktivan = 1 AND (id_kategorija = ".$kat." || id_nadkategorija = ".$kat." || id_nadkategorija2 = ".$kat.");";
				$result2 = mysqli_query($conn, $sql2);
				$resultCheck = mysqli_num_rows($result2);
				if ($resultCheck > 0) {
					while ($row = mysqli_fetch_assoc($result2)) {
						echo "<p class='br_ogl'>broj oglasa: " . $row['broj']."</p>";
						echo"</a></li>";
						
					}				
				}
		}
	}
}
?>
</ul>
</div>
</div>
</div>
<?php 
	require "footer.php";
?>