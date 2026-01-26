<?php 
include ("Sesion/autenticar.php");
require_once '../Modelo/General.php';
require_once '../Modelo/BitacoraTransaccion.php';
require_once '../Modelo/Vehiculo.php';

$bitacoraTransaccion = new Transacciones();
$vehiculo = new Vehiculo();

date_default_timezone_set('America/Bogota');

/* DATOS POST*/

$nombres_buyer = $_POST['nombres_buyer'];
$apellidos_buyer = $_POST['apellidos_buyer'];
$email_buyer = strtolower($_POST['email_buyer']);
$tipo_documento_buyer = $_POST['tipo_documento_buyer'];
$num_documento_buyer = $_POST['num_documento_buyer'];
$num_celular_buyer = $_POST['num_celular_buyer'];
$registroID = $_POST['registroID'];
$modulo = $_POST['modulo'];

if ($_POST['registroID'] != ''){
    $extraGeneralInfo = [
        "modulo" => $modulo,
        "registroID" => $registroID,
    ];
}else{
    $extraGeneralInfo = [
        "modulo" => $modulo,
    ];
}
  
$JSONextraGeneralInfo = json_encode($extraGeneralInfo);
//print_r($JSONextraGeneralInfo);


$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ip = obtenerIP();

$referencia = $_POST['referencia'];
$descripcion = $_POST['descripcion'];
$valor_pago = explode("$", $_POST['valor']);

$valor = intval(str_replace(",", "", $valor_pago[1]));
$tipo_moneda = $valor_pago[0];

/*DATOS DE AUTENTICACION*/

$info = explode(" - ", $descripcion);
$placa = $info[1];

$listarVehiculoPorPlaca = $vehiculo->listarPorPlaca($placa);
//print_r($listarVehiculoPorPlaca);

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

    /* CREACION DE TRANKEY*/
    $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

/*------------ LINEAS PREMIUM ------------*/
} else if (($listarVehiculoPorPlaca[0]['numero_movil'] >= 1000)&&($listarVehiculoPorPlaca[0]['numero_movil'] <= 1999)){ 
    
    $secretKey = '3xjqwHIo7eZyydi2';
    // PRUREBA $secretKey = 'OGVbMUWB2ujHgCwC';
    
    /*LOGIN*/
    $login = '31164be2fab23d6c934d8b69d9b1cc59';
    // PRUEBA $login = 'c1f41e0bb55b3d6c029075ae981b35b6';

    /* CREACION DE TRANKEY*/
    $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));
}

$urlReturn = 'https://www.sistemakv.com/Vista/respuestaTransaccionPago.php?ref=' . $referencia;


/* ---------------------------------------- */
/* -------------************--------------- */
/* ---------------------------------------- */

$data = [
    'auth' => [
        'login' => $login,
        'seed' => $seed,
        'nonce' => $nonceBase64,
        'tranKey' => $tranKey
    ],

    "payment" => [
        "reference" => $referencia,
        "description" => $descripcion,
        "amount" => [
            "currency" => $tipo_moneda,
            "total" => $valor
        ],
    ],
    "buyer" => [
        "name" => $nombres_buyer,
        "surname" => $apellidos_buyer,
        "email" => $email_buyer,
        "document" => $num_documento_buyer,
        "documentType" => $tipo_documento_buyer,
        "mobile" => $num_celular_buyer
    ],
    "expiration" => date('c',strtotime($seed . "+ 8 minutes")),
    "returnUrl" => $urlReturn,
    "ipAddress" => $ip,
    "userAgent" => $user_agent

];


/* ---------------------------------------- */
/* -------------************--------------- */
/* ---------------------------------------- */


$dataJSON = json_encode($data);
//print_r($dataJSON);

//print_r($dataJSON);
$urlAPIRedirection = 'https://checkout.placetopay.com/api/session';
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


//execute the POST request
$result = curl_exec($ch);
$resultadoAuth = json_decode($result);

//print_r($resultadoAuth);

?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php include("../Vista/Template/styles.php"); ?>
    </head>
    <body>

        <section class="row d-flex justify-content-center">
            <div class="col-6 text-center" style="margin-top: 100px;">
                <i style="font-size: 8rem; color: #3d6685;" class="fa fa-spinner fa-pulse mt-3" aria-hidden="true"></i>
                <p class="mt-4"><strong style="font-size: 1.5rem; color: #1b2d3b;"><?php echo $resultadoAuth->{'status'}->{'message'} ?></strong></p>
                <p style="font-size: 1.5rem; color: #1b2d3b;" class="mt-2">Redirigiendo, por favor espere... </p>
                
                <div class="row d-flex justify-content-around mt-5">
                    <section>
                        <a target="_blank" href="https://www.intranetgroupkv.com/"><img src="https://sistemakv.com/Resources/img/kingvision_transparente.png" alt="Logo_King_Vision" width="85" height="55" style="display: block; margin-top: 10px;">
                    </section>
                    <section>
                        <img src="https://static.placetopay.com/placetopay-logo.svg" alt="Placetopay" width="140" height="50" style="margin-left: 5px;">
                    </section>
                </div>
            </div>
        </section>

        <?php include("../Vista/Template/scripts.php"); ?>
    </body>
    </html>


<?php 

if ($resultadoAuth->{'status'}->{'status'} == 'OK') {

    $requestID = $resultadoAuth->{'requestId'};
    $id_usuario = $_SESSION['id_usuario'];
    $fecha = date('Y-m-d H:i:s');
    $estado = 'PENDING';

    $registrarTransaccion = $bitacoraTransaccion->registrarTransaccion($referencia, $requestID, $id_usuario, $dataJSON, $fecha, $estado, $JSONextraGeneralInfo);

    echo "<script>setTimeout(function(){ window.location='" . $resultadoAuth->{'processUrl'} . "'; }, 1500);</script>";

}else{

    echo "<script>setTimeout(function(){ location.reload(); }, 1500);</script>";
}

//close cURL resource
curl_close($ch);

?>