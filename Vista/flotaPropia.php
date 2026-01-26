<?php 
include("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/FlotaPropia.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/General.php");

$vehiculo =  $_POST['id_vehiculo'];
$rango_inicial =  $_POST['fecha_inicial'];
$rango_final =  $_POST['fecha_final'];

if ($vehiculo == 0) {
   $id_vehiculo = '%';
}else{
    $id_vehiculo = $_POST['id_vehiculo'];
}



$fecha_inicial = explode('-', $rango_inicial);
$mesInicial = $fecha_inicial[1];
$añoInicial = $fecha_inicial[0];

$fecha_final = explode('-', $rango_final);
$mesFinal = $fecha_final[1];
$añoFinal = $fecha_final[0];

$flotaPropia = new FlotaPropia();
$listar = $flotaPropia->filtrar($mesInicial, $añoInicial, $mesFinal, $añoFinal, $id_vehiculo);

$vehiculo = new Vehiculo();
$listarPorId = $vehiculo->listarPorId();

$listarDescuentosPorIdFlota = $flotaPropia->listarDescuentosPorId($id_flota_propia);

 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Flota Propia</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <!--fin  styles -->

</head>
<body>
    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Flota Propia</li>
         </ol>
    </div>
    
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col">
    		<h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-bus" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Flota Propia</h2>
    	</div>

      <div class="col d-flex justify-content-end">
            <a href="registrarDetalleFlotaPropia.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Ingresar detalle <span class="fa fa-plus"></span></a>
      </div>

    </div>
    <hr style="background-color:#5e99b1;">



    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
    		<thead>
    			<tr>
              <th>VEHICULO</th>
              <th>N° RECORRIDOS</th>
              <th>DIAS LABORADOS</th>
              <th>VALOR GENERADO</th>
              <th>DESCUENTOS</th>
              <th>VALOR A PAGAR</th>                  
              <th>FECHA DEL MOVIMIENTO</th> 
    			</tr>
    		</thead>
            <tbody>
                <?php foreach ($listar as $l){ ?>
                    <tr>
                        <td>
                            <?php
                                $listarPorId = $vehiculo->listarPorId($l['id_vehiculo']);

                                foreach ($listarPorId as $lpi) {                                
                                    echo $lpi['placa']; 
                                }
                            ?>      
                        </td>
                        <td><?php echo $l['numero_recorridos']; ?></td>
                        <td><?php echo $l['dias_laborados'] . ' dias'; ?></td>
                        <td><?php echo '$' . number_format($l['valor_generado'],0); ?></td>
                        <td><?php 
                                $listarTotalDescuentosPorId = $flotaPropia->listarTotalDescuentosPorId($l['id_flota_propia']);

                                foreach ($listarTotalDescuentosPorId as $ldpif) {
                                   echo '$' .number_format($ldpif['total_descuento'], 0);
                                }
                               
                            ?>
                            <a href="" data-toggle="modal" data-target="#exampleModal" onclick="listarDescuentos(<?php echo $l['id_flota_propia'];?>)">
                                <span class="fa fa-eye"></span>
                            </a>
                        </td>
                        <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Descuentos aplicados</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                      <section id="contenido_modal">
                                        
                                      </section>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <td>
                          <?php
                              $listarTotalAPagarPorFlota = $flotaPropia->listarTotalAPagarPorFlota($l['id_flota_propia']);
                              foreach ($listarTotalAPagarPorFlota as $tpf) {
                                echo '$' . number_format($tpf['totalPagar']);
                              }
                          ?>
                        </td>
                        <td>
                            <?php 
                                $fechaMovimiento =  explode('-', $l['fecha_movimiento']);
                                $año = $fechaMovimiento[0];
                                $mes = $fechaMovimiento[1];

                                $convertirMes = mes($mes);

                                echo ucfirst($convertirMes) . ' de ' . $año;
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
    	</table>
    </div>
    
    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?>

  <script type="text/javascript">
        function listarDescuentos(id_flota_propia){
          //alert(id_flota_propia);
           var parametros = {
                        "id_flota_propia" : id_flota_propia
                };
                $.ajax({
                        data:  parametros, //datos que se envian a traves de ajax
                        url:   '../Controlador/listarDescuentos.php' , //archivo que recibe la peticion
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
  </script>

  
</body>
</html>