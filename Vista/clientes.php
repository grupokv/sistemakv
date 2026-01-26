<?php 
    include ("../Controlador/Sesion/autenticar.php");
    require_once("../Modelo/Cliente.php");

    $cliente = new Cliente();
    $listar = $cliente->listar();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Clientes</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES-->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style type="text/css" media="screen">
                .barra-principal{
                    background-color: #5e99b1;
                    width: auto;
                }

                .botones_principal{
                    display: flex;
                    justify-content: flex-end;
                }

                .boton-registro{
                    background-color: #fff; 
                    height: 40px; 
                    margin-top: 10px; 
                    margin-bottom: 10px; 
                    color: #00a0df;
                }

                @media (max-width: 760px){
                  
                
                    .titulo_principal{
                        text-align: center;
                    }

                    .botones_principal{
                        display: flex;
                        justify-content: center;
                    }
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
                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">CLIENTES</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            <a href="registrarClientes.php" class="btn btn-outline-info" id="buttonsKV">Crear Cliente <i class="fa fa-plus"></i></a>
        </div>

    <div class="mt-2 p-4 table-responsive mb-5" style="background-color: #fff;">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead class="text-center" style="background-color: #1b2d3b; color: #fff;">
    			<tr>
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
                        <td><?php echo $lc['razon_social']?></td>
                        <td><?php echo $lc['nit_cliente'] ?></td>                   
                        <td><?php echo $lc['direccionC'] ?></td>                   
                        <td><?php echo $lc['telefonoC'] ?></td>
                        <td>
                            <!--  ACTIVAR Y INACTIVAR -->
                                <?php if ($lc['estado'] == 0){ ?>
                                    <a href="../Controlador/bloquearDesbloquearCliente.php?id_cliente=<?php echo $lc['id_cliente']; ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-unlock"></i></a>
                                <?php } else if ($lc['estado'] == 1) { ?>
                                    <a href="../Controlador/bloquearDesbloquearCliente.php?id_cliente=<?php echo $lc['id_cliente']; ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-lock"></i></a>
                                <?php }  ?>

                            <!--  ACTUALIZAR -->

                                <a href="actualizarCliente.php?id_cliente=<?php echo $lc['id_cliente'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-edit"></i></a>
                        </td>    				
                    </tr>
    			<?php } ?>
    		</tbody>
    	</table>
    </div>
    
    <!-- FIN CONTENIDO -->


    <!-- script -->
    <?php include("Template/scripts.php"); ?>
    <!-- script-->


</body>
</html>