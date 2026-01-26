<?php 
include("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");

$vehiculo = new Vehiculo();
$usuario = new Usuario();
$conceptosCobro = new ConceptoCobro();

$listarComprobantesPagos = $conceptosCobro->ListarComprobantes();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Comprobantes de Pago</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
        
        <style type="text/css">
        
          #buttonExcel {
            width: 150px;
            color: #1d9c72;
            border: 1px solid #1d9c72;
            border-radius: 5px;
            cursor: pointer;
          }

          #buttonExcel:hover {
              color: #fff;
              background-color: #1d9c72;
              transition-duration: .8s;
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
                  <li class="breadcrumb-item " aria-current="page"><a href="conceptos_cobro.php">Servicios Cartera</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Comprobantes de pago</li>
               </ol>
          </div>

          <div class="notice notice-sistemakv">
              <strong><i class="fa fa-file-text mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">COMPROBANTES DE PAGO</b></strong>
          </div>

          <div class="mt-2" style="height: auto; padding: 2px; width: 100%; background-color: #fff; border-radius: 10px;">
              <section class="row ml-3">
                  <div id="buttonExcel" class="text-center m-1 pl-2 pr-2" onclick="validarReporte('1');">Reporte Diario<i class="fa fa-file-excel-o ml-1"></i></div>
                  <div id="buttonExcel" class="text-center m-1 pl-2 pr-2" data-toggle="modal" data-target="#reportSemanal">Reporte por Rango<i class="fa fa-file-excel-o ml-1"></i></div>
              </section>
          </div>

          <div class="col-12 p-4 mt-2" style="background-color: #fff;">
            <table id="dataT" class="table table-sm">
                <thead style="background-color: #1b2d3b; color: #fff;">
                    <tr class="text-center">
                      <th><b>ID</b></th>
                      <th><b>N° COMPROBANTE</b></th>
                      <th><b>VEHICULO</b></th>
                      <th><b>TOTAL PAGADO</b></th>
                      <th><b>VALOR CONCEPTO</b></th>
                      <th><b>CONCEPTO</b></th>
                      <th><b>BANCO CONSIGNACIÓN</b></th>
                      <th><b>USUARIO REGISTRANTE</b></th>
                      <th><b>FECHA DE REGISTRO</b></th>
                      <th><b>COMPROBANTE</b></th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($listarComprobantesPagos as $cp){ 

                    $listarCobroId = $conceptosCobro->listarPorIdCobrosPropietario($cp['id_cobro_propietario']);
                    $listarConceptoId = $conceptosCobro->listarPorId($listarCobroId[0]['id_concepto']);
                    $listarVehiculoID = $vehiculo->listarPorId($listarCobroId[0]['id_vehiculo']);
                    $listarBancosId = $conceptosCobro->listarBancosId($cp['banco_consignacion']);
                    $listarUsuarioPorId = $usuario->listarUsuarioPorId($cp['usuario_registro']);

                    ?>
                    <tr class="text-center">
                      <td><?php echo $cp['id_comprobante']; ?></td>
                      <td><?php echo $cp['num_id_comprobante']; ?></td>
                      <td><?php echo $listarVehiculoID[0]['placa'] . ' | ' . $listarVehiculoID[0]['numero_movil']; ?></td>
                      <td><strong>$</strong> <?php echo number_format($cp['valor_pagado']); ?></td>
                      <td><strong>$</strong> <?php echo number_format($listarCobroId[0]['valor']); ?></td>
                      <td>
                          <?php 
                              $fecha_cobro = explode("-", $listarCobroId[0]['fecha_cobro']); 
                              echo $listarConceptoId[0]['detalle_concepto'] . ' - ' . strtoupper(mes($fecha_cobro[1])); 
                          ?>
                      </td>
                      <td> <?php echo $listarBancosId[0]['descripcion']; ?> </td>
                      <td><?php echo $listarUsuarioPorId[0]['nombre'] ?></td>
                      <td><?php echo $cp['fecha_registro_comprobante']; ?></td>
                      <?php if($cp['referencia_transaccion'] != NULL){ ?>
                        <td><?php echo $cp['referencia_transaccion']; ?></td>
                      <?php } else { ?>
                        <td><a href="../Documentos/Comprobantes/<?php echo $cp['comprobante_pago'] ?>" target="_blank">Comprobante pago <i class="fa fa-eye"></i></a></td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                </tbody>
            </table>
          </div>

      </section>

      
      <!-- Modal -->
      <div class="modal fade" id="reportSemanal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-body">
                    <form action="Excel/excelComprobantesPago.php" method="POST">
                        <b class="text-center">REPORTE SEMANAL</b>
                        <hr>
                        <section class="row">
                            <!--NOMBRE AREA-->
                              <div class="col-6 mt-3">
                                  <label>Fecha Inicial</label>
                                  <input type="text" name="fecha_inicial" id="fecha_inicial" value="<?php echo $li['nombre_area'] ?>" class="form-control form-control-sm">
                              </div>

                            <!--NOMBRE AREA-->
                              <div class="col-6 mt-3">
                                  <label>Fecha Final</label>
                                  <input type="text" name="fecha_final" id="fecha_final" class="form-control form-control-sm">
                              </div>

                        </section>
                        <hr>
                        <section class="row d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-danger mr-2" data-dismiss="modal">Cerrar</button>
                            <button type="submit" target="_blank" class="btn" id="buttonsKV">Exportar</button>
                        </section>
                    </form>
                </div>
              </div>
          </div>
      </div>
    
    <!-- FIN CONTENIDO -->


  <!-- SCRIPT -->
  <?php include("Template/scripts.php"); ?>
  <script>

      function validarReporte(val){

          const parametros = {
              "tipo_reporte": val
          };

          $.ajax({
              data: parametros,
              url: 'Excel/excelComprobantesPago.php',
              type: 'POST',
              beforeSend: function() {},
              success: function(response) {
                return response;
              }
          });
      }

      $( function(){

          $( "#fecha_inicial" ).datepicker({ 
              dateFormat:'yy-mm-dd',
              changeMonth:true,
              changeYear:true,
              monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
              monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
              dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
              dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
              dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
          });

          $( "#fecha_final" ).datepicker({ 
              dateFormat:'yy-mm-dd',
              changeMonth:true,
              changeYear:true,
              monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
              monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
              dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
              dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
              dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
          });
      
      });

  </script>

  
</body>
</html>