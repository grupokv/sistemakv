<?php
include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Pre-operacionales.php';

$preoperacionales = new PreOperacionales();

$id_preoperacional = $_POST['id_preoperacional'];

if ($_POST['lavado_manos'] == '') {
	$lavado_manos = 'NC';
}else{
	$lavado_manos = $_POST['lavado_manos'];
}

if ($_POST['tapabocas_guantes'] == '') {
	$tapabocas = 'NC';
}else{
	$tapabocas = $_POST['tapabocas_guantes'];
}


if ($_POST['desinfectante'] == '') {
	$desinfectante = 'NC';
}else{
	$desinfectante = $_POST['desinfectante'];
}

if ($_POST['bayetillas_toallas'] == '') {
	$bayetillas = 'NC';
}else{
	$bayetillas = $_POST['bayetillas_toallas'];
}

if ($_POST['escoba_trapero'] == '') {
	$escoba = 'NC';
}else{
	$escoba = $_POST['escoba_trapero'];
}

if ($_POST['alisto_toalla'] == '') {
	$alisto_toalla = 'NC';
}else{
	$alisto_toalla = $_POST['alisto_toalla'];
}

if ($_POST['balde'] == '') {
	$balde = 'NC';
}else{
	$balde = $_POST['balde'];
}

if ($_POST['bolsa'] == '') {
	$bolsa = 'NC';
}else{
	$bolsa = $_POST['bolsa'];
}

if ($_POST['productos'] == '') {
	$productos = 'NC';
}else{
	$productos = $_POST['productos'];
}

if ($_POST['tapetes'] == '') {
	$tapetes = 'NC';
}else{
	$tapetes = $_POST['tapetes'];
}

if ($_POST['volante'] == '') {
	$volante = 'NC';
}else{
	$volante = $_POST['volante'];
}

if ($_POST['zona_pasajeros'] == '') {
	$zona_pasajeros = 'NC';
}else{
	$zona_pasajeros = $_POST['zona_pasajeros'];
}

if ($_POST['zona_conductor'] == '') {
	$zona_conductor = 'NC';
}else{
	$zona_conductor = $_POST['zona_conductor'];
}

if ($_POST['piso_vehiculo'] == '') {
	$piso_vehiculo = 'NC';
}else{
	$piso_vehiculo = $_POST['piso_vehiculo'];
}

if ($_POST['aspersion'] == '') {
	$aspersion = 'NC';
}else{
	$aspersion = $_POST['aspersion'];
}

if ($_POST['disposicion'] == '') {
	$disposicion = 'NC';
}else{
	$disposicion = $_POST['disposicion'];
}

if ($_POST['bodega'] == '') {
	$bodega = 'NC';
}else{
	$bodega = $_POST['bodega'];
}

if ($_POST['hidratacion'] == '') {
	$hidratacion = 'NC';
}else{
	$hidratacion = $_POST['hidratacion'];
}

if ($_POST['disposicion'] == '') {
	$disposicion = 'NC';
}else{
	$disposicion = $_POST['disposicion'];
}

$actualizar = $preoperacionales->actualizarDesinfeccion($lavado_manos,$desinfectante,$tapabocas,$bayetillas,$escoba,$alisto_toalla,$balde,$bolsa,$productos,$tapetes,$volante,$zona_pasajeros, $zona_conductor,$piso_vehiculo,$aspersion,$disposicion,$bodega,$hidratacion,$id_preoperacional);

include '../Vista/Template/styles.php';
?>

<style type="text/css" media="screen">
	@import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');

	body{
	    background: #eeeeee;
	    font-family: 'Poppins', sans-serif;
	}

	#continuar:hover{
		background-color: #c40c0c;
		color: #fff !important;

	}

	#info{
		width: 100%;
		background: #fff;
		border-radius: 2px; 
		width: 50%;
	}

	.linea{
		border-bottom: 4px solid #fff; 
		height: 1px; 
		width: 50%;
	}

	#k{
		font-size: 1.6rem; 
		font-weight: bold;
	}

	#v{
		font-size: 1.6rem; 
		font-weight: bolder;
	}

	@media (max-width: 768px){
		.general{
			height: auto;
		}

		#info{
			width: 100%;
		}

		.linea{
			width: 100%;
		}

		#continuar{
			margin-bottom: 15px;
		}


	}

</style>

<div style="display: flex; justify-content: center; margin-top: 60px;">
	<div class="mb-2 linea" ></div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="row" id="info" style=" ">
		<section class="col-xs-12 col-sm-12 col-md-8 col-lg-8 general">
			<div class="row justify-content-center mt-4">
                <p class="ml-4 logo" id="k">KING</p>  
                <p class="ml-1 mr-3 logo" id="v">VISION</p> 
 			</div>
				<p class="text-center m-2" style="font-family: 'Raleway', sans-serif;">Se ha registrado satisfactoriamente la pre - operacional del vehiculo</p>
				<p class="text-center m-2" style="font-family: 'Raleway', sans-serif;">¡¡ Gracias por su colaboración !!</p>
           
		</section>
		<section class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="border-left: 4px solid #eee">
			<div class="mt-5">
				<?php if ($_SESSION['id_perfil'] == 3){ ?>
					
					<a href="../Vista/inicioConductores.php" type="button" class="btn btn-block" id="continuar" style="border: 1px solid #c40c0c; border-radius: 18px; color: #c40c0c;"> Finalizar </a>
				<?php } else { ?>
					<a href="../Vista/preoperacionales.php" type="button" class="btn btn-block" id="continuar" style="border: 1px solid #c40c0c; border-radius: 18px; color: #c40c0c;"> Finalizar </a>
				<?php } ?>
			</div>
		</section>
	</div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="mt-2 linea"></div>
</div>

<?php include '../Vista/Template/scripts.php'; ?>