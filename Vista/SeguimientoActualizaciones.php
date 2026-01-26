<?php 
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/SeguimientoActualizacion.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Modulo.php';
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Conductor.php';

$seguimiento = new Seguimiento_Actualizacion();
$listarS = $seguimiento->listar();

$usuario = new Usuario();
$conductor = new Conductor();
$modulo = new Modulo();
$vehiculo = new Vehiculo();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Seguimiento Actualizaciones</title>
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

    <!--***************************-->
  
    <!-- CONTENIDO -->
      <section class="home_content">
          
          <div aria-label="breadcrumb" class="mt-1"> 
            <ol class="breadcrumb" style="background-color: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Actualizaciones Pendientes</li>
            </ol>
          </div>

          <div class="notice notice-sistemakv">
            <strong><i class="fa fa-envelope mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">SEGUIMIENTO DE SOLICITUDES PENDIENTES</b></strong>
          </div>

          <div class="col-12 mt-2 p-4 table-responsive" style="background-color: #fff;">  
            <table id="dataT" class="table table-hover table-sm display" style="width:100%">
                <thead style="background-color: #1b2d3b; color: #fff;">
                    <tr class="text-center">
                        <th  style="vertical-align: top;">ID</th>
                        <th  style="vertical-align: top;">USUARIO SOLICITANTE</th>
                        <th  style="vertical-align: top;">MODULO</th>
                        <th  style="vertical-align: top;">REGISTRO A MODIFICAR</th>
                        <th  style="vertical-align: top;">DOCUMENTO</th>
                        <th  style="vertical-align: top;">NOMBRE DOCUMENTO</th>
                        <th  style="vertical-align: top;">FECHA DE VENCIMIENTO O EXPEDICIÓN</th>
                        <th  style="vertical-align: top;">ESTADO</th>
                        <th  style="vertical-align: top;">OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($listarS as $ls){ 
                    $listarVehiculoPorId = $vehiculo->listarPorId($ls['id_registro']); 
                    $listarConductorPorId = $conductor->listarPorId($ls['id_registro']);

                    ?>
                    <tr class="text-center">
                        <td><?php echo $ls['id_seguimiento'];  ?></td>
                        <td><?php $listarUsuarioPorId = $usuario->listarUsuarioPorId($ls['id_usuario']); echo $listarUsuarioPorId[0]['nombre'] ?></td>
                        <td><?php $listarModuloPorId = $modulo->listarPorId($ls['id_modulo']); echo strtoupper($listarModuloPorId[0]['nombre_modulo']) ?></td>
                        <td>
                          <?php
                              if ($ls['id_modulo'] == 12) {
                                  echo $listarConductorPorId[0]['nombre_conductor'] . ' | ' . $listarConductorPorId[0]['numero_documento_conductor'] ; 
                              }else{
                                  echo $listarVehiculoPorId[0]['placa']; 
                              }
                          ?>
                        </td>
                        <td>
                            <?php 
                                $columnas = explode(" | ", $ls['columnas']); 
                                $nombre_documento = $columnas[0]; 
                                $fecha_vencimiento = $columnas[1];  
                                echo strtoupper($nombre_documento); 
                            ?>
                        </td>
                        <td>
                            <?php if ($ls['id_modulo'] != 12) {
                                echo $ls['documento'] ?>
                                <a target="_blank" href="<?php echo "../Documentos/Vehiculos/" . $listarVehiculoPorId[0]['placa']. "/"  . $ls['documento'] ?>">
                                  <span class="fa fa-eye ml-2" style="color: #304fcc;"></span>
                                </a>
                            <?php } else { 
                                echo $ls['documento'] ?>
                                <a target="_blank" href="<?php echo "../Documentos/Conductores/" . $listarConductorPorId[0]['numero_documento_conductor']. "/"  . $ls['documento'] ?>">
                                  <span class="fa fa-eye ml-2" style="color: #304fcc;"></span>
                                </a>
                            <?php } ?>
                        </td>
                        <td><?php if($ls['nueva_fecha_vencimiento'] == '0000-00-00'){ echo "NO APLICA O NO SE CARGO LA FECHA DE VENCIMIENTO"; }else{ echo $ls['nueva_fecha_vencimiento']; } ?></td>
                        <td><?php if ($ls['estado'] == 'P') {
                            echo "PENDIENTE";
                        }else if ($ls['estado'] == 'R') {
                            echo "RECHAZADA";
                        }else if ($ls['estado'] == 'A') {
                            echo "ACEPTADA";
                        }?></td>

                        <td>
                          <?php if ($ls['estado'] == 'P'){ ?>
                              <button class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#modalSeguimientos" onclick="valor(<?php echo $ls['id_seguimiento'];?>)"><span class="fa fa-check" style="font-size: .9rem;"></span></button>
                          <?php }else{ ?>
                              <a class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;" href="../Controlador/eliminarSolicitudSeguimientoActualizacion.php?id_seguimiento=<?php echo $ls['id_seguimiento']; ?>"><i class="fa fa-trash-o" style="font-size: .9rem;"></i></a>
                          <?php } ?>
                          
                        </td>
                    </tr>
                  <?php } ?>  
                </tbody>
            </table>
          </div> 

      </section>
      
    <!-- FIN CONTENIDO -->

    <!--***************************-->

    <!------------------------------------------------------->
    <!--------------------- MODALES ------------------------->
    <!------------------------------------------------------->

    <!-- MODAL SEGUIMIENTOS -->
      <div class="modal fade" id="modalSeguimientos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="../Controlador/ActualizarDocsSeguimiento.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-size: .9rem;">SEGUIMIENTO DE ACTUALIZACIÓN DE DOCUMENTOS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="mensaje">
                          <p style="font-size: .8rem;">¿Esta seguro de realizar este cambio? Antes de aprobar o denegar la actualización de este documento, porfavor verifique la veracidad del mismo con su respectiva fecha de vencimiento.</p>
                        </div>
                        <div  id="novedad" style="display: none;">
                          <label style="font-size: .8rem;">Novedad de Rechazo</label>
                          <textarea name="novedad_rechazo" id="novedad_rechazo" class="form-control" style="font-size: .8rem;"></textarea>
                          <input type="hidden" name="id_seguimiento" id="id_seguimiento" value=""></td>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: .8rem;">CERRAR</button>
                      <button type="button" class="btn btn-warning" id="rechazar" style="color: #fff; font-size: .8rem;" onclick="mostrarCampoNovedad();">RECHAZAR</button>
                      <div style="display: none;" id="aceptar_rechazo">
                          <button type="submit"  name="enviar" value="1" class="btn btn-success" style="color: #fff; font-size: .8rem;">ENVIAR</button>
                      </div>
                      <div id="aprobar">
                          <button type="button" onclick="this.form.submit()" name="enviar" value="2" class="btn btn-primary" style="font-size: .8rem;">APROBAR</button>
                      </div>
                    </div>
                  </form>
              </div>
            </div>
      </div>

    <!------------------------------------------------------->
    <!------------------ FIN MODALES ------------------------>
    <!------------------------------------------------------->
    
    <!--***************************-->

    <!-- SCRIPTS -->
      
      <?php include("Template/scripts.php") ?>
      
      <script type="text/javascript">
          function mostrarCampoNovedad(){
             document.getElementById('aceptar_rechazo').style.display = 'flex';
             document.getElementById('aprobar').style.display = 'none';
             document.getElementById('mensaje').style.display = 'none';
             document.getElementById('novedad').style.display = 'flex';
             document.getElementById('rechazar').style.display = 'none';
          }
          function valor(id){
            document.getElementById('id_seguimiento').value = id;
          }
      </script>
    <!--FIN SCRIPTS -->
</body>
</html>