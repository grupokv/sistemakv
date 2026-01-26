<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Usuario.php");

$contrato = new Contrato();
$listar = $contrato->listarTodos();

$usuario = new Usuario();
$hoy = date('Y-m-d');

?>


<!DOCTYPE html>
<html>
<head><meta charset="euc-kr">
  
    <title>SistemaKV | Usuarios Contratos</title>
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

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <section class="home_content"> 

        <div aria-label="breadcrumb" class="mt-1"> 
             <ol class="breadcrumb" style="background-color: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Usuarios Contratos</li>
             </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i>USUARIOS CONTRATOS FIJOS</strong>
        </div>

        <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
        	<table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
        		<thead style="background-color: #1b2d3b; color: #fff;">
        			<tr>
                        <th>CONTRATO N°</th>
                        <th>CONTRATISTA</th>
        				<th>CONTRATANTE</th>
                        <th>TIPO CONTRATO</th>
                        <th>ESTADO</th>
                        <th>EMISOR</th>
        				<th>OPCIONES</th>
        			</tr>
        		</thead>
        		<tbody>
        			<?php foreach ($listar as $lc){ ?>
        				<tr>                
                            <td><?php echo  str_pad($lc['id_contrato'], 6, '0', STR_PAD_LEFT)?></td>
                            <td><?php echo $lc['nombre_empresa'] ?></td>                   
                            <td><?php echo $lc['razon_social'] ?></td>
                            <?php $listarUId = $usuario->listarUsuarioPorId($lc['id_responsable']) ?>
                            <td>
                                <?php 
                                    $listarTipoContrato = $contrato->listarTiposContratosId($lc['id_tipo_contrato']);  
                                    echo utf8_encode(strtoupper($listarTipoContrato[0]['tipo_contrato'])); 
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if ($lc['fecha_final_contrato'] < $hoy) { 
                                        echo 'VENCIDO'; 
                                    } else { 
                                        echo 'ACTIVO'; 
                                    } 
                                ?>
                            </td> 
                           <td>
                                <?php foreach ($listarUId as $lui) {
                                         echo $lui['nombre'];
                                        }
                                ?>        
                            </td>
                            <td>
                                <a href="../Documentos/Contratos/<?php echo $lc['doc_fotocopia_contrato'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-success"><span class="fa fa-search"></span></a>
                                <a href="consultarUsuariosContratosFijos.php?id_contrato=<?php echo $lc['id_contrato']; ?>" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-info"><span class="fa fa-users"></span></a>
                            </td>    				
                        </tr>
        			<?php } ?>
        		</tbody>
        	</table>
        </div>

    </section>

    <!-- FIN CONTENIDO -->

    <!-- ******************************************** -->

    <!-- MODAL PROYECTOS-->
        <div class="modal fade" id="ModalProyectos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
               <div class="alert alert-primary text-center" role="alert">
                  PROYECTOS
                </div>

                <input type="hidden" name="id_contrato" id="id_contrato">

                <div class="contenido_proyectos" id="contenido_proyectos"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

    <!-- MODAL TARIFAS-->
        <div class="modal fade"  id="ModalTarifas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-body">
               <div class="alert alert-primary text-center" role="alert">
                  TARIFAS DE LOS SERVICIOS
                </div>
                
                <input type="hidden" name="id_proyecto" id="id_proyecto">

                <div class="contenido_tarifas" id="contenido_tarifas"></div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
              </div>
            </div>
          </div>
        </div>
    
    <!-- MODAL TARIFAS TERCEROS-->
    
        <div class="modal fade" style="margin-top: 100px;" id="ModalTarifasTerceros" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
               <div class="alert alert-primary text-center" role="alert">
                  TARIFAS A TERCEROS
                </div>
                
                <input type="hidden" name="id_proyecto" id="id_proyecto">

                <div class="contenido_tarifas_terceros" id="contenido_tarifas_terceros"></div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
              </div>
            </div>
          </div>
        </div>
    
    <!-- ******************************************** -->

    <!-- SCRIPT -->

        <?php include("Template/scripts.php"); ?>

        <script type="text/javascript">
            
            function idContratoProyectos(id_contrato){
                document.getElementById('id_contrato').value = id_contrato; 
            }  

            function idProyectotarifas(id_proyecto){
                document.getElementById('id_proyecto').value = id_proyecto; 
            } 

            function idtarifaProyecto(id_tarifa){
                document.getElementById('id_tarifa').value = id_tarifa; 
            } 

            function listarProyectos(id_contrato){
                var parametros = {
                    "id_contrato" : id_contrato
                };
                $.ajax({
                        data:  parametros, 
                        url:   '../Controlador/listarProyectosContratos.php',
                        type:  'POST', 
                        beforeSend: function () {
                                $("#contenido_proyectos").html("Procesando, espere por favor...");
                        },
                        success:  function (response) { 
                                //alert(response);
                                $("#contenido_proyectos").html(response);
                        }
                });
            }

            function listarTarifasTerceros(id_tarifa_proyecto){
                //alert(id_tarifa_proyecto);
                var parametros = {
                    "id_tarifa_proyecto" : id_tarifa_proyecto
                };
                $.ajax({
                        data:  parametros, 
                        url:   '../Controlador/listarTarifasTercerosProyectos.php',
                        type:  'POST', 
                        beforeSend: function () {
                                $("#contenido_tarifas_terceros").html("Procesando, espere por favor...");
                        },
                        success:  function (response) { 
                                //alert(response);
                                $("#contenido_tarifas_terceros").html(response);
                        }
                });
            }

            function listarTarifas(id_proyecto, id_contrato){
               
                var parametros = {
                    "id_proyecto" : id_proyecto,
                    "id_contrato" : id_contrato
                };
                $.ajax({
                        data:  parametros, 
                        url:   '../Controlador/listarTarifasProyectos.php',
                        type:  'POST', 
                        beforeSend: function () {
                                $("#contenido_tarifas").html("Procesando, espere por favor...");
                        },
                        success:  function (response) { 
                                //alert(response);
                                $("#contenido_tarifas").html(response);
                        }
                });
            }
        </script>

    <!-- FIN SCRIPT -->

</body>
</html>