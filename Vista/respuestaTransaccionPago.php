<?php 

session_start();

include ("Sesion/autenticar.php");
require_once '../Modelo/BitacoraTransaccion.php';
require_once ("../Modelo/ConceptosCobro.php");
require_once ("../Modelo/Cartera.php");
require_once ("../Modelo/contratoOcasional.php");
require_once ("../Modelo/Fuec.php");
require_once ("../Modelo/Vehiculo.php");

date_default_timezone_set('America/Bogota');
$referencia = $_GET['ref'];

$vehiculo = new Vehiculo();
$cartera = new Cartera();
$concepto = new ConceptoCobro();
$bitacoraTransaccion = new Transacciones();
$fuec = new Fuec();
$contratoOcasional = new ContratoOcasional();


$listarTransaccionReferencia = $bitacoraTransaccion->listarTransaccionReferencia($referencia);
$dataTransaccion = json_decode(utf8_decode($listarTransaccionReferencia[0]['data']));
$info = explode(" - ", $dataTransaccion->{'payment'}->{'description'});
$placa = $info[1];

$listarVehiculoPorPlaca = $vehiculo->listarPorPlaca($placa);

/* CREACION DE NONCE*/

if (function_exists('random_bytes')) {
    $nonce = bin2hex(random_bytes(16));
} elseif (function_exists('openssl_random_pseudo_bytes')) {
    $nonce = bin2hex(openssl_random_pseudo_bytes(16));
} else {
    $nonce = mt_rand();
}

$nonceBase64 = base64_encode($nonce);

/* CREACION DE SEED*/
$seed = date('c'); //Fecha actual en formato ISO 8601

/* --------- ORT ------------*/
if (($listarVehiculoPorPlaca[0]['numero_movil'] >= 1)&&($listarVehiculoPorPlaca[0]['numero_movil'] <= 999)){ 
    
    $secretKey = '2Rv38c8x4vS5eKrT';

    /*LOGIN*/
    $login = '100f9ea2a9f5d25f80f3141bfcde9e0a';

/*------------ LINEAS PREMIUM ------------*/
} else if (($listarVehiculoPorPlaca[0]['numero_movil'] >= 1000)&&($listarVehiculoPorPlaca[0]['numero_movil'] <= 1999)){ 
    
    $secretKey = '3xjqwHIo7eZyydi2';
    
    /*LOGIN*/
    $login = '31164be2fab23d6c934d8b69d9b1cc59';
}

/* CREACION DE TRANKEY*/

$tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

$data = [
	'auth' => [
     	'login' => $login,
        'seed' => $seed,
        'nonce' => $nonceBase64,
        'tranKey' => $tranKey
    ]
];

$dataJSON = json_encode($data);

$urlAPIRedirection = 'https://checkout.placetopay.com/api/session/'. $listarTransaccionReferencia[0]['requestID'];
$ch = curl_init($urlAPIRedirection);

curl_setopt_array($ch, array(
    // Indicar que vamos a hacer una petición POST
    CURLOPT_CUSTOMREQUEST => "POST",
    // Justo aquí ponemos los datos dentro del cuerpo
    CURLOPT_POSTFIELDS => $dataJSON,
    // Encabezados
    //CURLOPT_HEADER => true,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($dataJSON), // Abajo podríamos agregar más encabezados
    ),
    # indicar que regrese los datos, no que los imprima directamente
    CURLOPT_RETURNTRANSFER => true,
));


$result = curl_exec($ch);
$resultado = json_decode($result);

$estado = $resultado->{'status'}->{'status'};
$valorTotalTransaccion = $resultado->{'request'}->{'payment'}->{'amount'}->{'total'};
$num_id_comprobante = date('YmdHis');
$fecha_registro_comprobante = date('Y-m-d H:i:s');
$usuario_registro = $listarTransaccionReferencia[0]['id_usuario'];


/* ---------------------------------------- */
/* ----------ACTUALIZACIÓN DATOS----------- */
/* ---------------------------------------- */

$actualizarTransaccion = $bitacoraTransaccion->actualizarTransaccion($fecha_registro_comprobante, $estado, $result, $listarTransaccionReferencia[0]['requestID']);

$generalInfo = json_decode(utf8_decode($listarTransaccionReferencia[0]['extraGeneralInfo']));


/*--------------------------------------------*/
//------------- MODULO 1 = CARTERA ------------
/*--------------------------------------------*/
// MODULO 2 = EXTRACTOS - CONTRATOS OCASIONALES
/*--------------------------------------------*/
//--------- MODULO 3 = EXTRACTOS FIJOS---------
/*--------------------------------------------*/
//--------- MODULO 4 = PAQUETES PLUS ----------
/*--------------------------------------------*/
//--------- MODULO 5 = CARTERA AVALES ----------
/*--------------------------------------------*/


if($generalInfo->{'modulo'} == 1){
	if ($resultado->{'status'}->{'status'} == 'APPROVED') {

		$id_cobros = $generalInfo->{'registroID'};
		$listarCobrosPropietarioID = $concepto->listarCobrosPropietarioID($id_cobros);
		print_r($listarCobrosPropietarioID);

		foreach ($listarCobrosPropietarioID as $lcpi) {
			
			$id_cobro = $lcpi['id_cobro'];
			$valor_cobro = $lcpi['valor'];
			$fecha_cobro = $lcpi['fecha_cobro'];

			/*REGISTRAR COMPROBANTE DE PAGO PARA LA TRANSACCION*/
        	$registrarComprobantePagoPropietario = $concepto->registrarComprobanteTransaccion($id_cobro, $valor_cobro, $fecha_cobro, $valorTotalTransaccion, $num_id_comprobante, $referencia, $fecha_registro_comprobante, $usuario_registro, $fecha_registro_comprobante);

			/*ACTUALIZAR ESTADO DE COBRO DEL PROPIETARIO PENDIENTE A SALDADO*/
	        $estadoCobroProp = "S";
	        $actualizarEstadoCobroPropietario = $concepto->actualizarEstadoCobroPropietario($estadoCobroProp, $id_cobro);

		}

    	$extraGeneralInfo = [
    		"modulo" => $generalInfo->{'modulo'},
    		"registroID" => $generalInfo->{'registroID'},
    		"num_id_comprobante" => $num_id_comprobante,
    	];

    	$extraGeneralInfo = json_encode($extraGeneralInfo);

    	$actualizarExtraGeneralInfoTransaccion = $bitacoraTransaccion->actualizarExtraGeneralInfoTransaccion($extraGeneralInfo, $referencia);

	}

} else if($generalInfo->{'modulo'} == 2){
	
	$id_fuec_ocasional = $generalInfo->{'registroID'};
	$listarFuecPorId = $fuec->listarFuecPorId($id_fuec_ocasional);

	if ($resultado->{'status'}->{'status'} == 'APPROVED') {

		$estado = 'F';
		$actualizarEstadoFuec = $contratoOcasional->actualizarEstadoFuecOcasional($id_fuec_ocasional, $estado);

		$actualizarEstadoContratoOCasional = $contratoOcasional->actualizarEstadoContratoOcasional($listarFuecPorId[0]['id_contrato_ocasional'], $estado);
	}

} else if($generalInfo->{'modulo'} == 3){
		

	if ($resultado->{'status'}->{'status'} == 'APPROVED') {
		
		$avales = $generalInfo->{'registroID'};
		$consultarAvalIDs = $cartera->consultarAvalIDs($avales);

		foreach ($consultarAvalIDs as $caids) {
			$actualizarEstadoAvales = $cartera->actualizarEstadoAvales($caids['id_aval']);
		}
	}

} else if($generalInfo->{'modulo'} == 4){
	if ($resultado->{'status'}->{'status'} == 'APPROVED') {
	    
	    $id_transaccion = $listarTransaccionReferencia[0]['id_transaccion'];
	    $fecha_inicial = date('Y-m-d');
	    $fecha_final = date("Y-m-d",strtotime($fecha_inicial."+ 1 month")); 
	    $id_vehiculo = $listarVehiculoPorPlaca[0]['id_vehiculo'];
	    $estado = 'ACTIVO'; 
	    $id_usuario = $_SESSION['id_usuario']; 
	    
	    $registrarPaquetePlusVehiculo = $bitacoraTransaccion->registrarPaquetePlusVehiculo($id_vehiculo, $id_transaccion, $id_usuario, $fecha_inicial , $fecha_final, $estado);
	    
    	$extraGeneralInfo = [
    		"modulo" => $generalInfo->{'modulo'},
    		"registroID" => $registrarPaquetePlusVehiculo,
    	];

    	$extraGeneralInfo = json_encode($extraGeneralInfo);
	    
    	$actualizarExtraGeneralInfoTransaccion = $bitacoraTransaccion->actualizarExtraGeneralInfoTransaccion($extraGeneralInfo, $referencia);
	}

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Resultado Transacción</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<?php include("Template/styles.php"); ?>

	<style>	
	    @media (max-width: 760px){
  
	        #titleMessageTransaction{
	        	border: 0px !important;
	        }

	    }
	

	</style>	

</head>
<body>

	<section class="row d-flex justify-content-center">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 text-center p-2 mt-3" id="titleMessageTransaction" style="border-bottom: 2px solid #d3d3d3;">

			<?php if ($resultado->{'status'}->{'status'} == 'APPROVED'){ ?>

				<i class="fa fa-check-circle-o" style="font-size: 5.2rem; color: #29a825;"></i>
				<h4 style="color: #29a825;"><strong><?php echo strtr(strtoupper($resultado->{'status'}->{'message'}), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"); ?></strong></h4>

			<?php } else if ($resultado->{'status'}->{'status'} == 'PENDING'){ ?>

				<i class="fa fa-clock-o" style="font-size: 5.2rem; color: aquamarine;"></i>
				<h4 style="color: aquamarine;"><strong><?php echo strtr(strtoupper($resultado->{'status'}->{'message'}), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"); ?></strong></h4>

			<?php } else { ?>

				<i class="fa fa-times-circle-o" style="font-size: 5.2rem; color: #db4f4f;"></i>
				<h4 style="color: #db4f4f;"><strong><?php echo strtr(strtoupper($resultado->{'status'}->{'message'}), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"); ?></strong></h4>
				
			<?php } ?>

		</div>
	</section>
	<!-- <section class="row d-flex justify-content-center mt-1">
	    <div id="barraInferiorTitulo" class="col-xs-6 col-sm-6 col-md-4 col-lg-4" style="background: #f9b434; width: 100%; height: 3px;"></div>
	    <div id="barraInferiorTitulo" class="col-xs-6 col-sm-6 col-md-4 col-lg-4" style="background: #4c81a8; width: 100%; height: 3px;"></div>
	</section> -->
	<section class="row d-flex justify-content-center">
		<div class="col-xs-11 col-sm-11 col-md-4 col-lg-4 text-center p-2 mr-1 mt-2" style="border: 2px solid #ebebeb;">
			<div class="col-12 ">
				<label><strong>TOTAL A PAGAR</strong></label>
			</div>
			<div class="col-12 text-center">
				<p style="font-size: 1.7rem;"><strong>$ <?php echo number_format($resultado->{'request'}->{'payment'}->{'amount'}->{'total'}); ?></strong></p>
				<cite>COP: Pesos Colombianos</cite>
			</div>
			<div class="col-12 text-center mt-4 p-1" style="background: #fafafa; border: 2px solid #ebebeb;">
                <label style="color: #1b2d3b;"><strong>REFERENCIA: </strong></label>
                <input type="text" class="form-control" name="referencia" value="<?php echo $resultado->{'request'}->{'payment'}->{'reference'}?>" readonly style="border-style: dashed; background: #ffffff; text-align: center; font-size: .9rem;">
            </div>

            <div class="col-12 text-center mt-1 p-1">
                <label style="color: #1b2d3b;"><strong>DESCRIPCIÓN: </strong></label>
                <textarea class="form-control" name="descripcion" value="" readonly style="border-style: dashed; background: #ffffff; text-align: center; font-size: .9rem;"><?php echo $resultado->{'request'}->{'payment'}->{'description'}?></textarea> 
            </div>

		</div>

		<div class="col-xs-11 col-sm-11 col-md-4 col-lg-4 text-center p-2 ml-1 mt-2" style="border: 2px solid #ebebeb;">
			
			<div class="col-12 ">
				<label><strong>INFORMACIÓN GENERAL</strong></label>
			</div>

			<div class="col-12 text-center mt-4 p-1" style="background: #fafafa; border: 2px solid #ebebeb;">
                <!-- <label style="color: #1b2d3b;"><i class="fa fa-cc-visa" style="color: #0061b2; font-size: 2.2rem;"></i></label> -->
                <label><strong style="color: #1b2d3b;">Fecha transacción: </strong> <?php echo date('Y-m-d H:i:s'); ?></label>
                
            </div>


			<div class="col-12 text-center mt-4 p-1" style="background: #fafafa; border: 2px solid #ebebeb;">
                <label style="color: #1b2d3b;"><strong>SESIÓN: </strong></label>
                <input type="text" class="form-control" name="requestID" value="<?php echo $resultado->{'requestId'} ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center; font-size: .9rem;">
            </div>

		</div>


	</section>
	<section class="row d-flex justify-content-center mt-4 mb-5">
			<a class="btn btn-outline-danger col-4  btn-block" href="../Vista/pagos_pendientes_propietario.php" >Finalizar</a>
	</section>

    <?php include("Template/scripts.php"); ?>
</body>
</html>