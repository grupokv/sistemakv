<?php  

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Operativo.php';
require_once("../Modelo/TipoVehiculo.php");

$tipoVehiculo = new TipoVehiculo();
$operativo = new Operativo();

$id_producto = $_POST['id_producto'];
$id_cliente = $_POST['id_cliente'];
$detalle_producto = strtoupper($_POST['detalle_producto']);
$tipo_producto = $_POST['tipo_producto'];
$dias_aplicados_mensualidad = $_POST['dias_aplicados_mensualidad'];
$dia_corte = $_POST['dia_corte'];
$observaciones = strtoupper($_POST['observaciones']);

$actualizarProductoCliente = $operativo->actualizarProductoCliente($id_producto, $id_cliente, $detalle_producto, $tipo_producto, $dias_aplicados_mensualidad, $dia_corte, $observaciones);

/*ELIMINAR TARIFAS ACTUALES */

$eliminarTarifasProductos = $operativo->eliminarTarifasProductos($id_producto);

/* REGISTRO TARIFAS DEL PRODUCTO */
$listarClasesMovilPorIdCliente = $operativo->listarClasesMovilPorIdCliente($id_cliente);

foreach ($listarClasesMovilPorIdCliente as $ltv) {

	$id_tipo_vehiculo = $ltv['id'];

	if (isset($_POST['id_tipo_vehiculo'])){
		for ($i=0; $i < count($_POST['id_tipo_vehiculo']) ; $i++) {
			if ($_POST['id_tipo_vehiculo'][$i] == $ltv['id']) {

				/* ---------- VALOR REQUERIDO ----------*/
					$v_r_cliente = $_POST['vr_cliente_' . strtolower($ltv['id'])];
					$v_r_movil = $_POST['vr_movil_' . strtolower($ltv['id'])];

					if (($v_r_cliente != '') || ($v_r_movil != '')) {
						$valor_recorrido = array('cliente' => $v_r_cliente, 'movil' => $v_r_movil);
						$valor_recorrido_json = json_encode($valor_recorrido);
					}else{
						$valor_recorrido_json = NULL;
					}

				/* ---------- VALOR HORA ----------*/
					$vh_cliente = $_POST['vh_cliente_' . strtolower($ltv['id'])];
					$vh_movil = $_POST['vh_movil_' . strtolower($ltv['id'])];

					if (($vh_cliente != '') || ($vh_movil != '')) {
						$valor_hora = array('cliente' => $vh_cliente, 'movil' => $vh_movil);
						$valor_hora_json = json_encode($valor_hora);
					}else{
						$valor_hora_json = NULL;
					}

				/* ---------- RECORRIDOS POR HORA ----------*/
					$rxd_cliente = $_POST['rxd_cliente_' . strtolower($ltv['id'])];
					$rxd_movil = $_POST['rxd_movil_' . strtolower($ltv['id'])];

					if (($rxd_cliente != '') || ($rxd_movil != '')) {
						$recorridos_x_dia = array('cliente' => $rxd_cliente, 'movil' => $rxd_movil);
						$recorridos_x_dia_json = json_encode($recorridos_x_dia);
					}else{
						$recorridos_x_dia_json = NULL;
					}

				/* ---------- VALOR MENSUAL ----------*/
					$vm_cliente = $_POST['vm_cliente_' . strtolower($ltv['id'])];
					$vm_movil = $_POST['vm_movil_' . strtolower($ltv['id'])];

					if (($vm_cliente != '') || ($vm_movil != '')) {
						$valor_mensual = array('cliente' => $vm_cliente, 'movil' => $vm_movil);
						$valor_mensual_json = json_encode($valor_mensual);
					}else{
						$valor_mensual_json = NULL;
					}

				/* ---------- VALOR RELEVO SENCILLO ----------*/
					$vrsxr_cliente = $_POST['vrsxr_cliente_' . strtolower($ltv['id'])];
					$vrsxr_movil = $_POST['vrsxr_movil_' . strtolower($ltv['id'])];

					if (($vrsxr_cliente != '') || ($vrsxr_movil != '')) {
						$valor_relevo_sencillo = array('cliente' => $vrsxr_cliente, 'movil' => $vrsxr_movil);
						$valor_relevo_sencillo_json = json_encode($valor_relevo_sencillo);
					}else{
						$valor_relevo_sencillo_json = NULL;
					}

				/* ---------- VALOR RELEVO DOBLE ----------*/
					$vrdxr_cliente = $_POST['vrdxr_cliente_' . strtolower($ltv['id'])];
					$vrdxr_movil = $_POST['vrdxr_movil_' . strtolower($ltv['id'])];

					if (($vrdxr_cliente != '') || ($vrdxr_movil != '')) {
						$valor_relevo_doble = array('cliente' => $vrdxr_cliente, 'movil' => $vrdxr_movil);
						$valor_relevo_doble_json = json_encode($valor_relevo_doble);
					}else{
						$valor_relevo_doble_json = NULL;
					}

				/* ---------- COSTO POR DISPONIBILIDAD ----------*/
					$cpd_cliente = $_POST['cpd_cliente_' . strtolower($ltv['id'])];
					$cpd_movil = $_POST['cpd_movil_' . strtolower($ltv['id'])];

					if (($cpd_cliente != '') || ($cpd_movil != '')) {
						$costo_por_disponibilidad = array('cliente' => $cpd_cliente, 'movil' => $cpd_movil);
						$costo_disponibilidad_json = json_encode($costo_por_disponibilidad);
					}else{
						$costo_disponibilidad_json = NULL;
					}


				$registrarTarifasProductoCliente = $operativo->registrarTarifasProductoCliente($id_tipo_vehiculo, $id_producto, $id_cliente, $valor_recorrido_json, $valor_hora_json, $recorridos_x_dia_json, $valor_mensual_json, $valor_relevo_sencillo_json, $valor_relevo_doble_json, $costo_disponibilidad_json);

			}
		}
	}
	
}

echo "<script>alert('Se ha actualizado correctamente la información.'); window.location.href = '../Vista/actualizarProductoCliente.php?id_producto=" . $id_producto . "';</script>";

?>
