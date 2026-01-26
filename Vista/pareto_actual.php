<?php 
include ("../Controlador/Sesion/autenticar.php");
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Pareto Actual</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>

  <style type="text/css" media="screen">
        .panel{
            background-color: red;
        }

        .panel-heading{
            background-color: green;
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
            <li class="breadcrumb-item active" aria-current="page">Pareto Actual</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-file-text" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Pareto Actual</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <a href="registrarActas.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Registrar Actividad <span class="fa fa-plus"></span></a>
            <a href="registrarActas.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Pareto Siguiente Semana <span class="fa fa-calendar-check-o"></span></a>

        </div>
    </div>
    <hr style="background-color:#5e99b1;">

    <section class="d-flex justify-content-around">
        <div style="padding: 15px; width: 98%; border: 3px solid #f2f2f2">
            
            <!-- LLAMADAS-->
            <div class="alert alert-info" role="alert">
                LLAMADAS
            </div>

            <div class="mt-2 p-4 table-responsive">
                <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
            		<thead>
                		<tr>
                			<th>ID</th>
                            <th style="width:500px">DESCRIPCIÓN</th>
                            <th>FECHA</th>
                            <th>ESTADO</th>
                            <th>ACCIONES</th>
                		</tr>
            		</thead>
            		<tbody>
                		<tr>
                			<td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                		</tr>
            		</tbody>
            	</table>
            </div>
        
            <!-- IMPORTANTES-->
            <div class="alert alert-secondary " role="alert">
                IMPORTANTES
            </div>

            <div class="mt-2 p-4 table-responsive">
                <table  id="dataT2" class="table table-hover table-sm display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="width:500px">DESCRIPCIÓN</th>
                            <th>FECHA</th>
                            <th>ESTADO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- URGENTES-->
            <div class="alert alert-danger" role="alert">
                URGENTES
            </div>

            <div class="mt-2 p-4 table-responsive">
                <table  id="dataT3" class="table table-hover table-sm display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="width:500px">DESCRIPCIÓN</th>
                            <th>FECHA</th>
                            <th>ESTADO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
        </div>
    </section>
    <!-- FIN CONTENIDO -->


    <!-- script -->
    <?php include("Template/scripts.php"); ?>


</body>
</html>