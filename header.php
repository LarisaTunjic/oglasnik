<?php 
	session_start();
	require "includes/dbh.inc.php";
	/*require "footer.php";*/
	date_default_timezone_set('Europe/Zagreb');
 ?>
<!doctype html>
<html lang="hr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
	<!-- Prilagođava prikaz za sve uređaje -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto+Slab:wght@300&family=Satisfy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<meta charset = "utf-8">
		<title>Oglasnik</title>
		<link rel="stylesheet" href="style.css"/>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

	</head>
	<body>
		<header><!--forma za pretraživanje oglasa-->
		<div class="container bg-light">
		<nav class="navbar navbar-expand-lg navbar-light">
			<a class="navbar-brand"  href="kategorije.php" title="Vrati na početnu" id="logo">
				<img src="img/logo1.png" alt="OGLASNIK">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="kategorije.php">Kategorije</a> 
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="svi_oglasi.php">Svi oglasi</a>
				</li>
				<form class="search form-inline my-2 my-lg-0" action="search.php" method="POST">
					<input id="src" class="form-control mr-sm-2" type="text" name="search" placeholder="Upiši pojam...">
					<button id="searchBut" type="submit" class="btn btn-outline-success my-2 my-sm-0" name="searchBut"></button>
				</form>

				<?php  
					if (isset($_SESSION['kor_id']) && isset($_SESSION['kor_ime'])){
						echo '<p id="pozdrav">Dobrodošli, '. $_SESSION['kor_ime'].'</p>';
					}
					
  					if (isset($_SESSION['kor_id']) && isset($_SESSION['kor_ime'])){
						echo "<li class='nav-item'>";
						echo "<a class='nav-link' href='oglasi_ulogiranog_korisnika.php'>Moji oglasi</a></li>";
					}else{
						echo "<li class='nav-item'>";
						echo "<a class='nav-link' href='registracija.php'>Registriraj se :)</a></li>";
					} 
				
				if (!(isset($_SESSION['kor_id']) && isset($_SESSION['kor_ime']))){
				echo"<li class='nav-item dropdown'>
					<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' 
					data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Prijava</a>
						<div class='dropdown-menu nav-prijava-wrapper' aria-labelledby='navbarDropdown'>
							<div class='dropdown-item nav-prijava'>
								<form action='includes/prijava.inc.php' method='post'>
									<div class='col-auto'>
										<input type='text' name='kor_ime' class='form-control' placeholder='Korisničko ime'>
										<input type='password' class='form-control' name='pass' placeholder='Lozinka'>
										<a href='zaboravljena_lozinka.php'>Zaboravili ste lozinku?</a>
										<button id='prijava' type='submit' name='prijavaBut'> Prijavi se </button>
									</div>
								</form>
							</div>
						</div>";
				}else{
				#forma za prijavu i registraciju
					echo'<li class="nav-item"> <form action=odaberi_kategoriju.php method="post">
							<button id="dodajOglas" class="nav-link" type="submit" name="dodajOglas"> Predaj oglas </button>
						</form></li>';
					echo '<li class="nav-item"><form action=includes/odjava.inc.php method="post">
							<button id="odjava" type="submit"  class="nav-link" name="odjavaBut"> Odjavi se </button>
						</form></li>';
					
				}
				?>
				</ul>
			</div>
			</nav>
		</div>
		</header>
	
