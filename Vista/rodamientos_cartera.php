<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cartera.php");
require_once("../Modelo/Cliente.php");

$cliente = new Cliente();


$cartera = new Cartera();
$listarRodamientosCartera = $cartera->listarRodamientosCartera();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Rodamientos</title>
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
            <li class="breadcrumb-item active" aria-current="page">Rodamientos</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-gears" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Rodamientos</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <a href="registrarRodamientos.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">registrar Rodamiento <span class="fa fa-plus"></span></a>
            <a href="registrarRodamientos.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Importar Excel <span class="fa fa-upload"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr class="text-center">
    				<th>ID</th>
    				<th>EMPRESA</th>
    				<th>CLIENTE</th>
    				<th>TIPO IDENTIFICACIÓN</th>
    				<th>N° DE IDENTIFICACIÓN</th>
    				<th>VALOR TOTAL</th>
    				<th>POR VENCER</th>
    				<th>1 - 30</th>
    				<th>31 - 60</th>
    				<th>61 - 90</th>
    				<th>MAS DE 90</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php foreach ($listarRodamientosCartera as $lrc){ ?>
                    <tr class="text-center">
                        <td><?php echo $lrc['id_rodamiento'] ?></td>
        				<td>
        				    <?php 
        				        if($lrc['id_empresa'] == 1){ 
        				           echo "ORT";
        				        }else{
        				            echo "LP";
        				        }
        				    ?>
        				</td>
        				<td><?php echo $lrc['nombre_cliente']; ?></td>
        				<td><?php echo $lrc['tipo_identificacion']; ?></td>
        				<td><?php echo $lrc['num_identificacion'] ?></td>
        				<td><?php echo "$ " . number_format($lrc['valor_total']); ?></td>
        				<td><?php echo "$ " . number_format($lrc['por_vencer']); ?></td>
        				<td><?php echo "$ " . number_format($lrc['dias_mora_1_30']); ?></td>
        				<td><?php echo "$ " . number_format($lrc['dias_mora_31_60']); ?></td>
        				<td><?php echo "$ " . number_format($lrc['dias_mora_61_90']); ?></td>
        				<td><?php echo "$ " . number_format($lrc['dias_mora_mayor_90']); ?></td>
                    </tr>
                <?php } ?>
    		</tbody>
    	</table>
    </div>
    
    <!-- FIN CONTENIDO -->


    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>
    <!--FIN SCRIPT-->
</body>
</html>