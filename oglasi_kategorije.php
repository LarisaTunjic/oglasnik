<?php 
	include 'header.php';
	$id = $_GET['id'];
?>
<div class="kategorije">
<div class="container">
<ul>
 <?php
	$sql = "SELECT a.id_kategorija, a.naziv, a.slika, a.nadkategorija_id,IFNULL(b.broj,0) AS br FROM kategorija AS a LEFT JOIN ( 
				SELECT id_kategorija, count(*) as broj FROM oglas WHERE aktivan = 1 GROUP BY id_kategorija) AS b 
					ON a.id_kategorija=b.id_kategorija WHERE nadkategorija_id = ".$id." ORDER BY id_kategorija ASC ;";
	$result = mysqli_query($conn, $sql);			#AKO IMA PODKATEGORIJE ISPISI IH
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0){
		while ($row = mysqli_fetch_assoc($result)) {		
			if(!(isset($_SESSION['id_tip']))){	#PRIKAZ ZA ANONIMNOG KORISNIKA
				echo"<li><a href='oglasi_kategorije.php?id=" .$row['id_kategorija']."'>
					<i class='pin'></i>";
				$velicina = strlen($row['naziv']);
				if($velicina > 15){
					echo $row['naziv'];
				}else{
					echo"<h2>" . $row['naziv'] . "</h2>"; }
				if($row['slika'] == 0){
					echo "<figure><img class='slProf1' src='uploads/kategorije/kategorija.png' /></figure>";
				}else{
					echo"<figure><img class='slProf1' src='uploads/kategorije/kategorija".$row['id_kategorija'].".png' /></figure>";
				}
				echo"<p class='br_ogl'>broj oglasa:" . $row['br'] ."</p></a></li>";
			}elseif($_SESSION['id_tip']=='0'){ #ADMIN PRIKAZ	
				echo"<li><a href='oglasi_kategorije.php?id=" .$row['id_kategorija']."'>
					<i class='pin'></i>";
				$velicina = strlen($row['naziv']);
				if($velicina > 15){
					echo $row['naziv'];
				}else{
					echo"<h2>" . $row['naziv'] . "</h2>"; }
				echo"<p class='br_ogl'>broj oglasa:" . $row['br'] ."</p></a></li>";
				if($row['slika'] == 0){
					echo "<figure><img class='slProf1' src='uploads/kategorije/kategorija.png' /></figure>";
				}else{
					echo"<figure><img class='slProf1' src='uploads/kategorije/kategorija".$row['id_kategorija'].".png' /></figure>";
				}
				echo"<p>Uredi kategoriju</p></a></li>";
			}elseif($_SESSION['id_tip']=='1'){	#obični korisnik
				echo"<li><a href='oglasi_kategorije.php?id=" .$row['id_kategorija']."'>
					<i class='pin'></i>";
				$velicina = strlen($row['naziv']);
				if($velicina > 15){
					echo $row['naziv'];
				}else{
					echo"<h2>" . $row['naziv'] . "</h2>"; }
				if($row['slika'] == 0){
					echo "<figure><img class='slProf1' src='uploads/kategorije/kategorija.png' /></figure>";
				}else{
					echo"<figure><img class='slProf1' src='uploads/kategorije/kategorija".$row['id_kategorija'].".png' /></figure>";
				}
				echo"<p class='br_ogl'>broj oglasa:" . $row['br'] ."</p></a></li>";
			}
		}
	}else{		#INAČE LISTA OGLASA
		$sql = "SELECT a.id_kategorija, a.naziv, a.slika, a.nadkategorija_id,IFNULL(b.broj,0) AS br FROM kategorija AS a LEFT JOIN ( 
					SELECT id_kategorija, count(*) as broj FROM oglas WHERE aktivan = 1 GROUP BY id_kategorija) AS b 
						ON a.id_kategorija=b.id_kategorija WHERE nadkategorija_id IS NULL ORDER BY id_kategorija ASC ;";
		$result = mysqli_query($conn, $sql);			
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck > 0){
			while ($row = mysqli_fetch_assoc($result)) {
				echo"
				<h6>Tip oglasa:</h6>
				<form action='"; echo $_SERVER['PHP_SELF']; echo "?id="; echo $id;echo"' method='post' class='form-row justify-content-between' name='form_filter' >
					<select class='tip_ogl col-md-5 form-control' name='value' method='POST'>
						<option value='0'>Svi</option>
						<option value='2'>Besplatni</option>
						<option value='1'>Plaćeni</option>
					</select>
					<input class='filter col-md-5 form-control' type='submit' value = 'Filtriraj'>
				</form>";

				$id = $_GET['id'];
				$id = mysqli_real_escape_string($conn,$_GET['id']);
				$query = "SELECT naziv FROM kategorija WHERE id_kategorija=" .$id .";";
				$result = mysqli_query($conn,$query);
				$resultCheck = mysqli_num_rows($result);
				if ($resultCheck > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<h1>" .$row['naziv']. "</h1>";		#ispis naziva kategorije
					}
				}
				if(isset($_POST['value'])) {
					if($_POST['value'] == '0'){
						$id = $_GET['id'];
						$id = mysqli_real_escape_string($conn,$_GET['id']);
						$query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, b.naziv FROM oglas AS a INNER JOIN(
									SELECT id_kategorija, naziv FROM kategorija)
									AS b ON a.id_kategorija=b.id_kategorija
									WHERE b.id_kategorija= " .$id ." AND aktivan='1';";
					}elseif($_POST['value'] == '2'){
						echo"<h1>Besplatni oglasi</h1>";
						$id = $_GET['id'];
						$id = mysqli_real_escape_string($conn,$_GET['id']);
						$query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, a.id_tip_oglas, b.naziv FROM oglas AS a INNER JOIN(
									SELECT id_kategorija, naziv FROM kategorija)
									AS b ON a.id_kategorija=b.id_kategorija
									WHERE b.id_kategorija = " .$id ." AND aktivan = '1' AND id_tip_oglas = '2';";
					}elseif($_POST['value'] == '1'){
						echo"<h1>Plaćeni oglasi</h1>";
						$id = $_GET['id'];
						$id = mysqli_real_escape_string($conn,$_GET['id']);
						$query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, a.id_tip_oglas, b.naziv FROM oglas AS a INNER JOIN(
									SELECT id_kategorija, naziv FROM kategorija)
									AS b ON a.id_kategorija=b.id_kategorija
									WHERE b.id_kategorija = " .$id ." AND aktivan = '1' AND id_tip_oglas = '1';";
					}
					$result = mysqli_query($conn,$query);		#ispis oglasa sa filterom
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
								<i class='pin'></i>";
								$velicina = strlen($row['naslov']);
								if($velicina > 8){
									echo $row['naslov'];
								}else{
									echo"<h2>" . $row['naslov'] . "</h2><bR>"; }
									echo"<br><p class=kontakt>Dodano: " .$row['vrijedi_od']. "</p>
										<p>Pogledaj oglas</p></a></li>";
						}
					}else{
						echo "<h6 id='tip'>Ova kategorija još ne sadrži oglase!</h6>";
					}
				}else{
					$id = $_GET['id'];						#ispis oglasa bez filtera
					$id = mysqli_real_escape_string($conn,$_GET['id']);
					$query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, b.naziv FROM oglas AS a INNER JOIN(
								SELECT id_kategorija, naziv FROM kategorija)
								AS b ON a.id_kategorija=b.id_kategorija
								WHERE b.id_kategorija= " .$id ." AND aktivan='1';";
					$result = mysqli_query($conn,$query);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
								<i class='pin'></i>";
								$velicina = strlen($row['naslov']);
								if($velicina > 8){
									echo $row['naslov'];
								}else{
									echo"<h2>" . $row['naslov'] . "</h2><bR>"; }
									echo"<br><p class=kontakt>Dodano: " .$row['vrijedi_od']. "</p>
										<p>Pogledaj oglas</p></a></li>";
						}
					}else{
						echo "<h6 id='tip'>Ova kategorija još ne sadrži oglase!</h6>";
					}
				}
			}
		}else{
			echo "<h1>" .$row['naziv']. "</h1>";
			echo "<h6 id='tip'>Ova kategorija još ne sadrži oglase!</h6>";
		}
	}
 ?>
</ul>
</div>
</div>
<?php 
	require "footer.php";
?>
