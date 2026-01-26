<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/TipoVehiculo.php';
require_once '../Modelo/Contrato.php';

$idTarifaProyecto = explode("-", $_GET['id_tarifa_proyecto']);
$id_tarifa_proyecto = $idTarifaProyecto[0];
$id_proyecto = $idTarifaProyecto[1];



$id = '';
$titulo = '';
$icono = '';
$redireccion = '';

/* VARIABLES MENU*/
$titulo .= 'Actualizar Tarifas Proyectos';
$redireccion .= 'contratos.php';
$icono .= 'fa fa-gears';

$contrato = new Contrato();
$listarIdTarifas = $contrato->listarIdTarifas($id_tarifa_proyecto);


$tipoVehiculo = new TipoVehiculo();
$listarTiposVehiculos = $tipoVehiculo->listar();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Proyecto</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="Contratos.php">Contratos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Tarifas Proyectos</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form action="../Controlador/actualizarTarifasProyectos.php" method="POST">
	            	
	            	<?php include("Template/header-form.php"); ?>

                    <?php foreach ($listarIdTarifas as $lti) { ?>

	            		<input type="hidden" class="form-control" name="id_proyecto" id="id_proyecto" value="<?php echo $id_proyecto ?>">
                        <input type="hidden" class="form-control" name="id_tarifa_proyecto" id="id_tarifa_proyecto" value="<?php echo $id_tarifa_proyecto ?>">

			            <!-- Detalle -->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Detalle</label>
				     	        </section>
		                    	<section class="input">
                                        <input type="text" name="detalle" id="detalle" class="form-control" required="true" value="<?php echo $lti['detalle'] ?>">
				     	        </section>
		                    </div>

                        <!-- Tipo Vehiculo -->

                            <div class="row mt-3">
                                <section class="label">
                                    <label>Tipo Vehiculo</label>
                                </section>
                                <section class="input">
                                        <select class="form-control selectpicker" data-live-search="true" name="id_tipo_vehiculo" id="id_tipo_vehiculo">
                                            <?php foreach ($listarTiposVehiculos as $ltv){ ?>
                                                <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>" <?php if($lti['id_tipo_vehiculo'] == $ltv['id_tipo_vehiculo'] ){ ?> selected="selected" <?php } ?> ><?php echo $ltv['nombre_tipo_vehiculo']; ?></option>
                                            <?php } ?>
                                        </select>
                                </section>
                            </div>

                        <!-- Tiempo cobro -->

                            <div class="row mt-3">
                                <section class="label">
                                    <label>Tiempo de Cobro</label>
                                </section>
                                <section class="input">
                                        <select class="form-control selectpicker" data-live-search="true" name="tiempo_cobro" id="tiempo_cobro">
                                            <?php if ($lti['tiempo_cobro'] == 'M'){ ?>
                                                <option value="M" selected="selected">MENSUAL</option>
                                                <option value="D">DIARIO</option>
                                                <option value="H">POR HORA</option>
                                                <option value="S">POR SERVICIO</option>
                                            <?php } else if ($lti['tiempo_cobro'] == 'D') { ?>
                                                <option value="D" selected="selected">DIARIO</option>
                                                <option value="M">MENSUAL</option>
                                                <option value="H">POR HORA</option>
                                                <option value="S">POR SERVICIO</option>
					    <?php } else if ($lti['tiempo_cobro'] == 'H') { ?>
                                                <option value="H" selected="selected">POR HORA</option>
                                                <option value="M">MENSUAL</option>
                                                <option value="D">DIARIO</option>
                                                <option value="S">POR SERVICIO</option>
                                            <?php }else if ($lti['tiempo_cobro'] == 'S') { ?>
                                                <option value="S" selected="selected">POR SERVICIO</option>
                                                <option value="M">MENSUAL</option>
                                                <option value="D">DIARIO</option>
                                                <option value="H">POR HORA</option>
                                            <?php }else{ ?>
                                                <option value="0" selected="selected">SELECCIONAR</option>
                                                <option value="M">MENSUAL</option>
                                                <option value="D">DIARIO</option>
                                                <option value="H">POR HORA</option>
                                                <option value="S">POR SERVICIO</option>
                                            <?php } ?>
                                        </select>
                                </section>
                            </div>

                        <!-- Costo Servicio -->

                            <div class="row mt-3">
                                <section class="label">
                                    <label>Tarifa del Servicio</label>
                                </section>
                                <section class="input">
                                        <input type="text" name="costo_servicio" id="costo_servicio" class="form-control" value="<?php echo $lti['costo_servicio'] ?>" required="true">
                                </section>
                            </div>

                        <hr>

                    <?php  } ?>    

          
                    <?php include("Template/bottom-form.php"); ?>


	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>


</body>
</html>