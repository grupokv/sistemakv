<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vinculacion.php");

$vinculacion = new Vinculacion();
$listarClientes = $vinculacion->listarClientes();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Clientes Vinculaciones</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles-->
  <?php include("Template/styles.php") ?>

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
            <li class="breadcrumb-item active" aria-current="page">Clientes Vinculaciones</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">

    <div class="row barra-principal">
    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
    		<h2 class="mt-2" id="titulo" style="color: #fff; line-height: 25px;"><span class="fa fa-globe ml-2" style="border: 3px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Clientes Vinculaciones</h2>
    	</div>
    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 botones_principal">
            <a href="registrarClientesVinculaciones.php" class="btn boton-registro ml-1 mr-1" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Registrar cliente <span class="fa fa-plus"></span></a>
        </div>
    </div>

    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
                    <th>RAZON SOCIAL</th>
                    <th>NIT</th>
    				<th>DIRECCION</th>
                    <th>TELEFONO</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php foreach ($listarClientes as $lc){ ?>
    				<tr>                
                        <td><?php echo $lc['razon_social']?></td>
                        <td><?php echo $lc['nit'] ?></td>                   
                        <td><?php echo $lc['direccion'] ?></td>                   
                        <td><?php echo $lc['telefono'] ?></td>
                        <td>
                            <a href="" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
                                    <span class="fa fa-edit"></span>
                            </a>
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