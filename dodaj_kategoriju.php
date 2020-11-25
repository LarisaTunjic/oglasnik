<?php 

	require "header.php";
	ob_start();
 ?>
<div class="kategorije">
<div class="container">	
	<div class="search-wrapper">
 		<h1> Kreiranje nove kategorije </h1>
<?php
 	if(isset($_GET['error'])){
		if($_GET['error'] == "big_img"){
			echo"<h2 class='greska'>*Greška: Slika je prevelika.</h2>";
		}elseif($_GET['error'] == "error_img"){
			echo"<h2 class='greska'>*Greška: Dogodila se greška.</h2>";
		}elseif($_GET['error'] == "error_img"){
			echo"<h2 class='greska'>*format: Ova vrsta slike nije dozvoljena..</h2>";
		}
	}
?>
	</div>
<div class="pb-5">
	<i class="pin"></i>
	<blockquote class="note yellow">
	<form  action="dodaj_kategoriju.php" method="POST" enctype="multipart/form-data">
		Naziv kategorije:<br> <input type="text" name="naziv"><br>
		Slika kategorije: <br><input type="file" name="slika"><br>
		<button id="dodajKat" type="submit" name="dodajKat"> Zaljepi kategoriju </button>
	</form>
	</blockquote>
</div>
<?php 
if(isset($_POST['dodajKat'])){
	$naziv = $_POST['naziv'];
	$slika = $_FILES['slika'];

	$query = "SELECT max(id_kategorija) FROM kategorija;";
	$result = mysqli_query($conn, $query);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) { 
		while ($row = mysqli_fetch_assoc($result)) {
			$id_kategorija = ($row['max(id_kategorija)']+1);
							
			if($_FILES["slika"]["error"] == 4) {	# dodavanja samo naslova
				$sql = "INSERT INTO kategorija (id_kategorija, naziv, slika) VALUES ('$id_kategorija','$naziv','0')";
				$result = mysqli_query($conn, $sql) or trigger_error()."in".$sql;	
				header("Location: kategorije.php?uploadsuccess");	
			}else{									#dodavanje naslova i slike
				$slName = $_FILES['slika']['name'];
				$slTmpName = $_FILES['slika']['tmp_name'];
				$slSize = $_FILES['slika']['size'];
				$slError = $_FILES['slika']['error'];
				$slType = $_FILES['slika']['type'];

				$slExt = explode('.', $slName);
				$slActualExt = strtolower(end($slExt));

				$allowed = array('jpg', 'jpeg', 'png');

				if (in_array($slActualExt, $allowed)) {
					if($slError === 0){
						if($slSize < 1000000){
							$query = "SELECT max(id_kategorija) FROM kategorija;";
							$result = mysqli_query($conn, $query);
							$resultCheck = mysqli_num_rows($result);
							if ($resultCheck > 0) { 
								while ($row = mysqli_fetch_assoc($result)) {
									$id_kategorija = ($row['max(id_kategorija)']+1);
									
									$slNameNew = "kategorija". $id_kategorija.".".$slActualExt; #ime slike koja se sprema
									$slDestination = 'uploads/kategorije/'.$slNameNew;
									move_uploaded_file($slTmpName, $slDestination);

									$sql = "INSERT INTO kategorija (id_kategorija, naziv, slika) VALUES ('$id_kategorija','$naziv','1')";
									$result = mysqli_query($conn, $sql) or trigger_error()."in".$sql;	
									header("Location: kategorije.php?uploadsuccess");	
								}
							}
						}else{
							header("Location: uredi_kategoriju.php?error=big_img");
						}
					}else{
						header("Location: uredi_kategoriju.php?error=error_img");
					}
				}else{
					header("Location: uredi_kategoriju.php?error=format");
				}
			}
		}
	}
}
?>
</div>
</div>
<?php 
	require "footer.php";
?>