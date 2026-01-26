 <?php 
include("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/Fuec.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");

$fuec = new Fuec();
$fecha = date('Y-m-d');
$fecha1 = date("Y-m-d", strtotime($fecha."- 8 week")); 
$listar = $fuec->listarMes($fecha1);
//print_r($listar);

$vehiculo = new Vehiculo();
$contrato = new Contrato();
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

  <!-- FIN STYLES -->

</head>
<body>

<!--MENU-->
    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>
<!--FIN MENU-->

<!-- *************************** -->  
<!-- CONTENIDO -->

    <section class="home_content">

        <div aria-label="breadcrumb" class="mt-1"> 
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Extractos</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
          <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">EXTRACTOS</b></strong>
        </div>


        <div class="notice notice-sistemakv">

            <a  id="buttonsKV"  href="registrarFuec.php" class="btn btn-outline-info">
                Crear Extracto 
                <i class="fa fa-plus"></i>
            </a>

            <a id="buttonsKV" href="reporteFuec.php" class="btn btn-outline-info">
                Reporte 
                <i class="fa fa-file-text-o"></i>
            </a>

        </div>

        <div class="mt-2 p-4 table-responsive" style="background: #fff; border-radius: 5px;">
        	<table id="dataTable" class="table table-hover table-sm display text-center" style="width:100%">
          		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr>
                      <th style="vertical-align: top;">ID</th>
                      <th style="vertical-align: top;">NUM INTERNO</th>
                      <th style="vertical-align: top;">COMPROBANTE</th>
                      <th style="vertical-align: top;">ORIGEN</th>
                      <th style="vertical-align: top;">DESTINO</th>
            				  <th style="vertical-align: top;">VEHICULO</th>
                      <th style="vertical-align: top;">CONTRATO</th>
            				  <th style="vertical-align: top;">OPCIONES</th>
            			</tr>
          		</thead>
          		<tbody>
                  <?php foreach ($listar as $lu){ ?>
                      <tr>
                          <td><?php echo $lu['id_fuec'] ?></td>
                          <td><?php echo $lu['num_interno'] ?></td>
                          <td><?php echo $lu['num_comprobante'] ?></td>
                          <td><?php echo $lu['origen']?></td>
                          <td><?php echo $lu['destino'] ?></td>
                          <td><?php 
                              if($lu['id_vehiculo'] == '0'){
                                  echo 'N/A';
                              } else {
                                  $placa = $vehiculo->listarPorId($lu['id_vehiculo']);
                                  echo $placa[0]['placa'];
                              }
                              ?>
                          </td>
  				
                          <td><?php if($lu['id_contrato'] == '0'){
                                  echo 'N/A';
                              } else {
                                  $numero = $contrato->listarId($lu['id_contrato']);
                                  echo $numero[0]['id_contrato'];
                              }
                               ?>       
                          </td>
                          <td>
                              <?php $cod = base64_encode($lu['id_fuec']);?>
                              <a href="formato_fuec.php?id=<?php echo $cod; ?>" target="_blank" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
                                      <span class="fa fa-search"></span>
                              </a>

                              <button class="btn btn-outline-success" data-toggle="modal" data-target="#duplicarFuec" onclick="listar_vehiculos(<?php echo $lu['id_contrato'];?>); id_fuec(<?php echo $lu['id_fuec'];?>, <?php echo $lu['id_contrato'];?>);" style="margin: 0px; padding: 0px 4px 0px 4px;">
                                      <span class="fa fa-files-o"></span>
                              </button>
                          </td>
                      </tr>
                  <?php } ?>
          		</tbody>
        	</table>
        </div>
        
    </section>

    <!-- MODAL DUPLICAR EXTRACTO -->
        <div class="modal fade" id="duplicarFuec" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="../Controlador/duplicarFuec.php" method="POST">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="notice notice-sistemakv">
                              <strong><i class="fa fa-files-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">DUPLICAR EXTRACTO</b></strong>
                            </div>
                            
                            <!-- ID CONTRATO -->

                                <input type="hidden" name="id_contrato" id="id_contrato">

                            <!-- ID FUEC -->

                                <input type="hidden" name="id_fuec" id="id_fuec">
                            
                            <!-- VEHICULOS -->

                                <label class="mt-4 mb-2"><b>VEHÍCULO</b></label>   
                                <select class="form-control" data-live-search="true" name="vehiculo" id="vehiculo" onchange="validarDocsConductor(this.value); veh(this.value);"></select>

                            <div class="row mt-3 mb-3 p-4 text-center" class="mensaje_conductor" id="mensaje_conductor">
                                
                            </div>

                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-danger col-3 mr-2" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-outline-info col-3" name="duplicar" id="duplicar">Duplicar</button>
                        </div>                                        
                    </div>
                </form>

            </div>
        </div>

<!-- FIN CONTENIDO -->
<!-- *************************** -->


<!-- *************************** -->
<!-- SCRIPT -->

  <?php include("Template/scripts.php"); ?>

  <script type="text/javascript">

      $('#dataTable').DataTable( {
          "order": [[ 0, "desc" ]]
      });

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
          if(contrato != ''){
              var parametros = {
              "contrato" : contrato
              };
              $.ajax({
                data:  parametros,
                url:   '../Modelo/CargarVehiculosPorContrato.php',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (response) {
                  $("#vehiculo").html(response);
                }
              });
          } else {
              $("#vehiculo").html('<option value="">No existen vehiculos</option>');
          }
      }

      function veh(id_contrato){
        if(id_contrato == 0){
          //alert(contrato);
            var parametros = {
              "contrato" : id_contrato
            };
            $.ajax({
                data:  parametros,
                url:   '../Modelo/CargarVehiculosPorContrato.php',
                type:  'POST',
                beforeSend: function () {
                    $("#vehiculo").html("<option value=''>Procesando, espere por favor...</option>");
                },
                success:  function (response) {
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

<!-- FIN SCRIPT -->
<!-- *************************** -->
  
</body>
</html>