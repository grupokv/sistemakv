<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Administracion.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");

$vehiculo = new vehiculo();
$administracion = new Administracion();

$listarPermisosModVehiculosIdUsuario = $administracion->listarPermisosModVehiculosIdUsuario($_SESSION['id_usuario']);
$listarV = $vehiculo->listar();


$usuario = new Usuario();

$modulo = 11;
$permisos = permisos($modulo,$_SESSION['id_usuario']);
//print_r($permisos);
if(count($permisos) < 1){
	echo ("<script LANGUAGE='JavaScript'>
    window.location.href='https://www.sistemakv.com/';
    </script>");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Vehiculos</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->

    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style>
        .modal-backdrop{
          z-index: 2;
        }

        th {
            border-radius: 13px;
            border: 3px solid #fff;
            background-color: #274054;
            color: #fff;
            padding: 10px;
        }

        #dataTable thead {
            background-color: #fff;
        }

        #dataTable table {
            font-size: .8rem;
        }

        #dataTable tr {
            background-color: #fff;
        }

        #dataTable th {
            border-radius: 13px;
            border: 3px solid #fff;
            background-color: #274054;
            color: #fff;
        }

    </style>

  <!--FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

  <!--**************************--->
  
  <!-- CONTENIDO -->
  
  <section class="home_content">  
    
      <div class="notice notice-sistemakv">
          <strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">VEHÍCULOS</b></strong>
      </div>

      <div class="notice notice-sistemakv p-2">
          <?php if($permisos[0]['agregacion'] == 1){ ?>
            <a id="buttonsKV" href="registrarVehiculos.php" class="btn m-1"> Nuevo Vehículo<i class="fa fa-plus-circle ml-1"></i></a>
          <?php } ?>
          <?php if($permisos[0]['consulta'] == 1){ ?>
              <a id="buttonsKV" href="reporteVehiculos.php" class="btn m-1">Reporte <i class="fa fa-clipboard ml-1"></i></a>
              <?php if ($_SESSION['id_usuario'] == 1){ ?>
                  <a id="buttonsKV" href="reporteVehiculosActualizacionesDocumentos.php" class="btn m-1">Reporte Modificaciones<i class="fa fa-clipboard ml-1"></i></a>
              <?php } ?>
          <?php } ?>
      </div>

      <div class="mt-2 mb-4 table-responsive p-4" style="background-color: #fff; border-radius: 5px;">
      	  <table id="dataTable" class="table table-hover table-sm display" style="width:100%;">
          		<thead style="background-color: #1b2d3b; color: #fff;">
          			<tr class="text-center">
                  <th style="vertical-align: top;">ID</th>
                  <th style="vertical-align: top;">PLACA</th>
                  <th style="vertical-align: top;">MARCA Y LINEA</th>
                  <th style="vertical-align: top;">MODELO</th>
                  <th style="vertical-align: top;">TIPO VEHICULO</th>
                  <th style="vertical-align: top;">CANTIDAD DE PASAJEROS</th>
                  <th style="vertical-align: top;">SERVICIO</th>
                  <th style="vertical-align: top;">MOVIL</th>
                  <th style="vertical-align: top;" style="width: 50px;">PROPIETARIO</th>
                  <th style="vertical-align: top;" style="width: 15px;">ESTADO</th>
          				<th style="vertical-align: top;">OPCIONES</th>
          			</tr>
          		</thead>
        		  <tbody>
                <?php foreach ($listarV as $lv){ ?>
                  <tr  class="text-center">
                      <td><?php echo $lv['id_vehiculo'] ?></td>
                      <td><?php echo $lv['placa'] ?></td>
                      <td><?php echo $lv['marca'] ?></td>
                      <td><?php echo $lv['modelo'] ?></td>
                      <td><?php echo $lv['nombre_tipo_vehiculo'] ?></td>
                      <td><?php if($lv['cant_pasajeros'] == 1){
                                echo $lv['cant_pasajeros'] . " Pasajero";
                          }else{
                                echo $lv['cant_pasajeros'] . " Pasajeros";
                          }?></td>
                      <td><?php echo $lv['nombre_tipo_servicio'] ?></td>
                      <td><?php echo $lv['numero_movil'] ?></td>
                      <td title="<?php echo $lv['telefono_propietario'];?>">
                        <?php
                          $listarUsuario = $usuario->listarPropietariosPorId($lv['id_propietario']);
                          echo $listarUsuario[0]['nombre'];
                        ?>
                      </td>
                      <td>
                          <?php 
                              if($lv['estado'] == 0){
                                echo "<div class='col-12' style='background-color: #c23e3e; border-radius: 25px; color: #fff;'>Inactivo</div>";
                              } else if($lv['estado'] == 1){
                                echo "<div class='col-12' style='background-color: #288211; border-radius: 25px; color: #fff;'>Activo</div>";
                              } else if($lv['estado'] == 2){
                                echo "<div class='col-12' style='background-color: #eda426; border-radius: 25px; color: #fff;'>Desvinculado</div>";
                              } else if($lv['estado'] == 3){
                                echo "<div class='col-12' style='background-color: #eda426; border-radius: 25px; color: #fff;'>Retirado </div>";
                              } 
                          ?>
                      </td>       
                      <td>

                          <?php if(($lv['estado'] == 2) || ($lv['estado'] == 3)){ ?>
                              <?php if($lv['soporte_cambio_estado'] != ""){ ?>
                                  <a href="../Documentos/Vehiculos/SoportesEstados/<?php echo $lv['soporte_cambio_estado']; ?>" target="_blank" class="btn btn-outline-warning"  style="margin: 2px; padding: 0px 4px 0px 4px;"><i class="fa fa-eye"></i></a>
                              <?php } ?>
                          <?php }else{ ?>
                              
                              <!-- Cambiar Estado -->
                                <?php if($permisos[0]['eliminacion'] == 1){ ?>
                                    <button onclick="modalCambiarEstado(<?php echo $lv['id_vehiculo'] ?>);" id="cambiar_estado" class="btn btn-outline-danger" style="margin: 2px;  padding: 0px 4px 0px 4px;"><i class="fa fa-lock"></i></button>
                                <?php } ?>

                              <!-- Actualizar -->

                                <?php if($permisos[0]['edicion'] == 1){ ?>
                                    <a href="actualizarVehiculo.php?id_vehiculo=<?php echo $lv['id_vehiculo'] ?>" class="btn btn-outline-info"  style="margin: 2px; padding: 0px 4px 0px 4px;"><i class="fa fa-edit"></i></a>
                                <?php } ?>

                              <!--Consultar Documentos-->
                                <?php if($permisos[0]['consulta'] == 1){ ?>
                                    <a href="" class="btn btn-outline-warning"  style="margin: 2px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#vehiModal" onclick="modal(<?php echo $lv['id_vehiculo'];?>)"><i class="fa fa-search"></i></a>
                                <?php } ?>

                              <!--Consultar Conductores y Contratos -->
                                <?php if($permisos[0]['consulta'] == 1){ ?>
                                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#condsVehiculos" style="margin: 2px; padding: 0px 4px 0px 4px;" onclick="modalCond(<?php echo $lv['id_vehiculo'];?>)"><i class="fa fa-users"></i></button>
                                
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#contratosVehiculos" style="margin: 2px; padding: 0px 4px 0px 4px;" onclick="modalContratos(<?php echo $lv['id_vehiculo'];?>)"><i class="fa fa-files-o"></i></button>
                                <?php } ?>

                          <?php } ?>
                          
                      </td>
                  </tr>
                <?php } ?>
        		  </tbody>
      	  </table>
      </div>
  </section>

    <!-- MODAL DOCUMENTACION -->
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
            <form action="actualizarVehiculo.php" method="GET">
                <input type="hidden" name="id_vehiculo" id="id_veh" value="">
                <?php if($permisos[0]['edicion'] == 1){ ?>
                  <button  type="submit" class="btn btn-outline-info">Actualizar información</button>
                <?php } ?>
            </form>
            </div>
          </div>
        </div>
      </div>

    <!--MODAL CONDUCTORES-->
        <div class="modal fade" id="condsVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content f-flex justify-content-center">
              <div class="modal-header">
                  <h5 class="modal-title " id="exampleModalLabel">CONDUCTORES ANCLADOS</h5>  
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <section id="contenido_modal_cond" name="contenido_modal_cond">

                  </section>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

    <!-- MODAL CONTRATOS-->
        <div class="modal fade" id="contratosVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content f-flex justify-content-center">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">CONTRATOS ANCLADOS</h5>  
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <section id="contenido_modal_contratos" name="contenido_modal_contratos">

                  </section>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

      <!-- MODAL ESTADO -->
      <div class="modal fade" id="modalEstados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content p-3">
                <form method="POST" action="../Controlador/bloquearDesbloquearVehiculo.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-12 text-center mb-3">
                            <h5 class="modal-title" id="exampleModalLabel" style="font-size: .9rem;"><b>ACTUALIZACIÓN DE ESTADO - VEHÍCULOS</b></h5>
                        </div>

                        <hr>

                        <div class="text-center" id="mensaje">
                          <p style="font-size: .8rem;">¿Esta seguro de realizar algún cambio de estado en este vehículo? </p>
                        </div>

                        <input type="hidden" id="id_vehiculo" name="id_vehiculo" class="form-control form-control-sm">

                        <div class="col-12 mt-4">
                            <label style="font-size: .8rem;">Estado</label>
                            <select class="form-control form-control-sm selectpicker" onchange="validarEstado(this.value);" data-live-search="true" name="estadoVehiculo" id="estadoVehiculo" title="Seleccionar">
                                <option value="0">Inactivar</option>
                                <option value="1">Activar</option>
                                <option value="2">Desvincular (Afiliados)</option>
                                <option value="3">Retirar (Terceros)</option>
                            </select>
                        </div>
                        
                        <div class="col-12 mt-4 p-3" id="docSoporteCambioEstado" style="border: 1px dashed #d1d1d1; display:none; ">
                            <label style="font-size: .8rem;">Documento Soporte (Paz y Salvo o Resolución de Desvinculación)</label>
                            <input type="file" class="form-control form-control-sm mt-1" name="docCambioEstado" id="docCambioEstado">
                        </div>

                        <hr>

                        <div class="col-12 d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-danger mr-2" data-dismiss="modal" style="font-size: .8rem;">CERRAR</button>
                            <button type="submit" name="enviar" class="btn btn-outline-primary" style="font-size: .8rem;">ACTUALIZAR</button>
                        </div>
                        
                    </div>
                </form>

              </div>
          </div>
      </div>


  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

        $(document).ready(function() {

            $('#dataTable').DataTable( {
                "order": [[ 0, "desc" ],[ 9, 'desc' ]]
            });

        } );

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

        function modalCond(id_vehiculo){
          /*alert(id_vehiculo);*/
          document.getElementById('id_veh').value = id_vehiculo;

          var parametros = {
                        "id_vehiculo" : id_vehiculo
                };
                $.ajax({
                        data:  parametros, //datos que se envian a traves de ajax
                        url:   '../Controlador/listarCondsVehiculo.php', //archivo que recibe la peticion
                        type:  'POST', //método de envio
                        beforeSend: function () {
                                $("#contenido_modal_cond").html("Procesando, espere por favor...");
                        },
                        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                                //alert(response);
                                $("#contenido_modal_cond").html(response);
                        }
                });
        }

        function modalContratos(id_vehiculo){
          /*alert(id_vehiculo);*/

          var parametros = {
                        "id_vehiculo" : id_vehiculo
                };
                $.ajax({
                        data:  parametros, //datos que se envian a traves de ajax
                        url:   '../Controlador/listarContratosVehiculoModal.php', //archivo que recibe la peticion
                        type:  'POST', //método de envio
                        beforeSend: function () {
                                $("#contenido_modal_contratos").html("Procesando, espere por favor...");
                        },
                        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                                //alert(response);
                                $("#contenido_modal_contratos").html(response);
                        }
                });
        }

        function modalCambiarEstado(id_vehiculo){
           $("#modalEstados").modal("show");
           $("#id_vehiculo").val(id_vehiculo);
        }

        function validarEstado(val){
            if((val == 2) || (val == 3)){
                $("#docSoporteCambioEstado").css("display", "block");
            }else{
                $("#docSoporteCambioEstado").css("display", "none");
            }
        }


  </script>



  
</body>
</html>