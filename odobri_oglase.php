<?php 

	require "header.php";

 ?>
 <div class="kategorije">
<div class="container">
	<div class="search-wrapper">
		<h1>Neodobreni oglasi</h1>
	</div>
<div class='pb-5'>
 <ul>
 <?php 
	$sql = "SELECT a.id_oglas, a.id_kategorija, a.id_tip_oglas, a.naslov, a.aktivan, a.kontakt_o, b.naziv FROM oglas AS a INNER JOIN(
			SELECT id_kategorija, naziv FROM kategorija) AS b ON a.id_kategorija=b.id_kategorija WHERE aktivan ='0';";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
			<i class='pin'></i>";
			$velicina = strlen($row['naslov']);
			if($velicina > 8){
				echo "<b>".$row['naslov']."</b>";
			}else{
				echo"<h2>" . $row['naslov'] . "</h2><bR>"; }
			echo"<p style='font-style: italic'>" .$row['naziv']."</p>
				<p>Pogledaj oglas</p></a></li>";
				
		}
	}else{
		echo"<div class='quote-container'>
		<i class='pin'></i>
		<blockquote class='note yellow' style='font-family: Satisfy; font-size: 35px;'>
		Svi oglasi su odobreni.</blackquote></div>";
	}
?>
</ul>
</div>
</div>
</div>
<?php 
	require "footer.php";
?>