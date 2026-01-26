<?php 

require_once ("../Modelo/contratoOcasional.php");
require_once ("../Modelo/BitacoraTransaccion.php");
require_once ("../Modelo/ConceptosCobro.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/Cartera.php");
require_once ("../Modelo/Fuec.php");

$contratoOcasional = new ContratoOcasional();
$bitacoraTransaccion = new Transacciones();
$concepto = new ConceptoCobro();
$vehiculo = new Vehiculo();
$cartera = new Cartera();
$fuec = new Fuec();

$data = file_get_contents('php://input');
$dataPOST = json_decode(utf8_decode($data));

$requestID = $dataPOST->{'requestId'};
$reference = $dataPOST->{'reference'};

$listarTransaccionReferencia = $bitacoraTransaccion->listarTransaccionReferencia($reference);
$dataTransaccion = json_decode(utf8_decode($listarTransaccionReferencia[0]['data']));
$info = explode(" - ", $dataTransaccion->{'payment'}->{'description'});
$placa = $info[1];

$listarVehiculoPorPlaca = $vehiculo->listarPorPlaca($placa);


/*CREACIÓN DE AUTENTICACIÓN TRANSACCION CREATE REQUEST*/

if (function_exists('random_bytes')) {
    $nonce = bin2hex(random_bytes(16));
} elseif (function_exists('openssl_random_pseudo_bytes')) {
    $nonce = bin2hex(openssl_random_pseudo_bytes(16));
} else {
    $nonce = mt_rand();
}

$nonceBase64 = base64_encode($nonce);

/* CREACION DE SEED */
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


/* --------- --- ------------*/

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

/*CURL ENVIO POST DATA*/

$urlAPIRedirection = 'https://checkout.placetopay.com/redirection/api/session/'. $requestID;
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

$listarTransaccionReferencia = $bitacoraTransaccion->listarTransaccionReferencia($reference);
$dataTransaccion = json_decode(utf8_decode($listarTransaccionReferencia[0]['data']));
$info = explode(" - ", $dataTransaccion->{'payment'}->{'description'});
$placa = $info[1];

$listarVehiculoPorPlaca = $vehiculo->listarPorPlaca($placa);
//print_r($listarTransaccionReferencia);

$estado = $resultado->{'status'}->{'status'};
$valorTotalTransaccion = $resultado->{'request'}->{'payment'}->{'amount'}->{'total'};
$num_id_comprobante = date('YmdHis');
$fecha_registro_comprobante = date('Y-m-d H:i:s');
$usuario_registro = $listarTransaccionReferencia[0]['id_usuario'];

if ($estado != $listarTransaccionReferencia[0]['estado']) {

	$actualizarTransaccion = $bitacoraTransaccion->actualizarTransaccion($fecha_registro_comprobante, $estado, $result, $requestID);

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

	if($generalInfo->{'modulo'} === 1){

		if ($estado === 'APPROVED') {

			$id_cobros = $generalInfo->{'registroID'};
			$listarCobrosPropietarioID = $concepto->listarCobrosPropietarioID($id_cobros);

			foreach ($listarCobrosPropietarioID as $lcpi) {
				
				$id_cobro = $lcpi['id_cobro'];
				$valor_cobro = $lcpi['valor'];
				$fecha_cobro = $lcpi['fecha_cobro'];

				/*REGISTRAR COMPROBANTE DE PAGO PARA LA TRANSACCION*/
	        	$registrarComprobantePagoPropietario = $concepto->registrarComprobanteTransaccion($id_cobro, $valor_cobro, $fecha_cobro, $valorTotalTransaccion, $num_id_comprobante, $reference, $fecha_registro_comprobante, $usuario_registro, $fecha_registro_comprobante);

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

	    	$actualizarExtraGeneralInfoTransaccion = $bitacoraTransaccion->actualizarExtraGeneralInfoTransaccion($extraGeneralInfo, $reference);
	    }

	} else if($generalInfo->{'modulo'} == 2){

		if ($estado === 'APPROVED') {

				$id_fuec_ocasional = $generalInfo->{'registroID'};
				$listarFuecPorId = $fuec->listarFuecPorId($id_fuec_ocasional);


				$estado = 'F';

				/*ACTUALIZAR ESTADO EXTRACTO*/
				$actualizarEstadoFuec = $contratoOcasional->actualizarEstadoFuecOcasional($id_fuec_ocasional, $estado);

				/*ACTUALIZAR ESTADO CONTRATO OCASIONAL*/
				$actualizarEstadoContratoOCasional = $contratoOcasional->actualizarEstadoContratoOcasional($listarFuecPorId[0]['id_contrato_ocasional'], $estado);
		}
			
	} else if($generalInfo->{'modulo'} == 4){
			   
			if ($estado === 'APPROVED') {

				$id_transaccion = $listarTransaccionReferencia[0]['id_transaccion'];
			    $fecha_inicial = date('Y-m-d');
			    $fecha_final = date("Y-m-d",strtotime($fecha_inicial."+ 1 month")); 
			    $id_vehiculo = $listarVehiculoPorPlaca[0]['id_vehiculo'];
			    $estado = 'ACTIVO'; 
			    $id_usuario = $listarTransaccionReferencia[0]['id_usuario']; 

			    /*REGISTRO DE PAQUETE PLUS AL VEHICULO*/

			    $registrarPaquetePlusVehiculo = $bitacoraTransaccion->registrarPaquetePlusVehiculo($id_vehiculo, $id_transaccion, $id_usuario, $fecha_inicial , $fecha_final, $estado);
			    
		    	$extraGeneralInfo = [
		    		"modulo" => $generalInfo->{'modulo'},
		    		"registroID" => $registrarPaquetePlusVehiculo,
		    	];

		    	$extraGeneralInfo = json_encode($extraGeneralInfo);
			    
			    /*ACTUALIZACIÓN DE LA BITACORA TRANSACCIONAL*/
		    	$actualizarExtraGeneralInfoTransaccion = $bitacoraTransaccion->actualizarExtraGeneralInfoTransaccion($extraGeneralInfo, $reference);
			}
	}
}


?>