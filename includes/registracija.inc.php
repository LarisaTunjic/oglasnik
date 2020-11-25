<?php
require "dbh.inc.php";

require('../captcha/autoload.php');

    $siteKey = '6LcXjMQUAAAAALmEA14W1O7AnaYlV12RvaOV4CSk';
    $secret = '6LcXjMQUAAAAALEEzJIoGvxr50sfqnv3-rqGCutt';
    
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);
    
    $gRecaptchaResponse = $_POST['g-recaptcha-response']; //google captcha post data
    $remoteIp = $_SERVER['REMOTE_ADDR']; //to get user's ip
    
    $recaptchaErrors = ''; // blank varible to store error
    
    $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp); //method to verify captcha

    $mail_status = false;

if ($resp->isSuccess()) {

	if(isset($_POST['regBut'])){

		require 'dbh.inc.php';

		$korisnicko_ime = $_POST['kor_ime'];
		$ime = $_POST['ime'];
		$prezime = $_POST['prez'];
		$email = $_POST['mail'];
		$lozinka = $_POST['pass'];
		$lozinkaPonovo = $_POST['pass-ponovo'];

		#provjerava dali je korisnik sve popunio u formi
		if (empty($korisnicko_ime) || empty($email) || empty($lozinka) || empty($lozinkaPonovo)) {
			header("Location: ../registracija.php?error=emptyfields&kor_ime=".$korisnicko_ime. "&mail=".$email); #javljanje greške, vraćanje na registraciju
			exit();
		} #provjera korisničkog imena i e-maila
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $korisnicko_ime)) {
			header("Location: ../registracija.php?error=invalidmailkor_ime");
			exit();
		}
		#provjera dali je upisan ispravni e-mail
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../registracija.php?error=invalidmail&kor_ime=".$korisnicko_ime); #javljanje greške, vraćanje na registraciju i samo korisničko ime
			exit();
		}#provjera korisničko ime i dozvoljene znakove
		elseif (!preg_match("/^[a-zA-Z0-9]*$/", $korisnicko_ime)) {
			header("Location: ../registracija.php?error=invalidkor&mail=".$email); #javljanje greške, vraćanje na registraciju i samo e-mail
			exit();
		}#provjera dali se lozinke podudaraju
		elseif ($lozinka !== $lozinkaPonovo) {
			header("Location: ../registracija.php?error=passwordcheck&kor_ime=".$korisnicko_ime. "&mail=".$email);
			exit();
		}#provjera postoji li već korisnik sa unesenim korisničkim imenom*/
		else{
			$sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime=?";
			$stmt = mysqli_stmt_init($conn); #Dodjeljuje i inicijalizira objekt naredbe
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../registracija.php?error=sqlerror");
				exit();
			}
			else {
				mysqli_stmt_bind_param($stmt, "s", $korisnicko_ime);#prosljedi što je korisnik unjeo
				mysqli_stmt_execute($stmt);#IZVRŠAVA upit koji je prethodno pripremljen pomoću funkcije mysqli_prepare (). Kada se izvrše, svi postojeći parametri automatski će se zamijeniti odgovarajućim podacima.
				mysqli_stmt_store_result($stmt);#poziva se za svaki upit koji uspješno proizvodi skup rezultata tj. nasao je duplikat sprema rezultat u var stmt
				$resultCheck = mysqli_stmt_num_rows($stmt);#mysqli_stmt_num_rows vraća broj redaka u skupu rezultata. broj može biti 0 ili 1
				if ($resultCheck > 0) {
					header("Location: ../registracija.php?error=usertaken&mail=".$email);
					exit();
				} #upisivanje korisnika u bazu
				else{
					$sql = "INSERT INTO korisnik (korisnicko_ime, ime, prezime, lozinka, email) VALUES ( ?, ?, ?, ?, ?)";
					$stmt = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt, $sql)) {
						header("Location: ../registracija.php?error=sqlerror");
						exit();
					}else{
						#upisivanje podataka u bazu
						mysqli_stmt_bind_param($stmt, "sssss", $korisnicko_ime, $ime, $prezime, $lozinka, $email);
						mysqli_stmt_execute($stmt);
						header("Location: ../kategorije.php?singup=success");
						exit();
					}
				}
			}
		}#zatvaranje baze
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}#pristup stranici samo na gumb// vračanje na registraciju
	else{
		header("Location: ../registracija.php");
		exit();
	}
}else {

    header("Location: ../registracija.php?error=captcha"); 
	exit();
}