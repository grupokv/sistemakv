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

$listarUnidadesOperativasProgramacion = $programacion->listarUnidadesOperativasProgramacion();

if ($_POST) {
    if ($_POST['fecha_inicial'] != '') {
        $fecha_inicial = $_POST['fecha_inicial'];
    }else{
        $fecha_inicial = "0000-00-00";
    }

    if ($_POST['fecha_final'] != '') {
        $fecha_final = $_POST['fecha_final'];
    }else{
        $fecha_final = "9999-99-99";
    }

    if ($_POST['proyecto'] != '') {
        $proyecto = $_POST['proyecto'];
    }else{
        $proyecto = "%%";
    }

    if ($_POST['unidad_operativa'] != '') {
        $unidad_operativa = $_POST['unidad_operativa'];
    }else{
        $unidad_operativa = "%%";
    }

    $listar_programaciones = $programacion->listarFiltroServicioProgramaciones($fecha_inicial, $fecha_final, $proyecto, $unidad_operativa);
}



?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Reportes Servicios</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style type="text/css">
              
            .barra-principal{
              background-color: #5e99b1;
              width: 100%;
              border-radius: 5px;
            }

            .botones_principal{
              display: flex;
              justify-content: flex-end;
            }

            .boton-registro{
              background-color: #fff; 
              height: 40px; 
              margin-top: 10px; 
              margin-bottom: 10px; 
              color: #5e99b1;
              cursor: pointer;
            }

            .boton-registro:hover{
                color: #5e99b1;
            }

            #btnFiltro, #btnRegistro, #btnActivar{
                margin-right: 10px;
            }

            #dataTable tr td{
                font-size: .8rem;
            }

            .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
                background-color: #5e99b1;
                border: 2px solid #4c7b8f;
            }



            @media (max-width: 760px){
              
                .fa-plus{
                    display: none;
                }

                .titulo_principal{
                    margin-top: 10px;
                    text-align: center;

                }

                .titulo_principal h2{
                    margin-left: 0px !important;
                }

                .botones_principal{
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    margin-bottom: 10px;
                    margin-top: 10px;
                }

                #iconoModulo{
                    display: none;
                }

                #btnFiltro, #btnRegistro, #btnActivar{
                    margin-right: 0px;
                    width: 100%;
                }

                .ui-tabs .ui-tabs-nav li{
                    width: 100%;
                    text-align: center;
                }

            }
        </style>
    <!-- FIN STYLES -->

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
                 <ol class="breadcrumb" style="background-color: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="programacion_servicios.php">Servicios Programados</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Reportes</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-file-text mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REPORTES SERVICIOS</b></strong>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%">
                <p>FILTRAR REPORTE</p>
            </div>

        <form action="" method="POST" style="background-color: #fff;">
            <hr style="background-color:#f2f2f2; width: 100%;">
                <div class="row p-4 m-1 d-flex justify-content-center">
                    <div class="col-sm-12 col-md-2 col-lg-2 m-1">
                        <label><b>FECHA INICIAL</b></label>
                        <input type="text" name="fecha_inicial" id="datepicker" class="form-control">
                    </div>
                    
                    <div class="col-sm-12 col-md-2 col-lg-2 m-1">
                        <label><b>FECHA FINAL</b></label>
                        <input type="text" name="fecha_final" id="datepicker1" class="form-control">
                    </div>
                    
                    <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                        <label><b>PROYECTO</b></label>
                        <select name="proyecto" id="preoyecto" class="form-control selectpicker" data-live-search="true" > 
                            <option value="">SELECCIONAR</option>
                            <option value="VEJEZ">VEJEZ</option>
                            <option value="DISCAPACIDAD">DISCAPACIDAD</option>
                            <option value="EMPRESARIAL">EMPRESARIAL</option>
                            <option value="INFANCIA">INFANCIA</option>
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-3 m-1">
                        <label><b>UNI. OPERATIVA</b></label>
                        <select name="unidad_operativa" id="unidad_operativa" class="form-control selectpicker" data-live-search="true" > 
                            <option value="">SELECCIONAR</option>
                            <?php foreach ($listarUnidadesOperativasProgramacion as $uop){ ?>
                                <option value="<?php echo $uop['unidad_operativa'] ?>"><?php echo utf8_encode($uop['unidad_operativa']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                
                </div>
                
                
                <div class="col-12 p-1 m-1 d-flex justify-content-center">
                    <div class="col-lg-3 col-md-3 col-sm-10 col-xs-10">
                        <button type="submit" class="btn btn-outline-info btn-block mr-4 mt-4"><i class="fa fa-search ml-2 mr-2"></i>Filtrar</button>
                    </div>
                </div> 
        </form>

        <div class="col-12 d-flex justify-content-center"  style="background-color: #fff;">
            <div class="col-lg-3 col-md-3 col-sm-10 col-xs-10">
                <form action="reporteServiciosProgramacion.php" method="POST">
                    <input type="hidden" id="fecha_inicialReport" name="fecha_inicialReport" class="form-control" value="<?php echo $fecha_inicial ?>">
                    <input type="hidden" id="fecha_finalReport" name="fecha_finalReport" class="form-control" value="<?php echo $fecha_final ?>">
                    <input type="hidden" id="proyectoReport" name="proyectoReport" class="form-control" value="<?php echo $proyecto ?>">
                    <input type="hidden" id="unOperativaReport" name="unOperativaReport" class="form-control" value="<?php echo $unidad_operativa ?>">
                    
                    <button type="submit" class="btn btn-outline-success btn-block m-2"><i class="fa fa-file-excel-o ml-2 mr-2"></i>Exportar</button>
                </form>
            </div>
        </div>

        <div class="mt-2 p-4 mb-4 table-responsive" id="tableR" style="background-color: #fff;">
            <table id="dataTable" class="table table-hover table-sm display" style="width:100%;">
                <thead style="background-color: #1b2d3b; color: #fff;">
                    <tr class="text-center">
                        <th style="vertical-align: top;"></th>
                        <th style="vertical-align: top;">ESTADO</th>
                        <th style="vertical-align: top;">CODIGO</th>
                        <th style="vertical-align: top;">FECHA</th>
                        <th style="vertical-align: top;">PROYECTO</th>
                        <th style="vertical-align: top;">UN. OPERATIVA</th>
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
                        <th style="vertical-align: top;">NOVEDADES</th>
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
                            <td><a href="actualizarServicioProgramacion.php?id=<?php echo $lps['id_programacion']; ?>"><i class="fa fa-edit" style="color: darkcyan; cursor: pointer; font-size: 1.3rem;"></i></a></td>
                            
                            <?php if($lps['estado'] == 'A'){ ?>
                                <td style=" font-size: .9rem; color: green;" ><strong>ACTIVO</strong></td>
                            <?php } else if($lps['estado'] == 'F'){ ?>
                                <td style=" font-size: .9rem; color: #db2a2a;" ><strong>FINALIZADO</strong></td>
                            <?php } else { ?>
                                <td style=" font-size: .9rem; color: #f5c127;" ><strong>CANCELADO</strong></td>
                            <?php } ?>

                            <td><strong><?php echo $lps['codigo_identificativo']; ?></strong></td>
                            <td><strong><?php echo $lps['fecha']; ?></strong></td>
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
                            <td><?php echo $lps['novedades']; ?></td>
                            <td>
                                <?php 
                                    $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_facturacion']);
                                    echo $listarVehiculoID[0]['placa']; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_liquidacion']);
                                    echo $listarVehiculoID[0]['placa']; 
                                ?>
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
    

    <!-- FIN CONTENIDO -->

    <!------------------------------------------------------->
    <!------------------------------------------------------->
    <!------------------------------------------------------->

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

        $( function() {
            $("#datepicker").datepicker({ dateFormat:'yy-mm-dd'});
            $("#datepicker1").datepicker({ dateFormat:'yy-mm-dd'});
        } );


    </script>

</body>
</html>