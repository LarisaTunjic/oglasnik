<?php 
	require "header.php";
 ?>
<div class="kategorije">
<div class="container">	
	<div class="search-wrapper">
		<h1> Kreiranje nove podkategorije </h1>
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
 <?php
 $id_nadkategorija = $_GET['id'];
 ?>
<div class="pb-5">
	<i class="pin"></i>
	<blockquote class="note yellow">
	<form action='<?php echo $_SERVER['PHP_SELF']; echo "?id="; echo $id_nadkategorija;?>' method="POST" enctype="multipart/form-data">
		Naziv podkategorije:<br> <input type="text" name="naziv"><br>
		Slika podkategorije: <br><input type="file" name="slika"><br>
		<button id="dodajKat" type="submit" name="dodajKat"> Zaljepi podkategoriju </button>
	</form>
	</blockquote>
</div>
<?php 
if(isset($_POST['dodajKat'])){
	$naziv = $_POST['naziv'];
	$slika = $_FILES['slika'];
	$id_nadkategorija = $_GET['id'];

	$query = "SELECT max(id_kategorija) FROM kategorija;";
	$result = mysqli_query($conn, $query);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) { 
		while ($row = mysqli_fetch_assoc($result)) {
			$id_kategorija = ($row['max(id_kategorija)']+1);
							
			if($_FILES["slika"]["error"] == 4) {
				$sql = "INSERT INTO kategorija (id_kategorija, naziv, slika, nadkategorija_id) 
				VALUES ('$id_kategorija','$naziv','0', '$id_nadkategorija')";
				$result = mysqli_query($conn, $sql) or trigger_error()."in".$sql;	
				header("Location: kategorije.php?uploadsuccess");
			}else{
				$slName = $_FILES['slika']['name'];
				$slTmpName = $_FILES['slika']['tmp_name'];
				$slSize = $_FILES['slika']['size'];
				$slError = $_FILES['slika']['error'];
				$slType = $_FILES['slika']['type'];

				$slExt = explode('.', $slName);
				$slActualExt = strtolower(end($slExt));

				$allowed = array('png');

				if (in_array($slActualExt, $allowed)) {
					if($slError === 0){
						if($slSize < 1000000){
							$query = "SELECT max(id_kategorija) FROM kategorija;";
							$result = mysqli_query($conn, $query);
							$resultCheck = mysqli_num_rows($result);
							if ($resultCheck > 0) { 
								while ($row = mysqli_fetch_assoc($result)) {
									$id_kategorija = ($row['max(id_kategorija)']+1);
									
									$slNameNew = "kategorija". $id_kategorija.".png"; #ime slike koja se sprema
									$slDestination = 'uploads/kategorije/'.$slNameNew;
									move_uploaded_file($slTmpName, $slDestination);

									$sql = "INSERT INTO kategorija (id_kategorija, naziv, slika, nadkategorija_id) 
									VALUES ('$id_kategorija','$naziv','1', '$id_nadkategorija')";
									$result = mysqli_query($conn, $sql) or trigger_error()."in".$sql;	
									header("Location: kategorije.php?uploadsuccess");	
								}
							}
						}else{
							header("Location: uredi_kategoriju.php?error=big_img&id=".$id_nadkategorija);
						}
					}else{
						header("Location: uredi_kategoriju.php?error=error_img&id=".$id_nadkategorija);
					}
				}else{
					header("Location: uredi_kategoriju.php?error=format&id=".$id_nadkategorija);
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
