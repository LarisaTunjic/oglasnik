<?php 

	require "header.php";
?>
<div class="kategorije">
<div class="container">

	<div class="search-wrapper">
		<h1>Svi korisnici</h1>
	</div>
<div class='pb-5'>
<ul>
<?php 
$sql = "SELECT id_korisnik, korisnicko_ime, slika 
			FROM korisnik
			WHERE id_korisnik > 1"; #dohvati sve obične korisnike
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) { # lista korisnika
		while ($row = mysqli_fetch_assoc($result)) {
			if(isset($_SESSION['kor_id'])){
				if($_SESSION['id_tip']=='0'){	#ADMIN PRIKAZ
					$sql = "SELECT id_korisnik, korisnicko_ime,slika FROM korisnik
							WHERE id_korisnik != ".$_SESSION['kor_id'].";"; #NE ISPISUJ ULOGIRANOG KORISNIKA
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) { 
						while ($row = mysqli_fetch_assoc($result)) {			
							echo "<li><a href='uredi_korisnika.php?id=" .$row['id_korisnik']."'>";
							echo"<i class='pin'></i>";
							echo "<h2>" . $row['korisnicko_ime'] . "</h2>";
							if($row['slika'] == 0){
								echo "<p><img class='slProf1' src='uploads/korisnici/korisnik.png';'/></p></a></li>";
							}else{
								$imeSL = "uploads/korisnici/korisnik".$row['id_korisnik']."*";
								$infoSL = glob($imeSL);
								$extSL = explode(".", $infoSL[0]); 
								$actualextSL = $extSL[1]; 
								echo"<p><img class='slProf1'  src='uploads/korisnici/korisnik".$row['id_korisnik'].".".$actualextSL."';'/></p>";
								echo "<p class='br_ogl'>Uredi korisnika</p></a></li>";
							}
						}
					}
				}
				elseif($_SESSION['id_tip']!='0'){		#PRIKAZ ZA ULOGIRANOG KORISNIKA
					$sql = "SELECT id_korisnik, korisnicko_ime,slika FROM korisnik
								WHERE id_korisnik != ".$_SESSION['kor_id'].";"; #NE ISPISUJ ULOGIRANOG KORISNIKA
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) { 
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<li><a href='oglasi_korisnika.php?id=" .$row['id_korisnik']."'>";
							echo"<i class='pin'></i>";
							echo "<h2>" . $row['korisnicko_ime'] . "</h2>";
							echo "<p class='br_ogl'>Pogledaj moje oglase :)</p>";
							if($row['slika'] == 0){
								echo "<p><img class='slProf1' src='uploads/korisnici/korisnik.png';'/></p></a></li>";
							}else{
								$imeSL = "uploads/korisnici/korisnik".$row['id_korisnik']."*";
								$infoSL = glob($imeSL);
								$extSL = explode(".", $infoSL[0]); 
								$actualextSL = $extSL[1]; 
								echo"<p><img class='slProf1'  src='uploads/korisnici/korisnik".$row['id_korisnik'].".".$actualextSL."';'/>";
							}"</p></a></li>";
						}
					}
				}
			
			}elseif(!(isset($_SESSION['kor_id']))){			#PRIKAZ ZA ANONIMNOG KORISNIKA
			echo "<li><a href='oglasi_korisnika.php?id=" .$row['id_korisnik']."'>";
			echo"<i class='pin'></i>";
			echo "<h2>" . $row['korisnicko_ime'] . "</h2>";
			echo "<p class='br_ogl'>Pogledaj moje oglase :)</p>";
			if($row['slika'] == 0){
				echo "<p><img class='slProf1' src='uploads/korisnici/korisnik.png' ;'/></p></a></li>";
			}else{
				echo"<p><img class='slProf1' src='uploads/korisnici/korisnik".$row['id_korisnik'].".jpg';'/>";
			}"</p></a></li>";
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
