<?php 

require_once("../Modelo/Usuario.php");

$id_usuario = $_GET['id_usuario'];

if (!isset($id_usuario)) {
	echo "<script>
    window.location.href='../vista/usuarios.php';
    </script>";
    exit();
}else{

   $datos = explode('_', $id_usuario);
   $id_usuario = $datos[0];
   $opcion = $datos[1];


	if($opcion == 2){
		$usuario = new Usuario();
		$bloquear = $usuario->bloquear($id_usuario);
	} else {
		$usuario = new Usuario();
		$desbloquear = $usuario->desbloquear($id_usuario);
	}
}


?>
