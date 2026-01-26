<?php 
date_default_timezone_set('America/Bogota');
require_once '../Modelo/Contrato.php';
require_once '../Modelo/General.php';

$id_contrato = $_POST['id_contrato'];
$numero_contrato = $_POST['numero_contrato'];
$id_tipo_contrato = $_POST['id_tipo_contrato'];
$id_empresa = $_POST['id_empresa'];
$id_cliente = $_POST['id_cliente'];
$objeto_contrato = $_POST['objeto_contrato'];
$fecha_inicial_contrato = $_POST['fecha_inicial_contrato'];
$fecha_final_contrato = $_POST['fecha_final_contrato'];
$fecha_creacion_contrato = $_POST['fecha_creacion_contrato'];
$hora_creacion_contrato = $_POST['hora_creacion_contrato'];
$id_ciudad = $_POST['id_ciudad'];
$id_responsable = $_POST['id_responsable'];
$doc_fotocopia_contrato = $_FILES['doc_fotocopia_contrato']['name'];
$doc_fotocopia_contrato = $_FILES['doc_fotocopia_contrato']['size'];
$doc_fotocopia_contrato_act = $_POST['doc_fotocopia_contrato_act'];
$nombre_responsable = $_POST['nombre_responsable'];
$numero_documento_responsable = $_POST['numero_documento_responsable'];
$direccion_responsable = $_POST['direccion_responsable'];
$telefono_responsable = $_POST['telefono_responsable'];


date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');

	if (isset($doc_fotocopia_contrato)){

        if (!empty($doc_fotocopia_contrato)) {
        	
			$valido = 0;
            $valido = validar_archivo($_FILES['doc_fotocopia_contrato']['name'], $_FILES['doc_fotocopia_contrato']['size']);

           // echo "Hola";
            if($valido == 1){

                	//echo "Hola ";
                   $doc_fotocopia_contrato = quitar_simbolos($_FILES['doc_fotocopia_contrato']['name']);

                    $carpeta = '../Documentos/Contratos';
		            $ruta = $carpeta .'/'. $fecha .'-'. $_FILES['doc_fotocopia_contrato']['name'];
		            $doc_fotocopia_contrato = $fecha .'-'. $doc_fotocopia_contrato;                

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['doc_fotocopia_contrato']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);
					
            } else {
                echo "<script> alert('El tipo de archivo en documento Fotocopia del contrato no es valido o el archivo excede el tamaño permitido'); history.back(); </script>";
                exit();
            }

        } else {
            $doc_fotocopia_contrato = $_POST['doc_fotocopia_contrato_act'];
        }
    }

$contrato = new Contrato();

$actualizarContrato = $contrato->actualizarContrato($id_contrato, $numero_contrato, $id_tipo_contrato, $id_empresa, $id_cliente, $objeto_contrato, $fecha_inicial_contrato, $fecha_final_contrato, $fecha_creacion_contrato, $hora_creacion_contrato, $id_ciudad, $id_responsable, $doc_fotocopia_contrato, $nombre_responsable, $numero_documento_responsable, $direccion_responsable, $telefono_responsable);

header('Location: ../Vista/contratos.php');

?>