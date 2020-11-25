<?php 
	include 'header.php'
 ?>
<div class="kategorije">
<div class="container">	
	<div class="row search-wrapper">
		<div class="col-md-6">
			<h1>Rezultat pretrage</h1>
		</div>
		<div class="col-md-6">
			<?php
				$search = mysqli_real_escape_string($conn, $_POST['search']);
				$sql = "SELECT a.id_oglas, a.id_kategorija, a.naslov, b.naziv, CONCAT(SUBSTRING_INDEX(tekst,' ' ,3), '...') as tekst FROM oglas AS a INNER JOIN( 
							SELECT id_kategorija, naziv FROM kategorija) AS b ON a.id_kategorija=b.id_kategorija 
								WHERE aktivan = 1 AND naslov LIKE '%".$search."%' OR tekst LIKE '%".$search."%';";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				echo "<h6 id=tip style='padding-left: 12px; margin-left: -161px; margin-right: 475px;'>Broj rezultata: " . $resultCheck . "</h2>";
			?>
		</div>
	</div>
 <?php
 if (isset($_POST['searchBut'])) {#funkcija provjerava dali je upisan string
 	$search = mysqli_real_escape_string($conn, $_POST['search']);
 	$sql = "SELECT a.id_oglas, a.id_kategorija, a.naslov, b.naziv, CONCAT(SUBSTRING_INDEX(tekst,' ' ,3), '...') as tekst FROM oglas AS a INNER JOIN( 
 				SELECT id_kategorija, naziv FROM kategorija) AS b ON a.id_kategorija=b.id_kategorija 
 					WHERE aktivan = 1 AND naslov LIKE '%".$search."%' OR tekst LIKE '%".$search."%';";
 	$result = mysqli_query($conn, $sql);
 	$resultCheck = mysqli_num_rows($result);
	 echo"<div class='pb-5'><ul>";
 	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
				<i class='pin'></i>
				<h2>" .$row['naslov']. "</h2>
				<p style='font-style: italic'>" .$row['naziv']."</p>
				" .$row['tekst']. "
				<p>Pogledaj oglas</p></a></li>";
		}
	}
	else{
		echo"<div class='quote-container'>
		<i class='pin'></i>
		<blockquote class='note yellow' style='font-size: 32px; font-family:Satisfy; padding-left: 42px;'>
		Nema rezultata pretrage.</blackquote></div>";
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
