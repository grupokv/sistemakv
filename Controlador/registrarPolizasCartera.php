<?php 
session_start();
require_once("../Modelo/Cartera.php");


date_default_timezone_set('America/Bogota');

$cartera = new Cartera();

$id_empresa = $_POST['id_empresa'];
$nombre_cliente = $_POST['nombre_cliente'];
$tipo_identificacion = $_POST['tipo_identificacion'];
$num_identificacion = $_POST['num_identificacion'];
$valor_total = $_POST['valor_total'];
$por_vencer = $_POST['por_vencer'];

if($_POST['dias_mora_1_30'] == ""){
    $dias_mora_1_30 = 0;
}else{
    $dias_mora_1_30 = $_POST['dias_mora_1_30'];
}
if($_POST['dias_mora_31_60'] == ""){
    $dias_mora_31_60 = 0;
}else{
    $dias_mora_31_60 = $_POST['dias_mora_31_60'];
}
if($_POST['dias_mora_61_90'] == ""){
    $dias_mora_61_90 = 0;
}else{
    $dias_mora_61_90 = $_POST['dias_mora_61_90'];
}
if($_POST['dias_mora_mayor_90'] == ""){
    $dias_mora_mayor_90 = 0;
}else{
    $dias_mora_mayor_90 = $_POST['dias_mora_mayor_90'];
}
$id_usuario_creador = $_SESSION['id_usuario'];
$fecha_creacion = date('Y-m-d H:i:s');

$registrarPolizasCartera = $cartera->registrarPolizasCartera($id_empresa, $nombre_cliente, $tipo_identificacion, $num_identificacion, $valor_total, $por_vencer, $dias_mora_1_30, $dias_mora_31_60, $dias_mora_61_90, $dias_mora_mayor_90, $id_usuario_creador, $fecha_creacion);


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
				<p class="col-12 text-center" style="font-family: 'Raleway', sans-serif;">Se ha registrado correctamente la poliza</p>
				<p class="col-12 text-center" style="font-family: 'Raleway', sans-serif;">¿Desea agregar otro?</p>
            </div>
		</section>
		<section class="col-4" style="border-left: 4px solid #eee">
			<div class="mt-5">
				<a href="../Vista/registrarPolizas.php" type="button" class="btn btn-block" id="registrar" style="border: 1px solid  #18ad13; border-radius: 18px; color:  #18ad13;  ">Registrar</a>
				<a href="../Vista/polizas_cartera.php" type="button" class="btn btn-block" id="continuar" style="border: 1px solid #c40c0c; border-radius: 18px; color: #c40c0c; ">Finalizar</a>
			</div>
		</section>
	</div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="mt-2" style="border-bottom: 4px solid #fff; height: 1px; width: 50%;"></div>
</div>

<?php include '../Vista/Template/scripts.php'; ?>