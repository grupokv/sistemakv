<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Departamento.php");

$cliente = new Cliente();
$listarClientes = $cliente->listar();

$empresa = new Empresa();
$listarEmpresas = $empresa->listar();

$ciudad = new Ciudad();
$listarCiudades = $ciudad->listar();

$departamento = new Departamento();
$listarDepartamentos = $departamento->listar();

$fecha1 = date('Y-m-d');
$nuevafecha = strtotime('+2 month', strtotime($fecha1));
$fecha2 = date('Y-m-d',$nuevafecha);

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="gb18030">
    <title>SistemaKV | Registrar Extracto</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- styles -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/registrarUsuario.css">
    <style>
        .bootstrap-select.form-control:not([class*=col-]) {
            width: 93% !important;
        }

        /*.origen{
            width: 93% !important;
        }*/
        
        .dropdown-menu.show{
            max-width:100% !important;
            display: block;
            min-width:100% !important;
        }

        #convenio {
            background-color: white !important;
            font-size: .9rem;
        }

       
    </style>

</head>
<body >
    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="fuec.php">Extractos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Extracto</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="col-10 formulario mb-5">
            <div class="row" style="height: 60px; background-color: #5e99b1; ">
              <div class="col-">
                <h2 class="ml-4 mt-2" style="color: #fff;"><i class="fa fa-users p-2" style="border: 2px solid #fff; border-radius: 50%; font-size: 1.8rem;"></i> Registrar Extracto</h2>
              </div>
            </div>
            <hr>
            <!-- Formulario -->
            <form method="POST" action="../Controlador/registrarFuec.php" class="p-4">

                    <!-- CLIENTE -->
                    <div class="row mt-4 mb-4 ">
                        <div class="label">    
                            <label>Cliente</label>
                        </div>
                        <div class="input">    
                            <select class="form-control selectpicker" data-live-search="true" name="cliente" id="cliente" onchange="listar_contratos();">
                                <option>SELECCIONAR </option>
                                    <?php foreach ($listarClientes as $cli){ ?>
                                        <option value="<?php echo $cli['id_cliente'] ?>">
                                            <?php echo $cli['razon_social'] ?>
                                        </option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                  

                    <!-- CONTRATO -->
                    <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>Contrato</label>
                            </div>
                            <div class="input">    
                               <select class="form-control" name="contrato" id="contrato"  onchange="listar_vehiculos(); validarContrato(this.value);" required="required">
                            </select>
                            </div>
                        </div>
                    

                    <!-- VEHICULO -->
                        <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>Vehiculo</label>
                            </div>
                            <div class="input">    
                               <select class="form-control" data-live-search="true" name="vehiculo" id="vehiculo" onchange="validarDocsConductor(this.value); validar_datos(); veh(this.value); validarDocsVehiculoAlert(this.value);">
                               </select>
                            </div>
                        </div>

                        <div id="veh"></div>

                        <div class="row ml-5 mb-3" class="mensaje_conductor" id="mensaje_conductor">
                            <div class="col-12 ml-5">
                                
                            </div>
                        </div>

                    <!-- ORIGEN -->
                    <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>Origen</label>
                            </div>
                            <div class="input">    
                               <select class="form-control selectpicker" data-live-search="true" name="origen" id="origen" onchange="validar_datos();">
                                <option value="">SELECCIONAR</option>
                                <?php foreach ($listarCiudades as $ori){ ?>
                                  <option value="<?php echo $ori['ciudad'] ?>">
                                    <?php echo $ori['ciudad'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                  <button type="button" class="btn btn-xs btn-success" onclick="cargar_origen()"><span class="fa fa-refresh" ></span></button>
                            </div>
                        </div>

                    <!-- DESTINO -->
                    <div class="row mt-4 mb-4 " id="destinoCiudades" style="display: none;">
                            <div class="label">    
                                <label>Destino</label>
                            </div>
                            <div class="input">    
                                <select class="form-control selectpicker" data-live-search="true" name="destinoCiudad" id="destino" onchange="validar_datos();">
                                    <option value="">SELECCIONAR </option>
                                        <?php foreach ($listarCiudades as $des){ ?>
                                            <option value="<?php echo $des['ciudad'] ?>">
                                                <?php echo $des['ciudad'] ?>
                                            </option>
                                        <?php } ?>
                                        <?php foreach ($listarDepartamentos as $ld){ ?>
                                            <option value="<?php echo $ld['departamento'] ?>">
                                                <?php echo $ld['departamento'] ?>
                                            </option>
                                        <?php } ?>
                                </select>
                               <button type="button" class="btn btn-xs btn-success" onclick="cargar_destino()"><span class="fa fa-refresh" ></span></button>
                            </div>
                        </div>

                    <div class="row mt-4 mb-4 " id="destinoRutaText" style="display: none;">
                            <div class="label">    
                                <label>Destino</label>
                            </div>
                            <div class="input">    
                                <textarea class="form-control" name="destinoRuta" id="destino" onchange="validar_datos();"></textarea>
                            </div>
                        </div>

                    <!-- ANEXO -->
                    <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>Anexo</label>
                            </div>
                            <div class="input">    
                               <input type="checkbox" name="anexo" id="anexo" class="form-control" style="max-width: 20px;">
                            </div>
                        </div>

                    <!-- SELECCIONAR FECHA FINAL -->
                        <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>Seleccionar Fecha Final</label>
                            </div>
                            <div class="input">    
                               <input type="checkbox" name="cambiar_fecha" id="cambiar_fecha" class="form-control" style="max-width: 20px;" onclick="fecha()" value="S">
                            </div>
                        </div>

                    <!-- FECHA FINAL -->
                        <div class="row mt-4 mb-4 " id="fecha_fuec" style="display:none">
                            <div class="label">    
                                <label>Fecha Final</label>
                            </div>
                            <div class="input">    
                               <input type="text" class="form-control" name="fecha_final" id="datepicker" placeholder="SELECCIONAR FECHA" />
                            </div>
                        </div>

                    <!-- TIPO CONVENIO -->
                        <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>Tipo Extracto</label>
                            </div>
                            <div class="input">    
                                <select class="form-control selectpicker" data-live-search="true" name="tipo_extracto" id="tipo_extracto" onchange="validarConvenioVehiculo(this.value);">
                                    <option value="" selected="selected">N/A</option>
                                    <option value="CONVENIO">CONVENIO</option>
                                    <option value="CONSORCIO">CONSORCIO</option>
                                    <option value="UNION TEMPORAL">UNION TEMPORAL</option>
                                </select>
                            </div>
                        </div>


                        <div class="row mt-4 mb-4" id="conveniosVeh" style="display: none;">
                            <div class="label">    
                                <label>Convenio</label>
                            </div>
                            <div class="input" id="convenioVehiculoSelect">    
                               
                            </div>
                        </div>
                    
                        <div class="row mt-4 mb-4" id="tipoExtracCon" style="display: none;">
                            <div class="label">    
                                <label>Con</label>
                            </div>
                            <div class="input">    
                               <input type="text" class="form-control" name="extracto_con" id="extracto_con" />
                            </div>
                        </div>

                    <!-- RESPONSABLE CONTRATO -->
                        <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>Nombre Responsable</label>
                            </div>
                            <div class="input">    
                               <input type="text" class="form-control" name="nombre_responsable" id="nombre_responsable" onkeyup="validar_datos()" />
                            </div>
                        </div>

                        <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>No. Identificación</label>
                            </div>
                            <div class="input">    
                               <input type="text" class="form-control" name="num_responsable" id="num_responsable" onkeyup="validar_datos()" />
                            </div>
                        </div>

                        <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>Dirección</label>
                            </div>
                            <div class="input">    
                               <input type="text" class="form-control" name="dir_responsable" id="dir_responsable" onkeyup="validar_datos()" />
                            </div>
                        </div>

                        <div class="row mt-4 mb-4 ">
                            <div class="label">    
                                <label>Télefono</label>
                            </div>
                            <div class="input">    
                               <input type="text" class="form-control" name="tel_responsable" id="tel_responsable" onkeyup="validar_datos()" />
                            </div>
                        </div>

                    <hr>

                    <!-- BOTONES -->
                    
                  <div class="row justify-content-center botones-form mt-2 mb-2">
                    <div class="boton mt-2">
                      <a href="fuec.php" class="btn btn-danger btn-block">CANCELAR</a>
                    </div>

                    <div class="boton mt-2">
                      <input type="button" id="boton_vista" style="display:none" class="btn btn-info btn-block" value="Vista Preliminar" onclick="vista_preliminar()" />
                    </div>

                    <div class="boton mt-2">
                      <input type="submit" class="btn btn-primary btn-block" value="Registrar" id="Registrar" />
                    </div>
                  </div>

            </form>
        </div>
    </section>

    <!--- CONVENIO -->
    <div class="modal" id="avisoConveniosVeh" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="col-12 mt-4">
                        <section class="d-flex justify-content-center">
                            <i class="fa fa-exclamation-circle" style="color:#d11f1f; font-size: 6rem; "></i>
                        </section>

                        <section class="text-center mt-2 mb-3">
                            <p style="font-size: 1.3rem; color: #d11f1f;"><strong>NO SE ENCONTRO CONVENIO ACTIVO</strong></p>
                        </section>

                        <p>El vehículo seleccionado no tiene actualmente convenio activo registrado en el sistema, no se podrá generar extracto hasta registrar uno.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- VEHICULO -->
    <div class="modal" id="avisoDocsVeh" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="col-12 mt-4">
                        <section class="d-flex justify-content-center">
                            <i class="fa fa-exclamation-circle" style="color:#d11f1f; font-size: 6rem; "></i>
                        </section>

                        <section class="text-center mt-2 mb-3">
                            <p style="font-size: 1.3rem; color: #d11f1f;"><strong>DOCUMENTACIÓN PENDIENTE O VENCIDA</strong></p>
                        </section>

                        <p>El vehiculo tiene documentación pendiente o vencida, no se podrá emitir fuec con el vehículo hasta tener todo al día.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- CONVENIO -->
    <div class="modal" id="validarConvenio" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="col-12 mt-4">
                        <section class="d-flex justify-content-center">
                            <i class="fa fa-exclamation-circle" style="color:#d11f1f; font-size: 6rem; "></i>
                        </section>

                        <section class="text-center mt-2 mb-3">
                            <p style="font-size: 1.3rem; color: #d11f1f;"><strong>CONVENIO FIRMADO SIN CARGAR</strong></p>
                        </section>

                        <p>El convenio seleccionado no tiene o no se le ha cargado el soporte del documento firmado, por favor realizar la cargar del mismo lo antes posible.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?>
<!--INICIO INPUT HORA-->
<script type="text/javascript" src="../Resources/js/moment/moment.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<!--FIN INPUT HORA-->

  <script type="text/javascript">


        $( function() {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
        } );

        function validarContrato(contrato){
            //alert(contrato);
            var contratos = ['257', '258', '259'];
            console.log(contratos);
            if (contratos.includes(contrato)) {
                //alert("sdf");
                document.getElementById('destinoRutaText').style.display = 'flex';
                document.getElementById('destinoCiudades').style.display = 'none';
            }else{
                //alert("fff");
                document.getElementById('destinoRutaText').style.display = 'none';
                document.getElementById('destinoCiudades').style.display = 'flex';
            }
        }

        function habilitarCampos(){
            $("#origen").prop("disabled", false);                     
            $("#destino").prop("disabled", false);                      
            $("#anexo").prop("disabled", false);                      
            $("#cambiar_fecha").prop("disabled", false);                      
            $("#tipo_extracto").prop("disabled", false);                 
            $("#extracto_con").prop("disabled", false);                      
            $("#nombre_responsable").prop("disabled", false);                     
            $("#num_responsable").prop("disabled", false);                     
            $("#dir_responsable").prop("disabled", false);                      
            $("#tel_responsable").prop("disabled", false);                      
            $("#Registrar").prop("disabled", false);

        }

        function validarDocsVehiculoAlert(id_vehiculo){
            var parametros = {
                "id_vehiculo" : id_vehiculo,
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/validarDocsPorVehiculo.php',
                type: 'POST',
                beforeSend: function(){
                },
                success: function(response){
                    //alert(response);
                    $("#veh").html(response);
                    var valDoc = $("#validacion_doc").val();
                    
                    if (valDoc == 1) {

                        $("#avisoDocsVeh").modal("show");

                        $("#origen").attr("disabled","disabled");                      
                        $("#destino").attr("disabled","disabled");                      
                        $("#anexo").attr("disabled","disabled");                      
                        $("#cambiar_fecha").attr("disabled","disabled");                      
                        $("#tipo_extracto").attr("disabled","disabled");                      
                        $("#extracto_con").attr("disabled","disabled");                      
                        $("#nombre_responsable").attr("disabled","disabled");                      
                        $("#num_responsable").attr("disabled","disabled");                      
                        $("#dir_responsable").attr("disabled","disabled");                      
                        $("#tel_responsable").attr("disabled","disabled");                      
                        $("#Registrar").attr("disabled","disabled");

                    }else{
                        habilitarCampos();
                    }
                }
            });
        }
  
        function validarDocsConductor(id_vehiculo){
            //alert(id_vehiculo);
            var parametros = {
                "id_vehiculo" : id_vehiculo,
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/VerificarDocConductorPorVehiculo.php',
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    $("#mensaje_conductor").html(response);

                    var con = document.getElementById('verificarDocsConductor').value;
              
                    if(con >= 1){

                        $("#origen").attr("disabled","disabled");                      
                        $("#destino").attr("disabled","disabled");                      
                        $("#tipo_extracto").attr("disabled","disabled");                      
                        $("#extracto_con").attr("disabled","disabled");                      
                        $("#nombre_responsable").attr("disabled","disabled");                      
                        $("#num_responsable").attr("disabled","disabled");                      
                        $("#dir_responsable").attr("disabled","disabled");                      
                        $("#tel_responsable").attr("disabled","disabled");                      
                        $("#Registrar").attr("disabled","disabled");                      

                    } else {
                        habilitarCampos();
                    } 
                }
            });
        }

        function validarConvenioVehiculo(tipo_extracto){
            var id_vehiculo = $('#vehiculo').val();
            //alert(id_vehiculo);

            if (tipo_extracto == 'CONVENIO') {

                if ((id_vehiculo != null) && (id_vehiculo != '')) {

                    document.getElementById("conveniosVeh").style.display = 'flex';

                    var parametros = {
                        "id_vehiculo" : id_vehiculo,
                    };

                    $.ajax({
                        data:  parametros,
                        url:   '../Controlador/validarConveniosActivosVehiculo.php',
                        type:  'POST',
                        beforeSend: function () {
                            $("#convenioVehiculoSelect").html("<p>VALIDANDO CONVENIOS, POR FAVOR ESPERE... </p>");
                        },
                        success:  function (response) {
                            $("#convenioVehiculoSelect").html(response);

                            var convenio = $("#valConv").val();
                            var valDocVeh = $("#validacion_doc").val();
                            //alert(convenio);
                            if (valDocVeh != 1){
                                if (convenio == 0) {
                                    $("#avisoConveniosVeh").modal("show");

                                    $("#origen").attr("disabled","disabled");                      
                                    $("#destino").attr("disabled","disabled");                      
                                    $("#anexo").attr("disabled","disabled");                      
                                    $("#cambiar_fecha").attr("disabled","disabled");                      
                                    //$("#tipo_extracto").attr("disabled","disabled");                      
                                    $("#extracto_con").attr("disabled","disabled");                      
                                    $("#nombre_responsable").attr("disabled","disabled");                      
                                    $("#num_responsable").attr("disabled","disabled");                      
                                    $("#dir_responsable").attr("disabled","disabled");                      
                                    $("#tel_responsable").attr("disabled","disabled");                      
                                    $("#Registrar").attr("disabled","disabled");

                                    alertify.error('No se encontró convenio');

                                }else{
                                    habilitarCampos();
                                    alertify.success('¡Convenio Activo!');
                                }
                            }
                        }
                    });

                }else{
                    $("#tipo_extracto").val("").change();
                    alertify.error("No se ha seleccionado vehiculo.");
                }

            }else if(tipo_extracto == ""){
                document.getElementById('tipoExtracCon').style.display = 'none';
                document.getElementById("conveniosVeh").style.display = 'none';

                habilitarCampos();
                
            }else{
                document.getElementById('tipoExtracCon').style.display = 'flex';
                document.getElementById("conveniosVeh").style.display = 'none';

                habilitarCampos();
            }
            
        }

        function veh(id_vehiculo){

            if(id_vehiculo == 0){
                var parametros = {
                    "contrato" : id_vehiculo
                };
                $.ajax({
                    data:  parametros,
                    url:   '../Modelo/CargarVehiculosPorContrato.php',
                    type:  'post',
                    beforeSend: function () {
                         $("#vehiculo").html("<option value=''>Procesando, espere por favor...</option>");
                    },
                    success:  function (response) {
                        //alert(response);
                        $("#vehiculo").html(response);                  
                    }
                });

                buscarresponsable();
            }
            validar_datos();
        }


        function tipoextracto(convenio){

            document.getElementById('tipoExtracCon').style.display = 'flex';

            var parametros = {
                "id_convenio" : convenio
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/CargarEmpresaConvenio.php',
                type:  'post',
                beforeSend: function () {
                    //$("#extracto_con").val("PROCESANDO, ESPERE POR FAVOR...");
                    $("#extracto_con").val("");
                },
                success:  function (response) {
                    if (response != "") {
                        $("#extracto_con").val(response); 
                    }                 
                }
            });

            if(tipo_extracto != ''){
            } else {
                document.getElementById('otros').style.display = 'none';
            }
            validar_datos();
        }

        function listar_contratos(){

            document.getElementById('contrato').value = '';

            var cliente = document.getElementById('cliente').value;

            if(cliente != ''){

                var parametros = {
                    "cliente" : cliente,
                };
                $.ajax({
                    data:  parametros,
                    url:   '../Modelo/CargarContratosCliente.php',
                    type:  'post',
                    beforeSend: function () {
                        $("#contrato").html("Procesando, espere por favor...");
                    },
                    success:  function (response) {
                        //alert(response);
                        $("#contrato").html(response);
                    }
                });

            } else {

                $("#contrato").html('<option value="">No existen contratos vigentes</option>');

            }

            listar_vehiculos();
            validar_datos();
        }


        function listar_vehiculos(){
            var contrato = document.getElementById('contrato').value;

            if(contrato != ''){

                var parametros = {
                    "contrato" : contrato
                };

                $.ajax({
                    data:  parametros,
                    url:   '../Modelo/CargarVehiculosPorContrato.php',
                    type:  'POST',
                    beforeSend: function () {
                    },
                    success:  function (response) {
                      $("#vehiculo").html(response);
                    }
                });

                buscarresponsable();

            } else {
                $("#vehiculo").html('<option value="">No existen vehiculos</option>');

                document.getElementById('nombre_responsable').value = '';
                document.getElementById('num_responsable').value = '';
                document.getElementById('dir_responsable').value = '';
                document.getElementById('tel_responsable').value = '';
            }

            validar_datos();
          
        }

        function buscarresponsable(){
            var contrato = document.getElementById('contrato').value;
          
            if(contrato != ''){

                var parametros = {
                    "contrato" : contrato
                };

                $.ajax({
                    data:  parametros,
                    url:   '../Modelo/CargarResponsable.php',
                    type:  'POST',
                    beforeSend: function () {
                    },
                    success:  function (response) {
                        if(response != ''){
                            var datos_responsable = response.split('|');
                            document.getElementById('nombre_responsable').value = datos_responsable[0];
                            document.getElementById('num_responsable').value = datos_responsable[1];
                            document.getElementById('dir_responsable').value = datos_responsable[2];
                            document.getElementById('tel_responsable').value = datos_responsable[3];
                        }
                    }
                });
            } else {
                document.getElementById('nombre_responsable').value = '';
                document.getElementById('num_responsable').value = '';
                document.getElementById('dir_responsable').value = '';
                document.getElementById('tel_responsable').value = '';
            }

            validar_datos();
        }

        function validar_datos(){
            var dato_cliente = document.getElementById('cliente').value;
            var dato_contrato = document.getElementById('contrato').value;
            var dato_vehiculo = document.getElementById('vehiculo').value;
            var dato_origen = document.getElementById('origen').value;
            var dato_destino = document.getElementById('destino').value;
            var dato_nombre_responsable = document.getElementById('nombre_responsable').value;
            var dato_num_responsable = document.getElementById('num_responsable').value;
            var dato_dir_responsable = document.getElementById('dir_responsable').value;
            var dato_tel_responsable = document.getElementById('tel_responsable').value;
            
            if((dato_cliente != '')&&(dato_contrato != '')&&(dato_vehiculo != '')&&(dato_origen != '')&&(dato_destino != '')&&(dato_nombre_responsable != '')&&(dato_num_responsable != '')&&(dato_dir_responsable != '')&&(dato_tel_responsable != '')){
              document.getElementById('boton_vista').style.display = 'block';
            } else {
              document.getElementById('boton_vista').style.display = 'none';
            }
        }

        function vista_preliminar(){
            var dato_cliente = document.getElementById('cliente').value;
            var dato_contrato = document.getElementById('contrato').value;
            var dato_vehiculo = document.getElementById('vehiculo').value;
            var dato_origen = document.getElementById('origen').value;
            var dato_destino = document.getElementById('destino').value;
            var dato_tipo_extracto = document.getElementById('tipo_extracto').value;
            var dato_extracto_con = document.getElementById('extracto_con').value;
            var dato_nombre_responsable = document.getElementById('nombre_responsable').value;
            var dato_num_responsable = document.getElementById('num_responsable').value;
            var dato_dir_responsable = document.getElementById('dir_responsable').value;
            var dato_tel_responsable = document.getElementById('tel_responsable').value;

            var parametros = {
                "cliente" : dato_cliente,
                "contrato" : dato_contrato,
                "vehiculo" : dato_vehiculo,
                "origen" : dato_origen,
                "destino" : dato_destino,
                "tipo_extracto" : dato_tipo_extracto,
                "extracto_con" : dato_extracto_con,
                "nombre_responsable" : dato_nombre_responsable,
                "num_responsable" : dato_num_responsable,
                "dir_responsable" : dato_dir_responsable,
                "tel_responsable" : dato_tel_responsable,
            };
            $.ajax({
                data:  parametros,
                url:   '../Modelo/CrearPreliminarFuec.php',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (response) {
                    alert(response);
                    if(response != ''){
                        window.open('formato_borrador.php?id='+response);
                    } else {
                        alert('Error al crear vista preliminar, intente nuevamente');
                    }
                }
            });
        }

        function cargar_origen(){
            var id = 0;
            var parametros = {
                "id" : id,
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/listarCiudadesTodas.php',
                type:  'post',
                beforeSend: function () {
                    $("#origen").html("<option value=''>Procesando, espere por favor...</option>");
                },
                success:  function (response) {
                    $("#origen").html(response);
                    $('#origen').addClass("selectpicker").selectpicker('refresh');
                }
            });
        }


        function cargar_destino(){
            var id = 0;

            var parametros = {
                "id" : id,
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/listarCiudadesTodas.php',
                type:  'post',
                beforeSend: function () {
                    $("#destino").html("<option value=''>Procesando, espere por favor...</option>");
                },
                success:  function (response) {
                    $("#destino").html(response);
                    $('#destino').addClass("selectpicker").selectpicker('refresh');
                }
            });
        }


        function fecha(){
            var checkbox = document.getElementById('cambiar_fecha');
            var checked = checkbox.checked;

            if(checked){
                    document.getElementById('fecha_fuec').style.display = 'flex';
            } else {
                document.getElementById('fecha_fuec').style.display = 'none';
            }
        }

        function validarDocFirmadoConvenio(val){
            var parametros = {
                "id_convenio" : val,
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/validarDocConvenio.php',
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    //alert(response);
                    if (response == 1){
                        $('#validarConvenio').modal('show');
                    } 
                }
            });
        }

  </script>
  
</body>
</html>