<?php 

$imeservera = 'localhost';
$DBkorisnik = 'larisa';
$DBlozinka = '123';
$bazapodataka = 'oglasnik';

$conn = mysqli_connect($imeservera, $DBkorisnik, $DBlozinka, $bazapodataka);
$conn->set_charset("utf8");
if (!$conn) {
	die("Povezivanje nije uspjelo: ".msqli_connect_error());
}