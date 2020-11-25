<?php 
    include 'header.php';
    ob_start();
    
?>
<div class="placanje">
<div class="container">
    <div class="search-wrapper">
        <h1>Plaćanje karticom:</h1>
        <h6 id="tip">Iznos narudžbe: 15kn</h6>
    </div>      
    <div class="papirici pb-5">
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $id = mysqli_real_escape_string($conn,$_GET['id']);
    $sql = "SELECT a.ime, a.prezime, a.kontakt_k, a.email, b.id_oglas, b.naslov FROM korisnik AS a INNER JOIN
                (SELECT id_oglas, id_korisnik, naslov FROM oglas) AS b ON a.id_korisnik=b.id_korisnik WHERE id_oglas= " .$id. ";" ;
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) { 
        while ($row = mysqli_fetch_assoc($result)) {
            $ido = $row['id_oglas'];
            $naslov_ogl = $row['naslov'];
            $email = $row['email'];
            echo"<div class='container'>
                <i class='pin'></i>
                    <blockquote class='note yellow'>
                        <b>Podaci o vlasniku kartice:</b><hr>
                            <form class='forma' action='charge.php?ogl=".$naslov_ogl."&email=".$email."&ido=".$ido."' id='payment-form' method='post'>
                            <ul>
                                <li><label for='ime'>Ime: </label><input type='text' name='ime'  value='" .$row['ime']. "'></li>
                                <li><label for='prez'>Prezime: </label><input type='text' name='prez'  value='" .$row['prezime']. "'></li>
                                <li><label for='adr'>Adresa: </label><input type='text' name='adr'placeholder='Upišite adresu'></li>
                                <li><label for='grad'>Grad: </label><input type='text' name='grad'placeholder='Upišite grad'></li>
                                <li><label for='pbr'>Poštanski broj: </label><input type='password' name='pbr'placeholder='Upišite poštanski broj'></li>
                                <li><label for='dr'>Država: </label><input type='text' name='dr'placeholder='Upišite državu'></li>
                                <li><label for='tel'>Telefonski broj: </label><input type='text' name='tel'value='" .$row['kontakt_k']. "'></li>
                                <li><label for='email'>e-mail:</label><input type='email' name='ime'  value='" .$row['email']. "'></li>
                            <ul>          
                    </blockquote>
                </div>";
        }
    }
    echo"<div class='container'>
        <i class='pin'></i>
            <blockquote class='note yellow'>  
                <label for='card-element'>
                    <b>Podaci o kartici: </b><hr><p>Molim Vas upišite broj kartice, datum isteka i CVC kod</p>
                    </label>
                    <div id='card-element'>
                    <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <!-- Used to display Element errors. -->
                    <div id='card-errors' role='alert'></div>
                <div class='bayBut'>
                    <button id='pay' type='submit' name='payBut'> Plati oglas </button>
                </form> 
                <form action='placanje.php' method='post'>
                    <button id='odustani' type='submit' name='odustani'> Odustani </button>
                </form>
                </div>
            </blockquote>
        </div>";
}
?>
</div>
</div>
</div> 
<script src="https://js.stripe.com/v3/"></script>
<script src="./js/charge.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1./jquery.min.js"></script>

<?php

require "footer.php";