<?php
session_start();

include ("Sesion/autenticar.php");
require_once("../Modelo/Vinculacion.php");
require_once("../Modelo/General.php");

date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');


$vinculacion = new Vinculacion();

$numero_contrato = $_POST['numero_contrato'];
$id_tipo_contrato = $_POST['id_tipo_contrato'];
$id_empresa = $_POST['id_empresa'];
$id_cliente = $_POST['id_cliente'];
$fecha_inicial = $_POST['fecha_inicial_contrato'];
$fecha_final = $_POST['fecha_final_contrato'];
$fecha_creacion = date('Y-m-d H:i:s');
$creador = $_SESSION['id_usuario'];


if (isset($_FILES['doc_fotocopia_contrato']['name'])){
    
    /* FOTOCOPIA DEL CONTRATO*/
        if (!empty($_FILES['doc_fotocopia_contrato']['name'])) {
            
            $valido = 0;
            $valido = validar_archivo($_FILES['doc_fotocopia_contrato']['name'], $_FILES['doc_fotocopia_contrato']['size']);
            if($valido == 1){

                $doc_fotocopia_contrato = quitar_simbolos($_FILES['doc_fotocopia_contrato']['name']);
                $doc_fotocopia_contrato = $fecha . '-'. $doc_fotocopia_contrato;                    
                $carpeta = "../Documentos/Vinculaciones/Contratos";
                $ruta = $carpeta .'/'. $doc_fotocopia_contrato;                    

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['doc_fotocopia_contrato']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);

            } else {
                echo "<script>alert('El tipo de archivo en FOTOCOPIA DEL CONTRATO no es valido o el archivo excede el tamaño permitido');history.back();</script>";
                exit();
            }

        }
}

$registrarContrato = $vinculacion->registrarContrato($numero_contrato, $id_tipo_contrato, $id_empresa, $id_cliente, $fecha_inicial, $fecha_final, $doc_fotocopia_contrato, $fecha_creacion, $creador);


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
				<p class="col-12 text-center" style="font-family: 'Raleway', sans-serif;">Se ha registrado correctamente el contrato</p>
            </div>
		</section>
		<section class="col-4" style="border-left: 4px solid #eee">
			<div class="mt-5">
				<a href="../Vista/contratos_prestacion_servicios.php" type="button" class="btn btn-block" id="continuar" style="border: 1px solid #c40c0c; border-radius: 18px; color: #c40c0c; ">Continuar</a>
			</div>
		</section>
	</div>
</div>

<div style="display: flex; justify-content: center;">
	<div class="mt-2" style="border-bottom: 4px solid #fff; height: 1px; width: 50%;"></div>
</div>

<?php include '../Vista/Template/scripts.php'; ?>