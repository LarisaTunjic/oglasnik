<?php 

	require "header.php";
	ob_start();
?>
	<div class="kategorije">
	<div class="container">	
	<div class='pb-5'>
<?php

$id = $_GET['id'];
$id = mysqli_real_escape_string($conn,$_GET['id']);
$query = "SELECT * FROM kategorija 
			WHERE id_kategorija= ".$id." ;" ;
$result = mysqli_query($conn,$query) or trigger_error()."in".$query;
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) { 
	while ($row = mysqli_fetch_assoc($result)){
		echo"<div class='button-flex-wrapper'>
		<h1 style='font-family:Satisfy;'> Uredi kategoriju : " .$row['naziv']."</h1>";
		if(isset($_GET['error'])){
			if($_GET['error'] == "big_img"){
				echo"<h2 class='greska'>*Greška: Slika je prevelika.</h2>";
			}elseif($_GET['error'] == "error_img"){
				echo"<h2 class='greska'>*Greška: Dogodila se greška.</h2>";
			}elseif($_GET['error'] == "error_img"){
				echo"<h2 class='greska'>*format: Ova vrsta slike nije dozvoljena..</h2>";
			}
		}
		echo"<form action='dodaj_podkategoriju?id=" .$row['id_kategorija']."' method='post' enctype='multipart/form-data'>
		<input type='hidden' name='id' value=". $row['id_kategorija'].">
		<button class='dodaj_kat1' type='submit' name='dodaj_kat1' style='font-family:Satisfy;'> Dodaj podkategoriju</button>
		</form>
		</div>
		<div class='container'>
		<i class='pin'></i>
		<blockquote class='note yellow'>
		<form  action='uredi_kategoriju?id=" .$row['id_kategorija']."' method='post' enctype='multipart/form-data'>
		<input type='hidden' name='id' value=". $row['id_kategorija']."> 
		Naziv kategorije: <input type='text' name='naziv' value='" . $row['naziv'] ."'><br>
		Slika kategorije:<br>";
			if($row['slika'] == 0){
				echo "<p><img class='slKat2' src='uploads/kategorije/kategorija.png' style='width:128px;height:128px;'/></p>";
			}else{
				$imeSL = "uploads/kategorije/kategorija".$row['id_kategorija']."*";
				$infoSL = glob($imeSL);
				$extSL = explode(".", $infoSL[0]); 
				$actualextSL = $extSL[1]; 
				echo"<div class='slikaDel'><img class='slKat2' src='uploads/kategorije/kategorija".$id.".".$actualextSL."' style='width:128px;height:128px;'/>
				<button id='slikaDel' type='submit' name='slikaDel' title='Obriši sliku'><img src='img/trash.png'></button></div>";
			}
		echo "<input type='file' name='slika'><br>
			<button id='urediKat' type='submit' name='urediKat' style='font-family:arial;'> Zaljepi promjene </button>
			<button id='delKat' type='submit' name='delKat'> Obriši kategoriju </button></form></blockquote</div>";
	}
}
?>
</ul></div>
<ul>
<?php
$id = $_GET['id'];
$id = mysqli_real_escape_string($conn,$_GET['id']);
$query = "SELECT a.id_kategorija, a.naziv, a.slika, a.nadkategorija_id,IFNULL(b.broj,0) AS br FROM kategorija AS a LEFT JOIN ( 
			SELECT id_kategorija, count(*) as broj FROM oglas WHERE aktivan = 1 GROUP BY id_kategorija) AS b 
				ON a.id_kategorija=b.id_kategorija WHERE nadkategorija_id = ".$id." ORDER BY id_kategorija ASC;";
$result = mysqli_query($conn,$query) or trigger_error()."in".$query;
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) { 
	echo"<h1 style='font-family:Satisfy;'>Podkategorije su:</h1>";
	while ($row = mysqli_fetch_assoc($result)){
		 #ispisati podkategorije ove kategorije
		echo"<div><li><a href='uredi_podkategoriju.php?id=" .$row['id_kategorija']."'>
			<i class='pin'></i>";
		$velicina = strlen($row['naziv']);
		if($velicina > 15){
			echo "<b>".$row['naziv']."</b>";
		}else{
			echo"<h2>" . $row['naziv'] . "</h2>"; }
		if($row['slika'] == 0){
			echo "<figure><img class='slProf1' src='uploads/kategorije/kategorija.png' /></figure>";
		}else{
			$imeSL = "uploads/kategorije/kategorija".$row['id_kategorija']."*";
			$infoSL = glob($imeSL);
			$extSL = explode(".", $infoSL[0]); 
			$actualextSL = $extSL[1]; 
			echo"<figure><img class='slProf1' src='uploads/kategorije/kategorija".$row['id_kategorija'].".".$actualextSL."' /></figure>";
		}
		echo"<p>Uredi podkategoriju</p></a></li></div>";
	}
}
$id = mysqli_real_escape_string($conn,$_GET['id']);
if(isset($_POST['urediKat'])){
	$id = $_POST['id'];
	$naziv = $_POST['naziv'];
	$slika = $_FILES['slika'];

	if($_FILES["slika"]["error"] == 4) {
		$sql = "UPDATE kategorija SET naziv = '$naziv' WHERE id_kategorija = ".$id.";";
		mysqli_query($conn, $sql);
		header("Location: uredi_kategoriju.php?id=".$id."");	
	}else{
		
		$slName = $_FILES['slika']['name'];
		$slTmpName = $_FILES['slika']['tmp_name'];
		$slSize = $_FILES['slika']['size'];
		$slError = $_FILES['slika']['error'];
		$slType = $_FILES['slika']['type'];

		$slExt = explode('.', $slName);
		$slActualExt = strtolower(end($slExt));

		$allowed = array('jpg', 'jpeg','png');

		if (in_array($slActualExt, $allowed)) {
			if($slError === 0){
				if($slSize < 10000000){
					#brisanje stare slike ako postoji
					$sqlST = "SELECT slika FROM kategorija;";
					$result = mysqli_query($conn, $sqlST);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) { 
						while ($row = mysqli_fetch_assoc($result)){
							if($row['slika'] === 1){

								$imeSL = "uploads\kategorije\kategorija".$id."*";
								$infoSL = glob($imeSL); #traži file koji ima dio imena koji se pretražuje
								$extSL = explode(".", $infoSL[0]); #potreban je prvi reuzltat (id 1 i id 11)
								$actualextSL = $extSL[1]; #drugi rezultat je ekstenzija slike
								$slika = "uploads\kategorije\kategorija".$id.".".$actualextSL;
								unlink($slika);
								$slNameNew = "kategorija". $id .".".$slActualExt; #ime nove slike koja se sprema
								$slDestination = 'uploads/kategorije/'.$slNameNew;
								move_uploaded_file($slTmpName, $slDestination);
								$sqlSVE = "UPDATE kategorija SET naziv = '$naziv', slika = '1' WHERE id_kategorija = ".$id.";";
								mysqli_query($conn, $sqlSVE);
								header("Location: uredi_kategoriju.php?id=".$id."");
							}else{
								$slNameNew = "kategorija". $id .".".$slActualExt; #ime nove slike koja se sprema
								$slDestination = 'uploads/kategorije/'.$slNameNew;
								move_uploaded_file($slTmpName, $slDestination);
								$sqlSVE = "UPDATE kategorija SET naziv = '$naziv', slika = '1' WHERE id_kategorija = ".$id.";";
								mysqli_query($conn, $sqlSVE);
								header("Location: uredi_kategoriju.php?id=".$id."");
							}	
						}
					}
				}else{
					header("Location: uredi_kategoriju.php?error=big_img&id=".$id);
				}
			}else{
				header("Location: uredi_kategoriju.php?error=error_img&id=".$id);
			}
		}else{
			header("Location: uredi_kategoriju.php?error=format&id=".$id);
		}
	}
	
}elseif(isset($_POST['delKat'])){

	$sql = "DELETE FROM kategorija 
				WHERE id_kategorija = " .$id. ";";
	mysqli_query($conn, $sql);
	$putanja = "uploads\kategorije".$id;
	unlink($putanja);
	header("Location: kategorije.php");
					
}
if(isset($_POST['slikaDel'])){			#BRISANJE SLIKE 
	$imeSL = "uploads\kategorije\kategorija".$id."*";
	$infoSL = glob($imeSL); #traži file koji ima dio imena koji se pretražuje
	$extSL = explode(".", $infoSL[0]); #potreban je prvi reuzltat (id 1 i id 11)
	$actualextSL = $extSL[1]; #drugi rezultat je ekstenzija slike

#BRISANJE SLIKE IZ FOLDERA
	$slika = "uploads\kategorije\kategorija".$id.".".$actualextSL;
	if(!unlink($slika)){
		echo"<h3>Slika nije izbrisana!</h3>";
	}
	$sql = "UPDATE kategorija SET slika = 0 WHERE id_kategorija = ".$id.";";
	mysqli_query($conn, $sql);
	header("Location: uredi_kategoriju.php?id=" .$id);
}
?>
</ul>
</div>
</div>
</div>
<?php 
	require "footer.php";
?>

