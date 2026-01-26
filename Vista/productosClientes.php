<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/TipoVehiculo.php");

$tipoVehiculo = new TipoVehiculo();
$operativo = new Operativo();
$cliente = new Cliente();

$listarProductos = $operativo->listarProductos();

$hoy = date('Y-m-d');

?>


<!DOCTYPE html>
<html>
<head><meta charset="utf-8">
  
    <title>SistemaKV | Productos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- styles -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
        
        <style>
            
            th{
                border-radius: 13px;
                border: 3px solid #fff;
                background-color: #1b2d3b; 
                color: #fff;
            }

        </style>
    <!--fin  styles -->

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
           <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Productos</li>
           </ol>
        </div>
        
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">PRODUCTOS</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            <a href="registrarProductoCliente.php" class="btn btn-outline-info" id="buttonsKV" data-bs-toggle="tooltip" data-bs-placement="top" title="Nuevo Registro">Nuevo Registro <i class="fa fa-plus-circle" style="font-size: 1.2rem;"></i></a>
            <!-- <button class="btn btn-outline-info" onclick="openNav()" id="buttonsKV" data-bs-toggle="tooltip" data-bs-placement="top" title="Filtro">Filtro <i class="fa fa-search" style="font-size: 1.2rem;"></i></button> -->
        </div>

        <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
        	<table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
        		<thead>
        			<tr class="text-center">
                        <th>#</th>
                        <th>PRODUCTO</th>
        				<th>CLIENTE</th>
                        <th>TIPO VEHÍCULO</th>
                        <th>DIA DE CORTE</th>
        				<th>OPCIONES</th>
        			</tr>
        		</thead>
                <tbody>
                    <?php foreach ($listarProductos as $lp){ ?>
                        <tr>
                            <td><?php echo str_pad($lp['id_producto'], 5, "0", STR_PAD_LEFT); ?></td>
                            <td><?php echo $lp['detalle_producto']; ?></td>
                            <td>
                                <?php 
                                    $cliente_ID = $cliente->cliente_ID($lp['id_cliente']);
                                    echo $cliente_ID[0]['razon_social'] 
                                ?>
                            </td>
                            <td><?php echo $lp['tipo_producto'] ?> </td>
                            <td><?php echo $lp['dia_corte'];?></td>
                            <td>
                                <a href="actualizarProductoCliente.php?id_producto=<?php echo $lp['id_producto'] ?>" class="btn btn-outline-info" style="margin: 2px; border-radius: 4px; padding: 0px 2px 0px 4px;"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
        	</table>
        </div>

    </section>
    <!-- FIN CONTENIDO -->
    

    <!-- script -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
    
        function openNav() {
            document.getElementById("Medium").style.width = "30%";
          document.getElementById("Medium").style.right = "0";
          
        }
        
        function closeNav() {
            document.getElementById("Medium").style.width = "0%";
          document.getElementById("Medium").style.right = "30%";
        }
        
    </script>


</body>
</html>