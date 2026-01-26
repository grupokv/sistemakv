<?php 

include ("../Controlador/Sesion/autenticar.php");

require_once ("../Modelo/Cliente-Convenio.php");
require_once ("../Modelo/EmpresaEnt.php");
require_once ("../Modelo/Convenio.php");
require_once ("../Modelo/Contrato.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/Usuario.php");
require_once ("../Modelo/Cliente.php");

date_default_timezone_set('America/Bogota');
    
$clienteConvenio = new Cliente_Convenio();
$convenio = new Convenio();
$vehiculo = new Vehiculo();
$contrato = new Contrato();
$usuario = new Usuario();
$empresa = new Empresa();
$cliente = new Cliente();

$listarConvenios = $convenio->listarTodos();
$listarV = $vehiculo->listar();

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>SistemaKV | Convenios</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      
        <!-- STYLES -->
            <?php include("Template/styles.php") ?>
            <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
            <style type="text/css">
                .custom-file-input.selected:lang(en)::after {
      content: "" !important;
    }

    .custom-file {
      overflow: hidden;
    }

    .custom-file-input {
      white-space: nowrap;
    }
            </style>
        <!-- FIN  STYLES -->

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
                <li class="breadcrumb-item active" aria-current="page">Convenios</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">CONVENIOS</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            <a href="registrarConvenios.php" class="btn btn-outline-info" id="buttonsKV">Registrar Convenio <i class="fa fa-plus"></i></a>
            <a href="cargarConvenios.php" class="btn btn-outline-info" id="buttonsKV">Subir Convenio <i class="fa fa-upload"></i></a>
        </div>

        <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
        	<table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
        		<thead style="background-color: #1b2d3b; color: #fff;">
        			<tr>
                        <th>N° CONVENIO</th>
                        <th>EMPRESA CONTRATISTA</th>
        				<th>EMPRESA COLABORADORA</th>
                        <th>FECHA EXPEDICIÓN</th>
                        <th>VEHÍCULO</th>
                        <th>CONTRATO</th>
                        <th>DURACIÓN CONVENIO</th>
                        <th>EMISOR</th>
                        <th>ESTADO</th>
        				<th>OPCIONES</th>
        			</tr>
        		</thead>
        		<tbody>
        			<?php foreach ($listarConvenios as $lc){ ?>
        				<tr>                
                            <td><?php echo  str_pad($lc['id_convenio'], 6, '0', STR_PAD_LEFT)?></td>
                            <td>
                                <?php 
                                    $listarEmpresasId = $empresa->listarPorId($lc['id_empresa']);
                                    echo $listarEmpresasId[0]['nombre_empresa'];
                                ?>
                            </td>                   
                            <td>
                                <?php 
                                    $listarClienteConvenioId = $clienteConvenio->cliente_ID($lc['id_cliente']);
                                    echo $listarClienteConvenioId[0]['razon_social']; 
                                ?>
                            </td>                   
                            <td><?php echo $lc['fecha_creacion_convenio'] . ' ' . $lc['hora_creacion_convenio'] ?></td>              
                            <td>
                                <?php 
                                    $listarVehiculoPorId = $vehiculo->listarPorId($lc['id_vehiculo']);
                                        echo $listarVehiculoPorId[0]['placa'];
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $id_contratos = explode(",", $lc['id_contrato']);

                                    if(count($id_contratos) > 1){
                                        echo $lc['id_contrato'];
                                    }else{
                                        $listarContratoPorId = $contrato->listarId($lc['id_contrato']);
                                        $cliente_ID = $cliente->cliente_ID($listarContratoPorId[0]['id_cliente']);
                                        echo $lc['id_contrato'] . ' - ' . $cliente_ID[0]['razon_social'];
                                    }
                                     
                                ?>
                            </td>              
                            <td>
                                <?php 
                                    $fecha1 = new DateTime($lc['fecha_inicio_convenio']);
                                    $fecha2 = new DateTime($lc['fecha_final_convenio']);
                                    $diff = $fecha1->diff($fecha2);

                                    echo "<strong>" . $diff->days . ' DÍAS | </strong> ' . $lc['fecha_inicio_convenio']. '<strong> A </strong>' . $lc['fecha_final_convenio']; 
                                ?>
                            </td>                
                            <td>
                                <?php 
                                    $listarPorId = $usuario->listarUsuarioPorId($lc['id_responsable']); 
                                    echo $listarPorId[0]['nombre'];
                                ?>
                            </td>      
                            <td>
                                <?php if (date('Y-m-d') > $lc['fecha_final_convenio']){ ?>
                                    <p style="font-size: .9rem;">VENCIDO <span style="color: darkred; font-size: 1.4rem;" class="fa fa-times-circle-o"></span></p>
                                <?php }else{ ?>
                                    <p style="font-size: .9rem;">ACTIVO <span style="color: darkgreen; font-size: 1.4rem;" class="fa fa-check-circle-o"></span></p>
                                <?php } ?>
                            </td>             
                            <td>
                                <?php if ($lc['doc_convenio'] == ""){ ?>
                                    
                                    <!-- VISUALIZAR PDF CONVENIO-->
                                    <a href="PDF/convenio.php?id_convenio=<?php echo $lc['id_convenio']; ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-success"><span class="fa fa-search"></span></a>
                                    
                                   
                                    <!-- CARGAR PDF CONVENIO FIRMADO-->
                                    <button style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="cargarConvenio(<?php echo $lc['id_convenio']; ?>);" class="btn btn-outline-danger" data-toggle="modal" data-target="#cargarConvenioFirmado"><span class="fa fa-upload"></span></button>

                                    <!-- ACTUALIZAR INFORMACIÓN-->
                                    <a href="actualizarConvenio.php?id_convenio=<?php echo $lc['id_convenio']; ?>" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-info"><span class="fa fa-edit"></span></a>

                                    <!-- DUPLICAR INFORMACIÓN CONVENIO -->
                                    <button style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-warning m-1" data-toggle="modal" data-target="#modalDuplicar" onclick="duplicarConvenio(<?php echo $lc['id_convenio'] ?>);"><i class="fa fa-files-o"></i></button>

                                <?php }else{ ?>

                                    <?php if ($lc['tipo_registro_conv'] == "E"){ ?>

                                        <!-- VISUALIZAR CONVENIO FIRMADO -->
                                        <a href="../Documentos/Convenios/<?php echo $lc['doc_convenio'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-danger"><span class="fa fa-search"></span></a>

                                        <!-- VISUALIZAR PDF CONVENIO -->
                                        <a href="PDF/convenio.php?id_convenio=<?php echo $lc['id_convenio']; ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-success"><span class="fa fa-search"></span></a>
                                        
                                    <?php } else if ($lc['tipo_registro_conv'] == "T"){ ?>

                                        <!-- VISUALIZAR CONVENIO FIRMADO -->
                                        <a href="../Documentos/Convenios/<?php echo $lc['doc_convenio'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-danger"><span class="fa fa-search"></span></a>

                                        <!-- ACTUALIZAR CONVENIO FIRMADO-->
                                        <a href="actualizarCargarConvenios.php?id_convenio=<?php echo $lc['id_convenio']; ?>" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-primary"><span class="fa fa-edit"></span></a>
                                    


                                    <?php } ?>
                                    <!-- DUPLICAR INFORMACIÓN CONVENIO -->
                                    <!-- <button style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-warning" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-files-o"></span></button> -->

                                <?php } ?>
                            </td>    				
                        </tr>
        			<?php } ?>
        		</tbody>
        	</table>
        </div>

    </section>
    
    <!-- FIN CONTENIDO -->
    
    <!-- MODAL DUPLICAR CONVENIO -->
        <div class="modal fade" id="modalDuplicar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="notice notice-sistemakv">
                            <strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i>DUPLICAR CONVENIO</strong>
                        </div>

                        
                        <form method="POST" action="../Controlador/duplicarConvenio.php">
                            <div style="border: 1px dashed #d1d1d1;" id="seccion_duplicar" class="row d-flex justify-content-center p-3 m-3">
                                
                                <input type="hidden" name="id_convenio" id="id_convenio_duplicar" class="form-control">

                                <!-- vehiculo -->
                                    <div class="col-12 mb-3" id="vehiculo">
                                        <label><b>Vehículo</b></label>
                                        <select name="id_vehiculo" id="id_vehiculo"  class="col-12 form-control selectpicker" data-live-search="true" onchange="listarConductoresPorVehiculo(this.value); ocultarConductoresContratos(); listarContratosPorVehiculo(this.value, 0);">
            						        <option value="">SELECCIONAR</option>
            						        <?php foreach ($listarV as $lv){ 

                                                $hoy = date('Y-m-d');
                                                $fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
                                                $fecha2 = date('Y-m-d', $fecha2);
                                                
            									$documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
            									
            									if (count($documentosvencidosPorId) > 0) {?>
            										<option value="<?php echo $lv['id_vehiculo'] ?>"disabled style="color:red;font-weight:bolder">
            						        			<?php echo $lv['placa'] ?>
            						        		</option>
            									<?php } else { ?>
            										<option value="<?php echo $lv['id_vehiculo'] ?>">
            						        			<?php echo $lv['placa'] ?>
            						        		</option>
            									<?php } ?>
            						        	
            						        <?php } ?>
            						    </select>
            	                    </div>

                                <!-- Conductor -->

                                    <div class="col-12 mb-3" id="conductor" style="display: none;" >
                                        <label>Conductores del vehiculo</label>
                                        <select name="id_conductor[]" id="id_conductor" class="form-control"  multiple="multiple">
                                        </select>
                                    </div>

                                <!-- Contratos -->

                                    <div class="col-12 mb-3" id="contratos" style="display: none;" >
                                        <label>Contratos del vehiculo</label>
                                        <select name="id_contrato" id="id_contrato" class="form-control" onchange="validarObjetoContrato(this.value);">
                                            <option value="">SELECCIONAR</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3" id="ObjContrato" style="display: none;" >
                                        <label>Objeto del Contrato</label>
                                        <textarea class="form-control" name="objeto_contrato_conv" id="objeto_contrato_conv"></textarea>
                                    </div>
      
                            </div>
                            
                            <div class="d-flex justify-content-center mt-3">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-outline-success ml-3">Duplicar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    
    <!-- MODAL CARGAR CONVENIO FIRMADO-->
        <div class="modal fade" id="cargarConvenioFirmado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="notice notice-sistemakv">
                            <strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i>CARGAR DOCUMENTO FIRMADO</strong>
                        </div>

                        <form class="p-3" action="../Controlador/cargarPDFConvenioFirmado.php" method="POST" enctype="multipart/form-data">

                            <div id="seccion_cargarDoc" style="border: 1px dashed #d1d1d1;" class="row d-flex justify-content-center p-3">

                                <input type="hidden" class="form-control" name="id_convenio" id="id_convenio">
                                
                                <div class="col-12 mt-3 mb-1">
                                    <label><strong>Convenio Firmado (Documento)</strong></label>
                                </div>
                                
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input form-control" name="documento_firmado" id="documento_firmado" required>
                                    <label class="custom-file-label" for="customInput">SELECCIONAR ARCHIVO ...</label>
                                </div>

                            <!--     <div class="col-12 mb-3" id="vehiculo">
                                    <input type="file" class="form-control" name="documento_firmado" id="documento_firmado">
                                </div>
                                     -->
                            </div>
                            
                            <div class="d-flex justify-content-center mt-2 mb-2">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-outline-success ml-3">Cargar Documento</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <!-- script -->
    <?php include("Template/scripts.php"); ?>
    
    <script>

        function listarConductoresPorVehiculo(id_vehiculo){
            //alert(id_vehiculo);
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarConductoresVehiculo.php',
                type: 'post',
                beforeSend: function () {
                    $("#id_conductor").html('<option value=""> Cargando Conductores</option>');
                },
                success:  function (response) { 
                    $('#id_conductor').empty();
                    $("#id_conductor").append(response);
                    $('#id_conductor').trigger("chosen:updated");
                    $("#id_conductor").chosen(); 
                }
            })

        }

        function listarContratosPorVehiculo(id_vehiculo, id_contrato){
            //alert(id_vehiculo);
            var parametros = {
                "id_vehiculo" : id_vehiculo,
                "id_contrato" : id_contrato
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarContratosVehiculo.php',
                type: 'POST',
                beforeSend: function () {
                    $("#id_contrato").html('<option value=""> Cargando Contratos</option>');
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    //alert(response);
                    $("#id_contrato").html(response);
                }
            })

        }

        function ocultarConductoresContratos(){
            var vehiculo = document.getElementById('vehiculo').value;

            if (vehiculo == '') {
                document.getElementById('conductor').style.display = 'none';
                document.getElementById('contratos').style.display = 'none';
            }else{
                document.getElementById('conductor').style.display = 'block';
                document.getElementById('contratos').style.display = 'block';
            }
        }

        function validarObjetoContrato(id_contrato){
            var parametros = {
                "id_contrato" : id_contrato
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarObjetoPorContratoVehiculo.php',
                type: 'POST',
                beforeSend: function () {
                    $("#objeto_contrato_conv").html('Cargando, por favor espere..');
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    //alert(response);
                    document.getElementById("ObjContrato").style.display = 'block';
                    $("#objeto_contrato_conv").html(response);
                }
            });
        }


        function cargarConvenio(val){
            document.getElementById("id_convenio").value = val; 
        }

        function duplicarConvenio(val){
            document.getElementById("id_convenio_duplicar").value = val; 
        }
    
        
    </script>

</body>
</html>