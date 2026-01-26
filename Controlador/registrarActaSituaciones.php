<?php 
require_once '../Modelo/Actas.php';

$acta = new Acta();

$id_acta = $_POST['id_acta'];
$descripcion_situacion = strtr(strtoupper($_POST['descripcion_situacion']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
$solucion_situacion = strtr(strtoupper($_POST['solucion_situacion']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
$id_responsable = $_POST['id_responsable'];

$responsables = '';

for ($i=0; $i < count($id_responsable); $i++) { 
	if($i == (count($id_responsable) - 1)){
		$responsables .= $id_responsable[$i];
	}else{
		$responsables .= $id_responsable[$i] . ',';
	}
}
$estado_solucion = $_POST['estado_solucion'];
$id_reportar_a = $_POST['id_reportar_a'];
$fecha_limite = $_POST['fecha_limite'];
$prioridad = $_POST['prioridad'];

$registrarSituacionActa = $acta->registrarSituacionActa($id_acta, $descripcion_situacion, $solucion_situacion, $responsables, $estado_solucion, $id_reportar_a, $fecha_limite, $prioridad);

include '../Vista/Template/styles.php';

?>

<style type="text/css" media="screen">
	@import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');

	body{
		background: #eeeeee;
		font-family: 'Poppins', sans-serif;
	}

	#registrar:hover{
		background-color: #18ad13;
		color: #fff !important;
	}

	#continuar:hover{
		background-color: #c40c0c;
		color: #fff !important;

	}
</style>

<div style="display: flex; justify-content: center; margin-top: 60px;">
	<div class="mb-2" style="border-bottom: 4px solid #fff; height: 1px; width: 50%;"></div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="row" style="background: #fff; width: 50%; height: 170px; border-radius: 2px;">
		<section class="col-8">
			<div class="row justify-content-center mt-4">
                <p class="ml-4 logo" id="k" style="font-size: 1.6rem; font-weight: bold;">KING</p>  
                <p class="ml-1 mr-3 logo" id="v" style="font-size: 1.6rem; font-weight: bolder;">VISION</p> 
				<p style="font-family: 'Raleway', sans-serif;">¿Deseas agregar otra situación para este acta?</p>
            </div>
		</section>
		<section class="col-4" style="border-left: 4px solid #eee">
			<div class="mt-5">
				<a href="../Vista/registrarActasSituaciones.php?id_acta=<?php echo $id_acta ?>" type="button" class="btn btn-block" id="registrar" style="border: 1px solid  #18ad13; border-radius: 18px; color:  #18ad13;  ">Agregar Mas</a>
				<a href="../Vista/Actas.php" type="button" class="btn btn-block" id="continuar" style="border: 1px solid #c40c0c; border-radius: 18px; color: #c40c0c; ">Continuar</a>
			</div>
		</section>
	</div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="mt-2" style="border-bottom: 4px solid #fff; height: 1px; width: 50%;"></div>
</div>

<?php include '../Vista/Template/scripts.php'; ?>