<?php 
include("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/Pasajero.php");
require_once("../Modelo/TipoPasajero.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Curso.php");

$pasajero = new Pasajero();
$tipopasajero = new TipoPasajero();
$curso = new Curso();
$colegio = new Cliente();
$listar = $pasajero->listar();

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Pasajeros</title>
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
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pasajeros</li>
         </ol>
    </div>
    
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-users" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Pasajeros</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <a href="registrarPasajeros.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Ingresar Pasajero <span class="fa fa-plus"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
                    <th>NOMBRE</th>
                    <th>TIPO</th>
                    <th>CURSO</th>
                    <th>COLEGIO</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php foreach ($listar as $lu){ ?>
                    <tr>
                        <td><?php echo $lu['nombre'] ?></td>
                        <td>
                        	<?php 
                        	$tipopasajeros = $tipopasajero->listarTipoPasajeroPorId($lu['id_tipo']);
                        	echo $tipopasajeros[0]['nombre']; 
                        	?>
                        </td>
                        <td>
                        	<?php
                        	if($lu['id_curso'] != '0'){
                        		$cursos = $curso->listarCursoPorId($lu['id_curso']);
                        		echo $cursos[0]['nombre'];
                        	} else {
                        		echo 'N/A';
                        	}
                        	?>
                        </td>
                        <td>
                        	<?php
                        	$colegios = $colegio->listarClientePorId($lu['id_colegio']);
                        	echo $colegios[0]['razon_social'];
                        	?>
                        </td>
                        <td>
                            <!--Bloquear y Desboquear-->
                            <?php if ($lu['estado'] == 0){ ?>
                                <a href="../Controlador/bloquearDesbloquearPasajero.php?id_pasajero=<?php echo $lu['id_pasajero']; ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
                            <?php } elseif ($lu['estado'] == 1) { ?>
                                <a href="../Controlador/bloquearDesbloquearPasajero.php?id_pasajero=<?php echo $lu['id_pasajero']; ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-lock"></span></a>
                             <?php }  ?>
                            <a href="actualizarPasajeros.php?id_pasajero=<?php echo $lu['id_pasajero'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
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

  
</body>
</html>