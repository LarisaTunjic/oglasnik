<?php 
    include 'header.php';
    
?>
<div class="kategorije">
<div class="container">
    <div class="search-wrapper">
        <h1>Podaci za plaćanje</h1>
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
                <table class='podaci'>
                    <tr>
                        <th>Šifra oglasa:</th><td>".$row['id_oglas']."</td>
                    </tr>
                    <tr>
                        <th>Naslov oglasa:  </th><td>".$row['naslov']."</td>
                    </tr>
                    <tr>
                        <th>Primatelj:  </th><td>Oglasnik d.o.o., Ivanićgradska 60, 10 000 Zagreb</td>
                    </tr>  
                    <tr>
                        <th>Iznos:</th> <td>15 kn</td>
                    </tr>
                    <tr>
                        <th>Model:</th> <td>HR02</td>
                    </tr>
                    <tr>
                        <th>Poziv na broj primatelja:</th> <td>10-".$row['id_oglas']."</td>
                    </tr>
                    <tr>
                        <th>IBAN:</th> <td>HR9223000041245700111</td>
                    </tr>
                    <tr>
                        <th>Opis plaćanja:</th> <td>Oglas broj ".$row['id_oglas']."</td>
                    </tr>
                </table>
                    <p>Prilikom plaćanja uplatnicom, koristite gore navedene podatke. Popunite ih ispravno kako bi što prije 
                        istaknuli Vaš oglas. Uplaćena sredstva su vidljiva u roku od 1 do 3 radna dana. Za pomoć kontaktirajte 
                        našu službu za korisnike. Hvala Vam što ste nas odabrali.</p>
        </blockquote>
        </div>";
    }
}
?>
</div>
</div>  
<?php
    require "footer.php";
    