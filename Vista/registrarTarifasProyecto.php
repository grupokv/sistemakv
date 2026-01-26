<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/TipoVehiculo.php';

$id_proyecto = $_GET['id_proyecto'];

    $id = '';
    $titulo = '';
    $icono = '';
	$redireccion = '';

/* VARIABLES MENU*/
$titulo .= 'Registrar Tarifas Proyectos';
$redireccion .= 'contratos.php';
$icono .= 'fa fa-gears';


$tipoVehiculo = new TipoVehiculo();
$listarTiposVehiculos = $tipoVehiculo->listar();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Proyecto</title>
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
            <li class="breadcrumb-item active" aria-current="page">Registrar Proyecto Proyectos</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form action="../Controlador/registrarTarifasProyectos.php" method="POST">
	            	
	            	<?php include("Template/header-form.php"); ?>

	            		<input type="hidden" class="form-control" name="id_proyecto" id="id_proyecto" value="<?php echo $id_proyecto ?>">

			            <!-- Detalle -->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Detalle</label>
				     	        </section>
		                    	<section class="input">
                                        <input type="text" name="detalle" id="detalle" class="form-control" required="true">
				     	        </section>
		                    </div>

                        <!-- Tipo Vehiculo -->

                            <div class="row mt-3">
                                <section class="label">
                                    <label>Tipo Vehiculo</label>
                                </section>
                                <section class="input">
                                        <select class="form-control selectpicker" data-live-search="true" name="id_tipo_vehiculo" id="id_tipo_vehiculo">
                                            <option value="0">SELECCIONAR</option>
                                            <?php foreach ($listarTiposVehiculos as $ltv){ ?>
                                                <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>"><?php echo $ltv['nombre_tipo_vehiculo']; ?></option>
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
                                            <option value="0">SELECCIONAR</option>
                                            <option value="M">MENSUAL</option>
                                            <option value="D">DIARIO</option>
                                            <option value="H">POR HORA</option>
                                            <option value="S">POR SERVICIO</option>
                                        </select>
                                </section>
                            </div>

                        <!-- Costo Servicio -->

                            <div class="row mt-3">
                                <section class="label">
                                    <label>Tarifa del Servicio</label>
                                </section>
                                <section class="input">
                                        <input type="text" name="costo_servicio" id="costo_servicio" class="form-control" required="true">
                                </section>
                            </div>

                        <hr>

          
                    <?php include("Template/bottom-form.php"); ?>


	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>


</body>
</html>