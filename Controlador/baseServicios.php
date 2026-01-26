<?php  
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/General.php");

$operativo = new Operativo();
$usuario = new Usuario();
$cliente = new Cliente();
$vehiculo = new Vehiculo();
$conductor = new Conductor();
$contrato = new Contrato();
$empresa = new Empresa();

/* ---------------------------- */
/* VALIDAR PERMISOS GENERALES */
/* ---------------------------- */

$modulo = 115;
$permisos = permisos($modulo, $_SESSION['id_usuario']);

$eliminar = $permisos[0]['eliminacion']; 
$editar = $permisos[0]['edicion']; 
$registro = $permisos[0]['agregacion']; 

/* ---------------------------- */
/* VALIDAR PERMISOS ESPECIFICOS */
/* ---------------------------- */

$id_usuario = $_SESSION['id_usuario'];
$listarPermisosUsuariosOperativo = $operativo->listarPermisosUsuariosOperativoIdUsuario($id_usuario);

$clientes = $listarPermisosUsuariosOperativo[0]['id_cliente'];
$anular = $listarPermisosUsuariosOperativo[0]['anulacion'];
$consulta = $listarPermisosUsuariosOperativo[0]['consulta'];

/* ---------------------------- */
/* ---------------------------- */

$_SESSION['dataFiltro'] = array();

/* ---------------------------- */
/* ---------------------------- */

if($_POST){
	
	/* -------------------------------------------- */
	/* ----------------- CLIENTE ------------------ */
		if($_SESSION['filtro_cliente'] != ""){

			if($_POST['id_cliente'] == ""){
				$id_cliente = $_SESSION['filtro_cliente'];
			}else{
				$id_cliente = " = " . $_POST['id_cliente'];
				$_SESSION['filtro_cliente'] = $id_cliente;
			}

			$clienteData = explode(" = ", $_SESSION['filtro_cliente']);
			$clienteID = $cliente->cliente_ID($clienteData[1]);

			array_push($_SESSION['dataFiltro'], 'Cliente: '. ucwords(strtolower($clienteID[0]['razon_social'])));
		}else{

			if ($_POST['id_cliente'] != "") {
				$id_cliente = " = " . $_POST['id_cliente'];
				$clienteID = $cliente->cliente_ID($_POST['id_cliente']);
				array_push($_SESSION['dataFiltro'], 'Cliente: '. ucwords(strtolower($clienteID[0]['razon_social'])));
				$_SESSION['filtro_cliente'] = $id_cliente;
			}else{
				$_SESSION['filtro_cliente'] = "";

				if($clientes == 'ALL'){
					$id_cliente = "LIKE '%%'";
				}else{
					$id_cliente = "IN (". $clientes .")";
				}
			}	
		}
	
	/* -------------------------------------------- */
	

	/* -------------------------------------------- */
	/* --------------- TIPO SERVICIO -------------- */
	
		if($_SESSION['filtro_tipoServicio'] != ""){
			if($_POST['tipo_servicio'] == ""){
				$tipo_servicio = $_SESSION['filtro_tipoServicio'];
			}else{
				$tipo_servicio = " = " . $_POST['tipo_servicio'];
				$_SESSION['filtro_tipoServicio'] = $tipo_servicio;
			}

			array_push($_SESSION['dataFiltro'], 'Tipo: '. ucfirst(strtolower($tipo_servicio)));
		}else{
			if ($_POST['tipo_servicio'] != "") {
				$tipo_servicio = $_POST['tipo_servicio'];
				array_push($_SESSION['dataFiltro'], 'Tipo: '. ucfirst(strtolower($_POST['tipo_servicio'])));
				$_SESSION['filtro_tipoServicio'] = $tipo_servicio;
			}else{
				$tipo_servicio = "";
				$_SESSION['filtro_tipoServicio'] = "";
			}
		}
	/* -------------------------------------------- */


	/* -------------------------------------------- */
	/* -------------- FECHA INICIAL --------------- */

		if($_SESSION['filtro_fechaFinal'] != ""){
			if($_POST['fecha_inicial'] == ""){
				$fecha = $_SESSION['filtro_fechaInicial'];
			}else{
				$fecha = $_POST['fecha_inicial'];
				$_SESSION['filtro_fechaInicial'] = $fecha;
			}

			array_push($_SESSION['dataFiltro'], 'Desde: '. $fecha);

		}else{
			if ($_POST['fecha_inicial'] != "") {
				$fecha = $_POST['fecha_inicial'];
			}else{
				$fecha = date('Y-m-d', strtotime('Monday this week'));
			}
			$_SESSION['filtro_fechaInicial'] = $fecha;
			array_push($_SESSION['dataFiltro'], 'Desde: '. $fecha);
		}

	/* -------------------------------------------- */


	/* -------------------------------------------- */
	/* ---------------- FECHA FINAL --------------- */

		if($_SESSION['filtro_fechaFinal'] != ""){
			if($_POST['fecha_final'] == ""){
				$fecha2 = $_SESSION['filtro_fechaFinal'];
			}else{
				$fecha2 = $_POST['fecha_final'];
				$_SESSION['filtro_fechaFinal'] = $fecha2;
			}

			array_push($_SESSION['dataFiltro'], 'Hasta: '. $fecha2);
		}else{
			if ($_POST['fecha_final'] != "") {
				$fecha2 = $_POST['fecha_final'];
			}else{
				$fecha2 = date('Y-m-d', strtotime('Sunday this week'));
			}
			$_SESSION['filtro_fechaFinal'] = $fecha2;
			array_push($_SESSION['dataFiltro'], 'Hasta: '. $fecha2);
		}

	/* -------------------------------------------- */


	/* -------------------------------------------- */
	/* ------------------ EMISOR ------------------ */
		
		if($_SESSION['filtro_emisor'] != ""){
			if($_POST['emisor'] == ""){
				$emisor = $_SESSION['filtro_emisor'];
			}else{
				$emisor = $_POST['emisor'];
				$_SESSION['filtro_emisor'] = $emisor;
			}
			
			$listarUsuEmisor = $usuario->listarUsuarioPorId($emisor);
			array_push($_SESSION['dataFiltro'], 'Emitido Por: ' . ucwords(strtolower($listarUsuEmisor[0]['nombre'])));
		}else{
			if ($_POST['emisor'] != "") {
				$emisor = $_POST['emisor'];
				$listarUsuEmisor = $usuario->listarUsuarioPorId($_POST['emisor']);
				array_push($_SESSION['dataFiltro'], 'Emitido Por: ' . ucwords(strtolower($listarUsuEmisor[0]['nombre'])));
				$_SESSION['filtro_emisor'] = $emisor;
			}else{
				$_SESSION['filtro_emisor'] = "";
				$emisor = "";
			}
		}

	/* -------------------------------------------- */


	/* -------------------------------------------- */
	/* ----------------- VEHICULO ----------------- */
		
		if($_SESSION['filtro_vehiculo'] != ""){
			if($_POST['id_vehiculo'] == ""){
				$id_vehiculo = $_SESSION['filtro_vehiculo'];
			}else{
				$id_vehiculo = " = '" . $_POST['id_vehiculo'] . "'";
				$_SESSION['filtro_vehiculo'] = $id_vehiculo;
			}
			$veh = explode("'", $id_vehiculo);
			$listarVeh = $vehiculo->listarPorId($veh[1]);
			array_push($_SESSION['dataFiltro'], 'Vehículo: '. $listarVeh[0]['placa']);

		}else{
			if ($_POST['id_vehiculo'] != "") {
				$id_vehiculo = " = '" . $_POST['id_vehiculo'] . "'";
				$listarVeh = $vehiculo->listarPorId($_POST['id_vehiculo']);
				array_push($_SESSION['dataFiltro'], 'Vehículo: '. $listarVeh[0]['placa']);
				$_SESSION['filtro_vehiculo'] = $id_vehiculo;
			}else{
				$id_vehiculo = "LIKE '%%'";
				$_SESSION['filtro_vehiculo'] = "";
			}

		}

	/* -------------------------------------------- */

	
	/* -------------------------------------------- */
	/* ----------------- CONDUCTOR ---------------- */

		if($_SESSION['filtro_conductor'] != ""){
			if($_POST['id_conductor'] == ""){
				$id_conductor = $_SESSION['filtro_conductor'];
			}else{
				$id_conductor = " = '" . $_POST['id_conductor'] . "'";
				$_SESSION['filtro_conductor'] = $id_conductor;
			}
			$cond = explode("'", $id_conductor);
			$listarCond = $conductor->listarPorId($cond[1]);
			array_push($_SESSION['dataFiltro'], 'Conductor: ' . ucwords(strtolower($listarCond[0]['nombre_conductor'])));

		}else{
			if ($_POST['id_conductor'] != "") {
				$id_conductor = " = '" . $_POST['id_conductor'] . "'";
				$listarCond = $conductor->listarPorId($_POST['id_conductor']);
				array_push($_SESSION['dataFiltro'], 'Conductor: ' . ucwords(strtolower($listarCond[0]['nombre_conductor'])));
				$_SESSION['filtro_conductor'] = $id_conductor;
			}else{
				$id_conductor = "LIKE '%%' ";
				$_SESSION['filtro_conductor'] = "";
			}
		}
	/* -------------------------------------------- */


	/* -------------------------------------------- */
	/* ----------------- ASIGNACIÓN --------------- */

		if($_SESSION['filtro_pendienteAsig'] != ""){
			if($_POST['pend_asignacion'] == ""){
				$estado = $_SESSION['filtro_pendienteAsig'];
			}else{
				$estado = " = '" . $_POST['pend_asignacion'] . "'";
				$_SESSION['filtro_pendienteAsig'] = $estado;
			}
			$est = explode("'", $estado);
			array_push($_SESSION['dataFiltro'], 'Pendiente: '. $est[1]);

		}else{
			if ($_POST['pend_asignacion'] != "") {
				$estado = " = '" . $_POST['pend_asignacion'] . "'";
				array_push($_SESSION['dataFiltro'], 'Pendiente: '. $_POST['pend_asignacion']);
				$_SESSION['filtro_pendienteAsig'] = $estado;
			}else{
				$estado = " != 'E' ";
				unset($_SESSION['filtro_pendienteAsig']);
			}
		}	

	/* -------------------------------------------- */


	/* -------------------------------------------- */
	/* ----------------- PRODUCTO ----------------- */

		if($_SESSION['filtro_producto'] != ""){
			if($_POST['id_producto'] == ""){
				$id_producto = $_SESSION['filtro_producto'];
			}else{
				$id_producto = " = '" . $_POST['id_producto'] . "'";
				$_SESSION['filtro_producto'] = $_POST['id_producto'];
			}
			$listarProd = $operativo->listarProductosPorID($id_producto);
			array_push($_SESSION['dataFiltro'], 'Producto: ' . ucwords(strtolower($listarProd[0]['detalle_producto'])));

		}else{
			if ($_POST['id_producto'] != "") {
				$id_producto = $_POST['id_producto'];
				$listarProd = $operativo->listarProductosPorID($_POST['id_producto']);
				array_push($_SESSION['dataFiltro'], 'Producto: ' . ucwords(strtolower($listarProd[0]['detalle_producto'])));
				$_SESSION['filtro_producto'] = $_POST['id_producto'];
			}else{
				$id_producto = "";
				unset($_SESSION['filtro_producto']);
			}
		}

	/* -------------------------------------------- */

}


$listarServicios = $operativo->listarServicios($fecha, $fecha2, $id_cliente, $tipo_servicio, $emisor, $id_vehiculo, $id_conductor, $estado, $id_producto);

$html = '';

$i = 1;
foreach ($listarServicios as $ls) {
	$cliente_ID = $cliente->cliente_ID($ls['id_cliente']);
	$listarProductosPorID = $operativo->listarProductosPorID($ls['id_producto']);
	$listarUsuarioPorId = $usuario->listarUsuarioPorId($ls['id_usuario_creador']);
    $listarVehiculosPorServicioID = $operativo->listarVehiculosPorServicioID($ls['id_servicio_base']);

    /* --------------------------------------- */

    $listarContratoId = $contrato->listarId($ls['id_contrato']);
    $emp = $empresa->listarPorId($listarContratoId[0]['id_empresa']);
	$cli = $cliente->listarClientePorId($listarContratoId[0]['id_cliente']);

	$html .= '<tr>';
		$html .= '<td>' . str_pad($ls['id_servicio_base'], 5, "0", STR_PAD_LEFT) .'</td>';
		$html .= '<td>' . $ls['fecha_inicio'] . ' - ' . date('h:i A', strtotime($ls['hora_inicio'])) .'</td>';
		$html .= '<td>' . $ls['fecha_final'] . ' - ' . date('h:i A', strtotime($ls['hora_final'])) .'</td>';
		$html .= '<td>' . $ls['id_contrato'] .'</td>';
		$html .= '<td>' . $cliente_ID[0]['razon_social'] .'</td>';
		$html .= '<td>' . $emp[0]['nombre_empresa'] . ' - '. $emp[0]['nit_empresa']  .'</td>';
		$html .= '<td>' . $listarProductosPorID[0]['detalle_producto'] . ' - ' . $listarProductosPorID[0]['tipo_producto'] .'</td>';
		
		if($ls['division_cliente'] == ''){
			$html .= '<td> - </td>';
		}else{
			$html .= '<td>' . $ls['division_cliente'] .'</td>';	
		}

		if($ls['grupo'] == ''){
			$html .= '<td> - </td>';
		}else{
			$html .= '<td>' . $ls['grupo'] .'</td>';	
		}
		$html .= '<td>' . $ls['tipo_servicio'] .'</td>';
		$html .= '<td>' . $ls['solicitante'] .'</td>';
		// $html .= '<td>'  . $listarUsuarioPorId[0]['nombre'] .'</td>';
		$html .= '<td  class="d-flex justify-content-center">';
			if($consulta == 'S'){
				if ($ls['estado_servicio'] == 'PA') {
					$html .= '<div type="text" id="contEstado" style="background: #ff0000;" data-bs-toggle="tooltip" data-bs-placement="top" title="PENDIENTE POR ASIGNACIÓN" onclick="vehiculosServicios(' . $ls['id_servicio_base'] . '); "></div>';
				}else if ($ls['estado_servicio'] == 'A') {
					$html .= '<div type="text"  id="contEstado" style="background: #96f909;" data-bs-toggle="tooltip" data-bs-placement="top" title="ACTIVO"></div>';
				} else if ($ls['estado_servicio'] == 'I'){
					$html .= '<div type="text"  id="contEstado" style="background: #ffc000;" data-bs-toggle="tooltip" data-bs-placement="top" title="ANULADO"><b>A</b></div>';
				}
			}else{
				if ($ls['estado_servicio'] == 'PA') {
					$html .= '<div type="text" id="contEstado" style="background: #ff0000;" onclick="vehiculosServicios(' . $ls['id_servicio_base'] . '); "></div>';
				}else if ($ls['estado_servicio'] == 'A') {
					$html .= '<div type="text"  id="contEstado" style="background: #96f909;" onclick="vehiculosServicios(' . $ls['id_servicio_base'] . '); "></div>';
				} else if ($ls['estado_servicio'] == 'I'){
					$html .= '<div type="text"  id="contEstado" style="background: #ffc000;" onclick="vehiculosServicios(' . $ls['id_servicio_base'] . '); "><b>A</b></div>';
				}
			}
		$html .= '</td>'; 
		$html .= '<td>';

			/* ACTUALIZAR */

			if($editar == 1){
				$html .= '<a href="actualizarBaseServicio.php?id_servicio=' .$ls['id_servicio_base'] .'" class="btn btn-outline-info" style="margin: 2px; border-radius: 4px; padding: 0px 2px 0px 2px;"><i class="fa fa-edit"></i></a>';
			}else{
				$fecha1 = date("Y-m-d", strtotime($ls['fecha_creacion']));
				$fecha2 = date('Y-m-d');
				if ($fecha1 == $fecha2) {
					$html .= '<a href="actualizarBaseServicio.php?id_servicio=' .$ls['id_servicio_base'] .'" class="btn btn-outline-info" style="margin: 2px; border-radius: 4px; padding: 0px 2px 0px 2px;"><i class="fa fa-edit"></i></a>';
				}
			}
			
			/* ANULAR */
			if($anular == 'SI'){
				$html .= '<a href="cambiarEstadoBaseServicio.php?id_servicio=' .$ls['id_servicio_base'] .'" class="btn btn-outline-warning" style="margin: 2px; border-radius: 4px; padding: 0px 2px 0px 2px;"><i class="fa fa-ban"></i></a>';
			}

			/* ELIMINAR */
			if($eliminar == 1){
				$html .= '<button onclick="confirmarEliminaciónServicio(' .$ls['id_servicio_base'] .');"  class="btn btn-outline-danger" style="margin: 2px; border-radius: 4px; padding: 0px 2px 0px 2px;"><i class="fa fa-trash"></i></button>';
			}

		$html .= '</td>';
		$html .= '<td>';
			$html .= '<i data-bs-toggle="tooltip" data-bs-placement="left" title="Creado el: ' . strtoupper(date("Y-m-d g:i a", strtotime($ls['fecha_creacion']))) . ' - Por: '. $listarUsuarioPorId[0]['nombre'] .' " style="color: #6e6e6e; font-size:1rem; border-radius:50%; cursor:pointer;" class="fa fa-exclamation-circle"></i>';
			$html .= '<input onclick="serviciosReajustar(this.value);" type="checkbox" name="re_ajustar[]" id="re_ajustar'. $ls['id_servicio_base']. '" value="'. $ls['id_servicio_base']. '" data-bs-toggle="tooltip" data-bs-placement="left" title="Re-ajustar valor"/>';
		$html .= '</td>';
		
	$html .= '</tr>';
}

echo $html;

?>
