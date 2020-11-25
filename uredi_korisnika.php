<?php 

	require "header.php";
?>
<div class="kategorije">
<div class="container">
<div class='pb-5'>
<?php
$id = $_GET['id'];
$id = mysqli_real_escape_string($conn,$_GET['id']);
$query = "SELECT * FROM korisnik 
			WHERE id_korisnik = ".$id.";";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if($resultCheck > 0){
	while ($row = mysqli_fetch_array($result)) {
		echo "<div class='search-wrapper'><h1 style='font-family:Satisfy;'><b>Uredi korisnika : </b>" . $row['korisnicko_ime'] ."</h1></div>
			<div class='pb-5'>
			<i class='pinn'></i>
			<blockquote class='note yellow'>
			<form  action='uredi_korisnika?id=" .$row['id_korisnik']."' method='post'>
			<b>Korisničko ime:</b> " .$row['korisnicko_ime']."<br>
			<b>Ime:</b> " .$row['ime']."<br>
			<b>Prezime:</b> ". $row['prezime']."<br>
			<b>E-mail:</b> " .$row['email']. "<br>";
			if($row['slika'] == 0){
				echo "<p><img class='slUrProf' src='uploads/korisnici/korisnik.png' style='width:128px;height:128px;'/></p><br>";
			}else{
				$imeSL = "uploads/korisnici/korisnik".$row['id_korisnik']."*";
				$infoSL = glob($imeSL);
				$extSL = explode(".", $infoSL[0]); 
				$actualextSL = $extSL[1]; 
				echo"<div class='slUrProf'><p><img  src='uploads/korisnici/korisnik".$row['id_korisnik'].".".$actualextSL."' style='width:128px;height:128px;'/></p></div>";
			}
		echo"<form  action='uredi_korisnika?id=" .$row['id_korisnik']."' method='post'>
			<input type='hidden' name='id' value=". $row['id_korisnik']."> 
			<input type='radio' name='id_tip' value='0'". ( $row['id_tip'] == '0' ? ' checked="checked"':''). "/> Administrator<br>
	  		<input type='radio' name='id_tip' value='1'". ( $row['id_tip'] == '1' ? ' checked="checked"':''). "/> Obični korisnik<br>
			<button id='urediKor' type='submit' name='urediKor'> Spremi promjene </button>
			<button id='delKor' type='submit' name='delKor'> Obriši korisnika </button></form></div>";
	}
}
if(isset($_POST['urediKor'])){
	$id_tip=$_POST['id_tip'];

	$sql = "UPDATE korisnik SET id_tip = ".$id_tip."
				WHERE id_korisnik = ".$id.";";

	mysqli_query($conn, $sql);
	header("Location: korisnici.php");

}elseif(isset($_POST['delKor'])){
	$sql = "DELETE FROM korisnik 
				WHERE id_korisnik = ".$id.";";
 
	mysqli_query($conn, $sql);
	header("Location: korisnici.php");
}
?>
</div>
</div>
</div>
<?php
require "footer.php";
?>
