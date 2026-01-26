 <?php 
include("../Controlador/Sesion/autenticar.php");

require_once ("../Modelo/ConceptosCobro.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cartera.php");
require_once("../Modelo/Fuec.php");

$id_usuario = $_SESSION['id_usuario'];

$concepto = new ConceptoCobro();
$vehiculo = new Vehiculo();
$contrato = new Contrato();
$usuario = new Usuario();
$cartera = new Cartera();
$fuec = new Fuec();

/*$fecha = date('Y-m-d');
$fecha1 = date("Y-m-d",strtotime($fecha."- 4 week")); 
$listar = $fuec->listarMes($fecha1);*/

$listarFuecPorIdEmisor = $fuec->listarFuecPorIdEmisor($id_usuario);


$buscarVehiculoPorPropietario = $vehiculo->buscarVehiculoPorPropietario($_SESSION['id_usuario']);
$listado_veh = '';
$i=1;

foreach($buscarVehiculoPorPropietario as $vp){
    
    if($i==count($buscarVehiculoPorPropietario)){
        $listado_veh .= $vp['id_vehiculo'];
    } else {
        $listado_veh .= $vp['id_vehiculo'].',';
    }   
    
$i++; 

}

$pagos_pendientes = $concepto->pagosPendientes($listado_veh);
$cant_carteraPendiente = count($pagos_pendientes);

$vehiculos_pagos_pendientes = array();
foreach ($pagos_pendientes as $pp) {
    array_push($vehiculos_pagos_pendientes, $pp['id_vehiculo']);
}


$vehiculos_pp = array_values(array_unique($vehiculos_pagos_pendientes));

$cant = 1;
$placa_vehiculos = '';

for ($i=0; $i < count($vehiculos_pp); $i++) { 
    $listarVehiculosPorId = $vehiculo->listarPorId($vehiculos_pp[$i]);
    
    if ($cant > 1) {
      $placa_vehiculos .= $listarVehiculosPorId[0]['placa'] . ' - '; 
    }

    $cant++;
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Extractos</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    
    <style type="text/css">
      

      .barra-principal{
        background-color: #5e99b1;
        width: auto;
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
        
          .fa-plus{
             display: none;
          }

          .titulo_principal{
            text-align: center;
          }

          .botones_principal{
            display: flex;
            justify-content: center;
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
                  <li class="breadcrumb-item active" aria-current="page">Extractos</li>
               </ol>
          </div>

          <div class="notice notice-sistemakv">
              <strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">EXTRACTOS</b></strong>
          </div>

          <div class="notice notice-sistemakv">
              <a href="registrarFuecPropietarios.php" id="buttonsKV" class="btn">Crear Extracto <i class="fa fa-plus"></i></a>
          </div>
    
          <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
            <table id="dataT" class="table table-sm display text-center" style="width:100%">
                <thead style="background-color: #1b2d3b; color: #fff;">
                    <tr>
                        <th>N° INTERNO</th>
                        <th>COMPROBANTE</th>
                        <th>ORIGEN</th>
                        <th>DESTINO</th>
                        <th>VEHÍCULO</th>
                        <th>CONTRATO</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listarFuecPorIdEmisor as $lfe){ ?>
                        <tr>
                            <td><?php echo $lfe['num_interno']; ?></td>
                            <td><?php echo $lfe['num_comprobante']; ?></td>
                            <td><?php echo $lfe['origen']; ?></td>
                            <td><?php echo $lfe['destino']; ?></td>
                            <td><?php 
                                if($lfe['id_vehiculo'] == '0'){
                                    echo 'N/A';
                                } else {
                                    $placa = $vehiculo->listarPorId($lfe['id_vehiculo']);
                                    echo $placa[0]['placa'];
                                }
                                ?>
                            </td>
                    
                            <td><?php if($lfe['id_contrato'] == '0'){
                                    echo 'N/A';
                                } else {
                                    $numero = $contrato->listarId($lfe['id_contrato']);
                                    echo $numero[0]['id_contrato'];
                                }
                                 ?>       
                            </td>
                            <td>
                                <?php $cod = base64_encode($lfe['id_fuec']);?>
                                <a href="formato_fuec.php?id=<?php echo $cod; ?>" target="_blank" class="btn btn-outline-info" style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-search"></i></a>
                            </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
          </div>
    
    </section>

    <!-- FIN CONTENIDO -->

    <!----------------------------------->
    <!------------ MODALES -------------->
    <!----------------------------------->

    <?php if (($cant_carteraPendiente > 0) ){ ?>
        
        <div class="modal fade" id="carteraPendiente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-body text-center" id="modal-body" >
                        <div class="col-12" style="height: auto;">
                            <i style="color: #d62d2d; font-size: 6rem;" class="fa fa-exclamation-circle"></i>
                            <h4 class="modal-title" style="color: #a1a1a1; "><strong>CARTERA PENDIENTE</strong></h4>
                        </div> 
                        <div class="col-12 mt-3">
                            <p>El/los vehículo/s <strong><?php echo $placa_vehiculos ?></strong> anclado/s a su usuario tiene/n cartera pendiente, por favor póngase al día con los pagos para poder emitir extractos con el vehiculo. </p>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <a type="button" href="inicioPropietarios.php" class="btn btn-danger" data-dismiss="modal" style="color: #fff;">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
    <!-- FIN CONTENIDO -->

  <!-- script -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

      function modalAviso(){
        
        $("#carteraPendiente").modal("show");   
      }

      $(window).on("load", modalAviso());

      function validarDocsConductor(id_vehiculo){
            var parametros = {
              "id_vehiculo" : id_vehiculo,
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/VerificarDocConductorPorVehiculo.php',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (response) {
                    $("#mensaje_conductor").html(response);

                    var con = document.getElementById('verificarDocsConductor').value;
                      if(con == 1){

                        $("#duplicar").attr("disabled","disabled");                 

                      }
                }
            });
      }

      function listar_vehiculos(contrato){
          var contrato = contrato;
          //alert(contrato);
          if(contrato != ''){
              //alert(contrato);
              var parametros = {
              "contrato" : contrato
              };
              $.ajax({
                data:  parametros,
                url:   '../Modelo/CargarVehiculosPorContrato.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                    //$("#semana").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                    //alert(response);
                    $("#vehiculo").html(response);
                }
              });
          } else {
              $("#vehiculo").html('<option value="">No existen vehiculos</option>');
          }    
      }

      function veh(id_vehiculo){
        
        //alert(colegio);
        if(id_vehiculo == 0){
          //alert(contrato);
            var parametros = {
              "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                data:  parametros,
                url:   '../Modelo/CargarVehiculosPorContrato.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                    $("#vehiculo").html("<option value=''>Procesando, espere por favor...</option>");
                },
                success:  function (response) {
                    //alert(response);
                    $("#vehiculo").html(response);
                }
            });
        }
      }

      function id_fuec(id, contrato){
          document.getElementById('id_contrato').value = contrato;
          document.getElementById('id_fuec').value = id;
      }

    </script>

  
</body>
</html>