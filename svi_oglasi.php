<?php 
	include 'header.php';
?>
<div class="kategorije">
<div class="container">	
	<div class="search-wrapper" style="font-family: roboto;">
	<span>
		<?php
			if(isset($_POST['value'])) {
				if($_POST['value'] == '0'){
					echo"<h1>Svi oglasi</h1>";
				}
				elseif($_POST['value'] == '2'){
					echo"<h1>Besplatni oglasi</h1>";
				}elseif($_POST['value'] == '1'){
					echo"<h1>Plaćeni oglasi</h1>";
				}
			}
		?>
	</span>
	<?php 
		if(isset($_SESSION['kor_id'])){
			if($_SESSION['id_tip']=='0'){
			echo'<form action=odobri_oglase.php class="odobri_ogl" method="post">
				<button class="btn" type="submit" name="odobri_ogl"> Odobri oglase</button>
				</form>';
			}
		}?>
	<h6 id=tip>Tip oglasa:</h6>
	<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' class='form-row justify-content-between' name='form_filter' >
		<select class="tip_ogl col-md-5 form-control" name="value" method="POST">";
			<option value='0'>Svi</option>
			<option value='2'>Besplatni</option>
			<option value='1'>Plaćeni</option>
		</select>
		<input class="filter col-md-5 form-control" type='submit' value = 'Filtriraj'>
	</form>
</div>
<div class='pb-5'>
<ul>
 <?php
if(isset($_POST['value'])) {
	if($_POST['value'] == '0'){
		$sql = "SELECT id_oglas, b.id_kategorija, b.naziv, id_tip_oglas, naslov, aktivan, vrijedi_do,DATE_FORMAT(vrijedi_od, '%Y-%m-%d') AS datum FROM oglas AS a INNER JOIN(
			SELECT id_kategorija, naziv FROM kategorija) AS b ON a.id_kategorija=b.id_kategorija
			WHERE aktivan='1' AND id_tip_oglas = '1' ORDER BY datum DESC;";			#plaćeni oglasi

		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<li class='placeni'><a href='oglas.php?id=" .$row['id_oglas']."'>
					<i class='pin'></i>";
					$velicina = strlen($row['naslov']);
					if($velicina > 8){
						echo "<p class=placeni-pill><b>".$row['naslov']."</b></p>";
					}else{
						echo"<h2>" . $row['naslov'] . "</h2><br>"; }
					echo"<p style='font-style: italic'>" .$row['naziv']."</p>
					<p class=kontakt>Objavljeno ";
					$datum = $row['datum'];
					$datum = strtotime($datum);
					$danas = date("Y-m-d");
					$danas = strtotime($danas);
					$datediff = $danas - $datum ;
					$rezultat = round($datediff / 86400);
					if ($rezultat == 1){
						echo "jučer</p>";
					}elseif($rezultat == 0){
						echo "danas</p>";
					}else{
						echo "prije ". $rezultat." dana</p>";
					}
					echo"<p>Pogledaj oglas</p></a></li>";
				if (!function_exists('deaktivacijaOglasa')) {
					function deaktivacijaOglasa($vrijedi_do){
						$danas = strtotime(date("Y-m-d H:i:s"));
						$razlika = $danas - strtotime($vrijedi_do);
						if($razlika > 1){
							return true;
						}
					}
				}
				if(deaktivacijaOglasa($row['vrijedi_do'])){
					$sql = "UPDATE oglas SET aktivan = '2' AND id_tip_oglas = '2'
								WHERE id_oglas = " .$row['id_oglas']. ";" ;
					mysqli_query($conn, $sql);

					$sql = "SELECT a.id_oglas, a.id_korisnik, a.naslov, b.email FROM oglas AS a INNER JOIN( 
								SELECT id_korisnik, email FROM korisnik) AS b ON a.id_korisnik=b.id_korisnik 
								WHERE aktivan='2';";
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) { 
						while ($row = mysqli_fetch_assoc($result)){
							$naslov = $row['naslov'];
							$mail = $row['email'];
							$subject = "Isticanje oglasa ".$naslov;
							$body_message = "http://localhost//oglasnik/uredi_oglas.php?id=".$row['id_oglas'];
							$poruka = "Poštovani, oglas Vam je istekao. Posjetite nas ponovo za obnovu oglasa ili izradu novog.";
							
							mail($mail, $subject, $body_message, $poruka);
						}
					}
				}
			}
		}$sqlB = "SELECT id_oglas, b.id_kategorija, b.naziv, id_tip_oglas, naslov, aktivan, vrijedi_do,DATE_FORMAT(vrijedi_od, '%Y-%m-%d') AS datum FROM oglas AS a INNER JOIN(
			SELECT id_kategorija, naziv FROM kategorija) AS b ON a.id_kategorija=b.id_kategorija
			WHERE aktivan='1' AND id_tip_oglas = '2' ORDER BY datum DESC;";					#besplatni oglasi

		$resultB = mysqli_query($conn, $sqlB);
		$resultCheckB = mysqli_num_rows($resultB);
		if ($resultCheckB > 0) {
			while ($row = mysqli_fetch_assoc($resultB)) {
				echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
					<i class='pin'></i>";
					$velicina = strlen($row['naslov']);
					if($velicina > 8){
						echo "<b>".$row['naslov']."</b>";
					}else{
						echo"<h2>" . $row['naslov'] . "</h2><br>"; }
					echo"<p style='font-style: italic'>" .$row['naziv']."</p>
					<p class=kontakt>Objavljeno ";
					$datum = $row['datum'];
					$datum = strtotime($datum);
					$danas = date("Y-m-d");
					$danas = strtotime($danas);
					$datediff = $danas - $datum ;
					$rezultat = round($datediff / 86400);
					if ($rezultat == 1){
						echo "jučer</p>";
					}elseif($rezultat == 0){
						echo "danas</p>";
					}else{
						echo "prije ". $rezultat." dana</p>";
					}
					echo"<p>Pogledaj oglas</p></a></li>";
				if (!function_exists('deaktivacijaOglasa')) {
					function deaktivacijaOglasa($vrijedi_do){
						$danas = strtotime(date("Y-m-d H:i:s"));
						$razlika = $danas - strtotime($vrijedi_do);
						if($razlika > 1){
							return true;
						}
					}
				}
				if(deaktivacijaOglasa($row['vrijedi_do'])){
					$sql = "UPDATE oglas SET aktivan = '2' AND id_tip_oglas = '2'
								WHERE id_oglas = " .$row['id_oglas']. ";" ;
					mysqli_query($conn, $sql);

					$sql = "SELECT a.id_oglas, a.id_korisnik, a.naslov, b.email FROM oglas AS a INNER JOIN( 
								SELECT id_korisnik, email FROM korisnik) AS b ON a.id_korisnik=b.id_korisnik 
								WHERE aktivan='2';";
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck > 0) { 
						while ($row = mysqli_fetch_assoc($result)){
							$naslov = $row['naslov'];
								$mail = $row['email'];
								$subject = "Isticanje oglasa '".$naslov."'";
								$body_message = "http://localhost//oglasnik/uredi_oglas.php?id=".$row['id_oglas'];
								$poruka = "Poštovani, oglas Vam je istekao. Posjetite nas ponovo za obnovu oglasa ili izradu novog.";
								
								mail($mail, $subject, $body_message, $poruka);
						}
					}
				}
			}
		}
 	}elseif($_POST['value'] == '2'){
		$sql = "SELECT id_oglas, b.id_kategorija, b.naziv, id_tip_oglas, naslov, aktivan, vrijedi_do, DATE_FORMAT(vrijedi_od, '%Y-%m-%d') AS datum FROM oglas AS a INNER JOIN(
					SELECT id_kategorija, naziv FROM kategorija) AS b ON a.id_kategorija=b.id_kategorija
					WHERE id_tip_oglas='2' AND aktivan='1' ORDER BY datum DESC;";
	}elseif($_POST['value'] == '1'){
		$sql = "SELECT id_oglas, b.id_kategorija, b.naziv, id_tip_oglas, naslov, aktivan, vrijedi_do, DATE_FORMAT(vrijedi_od, '%Y-%m-%d') AS datum FROM oglas AS a INNER JOIN(
					SELECT id_kategorija, naziv FROM kategorija) AS b ON a.id_kategorija=b.id_kategorija
					WHERE id_tip_oglas='1' AND aktivan='1' ORDER BY datum DESC;";
	}
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
				<p class=kontakt>Objavljeno ";
				$datum = $row['datum'];
            	$datum = strtotime($datum);
           		$danas = date("Y-m-d");
            	$danas = strtotime($danas);
            	$datediff = $danas - $datum ;
				$rezultat = round($datediff / 86400);
				if ($rezultat == 1){
					echo "jučer</p>";
				}elseif($rezultat == 0){
					echo "danas</p>";
				}else{
					echo "prije ". $rezultat." dana</p>";
				}
				echo"<p>Pogledaj oglas</p></a></li>";
			if (!function_exists('deaktivacijaOglasa')) {
				function deaktivacijaOglasa($vrijedi_do){
					date_default_timezone_set('Europe/Zagreb');
					$danas = strtotime(date("Y-m-d H:i:s"));
					$razlika = $danas - strtotime($vrijedi_do);
					if($razlika > 1){
						return true;
					}
				}
			}
				if(deaktivacijaOglasa($row['vrijedi_do'])){
					$sql = "UPDATE oglas SET aktivan = '2'
								WHERE id_oglas = " .$row['id_oglas']. ";" ;
					mysqli_query($conn, $sql);
				}
		}
	}
}else{
	$sql = "SELECT id_oglas, b.id_kategorija, b.naziv, id_tip_oglas, naslov, aktivan, vrijedi_do,DATE_FORMAT(vrijedi_od, '%Y-%m-%d') AS datum FROM oglas AS a INNER JOIN(
			SELECT id_kategorija, naziv FROM kategorija) AS b ON a.id_kategorija=b.id_kategorija
			WHERE aktivan='1' AND id_tip_oglas = '1' ORDER BY datum DESC;";			#plaćeni oglasi

	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<li class='placeni'><a href='oglas.php?id=" .$row['id_oglas']."'>
				<i class='pin'></i>";
				$velicina = strlen($row['naslov']);
				if($velicina > 8){
					echo "<p class=placeni-pill><b>".$row['naslov']."</b></p>";
				}else{
					echo"<h2>" . $row['naslov'] . "</h2><br>"; }
				echo"<p style='font-style: italic'>" .$row['naziv']."</p>
				<p class=kontakt>Objavljeno ";
				$datum = $row['datum'];
            	$datum = strtotime($datum);
           		$danas = date("Y-m-d");
            	$danas = strtotime($danas);
            	$datediff = $danas - $datum ;
				$rezultat = round($datediff / 86400);
				if ($rezultat == 1){
					echo "jučer</p>";
				}elseif($rezultat == 0){
					echo "danas</p>";
				}else{
					echo "prije ". $rezultat." dana</p>";
				}
				echo"<p>Pogledaj oglas</p></a></li>";
			if (!function_exists('deaktivacijaOglasa')) {
				function deaktivacijaOglasa($vrijedi_do){
					$danas = strtotime(date("Y-m-d H:i:s"));
					$razlika = $danas - strtotime($vrijedi_do);
					if($razlika > 1){
						return true;
					}
				}
			}
			if(deaktivacijaOglasa($row['vrijedi_do'])){
				$sql = "UPDATE oglas SET aktivan = '2' AND id_tip_oglas = '2'
							WHERE id_oglas = " .$row['id_oglas']. ";" ;
				mysqli_query($conn, $sql);

				$sql = "SELECT a.id_oglas, a.id_korisnik, a.naslov, b.email FROM oglas AS a INNER JOIN( 
							SELECT id_korisnik, email FROM korisnik) AS b ON a.id_korisnik=b.id_korisnik 
							WHERE aktivan='2';";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				if ($resultCheck > 0) { 
					while ($row = mysqli_fetch_assoc($result)){
						$naslov = $row['naslov'];
						$mail = $row['email'];
						$subject = "Isticanje oglasa ".$naslov;
						$body_message = "http://localhost//oglasnik/uredi_oglas.php?id=".$row['id_oglas'];
						$poruka = "Poštovani, oglas Vam je istekao. Posjetite nas ponovo za obnovu oglasa ili izradu novog.";
						
						mail($mail, $subject, $body_message, $poruka);
					}
				}
			}
		}
	}$sqlB = "SELECT id_oglas, b.id_kategorija, b.naziv, id_tip_oglas, naslov, aktivan, vrijedi_do,DATE_FORMAT(vrijedi_od, '%Y-%m-%d') AS datum FROM oglas AS a INNER JOIN(
		SELECT id_kategorija, naziv FROM kategorija) AS b ON a.id_kategorija=b.id_kategorija
		WHERE aktivan='1' AND id_tip_oglas = '2' ORDER BY datum DESC;";					#besplatni oglasi

	$resultB = mysqli_query($conn, $sqlB);
	$resultCheckB = mysqli_num_rows($resultB);
	if ($resultCheckB > 0) {
		while ($row = mysqli_fetch_assoc($resultB)) {
			echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
				<i class='pin'></i>";
				$velicina = strlen($row['naslov']);
				if($velicina > 8){
					echo "<b>".$row['naslov']."</b>";
				}else{
					echo"<h2>" . $row['naslov'] . "</h2><br>"; }
				echo"<p style='font-style: italic'>" .$row['naziv']."</p>
				<p class=kontakt>Objavljeno ";
				$datum = $row['datum'];
				echo $datum.'<br>';
				$datum = strtotime($datum);
				echo $datum.'<br>';
				   $danas = strtotime(date("Y-m-d"));
				   echo $danas.'<br>';
				$datediff = $danas - $datum ;
				echo $datediff.'<br>';
				$rezultat = round($datediff / 86400);
				if ($rezultat == 1){
					echo "jučer</p>";
				}elseif($rezultat == 0){
					echo "danas</p>";
				}else{
					echo "prije ". $rezultat." dana</p>";
				}
				echo"<p>Pogledaj oglas</p></a></li>";
			if (!function_exists('deaktivacijaOglasa')) {
				function deaktivacijaOglasa($vrijedi_do){
					$danas = strtotime(date("Y-m-d H:i:s"));
					$razlika = $danas - strtotime($vrijedi_do);
					if($razlika > 1){
						return true;
					}
				}
			}
			if(deaktivacijaOglasa($row['vrijedi_do'])){
				$sql = "UPDATE oglas SET aktivan = '2' AND id_tip_oglas = '2'
							WHERE id_oglas = " .$row['id_oglas']. ";" ;
				mysqli_query($conn, $sql);

				$sql = "SELECT a.id_oglas, a.id_korisnik, a.naslov, b.email FROM oglas AS a INNER JOIN( 
							SELECT id_korisnik, email FROM korisnik) AS b ON a.id_korisnik=b.id_korisnik 
							WHERE aktivan='2';";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				if ($resultCheck > 0) { 
					while ($row = mysqli_fetch_assoc($result)){
						$naslov = $row['naslov'];
							$mail = $row['email'];
							$subject = "Isticanje oglasa '".$naslov."'";
							$body_message = "http://localhost//oglasnik/uredi_oglas.php?id=".$row['id_oglas'];
							$poruka = "Poštovani, oglas Vam je istekao. Posjetite nas ponovo za obnovu oglasa ili izradu novog.";
							
							mail($mail, $subject, $body_message, $poruka);
					}
				}
			}
		}
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
