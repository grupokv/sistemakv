<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/Conductor.php");
require_once ("../Modelo/Usuario.php");

$programacion = new Programacion();
$vehiculo = new Vehiculo();
$conductor = new Conductor();
$usuario = new Usuario();

$listar_programaciones = $programacion->listar_programaciones();
$listarUnidadesOperativasProgramacion = $programacion->listarUnidadesOperativasProgramacion();
$listarVehiculos = $vehiculo->listarActivos();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Programación Servicios</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
  
  <style type="text/css">
      
    #dataTable tr td{
        font-size: .8rem;
    }

    .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
        background-color: #5e99b1;
        border: 2px solid #4c7b8f;
    }


    @media (max-width: 760px){
        .ui-tabs .ui-tabs-nav li{
            width: 100%;
            text-align: center;
        }
    }

  </style>
  <!--fin  styles -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    
    <section class="home_content">

        <div aria-label="breadcrumb" class="mt-1"> 
           <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Base Programaciones</li>
           </ol>
        </div>
        
        <div class="notice notice-sistemakv">
          <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">BASE PROGRAMACIONES</b></strong>
        </div>


        <div class="notice notice-sistemakv">
            <a href="registrarBaseProgramacion.php" id="buttonsKV" class="btn btn-outline-info">Crear Programación<i class="fa fa-plus ml-2"></i></a>

            <a href="programacion_servicios.php" id="buttonsKV" class="btn btn-outline-info">Servicios<i class="fa fa-search ml-2"></i></a>
        </div>
                    
        <div class="mt-2 p-4 table-responsive" id="tableR" style="background: #fff;">
            <table id="dataTable" class="table table-hover table-sm text-center" style="width:100%; ">
                <thead style="background-color: #1b2d3b; color: #fff;">
                    <tr class="text-center">
                        <th style="vertical-align: top;"></th>
                        <th style="vertical-align: top;">ID</th>
                        <th style="vertical-align: top;">CODIGO</th>
                        <th style="vertical-align: top;">PROYECTO</th>
                        <th style="vertical-align: top;">UNIDAD OPERATIVA</th>
                        <th style="vertical-align: top;">LOCALIDAD</th>
                        <th style="vertical-align: top;">E/S</th>
                        <th style="vertical-align: top;">PUNTO INICIO</th>
                        <th style="vertical-align: top;">PUNTO FINAL</th>
                        <th style="vertical-align: top;">HORA</th>
                        <th style="vertical-align: top;">FRECUENCIA</th>
                        <th style="vertical-align: top;">OBSERVACIONES</th>
                        <th style="vertical-align: top;">CAPACIDAD</th>
                        <th style="vertical-align: top;">MONITORA</th>
                        <th style="vertical-align: top;">CONTACTO MONITORA</th>
                        <!--<th style="vertical-align: top;">NOVEDADES</th>-->
                        <th style="vertical-align: top;">PLACA FACT</th>
                        <th style="vertical-align: top;">PLACA LIQ</th>
                        <th style="vertical-align: top;">CAPACIDAD VEHICULO</th>
                        <th style="vertical-align: top;">PROPIETARIO</th>
                        <th style="vertical-align: top;">CONDUCTOR</th>
                        <th style="vertical-align: top;">CONTACTO CONDUCTOR</th>
                        <th style="vertical-align: top;">VALOR PAGAR VEHÍCULO</th>
                        <th style="vertical-align: top;">VALOR PAGAR MONITORA</th>
                        <th style="vertical-align: top;">VALOR FACTURAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listar_programaciones as $lps){ ?>
                        
                        <tr class="text-center">
                            <td><a href="actualizarBaseProgramacion.php?id=<?php echo $lps['id_programacion']; ?>"><i class="fa fa-edit" style="color: darkcyan; cursor: pointer; font-size: 1.3rem;"></i></a></td>
                            <td><strong><?php echo $lps['id_programacion']; ?></strong></td>
                            <td><strong><?php echo $lps['codigo_identificativo']; ?></strong></td>
                            <td><?php echo $lps['proyecto']; ?></td>
                            <td><?php $listarUnidadOperativaId = $programacion->listarUnidadOperativaId( $lps['unidad_operativa']); echo $listarUnidadOperativaId[0]['unidad_operativa']; ?></td>
                            <td><?php echo $lps['localidad']; ?></td>
                            <td><b><?php echo $lps['entrada_salida']; ?></b></td>
                            <td><?php echo strtoupper($lps['punto_inicio']); ?></td>
                            <td><?php echo strtoupper($lps['punto_final']); ?></td>
                            <td>
                                <?php 
                                    echo strtoupper(date('g:i a', strtotime($lps['horario']))); 
                                ?>       
                            </td>
                            <td><?php echo $lps['frecuencia']; ?></td>
                            <td><?php echo $lps['observaciones']; ?></td>
                            <td><?php echo $lps['capacidad_servicio']; ?></td>
                            <td><?php echo strtoupper($lps['nombre_monitora']); ?></td>
                            <td><?php echo $lps['telefono_monitora']; ?></td>
                            <!-- <td><?php echo $lps['novedades']; ?></td> -->
                            <td>
                                <?php if ($lps['id_vehiculo_facturacion'] != 0){ ?>
                                    <a style="color: darkcyan; cursor: pointer;" data-toggle="modal" data-target="#vehiModal" onclick="modal(<?php echo $lps['id_vehiculo_facturacion'];?>)">
                                        <?php 
                                            $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_facturacion']);
                                            echo $listarVehiculoID[0]['placa']; 
                                        ?>
                                    </a>
                                <?php } ?>
                                
                            </td>
                            <td>
                                <?php if ($lps['id_vehiculo_liquidacion'] != 0){ ?>
                                    <a style="color: darkcyan; cursor: pointer;" data-toggle="modal" data-target="#vehiModal" onclick="modal(<?php echo $lps['id_vehiculo_liquidacion'];?>)">
                                        <?php 
                                            $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_liquidacion']);
                                            echo $listarVehiculoID[0]['placa']; 
                                        ?>
                                    </a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php 
                                    $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_liquidacion']);
                                    echo $listarVehiculoID[0]['cant_pasajeros']; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_liquidacion']);
                                    $listarUsuarioPorId = $usuario->listarUsuarioPorId($listarVehiculoID[0]['id_propietario']);
                                    echo $listarUsuarioPorId[0]['nombre']; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $listarConductorID = $conductor->listarPorId($lps['id_conductor']);
                                    echo $listarConductorID[0]['nombre_conductor']; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $listarConductorID = $conductor->listarPorId($lps['id_conductor']);
                                    echo $listarConductorID[0]['telefono1']; 
                                ?>
                            </td>
                            <td><?php echo "<b>$</b> " . number_format($lps['valor_pagar']); ?></td>
                            <td><?php echo "<b>$</b> " . number_format($lps['valor_pagar_monitora']); ?></td>
                            <td><?php echo "<b>$</b> " . number_format($lps['valor_facturar']); ?></td>
                        
                                
                        </tr>

                    <?php } ?>
                </tbody>
            </table>

        </div>

    </section>
    
    <!-- FIN CONTENIDO -->

    <!------------------------------------------------------->
    <!------------------------------------------------------->
    <!------------------------------------------------------->


    <!------------------------------------------------------->
    <!--------------------- MODALES ------------------------->
    <!------------------------------------------------------->

    <!-- MODAL DOCUMENTACIÓN VEHICULO -->
        <div class="modal fade" id="vehiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #5e99b1; color: #fff;">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.3rem;">DOCUMENTACIÓN VEHICULO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" color: #fff;">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section id="contenido_modal" class="col-12"></section>
                    </div>
                </div>
            </div>
        </div>

    <!-- script -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

        $(document).ready(function() {
            
            $('#dataTable').DataTable({
                "scrollX": true, 
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
            });
        });



        function modal(id_vehiculo){
            //alert(id_vehiculo);

            var parametros = {
                "id_vehiculo" : id_vehiculo
            };

            $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/listarDocsVehiculo.php', //archivo que recibe la peticion
                type:  'post', //método de envio
                beforeSend: function () {
                        $("#contenido_modal").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    //alert(response);
                    $("#contenido_modal").html(response);
                }
            });
        }


    </script>

</body>
</html>