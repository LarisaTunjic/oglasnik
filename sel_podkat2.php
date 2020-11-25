<?php 
session_start();
require "includes/dbh.inc.php";


$id_pod = $_POST['id_kategorija'];   // department id

$sql = "SELECT id_kategorija, naziv FROM kategorija WHERE nadkategorija_id=".$id_pod.";";

$result = mysqli_query($conn,$sql);

$array_podkategorije = array();

while( $row = mysqli_fetch_array($result) ){
    $id_pod2 = $row['id_kategorija'];
    $naziv = $row['naziv'];

    $array_podkategorije[] = array("id_kategorija" => $id_pod2, "naziv" => $naziv);
}

// encoding array to json format
echo json_encode($array_podkategorije);
?>