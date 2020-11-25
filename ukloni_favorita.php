<?php
require "includes/dbh.inc.php";

$idk = $_GET['idk'];
$ido = $_GET['ido'];

if($_GET['action'] && $_GET['action'] == 'delete') {
    $sqlB = "DELETE FROM spremljeni_oglasi WHERE id_korisnik =".$idk." AND id_oglas =".$ido." ;";
    $result = mysqli_query($conn, $sqlB);
    header("Location: favoriti.php");
}