<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/Cartera.php");
require_once("../Modelo/Cliente.php");
date_default_timezone_set('America/Bogota');


$cartera = new Cartera();
/* -------------- ACTUALIZAR ESTADO DE DESCUENTOS ---------------- */

$hoy = date("Y-m-d");
$actualizarEstadoDescuentos = $cartera->actualizarEstadoDescuentos($hoy);

/* --------------------------------------------------------------- */

$listarDescuentosCartera = $cartera->listarDescuentosCartera();

$vehiculo = new Vehiculo();
$listarVehiculosVinculados = $vehiculo->listarVehiculosVinculados();

$conceptoCobro = new ConceptoCobro();
$listarConceptos = $conceptoCobro->listar();

$cliente = new Cliente();

?>

<!DOCTYPE html>
<html>
<head><meta charset="euc-kr">
  
  <title>SistemaKV | Descuentos Cartera</title>
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
            <li class="breadcrumb-item active" aria-current="page">Descuentos Cartera</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-file-text" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Descuentos Cartera </h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <a href="reportesDescuentos.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;"> Reportes <span class="fa fa-file-text"></span></a>
            <a href="generarDescuentos.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Generar Descuentos <span class="fa fa-plus"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
    		<thead>
    			<tr>
                    <th>ID DESCUENTO</th>
                    <th>VEHICULO</th>
    				<th>CONCEPTO</th>
                    <th>DESCUENTO</th>
                    <th>PERIODO VALIDO DEL DESCUENTO</th>
                    <th>DESCUENTO DE NOMINA</th>
                    <th>CLIENTE</th>
                    <th>ESTADO</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
    		    <?php foreach($listarDescuentosCartera As $ldc){ ?>
    				<tr>   
                        <td><?php echo $ldc['id_descuento']; ?></td>
                        <td>
                            <?php 
                                $listarVehiculoPorId = $vehiculo->listarPorId($ldc['id_vehiculo']);
                                echo $listarVehiculoPorId[0]['placa'] . " - " . $listarVehiculoPorId[0]['numero_movil']; 
                            ?>
                        </td>
                        <td>
                            <?php 
                                $listarConceptosPorId = $conceptoCobro->listarPorId($ldc['id_concepto']);
                                echo $listarConceptosPorId[0]['detalle_concepto']; 
                            ?>
                        </td>
                        <td><?php if($ldc['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $ldc['descuento']; }else{ echo "$ " . number_format($ldc['descuento']); } ?></td>
                        <td>
                            <?php 
                                $datetime1 = date_create($ldc['fecha_inicial_valido']); 
                                $datetime2 = date_create($ldc['fecha_final_valido']); 
                                $diferencia = date_diff($datetime1, $datetime2);
                                echo $diferencia->format('%R%a Dias validos.') . " | " . $ldc['fecha_inicial_valido'] . " - " . $ldc['fecha_final_valido']; 
                            
                            ?>
                        </td>
                        <td>
                            <?php if($ldc['descuento_nomina'] == "S"){ ?>
                                <p>SI</p>
                            <?php }else{ ?>
                                <p>NO</p>
                            <?php } ?>
                        </td>
                        <td>
                            <?php 
                                $listarClienteId = $cliente->cliente_ID($ldc['id_cliente']);
                                echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                            ?>
                        </td>
                        <td>
                            <?php if($ldc['estado'] == "A"){ ?>
                                <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                            <?php }else{ ?>
                                <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="../Vista/actualizarDescuento.php?id_descuento=<?php echo $ldc['id_descuento']; ?>" class="btn btn-outline-info" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>
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