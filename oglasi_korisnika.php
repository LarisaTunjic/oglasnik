<?php 
	include 'header.php'
 ?>
 <div class="kategorije">
<div class="container">
<div class='pb-5'>
 <?php
	$id = $_GET['id'];
	$id = mysqli_real_escape_string($conn,$_GET['id']);
	$sql = "SELECT id_korisnik, korisnicko_ime FROM korisnik 
				 WHERE id_korisnik= ".$id.";";
	$result = mysqli_query($conn,$sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo"<div class='search-wrapper'><h1>Oglasi korisnika: ".$row['korisnicko_ime']."</h1></div>";
		}
	}
?>
<ul>
<?php
	$query = "SELECT a.id_oglas, a.id_korisnik, a.naslov, a.aktivan, CONCAT(SUBSTRING_INDEX(a.tekst,' ' ,3), '...') as tekst FROM oglas AS a INNER JOIN (
				SELECT id_korisnik, korisnicko_ime FROM korisnik WHERE id_korisnik= ".$id.") 
					AS b ON a.id_korisnik=b.id_korisnik WHERE aktivan='1'";
	$result = mysqli_query($conn,$query);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
				<i class='pin'></i>";
				$velicina = strlen($row['naslov']);
				if($velicina > 8){
					echo "<b>".$row['naslov']."</b>";
				}else{
					echo"<h2>" . $row['naslov'] . "</h2><br>"; }
				echo"<br><p>" .$row['tekst']. "</p><br>
				<br><p>Pogledaj oglas</p></a></li>";
		}
	}else{
		echo"<h3 id=obav>Ovaj korisnik nema još oglasa.</h3>";
	}
 ?>
</ul>
</div>
</div>
</div>
<?php 
	require "footer.php";
?>
