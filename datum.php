<?php
    date_default_timezone_set('Europe/Zagreb');
    
    $datum = date('Y-m-d H:i:s');
    echo "datum danas: " .$datum. "<br>";
    $vrijeme = '2020-03-20 19:51:00';
    echo "datum oglasa: " .$vrijeme. "<br>";
	$danas = strtotime(date('Y-m-d H:m:s'));
	#$razlika = $danas - strtotime($vrijedi_do);
    echo "<br> sada: ".$danas;
    function deaktivacijaOglasa($vrijedi_do){
        $danas = strtotime(date('Y-m-d H:i:s'));
        $oglas = strtotime($vrijedi_do);
        echo "<br> oglas: ".$oglas;
        $razlika = $danas - $oglas;
        echo "<br>".$razlika;
        if($razlika > 1){
            echo "<br>istekao";
        }
        else {
            echo "<br>vrijedi";
        }
    }
    deaktivacijaOglasa($vrijeme);
        