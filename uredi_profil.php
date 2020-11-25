<?php
	require "header.php";
	ob_start();
?>
<div class="kategorije">
<div class="container">	
<?php 
$id = $_SESSION['kor_id'];

$id = mysqli_real_escape_string($conn, $_SESSION['kor_id']);

if(isset($_POST['urediProfil'])){
	if (isset($_SESSION['kor_id'])){
	$sql = "SELECT * FROM korisnik WHERE id_korisnik=" . $_SESSION['kor_id']. ";";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<div class='search-wrapper justify-content-between'><h1> Uredi svoj profil - " . $row['korisnicko_ime'] ."</h1>";
			echo"<a href='korisnici.php'><h6 id='tip' style= 'margin-left: 100px;'>Svi korisnici</h6></a>";
			
			if(isset($_GET['error'])){
				if($_GET['error'] == "big_img"){
					echo"<h2 class='greska'>*Greška: Slika je prevelika.</h2>";
				}elseif($_GET['error'] == "error_img"){
					echo"<h2 class='greska'>*Greška: Dogodila se greška.</h2>";
				}elseif($_GET['error'] == "error_img"){
					echo"<h2 class='greska'>*Format: Ova vrsta slike nije dozvoljena.</h2>";
				}elseif($_GET['error'] == "pass"){
					echo"<h2 class='greska'>*Lozinke se ne podudaraju.</h2>";
				}
			}
			echo"</div>
			<div class='pb-5'>
			<i class='pinn'></i>
			<blockquote class='note yellow'>
			<form class='formUredi' action='uredi_profil.php' method='post' enctype='multipart/form-data'>
			<input type='hidden' name='id' value=". $row['id_korisnik']."> 
			Korisničko ime: <input type='text' name='kor_ime' value=". $row['korisnicko_ime'].">
			Ime: <input type='text' name='ime' value=". $row['ime'].">
			Prezime: <input type='text' name='prezime' value=". $row['prezime'].">
			Kontakt: <input type='text' name='kontakt_k' value=". $row['kontakt_k'].">
			E-mail: <input type='text' name='email' value=". $row['email'].">
			Slika profila:";
				if($row['slika'] == 0){
					echo "<img src='uploads/korisnici/korisnik.png' style='width:128px;height:128px;'/>";
				}else{
					$imeSL = "uploads/korisnici/korisnik".$row['id_korisnik']."*";
					$infoSL = glob($imeSL);
					$extSL = explode(".", $infoSL[0]); 
					$actualextSL = $extSL[1]; 
					echo"<div><img  src='uploads/korisnici/korisnik".$row['id_korisnik'].".".$actualextSL."' style='width:128px;height:128px;'/>
					<button id='slikaDel' type='submit' name='slikaDel' title='Obriši sliku profila'><img src='img/trash.png'></button></div>";
				}
			echo "Promijeni sliku: <input type='file' name='slika'>
			<a href=resetiranje_lozinke.php?id=".$row['id_korisnik']."> Promijeni lozinku </a>
			<div><button id='urediKor' type='submit' name='urediKor'> Spremi promjene </button>
			<button id='delKor' type='submit' name='delKor'> Obriši profil </button></div></form></blockquote></div>";
		}
	}
	}
}
$id = $_SESSION['kor_id'];
$id = mysqli_real_escape_string($conn, $_SESSION['kor_id']);
if(isset($_POST['urediKor'])){
	$kor_ime=$_POST['kor_ime'];
	$ime=$_POST['ime'];
	$prezime=$_POST['prezime'];
	$email=$_POST['email'];
	$kontakt_k=$_POST['kontakt_k'];

	
	if($_FILES["slika"]["error"] == 4) {
		$sql = "UPDATE korisnik SET korisnicko_ime = '$kor_ime', ime = '$ime', prezime = '$prezime', kontakt_k = '$kontakt_k', email = '$email'
						WHERE id_korisnik = ".$id.";";
		mysqli_query($conn, $sql);
		header("Location: oglasi_ulogiranog_korisnika.php");	
	}else{
		$slika = $_FILES['slika'];
		$slName = $_FILES['slika']['name'];
		$slTmpName = $_FILES['slika']['tmp_name'];
		$slSize = $_FILES['slika']['size'];
		$slError = $_FILES['slika']['error'];
		$slType = $_FILES['slika']['type'];

		$slExt = explode('.', $slName); # razdvaja ime slike i njenu ekstenziju
		$slActualExt = strtolower(end($slExt)); # ekstenziju pretvara u mala slova

		$allowed = array('jpg', 'jpeg', 'png');# niz ekstenzija koje su dozvoljene

		if (in_array($slActualExt, $allowed)) {#provjera dali slika ima nešto od niza koji su dozvoljene sktenzije
			if($slError === 0){ #dali ime grešaka
				if($slSize < 10000000){# ako ima dozvoljenu veličinu
					#brisanje stare slike ako postoji
					$sqlST = "SELECT slika FROM kategorija;";
					$result = mysqli_query($conn, $sqlST);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) { 
						while ($row = mysqli_fetch_assoc($result)){
							if($row['slika'] === 1){
								$imeSL = "uploads\korisnici\korisnik".$id."*";
								$infoSL = glob($imeSL); #traži file koji ima dio imena koji se pretražuje
								$extSL = explode(".", $infoSL[0]); #potreban je prvi reuzltat (id 1 i id 11)
								$actualextSL = $extSL[1]; #drugi rezultat je ekstenzija slike
								$slika = "uploads\korisnici\korisnik".$id.".".$actualextSL;
								unlink($slika);
							}else{
								$slNameNew = "korisnik". $id .".".$slActualExt; #ime slike koja se sprema
								$slDestination = 'uploads/korisnici/'.$slNameNew;
								move_uploaded_file($slTmpName, $slDestination);
								$sqlSVE = "UPDATE korisnik SET korisnicko_ime = '$kor_ime', ime = '$ime', prezime = '$prezime', kontakt_k = '$kontakt_k', email = '$email', slika = 1
										WHERE id_korisnik = ".$id.";";
								mysqli_query($conn, $sqlSVE);
								header("Location: oglasi_ulogiranog_korisnika.php");	
							}
						}
					}
				}else{
					header("Location: uredi_profil.php?error=big_img&id=".$id);
				}
			}else{
				header("Location: uredi_profil.php?error=error_img&id=".$id);
			}
		}else{
			header("Location: uredi_profil.php?error=format&id=".$id);
		}
	}


}elseif(isset($_POST['delKor'])){		#BRISANJE PROFILA
	$sql = "DELETE FROM korisnik 
				WHERE id_korisnik = ".$id.";";
	mysqli_query($conn, $sql);

#BRISANJE SLIKE IZ FOLDERA
	$slika = "uploads/korisnici/korisnik".$id;
	unlink($slika);
	header("Location: kategorije.php");

}
if(isset($_POST['slikaDel'])){			#BRISANJE SLIKE PROFILA
	$imeSL = "uploads/korisnici/korisnik".$id."*";
	$infoSL = glob($imeSL); #traži file koji ima dio imena koji se pretražuje
	$extSL = explode(".", $infoSL[0]); #potreban je prvi reuzltat (id 1 i id 11)
	$actualextSL = $extSL[1]; #drugi rezultat je ekstenzija slike

#BRISANJE SLIKE IZ FOLDERA
	$slika = "uploads/korisnici/korisnik".$id.".".$actualextSL;
	if(!unlink($slika)){
		echo"<h3>Slika nije izbrisana!</h3>";
	}
	$sql = "UPDATE korisnik SET slika = 0 WHERE id_korisnik = ".$id.";";
	mysqli_query($conn, $sql);
	header("Location: oglasi_ulogiranog_korisnika.php");
}
?>
</div>
</div>
<?php 
	require "footer.php";
?>