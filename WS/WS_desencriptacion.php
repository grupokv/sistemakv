<?php
date_default_timezone_set('America/Bogota');
include('WS_encriptacion.php');

$seguridad = new Seguridad();
$fecha = date('YmdHis');
$dato = '80189960'.$fecha;
echo $key = $seguridad->encrypt($dato);
echo "<br/>";
echo $des = $seguridad->decrypt($key);


?>