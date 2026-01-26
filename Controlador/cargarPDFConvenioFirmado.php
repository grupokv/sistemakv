<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Convenio.php");
require_once("../Modelo/General.php"); 

date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');

$convenio = new Convenio();

$id_convenio = $_POST['id_convenio'];
$doc_convenio = $_FILES['documento_firmado']['name'];


if (isset($doc_convenio)){
	if (!empty($_FILES['documento_firmado']['name'])) {

	    $carpeta = $carpeta = '../Documentos/Convenios/';
	    $ruta = $carpeta .'/'. $fecha.'-'. $_FILES['documento_firmado']['name'];
	   	$doc_convenio = $fecha . '-' . $doc_convenio;

	    if (!file_exists($carpeta)) {
	        mkdir($carpeta, 0757, true);
	    }

	    $ruta_temp = $_FILES['documento_firmado']['tmp_name'];
	    move_uploaded_file($ruta_temp, $ruta);
	}

}

$cargarConvenioFirmado = $convenio->cargarConvenioFirmado($id_convenio, $doc_convenio);

if ($cargarConvenioFirmado != 0) { ?>

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
			alertify.alert('DOCUMENTO CARGADO', '¡El documento del convenio firmado se ha cargado satisfactoriamente en el sistema!.', function(){ window.history.back(); });   
        }

        $(window).on("load", modalAviso());

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
			alertify.alert('ERROR AL CARGAR DOCUMENTO', '¡Hubo un error al cargar el documento del convenio firmado en el sistema!.', function(){ window.history.back(); });   
        }

        $(window).on("load", modalAviso());

	</script>

<?php } ?>
