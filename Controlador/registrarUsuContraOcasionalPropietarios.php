<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/UsuarioContratoOcasional.php");
require_once("../Modelo/contratoOcasional.php");
require_once("../Modelo/Fuec.php");
require_once("../Modelo/Vehiculo.php");

$fuec = new Fuec();
$vehiculo = new Vehiculo();
$contratoOcasional = new ContratoOcasional();
$usuarioContratoOcasional = new UsuarioContratoOcasional();

$id_contrato = $_POST['id_contrato'];
$fecha_creacion = date('Y-m-d');

$nombre = $_POST['nombre_usuario'];
$documento = $_POST['numero_documento'];


for ($i=0; $i < count($nombre); $i++) { 

$nombre_usuario = $nombre[$i];
$numero_documento = $documento[$i];
$registrar = $usuarioContratoOcasional->registrar($id_contrato, $nombre_usuario, $numero_documento);	
}	



$datos = $fuec->listarFuecPorIdContratoOcasional($id_contrato);
$id_vehiculo = $datos[0]['id_vehiculo'];
$listarVehiculoID = $vehiculo->listarPorId($id_vehiculo);

$validarVehiculosEximidosPagos = $contratoOcasional->validarVehiculosEximidosPagos($id_vehiculo, $fecha_creacion);

$validarPaquetesPlusOcasionales = $contratoOcasional->validarPaquetesPlusOcasionales($id_vehiculo, $fecha_creacion);


if ((count($validarVehiculosEximidosPagos) > 0) || (count($validarPaquetesPlusOcasionales) > 0)) {
	echo "<script>alert('El contrato ocasional fue registrado correctamente.'); window.location.href='../Vista/contratosOcasionales.php';</script>";
	
}else{ 



if (($listarVehiculoID[0]['id_tipo_vehiculo'] == 7) || ($listarVehiculoID[0]['id_tipo_vehiculo'] == 6) || ($listarVehiculoID[0]['id_tipo_vehiculo'] == 3)) {
	if ($datos[0]['destino'] == $datos[0]['origen']) {
		$costo = '17000';
	}else{
		$costo = '10000';
	}
}else if ($listarVehiculoID[0]['id_tipo_vehiculo'] == 5) {
	if ($datos[0]['destino'] == $datos[0]['origen']) {
		$costo = '20000';
	}else{
		$costo = '15000';
	}
}else if ($listarVehiculoID[0]['id_tipo_vehiculo'] == 4) {
	if ($datos[0]['destino'] == $datos[0]['origen']) {
		$costo = '30000';
	}else{
		$costo = '17000';
	}
}

$descripcion = 'COSTOS ADMINISTRATIVOS ' . $datos[0]['id_fuec'];
$referencia = rand(1000, 9999) . date('YmdHis');

?>
	<!DOCTYPE html>
		<html>
		<body onload="submitForm();">
			<head>
    			<?php include("../Vista/Template/styles.php"); ?>
			</head>
				<div class="text-center" style="margin-top: 150px;">
					<i class="fa fa-check-circle-o" style="color: darkgreen; font-size: 7rem;"></i>
					<p style="font-size: 1.8rem;"><strong>Se ha registrado correctamente.</strong></p>
					<cite><strong><?php echo date('Y-m-d'); ?></strong></cite>
					
				</div>
				<section class="col-12 d-flex justify-content-center">
					<a target="_blank" href="https://www.intranetgroupkv.com/"><img src="https://sistemakv.com/Resources/img/kingvision_transparente.png" alt="Logo_King_Vision" width="100" height="60" style="display: block; margin-top: 10px;"></a>
				</section>
                    

			<form name="formRedirection" action="../Vista/formularioPagos.php" method="POST">
				<input type="hidden" name="costo" id="costo" value="<?php echo $costo ?>">
				<input type="hidden" name="descripcion" id="descripcion" value="<?php echo $descripcion ?>">
				<input type="hidden" name="referencia" id="referencia" value="<?php echo $referencia ?>">
				<input type="hidden" name="id_vehiculo" id="id_vehiculo" value="<?php echo $id_vehiculo ?>">
				<input type="hidden" name="registroID" id="registroID" value="<?php echo $datos[0]['id_fuec']; ?>">
				<input type="hidden" name="modulo" id="modulo" value="2">
			</form>
			
		</body>
		</html>

    	<?php include("../Vista/Template/scripts.php"); ?>
		<script>
			function submitForm() { 
				document.formRedirection.submit(); 
			}
		</script>
<?php } ?>
