<?php  
if (isset($_POST['prijavaBut'])) {

	require 'dbh.inc.php';

	$mail = $_POST['kor_ime'];
	$lozinka = $_POST['pass'];

	if (empty($mail) || empty($lozinka) ) {#provjerava dali su prazna polja
		echo("<script>alert('Popunite sva polja.')</script>");
 		echo("<script>window.location = '../kategorije.php?error=emptyfields';</script>");
		exit();
		
	}else{			#provjera dali postoji korisnik u bazi i dali je dobra lozinka
		$sql = "SELECT * FROM korisnik WHERE korisnicko_ime=? ;";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			echo("<script>alert('Dogodila se greška sa bazom.')</script>");
			echo("<script>window.location = '../kategorije.php?error=sqlerror';</script>");
			exit();
		}else{
			mysqli_stmt_bind_param($stmt, "s", $mail);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			#imali rezultata u bazi i spremanje u niz
			if ($row = mysqli_fetch_assoc($result)) {
				#$passCheck = password_verify($lozinka, $row['lozinka']);
				if ($lozinka != $row['lozinka']) {
					echo("<script>alert('Pogrešna lozinka.')</script>");
					echo("<script>window.location = '../kategorije.php?error=wrongpwd';</script>");
					exit();
				}elseif ($lozinka == $row['lozinka']) {
					session_start();
					$_SESSION['kor_id'] = $row['id_korisnik'];
					$_SESSION['kor_ime'] = $row['korisnicko_ime'];
					$_SESSION['id_tip'] = $row['id_tip'];

					header("Location: ../kategorije.php?login=success");
					exit();
				}else{
					echo("<script>alert('Pogrešna lozinka.')</script>");
					echo("<script>window.location = '../kategorije.php?error=wrongpwd';</script>");
					exit();
				}
			}else{#u slučaju greške da $passCheck nije ni 0 ni 1
				echo("<script>alert('Upisali ste krivo korisničko ime.')</script>");
				echo("<script>window.location = '../kategorije.php?error=nouser';</script>");
				exit();
			}
		}
	}
}else{
	header("Location: ../kategorije.php");
	exit();
}

?>