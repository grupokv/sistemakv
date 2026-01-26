<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
require_once("../Modelo/TipoServicio.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Cliente.php");

$id_servicio = $_GET['ids'];

/* VARIABLES MENU*/
$titulo = 'Actualizar  Servicio';
$redireccion = 'programacion_solicitudes.php';
$icono = 'fa fa-car';

$programacion = new Programacion();
$tipo_servicio = new TipoServicio();
$tipo_vehiculo = new TipoVehiculo();
$listarTiposServicios = $tipo_servicio->listarCliente();
$listarTiposVehiculos = $tipo_vehiculo->listar();

$datos_servicio = $programacion->serviciosPorIdDetalle($id_servicio);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Servicio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="programacion_solicitudes.php">Solicitudes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Servicio</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	          <form method="POST" action="../Controlador/actualizarServicio.php" class="p-4" enctype="multipart/form-data">
              <input type="hidden" name="id_servicio" value="<?php echo $id_servicio;?>">
                   

                    <!-- Fecha Servicio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Fecha</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" name="fecha_servicio" id="datepicker" class="form-control" autocomplete="off" required="required" value="<?php echo $datos_servicio[0]['fecha_servicio'];?>">
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
                                <input type="text" id="cant_pax" name="cant_pax" class="form-control" onKeyPress="return solo_numeros(event)" required="required" value="<?php echo $datos_servicio[0]['cantidad'];?>"/>
                                
                        </div>
                    </div>
                    
                    <!-- Nombre Contacto -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Nombre Contacto</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="nombre_contacto" name="nombre_contacto" class="form-control" onKeyPress="return solo_letras(event)" required="required" value="<?php echo $datos_servicio[0]['contacto'];?>"/>
                                
                        </div>
                    </div>

                    <!-- Telefono Contacto -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Teléfono Contacto</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="telefono_contacto" name="telefono_contacto" class="form-control" onKeyPress="return solo_numeros(event)" required="required" value="<?php echo $datos_servicio[0]['telefono_contacto'];?>"/>
                                
                        </div>
                    </div>

                    <!-- Listado Pasajeros -->
                    <input type="hidden" name="listado_act" id="listado_act" value="<?php echo $datos_servicio[0]['listado'];?>">
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Listado Pasajeros</label>
                        </div>
                        <div class="col-10">    
                                <input type="file" id="listado_pax" name="listado_pax" class="form-control" />
                                
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
                                <input type="text" id="ciudad" name="ciudad" class="form-control" required="required"  value="<?php echo $datos_servicio[0]['ciudad'];?>"/>
                                
                        </div>
                    </div>

                    <!-- Origen -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Origen</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="origen" name="origen" class="form-control" required="required"  value="<?php echo $datos_servicio[0]['origen'];?>"/>
                        </div>
                    </div>

                    <!-- Destino -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Destino</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="destino" name="destino" class="form-control" required="required" value="<?php echo $datos_servicio[0]['destino'];?>"/>
                        </div>
                    </div>

                    <!-- Tipo Servicio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Tipo de Servicio</label>
                        </div>
                        <div class="col-10">    
                           <select class="form-control" name="id_tiposervicio" id="id_tiposervicio" required="required">
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
                              <select class="form-control" name="id_tipovehiculo" id="id_tipovehiculo" required="required">
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
                            <input type="text" id="centro_costo" name="centro_costo" class="form-control" required="required" value="<?php echo $datos_servicio[0]['centro_costo'];?>"/>
                        </div>
                    </div>

                    <!-- Solicitante -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Solicitante</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="solicitante" name="solicitante" class="form-control" required="required" value="<?php echo $datos_servicio[0]['solicitante'];?>"/>
                        </div>
                    </div>

                    <hr>

                    <!-- BOTONES -->
                    <div class="row d-flex justify-content-center mt-4">
                      <div class="col-3">
                         <a type="submit" href="<?php echo $redireccion;?>" class="btn btn-danger btn-block">CANCELAR</a>
                      </div>
                      <div class="col-3">
                          <input type="submit" class="btn btn-ingresar btn-block" value="Actualizar"></input>
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

        $( function() {
            $( "#datepicker" ).datepicker({
              changeMonth: true,
              changeYear: true,
              minDate: '-0D',
              dateFormat:'yy/mm/dd'
            });
        } );

        $(function () {
            $('#hora_servicio').datetimepicker({
              format: 'LT'
            });
        });
  </script>
</body>
</html>