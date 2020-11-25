<?php
    require "includes/dbh.inc.php";
    $idk = $_GET['idk'];
    $ido = $_GET['ido'];

    $query = "INSERT INTO spremljeni_oglasi (id_korisnik, id_oglas) VALUES ('$idk', '$ido')";
    $result = mysqli_query($conn, $query);
    header("Location: oglas.php?id=".$ido);
    

?>
