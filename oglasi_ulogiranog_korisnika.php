<?php 
	include 'header.php';
	
?>
<div class="kategorije">
<div class="container">
	<div class="search-wrapper justify-content-between">
		<h1>Aktivni oglasi</h1>
		<form action="favoriti.php"  method="post">
		<button id="urediProfil" type="submit" name="favoriti"><img src='img/star1.png' height=22px; weight=22px;> Favoriti </button></form>
		<form action="uredi_profil.php"  method="post">
		<button id="urediProfil" type="submit" name="urediProfil"> Moj profil </button></form>
	</div>

<?php 
if (isset($_SESSION['kor_id'])){
	$sql = "SELECT id_oglas, id_korisnik, id_tip_oglas, naslov, DATE_FORMAT(vrijedi_do, '%Y-%m-%d') AS datum FROM oglas 
				WHERE id_korisnik=" . $_SESSION['kor_id']. " AND aktivan = '1';";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	echo"<div class='pb-5'><ul>";
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<li><a href='uredi_oglas.php?id=" .$row['id_oglas']."'>
				<i class='pin'></i>	
				<h2>" .$row['naslov']. "</h2>";
				if($row['id_tip_oglas'] == 1){
					echo "<p class=placeni-pill>Plaćen oglas</p>";
				}
				echo "Ističe ";
				$datum = $row['datum'];
            	$datum = strtotime($datum);
           		$danas = date("Y-m-d");
            	$danas = strtotime($danas);
            	$datediff = $datum - $danas ;
				$rezultat = round($datediff / 86400);
				if ($rezultat == 1){
					echo "sutra</p>";
				}else{
					echo "za ".$rezultat." dana</p>";
				}
				echo"<p>Uredi oglas</p></a></li>";
		}
	}
	elseif ($resultCheck == 0) {
		echo"<div class='quote-container'>
		  <i class='pin'></i>
		  <blockquote class='note yellow' style='font-size: 32px; font-family:Satisfy; padding-left: 46px;'>
		 Nemate aktivnih oglasa.</blackquote></div>";
	}
 }
 ?>
</ul>

<h1 class="naslov-oglasa" style="font-family:Satisfy" ><b>Neaktivni oglasi</b></h1>
<ul>
<?php 
if (isset($_SESSION['kor_id'])){
	$sql = "SELECT id_oglas, id_korisnik, naslov, aktivan, vrijedi_do  FROM oglas 
				WHERE id_korisnik=" . $_SESSION['kor_id']. " AND (aktivan = '2' OR aktivan='0');";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);

	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<li><a href='uredi_oglas.php?id=" .$row['id_oglas']."'>
				<i class='pin'></i>	
				<h2>" .$row['naslov']. "</h2>";
			if(($row['aktivan']) == 2){
				echo"<p>Oglas je istekao</p>
				<p>Produžite oglas</p>
				<p>Uredi oglas</p></a></li>";
			}elseif($row['aktivan'] == 0){
				echo"<p>Oglas čeka odobrenje</p>
				<p>Uredi oglas</p></a></li>";
			}
				
		}
	}
	elseif ($resultCheck == 0) {
		echo"<div class='quote-container'>
		  <i class='pin'></i>
		  <blockquote class='note yellow' style='font-size: 32px; font-family:Satisfy; padding-left: 35px;'>
		 Nemate neaktivnih oglasa.</blackquote></div>";
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
