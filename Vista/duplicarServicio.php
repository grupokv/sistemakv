<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
require_once("../Modelo/TipoServicio.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Conductor.php");

$id_servicio = $_GET['ids'];

/* VARIABLES MENU*/
$titulo = '';
$redireccion = '';
$icono = '';
$id = '';


$titulo .= 'Duplicar  Servicio';
$redireccion .= 'asignaciones.php';
$icono .= 'fa fa-car';

$programacion = new Programacion();
$tipo_servicio = new TipoServicio();
$tipovehiculo = new TipoVehiculo();
$vehiculo = new Vehiculo();
$conductor = new Conductor();


$listarTiposServicios = $tipo_servicio->listarCliente();
$listarTiposVehiculos = $tipovehiculo->listar();

/*LISTAR SERVICIO*/
$datos_servicio = $programacion->serviciosPorIdDetalle($id_servicio);


/*LISTAR ASIGNACION DE VEHICULO POR ID */
$listarAsignacionPorId = $programacion->listarAsignacionPorId($id_servicio);

/*VEHICULOS*/
$listado_vehiculos = $vehiculo->listar();
$listado_conductores = $conductor->listarPorId($listarAsignacionPorId[0]['id_conductor']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Duplicar Servicio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="asignaciones.php">Servicios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Duplicar Servicio</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

            	<?php include("Template/header-form.php"); ?>
	          	<form method="POST" action="../Controlador/duplicarServicio.php" class="p-4" enctype="multipart/form-data">
              		<input type="hidden" name="id_servicio" value="<?php echo $id_servicio;?>">
                   
                   <div id="tabs">
	                    <ul>
	                      <li><a href="#tabs-1">Información Servicio </a></li>
	                      <li><a href="#tabs-2">Asignación vehiculo </a></li>
	                    </ul>

	                    <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $datos_servicio[0]['id_solicitud'] ?>">
	                    <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $datos_servicio[0]['id_cliente'] ?>">
	                    <input type="hidden" name="tipo" id="tipo" value="<?php echo $datos_servicio[0]['tipo'] ?>">
	                    <input type="hidden" name="id_contrato" id="id_contrato" value="<?php echo $listarAsignacionPorId[0]['id_contrato'] ?>">
	                    <input type="hidden" name="id_proyecto" id="id_proyecto" value="<?php echo $listarAsignacionPorId[0]['id_proyecto'] ?>">
	                    <input type="hidden" name="id_tarifa_proyecto" id="id_tarifa_proyecto" value="<?php echo $listarAsignacionPorId[0]['id_tarifa_proyecto'] ?>">

	                    <!-- INFORMACION BASICA-->
	                        <div id="tabs-1">

                    			<!-- Fecha Servicio -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Fecha</label>
				                        </div>
				                        <div class="col-10">    
				                            <input type="text" name="fecha_servicio[]" id="fecha_servicio" class="form-control" value="0" placeholder="Seleccione Fechas" onfocus="validar(this.value)" onblur="validar(this.value)">
				                        </div>
				                    </div>

                   				<!-- Hora Servicio -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Hora</label>
				                        </div>
				                        <div class="col-10">    
				                                <input type="text" id="hora_servicio" name="hora_servicio" data-target="#hora_servicio" class="form-control datetimepicker" data-target="#hora_servicio" data-toggle="datetimepicker" autocomplete="off" required="required"  value="<?php echo $datos_servicio[0]['hora_servicio'];?>"/>
				                        </div>
				                    </div>

                    			<!-- Cantidad Pasajeros -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Cantidad Pasajeros</label>
				                        </div>
				                        <div class="col-10">    
				                                <input type="text" id="cant_pax" name="cant_pax" class="form-control" onKeyPress="return solo_numeros(event)" required="required" value="<?php echo $datos_servicio[0]['cantidad'];?>" readonly/>
				                                
				                        </div>
				                    </div>
                    
                    			<!-- Nombre Contacto -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Nombre Contacto</label>
				                        </div>
				                        <div class="col-10">    
				                                <input type="text" id="nombre_contacto" name="nombre_contacto" class="form-control" onKeyPress="return solo_letras(event)" required="required" value="<?php echo $datos_servicio[0]['contacto'];?>" readonly/>
				                                
				                        </div>
				                    </div>

                    			<!-- Telefono Contacto -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Teléfono Contacto</label>
				                        </div>
				                        <div class="col-10">    
				                                <input type="text" id="telefono_contacto" name="telefono_contacto" class="form-control" onKeyPress="return solo_numeros(event)" required="required" value="<?php echo $datos_servicio[0]['telefono_contacto'];?>" readonly/>
				                                
				                        </div>
				                    </div>

                    			<!-- Listado Pasajeros -->
				                    <input type="hidden" name="listado_act" id="listado_act" value="<?php echo $datos_servicio[0]['listado'];?>">
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Listado Pasajeros</label>
				                        </div>
				                        <div class="col-10">    
				                                <input type="file" id="listado_pax" name="listado_pax" class="form-control" readonly/>
				                                
				                        </div>
				                    </div>

				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Listado Actual</label>
				                        </div>
				                        <div class="col-10">    
				                        	<?php if($datos_servicio[0]['listado'] != ''){ ?>
				                        	<a href="http://186.155.38.170:91/Conductores/<?php echo $datos_servicio[0]['listado'];?>" target="_blank"><?php echo $datos_servicio[0]['listado'];?></a>
				                        	<?php } else { ?>
				                        	<?php echo "No hay listado cargado";?>
				                        	<?php } ?>
				                        </div>
				                    </div>

                    			<!-- Ciudad / Municipio -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Ciudad / Municipio</label>
				                        </div>
				                        <div class="col-10">    
				                                <input type="text" id="ciudad" name="ciudad" class="form-control" required="required"  value="<?php echo $datos_servicio[0]['ciudad'];?>" readonly/>
				                                
				                        </div>
				                    </div>

                    			<!-- Origen -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Origen</label>
				                        </div>
				                        <div class="col-10">    
				                            <input type="text" id="origen" name="origen" class="form-control" required="required"  value="<?php echo $datos_servicio[0]['origen'];?>" readonly/>
				                        </div>
				                    </div>

                    			<!-- Destino -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Destino</label>
				                        </div>
				                        <div class="col-10">    
				                            <input type="text" id="destino" name="destino" class="form-control" required="required" value="<?php echo $datos_servicio[0]['destino'];?>" readonly/>
				                        </div>
				                    </div>

                    			<!-- Tipo Servicio -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Tipo de Servicio</label>
				                        </div>
				                        <div class="col-10">    
				                           <select class="form-control" name="id_tiposervicio" id="id_tiposervicio" required="required" readonly>
				                                <option>Seleccionar </option>
				                                <?php foreach ($listarTiposServicios as $lt){ ?>
				                                  <option value="<?php echo $lt['id_tipo_servicio']; ?>" <?php if($datos_servicio[0]['id_tiposervicio'] == $lt['id_tipo_servicio']){ ?> selected="selected" <?php } ?> >
				                                    <?php echo $lt['nombre_tipo_servicio']; ?>
				                                  </option>
				                                <?php } ?>
				                              </select>
				                        </div>
				                    </div>

                    			<!-- Tipo Vehiculo -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label for="speed">Tipo de Vehiculo</label>
				                        </div>
				                        <div class="col-10">
				                              <select class="form-control" name="id_tipovehiculo" id="id_tipovehiculo" required="required" readonly>
				                                <option value="">Seleccionar </option>
				                                <?php foreach ($listarTiposVehiculos as $lc){ ?>
				                                  <option value="<?php echo $lc['id_tipo_vehiculo']; ?>" <?php if($datos_servicio[0]['id_tipovehiculo'] == $lc['id_tipo_vehiculo']){ ?> selected="selected" <?php } ?>>
				                                    <?php echo $lc['nombre_tipo_vehiculo']; ?>
				                                  </option>
				                                <?php } ?>
				                              </select>
				                        </div>
				                    </div>

								<!-- Centro Costo -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Centro de Costos</label>
				                        </div>
				                        <div class="col-10">    
				                            <input type="text" id="centro_costo" name="centro_costo" class="form-control" required="required" value="<?php echo $datos_servicio[0]['centro_costo'];?>" readonly/>
				                        </div>
				                    </div>

                    			<!-- Solicitante -->
				                    <div class="row col-12 mb-4">
				                        <div class="col-2 text-center">    
				                            <label>Solicitante</label>
				                        </div>
				                        <div class="col-10">    
				                            <input type="text" id="solicitante" name="solicitante" class="form-control" required="required" value="<?php echo $datos_servicio[0]['solicitante'];?>" readonly/>
				                        </div>
				                    </div>
	                   		</div>

	                   	<!-- ASIGNACION VEHICULO-->	
	                   		<div id="tabs-2">

	                   			<!-- Tipo Vehiculo-->
			                        <div class="row mt-3 mb-4">
			                            <div class="label">
			                                <label>Tipo Vehiculo Cliente</label>
			                            </div>
			                            <div class="input">
			                                <?php $tipov = $tipovehiculo->listarPorId($datos_servicio[0]['id_tipovehiculo']); echo $tipov[0]['nombre_tipo_vehiculo'];?>
			                            </div>
			                        </div>

								<!-- Cant Pasajeros-->
			                        <div class="row mt-3 mb-4">
			                            <div class="label">
			                                <label>Cantidad Pasajeros</label>
			                            </div>
			                            <div class="input">
			                                <?php echo $datos_servicio[0]['cantidad'];?>
			                            </div>
			                        </div>

			                    <!-- Vehiculo -->
			                        <div class="row mt-3 mb-4">
			                            <div class="label">
			                                <label>Vehiculo</label>
			                            </div>
			                            <div class="input">
			                                <select name="id_vehiculo" id="id_vehiculo" required="required" class="form-control" readonly >
			                                    <option value="" selected="selected">SELECCIONAR</option>
			                                    <?php foreach($listado_vehiculos as $lp){ ?>
			                                    	<option value="<?php echo $lp['id_vehiculo'];?>" <?php if( $lp['id_vehiculo'] == $listarAsignacionPorId[0]['id_vehiculo']){ ?> selected="selected" <?php } ?>><?php echo $lp['placa'].' | '.$lp['numero_movil'];?></option>
			                                    <?php } ?>
			                                    <option value="0">LISTAR TODOS</option>
			                                </select>
			                            </div>
			                        </div>

			                    <!-- Conductor --> 
			                        <div class="row mt-3 mb-4">
			                            <div class="label">
			                                <label>Conductor</label>
			                            </div>
			                            <div class="input">
			                                <select name="id_conductor" id="id_conductor" class="form-control"  required="required" readonly >
			                                    <option value="">SELECCIONAR</option>
			                                    <?php foreach ($listado_conductores as $lci){ ?>
			                                    	<option value="<?php echo $lci['id_conductor'];?>" <?php if( $lci['id_conductor'] == $listarAsignacionPorId[0]['id_conductor']){ ?> selected="selected" <?php } ?>> <?php echo $lci['nombre_conductor'] ?></option>
			                                    <?php } ?>
			                                </select>
			                            </div>
			                        </div>

			                    <!-- Tarifa Vehiculos -->
			                        <div class="row mt-3 mb-4">
			                            <div class="label">
			                                <label>Tarifa Vehiculo</label>
			                            </div>
			                            <div class="input">
			                                <input type="text" name="costo" id="costo" class="form-control"  required="required" value="<?php echo $listarAsignacionPorId[0]['costo'] ?>" >
			                            </div>
			                        </div>
	                   		</div>

                    <hr>

                    <!-- BOTONES -->
                    <div class="row d-flex justify-content-center mt-4">
                      <div class="col-3">
                         <a type="submit" href="<?php echo $redireccion;?>" class="btn btn-danger btn-block">CANCELAR</a>
                      </div>
                      <div class="col-3">
                          <input type="submit" class="btn btn-ingresar btn-block" value="Duplicar"></input>
                      </div>
                    </div>
            </form>
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>
    <!--INICIO INPUT HORA-->
<script type="text/javascript" src="../Resources/js/moment/moment.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<!--FIN INPUT HORA-->

	<script type="text/javascript">


        $(function () {
            $('#hora_servicio').datetimepicker({
              format: 'LT'
            });
        });

        $(function () {
            $('#fecha_servicio').multiDatesPicker({
                dateFormat: "yy-mm-dd"
            });

        });


        $( function() {
          $( "#tabs" ).tabs();
        } ); 

         

        function checkSubmit() {
        if (!enviando) {
            enviando = true;
            return true;
        } else {
            alert("El formulario ya se esta enviando");
            return false;
        }
    } 

  </script>
</body>
</html>