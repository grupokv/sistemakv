<?php 
include("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/BitacoraTransaccion.php");
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Cartera.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");

date_default_timezone_set('America/Bogota');

$cartera = new Cartera();

$vehiculo = new Vehiculo();
$buscarVehiculoPorPropietario = $vehiculo->buscarVehiculoPorPropietario($_SESSION['id_usuario']);

$concepto = new ConceptoCobro();

$cliente = new Cliente();
$listarClUsuarioRegistro = $cliente->listarClientesAncladosPorPropietario($_SESSION['id_usuario']);

$empresa = new Empresa();
$listarEmpresas = $empresa->listar();

$ciudad = new Ciudad();
$listarCiudades = $ciudad->listar();

$fecha1 = date('Y-m-d');
$nuevafecha = strtotime('+2 month', strtotime($fecha1));
$fecha2 = date('Y-m-d',$nuevafecha);


$transacciones = new Transacciones();
$transaccionesPendPorUsu = $transacciones->historialTransaccionesPendientesPorUsuario($_SESSION['id_usuario']);

$cantTPU = count($transaccionesPendPorUsu);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  
  <title>SistemaKV | Registrar Extracto</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- STYLES -->
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
    
    <style>
        .bootstrap-select.form-control:not([class*=col-]) {
            width: 100% !important;
        }

        .dropdown-menu.show{
        max-width:100% !important;
        display: block;
        min-width:100% !important;
        }

        .ajs-button{
            border-radius: 5px;
            background-color: #5e99b1;
            color: #fff;
            box-shadow: none;
            border:0px;
        }

        .ajs-header{
            color: #1b2d3b !important;
        }

        @media (max-width: 760px){
            .formulario{
                padding: 0px !important;
                margin: 0px;
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
                <li class="breadcrumb-item " aria-current="page"><a href="inicioPropietarios.php">Inicio</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="extractosFijosPropietarios.php">Extractos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registrar Extracto</li>
            </ol>
          </div>

          <div class="notice notice-sistemakv">
              <strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR EXTRACTO</b></strong>
          </div>

          <section class="form-usuarios mb-3">
              <div class="col-10 formulario mb-3">
                  
                  <!-- FORMULARIO -->

                    <form method="POST" action="../Controlador/registrarFuecPropietarios.php" class="formulario p-4">

                        <div id="input_validation"></div> 

                        <input type="hidden" name="cliente" id="cliente" class="form-control">
                            
                        <!-- VEHICULO -->
                        
                            <div class="row mt-3">
                                <section class="label">
                                    <label>Vehículo</label>
                                </section>
                                <section class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_vehiculo" id="id_vehiculo" required class="form-control" onchange="validarDocsYCarteraPorVehiculo(this.value); validarDatosForm(); listar_contratos(this.value); validarDocsConductor(this.value); ">
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($buscarVehiculoPorPropietario as $lvp){ 

                                            $hoy = date('Y-m-d');
                                            $fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
                                            $fecha2 = date('Y-m-d',$fecha2);
                                            $docs_vacios = $vehiculo->documentosvencidosPorId($lvp['id_vehiculo'],$hoy,$fecha2);
                          
                                            $pagos_pendientes = $concepto->pagosPendientesPorVehiculo($lvp['id_vehiculo']);

                                            $consultarAvalesActivosMesVehiculo = $cartera->consultarAvalesActivosMesVehiculo($lvp['id_vehiculo'], date('m'), date('Y'));
                                  
                                            $cant_carteraPendiente = (count($pagos_pendientes) + count($consultarAvalesActivosMesVehiculo));

                          
                                            if((count($docs_vacios) > 0) || ($cant_carteraPendiente > 0)){ ?>

                                                <option value="<?php echo $lvp['id_vehiculo'] ?>" style="color:red;font-weight:bolder">
                                                    <strong>
                                                      <?php
                                                          $listarVId = $vehiculo->listarPorId($lvp['id_vehiculo']);
                                                          echo $listarVId[0]['placa'];
                                                      ?>
                                                    </strong>
                                                </option>

                                            <?php }else{ ?>
                                              
                                                <option value="<?php echo $lvp['id_vehiculo'] ?>">
                                                    <?php
                                                        $listarVId = $vehiculo->listarPorId($lvp['id_vehiculo']);
                                                        echo $listarVId[0]['placa'];
                                                    ?>
                                                </option>

                                            <?php } ?>

                                        <?php } ?>
                                    </select>
                                </section>
                            </div>

                        <!-- CONDUCTOR -->
                          <div class="row ml-5 mb-3" class="mensaje_conductor" id="mensaje_conductor">
                              <div class="col-12 ml-5">
                                  
                              </div>
                          </div>

                        <!-- CONTRATO -->
                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>Contrato</label>
                                </div>
                                <div class="input">    
                                   <select class="form-control form-control-sm selectpicker" data-live-search="true" name="contrato" id="contrato" required="required" onchange="buscarresponsable(this.value); validarDatosForm(); validarClienteContrato(this.value);">
                                </select>
                                </div>
                            </div>
                            
                        <!-- ORIGEN -->
                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>Origen</label>
                                </div>
                                <div class="input">    
                                    <section class="row ml-1">
                                        <select class="col-10 form-control form-control-sm selectpicker" data-live-search="true" name="origen" id="origen" required="required" onchange="validarDatosForm();">
                                            <option value="">SELECCIONAR</option>
                                            <?php foreach ($listarCiudades as $ori){ ?>
                                                <option value="<?php echo $ori['ciudad'] ?>">
                                                    <?php echo $ori['ciudad'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <button id="cargarOrigen" type="button" class="btn btn-xs btn-outline-success col-1 m-1" onclick="cargar_origen()" style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-refresh" ></i></button>
                                    </section>
                                </div>
                            </div>

                        <!-- DESTINO -->
                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>Destino</label>
                                </div>
                                <div class="input">   
                                    <section class="row ml-1"> 
                                        <select class="col-10 form-control form-control-sm selectpicker" data-live-search="true" name="destino" id="destino" required="required" onchange="validarDatosForm();" >
                                            <option value="">SELECCIONAR </option>
                                            <?php foreach ($listarCiudades as $des){ ?>
                                                <option value="<?php echo $des['ciudad'] ?>">
                                                    <?php echo $des['ciudad'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <button id="cargarDestino" type="button" class="btn btn-xs btn-outline-success col-1 m-1" onclick="cargar_destino()" style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-refresh"></i></button>
                                    </section>
                                </div>
                            </div>

                        <!-- ANEXO -->
                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>Anexo</label>
                                </div>
                                <div class="input">    
                                    <input type="checkbox" name="anexo" id="anexo" class="form-control form-control-sm" style="max-width: 20px;">
                                </div>
                            </div>

                        <!-- FECHA FINAL -->

                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>Seleccionar Fecha Final</label>
                                </div>
                                <div class="input">    
                                   <input type="checkbox" name="cambiar_fecha" id="cambiar_fecha" class="form-control form-control-sm" style="max-width: 20px;" onclick="fecha()" value="S">
                                </div>
                            </div>

    		                    <div class="row mt-4 mb-4 " id="fecha_fuec" style="display:none">
                                <div class="label">    
                                    <label>Fecha Final</label>
                                </div>
                                <div class="input">    
                        	 	    <input type="text" name="fecha_final" id="datepicker" class="form-control form-control-sm" required="required" >
                                </div>
                            </div>

                        <!-- TIPO CONVENIO -->
                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>Tipo Extracto</label>
                                </div>
                                <div class="input">    
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="tipo_extracto" id="tipo_extracto" onchange="validarConvenioVehiculo(this.value);">
                                        <option value="" selected="selected">N/A</option>
                                        <option value="CONVENIO">CONVENIO</option>
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
                                   <input type="text" class="form-control form-control-sm" name="extracto_con" id="extracto_con" />
                                </div>
                            </div>

                        <!-- RESPONSABLE -->

                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>Nombre Responsable</label>
                                </div>
                                <div class="input">    
                                   <input type="text" class="form-control form-control-sm" name="nombre_responsable" id="nombre_responsable" required="required"/>
                                </div>
                            </div>

                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>No. Identificación</label>
                                </div>
                                <div class="input">    
                                   <input type="text" class="form-control form-control-sm" name="num_responsable" id="num_responsable" required="required"/>
                                </div>
                            </div>

                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>Dirección</label>
                                </div>
                                <div class="input">    
                                   <input type="text" class="form-control form-control-sm" name="dir_responsable" id="dir_responsable" required="required"/>
                                </div>
                            </div>

                            <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label>Télefono</label>
                                </div>
                                <div class="input">    
                                   <input type="text" class="form-control form-control-sm" name="tel_responsable" id="tel_responsable" required="required"/>
                                </div>
                            </div>

                        <!-- ***************************** -->

                        <!-- BOTONES -->
                        
                          <section class="col-12 mt-5 d-flex justify-content-center">
                              
                              <!-- CANCELAR REGISTRO -->
                                  <a href="extractosFijosPropietarios.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                              
                              <!-- VISTA PRELIMINAR -->
                                  <button type="button" id="boton_vista" style="display:none" class="btn btn-outline-info col-xs-12 col-sm-12 col-md-3 mr-3" onclick="vista_preliminar()">Vista Preliminar</button>
                              
                              <!-- REGISTRAR -->
                                  <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Registrar</button>
                          
                          </section>

                        <!-- ***************************** -->

                    </form>
              </div>
          </section>

      </section>
    
  <!-- FIN CONTENIDO -->

  <!-- ******************************* -->

  <!-- MODAL VALIDACIÓN DOCS Y CARTERA -->

    <div class="modal fade" id="ModalValidation" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
              <div class="col-12" style="height: auto;">
                <i style="color: #d62d2d; font-size: 6rem;" class="fa fa-exclamation-circle"></i>
                <h4 class="modal-title" style="color: #a1a1a1; "><strong>DOCUMENTACIÓN O CARTERA PENDIENTE</strong></h4>
              </div>
              <div class="col-12 mt-4" id="validationDocVencida" style="display:none;">
                <p>El vehiculo tiene documentación vencida, no se podrá emitir fuec con el vehículo hasta tener todo al día.</p>
              </div>
              
              <div class="col-12 mt-4" id="validationCartera" style="display:none;">
                <p>El vehiculo tiene cartera pendiente, no se podrá emitir fuec con el vehículo hasta tener los pagos al día</p>
              </div>
              
              <div class="col-12 mt-4" id="validationDocYCartera" style="display:none;">
                <p>El vehiculo tiene documentación vencida y cartera pendiente, no se podrá emitir fuec con el vehículo hasta tener todo al día.</p>
              </div>
            </div>
            <div class="col-12 modal-footer d-flex justify-content-center" style="border: 0px;">
              <button type="button" class="col-3 btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
      </div>
    </div>

  <!-- ******************************* -->

  <!-- SCRIPT -->

      <?php include("Template/scripts.php"); ?>

      <!--INICIO INPUT HORA-->
          <script type="text/javascript" src="../Resources/js/moment/moment.js"></script>
          <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
          
      <!--FIN INPUT HORA-->

      <script type="text/javascript">


          /* VALIDAR CLIENTE POR CONTRATO */

          function validarClienteContrato(id_contrato){

            var parametros = {
                "id_contrato" : id_contrato,  
            };
                  
            $.ajax({
                data:  parametros,
                url:   '../Controlador/validarClienteContrato.php',
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                  $("#cliente").val(response);
                }
            });          

          }

          /* VALIDACIÓN TRANSACCION PENDIENTES - EN CURSO*/

          function modalAviso(){
            if (<?php echo $cantTPU; ?> > 0) {
              alertify.alert('TRANSACCIÓN EN CURSO', '¡Actualmente tiene una transaccion con estado pendiente! \n no podra avanzar hasta terminar el debido proceso de la transacción o intentarlo nuevamente mas tarde \n  Si desea validar el estado de la misma dirijirse a la sección de historial de transacciones.', function(){ window.history.back(); });  
            } 
          }

          $(window).on("load", modalAviso());
      
          /* VALIDACION FECHA FINAL*/
          $( function() {
              $("#datepicker").datepicker({
                  dateFormat: "yy-mm-dd"
              });
          });


          function habilitarCampos(){
              $("#contrato").attr("disabled", false);   
              $("#origen").attr("disabled",false);                      
              $("#destino").attr("disabled",false);
              $("#anexo").attr("disabled",false);
              $("#cambiar_fecha").attr("disabled",false);
              $("#datepicker").attr("disabled",false);                 
              $("#nombre_responsable").attr("disabled",false);
              $("#num_responsable").attr("disabled",false);
              $("#dir_responsable").attr("disabled",false);
              $("#tel_responsable").attr("disabled",false);   
              $('#Registrar').attr("disabled", false);
          }


          /* LISTAR CONVENIOS POR VEHÍCULO*/
          function validarConvenioVehiculo(tipo_extracto){
              var id_vehiculo = $('#id_vehiculo').val();

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

                                      $("#contrato").attr("disabled","disabled");   
                                      $("#origen").attr("disabled","disabled");                      
                                      $("#destino").attr("disabled","disabled");
                                      $("#anexo").attr("disabled","disabled");
                                      $("#cambiar_fecha").attr("disabled","disabled");
                                      $("#datepicker").attr("disabled","disabled");                 
                                      $("#nombre_responsable").attr("disabled","disabled");
                                      $("#num_responsable").attr("disabled","disabled");
                                      $("#dir_responsable").attr("disabled","disabled");
                                      $("#tel_responsable").attr("disabled","disabled");   
                                      $('#Registrar').attr("disabled", true);
                                      $('#cargarOrigen').attr("disabled", true);
                                      $('#cargarDestino').attr("disabled", true);
                                      
                                      alertify.error('No se encontró convenio');

                                  }else{
                                      habilitarCampos();
                                      alertify.success('¡Se encontraron convenios activos!');
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

          /*LISTAR CONTRATOS POR VEHICULO*/
          function listar_contratos(id_vehiculo){
              
              if(id_vehiculo != ''){
                  var parametros = {
                      "id_vehiculo" : id_vehiculo,  
                  };
                  
                  $.ajax({
                      data:  parametros,
                      url:   '../Controlador/CargarContratosVehiculo.php',
                      type:  'POST',
                      beforeSend: function () {
                          $("#contrato").html('<option value="">Procesando, espere por favor...</option>');
                      },
                      success:  function (response) {
                          $("#contrato").html(response);
                          $('#contrato').selectpicker('refresh');
                          
                          if(document.getElementById('contrato').value == 0){
                              $("#contrato").attr("disabled","disabled");   
                              $("#origen").attr("disabled","disabled");                      
                              $("#destino").attr("disabled","disabled");                          
                              $("#anexo").attr("disabled","disabled");                               
                              $("#cambiar_fecha").attr("disabled","disabled");                               
                              $("#datepicker").attr("disabled","disabled");                 
                              $("#nombre_responsable").attr("disabled","disabled");                      
                              $("#num_responsable").attr("disabled","disabled");                      
                              $("#dir_responsable").attr("disabled","disabled");                      
                              $("#tel_responsable").attr("disabled","disabled");   
                              $('#Registrar').attr("disabled", true);
                              $('#cargarOrigen').attr("disabled", true);
                              $('#cargarDestino').attr("disabled", true);    
                          }else{
                              $("#contrato").attr("disabled", false);   
                              $("#origen").attr("disabled",false);                      
                              $("#destino").attr("disabled",false);                       
                              $("#anexo").attr("disabled", false);                              
                              $("#cambiar_fecha").attr("disabled", false);                              
                              $("#datepicker").attr("disabled",false);               
                              $("#nombre_responsable").attr("disabled",false);                      
                              $("#num_responsable").attr("disabled",false);                      
                              $("#dir_responsable").attr("disabled",false);                      
                              $("#tel_responsable").attr("disabled",false);     
                              $('#Registrar').attr("disabled", false);
                              $('#cargarOrigen').attr("disabled", false);
                              $('#cargarDestino').attr("disabled", false);  
                          }
                      }
                  });
                  
              }else{
                  $("#contrato").html('<option value="0">No existen contratos vigentes</option>');
              }
          }
          
          /*VERIFICAR DOCUMENTACIÓN DEL CONDUCTOR*/
          function validarDocsConductor(id_vehiculo){
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

                          $("#origen").prop("disabled", false);                     
                          $("#destino").prop("disabled", false);                      
                          $("#tipo_extracto").prop("disabled", false);                 
                          $("#extracto_con").prop("disabled", false);                      
                          $("#nombre_responsable").prop("disabled", false);                     
                          $("#num_responsable").prop("disabled", false);                     
                          $("#dir_responsable").prop("disabled", false);                      
                          $("#tel_responsable").prop("disabled", false);                      
                          $("#Registrar").prop("disabled", false);   
  		                  }	
                  }
              });
          }
          
          /* LISTAR PERSONA RESPONSABLE DEL CONTRATO SELECCIONADO*/
          function buscarresponsable(contrato){
              
              if(contrato != ''){
                  var parametros = {
                      "contrato" : contrato
                  };
                  $.ajax({
                      data:  parametros,
                      url:   '../Modelo/CargarResponsable.php',
                      type:  'post',
                      beforeSend: function () {
                          //alert('envio');
                          //$("#semana").html("Procesando, espere por favor...");
                      },
                      success:  function (response) {
                          //alert(response);
                          if(response != ''){
                              var datos_responsable = response.split('|');
                              document.getElementById('nombre_responsable').value = datos_responsable[0];
                              document.getElementById('num_responsable').value = datos_responsable[1];
                              document.getElementById('dir_responsable').value = datos_responsable[2];
                              document.getElementById('tel_responsable').value = datos_responsable[3];
                          }else{
                              document.getElementById('nombre_responsable').value = '';
                              document.getElementById('num_responsable').value = '';
                              document.getElementById('dir_responsable').value = '';
                              document.getElementById('tel_responsable').value = '';
                          }
                      }
                  });
              } else {
                  document.getElementById('nombre_responsable').value = '';
                  document.getElementById('num_responsable').value = '';
                  document.getElementById('dir_responsable').value = '';
                  document.getElementById('tel_responsable').value = '';
              }
          }

          /*VALIDAR DATOS DEL FORMULARIO*/
          function validarDatosForm(){
              var id_vehiculo = document.getElementById('id_vehiculo').value;
              var id_contrato = document.getElementById('contrato').value;
              var origen = document.getElementById('origen').value;
              var destino = document.getElementById('destino').value;
              
              //alert(id_vehiculo + ' - ' + id_contrato + ' - ' + origen + ' - ' + destino );
              
              if((id_vehiculo != '') && (id_contrato != '') && (origen != '') && (destino != '')){
                  document.getElementById('boton_vista').style.display = 'block';
              }else{
                  document.getElementById('boton_vista').style.display = 'none';
              }
          }
          
          /* RECARGAR ORIGEN*/
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
                      //alert('envio');
                      $("#origen").html("<option value=''>Procesando, espere por favor...</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#origen").html(response);
  		            $('#origen').addClass("selectpicker").selectpicker('refresh');
                  }
              });
  	      }
  	    
    	    /* RECARGAR DESTINO */
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
                        //alert('envio');
                        $("#destino").html("<option value=''>Procesando, espere por favor...</option>");
                    },
                    success:  function (response) {
                        //alert(response);
                        $("#destino").html(response);
    		            $('#destino').addClass("selectpicker").selectpicker('refresh');
                    }
                });
    	    }
  	    
  	      /* VALIDAR DOCUMENTACION VENCIDA O PENDIENTE Y CARTERA*/
  	      function validarDocsYCarteraPorVehiculo(id_vehiculo){
              var parametros = {
                  "id_vehiculo" : id_vehiculo,
              };

              $.ajax({
                  data: parametros,
                  url: '../Controlador/validarDocsYCarteraPorVehiculo.php',
                  type: 'POST',
                  beforeSend: function(){
                      
                  },
                  success: function(response){
                      //alert(response);
                      $('#input_validation').html(response);
                
                      var validacion = document.getElementById('validacion_doc_cartera').value;
                      //alert(validacion);

                      setTimeout(function(){ 

                          if((validacion == 1) || (validacion == 2) || (validacion == 3)){
                              $('#ModalValidation').modal('show');
                        
                              $("#contrato").attr("disabled","disabled");   
                              $("#origen").attr("disabled","disabled");                      
                              $("#destino").attr("disabled","disabled");                          
                              $("#anexo").attr("disabled","disabled");                               
                              $("#cambiar_fecha").attr("disabled","disabled");                               
                              $("#datepicker").attr("disabled","disabled");                 
                              $("#nombre_responsable").attr("disabled","disabled");                      
                              $("#num_responsable").attr("disabled","disabled");                      
                              $("#dir_responsable").attr("disabled","disabled");                      
                              $("#tel_responsable").attr("disabled","disabled");   
                              $('#Registrar').attr("disabled", true);
                              $('#cargarOrigen').attr("disabled", true);
                              $('#cargarDestino').attr("disabled", true);  
                          }else{
                              $('#ModalValidation').modal('hide');
                              
                              $("#contrato").attr("disabled", false);   
                              $("#origen").attr("disabled",false);                      
                              $("#destino").attr("disabled",false);                       
                              $("#anexo").attr("disabled", false);                              
                              $("#cambiar_fecha").attr("disabled", false);                              
                              $("#datepicker").attr("disabled",false);               
                              $("#nombre_responsable").attr("disabled",false);                      
                              $("#num_responsable").attr("disabled",false);                      
                              $("#dir_responsable").attr("disabled",false);                      
                              $("#tel_responsable").attr("disabled",false);     
                              $('#Registrar').attr("disabled", false);
                              $('#cargarOrigen').attr("disabled", false);
                              $('#cargarDestino').attr("disabled", false);  
                          }
                      
                          if(validacion == 1){
                              document.getElementById('validationDocVencida').style.display = 'flex';  
                              document.getElementById('validationCartera').style.display = 'none';  
                              document.getElementById('validationDocYCartera').style.display = 'none';   
                          }else if(validacion == 2){
                              document.getElementById('validationCartera').style.display = 'flex';
                              document.getElementById('validationDocVencida').style.display = 'none';  
                              document.getElementById('validationDocYCartera').style.display = 'none'; 
                          }else if(validacion == 3){
                              document.getElementById('validationDocYCartera').style.display = 'flex';
                              document.getElementById('validationDocVencida').style.display = 'none';  
                              document.getElementById('validationCartera').style.display = 'none'; 
                          }else{
                              document.getElementById('validationDocVencida').style.display = 'none';
                              document.getElementById('validationCartera').style.display = 'none';
                              document.getElementById('validationDocYCartera').style.display = 'none';
                          }

                      }, 100);

                  }
              });
          }

          /* VALIDACION HABILITAR SELECCION FECHA FINAL*/
          function fecha(){
  	          var checkbox = document.getElementById('cambiar_fecha');
  	          var checked = checkbox.checked;
    		    
              if(checked){
      			    document.getElementById('fecha_fuec').style.display = 'flex';
    		      } else {
  			        document.getElementById('fecha_fuec').style.display = 'none';
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
                      //alert(response);
                      if(response != ''){
                          window.open('formato_borrador.php?id='+response);
                      } else {
                          alert('Error al crear vista preliminar, intente nuevamente');
                      }
                  }
              });
          }
          
      </script>

  <!-- FIN SCRIPT -->

</body>
</html>