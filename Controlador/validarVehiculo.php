<?php

	include ("Sesion/autenticar.php");
	require_once '../Modelo/Vehiculo.php';
	require_once '../Modelo/Pre-operacionales.php';
	require_once '../Modelo/Usuario.php';
	require_once '../Modelo/Conductor.php';

	$vehiculo = new Vehiculo();
	$preopeacional = new PreOperacionales();
	$conductor = new Conductor();
	$usuario = new Usuario();
	

	/* ------------------------------------------------ */
	

	$hoy = date('Y-m-d');

	$id_vehiculo = $_GET['id_vehiculo'];

	$listarVehiculoId = $vehiculo->listarPorId($id_vehiculo);

	$cant = 0;

	if (($listarVehiculoId[0]['fecha_vencimiento_to'] < $hoy) || ($listarVehiculoId[0]['fecha_vencimiento_to'] == '0000-00-00')) {
		$cant = $cant + 1;
	}

	if ($listarVehiculoId[0]['fecha_vencimiento_lt'] == '0000-00-00') {
		$cant = $cant + 1;
	}

	if (($listarVehiculoId[0]['fecha_vencimiento_soat'] < $hoy) || ($listarVehiculoId[0]['fecha_vencimiento_soat'] == '0000-00-00')) {
		$cant = $cant + 1;
	}

	if (($listarVehiculoId[0]['fecha_vencimiento_rt'] < $hoy) || ($listarVehiculoId[0]['fecha_vencimiento_rt'] == '0000-00-00')) {
		$cant = $cant + 1;
	}

	if (($listarVehiculoId[0]['fecha_vencimiento_rp'] < $hoy) || ($listarVehiculoId[0]['fecha_vencimiento_rp'] == '0000-00-00')) {
		$cant = $cant + 1;
	}

	if (($listarVehiculoId[0]['fecha_vencimiento_contra'] < $hoy) || ($listarVehiculoId[0]['fecha_vencimiento_contra'] == '0000-00-00')) {
		$cant = $cant + 1;
	}

	if (($listarVehiculoId[0]['fecha_vencimiento_extra'] < $hoy) || ($listarVehiculoId[0]['fecha_vencimiento_extra'] == '0000-00-00')) {
		$cant = $cant + 1;
	}

	$dispositivo_velocidad = date('Y-m-d',strtotime($listarVehiculoId[0]['fecha_exp_disp_velocidad'] . "+ 1 year"));

	if (($dispositivo_velocidad < $hoy) || ($listarVehiculoId[0]['fecha_vencimiento_extra'] == '0000-00-00')) {
		$cant = $cant + 1;
	}

	/* ------------------------------------------------ */

	$listarUsuarioPorId = $usuario->listarUsuarioPorId($_SESSION['id_usuario']);
	$buscarConductorPorDocumento = $conductor->buscarConductorPorDocumento($listarUsuarioPorId[0]['usuario']);

	$id_conductor = $buscarConductorPorDocumento[0]['id_conductor'];
	$id_usuario = $_SESSION['id_usuario'];


	$validarPreoperacional = $preopeacional->listarPorIdVehiculoConductorYDia($id_vehiculo, $buscarConductorPorDocumento[0]['id_conductor'], $hoy);


	/* ------------------------------------------------ */

include '../Vista/Template/styles.php';

?>


<style type="text/css" media="screen">
	@import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@300&display=swap');

	body{    	
		font-family: 'Rajdhani', sans-serif;
	}	
</style>

<section class="row">
	<div class="col-5" style="width: auto; height: 5px; background-color: #335689; "></div>
	<div class="col-2" style="width: auto; height: 5px; background-color: #f7a60f; "></div>
	<div class="col-5" style="width: auto; height: 5px; background-color: #335689; "></div>
</section>
<!-- INICIO INFO-->

<div class="d-flex justify-content-center"  style="margin-top: 130px;">
	<img src="../Resources/images/gif-de-cargando-13.gif" style="width: 200px; height: 150px;">
</div>


<div class="d-flex justify-content-center">
	<p class="mt-5 text-center" style="font-size: 1.2rem;">VERIFICANDO DOCUMENTACIÓN DEL VEHICULO Y SU PREOPERACIONAL</p>
</div>
<div class="d-flex justify-content-center">
	<p class="text-center" style="font-size: 1.2rem;">DIARIO, POR FAVOR ESPERE ...</p>
</div>


<div class="d-flex justify-content-center"  style="margin-top: 100px;">
	<img src="../Resources/images/logoKV.png" style="width: 100px; height: 60px;">
</div>

<!-- FIN INFO-->


<?php include '../Vista/Template/scripts.php'; ?>

<script>

<?php if(($cant == 0) && (count($validarPreoperacional) == 0)){ ?>

 	setTimeout(function() {
        $(".fade").fadeOut(300);                     
        location.href = 'registrarPreoperacionales.php?opcion=1_' + <?php  echo $id_vehiculo ?> + '_' + <?php  echo $id_conductor ?> + '_' + <?php  echo $id_usuario ?>; 
    }, 3000);

<?php }else if(($cant == 0) && (count($validarPreoperacional) > 0)){ $_SESSION['idv'] = $id_vehiculo; ?>

 	setTimeout(function() {
        $(".fade").fadeOut(300);  
       	alert('El vehiculo actualmente tiene la documentación al dia y ya realizo su preoperacional diario.');                    
        location.href = "../Vista/inicioConductores.php"; 
    }, 3000);

<?php }else if($cant > 0){ $_SESSION['idv'] = ''; ?>

	setTimeout(function() {

        $(".fade").fadeOut(300);                     
       	alert('El vehiculo actualmente tiene documentación vencida.'); 
       	window.location.href = '../Vista/inicioConductores.php';

    }, 3000);

<?php } ?>

</script>