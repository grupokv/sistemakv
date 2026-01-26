<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ('../Modelo/Vehiculo.php');
require_once ('../Modelo/Usuario.php');
require_once ('../Modelo/General.php');

$vehiculo = new Vehiculo();
$usuario = new Usuario();

$hoy = date('Y-m-d');

$listarVehiculos = $vehiculo->listarActivos();

if($_POST){

    $id_modulo = 11;

    if ($_POST['fecha_inicial_reporte'] == '') {
        $fecha_inicial_reporte = '0000-00-00';
    }else{
        $fecha_inicial_reporte = $_POST['fecha_inicial_reporte'];
    }

    if ($_POST['fecha_final_reporte'] == '') {
        $fecha_final_reporte = '9999-12-31';
    }else{
        $fecha_final_reporte = $_POST['fecha_final_reporte'];
    }

    if ($_POST['id_vehiculo'] == '') {
        $id_vehiculo = '%%';
    }else{
        $id_vehiculo = $_POST['id_vehiculo'];
    }

    if ($_POST['tipo_actividad'] == '') {
        $tipo_actividad = '%%';
    }else{
        $tipo_actividad = $_POST['tipo_actividad'];
    }


} 

$filtroActualizacionesDocs = $vehiculo->filtroActualizacionesDocs($fecha_inicial_reporte, $fecha_final_reporte, $tipo_actividad, $id_modulo, $id_vehiculo);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Reporte Vehiculos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style type="text/css" media="screen">


            .barra-principal{
                background-color: #5e99b1;
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
               color: #00a0df;
            }

            @media (max-width: 760px){
                .titulo_principal{
                  text-align: center;
                }

                .botones_principal{
                  display: flex;
                  justify-content: center;
                }

                .formulario{
                    margin-top: 2px; 
                    margin-bottom: 2px;
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
                    <li class="breadcrumb-item " aria-current="page"><a href="../Vista/inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="../Vista/vehiculos.php">Vehiculos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reporte Vehiculos</li>
                </ol>
            </div>


            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-clipboard mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REPORTE MODIFICACIONES</b></strong>
            </div>
   
            <!-- FILTRO REPORTE -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%">
                    <p><b>FILTRAR REPORTE</b></p>
                </div>

                <div class="col-sm-12 col-md-12 mt-3 formulario_reporte" style="height: auto; width: 100%; border-radius: 4px; background-color: #fff; ">
                    
                    <form method="POST" action="" class="p-2">
                        
                        <div class="row mt-2 d-flex justify-content-center p-2" style="border: 1px dashed #d1d1d1;">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-3 formulario">
                                <label><strong style="font-size: .9rem;">FECHA INICIAL</strong></label>
                                <input type="text" class="form-control" name="fecha_inicial_reporte" id="datepicker">
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-3 formulario">
                                <label><strong style="font-size: .9rem;">FECHA FINAL</strong></label>
                                <input type="text" class="form-control" name="fecha_final_reporte" id="datepicker1">
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-3 formulario">
                                <label><strong style="font-size: .9rem;">VEHÍCULO</strong></label>
                                <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo" id="id_vehiculo">
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarVehiculos as $lv){ ?>
                                        <option value="<?php echo $lv['id_vehiculo'] ?>"><?php echo $lv['placa'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2 d-flex justify-content-center p-2" style="border: 1px dashed #d1d1d1;">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-3 formulario">
                                <label><strong style="font-size: .9rem;">TIPO DE ACTIVIDAD</strong></label>
                                <select class="form-control selectpicker" data-live-search="true" name="tipo_actividad" id="tipo_actividad">
                                    <option value="">SELECCIONAR</option>
                                    <option value="REGISTRAR">REGISTRO</option>
                                    <option value="ACTUALIZAR">ACTUALIZACIÓN</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2 d-flex justify-content-center">
                            <div class="col-3 mb-1 ">
                                <label>&nbsp;</label>
                                <button name="consultar" class="btn btn-outline-info btn-block">Filtrar</button>
                            </div>
                        </div>

                    </form>
                    
                    <form action="ExportarExcelActualizacionDocsVehiculos.php" method="POST" target="_blank">
                		<div class="row mt-1 d-flex justify-content-center">
                            <div class="col-3">
                        	    <input type="hidden" name="fecha_inicial" id="fecha_inicial" value="<?php echo $_POST['fecha_inicial_reporte']; ?>">
                                <input type="hidden" name="fecha_final" id="fecha_final" value="<?php echo $_POST['fecha_final_reporte']; ?>">
                                <input type="hidden" name="vehiculo" id="vehiculo" value="<?php echo $_POST['id_vehiculo']; ?>">
                                <input type="hidden" name="tipoActividad" id="tipoActividad" value="<?php echo $_POST['tipo_actividad']; ?>">
                               
                                <button type="submit" class="btn btn-outline-success mr-4 mb-3 btn-block" style="height: 40px;">Excel <i class="fa fa-file-excel-o"></i></button>
                
                		     </div>
                		</div>
            	    </form>
                </div>

            <!-- TABLA INFORMACION BASICA-->
                <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
                    <table id="dataT" class="table table-hover text-center table-sm display" style="width:100%">
                        <thead style="background-color: #1b2d3b; color: #fff;">
                            <tr>
                                <th colspan="8" style="text-align:center">
                                    TOTAL DE ACTUALIZACIONES: <?php echo count($filtroActualizacionesDocs);?>
                                </th>
                            </tr>
                            <tr style="font-size: .9rem;">
                                <td><strong>#</strong></td>
                                <td><strong>ACTIVIDAD</strong></td>
                                <td><strong>PLACA</strong></td>
                                <td><strong>FECHA ACTIVIDAD</strong></td>
                                <td><strong>DATOS ACTUALIZADOS</strong></td>
                                <td><strong>VALORES ANTIGUOS</strong></td>
                                <td><strong>VALORES NUEVOS</strong></td>
                                <td><strong>USUARIO</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($filtroActualizacionesDocs as $fad){ ?>
                                <tr style="font-size: .9rem;">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $fad['tipo_actividad']; ?></td>
                                    <td>
                                        <?php 
                                            $listarPorId = $vehiculo->listarPorId($fad['id_registro']);
                                            echo $listarPorId[0]['placa'] . ' | ' . $listarPorId[0]['numero_movil']; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $fad['fecha_actividad'] . ' A las ' . $fad['hora_actividad']; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo strtoupper($fad['columnas_modulo']); ?>
                                    </td>
                                    <td><?php echo strtoupper($fad['valores_antiguos']); ?></td>
                                    <td><?php echo strtoupper($fad['valores_nuevos']); ?></td>
                                    <td>
                                        <?php 
                                            $listarUsuarioPorId = $usuario->listarUsuarioPorId($fad['id_usuario']);
                                            echo $listarUsuarioPorId[0]['nombre']; 
                                        ?>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

        </section>
    <!-- FIN CONTENIDO -->

    </div>

    <!-- SCRIPT -->

        <?php include("Template/scripts.php"); ?>

        <script type="text/javascript">

            $( function() {
                $("#datepicker").datepicker({ dateFormat:'yy-mm-dd'});
                $("#datepicker1").datepicker({ dateFormat:'yy-mm-dd'});
            });

        </script>
</body>
</html>