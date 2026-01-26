<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Vehiculo-Contrato.php");

$contrato = new Contrato();
$vehiculoContrato = new Vehiculo_Contrato();
$listar = $contrato->listarTodos();

$usuario = new Usuario();
$hoy = date('Y-m-d');
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Contratos</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style type="text/css" media="screen">
        
            .barra-principal{
               background-color: #5e99b1;
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
                    <li class="breadcrumb-item active" aria-current="page">Contratos</li>
                 </ol>
            </div>


            <div class="notice notice-sistemakv">
                <strong><i class="fa fa fa-search mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">VEHÍCULOS POR CONTRATO</b></strong>
            </div>

            <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
            	<table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
            		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr>
                            <th>N° CONTRATO</th>
                            <th>CONTRATISTA</th>
            				<th>CONTRATANTE</th>
                            <th>TIPO CONTRATO</th>
                            <th>ESTADO</th>
            				<th>OPCIONES</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php foreach ($listar as $lc){ ?>
            				<tr>                
                                <td>
                                    <?php echo  str_pad($lc['id_contrato'], 6, '0', STR_PAD_LEFT)?>
                                </td>
                                <td><?php echo $lc['nombre_empresa'] ?></td>                   
                                <td><?php echo $lc['razon_social'] ?></td>                   
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
                                    <button data-toggle="modal" data-target="#consultarVehiculos" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-info" onclick="consultarVehiculosContrato(<?php echo $lc['id_contrato']; ?>);"><span class="fa fa-search"></span></button>

                                    <a href="ReporteExportarExcelVehiculosContratoFuec.php?id_contrato=<?php echo $lc['id_contrato']; ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-success"><span class="fa fa-file-excel-o"></span></a>

                                    <a href="ReporteExportarExcelConductoresVehiculoContratoFuec.php?id_contrato=<?php echo $lc['id_contrato']; ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-warning"><span class="fa fa-file-excel-o"></span></a>

                                </td>    				
                            </tr>
            			<?php } ?>
            		</tbody>
            	</table>
            </div>

</section>

    <!-- FIN CONTENIDO -->

    <!-- ************************************** -->

    <!-- MODAL CONSULTAR VEHICULOS POR CONTRATO -->
        <div class="modal fade" id="consultarVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="alert alert-warning text-center" role="alert">
                            <strong>VEHICULOS POR CONTRATO</strong>
                        </div>

                        <hr>

                        <div class="contenido_modal_vehiculos" id="contenido_modal_vehiculos">
                            
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- ************************************** -->

    
    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>

        <script type="text/javascript">

            function consultarVehiculosContrato(id_contrato){
                var parametros = {
                    "id_contrato" : id_contrato
                };
                $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/consultarVehiculosContratos.php', //archivo que recibe la peticion
                    type:  'POST', //método de envio
                    beforeSend: function () {
                            $("#contenido_modal_vehiculos").html("Procesando, espere por favor...");
                    },
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                            //alert(response);
                            $("#contenido_modal_vehiculos").html(response);
                    }
                });
            }
        </script>

    <!-- FIN SCRIPT -->

</body>
</html>