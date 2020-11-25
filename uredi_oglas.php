<?php 
    include 'header.php';
    ob_start();
?>
<div class="kategorije">
<div class="container">
<?php

	$id = $_GET['id'];
	$id = mysqli_real_escape_string($conn,$_GET['id']);
	$sql = "SELECT *  FROM oglas AS a INNER JOIN(
				SELECT id_korisnik, korisnicko_ime FROM korisnik)
					AS b ON a.id_korisnik=b.id_korisnik	WHERE id_oglas=" .$id. ";" ;
	$result = mysqli_query($conn,$sql) or trigger_error() ."in". $sql;
	while($row = mysqli_fetch_array($result)) {
        echo "<div class='search-wrapper'><h1> <b>Uredi oglas:</b> " .$row['naslov']."</h1>";
        if(isset($_GET['error'])){
			if($_GET['error'] == "br_slika"){
				echo"<h2 class='greska'>*Greška: Odabrali ste previše slika.</h2>";
			}elseif($_GET['error'] == "format"){
				echo"<h2 class='greska'>*Greška: Format slike nije dozvoljen.</h2>";
			}
		}
        echo"</div>
			<div class='pb-5'>
			<i class='pinn'></i>
            <blockquote class='note yellow'>";
            if(($row['id_tip_oglas'])=='2'){    #ako oglas nije plaćen
                echo"<form action='nacin_placanja?id=" .$row['id_oglas']."' method='POST'>
                <button id='promOgl' type='submit' name='promOgl'> Promoviraj oglas </button></form>";
            }else{
                echo"<b>Ovaj oglas ste platili.</b><hr>";
            }
            echo"<form class='formUredi'action='uredi_oglas?id=" .$row['id_oglas']."' method='post' enctype='multipart/form-data'>
			<input type='hidden' name='id' value=". $row['id_oglas'].">";
			if(($row['aktivan'])=='2'){
				echo"<button id='aktivOgl' type='submit' name='aktivOgl'> Aktiviraj oglas </button>";}
		echo"<br>Naslov oglasa: <input type='text' name='naslov' value='" .$row['naslov']. "'>
			Opis oglasa: <textarea type='text' name='tekst'>" . $row['tekst'] ."</textarea>
			Oglas objavljen: ".$row['vrijedi_od']."<br>
			Oglas ističe:  ".$row['vrijedi_do']."<br>
			Kontakt oglasa: <input type='text' name='kontakt_o' value=" . $row['kontakt_o'] .">";
	}
	$sqlSL = "SELECT a.id_slika, a.id_oglas, a.putanja_slika FROM slike_oglasa AS a INNER JOIN(	
				SELECT id_oglas FROM oglas) AS b ON a.id_oglas=b.id_oglas WHERE b.id_oglas=" .$id. ";";
	$result = mysqli_query($conn,$sqlSL);
	$numResults = mysqli_num_rows($result);
	if($numResults > 0){ #AKO VEĆ POSTOJE SLIKE OGLASA
        echo"Slike:
        <div class='sl'>";
		while($row = mysqli_fetch_array($result)) {
            echo"<li><p><img src='".$row['putanja_slika']."' style='width:128px;height:128px; border-radius: 8px;'/>
                <a href='brisanje_slika_oglasa.php?action=delete&filename=".$row['putanja_slika']."&idsl=". $row['id_slika'] ."&id=". $row['id_oglas'] ."'>
                <img src='img/trash.png'></a></p>
                </li>";
		}
		echo "</div>Odaberi slike:<input type='file' name='slike[]' multiple>
			<div><button id='spremiOgl' type='submit' name='spremiOgl'> Zalijepi promjene </button>";
	}else{
		$sqlSL = "SELECT id_oglas FROM oglas WHERE id_oglas=" .$id. ";";
		$result = mysqli_query($conn,$sqlSL);
		$numResults = mysqli_num_rows($result);
		if($numResults > 0){		#AKO OGLAS JOS NEMA SLIKA
			while ($row = mysqli_fetch_assoc($result)) {
		
				echo "Dodaj slike:<input type='file' name='slike[]' multiple><br>
					<div><button id='spremiOgl' type='submit' name='spremiOgl'> Zalijepi promjene </button>";
			}
		}
	}
	$sql = "SELECT *  FROM oglas AS a INNER JOIN(
				SELECT id_korisnik, korisnicko_ime FROM korisnik)
					AS b ON a.id_korisnik=b.id_korisnik	WHERE aktivan = 1 AND id_oglas=" .$id. ";" ;
	$result = mysqli_query($conn,$sql) or trigger_error() ."in". $sql;
	$numResults = mysqli_num_rows($result);
	if($numResults > 0){
		while($row = mysqli_fetch_array($result)) {
			echo"<button id='deakOgl' type='submit' name='deakOgl'> Deaktiviraj oglas </button>
				<button id='DelBut' type='submit' name='DelBut'> Obriši oglas </button></div></form>";
		}
	}else{
		echo"<button id='DelBut' type='submit' name='DelBut'> Obriši oglas </button></div></form>";
    }
$id = $_GET['id'];
if(isset($_POST['spremiOgl'])){
    $id = $_GET['id'];
    $naslov = $_POST['naslov'];
    $tekst = $_POST['tekst'];
    $kontakt_o = $_POST['kontakt_o'];
    $slika = $_FILES['slike'];
    
    #provjeri koliko oglas ima slika
    $sqlBR = "SELECT id_slika, COUNT(id_oglas) as broj_slika FROM slike_oglasa WHERE id_oglas= ".$id.";";
    $result = mysqli_query($conn,$sqlBR) or trigger_error() ."in". $sqlBR;
    $numResults = mysqli_num_rows($result);
    if($numResults > 0){
        while($row = mysqli_fetch_array($result)) {
            $br_slika = $row['broj_slika'];
            $count = count(array_filter($_FILES['slike']['name'])); #PROVJERA BROJA SELEKTIRANIH SLIKA
            $id = $_GET['id'];
            switch ($br_slika) {
                case 0:                     #OGLAS BEZ SLIKA
                    if ($count > 5) {
                        header("Location: uredi_oglas.php?error=br_slika&id=".$id);
                    }elseif($count == 0 || $count == NULL){
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) ;	
                        header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                    }else{
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) ;	
                        foreach($_FILES["slike"]["tmp_name"] as $key=>$tmp_name) {
                            $tmp_slika = $_FILES["slike"]["tmp_name"][$key];	
                            $ime_slika = $_FILES["slike"]["name"][$key];
                            $tip_slika = $_FILES["slike"]["type"][$key];

                            $slExt = explode('.', $ime_slika); # razdvaja ime slike i njenu ekstenziju
                            $slActualExt = strtolower(end($slExt)); # ekstenziju pretvara u mala slova
                            $allowed = array('jpg', 'jpeg', 'png');# niz ekstenzija koje su dozvoljene
                            if (in_array($slActualExt, $allowed)) {#provjera dali slika ima nešto od niza koji su dozvoljene sktenzije
                                $slNameNew = uniqid('', true) .".".$slActualExt; #ime slike koja se sprema
                                $putanja = "uploads/oglasi/slike_oglasa_".$id;
                                $putanja_slikaCheck = "uploads/oglasi/slike_oglasa_".$id."/".$slNameNew;
                                if (!file_exists($putanja_slikaCheck)) {
                                    mkdir($putanja, 0777, true);
                                    $putanja_slika = "uploads/oglasi/slike_oglasa_".$id."/".$slNameNew;
                                    move_uploaded_file($tmp_slika, $putanja_slika);
                                    $sqlSL = "INSERT INTO slike_oglasa (id_oglas, ime_slika, tip_slika, putanja_slika)	
                                                VALUES ('$id', '$slNameNew', '$tip_slika', '$putanja_slika');";
                                    $resultSl = mysqli_query($conn, $sqlSL);
                                    header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                                }
                            }else{
                                echo"<h2 class='greska'>Format slike nije dozvoljen!</h1>";
                                echo count(array_filter($_FILES['files']['name']));
                            }							
                        }
                    }
                    break;
                case 1:  
                    if ($count > 4) {
                        header("Location: uredi_oglas.php?error=br_slika&id=".$id);
                    }elseif($count == 0 || $count == NULL){
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) ;	
                        header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                    }else{
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) ;	
                        for ($i=0; $i < $count ; $i++) { 
                            $tmp_slika = $_FILES["slike"]["tmp_name"][$i];	
                            $ime_slika = $_FILES["slike"]["name"][$i];
                            $tip_slika = $_FILES["slike"]["type"][$i];
                                            
                            $slExt = explode('.', $ime_slika); # razdvaja ime slike i njenu ekstenziju
                            $slActualExt = strtolower(end($slExt)); # ekstenziju pretvara u mala slova
                            $allowed = array('jpg', 'jpeg', 'png');

                            if (in_array($slActualExt, $allowed)){#provjera dali slika ima nešto od niza koji su dozvoljene sktenzije
                                $slNameNew = uniqid('', true) .".".$slActualExt;
                                $putanja_slika = "uploads/oglasi/slike_oglasa_".$id."/".$slNameNew;
                                move_uploaded_file($tmp_slika, $putanja_slika);
                                #SPREMANJE SLIKA								
                                $sqlSL = "INSERT INTO slike_oglasa (id_oglas, ime_slika, tip_slika, putanja_slika)	
                                VALUES ('$id', '$slNameNew', '$tip_slika', '$putanja_slika');";
                                $result = mysqli_query($conn, $sqlSL) or trigger_error()."in".$sqlSL;
                                
                                header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                            }else{
                                header("Location: uredi_oglas.php?error=format&id=".$id);
                            }
                        }
                    }
                    break;
                case 2:
                    if ($count > 3) {
                        header("Location: uredi_oglas.php?error=br_slika&id=".$id);
                    }elseif($count == 0 || $count == NULL){
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) ;	
                        header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                    }else{
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) ;	
                        for ($i=0; $i < $count ; $i++) { 
                            $tmp_slika = $_FILES["slike"]["tmp_name"][$i];	
                            $ime_slika = $_FILES["slike"]["name"][$i];
                            $tip_slika = $_FILES["slike"]["type"][$i];
                                            
                            $slExt = explode('.', $ime_slika); # razdvaja ime slike i njenu ekstenziju
                            $slActualExt = strtolower(end($slExt)); # ekstenziju pretvara u mala slova
                            $allowed = array('jpg', 'jpeg', 'png');

                            if (in_array($slActualExt, $allowed)){#provjera dali slika ima nešto od niza koji su dozvoljene sktenzije
                                $slNameNew = uniqid('', true) .".".$slActualExt;
                                $putanja_slika = "uploads/oglasi/slike_oglasa_".$id."/".$slNameNew;
                                move_uploaded_file($tmp_slika, $putanja_slika);
                                #SPREMANJE SLIKA								
                                $sqlSL = "INSERT INTO slike_oglasa (id_oglas, ime_slika, tip_slika, putanja_slika)	
                                VALUES ('$id', '$slNameNew', '$tip_slika', '$putanja_slika');";
                                $result = mysqli_query($conn, $sqlSL) or trigger_error()."in".$sqlSL;
                                
                                header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                            }else{
                                header("Location: uredi_oglas.php?error=format&id=".$id);
                            }
                        }
                    }
                    break;
                case 3: 
                    if ($count > 2) {
                        header("Location: uredi_oglas.php?error=br_slika&id=".$id);
                    }elseif($count == 0 || $count == NULL){
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) ;	
                        header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                    }else{
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) ;	
                        for ($i=0; $i < $count ; $i++) { 
                            $tmp_slika = $_FILES["slike"]["tmp_name"][$i];	
                            $ime_slika = $_FILES["slike"]["name"][$i];
                            $tip_slika = $_FILES["slike"]["type"][$i];
                                            
                            $slExt = explode('.', $ime_slika); # razdvaja ime slike i njenu ekstenziju
                            $slActualExt = strtolower(end($slExt)); # ekstenziju pretvara u mala slova
                            $allowed = array('jpg', 'jpeg', 'png');

                            if (in_array($slActualExt, $allowed)){#provjera dali slika ima nešto od niza koji su dozvoljene sktenzije
                                $slNameNew = uniqid('', true) .".".$slActualExt;
                                $putanja_slika = "uploads/oglasi/slike_oglasa_".$id."/".$slNameNew;
                                move_uploaded_file($tmp_slika, $putanja_slika);
                                #SPREMANJE SLIKA								
                                $sqlSL = "INSERT INTO slike_oglasa (id_oglas, ime_slika, tip_slika, putanja_slika)	
                                VALUES ('$id', '$slNameNew', '$tip_slika', '$putanja_slika');";
                                $result = mysqli_query($conn, $sqlSL) or trigger_error()."in".$sqlSL;
                               
                                header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                            }else{
                                header("Location: uredi_oglas.php?error=format&id=".$id);
                            }
                        }
                    }
                    break;
                case 4:
                    if ($count > 1) {
                        header("Location: uredi_oglas.php?error=br_slika&id=".$id);
                    }elseif($count == 0 || $count == NULL) {
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) or trigger_error() ."in". $sql;
                        header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                    }else{
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                                mysqli_query($conn, $sql) or trigger_error() ."in". $sql;
                        for ($i=0; $i < $count ; $i++) { 
                            $tmp_slika = $_FILES["slike"]["tmp_name"][$i];	
                            $ime_slika = $_FILES["slike"]["name"][$i];
                            $tip_slika = $_FILES["slike"]["type"][$i];
                                            
                            $slExt = explode('.', $ime_slika); # razdvaja ime slike i njenu ekstenziju
                            $slActualExt = strtolower(end($slExt)); # ekstenziju pretvara u mala slova
                            $allowed = array('jpg', 'jpeg', 'png');

                            if (in_array($slActualExt, $allowed)){#provjera dali slika ima nešto od niza koji su dozvoljene sktenzije
                                $slNameNew = uniqid('', true) .".".$slActualExt;
                                $putanja_slika = "uploads/oglasi/slike_oglasa_".$id."/".$slNameNew;
                                move_uploaded_file($tmp_slika, $putanja_slika);
                                #SPREMANJE SLIKA								
                                $sqlSL = "INSERT INTO slike_oglasa (id_oglas, ime_slika, tip_slika, putanja_slika)	
                                VALUES ('$id', '$slNameNew', '$tip_slika', '$putanja_slika');";
                                $result = mysqli_query($conn, $sqlSL) or trigger_error()."in".$sqlSL;
                                
                                header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                            }else{
                                header("Location: uredi_oglas.php?error=format&id=".$id);
                            }
                        }
                    }
                    break;
                case 5:
                    if($count == 0 || $count == NULL){
                        $sql = "UPDATE oglas SET naslov = '$naslov', tekst = '$tekst', kontakt_o = '$kontakt_o' WHERE id_oglas = ".$id.";";
                        mysqli_query($conn, $sql) or trigger_error() ."in". $sql;
                        header("Location: oglasi_ulogiranog_korisnika.php?uploadsuccess");
                       
                    }else{
                        header("Location: uredi_oglas.php?error=br_slika&id=".$id);
                    }
                    break;
            
            }  
        }
    }
}elseif(isset ($_POST['aktivOgl'])){

	$sqlA = "UPDATE oglas SET aktivan = 0 WHERE id_oglas = " .$id. ";"; 
	mysqli_query($conn, $sqlA);
	header("Location: oglasi_ulogiranog_korisnika.php");
}
elseif(isset ($_POST['deakOgl'])){

	$sqlde = "UPDATE oglas SET aktivan = 2 WHERE id_oglas = " .$id. ";"; 
    mysqli_query($conn, $sqlde);
    header("Location: oglasi_ulogiranog_korisnika.php");
	
}elseif(isset ($_POST['DelBut'])){
    #brisanje slika iz baze
    $sql = "DELETE FROM slike_oglasa WHERE id_oglas=" .$id. ";";
	$sql .= "DELETE FROM oglas WHERE id_oglas=" .$id. ";"; 
    mysqli_multi_query($conn, $sql);
	
    #i iz foldera
    $putanja = "uploads/oglasi/slike_oglasa_".$id;
	if($result){
		unlink($putanja);
    }
    header("Location: oglasi_ulogiranog_korisnika.php");
}
	
?>
</div>
</div>
<?php 
	require "footer.php";
?>