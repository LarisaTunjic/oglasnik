<?php
	require "header.php";
	ob_start();
?>
<div class="kategorije">
<div class="container">	
<div class="search-wrapper">

    <h1>Vaši favoriti</h1>
</div>
<?php 
$id = $_SESSION['kor_id'];

$id = mysqli_real_escape_string($conn, $_SESSION['kor_id']);

if(isset($_POST['favoriti'])){
	if (isset($_SESSION['kor_id'])){
        $sql = "SELECT a.id_oglas, a.naslov, DATE_FORMAT(vrijedi_od, '%Y-%m-%d') AS datum FROM oglas a INNER JOIN spremljeni_oglasi b ON b.id_oglas = a.id_oglas WHERE b.id_korisnik = ".$_SESSION['kor_id'].";";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        echo"<div class='pb-5'><ul>";
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li><div class='oglas-wrapper'><a href='oglas.php?id=" .$row['id_oglas']."'>
                <i class='pin'></i>";
                $velicina = strlen($row['naslov']);
                if($velicina > 8){
                    echo "<p><b>".$row['naslov']."</b></p>";
                }else{
                    echo"<h2>" . $row['naslov'] . "</h2><br>"; 
                }
                echo"<p class=kontakt>Objavljeno ";
                $datum = $row['datum'];
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
                echo"<p>Pogledaj oglas</p><a class='ukloni' style='padding-top: 2px; padding-bottom: 2px;' href='ukloni_favorita.php?action=delete&idk=" .$_SESSION['kor_id']."&ido=". $row['id_oglas'] ."'>Ukloni favorita</a></a></div></li>";
            }
        }else{
            echo"<div class='quote-container'>
            <i class='pin'></i>
            <blockquote class='note yellow' style='font-size: 26px; font-family:Satisfy; padding-left: 46px;'>
            Još nemate spremljenih oglasa.</blackquote></div>";
        }
    }
}
?>
</ul>
</div>
</div>
</div>
<?php 

	require "footer.php";
?>