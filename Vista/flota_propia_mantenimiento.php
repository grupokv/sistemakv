<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/ReporteFlotaPropia.php");
require_once("../Modelo/Usuario.php");

$vehiculo = new vehiculo();
$listarV = $vehiculo->listarVehiculoFlotaPropia();

$usuario = new Usuario();
$tipo_vehiculo = new TipoVehiculo();
$reporte_fp = new ReporteFlotaPropia();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Flota Propia</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <style type="text/css">
    
    @media (max-width: 760px){
      
        .icono-principal{
          display: none;
        }

        .fa-plus{
           display: none;
        }
    }

    .barra-principal{
      background-color: #5e99b1;
    }

  </style>
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
    <div class="row barra-principal">
    	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-6">
    		  <h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-car" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Flota Propia - Mantenimiento</h2>
    	</div>
    </div>

    <hr style="background-color:#5e99b1;">
      <div class="mt-2 p-4 table-responsive">
    	  <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
      		<thead>
      			<tr>
              <th>PLACA</th>
              <th>MARCA Y LINEA</th>
              <th>MODELO</th>
              <th>TIPO VEHICULO</th>
              <th>CANTIDAD DE PASAJEROS</th>
              <th>KILOMETRAJE ACTUAL</th>
              <th>MOVIL</th>
              <th>PROPIETARIO</th>
              <th>ESTADO</th>
      				<th>OPCIONES</th>
      			</tr>
      		</thead>
    		  <tbody>
            <?php foreach ($listarV as $lv){ ?>
              <tr>
                  <td><?php echo $lv['placa'] ?></td>
                  <td><?php echo $lv['marca'] ?></td>
                  <td><?php echo $lv['modelo'] ?></td>
                  <td><?php $tip = $tipo_vehiculo->listarPorId($lv['id_tipo_vehiculo']); echo $tip[0]['nombre_tipo_vehiculo'];  ?></td>
                  <td><?php if($lv['cant_pasajeros'] == 1){
                            echo $lv['cant_pasajeros'] . " Pasajero";
                      }else{
                            echo $lv['cant_pasajeros'] . " Pasajeros";
                      }?></td>
                  <td><?php $rep = $reporte_fp->listarPorVehiculo($lv['id_vehiculo']); echo $rep[0]['kilometraje'];?></td>
                  <td><?php echo $lv['numero_movil'] ?></td>
                  <td>
                    <?php
                      $listarUsuario = $usuario->listarPropietariosPorId($lv['id_propietario']);
                      echo $listarUsuario[0]['nombre'];
                    ?>
                  </td>
                  <td>
                    <?php 
                      if($lv['estado'] == 1){
                        echo "Activo";
                      } else{
                        echo "Inactivo";
                      } 
                    ?>
                  </td>       
                  <td>
                    
                      <!-- Actualizar -->

                          <a href="registrarOrdenServicio.php?id=<?php echo $lv['id_vehiculo'] ?>" class="btn btn-outline-success"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-wrench"></span></a>

                      <!--Consultar-->
                        <a href="" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#vehiModal" onclick="modal(<?php echo $lv['id_vehiculo'];?>)"><span class="fa fa-search"></span></a>

                  </td>
                      <!-- Modal -->
                          <div class="modal fade" id="vehiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog " role="document">
                              <div class="modal-content f-flex justify-content-center">
                                <div class="modal-header">
                                    <h5 class="modal-title " id="exampleModalLabel">Documentación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <section id="contenido_modal" name="contenido_modal">

                                    </section>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                                <form action="" method="GET">
                                    <input type="hidden" name="id_vehiculo" id="id_veh" value="">
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
              </tr>
            <?php } ?>
    		  </tbody>
    	  </table>
      </div>
    
    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">


function modal(id_vehiculo){
  /*alert(id_vehiculo);*/
  document.getElementById('id_veh').value = id_vehiculo;

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


  </script>



  
</body>
</html>