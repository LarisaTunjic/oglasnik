<?php 
	include 'header.php';
	ob_start();
	$id_kat = $_GET['id'];
	$id_pod = $_GET['pod_id'];
	$id_pod2 = $_GET['pod_id2'];
	
?>
<div class="kategorije">
<div class="container">
	<div class="search-wrapper">
		<h1> Kreiranje novog oglasa </h1>
	<?php 
		if(isset($_GET['error'])){
			if($_GET['error'] == "br_slika"){
				echo"<h2 class='greska'>*Greška: Prevelik broj slika.</h2>";
			}elseif($_GET['error'] == "format"){
				echo"<h2 class='greska'>*Greška: Format slike nije dozvoljen.</h2>";
			}
		}
	?>
	</div>
<div class="pb-5">
	<i class="pinn"></i>
	<blockquote class="note yellow">
<?php	echo"
	<form class='formUredi' action='dodaj_oglas.php?id=".$id_kat."&pod_id=".$id_pod."&pod_id2=".$id_pod2."' method='post' enctype='multipart/form-data'>";
?>	
		Naslov oglasa*: <input type="text" name="naslov" placeholder="Napišite naslov oglasa.">
		Opis oglasa*: <br><textarea type="text" rows="10" name="tekst"  placeholder="Napišite nešto o svom oglasu..."></textarea><br>
		Kontakt za oglas: <input type="number" name="kontakt_o">
		Dodajte slike: <input type=file name="files[]" multiple><br>
		<button id="dodajOgl" type="submit" name="dodajOgl"> Zalijepi oglas </button>
		<br><h2 class='greska' style='font-size: 18px;'>*Obavezna polja.</h2>
	</form>
</blockquote>
</div>
<?php

if(isset($_POST['dodajOgl'])){
	
	$id_kat = $_GET['id'];
	$id_korisnik = $_SESSION['kor_id'];
	$naslov = $_POST['naslov'];
	$tekst = $_POST['tekst'];
	$kontakt_o = $_POST['kontakt_o'];

	if (empty($naslov) || empty($tekst) ) {
		echo("<script>alert('Molimo popunite polja.')</script>");
 		echo("<script>window.location = 'dodaj_oglas.php?error=prazna_polja&id=".$id_kat."&pod_id=".$id_pod."&pod_id2=".$id_pod2."</script>");
		exit();
	}
	$count = count(array_filter($_FILES['files']['name'])); #PROVJERA BROJA SLIKA

	if ($count > 5) {
		header("Location: dodaj_oglas.php?error=br_slika&id=".$id_kat."&pod_id=".$id_pod."&pod_id2=".$id_pod2);
	}
	elseif ($count == 0 || $count == NULL) { # AKO NEMA SLIKA SAMO UPISI TEKSTUALNI DIO OGLASA
	
		if(($id_pod2 == 0) && ($id_pod == 0)){
			$sqlOGL = "INSERT INTO oglas (id_kategorija, id_tip_oglas, id_korisnik, naslov, tekst, aktivan, kontakt_o) 
					VALUES ('$id_kat' , '2', '$id_korisnik', '$naslov', '$tekst', 0 , '$kontakt_o');";
			$resultText = mysqli_query($conn, $sqlOGL);

			# I POSALJI MAIL
			$sqlMail = "SELECT email FROM korisnik WHERE id_tip = '0'";
			$resultMail = mysqli_query($conn, $sqlMail);
			$resultCheck = mysqli_num_rows($resultMail);
			if ($resultCheck > 0) { 
				while ($row = mysqli_fetch_assoc($resultMail)){
					$mail = $row['email'];
					$subject = "Novi oglas";
					$poruka = "Admine, dodan je novi oglas koji treba odobriti ili ukloniti.";

					mail($mail, $subject, $poruka);
				}
			}
			header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
		}elseif($id_pod2 == 0){
			$sqlOGL = "INSERT INTO oglas (id_kategorija, id_nadkategorija, id_tip_oglas, id_korisnik, naslov, tekst, aktivan, kontakt_o) 
						VALUES ('$id_pod', '$id_kat' , '2', '$id_korisnik', '$naslov', '$tekst', 0 , '$kontakt_o');";
			$resultText = mysqli_query($conn, $sqlOGL);

			# I POSALJI MAIL
			$sqlMail = "SELECT email FROM korisnik WHERE id_tip = '0'";
			$resultMail = mysqli_query($conn, $sqlMail);
			$resultCheck = mysqli_num_rows($resultMail);
			if ($resultCheck > 0) { 
				while ($row = mysqli_fetch_assoc($resultMail)){
					$mail = $row['email'];
					$subject = "Novi oglas";
					$poruka = "Admine, dodan je novi oglas koji treba odobriti ili ukloniti.";

					mail($mail, $subject, $poruka);
				}
			}
			header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
		}else{
			$sqlOGL = "INSERT INTO oglas (id_kategorija, id_nadkategorija, id_nadkategorija2, id_tip_oglas, id_korisnik, naslov, tekst, aktivan, kontakt_o) 
						VALUES ('$id_pod2', '$id_pod' , '$id_kat' , '2', '$id_korisnik', '$naslov', '$tekst', 0 , '$kontakt_o');";
			$resultText = mysqli_query($conn, $sqlOGL);

			# I POSALJI MAIL
			$sqlMail = "SELECT email FROM korisnik WHERE id_tip = '0'";
			$resultMail = mysqli_query($conn, $sqlMail);
			$resultCheck = mysqli_num_rows($resultMail);
			if ($resultCheck > 0) { 
				while ($row = mysqli_fetch_assoc($resultMail)){
					$mail = $row['email'];
					$subject = "Novi oglas";
					$poruka = "Admine, dodan je novi oglas koji treba odobriti ili ukloniti.";

					mail($mail, $subject, $poruka);
				}
			}

			header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
		}
	}else{ 		#OGLAS SA SLIKAMA
		if(($id_pod2 == 0)&&($id_pod == 0)){
			$sqlOGL = "INSERT INTO oglas (id_kategorija, id_tip_oglas, id_korisnik, naslov, tekst, aktivan, kontakt_o) 
				VALUES ('$id_kat', '2', '$id_korisnik', '$naslov', '$tekst', 0 , '$kontakt_o');";
			$resultOGL = mysqli_query($conn, $sqlOGL) ;
			#DOHVAĆANJE ID_OGLASA
			$sqlID = "SELECT max(id_oglas) FROM oglas ;";							
			$resultID = mysqli_query($conn, $sqlID);
			$resultCheck = mysqli_num_rows($resultID);

			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($resultID)) {
					$id_oglas = $row['max(id_oglas)'];
					foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
						$tmp_slika = $_FILES["files"]["tmp_name"][$key];	
						$ime_slika = $_FILES["files"]["name"][$key];
						$tip_slika = $_FILES["files"]["type"][$key];
						$slExt = explode('.', $ime_slika); # razdvaja ime slike i njenu ekstenziju
						$slActualExt = strtolower(end($slExt)); # ekstenziju pretvara u mala slova
						$allowed = array('jpg', 'jpeg', 'png');# niz ekstenzija koje su dozvoljene
						if (in_array($slActualExt, $allowed)) {#provjera dali slika ima nešto od niza koji su dozvoljene sktenzije
							$slNameNew = uniqid('', true) .".".$slActualExt; #ime slike koja se sprema
							$putanja = "uploads/oglasi/slike_oglasa_".$id_oglas;
							$putanja_slikaCheck = "uploads/oglasi/slike_oglasa_".$id_oglas."/".$slNameNew;
							if (!file_exists($putanja_slikaCheck)) {
								mkdir($putanja, 0777, true);
								$putanja_slika = "uploads/oglasi/slike_oglasa_".$id_oglas."/".$slNameNew;
								move_uploaded_file($tmp_slika, $putanja_slika);
								$sqlSL = "INSERT INTO slike_oglasa (id_oglas, ime_slika, tip_slika, putanja_slika)	
											VALUES ('$id_oglas', '$slNameNew', '$tip_slika', '$putanja_slika');";
								$resultSl = mysqli_query($conn, $sqlSL);
								header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
							}
						}else{
							echo"<h2 class='greska'>Format slike nije dozvoljen!</h1>";
							echo count(array_filter($_FILES['files']['name']));
						}							
					}
				}	
			}
			# SLANJE MAILA
			$sqlMail = "SELECT email FROM korisnik WHERE id_tip = '0'";
			$resultMail = mysqli_query($conn, $sqlMail);
			$resultCheck = mysqli_num_rows($resultMail);
			if ($resultCheck > 0) { 
				while ($row = mysqli_fetch_assoc($resultMail)){
					$mail = $row['email'];
					$subject = "Novi oglas";
					$poruka = "Admine, dodan je novi oglas koji treba odobriti ili ukloniti.";

					mail($mail, $subject, $poruka);
				}
			}

		}elseif($id_pod2 == 0){
			$sqlOGL = "INSERT INTO oglas (id_kategorija, id_nadkategorija, id_tip_oglas, id_korisnik, naslov, tekst, aktivan, kontakt_o) 
				VALUES ('$id_pod', '$id_kat', '2', '$id_korisnik', '$naslov', '$tekst', 0 , '$kontakt_o');";
			$resultOGL = mysqli_query($conn, $sqlOGL) ;
			#DOHVAĆANJE ID_OGLASA
			$sqlID = "SELECT max(id_oglas) FROM oglas ;";							
			$resultID = mysqli_query($conn, $sqlID);
			$resultCheck = mysqli_num_rows($resultID);

			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($resultID)) {
					$id_oglas = $row['max(id_oglas)'];
					foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
						$tmp_slika = $_FILES["files"]["tmp_name"][$key];	
						$ime_slika = $_FILES["files"]["name"][$key];
						$tip_slika = $_FILES["files"]["type"][$key];
						$slExt = explode('.', $ime_slika); # razdvaja ime slike i njenu ekstenziju
						$slActualExt = strtolower(end($slExt)); # ekstenziju pretvara u mala slova
						$allowed = array('jpg', 'jpeg', 'png');# niz ekstenzija koje su dozvoljene
						if (in_array($slActualExt, $allowed)) {#provjera dali slika ima nešto od niza koji su dozvoljene sktenzije
							$slNameNew = uniqid('', true) .".".$slActualExt; #ime slike koja se sprema
							$putanja = "uploads/oglasi/slike_oglasa_".$id_oglas;
							$putanja_slikaCheck = "uploads/oglasi/slike_oglasa_".$id_oglas."/".$slNameNew;
							if (!file_exists($putanja_slikaCheck)) {
								mkdir($putanja, 0777, true);
								$putanja_slika = "uploads/oglasi/slike_oglasa_".$id_oglas."/".$slNameNew;
								move_uploaded_file($tmp_slika, $putanja_slika);
								$sqlSL = "INSERT INTO slike_oglasa (id_oglas, ime_slika, tip_slika, putanja_slika)	
											VALUES ('$id_oglas', '$slNameNew', '$tip_slika', '$putanja_slika');";
								$resultSl = mysqli_query($conn, $sqlSL);
								header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
							}
						}else{
							echo"<h2 class='greska'>Format slike nije dozvoljen!</h1>";
							echo count(array_filter($_FILES['files']['name']));
						}							
					}
				}	
			}
			# SLANJE MAILA
			$sqlMail = "SELECT email FROM korisnik WHERE id_tip = '0'";
			$resultMail = mysqli_query($conn, $sqlMail);
			$resultCheck = mysqli_num_rows($resultMail);
			if ($resultCheck > 0) { 
				while ($row = mysqli_fetch_assoc($resultMail)){
					$mail = $row['email'];
					$subject = "Novi oglas";
					$poruka = "Admine, dodan je novi oglas koji treba odobriti ili ukloniti.";

					mail($mail, $subject, $poruka);
				}
			}

		}else{
			$sqlOGL = "INSERT INTO oglas (id_kategorija, id_nadkategorija, id_nadkategorija2, id_tip_oglas, id_korisnik, naslov, tekst, aktivan, kontakt_o) 
				VALUES ('$id_pod2', '$id_pod' , '$id_kat', '2', '$id_korisnik', '$naslov', '$tekst', 0 , '$kontakt_o');";
			$resultOGL = mysqli_query($conn, $sqlOGL) ;
			#DOHVAĆANJE ID_OGLASA
			$sqlID = "SELECT max(id_oglas) FROM oglas ;";							
			$resultID = mysqli_query($conn, $sqlID);
			$resultCheck = mysqli_num_rows($resultID);

			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($resultID)) {
					$id_oglas = $row['max(id_oglas)'];
					foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
						$tmp_slika = $_FILES["files"]["tmp_name"][$key];	
						$ime_slika = $_FILES["files"]["name"][$key];
						$tip_slika = $_FILES["files"]["type"][$key];
						$slExt = explode('.', $ime_slika); # razdvaja ime slike i njenu ekstenziju
						$slActualExt = strtolower(end($slExt)); # ekstenziju pretvara u mala slova
						$allowed = array('jpg', 'jpeg', 'png');# niz ekstenzija koje su dozvoljene
						if (in_array($slActualExt, $allowed)) {#provjera dali slika ima nešto od niza koji su dozvoljene sktenzije
							$slNameNew = uniqid('', true) .".".$slActualExt; #ime slike koja se sprema
							$putanja = "uploads/oglasi/slike_oglasa_".$id_oglas;
							$putanja_slikaCheck = "uploads/oglasi/slike_oglasa_".$id_oglas."/".$slNameNew;
							if (!file_exists($putanja_slikaCheck)) {
								mkdir($putanja, 0777, true);
								$putanja_slika = "uploads/oglasi/slike_oglasa_".$id_oglas."/".$slNameNew;
								move_uploaded_file($tmp_slika, $putanja_slika);
								$sqlSL = "INSERT INTO slike_oglasa (id_oglas, ime_slika, tip_slika, putanja_slika)	
											VALUES ('$id_oglas', '$slNameNew', '$tip_slika', '$putanja_slika');";
								$resultSl = mysqli_query($conn, $sqlSL);
								header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
							}
						}else{
							echo"<h2 class='greska'>Format slike nije dozvoljen!</h1>";
							echo count(array_filter($_FILES['files']['name']));
						}							
					}
				}	
			}
			# SLANJE MAILA
			$sqlMail = "SELECT email FROM korisnik WHERE id_tip = '0'";
			$resultMail = mysqli_query($conn, $sqlMail);
			$resultCheck = mysqli_num_rows($resultMail);
			if ($resultCheck > 0) { 
				while ($row = mysqli_fetch_assoc($resultMail)){
					$mail = $row['email'];
					$subject = "Novi oglas";
					$poruka = "Admine, dodan je novi oglas koji treba odobriti ili ukloniti.";

					mail($mail, $subject, $poruka);
				}
			}

		}
	}
}

/*SLANJE MAILA ADMINIMA DA JE DODAN NOVI OGLAS (ako neće slati mail google je blokirao aplikaciju 
	treba ju ponovo dozvoliti  https://www.google.com/settings/security/lesssecureapps, 
	pokrenuti sendmail.exe kao administrator i
	maknuti komentar sa maila 
	sa kojeg se šalje C:\wamp64\bin\apache\apache2.4.37\bin)*/
?>

</div>
</div>
<?php 
require "footer.php";