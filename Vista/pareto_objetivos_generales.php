<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Actas.php");

$acta = new Acta();
$listarActa = $acta->listarActas();
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Objetivos Generales</title>
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
            <li class="breadcrumb-item active" aria-current="page">Objetivos Generales</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-object-ungroup" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Objetivos Generales</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <a href="registrarActas.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Registrar Objetivo General <span class="fa fa-plus"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
    				<th width="60">ID</th>
                    <th>DESCRIPCIÓN</th>
    				<th width="80">ACCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
    			<tr>
    				<td></td>
                    <td></td>
                    <td></td>
    			</tr>
    		</tbody>
    	</table>
    </div>
    
    <!-- FIN CONTENIDO -->


    <!-- script -->
    <?php include("Template/scripts.php"); ?>


</body>
</html>