<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Facturacion.php");

/* VARIABLES MENU*/
$titulo = 'Actualizar Facturacion';
$redireccion = 'facturaciones.php';
$icono = 'fa fa-money';

$id_facturacion = $_GET['id_facturacion'];

$vehiculo = new Vehiculo();
$listarVehiculos = $vehiculo->listar();

$contrato = new Contrato();
$listarContratos = $contrato->listarTodos();

$cliente = new Cliente();

$facturacion = new Facturacion();
$listarFacturacionPorId = $facturacion->listarPorId($id_facturacion);

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Facturacion</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="facturaciones.php">Facturaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Facturaciones</li>
         </ol>
    </div>

    <section class="form-usuarios mt1">
        <div class="formulario mb-5">

            <form action="../Controlador/actualizarFacturacion.php" method="POST">
			    <?php include("Template/header-form.php"); ?>
					<?php foreach ($listarFacturacionPorId as $lfpi){ ?>

						<input type="hidden" name="id_facturacion" id="id_facturacion" value="<?php echo $lfpi['id_facturacion'] ?>">
						<input type="hidden" name="estado" id="estado" value="<?php echo $lfpi['estado'] ?>">
						
						<!--VEHICULO-->
						    <div class="row mt-3 mb-4">
						        <div class="label">
						            <label>Vehiculo</label>
						        </div>
						        <div class="input">
						      		<select class="form-control" name="id_vehiculo" id="id_vehiculo">
						        		<?php foreach ($listarVehiculos as $lv){ ?>
						        			<option value="<?php echo $lv['id_vehiculo'] ?>" <?php if($lfpi['id_vehiculo'] == $lv['id_vehiculo']){?> selected = "selected"<?php }  ?>>
						        				<?php echo $lv['placa'] ?>
						        			</option>
						        		<?php } ?>
						      		</select>
						        </div>
						    </div>

						<!--MES-->
							<div class="row mt-3">
								<div class="label">
									<label>Mes</label>
								</div>
								<div class="input">
								    <input type="month" name="mes" id="datepicker" class="form-control" value="<?php $fecha = explode('-',$lfpi['mes']); $año = $fecha[0]; $mes = $fecha[1]; echo $año . '-' . $mes ?>">
								</div>
						    </div>

					    <!--DIAS FACTURADOS-->
							<div class="row mt-3">
								<div class="label">
									<label>Dias Facturados</label>
								</div>
								<div class="input">
								    <input type="text" name="dias_facturados" id="dias_facturados" class="form-control" value="<?php echo $lfpi['dias_facturados'] ?>">
								</div>
						    </div>

				    	<!--VALOR TOTAL FACTURADO-->
							<div class="row mt-3">
								<div class="label">
									<label>Valor Total Facturado</label>
								</div>
								<div class="input">
								    <input type="text" name="valor_total_facturado" id="valor_total_facturado" class="form-control" value="<?php echo $lfpi['valor_total_facturado'] ?>">
								</div>
						    </div>

				    	<!--VALOR TOTAL A PAGAR TERCEROS-->
							<div class="row mt-3">
								<div class="label">
									<label>Valor Total a Pagar al Tercero</label>
								</div>
								<div class="input">
								    <input type="text" name="valor_total_pagar_terceros" id="valor_total_pagar_terceros" class="form-control" value="<?php echo $lfpi['valor_total_pagar_terceros'] ?>">
								</div>
						    </div>

				    	<!-- FECHA FACTURA-->
							<div class="row mt-3">
								<div class="label">
									<label>Fecha Factura</label>
								</div>
								<div class="input">
								    <input type="date" name="fecha_factura" id="datepicker1" class="form-control" value="<?php echo $lfpi['fecha_factura'] ?>">
								</div>
						    </div>

				    	<!-- FECHA RECIBO PAGO-->
							<div class="row mt-3">
								<div class="label">
									<label>Fecha Recibo del Pago</label>
								</div>
								<div class="input">
								    <input type="date" name="fecha_recibo_pago" id="datepicker2" class="form-control" value="<?php echo $lfpi['fecha_recibo_pago'] ?>">
								</div>
						    </div>

				    	<!-- CONTRATOS-->
						    <div class="row mt-3 mb-4">
						        <div class="label">
						            <label>Contrato</label>
						        </div>
						        <div class="input">
						      		<select class="form-control" name="id_contrato" id="id_contrato">
						        		<?php foreach ($listarContratos as $lc){ ?>
						        			<option value="<?php echo $lc['id_contrato'] ?>" <?php if($lfpi['id_contrato'] == $lc['id_contrato']){?> selected = "selected"<?php }  ?>>
						        				
						        				<?php 
													$listarClienteId = $cliente->listarClientePorId($lc['id_cliente']); 
													echo "N. " . " " . $lc['id_contrato'] .  " " .  $listarClienteId[0]['razon_social']  . " -  DESDE: " .  $lc['fecha_inicial_contrato'] . ' HASTA: ' . $lc['fecha_final_contrato']?>
						        			</option>
						        		<?php } ?>
						      		</select>
						        </div>
						    </div>

					<?php } ?>

					        
			    <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
    	 $( function() {
	       
	        $( "#datepicker1").datepicker({
	        	dateFormat: "yy-mm-dd",
	        	minDate: 0
	        });

	        $( "#datepicker2").datepicker({
	        	dateFormat: "yy-mm-dd",
	        	minDate: 0
	        });
	    } );
    </script>
</body>
</html>

