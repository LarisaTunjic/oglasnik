<?php 
session_start();
require "includes/dbh.inc.php";


$id_kat = $_POST['id_kategorija'];   // department id

$sqlPOD = "SELECT id_kategorija, naziv FROM kategorija WHERE nadkategorija_id=".$id_kat.";";

$result = mysqli_query($conn,$sqlPOD);

$array_podkategorije = array();

while( $row = mysqli_fetch_array($result) ){
    $id_pod = $row['id_kategorija'];
    $naziv = $row['naziv'];

    $array_podkategorije[] = array("id_kategorija" => $id_pod, "naziv" => $naziv);
}

// encoding array to json format
echo json_encode($array_podkategorije);
?>

