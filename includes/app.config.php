<?php

define("CONSUMER_KEY","");
define("CONSUMER_SECRET","");
define("TOKEN","");
define("TOKEN_SECRET","");
define("RPP",15);
define("SOURCE_SCREEN_NAME","ingresa un nombre");
define("SEND_DM",0);  // 0: actualiza status con mención al user. 1: envía un DM al user

$frases = array(
"--", 
"--"
);

// CENTRO DE SANTIAGO
$geo = array(
'LAT' => -33.464542,
'LON' => -70.660168,
'RAD' => 55
);

// Usuarios Baneados
$banned = array();

error_reporting(0);

?>
