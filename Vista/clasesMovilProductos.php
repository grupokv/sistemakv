<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/TipoVehiculo.php");

$operativo = new Operativo();
$tipoVehiculo = new TipoVehiculo();
$usuario = new Usuario();
$cliente = new Cliente();


$listarClasesMovilClientes = $operativo->listarClasesMovilClientes();

?>


<!DOCTYPE html>
<html>
<head><meta charset="utf-8">
  
    <title>SistemaKV | Servicios Activos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- styles -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style>

            #servicios thead{
                background-color: #fff;
            }

            #servicios tr{
                background-color: #fff;
            }

            #servicios th{
                border-radius: 13px;
                border: 3px solid #fff;
                background-color: #274054; 
                color: #fff;
                padding: 10px;
            }

            #contEstado{
                width: 20px; 
                height: 20px; 
                border-radius: 50%; 
                cursor: pointer;{
            }

        </style>
    <!--fin  styles -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!-- ************************** --->
    
    <!-- CONTENIDO -->

    <section class="home_content">

        <div aria-label="breadcrumb" class="mt-1"> 
           <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Clases Vehiculos - Productos</li>
           </ol>
        </div>
        
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">CLASES VEHÍCULOS (PRODUCTOS)</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            <a href="registrarNuevaClaseMovilProducto.php" class="btn btn-outline-info" id="buttonsKV">Nuevo Registro<i class="fa fa-plus-circle ml-1"></i></a>
        </div>

        <div class="mt-2 p-4 table-responsive" id="servicios" style="background-color: #fff;">
        	<table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
        		<thead style="background-color: #1b2d3b; color: #fff;">
        			<tr>
                        <th>CLASE MOVIL PRODUCTO</th>
                        <th>TIPO VEHÍCULO</th>
        				<th>CAPACIDAD</th>
                        <th>CLIENTE</th>
                        <th>OBSERVACIONES</th>
        				<th>OPCIONES</th>
        			</tr>
        		</thead>
                <tbody>
                    <?php foreach ($listarClasesMovilClientes as $lcmc){ ?>
                        <tr>
                            <td><?php echo strtoupper($lcmc['clase_movil_producto']); ?></td>
                            <td>
                                <?php  
                                    $listarTipoV = $tipoVehiculo->listarPorId($lcmc['id_tipo_vehiculo']);

                                    echo $listarTipoV[0]['nombre_tipo_vehiculo'];
                                ?>
                            </td>
                            <td><?php echo $lcmc['capacidad']; ?></td>
                            <td>
                                <?php  
                                    $listarClientePorId = $cliente->cliente_ID($lcmc['id_cliente']);
                                    echo $listarClientePorId[0]['razon_social'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    if ($lcmc['observaciones'] == "") {
                                        echo "-"; 
                                    }else{
                                        echo $lcmc['observaciones'];
                                    }
                                ?>
                            </td>
                            <td>
                                <a href="actualizarClaseMovilProducto.php?id=<?php echo $lcmc['id'] ?>" class="btn btn-outline-info" style="margin: 2px; border-radius: 4px; padding: 0px 2px 0px 4px;"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
        	</table>
        </div>

    </section>
    <!-- FIN CONTENIDO -->



    <!-- MODAL -->
    <div class="modal" id="vehiculosServicio" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="contentVehServ">
                        
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <!-- FIN MODAL -->




    <!-- script -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
        function vehiculosServicios(val){
            var parametros = {
                "id_servicio" : val,
            };

            $.ajax({
                data:  parametros, 
                url:   '../Controlador/listarVehiculosPorServicio.php',
                type:  'POST', 
                beforeSend: function () {  
                },
                success:  function (response) { 
                    $('#vehiculosServicio').modal();
                    $("#contentVehServ").html(response);
                   /* setTimeout(function() {
                        $(".fade").fadeOut(300);   
                        $('#vehiculosServicio').modal();
                        $("#contentVehServ").html(reponse);
                    },3000);*/
                }
            });
        }
    </script>


</body>
</html>