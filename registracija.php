<?php 
	require "header.php";
 ?>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<div class="kategorije">
		<div class="container">
		<div class="search-wrapper">
			<h1>Registracija</h1>
			<h6 id=tip>Već ste registrirani naš korisnik? Molimo,
					<a href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>prijavite se</a>
						<div class='dropdown-menu nav-prijava-wrapper' aria-labelledby='navbarDropdown'>
							<div class='dropdown-item nav-prijava'>
								<form action='includes/prijava.inc.php' method='post'>
									<div class='col-auto'>
										<input type='text' name='kor_ime' class='form-control' placeholder='Korisničko ime'>
										<input type='password' class='form-control' name='pass' placeholder='Lozinka'>
										<button id='prijava' type='submit' name='prijavaBut'> Prijavi se </button>
									</div>
								</form>
							</div>
						</div></h6>
			<?php
			if(isset($_GET['error'])){
				if($_GET['error'] == "emptyfields"){
					echo"<h2 class='greska'>*Greška: Ispunite sva polja.</h2>";
				}
				elseif($_GET['error'] == "invalidmailkor_ime"){
					echo"<h2 class='greska'>*Greška: Pogrešan e-mail i korisničko ime.</h2>";
				}
				elseif($_GET['error'] == "invalidmail"){
					echo"<h2 class='greska'>*Greška: Pogrešan e-mail.</h2>";
				}
				elseif($_GET['error'] == "invalidkor"){
					echo"<h2 class='greska'>*Greška: Koristite nedopuštene znakove za korisničko ime.</h2>";
				}
				elseif($_GET['error'] == "passwordcheck"){
					echo"<h2 class='greska'>*Greška: Lozinke se ne podudaraju.</h2>";
				}
				elseif($_GET['error'] == "usertaken"){
					echo"<h2 class='greska'>*Greška: Korisničko ime je već korišteno.</h2>";
				}
				elseif($_GET['error'] == "captcha"){
					echo"<h2 class='greska'>*Greška: Niste potvrdili reCAPTCHU.</h2>";
				}
				elseif($_GET['error'] == "sqlerror"){
					echo"<h2 class='greska'>*Greška: Dogodila se greška sa bazom.</h2>";
				}
			}
			?>
			</div>
			<div class="pb-5">
				<i class="pinn"></i>
				<blockquote class="note yellow">
				<form action="includes/registracija.inc.php" method="post">
					Korisničko ime*: <br><input type="text" name="kor_ime" placeholder="Upišite korisničko ime"></br>
					E-mail adresa*: <br><input type="text" name="mail" placeholder="Upišite e-mail adresu"></br>
					Vaše ime: <br><input type="text" name="ime" placeholder="Upišite ime"></br>
					Vaše prezime: <br><input type="text" name="prez" placeholder="Upišite prezime"></br>
					Lozinka*: <br><input type="password" name="pass" placeholder="Upišite lozinku"></br>
					Ponovljena lozinka*: <br><input type="password" name="pass-ponovo" placeholder="Ponovite lozinku"></br>
					Potvrdi kako bismo znali da si čovjek, a ne stroj *<br>
					<div class="g-recaptcha" data-sitekey="6LcXjMQUAAAAALmEA14W1O7AnaYlV12RvaOV4CSk"></div>
					<button id="regBut" type="submit" name="regBut"> Registriraj se </button>
					<br><h2 class='greska' style='font-size: 18px;'>*Obavezna polja.</h2>
				</form>
				</blockquote>
			</div>
		</div>
	</div>
<?php
require "footer.php";