<?php 

require_once("../Modelo/Modulo.php");

$id_modulo = $_GET['id_modulo'];

if (!isset($id_modulo)) {
	echo "<script>
    window.location.href='../vista/modulos.php';
    </script>";
    exit();
}else{
   $datos = explode('_', $id_modulo);
   $id_modulo = $datos[0];
   $opcion = $datos[1];

   if ($opcion == 2) {
   	  $modulo = new Modulo();
   	  $bloquear = $modulo->bloquear($id_modulo);
   }else{
   	  $modulo = new Modulo();
   	  $desbloquear = $modulo->desbloquear($id_modulo);
   }
}

 ?>