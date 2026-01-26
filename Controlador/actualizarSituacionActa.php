<?php 
require_once '../Modelo/Actas.php';

$acta = new Acta();

$id_acta = $_POST['id_acta'];

$opcion = $_POST['ra'];

if ($opcion == 'R') {
	$descripcion_situacion = $_POST['descripcion_situacion'];
	$solucion_situacion = $_POST['solucion_situacion'];
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

}else{
	$id_situacion = $_POST['id_situacion'];
	$act_descripcion_situacion = $_POST['act_descripcion_situacion'];
	$act_solucion_situacion = $_POST['act_solucion_situacion'];
	$act_id_responsable = $_POST['act_id_responsable'];
	$act_estado_solucion = $_POST['act_estado_situacion'];
	
	$act_responsables = '';

	for ($i=0; $i < count($act_id_responsable); $i++) { 
		if($i == (count($act_id_responsable) - 1)){
			$act_responsables .= $act_id_responsable[$i];
		}else{
			$act_responsables .= $act_id_responsable[$i] . ',';
		}
	}

	$act_id_reportar_a = $_POST['act_id_reportar_a'];
	$act_fecha_limite = $_POST['act_fecha_limite'];
	$act_prioridad = $_POST['act_prioridad'];

	$actualizar = $acta->actualizarSituacionActa($id_situacion, $id_acta, $act_descripcion_situacion, $act_solucion_situacion, $act_responsables, $act_estado_solucion, $act_id_reportar_a, $act_fecha_limite, $act_prioridad);
}

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
				<p style="font-family: 'Raleway', sans-serif;">¿Deseas modificar o agregar otra situación?</p>
            </div>
		</section>
		<section class="col-4" style="border-left: 4px solid #eee">
			<div class="mt-5">
				<a href="../Vista/actualizarActasSituaciones.php?id_acta=<?php echo $id_acta ?>" type="button" class="btn btn-block" id="registrar" style="border: 1px solid  #18ad13; border-radius: 18px; color:  #18ad13;  ">Seguir modificando</a>
				<a href="../Vista/Actas.php" type="button" class="btn btn-block" id="continuar" style="border: 1px solid #c40c0c; border-radius: 18px; color: #c40c0c; ">Finalizar</a>
			</div>
		</section>
	</div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="mt-2" style="border-bottom: 4px solid #fff; height: 1px; width: 50%;"></div>
</div>


<?php include '../Vista/Template/scripts.php'; ?>
