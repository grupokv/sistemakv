<?php 
//include ("../Controlador/Sesion/autenticar.php");

$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Inspección Vehicular</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <link rel="stylesheet" href="../firma/signature-pad.css">
    <style>
        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
            background: #1b2d3b !important;
            border: #fff;
        }
    </style>
    <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
        <section class="home_content">  

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-car mr-3" style="font-size: 2rem;"></i>FIRMA ENTREGA INSPECCIÓN VEHICULAR</strong>
            </div>

            <section class="form-usuarios">
                <div class="formulario mb-5">
                    <form action="../Controlador/firmaEntregaInspeccionVehicular.php" id="signature-form" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
                            <!-- INFORMACION BASICA-->
                                <div id="tabs-1" class="p-4">

                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                    <input type="hidden" name="signature" id="signature-data" value="">
                                    
                                    <div class="row mt-2">
                                        <div class="label">
                                            <label>Nombre de Quien Entrega</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" class="form-control form-control-sm" name="nombre_entrega" id="nombre_entrega" required="required" >
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label">
                                            <label>Firma</label>
                                        </div>
                                        <div class="input">
                                            <div id="signature-pad" class="signature-pad" style="min-height:400px">
                                            <div class="signature-pad--body">
                                              <canvas></canvas>
                                            </div>
                                            <div class="signature-pad--footer">
                                              <div class="signature-pad--actions">
                                                <div>
                                                  <button type="button" class="btn btn-warning button clear" data-action="clear">Limpiar</button>
                                                </div>
                                                <div>
                                                  <button type="button" class="btn btn-success button save" data-action="save-png">Guardar</button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>              
                                    </div>
                                    
                                </div>

                    </form>
                </div>
            </section>

        </section>

    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
  
  <script>
        $(function() {
            $("#tabs").tabs();
        }); 

        $(function() {
            $("#fecha_proximo_mtto").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_lic_conductor").datepicker({dateFormat:'yy-mm-dd'});
            $("#tarjeta_propiedad_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#tarjeta_operacion_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#soat_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#poliza_extra_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#tecnomecanica_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#preventiva_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#fuec_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#disp_velocidad_fv").datepicker({dateFormat:'yy-mm-dd'});
            
        });

        function validarTipoVehiculo(val){

            const parametros = {
                "id_vehiculo" : val
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/validarTipoVehiculoInspeccion.php',
                type:  'POST',
                beforeSend: function () {
                    $("#img_danios_observados").val("");
                },
                success:  function (response) {
                    $("#img_danios_observados").html(response);                  
                }
            });

        }
        
        function traer_datos_veh(val){
            const parametros = {
                "id_vehiculo" : val
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/traerDatosVehiculo.php',
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    var data = response.split('|');
                    if(data.length > 0){
                        document.getElementById('placa').value = data[0];
                        document.getElementById('movil').value = data[1];
                        document.getElementById('cantidad').value = data[2];
                        document.getElementById('modelo').value = data[3];
                        document.getElementById('tipo_vehiculo').value = data[4];
                        document.getElementById('tipo_combustible').value = data[5];
                    } else {
                        document.getElementById('placa').value = '';
                        document.getElementById('movil').value = '';
                        document.getElementById('cantidad').value = '';
                        document.getElementById('modelo').value = '';
                        document.getElementById('tipo_vehiculo').value = '';
                        document.getElementById('tipo_combustible').value = '';
                    }
                }
            });
        }
        
        function traer_datos_cond(val){
            const parametros = {
                "id_conductor" : val
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/traerDatosConductor.php',
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    var data = response.split('|');
                    if(data.length > 0){
                        document.getElementById('nombre_conductor').value = data[0];
                        document.getElementById('num_doc_conductor').value = data[1];
                        document.getElementById('num_lic_conductor').value = data[2];
                        document.getElementById('tel_conductor').value = data[3];
                        document.getElementById('fecha_lic_conductor').value = data[4];
                    } else {
                        document.getElementById('nombre_conductor').value = '';
                        document.getElementById('num_doc_conductor').value = '';
                        document.getElementById('num_lic_conductor').value = '';
                        document.getElementById('tel_conductor').value = '';
                        document.getElementById('fecha_lic_conductor').value = '';
                    }
                }
            });
        }
        
    function entrega(val){
        if(val == 'SI'){
            document.getElementById('obs_entrega').style.display = "flex";
        } else {
            document.getElementById('obs_entrega').style.display = "none";
        }
    }
    function existe_veh(val){
        if(val == 'SI'){
            document.getElementById('vehiculo_existe').style.display = "flex";
        } else {
            document.getElementById('vehiculo_existe').style.display = "none";
            document.getElementById('placa').value = '';
            document.getElementById('movil').value = '';
            document.getElementById('cantidad').value = '';
            document.getElementById('modelo').value = '';
            document.getElementById('tipo_vehiculo').value = '';
            document.getElementById('tipo_combustible').value = '';
        }
    }
    function existe_cond(val){
        if(val == 'SI'){
            document.getElementById('conductor_existe').style.display = "flex";
        } else {
            document.getElementById('conductor_existe').style.display = "none";
            document.getElementById('nombre_conductor').value = '';
            document.getElementById('num_doc_conductor').value = '';
            document.getElementById('num_lic_conductor').value = '';
            document.getElementById('tel_conductor').value = '';
            document.getElementById('fecha_lic_conductor').value = '';
        }
    }
  </script>
  <!-- FIN SCRIPTS -->
    <script src="../firma/signature_pad.umd.js"></script>
  <script src="../firma/app.js"></script>
</body>
</html>