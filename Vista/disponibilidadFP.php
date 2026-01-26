<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Vehiculo.php");

$vehiculo = new Vehiculo();
$listarVehiculoFlotaPropia = $vehiculo->listarVehiculoFlotaPropia();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Disponibilidad FP</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style type="text/css">
        
        .infoDisp{
            background-color: #1b2d3b;
            color: #fff;
            font-size:.8rem;
        }

        .infoDisp:hover{
            color: #fff;
        }
        
        #filterActive {
            height: auto;
            width: auto;
            padding: 0px 10px 0px 10px;
            background: #1b2d3b;
            color: #fff;
            border-radius: 5px;
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
    
        <section class="home_content">

            <!-- CONTENIDO -->
            <div aria-label="breadcrumb" class="mt-1"> 
                <ol class="breadcrumb" style="background: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Control Mantenimientos</li>
                </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong>
                    <i class="fa fa-users mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">DISPONIBILIDAD FLOTA PROPIA</b>
                </strong>
            </div>

            <div class="notice notice-sistemakv">
                <!-- FILTRAR -->
                <button type="button" class="btn mr-3" data-toggle="modal" id="buttonsKV" data-target="#modalFilter" style="border-radius: 10px;">Filtrar <i class="fa fa-search ml-1"></i></button>

            </div>

            <div id="contDisp" class="mt-2 mb-5 p-4 table-responsive" style="background-color: #fff; overflow-x; scroll; ">
                
            </div>

        </section>
    
    <!--**************************--->

        <!-- MODAL FILTRO -->
            <div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="height: auto;">
                        <div class="modal-body">
                            <form action="" method="POST" id="filter">
                                <div class="col-12">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                            aria-hidden="true">&times;</i></button>
                                    <h5><b><i class="fa fa-filter mr-1"></i>FILTRO(S)</b></h5>
                                </div>

                                <section class="col-12 p-2" style=" background-color: #fafafa; font-size: .7rem;">

                                    <!-- TIPO SERVICIO -->
                                        <div class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                            <label for="#tipo_filtro"><b>TIPO FILTRO</b></label>
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                                name="tipo_filtro" id="tipo_filtro" style="border-style: dashed;" title="SELECCIONAR">
                                                <option value="TODOS">TODOS</option>
                                                <option value="DISP_DIA">DISPONIBLE DÍA</option>
                                                <option value="DISP_PARCIAL">DISPONIBLE PARCIAL</option>
                                                <option value="MTTO_MENOR">MANTENIMIENTO <= 3 DÍAS</option>
                                                <option value="MTTO_MAYOR">MANTENIMIENTO > 3 DÍAS</option>
                                                <option value="PLACA">POR PLACA</option>
                                                <option value="FACTURACION">FACTURACIÓN - INGRESOS</option>
                                            </select>
                                        </div>

                                    <!-- VEHICULO -->
                                        <div id="vehiculo" class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                            <label for="#id_vehiculo"><b>PLACA</b></label>
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                                name="id_vehiculo" id="id_vehiculo" style="border-style: dashed;" title="DEBE SELECCIONAR TIPO FILTRO: POR PLACA">
                                                <?php foreach ($listarVehiculoFlotaPropia as $lvfp) { ?>
                                                    <option value="<?php echo $lvfp['id_vehiculo']; ?>"><?php echo $lvfp['placa'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>


                                    <!-- FECHAS -->
                                    <section class="row mt-3 mb-4 p-2"
                                        style="border: 1px dashed #d3d3d3; background-color: #fff; width: 100%; margin: 0px;">
                                        <div class="col-6">
                                            <label for="#fecha_inicial"><b>DESDE</b></label>
                                            <input type="text" class="form-control form-control-sm" placeholder="FECHA INICIAL"
                                                name="fecha_inicial" id="fecha_inicial" style="border-style: dashed;">
                                        </div>

                                        <div class="col-6">
                                            <label for="#fecha_final"><b>HASTA</b></label>
                                            <input type="text" class="form-control form-control-sm" placeholder="FECHA FINAL"
                                                name="fecha_final" id="fecha_final" style="border-style: dashed;">
                                        </div>
                                    </section>

                                <section class="d-flex justify-content-center mb-3">
                                    <button type="button" data-dismiss="modal" style="border-radius: 10px;" class="btn btn-outline-danger btn-sm col-3">
                                        Cerrar</button>
                                    <button type="button" onclick="limpiarCamposFiltro();"
                                        class="btn btn-outline-info btn-sm ml-2 col-3" style="border-radius: 10px;" data-dismiss="modal" id="limpiar">
                                        Limpiar Filtro</button>
                                    <button type="button" class="btn btn-sm ml-2 col-3" id="buttonsKV"
                                        onclick="cargarDisponibilidad();" data-dismiss="modal"> Filtrar</button>
                                </section>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <!-- MODAL DETALLE SERVICIO -->
            <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="height: auto;">
                        <div class="modal-body" id="contentDetail">
                                
                        </div>
                    </div>
                </div>
            </div>

    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>
        
        <script>

            $(document).ready(function() {
                cargarDisponibilidad();
            });

            $(function() {
                $("#fecha_inicial").datepicker({
                    dateFormat: 'yy-mm-dd'
                });
                $("#fecha_final").datepicker({
                    dateFormat: 'yy-mm-dd'
                });
            });

            function cargarDisponibilidad(){

                var tipo_filtro = $("#tipo_filtro").val();
                var fecha_inicial = $("#fecha_inicial").val();
                var fecha_final = $("#fecha_final").val();

                var parametros = {
                    "tipo_filtro": tipo_filtro,
                    "fecha_inicial": fecha_inicial,
                    "fecha_final": fecha_final,
                };

                $.ajax({
                    data: parametros,
                    url: '../Controlador/baseDisponibilidadFP.php',
                    type: 'POST',
                    beforeSend: function() {
                        $('#contDisp').empty();
                    },
                    success: function(response) {
                        //alert(response);
                        $("#contDisp").append(response);
                    }
                });
            }

            function moreInfoServ(id, tipo){
                var parametros = {
                    "id": id,
                    "tipo": tipo,
                };

                $.ajax({
                    data: parametros,
                    url: '../Controlador/cargarInfoServicioDisponibilidad.php',
                    type: 'POST',
                    beforeSend: function() {
                        $('#contentDetail').empty();
                    },
                    success: function(response) {
                        $("#contentDetail").append(response);
                    }
                });
            }
            function limpiarCamposFiltro() {

                $('#fecha_inicial').val('');
                $('#fecha_final').val('');

                $('#tipo_filtro').val('');
                $("#tipo_filtro").selectpicker("refresh");

                cargarDisponibilidad();
                alertify.notify('Filtro Restablecido', 'success');
            }
            
        </script>
    <!-- SCRIPT -->
  
</body>
</html>