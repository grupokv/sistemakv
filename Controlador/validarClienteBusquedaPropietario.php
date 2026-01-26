<?php 

require_once '../Modelo/Cliente.php';

$busqueda = $_POST['buscador'];
$id_usuario = $_POST['id_usuario'];

$cliente = new Cliente();
$validarPorNitCliente = $cliente->validarPorNitCliente($busqueda);

$cant = count($validarPorNitCliente);

$html = '';

if ($cant > 0) {
	foreach ($validarPorNitCliente as $vnpc) {
		$html .= '<form action="../Controlador/anclarClientePorPropietario.php" method="POST">';
			$html .= '<div class="col-12 d-flex justify-content-center mt-4">';
				$html .= '<input type="hidden" class="form-control" name="id_cliente" id="id_cliente" value="'. $vnpc['id_cliente'] .'" />';
				$html .= '<input type="hidden" class="form-control" name="id_usuario" id="id_usuario" value="'. $id_usuario .'" />';
				$html .= '<pre>';
				$html .= '<p><strong>RAZON SOCIAL: </strong>' . $vnpc['razon_social'] . '</p>';
				$html .= '<p><strong>NIT: </strong>' . $vnpc['nit_cliente'] . '</p>';
				$html .= '<p><strong>DIRECCIÓN: </strong>' . $vnpc['direccionC'] . '</p>';
				$html .= '<p><strong>TELEFONO: </strong>' . $vnpc['telefonoC'] . '</p>';
			$html .= '</div>';
			$html .= '<div class="col-12 d-flex justify-content-center mb-2">';
				$html .= '<button type="submit" class="btn btn-success">Anclar Cliente</button>';
			$html .= '</div>';
		$html .= '</form>';
	}
}else{
	$html .= '<div class="d-flex justify-content-center mt-5">';
		$html .= '<p style="color: red;"> El cliente no se encuentra registrado en el sistema. </p>';
	$html .= '</div>';
}

echo $html;

?>