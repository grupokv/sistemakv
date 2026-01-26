<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Empleado.php");

$id = $_GET['id'];

$empleado = new Empleado();
$listarSSporID = $empleado->listarSSporID($id);

/* VARIABLES MENU*/
$titulo = 'Actualizar seguridad social empleados';
$redireccion = 'seguridadSocialEmpleados.php';
$icono = 'fa fa-map';

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar SS Emplados</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="seguridadSocialEmpleados.php">Seguridad Social</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Seguridad Social</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarSSEmpleado.php" method="POST" enctype="multipart/form-data">
	        	<?php include("Template/header-form.php"); ?>
                        <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id; ?>"/>
                        <table id="input-group" class="table mt-4">
                            <thead>
                                <tr>
                                    <th style="border:none;"></th>
                                    <th style="border:none;">NOMBRE DE DOCUMENTO</th>
                                    <th style="border:none;">DOC SEGURIDAD SOCIAL</th>
                                    <th style="border:none;">MES</th>
                                    <th width="100" style="border:none;">AÑO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border:none;"><span style="font-size: 1.6rem;" class="fa fa-file-text"></span></td>
                                    <td style="border:none;"><input type="text" class="form-control" name="nombre_doc_ss" id="nombre_doc_ss" value="<?php echo $listarSSporID[0]['nombre_documento']; ?>"></td>
                                    <td style="border:none;">
                                        <input type="file" class="form-control" name="doc_ss" id="doc_ss">
                                        <input type="hidden" class="form-control" name="doc_ss_actual" id="doc_ss_actual" value="<?php echo $listarSSporID[0]['seguridad_social']; ?>">
                                        <p class="mt-2"><strong>Documento Actual: </strong><a target="_blank" href="../Documentos/Empleados/SeguridadSocial/<?php echo $listarSSporID[0]['seguridad_social']; ?>"><?php echo $listarSSporID[0]['seguridad_social']; ?></a></p>
                                    </td>
                                    <td style="border:none;">
                                        <select class="form-control" ata-live-search="true" name="mes" id="mes">
                                            <option value="0">SELECCIONAR</option>
                                            <?php if($listarSSporID[0]['mes'] == '1'){ ?>
                                            <option value="01" selected="selected">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '2'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02" selected="selected">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '3'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03" selected="selected">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '4'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04" selected="selected">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '5'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05" selected="selected">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '6'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06" selected="selected">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '7'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07" selected="selected">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '8'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08" selected="selected">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '9'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09" selected="selected">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '10'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10" selected="selected">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '11'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11" selected="selected">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                            <?php } else if($listarSSporID[0]['mes'] == '12'){ ?>
                                            <option value="01">ENERO</option>
                                            <option value="02">FEBRERO</option>
                                            <option value="03">MARZO</option>
                                            <option value="04">ABRIL</option>
                                            <option value="05">MAYO</option>
                                            <option value="06">JUNIO</option>
                                            <option value="07">JULIO</option>
                                            <option value="08">AGOSTO</option>
                                            <option value="09">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12" selected="selected">DICIEMBRE</option>
                                            <?php } ?>
                                        </select>
                                    </td style="border:none;">
                                    <td style="border:none;">
                                        <input type="text" name="anio" id="anio" class="anio_ss form-control" >
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>

    <script>
        
        $( function() {
            $('.anio_ss').yearpicker({
                year: <?php echo $listarSSporID[0]['anio']; ?>,
            }); 
        }); 

    </script>
</body>
</html>