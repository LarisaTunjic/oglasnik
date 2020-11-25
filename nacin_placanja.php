<?php 
    include 'header.php';
?>
<div class="kategorije">
<div class="container">
    <div class="search-wrapper">
        <h1>Odaberite način plaćanja:</h1><br>
    </div>
<?php
$id = $_GET['id'];
$id = mysqli_real_escape_string($conn,$_GET['id']);
$sql = "SELECT *  FROM oglas WHERE id_oglas=" .$id. ";" ;
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) { 
	while ($row = mysqli_fetch_assoc($result)) {
        echo"<div class='pb-5'>
            <i class='pinn'></i>
            <blockquote class='note yellow'>
                <a href='podaci_za_uplatu?id=" .$row['id_oglas']."'>Plaćanje općom uplatnicom <br>
                <img src='img/uplatnica.jpg' width='340px'></a><br>
                <a href='placanje?id=".$row['id_oglas']."'>Plaćanje karticom (strip) <br>
                <img src='img/strip.png' width='340px'></a><br>
            </blockquote>
            </div>";
    }
}
?>
</div>
</div>
<?php
    require "footer.php";
?>

	