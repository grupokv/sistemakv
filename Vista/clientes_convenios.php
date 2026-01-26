<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente-Convenio.php");

$cliente = new Cliente_Convenio();
$listar = $cliente->listar();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Clientes Convenios</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- styles-->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <!--fin  styles -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

<!--**************************--->

<section class="home_content"> 

    
    <!-- CONTENIDO -->

    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Empresas Convenios</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">EMPRESAS CONVENIO</b></strong>
    </div>

    <div class="notice notice-sistemakv">
        <a id="buttonsKV" href="registrarClienteConvenio.php" class="btn btn-outline-info mr-4">
            <i class="fa fa-plus"></i> Nueva Empresa Convenio
        </a>
    </div>



    <div class="mt-2 p-4 table-responsive mb-5 " style="background-color: #fff;">
    	<table id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead class="text-center" style="background-color: #1b2d3b; color: #fff;">
    			<tr>
                    <th>ID</th>
                    <th>RAZON SOCIAL</th>
                    <th>NIT</th>
    				<th>DIRECCION</th>
                    <th>TELEFONO</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody class="text-center">
    			<?php foreach ($listar as $lc){ ?>
    				<tr>                
                        <td><?php echo $lc['id_cliente']?></td>
                        <td><?php echo $lc['razon_social']?></td>
                        <td><?php echo $lc['nit_cliente'] ?></td>                   
                        <td><?php echo $lc['direccionC'] ?></td>                   
                        <td><?php echo $lc['telefonoC'] ?></td>
                        <td>
                            <?php if ($lc['estado'] == 0){ ?>
                                <a href="../Controlador/bloquearDesbloquearClienteConvenio.php?id_cliente=<?php echo $lc['id_cliente']; ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
                            <?php } else if ($lc['estado'] == 1) { ?>
                                <a href="../Controlador/bloquearDesbloquearClienteConvenio.php?id_cliente=<?php echo $lc['id_cliente']; ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-lock"></span></a>
                             <?php }  ?>
                            <a href="actualizarClienteConvenio.php?id_cliente=<?php echo $lc['id_cliente'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
                                    <span class="fa fa-edit"></span>
                            </a>
                        </td>    				
                    </tr>
    			<?php } ?>
    		</tbody>
    	</table>
    </div>
    
</section>

    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>
    <!-- FIN SCRIPT -->


</body>
</html>