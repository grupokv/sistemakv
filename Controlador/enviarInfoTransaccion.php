<?php  
include ("Sesion/autenticar.php");
require_once ("../Modelo/BitacoraTransaccion.php");
require_once ("../Modelo/ConceptosCobro.php");
require_once ("../Modelo/Cartera.php");
require_once ("../Modelo/General.php");

$bitacoraTransaccion = new Transacciones();
$concepto = new ConceptoCobro();
$cartera = new Cartera();

$costo = $_POST['total'];

$descripcion = '';
$mesActual = '';
$id_conceptoActual = '';
$IDcobros = '';


for ($i=0; $i < count($_POST['pagos']) ; $i++) { 
	$conceptoCobro = explode('|', $_POST['pagos'][$i]);
	$id_cobroConcepto = $conceptoCobro[0];

	if ($i == (count($_POST['pagos']) - 1)){
		$IDcobros .= $id_cobroConcepto;
	
	}else{
		$IDcobros .= $id_cobroConcepto . ',';
	}
	
	$listarPorIdCobrosPropietario = $concepto->listarPorIdCobrosPropietario($id_cobroConcepto);

	$id_vehiculo = $listarPorIdCobrosPropietario[0]['id_vehiculo'];

	foreach ($listarPorIdCobrosPropietario as $cpicp) {
		$fechaCobro = explode("-", $cpicp['fecha_cobro']);

		$anio = $fechaCobro[0];
		$mes = $fechaCobro[1];
		$dia = $fechaCobro[2];

		$listarConceptoId = $concepto->listarPorId($cpicp['id_concepto']);

		if ($cpicp['id_concepto'] != $id_conceptoActual) {
    		$descripcion .= ' ' . $listarConceptoId[0]['detalle_concepto'];
		}


        if ($mesActual != $mes) {
        	if ($i == (count($_POST['pagos']) - 1)){
    			$descripcion .= ' ' . strtoupper(mes($mes)) . '.';
        	
			}else{
    			$descripcion .= ' ' . strtoupper(mes($mes)) . ',';
			}
    	}


		$mesActual = $mes;
        $id_conceptoActual = $cpicp['id_concepto'];
	}
}

$referencia = rand(1000, 9999) . date('YmdHis');


$historialTransaccionesPendientesPorUsuario = $bitacoraTransaccion->historialTransaccionesPendientesPorUsuario($_SESSION['id_usuario']);


$data = json_decode(utf8_decode($historialTransaccionesPendientesPorUsuario[0]['data']));



$cantTPU = count($historialTransaccionesPendientesPorUsuario);
//$cantTPU = 1;

if ($cantTPU == 0) {?>

<!DOCTYPE html>
<html>
<body onload="submitForm();">
	<form name="formRedirection" action="../Vista/formularioPagos.php" method="POST">
		<input type="hidden" name="costo" id="costo" value="<?php echo $costo ?>">
		<input type="hidden" name="descripcion" id="descripcion" value="<?php echo $descripcion ?>">
		<input type="hidden" name="referencia" id="referencia" value="<?php echo $referencia ?>">
		<input type="hidden" name="id_vehiculo" id="id_vehiculo" value="<?php echo $id_vehiculo ?>">
		<input type="hidden" name="registroID" id="registroID" value="<?php echo $IDcobros; ?>">
		<?php if ($_POST['TipoPago'] == 'A'){ ?>
			<input type="hidden" name="modulo" id="modulo" value="3">
		<?php } else{ ?>
			<input type="hidden" name="modulo" id="modulo" value="1">
		<?php } ?>
	</form>
</body>
</html>

<script>
	function submitForm() { 
		document.formRedirection.submit(); 
	}
</script>

<?php } else { ?>

	<!DOCTYPE html>
	<html>
	<head>
  		<?php include("../Vista/Template/styles.php") ?>
  		<style>
  			.ajs-button{
	            border-radius: 5px;
	            background-color: #5e99b1;
	            color: #fff;
	            box-shadow: none;
	            border:0px;
	        }

	        .ajs-header{
	            color: #1b2d3b !important;
	        }
  		</style>
  	</head>
	<body>
    	<?php include("../Vista/Template/scripts.php"); ?>
	</body>
	</html>


	<script>

		function modalAviso(){
			alertify.alert('TRANSACCIÓN EN CURSO', '¡Actualmente tiene una transaccion con estado pendiente! REFERENCIA:' + ' <?php echo $historialTransaccionesPendientesPorUsuario[0]['referencia'] ?> ' + ' - VALOR DE LA TRANSACCIÓN: ' + ' $<?php echo number_format($data->{'payment'}->{'amount'}->{'total'}) . ' ' . $data->{'payment'}->{'amount'}->{'currency'}?> ' + '  no podra avanzar hasta terminar el debido proceso de la transacción o intentarlo nuevamente mas tarde! \n \n Para validar el estado de la misma dirijirse a la sección de historial de transacciones.', function(){ window.history.back(); });   
        }

        $(window).on("load", modalAviso());

	</script>

<?php } ?>
