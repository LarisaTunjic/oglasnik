<?php

    include 'header.php';

if(!(empty($_GET['tid'])) && !(empty($_GET['product'])) && !(empty($_GET['email'])) &&! (empty($_GET['ido']))){

    $tid = $_GET['tid'];
    $product = $_GET['product'];
    $email = $_GET['email'];
    $email_o = "malilaric@gmail.com";
    $ido = $_GET['ido'];

    $sql = "UPDATE oglas SET id_tip_oglas = 1 WHERE id_oglas = ".$ido.";";
    mysqli_query($conn, $sql);

    $mail_to = $email;
    $subject = $product;

    $body_message = 'Hvala Vam što ste odabrali Oglasnik.'. "\n";
    $body_message .= 'Id Vaše transakcije je: '.$tid."\n";
    $body_message .= 'Vaš Oglasnik';

    $headers = 'From: '.$email_o."\r\n";

    $mail_status = mail($mail_to, $subject, $body_message, $headers);
}else{
    header('Location: placanje.php');
}

?>
<div class="kategorije">
    <div class="container">
        <div class="search-wrapper">
            <h1> Hvala Vam na plaćanju oglasa</h1>
        </div>
        <div class='pb-5'>
            <i class='pinn'></i>
                <blockquote class='note yellow'>
                    <b><?php echo $product ?></b>
                    <hr>
                    <p>Primili ste e-mail sa više informacija</p>
                    <p><a href="oglasi_ulogiranog_korisnika.php" class="btn btn-light mt-2">Povratak na ostale oglase</a></p>
                </blockquote>
        </div>
    </div>
</div>
<?php
require "footer.php";
?>



 