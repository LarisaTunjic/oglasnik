<?php 
    include 'header.php';
    ob_start();
    $id = $_GET['id'];
?>
<div class="kategorije ">
	<div class="container">
		<div class="search-wrapper">
			<h1>Kreiranje nove lozinke </h1>
		</div>
		<div class="pb-5">
			<i class="pinn"></i>
			<blockquote class="note yellow">
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "pass"){
                        echo"<h2 class='greska'>*Lozinke se ne podudaraju.</h2>";
                    }elseif($_GET['error'] == "empty"){
                        echo"<h2 class='greska'>*Niste upisali obje lozinke.</h2>";
                    }
                }
            ?>
                <form class="select_kat" action="resetiranje_lozinke.php?id=<?php echo $id ?>" method="post">
                    <input type='hidden' name='id' value="<?php $id?>"> 
                    Nova lozinka: <br><input type='password' name='pass' placeholder='Upišite novu lozinku'>
                    Ponovite lozinku: <br><input type='password' name='pass-ponovo' placeholder='Ponovite lozinku'><br>
					<button id='prijava' type='submit' name='resetPass'>Spremi novu lozinku</button>	
				</form>
			</blockquote>
		</div>
	</div>
</div>
<?php
if(isset($_POST['resetPass'])){
	$pass=$_POST['pass'];
    $passP=$_POST['pass-ponovo'];
    if($pass == $passP){
        $sql = "UPDATE korisnik SET lozinka = '$pass' WHERE id_korisnik = ".$id.";";
        mysqli_query($conn, $sql);
        header("Location: kategorije.php");
    }elseif(empty($pass) || empty($passP)){
        header("Location: resetiranje_lozinke.php?error=empty&id=".$id);
    }else{
        header("Location: resetiranje_lozinke.php?error=pass&id=".$id);
    }
}
    require "footer.php";
?>