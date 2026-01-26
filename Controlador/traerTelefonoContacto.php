<?php 
require("../Modelo/Programacion.php");

$contacto = $_POST['contacto'];

$html = '';
$programacion = new Programacion();

$dato = $programacion->telefonoContacto($contacto);
//echo count($dato);
if(count($dato) > 0){
    $html = $dato[0]['telefono_contacto'];
}
echo $html;

?>