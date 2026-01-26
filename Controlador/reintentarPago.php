<?php 
date_default_timezone_set('America/Bogota');

include ("Sesion/autenticar.php");
require_once '../Modelo/BitacoraTransaccion.php';
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/General.php';

$transacciones = new Transacciones();
$vehiculo = new Vehiculo();

$id_transaccion = $_POST['id_transaccion'];

$listarBitacoraTransaccionID = $transacciones->listarBitacoraTransaccionID($id_transaccion);

$data = json_decode(utf8_decode($listarBitacoraTransaccionID[0]['data']));
$info = explode(" - ", $data->{'payment'}->{'description'});
$placa = $info[1];

$listarVehiculoPorPlaca = $vehiculo->listarPorPlaca($placa);


$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ip = obtenerIP();
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
    ],

    "payment" => [
        "reference" => $data->{'payment'}->{'reference'},
        "description" => $data->{'payment'}->{'description'},
        "amount" => [
            "currency" => $data->{'payment'}->{'amount'}->{'currency'},
            "total" => $data->{'payment'}->{'amount'}->{'total'}
        ],
    ],
    "buyer" => [
        "name" => $data->{'buyer'}->{'name'},
        "surname" => $data->{'buyer'}->{'surname'},
        "email" => $data->{'buyer'}->{'email'},
        "document" => $data->{'buyer'}->{'document'},
        "documentType" => $data->{'buyer'}->{'documentType'},
        "mobile" => $data->{'buyer'}->{'mobile'}
    ],
    "expiration" => date('c',strtotime($seed . "+ 8 minutes")),
    "returnUrl" => $data->{'returnUrl'},
    "ipAddress" => $ip,
    "userAgent" => $user_agent
];

$dataJSON = json_encode($data);

//print_r($dataJSON);
//print_r($dataJSON);
$urlAPIRedirection = 'https://checkout.placetopay.com/api/session/';
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
                        <img src="https://sistemakv.com/Resources/img/Logo-placetopay-by-Evertec.webp" alt="Place to Pay" width="140" height="50" style="margin-left: 5px;">
                    </section>
                </div>
            </div>
        </section>

        <?php include("../Vista/Template/scripts.php"); ?>
    </body>
    </html>

<?php 

if ($resultadoAuth->{'status'}->{'status'} == 'OK') {
 
    $actualizarRequestIDTransaccionReintentoPago = $transacciones->actualizarRequestIDTransaccionReintentoPago($resultadoAuth->{'requestId'}, $id_transaccion);

    echo "<script>setTimeout(function(){ window.location='" . $resultadoAuth->{'processUrl'} . "'; }, 500);</script>";

}else{

    echo "<script>setTimeout(function(){ location.reload(); }, 1500);</script>";
}


?>

