<?php
require "includes/dbh.inc.php";

require('captcha/autoload.php');

    $siteKey = '6LcXjMQUAAAAALmEA14W1O7AnaYlV12RvaOV4CSk';
    $secret = '6LcXjMQUAAAAALEEzJIoGvxr50sfqnv3-rqGCutt';
    
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);
    
    $gRecaptchaResponse = $_POST['g-recaptcha-response']; //google captcha post data
    $remoteIp = $_SERVER['REMOTE_ADDR']; //to get user's ip
    
    $recaptchaErrors = ''; // blank varible to store error
    
    $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp); //method to verify captcha

    $mail_status = false;

if ($resp->isSuccess()) {
    if(isset($_POST['send'])){
        $idk = $_GET['idk'];
        $ido = $_GET['ido'];

        $ime = $_POST['ime'];
        $email = $_POST['email'];
        $poruka = $_POST['poruka'];
        $imeOglasa = $_POST['imeOglasa'];

        if (empty($ime) || empty($email) || empty($poruka)) {#provjerava dali su prazna polja
            header("Location: poruka.php?error=emptyfields&idk=".$idk. "&ido=".$ido); 
			exit();
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: poruka.php?error=invalidmail&idk=".$idk. "&ido=".$ido); 
            exit();
        }
        else{
            $sql = "SELECT email FROM korisnik  WHERE id_korisnik=" .$idk. ";" ;
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_array($result)){

                $mail_to = $row['email'];
                $subject = 'Nova poruka od '.$ime.' za oglas "'.$imeOglasa.'"';
        
                $body_message = 'Poruku poslao: '.$ime. "\n";
                $body_message .= 'E-mail: '.$email."\n";
                $body_message .= 'Poruka: '.$poruka;
        
        
                $headers = 'From: '.$email."\r\n";
                $headers .= 'Reply-To: '.$row['email']."\r\n";
        
        
                $mail_status = mail($mail_to, $subject, $body_message, $headers);

                header("Location: svi_oglasi.php");
                
                
            }
        }
    }
}else {
    $idk = $_GET['idk'];
    $ido = $_GET['ido'];
    header("Location: poruka.php?error=captcha&idk=".$idk. "&ido=".$ido); 
	exit();
    }
    
    if ($mail_status) {
         header("Location: svi_oglasi.php?success"); 
	exit();
    }