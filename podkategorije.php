<?php 
	include 'header.php';
	$id = $_GET['id'];
?>
<div class="kategorije">
<div class="container">
<div class='pb-5'>
<?php

$query = "SELECT naziv FROM kategorija WHERE id_kategorija=" .$id .";";
$result = mysqli_query($conn,$query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='search-wrapper'>
        <h1>" .$row['naziv']. "</h1>";		#ispis naziva podkategorije
    }
}
$sql = "SELECT * FROM kategorija WHERE nadkategorija_id = ".$id.";"; 
$result = mysqli_query($conn, $sql);			#AKO IMA PODKATEGORIJE ISPISI IH
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0){
    echo"</div><ul>";
    while ($row = mysqli_fetch_assoc($result)) {		
        if(!(isset($_SESSION['id_tip']))){	#PRIKAZ ZA ANONIMNOG KORISNIKA
            echo"<li><a href='podkategorije.php?id=" .$row['id_kategorija']."'>
                <i class='pin'></i>";
            $velicina = strlen($row['naziv']);
            if($velicina > 15){
                echo "<b>".$row['naziv']."</b>";
            }else{
                echo"<h2>" . $row['naziv'] . "</h2>"; }
            if($row['slika'] == 0){
                echo "<figure><img class='slProf1' src='uploads/kategorije/kategorija.png' /></figure>";
            }else{
                $imeSL = "uploads/kategorije/kategorija".$row['id_kategorija']."*";
                $infoSL = glob($imeSL);
                $extSL = explode(".", $infoSL[0]); 
                $actualextSL = $extSL[1]; 
                echo"<figure><img class='slProf1' src='uploads/kategorije/kategorija".$row['id_kategorija'].".".$actualextSL."'/></figure>";
            }
            $sql2 ="SELECT id_oglas, COUNT(*)as broj FROM oglas WHERE aktivan = 1 AND (id_kategorija = ".$row['id_kategorija']." || id_nadkategorija = ".$row['id_kategorija'].");";
			$result2 = mysqli_query($conn, $sql2);
			$resultCheck = mysqli_num_rows($result2);
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result2)) {
					echo "<br><p class='br_ogl'>broj oglasa:" . $row['broj']."</p>";
					echo"</a></li>";
				}				
			}
        }elseif($_SESSION['id_tip']=='1'){	#obični korisnik
            echo"<li><a href='podkategorije.php?id=" .$row['id_kategorija']."'>
                <i class='pin'></i>";
            $velicina = strlen($row['naziv']);
            if($velicina > 15){
                echo "<b>".$row['naziv']."</b>";
            }else{
                echo"<h2>" . $row['naziv'] . "</h2>"; }
            if($row['slika'] == 0){
                echo "<figure><img class='slProf1' src='uploads/kategorije/kategorija.png' /></figure>";
            }else{
                $imeSL = "uploads/kategorije/kategorija".$row['id_kategorija']."*";
                $infoSL = glob($imeSL);
                $extSL = explode(".", $infoSL[0]); 
                $actualextSL = $extSL[1]; 
                echo"<figure><img class='slProf1' src='uploads/kategorije/kategorija".$row['id_kategorija'].".".$actualextSL."'/></figure>";
            }
            $sql2 ="SELECT id_oglas, COUNT(*)as broj FROM oglas WHERE aktivan = 1 AND (id_kategorija = ".$row['id_kategorija']." || id_nadkategorija = ".$row['id_kategorija'].");";
			$result2 = mysqli_query($conn, $sql2);
			$resultCheck = mysqli_num_rows($result2);
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result2)) {
					echo "<br><p class='br_ogl'>broj oglasa:" . $row['broj']."</p>";
					echo"</a></li>";
				}				
			}
        }
    }
    echo"</ul>";
}
else{		#INAČE LISTA OGLASA
    $sql = "SELECT * FROM oglas WHERE aktivan = 1 AND (id_kategorija = ".$id." || id_nadkategorija = ".$id." || id_nadkategorija2 = ".$id.") ;";
    $result = mysqli_query($conn, $sql);			
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            echo"
            <h6 id='tip' class='ml-auto'>Tip oglasa:</h6>
            <form action='"; echo $_SERVER['PHP_SELF']; echo "?id="; echo $id;echo"' method='post' class='form-row justify-content-between' name='form_filter' >
                <select class='tip_ogl col-md-5 form-control' name='value' method='POST'>
                    <option value='0'>Svi</option>
                    <option value='2'>Besplatni</option>
                    <option value='1'>Plaćeni</option>
                </select>
                <input class='filter col-md-5 form-control' type='submit' value = 'Filtriraj'>
            </form>
        
            </div><ul>";
            if(isset($_POST['value'])) {
                if($_POST['value'] == '0'){
                    $id = $_GET['id'];
                    $id = mysqli_real_escape_string($conn,$_GET['id']); #ISPIŠI PRVO PLAĆENE
                    $query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, b.naziv FROM oglas AS a INNER JOIN(
                                SELECT id_kategorija, naziv FROM kategorija)
                                AS b ON a.id_kategorija=b.id_kategorija
                                WHERE b.id_kategorija= " .$id ." AND aktivan='1'AND id_tip_oglas = '1' ORDER BY a.vrijedi_od DESC;";
                    $result = mysqli_query($conn, $query);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li class='placeni'><a href='oglas.php?id=" .$row['id_oglas']."'>
                                <i class='pin'></i>";
                            $velicina = strlen($row['naslov']);
                            if($velicina > 8){
                                echo "<p class=placeni-pill><b>".$row['naslov']."</b></p>";
                            }else{
                                echo"<h2>" . $row['naslov'] . "</h2><br>"; }
                            echo"<p style='font-style: italic'>" .$row['naziv']."</p>
                            <p class=kontakt>Objavljeno ";
                            $datum = $row['vrijedi_od'];
                            $datum = strtotime($datum);
                            $danas = date("Y-m-d");
                            $danas = strtotime($danas);
                            $datediff = $danas - $datum ;
                            $rezultat = round($datediff / 86400);
                            if ($rezultat == 1){
                                echo "jučer</p>";
                            }elseif($rezultat == 0){
                                echo "danas</p>";
                            }else{
                                echo "prije ". $rezultat." dana</p>";
                            }
                            echo"<p>Pogledaj oglas</p></a></li>";
                        }
                    }
                    $query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, b.naziv FROM oglas AS a INNER JOIN(
                        SELECT id_kategorija, naziv FROM kategorija)        #ISPIŠI BESPLATNE OGLASE
                        AS b ON a.id_kategorija=b.id_kategorija
                        WHERE b.id_kategorija= " .$id ." AND aktivan='1'AND id_tip_oglas = '2' ORDER BY a.vrijedi_od DESC;";
                    $result = mysqli_query($conn, $query);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
                                <i class='pin'></i>";
                            $velicina = strlen($row['naslov']);
                            if($velicina > 8){
                                echo "<p><b>".$row['naslov']."</b></p>";
                            }else{
                                echo"<h2>" . $row['naslov'] . "</h2><br>"; }
                            echo"<p style='font-style: italic'>" .$row['naziv']."</p>
                            <p class=kontakt>Objavljeno ";
                            $datum = $row['vrijedi_od'];
                            $datum = strtotime($datum);
                            $danas = date("Y-m-d");
                            $danas = strtotime($danas);
                            $datediff = $danas - $datum ;
                            $rezultat = round($datediff / 86400);
                            if ($rezultat == 1){
                                echo "jučer</p>";
                            }elseif($rezultat == 0){
                                echo "danas</p>";
                            }else{
                                echo "prije ". $rezultat." dana</p>";
                            }
                            echo"<p>Pogledaj oglas</p></a></li>";
                        }
                    }                            
                }elseif($_POST['value'] == '2'){
                    echo"<h1>Besplatni oglasi</h1>";
                    $id = $_GET['id'];
                    $id = mysqli_real_escape_string($conn,$_GET['id']);
                    $query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, a.id_tip_oglas, b.naziv FROM oglas AS a INNER JOIN(
                                SELECT id_kategorija, naziv FROM kategorija)
                                AS b ON a.id_kategorija=b.id_kategorija
                                WHERE b.id_kategorija = " .$id ." AND aktivan = '1' AND id_tip_oglas = '2' ORDER BY a.vrijedi_od DESC;";
                    $result = mysqli_query($conn,$query);		#ispis oglasa sa filterom
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
                            <i class='pin'></i>";
                            $velicina = strlen($row['naslov']);
                            if($velicina > 8){
                                echo "<b>".$row['naslov']."</b>";
                            }else{
                                echo"<h2>" . $row['naslov'] . "</h2>"; 
                            }
                            echo"<p class=kontakt>Objavljeno ";
                            $datum = $row['vrijedi_od'];
                            $datum = strtotime($datum);
                            $danas = date("Y-m-d");
                            $danas = strtotime($danas);
                            $datediff = $danas - $datum ;
                            $rezultat = round($datediff / 86400);
                            if ($rezultat == 1){
                                echo "jučer</p>";
                            }elseif($rezultat == 0){
                                echo "danas</p>";
                            }else{
                                echo "prije ". $rezultat." dana</p>";
                            }
                            echo"<p>Pogledaj oglas</p></a></li>";
                        }          
                    }else{
                        echo"<div class='quote-container'>
                        <i class='pin'></i>
                        <blockquote class='note yellow' style='font-family: Satisfy; font-size: 21px;'>
                        Ova kategorija još ne sadrži besplatne oglase.</blackquote></div>";
                    }
                }elseif($_POST['value'] == '1'){
                    echo"<h1>Plaćeni oglasi</h1>";
                    $id = $_GET['id'];
                    $id = mysqli_real_escape_string($conn,$_GET['id']);
                    $query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, a.id_tip_oglas, b.naziv FROM oglas AS a INNER JOIN(
                                SELECT id_kategorija, naziv FROM kategorija)
                                AS b ON a.id_kategorija=b.id_kategorija
                                WHERE b.id_kategorija = " .$id ." AND aktivan = '1' AND id_tip_oglas = '1' ORDER BY a.vrijedi_od DESC;";
                    $result = mysqli_query($conn,$query);		#ispis oglasa sa filterom
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
                            <i class='pin'></i>";
                            $velicina = strlen($row['naslov']);
                            if($velicina > 8){
                                echo "<b>".$row['naslov']."</b>";
                            }else{
                                echo"<h2>" . $row['naslov'] . "</h2>"; 
                            }
                            echo"<p class=kontakt>Objavljeno ";
                            $datum = $row['vrijedi_od'];
                            $datum = strtotime($datum);
                            $danas = date("Y-m-d");
                            $danas = strtotime($danas);
                            $datediff = $danas - $datum ;
                            $rezultat = round($datediff / 86400);
                            if ($rezultat == 1){
                                echo "jučer</p>";
                            }elseif($rezultat == 0){
                                echo "danas</p>";
                            }else{
                                echo "prije ". $rezultat." dana</p>";
                            }
                            echo"<p>Pogledaj oglas</p></a></li>";
                        }          
                    }else{
                        echo"<div class='quote-container'>
                        <i class='pin'></i>
                        <blockquote class='note yellow' style='font-family: Satisfy; font-size: 21px;'>
                        Ova kategorija još ne sadrži plaćene oglase.</blackquote></div>";
                    }
                }
            }else{
                $id = $_GET['id'];						#ispis oglasa bez filtera
                $id = mysqli_real_escape_string($conn,$_GET['id']);
                $query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, b.naziv FROM oglas AS a INNER JOIN(
                    SELECT id_kategorija, naziv FROM kategorija)
                    AS b ON a.id_kategorija=b.id_kategorija
                    WHERE b.id_kategorija= " .$id ." AND aktivan='1'AND id_tip_oglas = '1' ORDER BY a.vrijedi_od DESC;";
                $result = mysqli_query($conn, $query);
                $resultCheck = mysqli_num_rows($result);
                if ($resultCheck > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li class='placeni'><a href='oglas.php?id=" .$row['id_oglas']."'>
                            <i class='pin'></i>";
                        $velicina = strlen($row['naslov']);
                        if($velicina > 8){
                            echo "<p class=placeni-pill><b>".$row['naslov']."</b></p>";
                        }else{
                            echo"<h2>" . $row['naslov'] . "</h2><br>"; }
                        echo"<p style='font-style: italic'>" .$row['naziv']."</p>
                        <p class=kontakt>Objavljeno ";
                        $datum = $row['vrijedi_od'];
                        $datum = strtotime($datum);
                        $danas = date("Y-m-d");
                        $danas = strtotime($danas);
                        $datediff = $danas - $datum ;
                        $rezultat = round($datediff / 86400);
                        if ($rezultat == 1){
                            echo "jučer</p>";
                        }elseif($rezultat == 0){
                            echo "danas</p>";
                        }else{
                            echo "prije ". $rezultat." dana</p>";
                        }
                        echo"<p>Pogledaj oglas</p></a></li>";
                    }
                }
                $query = "SELECT a.id_oglas, a.id_kategorija, a.naslov, a.vrijedi_od, b.naziv FROM oglas AS a INNER JOIN(
                    SELECT id_kategorija, naziv FROM kategorija)        #ISPIŠI BESPLATNE OGLASE
                    AS b ON a.id_kategorija=b.id_kategorija
                    WHERE b.id_kategorija= " .$id ." AND aktivan='1'AND id_tip_oglas = '2' ORDER BY a.vrijedi_od DESC;";
                $result = mysqli_query($conn, $query);
                $resultCheck = mysqli_num_rows($result);
                if ($resultCheck > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li><a href='oglas.php?id=" .$row['id_oglas']."'>
                            <i class='pin'></i>";
                        $velicina = strlen($row['naslov']);
                        if($velicina > 8){
                            echo "<p><b>".$row['naslov']."</b></p>";
                        }else{
                            echo"<h2>" . $row['naslov'] . "</h2><br>"; }
                        echo"<p style='font-style: italic'>" .$row['naziv']."</p>
                        <p class=kontakt>Objavljeno ";
                        $datum = $row['vrijedi_od'];
                        $datum = strtotime($datum);
                        $danas = date("Y-m-d");
                        $danas = strtotime($danas);
                        $datediff = $danas - $datum ;
                        $rezultat = round($datediff / 86400);
                        if ($rezultat == 1){
                            echo "jučer</p>";
                        }elseif($rezultat == 0){
                            echo "danas</p>";
                        }else{
                            echo "prije ". $rezultat." dana</p>";
                        }
                        echo"<p>Pogledaj oglas</p></a></li>";
                    }
                }
            }
        }
    }else{
        echo"<h6 id='tip' class='ml-auto'>Tip oglasa:</h6>
        <form action='"; echo $_SERVER['PHP_SELF']; echo "?id="; echo $id;echo"' method='post' class='form-row justify-content-between' name='form_filter' >
            <select class='tip_ogl col-md-5 form-control' name='value' method='POST'>
                <option value='0'>Svi</option>
                <option value='2'>Besplatni</option>
                <option value='1'>Plaćeni</option>
            </select>
            <input class='filter col-md-5 form-control' type='submit' value = 'Filtriraj'>
        </form>";
        echo"</div><ul>";
        echo"<div class='quote-container'>
		  <i class='pin'></i>
		  <blockquote class='note yellow' style='font-family: Satisfy; font-size: 32px; padding: 10px; padding-left: 50px;'>
          Kategorija nema oglasa.</blackquote></div>";
       
        
    }
}
?>
</ul>
</div>
</div>
</div>
<?php 
	include 'footer.php';
?>