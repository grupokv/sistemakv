<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");
require_once ("../Modelo/Conductor.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/Usuario.php");

$programacion = new Programacion();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
$usuario = new Usuario();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Servicios Programados</title>
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

        .content{
            padding: 0px !important;
        }

        #tabs ul{
            display:  block !important;
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
                <li class="breadcrumb-item " aria-current="page"><a href="programaciones.php">Base programaciones</a></li>
                <li class="breadcrumb-item active" aria-current="page">Servicios Fijos</li>
           </ol>
        </div>
        
        <div class="notice notice-sistemakv">
          <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">SERVICIOS FIJOS</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            
            <a id="buttonsKV" href="administrarServiciosProgramacion.php" class="btn btn-outline-info">Administrar <i class="fa fa-cog ml-2" style="font-size: 1.1rem;"></i></a>

            <button id="buttonsKV" data-toggle="modal" data-target="#activar" class="btn btn-outline-info">Programar Mes <i class="fa fa-calendar-check-o ml-2"></i></button>

        </div>


        <div class="text-center mt-5">
            <h5 style="font-weight: 500 !important;">AGENDA SEMANAL DE SERVICIOS</h5>
        </div>

        <div id="tabs" class="mt-3">
            <ul class="text-center d-flex justify-content-center">
                <li class="tab" id="tab0">
                    <a href="#tabs-1">
                        <input type="hidden" value="<?php echo date("Y-m-d", strtotime("monday this week")); ?>" id="fechaActual1">
                        <b>LUNES</b>
                    </a>
                </li>
                <li class="tab" id="tab1">
                    <a href="#tabs-2">
                        <input type="hidden" value="<?php echo date("Y-m-d", strtotime("tuesday this week")); ?>" id="fechaActual2">
                        <b>MARTES</b>
                    </a>
                </li>
                <li   class="tab" id="tab2">
                    <a href="#tabs-3">
                        <input type="hidden" value="<?php echo date("Y-m-d", strtotime("wednesday this week")); ?>" id="fechaActual3">
                        <b>MIERCOLES</b>
                    </a>
                </li>
                <li class="tab" id="tab3">
                    <a href="#tabs-4">
                        <input type="hidden" value="<?php echo date("Y-m-d", strtotime("thursday this week")); ?>" id="fechaActual4">
                        <b>JUEVES</b>
                    </a>
                </li>
                <li class="tab" id="tab4">
                    <a href="#tabs-5">
                        <input type="hidden" value="<?php echo date("Y-m-d", strtotime("friday this week")); ?>" id="fechaActual5">
                        <b>VIERNES</b>
                    </a>
                </li>
                <li class="tab" id="tab5">
                    <a href="#tabs-6">
                        <input type="hidden" value="<?php echo date("Y-m-d", strtotime("saturday this week")); ?>" id="fechaActual6">
                        <b>SABADO</b>
                    </a>
                </li>
                <li class="tab" id="tab6">
                    <a href="#tabs-7">
                        <input type="hidden" value="<?php echo date("Y-m-d", strtotime("sunday this week")); ?>" id="fechaActual7">
                        <b>DOMINGO</b>
                    </a>
                </li>
            </ul>

            <!-- INFORMACION BASICA-->
                <div id="tabs-1" class="content text-center">
                    <p class="mensaje m-3" style="font-size: .8rem; color: #1b2d3b;"><b>SELECCIONE UN DÍA PARA VER LOS SERVICIOS CORRESPONDIENTES.</b></p>
                </div>
                <div id="tabs-2" class="content text-center">
                    <p class="mensaje m-3" style="font-size: .9rem;"><b>SELECCIONE UN DÍA PARA VER LOS SERVICIOS CORRESPONDIENTES.</b></p>
                </div>
                <div id="tabs-3" class="content text-center">
                    <p class="mensaje m-3" style="font-size: .9rem;"><b>SELECCIONE UN DÍA PARA VER LOS SERVICIOS CORRESPONDIENTES.</b></p>
                </div>
                <div id="tabs-4" class="content text-center">
                    <p class="mensaje m-3" style="font-size: .9rem;"><b>SELECCIONE UN DÍA PARA VER LOS SERVICIOS CORRESPONDIENTES.</b></p>
                </div>
                <div id="tabs-5" class="content text-center">
                    <p class="mensaje m-3" style="font-size: .9rem;"><b>SELECCIONE UN DÍA PARA VER LOS SERVICIOS CORRESPONDIENTES.</b></p>
                </div>
                <div id="tabs-6" class="content text-center">
                    <p class="mensaje m-3" style="font-size: .9rem;"><b>SELECCIONE UN DÍA PARA VER LOS SERVICIOS CORRESPONDIENTES.</b></p>
                </div>
                <div id="tabs-7" class="content text-center">
                    <p class="mensaje m-3" style="font-size: .9rem;"><b>SELECCIONE UN DÍA PARA VER LOS SERVICIOS CORRESPONDIENTES.</b></p>
                </div>
        </div>

    </section>

    <!-- FIN CONTENIDO -->

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

    <!-- MODAL PROGRAMAR MES -->
        <div class="modal fade" id="activar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="../Controlador/activarServiciosProgramacion.php" method="POST">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #5e99b1; color: #fff;">
                            <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.3rem;"> PROGRAMAR MES</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" color: #fff;">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-3">
                            <section id="contenido" class="col-12">
                                <div class="col-12">
                                    <label for="">Mes</label>
                                    <input type="text" name="mes" id="mes" class="form-control">
                                </div>
                            </section>

                            <div class="col-12 d-flex justify-content-center mt-3 mb-3">
                                <button type="submit" class="btn btn-outline-info col-3">Activar</button>
                                <button type="button" class="btn btn-outline-danger col-3 ml-2" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <!------------------------------------------------------->
    <!------------------------------------------------------->
    <!------------------------------------------------------->

    <!-- script -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
       
        
        $( function() {
            $('.tab').removeClass("ui-tabs-active").removeClass("ui-state-active");
            $('.tab').attr('aria-selected', 'false');
            $('.tab').attr('aria-expanded', 'false');
            $('.tab').attr('tabindex', '-1');
            $('.tab').prop('selected', 'false');
            
            $("#tabs").tabs({
            
            }); 

        }); 

        
       
        $("#tabs").tabs({ 

            activate: function(event ,ui){
                var id = (ui.newTab.index() + 1);
                var fecha = $("#fechaActual"+ id).val();

                var parametros = {
                    "fecha" : fecha,
                    "id" : id
                };

                $.ajax({
                    data:  parametros,
                    url:   '../Controlador/listarProgramacionesServiciosPorDia.php',
                    type:  'POST',
                    beforeSend: function () {
                        $("#tabs-" + id).html("Procesando, espere por favor...");
                    },
                    success:  function (response) {
                        //alert(response);
                        $("#tabs-" + id).html(response);

                    }
                });
            }
        });

        $("#mes").MonthPicker({
            MonthFormat: 'yy-mm',
            Button: false,
            IsRTL: true,
            i18n: {
                months: ["Enero", "Feb", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agos", "Sept", "Oct","Nov", "Dic"],
                buttonText: "",
            }
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



    function finalizarServicio(val){
        var parametros = {
            "id_programacion" : val
        };

        $.ajax({
            data:  parametros, //datos que se envian a traves de ajax
            url:   '../Controlador/finalizarServicioProgramacionRuta.php', //archivo que recibe la peticion
            type:  'POST', //método de envio
            beforeSend: function () {
            },
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                //alert(response);
                document.location.reload();
            }
        })
    }

    </script>

</body>
</html>