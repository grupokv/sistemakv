<?php
include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Pre-operacionales.php';

$preoperacionales = new PreOperacionales();

$id_preoperacional = $_POST['id_preoperacional'];

/* ----------------------------------------- */
/* ----------- EQUIPO DE SEGURIDAD --------- */
/* ----------------------------------------- */

if ($_POST['botiquin'] == '') {
	$botiquin = 'NC';
}else{
	$botiquin = $_POST['botiquin'];
}

if ($_POST['extintor_cargado'] == '') {
	$extintor_cargado = 'NC';
}else{
	$extintor_cargado = $_POST['extintor_cargado'];
}

if ($_POST['gato'] == '') {
	$gato = 'NC';
}else{
	$gato = $_POST['gato'];
}

if ($_POST['cruceta_copa'] == '') {
	$cruceta_copa = 'NC';
}else{
	$cruceta_copa = $_POST['cruceta_copa'];
}

if ($_POST['triangulos'] == '') {
	$triangulos = 'NC';
}else{
	$triangulos = $_POST['triangulos'];
}

if ($_POST['tacos_cunias'] == '') {
	$tacos_cunias = 'NC';
}else{
	$tacos_cunias = $_POST['tacos_cunias'];
}

if ($_POST['llanta_repuesto'] == '') {
	$llanta_repuesto = 'NC';
}else{
	$llanta_repuesto = $_POST['llanta_repuesto'];
}

if ($_POST['herramientas'] == '') {
	$herramientas = 'NC';
}else{
	$herramientas = $_POST['herramientas'];
}

if ($_POST['chaleco_refractivo'] == '') {
	$chaleco_refractivo = 'NC';
}else{
	$chaleco_refractivo = $_POST['chaleco_refractivo'];
}

if ($_POST['aviso_conduzco'] == '') {
	$aviso_conduzco = 'NC';
}else{
	$aviso_conduzco = $_POST['aviso_conduzco'];
}


/* ----------------------------------------- */
/* ------------- ESTADO GENERAL ------------ */
/* ----------------------------------------- */


if ($_POST['nivel_liquido'] == '') {
	$nivel_liquido = 'NC';
}else{
	$nivel_liquido = $_POST['nivel_liquido'];
}

if ($_POST['nivel_aceite'] == '') {
	$nivel_aceite = 'NC';
}else{
	$nivel_aceite = $_POST['nivel_aceite'];
}

if ($_POST['fuga_aceite'] == '') {
	$fuga_aceite = 'NC';
}else{
	$fuga_aceite = $_POST['fuga_aceite'];
}

if ($_POST['estado_filtro_combustible'] == '') {
	$estado_filtro_combustible = 'NC';
}else{
	$estado_filtro_combustible = $_POST['estado_filtro_combustible'];
}

if ($_POST['cierre_puertas_ventanas'] == '') {
	$cierre_puertas_ventanas = 'NC';
}else{
	$cierre_puertas_ventanas = $_POST['cierre_puertas_ventanas'];
}

if ($_POST['seguro_puertas'] == '') {
	$seguro_puertas = 'NC';
}else{
	$seguro_puertas = $_POST['seguro_puertas'];
}

if ($_POST['cinturones_seguridad'] == '') {
	$cinturones_seguridad = 'NC';
}else{
	$cinturones_seguridad = $_POST['cinturones_seguridad'];
}

if ($_POST['control_fugas'] == '') {
	$control_fugas = 'NC';
}else{
	$control_fugas = $_POST['control_fugas'];
}

if ($_POST['estado_cojineria'] == '') {
	$estado_cojineria = 'NC';
}else{
	$estado_cojineria = $_POST['estado_cojineria'];
}

if ($_POST['fijacion_asientos'] == '') {
	$fijacion_asientos = 'NC';
}else{
	$fijacion_asientos = $_POST['fijacion_asientos'];
}

if ($_POST['ajuste_silla_conductor'] == '') {
	$ajuste_silla_conductor = 'NC';
}else{
	$ajuste_silla_conductor = $_POST['ajuste_silla_conductor'];
}

if ($_POST['estado_retrovisores'] == '') {
	$estado_retrovisores = 'NC';
}else{
	$estado_retrovisores = $_POST['estado_retrovisores'];
}

if ($_POST['pisos_cabina'] == '') {
	$pisos_cabina = 'NC';
}else{
	$pisos_cabina = $_POST['pisos_cabina'];
}

if ($_POST['llanta_trasera_izq'] == '') {
	$llanta_trasera_izq = 'NC';
}else{
	$llanta_trasera_izq = $_POST['llanta_trasera_izq'];
}

if ($_POST['llanta_trasera_der'] == '') {
	$llanta_trasera_der = 'NC';
}else{
	$llanta_trasera_der = $_POST['llanta_trasera_der'];
}

if ($_POST['llanta_delantera_izq'] == '') {
	$llanta_delantera_izq = 'NC';
}else{
	$llanta_delantera_izq = $_POST['llanta_delantera_izq'];
}

if ($_POST['llanta_delantera_der'] == '') {
	$llanta_delantera_der = 'NC';
}else{
	$llanta_delantera_der = $_POST['llanta_delantera_der'];
}

if ($_POST['estado_latoneria'] == '') {
	$estado_latoneria = 'NC';
}else{
	$estado_latoneria = $_POST['estado_latoneria'];
}

if ($_POST['pito'] == '') {
	$pito = 'NC';
}else{
	$pito = $_POST['pito'];
}

if ($_POST['aire_acondicionado'] == '') {
	$aire_acondicionado = 'NC';
}else{
	$aire_acondicionado = $_POST['aire_acondicionado'];
}

if ($_POST['apoya_cabezas'] == '') {
	$apoya_cabezas = 'NC';
}else{
	$apoya_cabezas = $_POST['apoya_cabezas'];
}

if ($_POST['alarma_retroceso'] == '') {
	$alarma_retroceso = 'NC';
}else{
	$alarma_retroceso = $_POST['alarma_retroceso'];
}



/* --------------------------------- */
/* ------------- FRENOS ------------ */
/* --------------------------------- */



if ($_POST['freno_parqueo'] == '') {
	$freno_parqueo = 'NC';
}else{
	$freno_parqueo = $_POST['freno_parqueo'];
}

if ($_POST['lvl_liquido_freno'] == '') {
	$lvl_liquido_freno = 'NC';
}else{
	$lvl_liquido_freno = $_POST['lvl_liquido_freno'];
}


/* ------------------------------------------------------------- */
/* ------------- INSTRUMENTO DE CONTROL Y SEGURIDAD ------------ */
/* ------------------------------------------------------------- */


if ($_POST['limpia_brisas'] == '') {
	$limpia_brisas = 'NC';
}else{
	$limpia_brisas = $_POST['limpia_brisas'];
}

if ($_POST['parabrisas'] == '') {
	$parabrisas = 'NC';
}else{
	$parabrisas = $_POST['parabrisas'];
}

if ($_POST['sistema_parabrisas'] == '') {
	$sistema_parabrisas = 'NC';
}else{
	$sistema_parabrisas = $_POST['sistema_parabrisas'];
}

if ($_POST['estado_vidrio_trasero'] == '') {
	$estado_vidrio_trasero = 'NC';
}else{
	$estado_vidrio_trasero = $_POST['estado_vidrio_trasero'];
}

if ($_POST['indicadores'] == '') {
	$indicadores = 'NC';
}else{
	$indicadores = $_POST['indicadores'];
}

if ($_POST['indicadores_luces_altas'] == '') {
	$indicadores_luces_altas = 'NC';
}else{
	$indicadores_luces_altas = $_POST['indicadores_luces_altas'];
}

if ($_POST['indicador_luces_parqueo'] == '') {
	$indicador_luces_parqueo = 'NC';
}else{
	$indicador_luces_parqueo = $_POST['indicador_luces_parqueo'];
}

if ($_POST['indicador_lvl_gasolina'] == '') {
	$indicador_lvl_gasolina = 'NC';
}else{
	$indicador_lvl_gasolina = $_POST['indicador_lvl_gasolina'];
}


/* ---------------------------------------- */
/* ------------- CONTAMINANTES ------------ */
/* ---------------------------------------- */


if ($_POST['sistema_escape'] == '') {
	$sistema_escape = 'NC';
}else{
	$sistema_escape = $_POST['sistema_escape'];
}

if ($_POST['emanacion_gases'] == '') {
	$emanacion_gases = 'NC';
}else{
	$emanacion_gases = $_POST['emanacion_gases'];
}


/* ---------------------------------------- */
/* ------------- CONTAMINANTES ------------ */
/* ---------------------------------------- */



if ($_POST['luces_posicion_delantera'] == '') {
	$luces_posicion_delantera = 'NC';
}else{
	$luces_posicion_delantera = $_POST['luces_posicion_delantera'];
}

if ($_POST['luces_posicion_trasera'] == '') {
	$luces_posicion_trasera = 'NC';
}else{
	$luces_posicion_trasera = $_POST['luces_posicion_trasera'];
}

if ($_POST['luces_freno'] == '') {
	$luces_freno = 'NC';
}else{
	$luces_freno = $_POST['luces_freno'];
}

if ($_POST['direccionales'] == '') {
	$direccionales = 'NC';
}else{
	$direccionales = $_POST['direccionales'];
}

if ($_POST['luces_emergencia'] == '') {
	$luces_emergencia = 'NC';
}else{
	$luces_emergencia = $_POST['luces_emergencia'];
}

if ($_POST['luces_retroceso'] == '') {
	$luces_retroceso = 'NC';
}else{
	$luces_retroceso = $_POST['luces_retroceso'];
}

if ($_POST['luz_placa'] == '') {
	$luz_placa = 'NC';
}else{
	$luz_placa = $_POST['luz_placa'];
}

if ($_POST['luces_bajas'] == '') {
	$luces_bajas = 'NC';
}else{
	$luces_bajas = $_POST['luces_bajas'];
}

if ($_POST['luces_altas'] == '') {
	$luces_altas = 'NC';
}else{
	$luces_altas = $_POST['luces_altas'];
}

if ($_POST['luces_interiores'] == '') {
	$luces_interiores = 'NC';
}else{
	$luces_interiores = $_POST['luces_interiores'];
}

if ($_POST['luces_tablero'] == '') {
	$luces_tablero = 'NC';
}else{
	$luces_tablero = $_POST['luces_tablero'];
}

if ($_POST['sistema_electrico_aislado'] == '') {
	$sistema_electrico_aislado = 'NC';
}else{
	$sistema_electrico_aislado = $_POST['sistema_electrico_aislado'];
}

$actualizar = $preoperacionales->actualizarProperacionalContratoGEB($id_preoperacional, $botiquin, $extintor_cargado, $gato, $cruceta_copa, $triangulos, $tacos_cunias, $llanta_repuesto, $herramientas, $chaleco_refractivo, $aviso_conduzco, $nivel_liquido, $nivel_aceite, $fuga_aceite, $estado_filtro_combustible, $sistema_embrague, $cierre_puertas_ventanas, $seguro_puertas, $cinturones_seguridad, $control_fugas, $estado_cojineria, $fijacion_asientos, $ajuste_silla_conductor, $estado_retrovisores, $pisos_cabina, $llanta_trasera_izq, $llanta_trasera_der, $llanta_delantera_izq, $llanta_delantera_der, $estado_latoneria, $pito, $aire_acondicionado, $apoya_cabezas, $alarma_retroceso, $freno_parqueo, $lvl_liquido_freno, $limpia_brisas, $parabrisas, $sistema_parabrisas, $estado_vidrio_trasero, $indicadores, $indicadores_luces_altas, $indicador_luces_parqueo, $indicador_lvl_gasolina, $sistema_escape, $emanacion_gases, $luces_posicion_delantera, $luces_posicion_trasera, $luces_freno, $direccionales, $luces_emergencia, $luces_retroceso, $luz_placa, $luces_bajas, $luces_altas, $luces_interiores, $luces_tablero, $sistema_electrico_aislado);

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