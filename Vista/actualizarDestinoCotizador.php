<?php 
require_once("../Modelo/Cotizador.php");
//include ("../Controlador/Sesion/autenticar.php");

$titulo = 'Destinos Cotizador';
$redireccion = 'adminDestinosCotizacion.php';
$icono = 'fa fa-briefcase';

$id = $_GET['id'];
$cotizacion = new Cotizador();
$listar = $cotizacion->listarDestinoPorId($id);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Destinos Cotizador</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            
	        <form action="../Controlador/actualizarDestinoCotizador.php" method="POST">
	        	
	        		<?php include("Template/header-form.php") ?>

				        <input type="hidden" value="<?php echo $id; ?>" name="id" id="id" class="form-control">
			        		
				        
					  	<div class="row mt-3 ">
					        	<div class="label">
						            <label>Departamento</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['departamento']; ?>" name="departamento" id="departamento" class="form-control">

					        		</div>
					        </div>
	
						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Ciudad</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['ciudad']; ?>" name="ciudad" id="ciudad" class="form-control">

					        	</div>
					        </div>	

						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Dias Servicio</label>
					        	</div>
					        	<div class="input">
					        		<input type="number" value="<?php echo $listar[0]['dias']; ?>" name="dias" id="dias" class="form-control">

					        	</div>
					        </div>	
					
						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Kilometraje</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo ($listar[0]['kilometros']); ?>" name="kilometraje" id="kilometraje" class="form-control" onblur="calculo_kms(this.value)">

					        	</div>
					        </div>

						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Kilometraje Total</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['kms_ida_retorno']; ?>" name="kms" id="kms" class="form-control" readonly="readonly">

					        	</div>
					        </div>	        
				        
						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Peajes Ida</label>
					        	</div>
					        	<div class="input">
					        		<input type="number" value="<?php echo ($listar[0]['total_peaje_viaje']); ?>" name="peajes" id="peajes" class="form-control" onblur="calculo_peajes(this.value)">

					        	</div>
					        </div>

						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Total Peajes</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo ($listar[0]['total_peaje_viaje'] * 2); ?>" name="total_peajes" id="total_peajes" class="form-control" readonly="readonly">

					        	</div>
					        </div>

						<hr/>
						<div class="row mt-3 ">
						<p style="width:100%;text-align:center"><b>TABLA DE VALORES</b></p>
						</div>

						<div class="row mt-3 ">
							<table class="table" style="width:100%; text-align:center">
								<tr>
									<th>TIPO VEHICULO</th>
								 	<th>VALOR PEAJE</th>
									<th>VALOR NORMAL</th>
								</tr>	
								<tr>
									<td>CAMPERO</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['peaje_campero']; ?>" name="peaje_campero" id="peaje_campero" class="form-control">
									</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['valor_campero'] ; ?>" name="valor_campero" id="valor_campero" class="form-control">
									</td>
								</tr>
								<tr>
									<td>DOBLE CABINA</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['peaje_doblecabina']; ?>" name="peaje_doblecabina" id="peaje_doblecabina" class="form-control">
									</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['valor_doblecabina'] ; ?>" name="valor_doblecabina" id="valor_doblecabina" class="form-control">
									</td>
								</tr>
								<tr>
									<td>VAN</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['peaje_van']; ?>" name="peaje_van" id="peaje_van" class="form-control">
									</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['valor_van'] ; ?>" name="valor_van" id="valor_van" class="form-control">
									</td>
								</tr>
								<tr>
									<td>MICROBUS</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['peaje_microbus']; ?>" name="peaje_microbus" id="peaje_microbus" class="form-control">
									</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['valor_microbus'] ; ?>" name="valor_microbus" id="valor_microbus" class="form-control">
									</td>
								</tr>
								<tr>
									<td>BUSETA</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['peaje_buseta']; ?>" name="peaje_buseta" id="peaje_buseta" class="form-control">
									</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['valor_buseta'] ; ?>" name="valor_buseta" id="valor_buseta" class="form-control">
									</td>
								</tr>
								<tr>
									<td>BUSETON</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['peaje_buseton']; ?>" name="peaje_buseton" id="peaje_buseton" class="form-control">
									</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['valor_buseton'] ; ?>" name="valor_buseton" id="valor_buseton" class="form-control">
									</td>
								</tr>
								<tr>
									<td>BUS</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['peaje_bus']; ?>" name="peaje_bus" id="peaje_bus" class="form-control">
									</td>
									<td>
										<input type="text" value="<?php echo $listar[0]['valor_bus'] ; ?>" name="valor_bus" id="valor_bus" class="form-control">
									</td>
								</tr>
							</table>
						</div>	

                    <?php include("Template/bottom-form.php") ?>
	        	
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
<script>
function calculo_kms(val){
	document.getElementById('kms').value = (val * 2);
}
function calculo_peajes(val){
	document.getElementById('total_peajes').value = (val * 2);
}
</script>
</body>
</html>