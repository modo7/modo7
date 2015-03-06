<?php
$conn=mysql_connect('localhost', 'nombre_usuario', 'pass') or die('Query failed: ' . mysql_error());
mysql_select_db("nombre_base_de_datos") or die('Query failed: ' . mysql_error());
mysql_set_charset('utf8',$conn); 
?>

