<?php 
	include 'header.php';
	ob_start();
?>
<div class="oglas main-background">
<div class="container">
<div class="papirici">
<style>
	@media print{
		
		.printer, .poruka, .ostalo,  .favorit, .korisnik, #DelBut, footer, .subfooter{
			display:none;
		}
		.ispis, .ispis*{
			visibility:visible;
		}
	}
</style>
<?php
$id = $_GET['id'];
$id = mysqli_real_escape_string($conn,$_GET['id']);
$sql = "SELECT *  FROM oglas AS a INNER JOIN(
			SELECT id_korisnik, korisnicko_ime, kontakt_k FROM korisnik)
    			AS b ON a.id_korisnik=b.id_korisnik WHERE id_oglas=" .$id. ";" ;
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)) {
	if(!(isset($_SESSION['kor_id']))){
		echo"<blockquote class='note1'>
		<i class='pin1'></i>";
		echo"<a class='printer'onclick='window.print();'><img src='img/printer.png' height=22px; weight=22px></a>";
		echo "<div class='ispis'><b>" .$row['naslov']."</b><br>
			<i>Opis oglasa: </i>" .$row['tekst']."<br>
			<i>Kontakt oglasa: </i>" .$row['kontakt_o']. "<br>
			<p class='ostalo'><i>Pogledaj ostale oglase korisnika:</i>
			<a href='oglasi_korisnika.php?id=" .$row['id_korisnik']."'><b>".$row['korisnicko_ime']."</b></a></p>";
			if($row['kontakt_k']==0){
				
			}else{
				echo"<br> <i>Tel/Mob: </i>" .$row['kontakt_k']. "<br>";
			}
			echo"<form  action='poruka.php?idk=" .$row['id_korisnik']."&ido=". $row['id_oglas'] ."' method='post'>
				<button class='poruka' type='submit' name='poruka'> Pošalji poruku korisniku</button></form>
				<i>Oglas je aktivan do:</i> $row[vrijedi_do]";
			$sqlU = "UPDATE `oglas` SET `br_pogleda` = `br_pogleda`+ '1' WHERE `id_oglas` =  ".$row['id_oglas']."; ";
			$resultU = mysqli_query($conn,$sqlU);
			$sqlBP = "SELECT br_pogleda FROM oglas WHERE id_oglas = ".$row['id_oglas']."; ";
			$resultBP = mysqli_query($conn,$sqlBP);
			while($row = mysqli_fetch_array($resultBP)){
				echo"<br><img src='img/eye.png'height=22px; weight=22px;> <i>Oglas pogledan:</i> <b>".$row['br_pogleda']."</b> puta</blockquote>";
			}
	}elseif($_SESSION['id_tip']=='1'){
		echo"<blockquote class='note1'>
		<i class='pin1'></i>";
		echo"<a class='printer'onclick='window.print();'><img src='img/printer.png' height=22px; weight=22px></a>";
		echo "<div class='ispis'><div class='search-wrapper justify-content-between'><b>" . $row['naslov']."</b><br>";
			$sqlP = "SELECT * FROM spremljeni_oglasi WHERE id_korisnik = ".$_SESSION['kor_id']." AND id_oglas = ".$row['id_oglas'].";";
			$resultP = mysqli_query($conn,$sqlP);
			$resultCheckP = mysqli_num_rows($resultP);
			if ($resultCheckP == 0) {
				echo"<a class=favorit href='spremanje_oglasa.php?idk=" .$_SESSION['kor_id']."&ido=". $row['id_oglas'] ."' title='Spremi u favorite'><img src='img/star.png' height=22px; weight=22px;></a></div>";
			}else{
				echo"</div>";
			}
			echo"<i>Opis oglasa: </i>" .$row['tekst']."<br>
			<i>Oglas istiće: </i>". $row['vrijedi_do']."<br>
			<i>Kontakt oglasa: </i>" .$row['kontakt_o']. "<br>
			<p class='ostalo'><i>Pogledaj ostale oglase korisnika:</i>
			<a href='oglasi_korisnika.php?id=" .$row['id_korisnik']."'><b>".$row['korisnicko_ime']."</b></a></p>";
			if($row['kontakt_k']==0){
				
			}else{
				echo"<br> <i>Tel/Mob: </i>" .$row['kontakt_k']. "<br>";
			}
			echo"<form  action='poruka.php?idk=" .$row['id_korisnik']."&ido=". $row['id_oglas'] ."' method='post'>
				<button class='poruka' type='submit' name='poruka'> Pošalji poruku korisniku</button></form>
				<i>Oglas je aktivan do:</i> $row[vrijedi_do]";
			$sqlU = "UPDATE `oglas` SET `br_pogleda` = `br_pogleda`+ '1' WHERE `id_oglas` =  ".$row['id_oglas']."; ";
			$resultU = mysqli_query($conn,$sqlU);
			$sqlBP = "SELECT br_pogleda FROM oglas WHERE id_oglas = ".$row['id_oglas']."; ";
			$resultBP = mysqli_query($conn,$sqlBP);
			while($row = mysqli_fetch_array($resultBP)){
				echo"<br><img src='img/eye.png'height=22px; weight=22px;><i> Oglas pogledan:</i> <b>".$row['br_pogleda']."</b> puta</blockquote>";
			}
	}
	if(isset($_SESSION['kor_id'])){
		if($_SESSION['id_tip']=='0'){
			echo"<blockquote class='note1 yellow'>
			<i class='pin1'></i>";
			echo"<a class='printer'onclick='window.print();'><img src='img/printer.png' height=22px; weight=22px></a>";
			echo"<div class='search-wrapper justify-content-between'><b>" . $row['naslov']."</b>";
				$sqlP = "SELECT * FROM spremljeni_oglasi WHERE id_korisnik = ".$_SESSION['kor_id']." AND id_oglas = ".$row['id_oglas'].";";
				$resultP = mysqli_query($conn,$sqlP);
				$resultCheckP = mysqli_num_rows($resultP);
				if ($resultCheckP == 0) {
					echo"<a class='favorit'href='spremanje_oglasa.php?idk=" .$_SESSION['kor_id']."&ido=". $row['id_oglas'] ."' title='Spremi u favorite'><img src='img/star.png' height=22px; weight=22px;></a></div>";
				}else{
					echo"</div>";
				}
				echo"<i>Opis oglasa:</i> " .$row['tekst']."<br>
				<i>Kontakt oglasa:</i> " .$row['kontakt_o']. "<br>
				<p class='ostalo'><i>Pogledaj ostale oglase korisnika:</i>
				<a href='oglasi_korisnika.php?id=" .$row['id_korisnik']."'><b>".$row['korisnicko_ime']."</b></a></p>";
			if($row['kontakt_k']==0){
				
			}else{
				echo"<br> <i>Tel/Mob: </i>" .$row['kontakt_k']. "<br>";
			}
			echo"<form  action='poruka.php?idk=" .$row['id_korisnik']."&ido=". $row['id_oglas'] ."' method='post'>
				<button class='poruka' type='submit' name='poruka'> Pošalji poruku korisniku</button></form>
				<i>Oglas je aktivan do: </i>$row[vrijedi_do]";
			$sqlA = "SELECT *  FROM oglas AS a INNER JOIN(
						SELECT id_korisnik, korisnicko_ime, kontakt_k FROM korisnik)
							AS b ON a.id_korisnik=b.id_korisnik WHERE id_oglas=" .$id. ";" ;
			$resultA = mysqli_query($conn,$sqlA);
			while($row = mysqli_fetch_array($resultA)) {
				echo"<form  action='oglas?id=" .$row['id_oglas']."' method='post'>";
				echo"<input type='hidden' name='id' value=". $row['id_oglas'].">
				<a class='korisnik' href='uredi_korisnika.php?id=" .$row['id_korisnik']."'> <b>Uredi korisnika: ".$row['korisnicko_ime']."</b> </a><br>";
				
					if ($row['aktivan']=='0') {
						echo"<button id='odobriBut' type='submit' name='odobriBut'> Odobri oglas </button>";
					}
					echo"<button id='DelBut' type='submit' name='DelBut'> Obriši oglas </button></form></blockquote>";
			}
		}
	}
}

$sqlSL = "SELECT a.id_slika, a.id_oglas, a.putanja_slika FROM slike_oglasa AS a INNER JOIN( 
			SELECT id_oglas FROM oglas) AS b ON b.id_oglas=a.id_oglas WHERE b.id_oglas = " .$id. ";";
$result = mysqli_query($conn,$sqlSL);
$resultCheck = mysqli_num_rows($result);
if($resultCheck > 1){
    echo"<blockquote class='note2' style = 'width: 482px'; 'margin-right: 50px';>
    <i class='pin2'></i>";
		$sqlSL = "SELECT a.id_slika, a.id_oglas, a.putanja_slika FROM slike_oglasa AS a INNER JOIN( 
					SELECT id_oglas FROM oglas) AS b ON b.id_oglas=a.id_oglas WHERE b.id_oglas = " .$id. ";";
		$result = mysqli_query($conn,$sqlSL);
		$row = mysqli_fetch_array($result);
			echo"
			<div class='imgBox'><div class='oglas-velike-slike' style='background-image:url(".$row['putanja_slika']."); '> </div></div>
				<ul class='thumb'>";
			$sqlSLm = "SELECT a.id_slika, a.id_oglas, a.putanja_slika FROM slike_oglasa AS a INNER JOIN( 
						SELECT id_oglas FROM oglas) AS b ON b.id_oglas=a.id_oglas WHERE b.id_oglas = " .$id. ";";
			$resultm = mysqli_query($conn,$sqlSLm);
			while($rowm = mysqli_fetch_array($resultm)) {
				echo"<li><a href='".$rowm['putanja_slika']."' target='imgBox'><img src='".$rowm['putanja_slika']."'></a></li>";
			}
    echo"</ul></blockquote>";
}elseif($resultCheck == 1){
    echo"<blockquote class='note2 yellow' style = 'width: 482px'; 'margin-right: 50px';>
    <i class='pin2'></i>";
		$sqlSL = "SELECT a.id_slika, a.id_oglas, a.putanja_slika FROM slike_oglasa AS a INNER JOIN( 
					SELECT id_oglas FROM oglas) AS b ON b.id_oglas=a.id_oglas WHERE b.id_oglas = " .$id. ";";
		$result = mysqli_query($conn,$sqlSL);
		$row = mysqli_fetch_array($result);
			echo"
			<div class='imgBox'><img src='".$row['putanja_slika']."'  width='437px'></div>
    		</blockquote>";
}
$id = $_GET['id'];
$id = mysqli_real_escape_string($conn,$_GET['id']);
if(isset ($_POST['odobriBut'])){
	$sql = "UPDATE oglas SET aktivan = 1 , vrijedi_od = NOW(), vrijedi_do = NOW() + INTERVAL 30 DAY
				WHERE id_oglas = " .$id. ";"; 
	mysqli_query($conn, $sql);
	header("Location: odobri_oglase.php");
}elseif(isset ($_POST['DelBut'])){
	$sql = "DELETE FROM slike_oglasa WHERE id_oglas=" .$id. ";";
	$sql .= "DELETE FROM oglas WHERE id_oglas=" .$id. ";"; 
    mysqli_multi_query($conn, $sql);

	header("Location: odobri_oglase.php");
}
 ?>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script type="text/javascript">
		$( document ).ready(function() {
			$('.thumb a').click(function(e){
                e.preventDefault();
				$('.oglas-velike-slike').css('background-image', 'url(' + $(this).attr("href") + ')');
            })
		});
    </script>

<?php 
	require "footer.php";