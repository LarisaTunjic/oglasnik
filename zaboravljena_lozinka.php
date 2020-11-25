<?php 
    include 'header.php';
    ob_start();
?>
<div class="kategorije ">
	<div class="container">
		<div class="search-wrapper">
			<h1> Ponovo postavljanje lozinke </h1>
		</div>
        
		<div class="pb-5">
			<i class="pinn"></i>
			<blockquote class="note yellow">
            <?php
            if(isset($_GET['error'])){
				if($_GET['error'] == "email"){
					echo"<h2 class='greska1'>*Upisali ste nepostojeći e-mail.</h2>";
                }elseif($_GET['error'] == "empty"){
					echo"<h2 class='greska1'>*Molimo upišite e-mail adresu.</h2>";
                }
            }
        ?>
				<form class="select_kat" action="" method="post">
                    Upišite Vašu e-mail adresu:<input type='text' class='form-control' name='mail'><br>
					<button id='prijava' type='submit' name='resetPass'>Pošalji</button>	
				</form>
			</blockquote>
		</div>
	</div>
</div>

<?php
if(isset($_POST['resetPass'])){
    $email = $_POST['mail'];

    if(empty($email)){
        header("Location: zaboravljena_lozinka.php?error=empty");
    }else{
        $sql = "SELECT id_korisnik, email FROM `korisnik` WHERE email = '".$email."' ;";
        $result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck > 0) {
			while ($row = mysqli_fetch_assoc($result)){
                $id = $row['id_korisnik'];
                $naslov = "Ponovo postavljanje lozinke";
                $mail = $row['email'];
                $subject = "Ponovo postavljanje lozinke";
                $body_message = "http://localhost//oglasnik/resetiranje_lozinke.php?id=".$id."";
                $poruka = "Poštovani, navedeni link Vas vodi na resetiranje lozinke.";
                
                mail($mail, $subject, $body_message, $poruka);
                header("Location: obavijest.php");

            }
        }else{
            header("Location: zaboravljena_lozinka.php?error=email");
        }
    }

}

require "footer.php";
?>