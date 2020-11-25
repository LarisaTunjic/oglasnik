<?php
    require_once('vendor/autoload.php');

    $ido = $_GET['ido'];
    $naslov_ogl = $_GET['ogl'];
    $email = $_GET['email'];

    
    \Stripe\Stripe::setApiKey('sk_test_w0rLfgYp4BdRtY68rtVqg6eg00ggL67Tm1');

    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    $ime = $POST['ime']; 
    $prez = $POST['prez'];     
    $token = $POST['stripeToken'];

$customer = \Stripe\Customer::create(array(
    "email" =>$email,
    "source" => $token
));

$charge = \Stripe\Charge::create(array(
    "amount" => 1500,
    "currency" => "HRK",
    "description" => "Platili ste oglas '".$naslov_ogl."'",
    "customer" => $customer->id
));

header('Location: success.php?tid='.$charge->id.'&product='.$charge->description.'&email='.$email.'&ido='.$ido);