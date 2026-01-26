<?php 
	include ("../Controlador/Sesion/autenticar.php");
	require_once ('../Modelo/Operacion.php');
    require_once ('../Modelo/Vehiculo.php');

/* VARIABLES MENU*/
$titulo = 'Registrar Detalle';
$redireccion = 'detalles.php';
$icono = 'fa fa-clipboard';

	$operaciones = new Operacion();
    $listarO = $operaciones->listar();

    $vehiculo = new Vehiculo();
    $listarVehiculo = $vehiculo->listar();


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar detalle</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="Areas.php">Areas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar areas</li>
         </ol>
    </div>

    <section class="form-usuarios mt1">
        <div class="formulario mb-5">

            <form action="../Controlador/registrarDetalleOperacion.php" method="POST">
			    <?php include("Template/header-form.php"); ?> 

			    	<!-- OPCIONES DE REGISTRO-->
						<div class="row mt-3">
							<div class="label">
								<label>¿Que tipo de operación desea registrar?</label>
							</div>
							<div class="input">
						    	<select class="form-control" name="opciones" id="opciones" onchange="desplegarOpciones(this.value);">
						    		<option value="0">Seleccione Opción</option>
						    		<option value="1">Operación Vehicular</option>
						    		<option value="2">Operación Personal</option>
						    	</select>
						    </div>
						</div>

					<!-- *********** OPERACION VEHICULAR ************* -->

					<!--FECHA DETALLE-->
						<div class="row mt-3" id="fechaDetalle" style="display: none;">
							<div class="label">
								<label>Fecha Detalle</label>
							</div>
							<div class="input">
							   <input type="date" name="fecha" id="fecha" class="form-control">
							</div>
					    </div>

					<!--VEHICULO-->
					    <div class="row mt-3" id="vehiculo" style="display: none;"> 
							<div class="label">
								<label>Vehiculo</label>
							</div>
							<div class="input">
							   <select class="form-control" name="id_vehiculo" id="id_vehiculo">
				                    <option value="0">Seleccione vehiculo</option>
				                    <?php foreach ($listarVehiculo as $v) { ?>
				                        <option value="<?php echo $v['id_vehiculo'] ?>">
				                            <?php echo $v['placa']?>
				                        </option>
				                    <?php } ?>
				                </select>
							</div>
					    </div>

					<!--OPERACION-->
					    <div class="row mt-3" id="operacion" style="display: none;">
							<div class="label">
								<label>Operación</label>
							</div>
							<div class="input">
							   <select class="form-control" name="id_operacion" id="id_operacion">
				                    <option value="0">Seleccione operación</option>
				                    <?php foreach ($listarO as $o) { ?>
				                        <option value="<?php echo $o['id_operacion'] ?>">
				                            <?php echo $o['nombre_operacion']?>
				                        </option>
				                     <?php } ?>
				                </select>
							</div>
					    </div>

					<!--PRECIO-->
					    <div class="row mt-3" id="precio" style="display: none;">
							<div class="label">
								<label>Precio</label>
							</div>
							<div class="input">
							    <input type="number" name="precio" id="precio" class="form-control">
							</div>
					    </div>

					<!-- *********** OPERACION PERSONAL ************* -->

					<!--DESCRIPCIÓN-->
						<div class="row mt-3" id="descripcionDetalleCosto" style="display: none;">
							<div class="label">
								<label>Descripción</label>
							</div>
							<div class="input">
							   <input type="text" name="descripcion" id="descripcion" class="form-control" required="true">
							</div>
					    </div>

					<!--NOMBRE PERSONA-->
						<div class="row mt-3" id="nombre" style="display: none;">
							<div class="label">
								<label>Nombre de la Persona o Entidad</label>
							</div>
							<div class="input">
							   <input type="text" name="nombre_persona" id="nombre_persona" class="form-control">
							</div>
					    </div>

					<!--FECHA DETALLE-->
						<div class="row mt-3" id="fechaDetalleCosto" style="display: none;">
							<div class="label">
								<label>Fecha Detalle</label>
							</div>
							<div class="input">
							   <input type="text" name="fecha_detalle" id="datepicker" class="form-control">
							</div>
					    </div>

					<!--PRECIO-->
					    <div class="row mt-3" id="precioDetalleCosto" style="display: none;">
							<div class="label">
								<label>Precio</label>
							</div>
							<div class="input">
							    <input type="number" name="precio_detalle_costo" id="precio_detalle_costo" class="form-control">
							</div>
					    </div>



			    <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	function desplegarOpciones(v){
	    	
	    	if (v == 1) {
	    		document.getElementById('fechaDetalle').style.display = 'flex';
	    		document.getElementById('vehiculo').style.display = 'flex';
	    		document.getElementById('operacion').style.display = 'flex';
	    		document.getElementById('precio').style.display = 'flex';

	    		document.getElementById('fecha').required = true;
	    		document.getElementById('id_vehiculo').required = true;
	    		document.getElementById('id_operacion').required = true;
	    		document.getElementById('precio').required = true;


	    		document.getElementById('descripcionDetalleCosto').style.display = 'none';
	    		document.getElementById('nombre').style.display = 'none';
	    		document.getElementById('fechaDetalleCosto').style.display = 'none';
	    		document.getElementById('precioDetalleCosto').style.display = 'none';


	    		document.getElementById('descripcion').required = false;
	    		document.getElementById('nombre_persona').required = false;
	    		document.getElementById('fecha_detalle').required = false;
	    		document.getElementById('precio_detalle_costo').required = false;
	    	}else if(v == 2){

	    		document.getElementById('descripcionDetalleCosto').style.display = 'flex';
	    		document.getElementById('nombre').style.display = 'flex';
	    		document.getElementById('fechaDetalleCosto').style.display = 'flex';
	    		document.getElementById('precioDetalleCosto').style.display = 'flex';


	    		document.getElementById('descripcion').required = true;
	    		document.getElementById('nombre_persona').required = true;
	    		document.getElementById('fecha_detalle').required = true;
	    		document.getElementById('precio_detalle_costo').required = true;




	    		document.getElementById('fechaDetalle').style.display = 'none';
	    		document.getElementById('vehiculo').style.display = 'none';
	    		document.getElementById('operacion').style.display = 'none';
	    		document.getElementById('precio').style.display = 'none';

	    		document.getElementById('fecha').required = false;
	    		document.getElementById('id_vehiculo').required = false;
	    		document.getElementById('id_operacion').required = false;
	    		document.getElementById('precio').required = false;
	    	}else{

	    		document.getElementById('fechaDetalle').style.display = 'none';
	    		document.getElementById('vehiculo').style.display = 'none';
	    		document.getElementById('operacion').style.display = 'none';
	    		document.getElementById('precio').style.display = 'none';

	    		document.getElementById('descripcionDetalleCosto').style.display = 'none';
	    		document.getElementById('nombre').style.display = 'none';
	    		document.getElementById('fechaDetalleCosto').style.display = 'none';
	    		document.getElementById('precioDetalleCosto').style.display = 'none';
	    	} 	
    	}

    	$( function() {

            $( "#datepicker" ).datepicker({ dateFormat:'yy/mm/dd'});
        } );

    </script>
</body>
</html>

