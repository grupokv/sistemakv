<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Convenio.php");
require_once("../Modelo/General.php");

date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');

$doc_convenio = $_FILES['doc_convenio']['name'];
$act_doc_convenio = $_POST['act_doc_convenio'];
$id_convenio = $_POST['id_convenio'];
$id_empresa = $_POST['id_empresa'];
$fecha_inicio_convenio = $_POST['fecha_inicio_convenio'];
$fecha_final_convenio = $_POST['fecha_final_convenio'];
$id_ciudad = $_POST['id_ciudad_convenio'];
$id_vehiculo = $_POST['id_vehiculo'];
$id_conductor = $_POST['id_conductor'];
$id_contrato = $_POST['id_contrato'];
$id_cliente = $_POST['id_cliente'];
$fecha_creacion_convenio = $_POST['fecha_creacion_convenio'];
$hora_creacion_convenio = $_POST['hora_creacion_convenio'];
$id_responsable = $_POST['id_responsable'];


if (isset($doc_convenio)){

	if (!empty($doc_convenio)) {

        $valido = 0;
        echo $valido = validar_archivo($_FILES['doc_convenio']['name'], $_FILES['doc_convenio']['size']);
        if($valido == 1){

            $doc_convenio = quitar_simbolos($_FILES['doc_convenio']['name']);
            $doc_convenio = $fecha . '-'. $doc_convenio;                    
            $carpeta = "../Documentos/Convenios/";
            $ruta = $carpeta .'/'. $doc_convenio;                    

            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0757, true);
            }

            $ruta_temp = $_FILES['doc_convenio']['tmp_name'];
            move_uploaded_file($ruta_temp, $ruta);

        } else {
            echo "<script>
            alert('El tipo de archivo del convenio no es valido o el archivo excede el tamaño permitido');
            history.back();
            </script>";
            exit();
        }

    } else {
        $doc_convenio = $_POST['act_tarjeta_operacion'];
    }

}

$convenio = new Convenio();
$ActualizarC = $convenio->actualizar($id_convenio, $doc_convenio, $id_empresa, $fecha_inicio_convenio, $fecha_final_convenio, $id_ciudad, $id_vehiculo, $id_conductor, $id_contrato, $id_cliente, $fecha_creacion_convenio, $hora_creacion_convenio, $id_responsable);

	

$id_modulo = 21;
$id_registro = $id_convenio;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = 'id_convenio | doc_convenio | id_empresa | fecha_inicio_convenio |fecha_final_convenio | id_ciudad | id_vehiculo | id_conductor | id_contrato | id_cliente | fecha_creacion_convenio | hora_creacion_convenio | id_responsable';
$valores_antiguos =  '';
$valores_nuevos = $cargarC . ' | '. $id_empresa . ' | '  . $doc_convenio . ' | '  . $fecha_inicio_convenio . ' | '  . $fecha_final_convenio . ' | '. $id_ciudad . ' | ' .  $id_vehiculo . ' | ' . $id_conductor . ' | ' . $id_contrato . ' | ' . $id_cliente . ' | ' . $fecha_creacion_convenio . ' | '. $hora_creacion_convenio . ' | ' . $id_responsable;

$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');


$bitacoraRegistroConvenios = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
														  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
														  $hora_actividad);


header("Location: ../Vista/convenios.php");

 ?>