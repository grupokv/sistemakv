<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$html = '';

for ($i=0; $i < count($_SESSION['dataFiltro']); $i++) { 
    $html .= '<div id="filterActive" class="text-center m-1">' . $_SESSION['dataFiltro'][$i] .'</div>';
}

echo $html;

?>