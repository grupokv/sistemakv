<?php 
	include ("../Controlador/Sesion/autenticar.php");
	require_once ('../Modelo/Operacion.php');

	$operaciones = new Operacion();
    $listarO = $operaciones->listar();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Operaciones</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
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
            <li class="breadcrumb-item " aria-current="page"><a href="../Vista/inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Operaciones</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-briefcase"  style="border: 1px solid #fff; border-radius: 50%; padding: 7px;"></span> Operaciones</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <a href="registrarOperaciones.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">registrar operación <span class="fa fa-plus"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
    				<th>NOMBRE DE LA OPERACIÓN</th>
                    <th>DESCRIPCIÓN OPERACION</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php foreach ($listarO as $lo){ ?>
                	<tr>
                        <td><?php echo $lo['nombre_operacion']; ?></td>
                        <td><?php echo $lo['descripcion']; ?></td>
                        <td>
                        	<!--Editar-->
    					    <a href="actualizarOperaciones.php?id_operacion=<?php echo $lo['id_operacion']; ?>" class="btn btn-info" data-toggle="tooltip" data-placement="button" title="Editar area"   style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>

    					    <!--Eliminar-->
    					    <a href="../Controlador/eliminarOperacion.php?id_operacion=<?php echo $lo['id_operacion']; ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="button" title="Eliminar area"   style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-trash"></span></a>
                        </td>
                	</tr>
    			<?php } ?>
    		</tbody>
    	</table>
    </div>
    
    <!-- FIN CONTENIDO -->


    <!-- script -->
    <?php include("Template/scripts.php"); ?>


</body>
</html>