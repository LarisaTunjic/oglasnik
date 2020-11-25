<?php 
	include 'header.php';
    $idk = $_GET['idk'];
	$ido = $_GET['ido'];

	$sqlOG = "SELECT naslov FROM oglas WHERE id_oglas=".$ido.";";
	$result = mysqli_query($conn,$sqlOG);
	while($row = mysqli_fetch_array($result)){
		$naslov_oglasa=$row['naslov'];
	}
	
?>
<div class="kategorije">
<div class="container">
	<div class="search-wrapper">
		<h1> Kontaktiraj oglašivača </h1>
	
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php
if(isset($idk)){
	$sql = "SELECT id_korisnik, korisnicko_ime, email FROM korisnik 
				WHERE id_korisnik=" .$idk. ";" ;
	$result = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_array($result)) {
		if(isset($_GET['error'])){
			if($_GET['error'] == "emptyfields"){
				echo"<h2 class='greska'>*Greška: Niste popunili sva polja.</h2>";
			}
			elseif($_GET['error'] == "invalidmail"){
				echo"<h2 class='greska'>*Greška: Upisali ste pogrešan e-mail.</h2>";
			}
			elseif($_GET['error'] == "captcha"){
				echo"<h2 class='greska'>*Greška: Niste potvrdili reCAPTCHU.</h2>";
			}
		}
		echo"</div><div class='pb-5'>
			<i class='pinn'></i>
			<blockquote class='note yellow'>
			<form class='formUredi' action='contact_send.php?idk=" .$row['id_korisnik']."&ido=". $ido ."' method='post'>
				<input type='hidden' name='imeOglasa' value=". $naslov_oglasa.">
				Primatelj: ".$row["korisnicko_ime"]."<br>
				Naslov poruke: Upit sa Oglasnika za oglas <br>
				Vaše ime: <input type='text' name='ime'><br>	
				Vaš e-mail: <input type='text' name='email'><br>
				Poruka: <textarea type='text' rows='10' name='poruka' ></textarea><br>
				Potvrdi kako bismo znali da si čovjek, a ne stroj *<br>
				<div class='g-recaptcha' data-sitekey='6LcXjMQUAAAAALmEA14W1O7AnaYlV12RvaOV4CSk'></div>
				<br><div class='gumbi'><button id='send' type='submit' name='send'> Pošaljite poruku </button>
				<a href='svi_oglasi.php' class='btn btn-primary btn-lg active' id='odustani'> Odustanite </a></div>
			</form>
			</blockquote>
            </div>";
	}
}
?>
 </div>
</div>
<?php 
	require "footer.php";
?>
