<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicio.php");

$id_servicio = $_GET['id_s'];

$programacion = new Programacion();
$tipoServicio = new TipoServicio();
$tipoVehiculo = new TipoVehiculo();

$listarServicio = $programacion->listarDetallesServiciosPorId($_GET['id_s']);

$listarTiposServicios = $tipoServicio->listarCliente();
$listarTiposVehiculos = $tipoVehiculo->listar();

$titulo = 'Registrar Servicio';
$redireccion = 'programacion_solicitudes.php';
$icono = 'fa fa-car';

  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Duplicar Servicio</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php"); ?>
  <link rel="stylesheet" href="../Resources/css/registrarUsuario.css">
</head>
<body>
    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="programacion_solicitudes.php">Solicitudes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Duplicar Servicio</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="col-10 formulario mb-5">
            <div class="row" style="height: 60px; background-color: #5e99b1; ">
              <div class="col-">
                <h2 class="ml-4 mt-2" style="color: #fff;"><span class="<?php echo $icono;?>" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Duplicar Servicio</h2>
              </div>
            </div>
            <hr>
            <!-- Formulario -->
            <form method="POST" action="../Controlador/registrarServicio.php" class="p-4" enctype="multipart/form-data">
                
                <?php foreach ($listarServicio as $lt){ ?>
                    
                    <input type="hidden" name="duplicar" id="duplicar" class="form-control" value="1">
                    <input type="hidden" name="id_solicitud" value="<?php echo $lt['id_solicitud'];?>">
                    <input type="hidden" name="id_cliente" value="<?php echo $lt['id_cliente'];?>">
                    <!-- Tipo Servicio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Tipo Servicio</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" class="form-control" name="tipo" value="<?php echo $lt['tipo'];?>" readonly="readonly">
                        </div>
                    </div>

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
                                <input type="text" id="hora_servicio" name="hora_servicio" data-target="#hora_servicio" class="form-control datetimepicker" data-toggle="datetimepicker" required="required" value="<?php echo $lt['hora_servicio'] ?>" />
                        </div>
                    </div>

                    <!-- Cantidad Pasajeros -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Cantidad Pasajeros</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="cant_pax" name="cant_pax" class="form-control" onKeyPress="return solo_numeros(event)"  value="<?php echo $lt['cantidad'] ?>" required="required" />
                                
                        </div>
                    </div>
                    
                    <!-- Nombre Contacto -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Nombre Contacto</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="nombre_contacto" name="nombre_contacto" class="form-control" onKeyPress="return solo_letras(event)" value="<?php echo $lt['contacto'] ?>" required="required"/>
                                
                        </div>
                    </div>

                    <!-- Telefono Contacto -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Teléfono Contacto</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="telefono_contacto" name="telefono_contacto" class="form-control" onKeyPress="return solo_numeros(event)" value="<?php echo $lt['telefono_contacto'] ?>" required="required"/>
                                
                        </div>
                    </div>

                    <!-- Listado Pasajeros -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Listado Pasajeros</label>
                        </div>
                        <div class="col-10">    
                                <input type="file" id="listado_pax" name="listado_pax" class="form-control" />
                                
                        </div>
                    </div>

                    <!-- Ciudad / Municipio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Ciudad / Municipio</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="ciudad" name="ciudad" class="form-control" value="<?php echo $lt['ciudad'] ?>" required="required"/>
                                
                        </div>
                    </div>

                    <!-- Origen -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Origen</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="origen" name="origen" class="form-control" value="<?php echo $lt['origen'] ?>" required="required"/>
                        </div>
                    </div>

                    <!-- Destino -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Destino</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="destino" name="destino" class="form-control" value="<?php echo $lt['destino'] ?>" required="required"/>
                        </div>
                    </div>

                    <!-- Tipo Servicio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Tipo de Servicio</label>
                        </div>
                        <div class="col-10">    
                           <select class="form-control" name="id_tiposervicio" id="id_tiposervicio" required="required">
                                <?php foreach ($listarTiposServicios as $lts){ ?>
                                  <option value="<?php echo $lts['id_tipo_servicio']; ?>" <?php if($lt['id_tiposervicio'] == $lts['id_tipo_servicio']){ ?> selected="selected" <?php } ?>>
                                    <?php echo $lts['nombre_tipo_servicio']; ?>
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
                                <?php foreach ($listarTiposVehiculos as $lc){ ?>
                                  <option value="<?php echo $lc['id_tipo_vehiculo']; ?>" <?php if($lt['id_tipovehiculo'] == $lc['id_tipo_vehiculo']){ ?> selected="selected" <?php } ?>>
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
                            <input type="text" id="centro_costo" name="centro_costo" class="form-control" value="<?php echo $lt['centro_costo'] ?>" required="required"/>
                        </div>
                    </div>

                    <!-- Solicitante -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Solicitante</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="solicitante" name="solicitante" class="form-control" value="<?php echo $lt['solicitante'] ?>" required="required"/>
                        </div>
                    </div>

                    <hr>

                    <!-- BOTONES -->
                    <div class="row d-flex justify-content-center mt-4">
                      <div class="col-3">
                         <a type="submit" href="<?php echo $redireccion;?>" class="btn btn-danger btn-block">CANCELAR</a>
                      </div>
                      <div class="col-3">
                          <input type="submit" class="btn btn-ingresar btn-block" value="Registrar"></input>
                      </div>
                    </div>

                <?php } ?>
            </form>
        </div>
    </section>



    
    <!-- FIN CONTENIDO -->


  <!-- script -->
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
 $('#fecha_servicio').multiDatesPicker({
                dateFormat: "yy-mm-dd"
            });
        function validar(valor){
            if(valor == ''){
                 document.getElementById("fecha_servicio").required = true;
            } else {
                 document.getElementById("fecha_servicio").required = false;
            }
            
        }
  </script>
  
</body>
</html>