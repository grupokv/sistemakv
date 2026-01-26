<?php 

date_default_timezone_set('America/Bogota');
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo-Conductor.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/referenciasConductor.php");
require_once("../Modelo/General.php");

$titulo = 'Actualizar Conductor';

if($_SESSION['id_perfil'] == 2){
	$redireccion = 'inicioPropietarios.php';
}else{
	$redireccion = 'conductores.php';
}

$modulo = 12;
$permisos = permisos($modulo,$_SESSION['id_usuario']);
//print_r($permisos);
if(count($permisos) < 1){
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='".$redireccion."';
    </script>");
}

$icono = 'fa fa-address-card-o';

$fecha2 = strtotime('+1 year',strtotime(date('Y-m-d')));
$year = date('Y');


$hoy = date('Y-m-d');
$plazoVencimiento = strtotime('+3 days',strtotime(date('Y-m-d')));
$plazoVencimiento = date('Y-m-d',$plazoVencimiento);

$id_conductor = $_GET['id_conductor'];

if (!isset($id_conductor)) {
	
}else{

	$conductor = new Conductor();
	$listarPorId = $conductor->listarPorId($id_conductor);
	

	$vehiculoConductor = new Vehiculo_Conductor();
	$listarVC = $vehiculoConductor->listarPorId($id_conductor);

	$vehiculo = new Vehiculo();
	$listarVehi = $vehiculo->listar();

	$usuario = new Usuario();

	$referenciasConductor = new ReferenciasConductor();
	
	/*COMERCIAL*/
		$listarPorTipoReferenciaComercial = $referenciasConductor->listarPorTipoReferenciaComercial($id_conductor);
		$comercial = count($listarPorTipoReferenciaComercial);
	/*LABORAL*/
		$listarPorTipoReferenciaLaboral = $referenciasConductor->listarPorTipoReferenciaLaboral($id_conductor);
		$laboral = count($listarPorTipoReferenciaLaboral);
	/*FAMILIAR*/
		$listarPorTipoReferenciaFamiliar = $referenciasConductor->listarPorTipoReferenciaFamiliar($id_conductor);
		$familiar = count($listarPorTipoReferenciaFamiliar);
	/*PERSONAL*/
		$listarPorTipoReferenciaPersonal = $referenciasConductor->listarPorTipoReferenciaPersonal($id_conductor);
		$personal = count($listarPorTipoReferenciaPersonal);

	$id_vehiculos = array();

	foreach ($listarVC as $lvc) {
		array_push($id_vehiculos, $lvc['id_vehiculo']);
	}
}

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Conductor</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
    	<?php include("Template/styles.php"); ?>
      	<link rel="stylesheet" href="../Resources/css/stylesHeader.css">

      	<style type="text/css">

      		.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
	            background: #1b2d3b !important;
	            border: #fff;
	        }

      	</style>
    <!-- STYLES -->

</head>
<body>
	<!-- MENU -->
      	<?php include("Template/header.php"); ?>
      	<?php include("Template/newMenu.php"); ?>
	<!-- FIN MENU -->

	<!-- ************************** -->

	<!-- CONTENIDO -->

	  	<section class="home_content"> 

			<?php if($_SESSION['id_perfil'] == 2){ ?>
				<div aria-label="breadcrumb" class="mt-1"> 
			        <ol class="breadcrumb" style="background-color: #fff;">
			            <li class="breadcrumb-item " aria-current="page"><a href="inicioPropietarios.php">Inicio</a></li>
			            <li class="breadcrumb-item active" aria-current="page">Actualizar conductor</li>
			        </ol>
			    </div>
		    <?php } else{ ?>
		    	<div aria-label="breadcrumb" class="mt-1"> 
		         	<ol class="breadcrumb" style="background-color: #fff;">
			            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
			            <li class="breadcrumb-item " aria-current="page"><a href="conductores.php">Conductores</a></li>
			            <li class="breadcrumb-item active" aria-current="page">Actualizar conductor</li>
			        </ol>
		    	</div>
		    <?php } ?>

          	<div class="notice notice-sistemakv" style="background-color: #fff;">
              	<strong><i class="fa fa-id-card-o  mr-3" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR CONDUCTOR</b></strong>
          	</div>


		    <section class="form-usuarios mt-1 mb-4" style="background-color: #fff;">

		        <div class="formulario mb-5">

		        	<?php if ($_SESSION['id_perfil'] == 2){ ?>
			        	<form action="../Controlador/seguimientoActualizacionesDocsConductor.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
		        	<?php } else { ?>
		        		<form action="../Controlador/actualizarCon.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
		        	<?php }?> 

			        	<div id="tabs" class="mt-3" style="font-family: 'Lato', sans-serif;">
		                    <ul>
		                      <li><a href="#tabs-1"><b>Información</b></a></li>
		                      <li><a href="#tabs-2"><b>Documentación</b></a></li>
							  <li><a href="#tabs-3"><b>Seguridad Social</b></a></li>
							  <li><a href="#tabs-4"><b>Antecedentes</b></a></li>
		                      <li><a href="#tabs-5"><b>Referencias</b></a></li>
		                    </ul>

		                    <?php foreach ($listarPorId as $lci){ ?>

		                    	<input type="hidden" name="id_conductor" value="<?php echo $lci['id_conductor'] ?>">
		                    	<input type="hidden" name="estado" value="<?php echo $lci['estado'] ?>">

		                    	<!-- INFORMACION BASICA-->
		                            <div id="tabs-1">

			                        	<!--NOMBRE-->
					                        <div class="row mt-3 ">
					        	                <div class="label">
					        		                <label><b>Nombre</b></label>
					        	                </div>
					        	                <div class="input">
					        	                    <?php if($_SESSION['id_usuario'] == '2234'){ ?>
					        	                    <input type="text" name="nombre_conductor"  id="nombre_conductor" class="form-control" value="<?php echo $lci['nombre_conductor'] ?>" >
					        	                    <?php } else { ?>
					        	                    <input type="text" name="nombre_conductor"  id="nombre_conductor" class="form-control" value="<?php echo $lci['nombre_conductor'] ?>" readonly>
					        	                    <?php } ?>
					        	                    <input type="hidden" name="nombre_conductor_act"  id="nombre_conductor_act" class="form-control" value="<?php echo $lci['nombre_conductor'] ?>">
					        	                </div>      		
					                        </div>

			                            <!-- NUMERO DE DOCUMENTO-->
											<div class="row mt-3 ">
					        			        <div class="label">
					        				        <label><b>Numero de Documento</b></label>
					        			        </div>
					        			        <div class="input">
					        	            		<input type="text" name="numero_documento_conductor"  id="numero_documento_conductor" class="form-control" value="<?php echo $lci['numero_documento_conductor'] ?>" readonly>

					        			        </div>      		
					        		        </div>

					                    <!--PAGO PACTADO-->
					                        <input type="hidden" name="pago_pactado"  id="pago_pactado" class="form-control" value="<?php echo $lci['pago_pactado'] ?>">
					        	                    <input type="hidden" name="pago_pactado_act"  id="pago_pactado_act" class="form-control" value="<?php echo $lci['pago_pactado'] ?>">
					        	    
			                            <!--TELEFONO 1 -->
					        		        <div class="row mt-3 ">
					        			        <div class="label">
					        				        <label><b>Telefono 1</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="text" name="telefono1"  id="telefono1" class="form-control" value="<?php echo $lci['telefono1'] ?>">
					        				        <input type="hidden" name="telefono1_act"  id="telefono1_act" class="form-control" value="<?php echo $lci['telefono1'] ?>">
					        			        </div>      		
					        		        </div>

					        	        <!--TELEFONO 2 -->
					        		        <div class="row mt-3 ">
					        			        <div class="label">
					        				        <label><b>Telefono 2</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="text" name="telefono2"  id="telefono2" class="form-control" value="<?php echo $lci['telefono2'] ?>">
					        				        <input type="hidden" name="telefono2_act"  id="telefono2_act" class="form-control" value="<?php echo $lci['telefono2'] ?>">
					        			        </div>      		
					        		        </div>

				        	     	   	<!--TELEFONO 3 --> 
					        		        <div class="row mt-3 ">
					        			        <div class="label">
					        				        <label><b>Telefono 3</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="text" name="telefono3"  id="telefono3" class="form-control" value="<?php echo $lci['telefono3'] ?>">
					        				        <input type="hidden" name="telefono3_act"  id="telefono3_act" class="form-control" value="<?php echo $lci['telefono3'] ?>">
					        			        </div>      		
					        		        </div>

					        		    <!-- FECHA DE NACIMIENTO-->

											<div class="row mt-3 ">
					        			        <div class="label">
					        				        <label><b>Fecha Nacimiento</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="text" name="fecha_nacimiento_conductor" id="datepicker" class="form-control" value="<?php echo $lci['fecha_nacimiento_conductor'] ?>">
					        				        <input type="hidden" name="fecha_nacimiento_conductor_act" id="datepicker" class="form-control" value="<?php echo $lci['fecha_nacimiento_conductor'] ?>">
					        			        </div>      		
					        		        </div>

					        		    <!-- CORREO ELECTRONICO-->

											<div class="row mt-3 ">
					        			        <div class="label">
					        				        <label><b>Correo Electronico</b></label>
					        			        </div>
					        			        <div class="input">

					        			        	<?php  $listarUsuPorId = $usuario->listarUsuarioPorCedula($lci['numero_documento_conductor']); ?>
					        			        	
					        			        		<input type="text" name="correo_electronico" id="correo_electronico" class="form-control" value="<?php echo $listarUsuPorId[0]['correo_electronico'] ?>">
					        				        	<input type="hidden" name="correo_electronico_act" id="correo_electronico_act" class="form-control" value="<?php echo $listarUsuPorId[0]['correo_electronico'] ?>">
					        			        </div>      		
					        		        </div>

					        		    <!-- DIRECCION-->

											<div class="row mt-3 ">
					        			        <div class="label">
					        				        <label><b>Dirección</b></label>
					        			        </div>
					        			        <div class="input">
					        			        	<input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo $lci['direccion'] ?>">
					        			        	<input type="hidden" name="act_direccion" id="act_direccion" class="form-control" value="<?php echo $lci['direccion'] ?>">
					        				        	
					        			        </div>      		
					        		        </div>

					        		    <!-- GENERO --> 
					        		        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>Genero</b></label>
					        			        </div>
					        			        <div class="input">
			                                        <select class="form-control" name="genero" id="genero">
			                                        	<option value="M" <?php if ($lci['genero'] == 'M'){ ?> selected="selected"
			                                        	<?php } ?>>Masculino</option>
			                                        	
			                                            <option value="F" <?php if ($lci['genero'] == 'F'){ ?> selected="selected"<?php } ?>>Femenino</option>
			                                            
			                                        </select>
			                                    </div>    
			                                    <input type="hidden" name="genero_act" value="<?php echo $lci['genero'] ?>">  		
					        		        </div>
				        		    
					        		    <!-- RH --> 
					        		        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>RH</b></label>
					        			        </div>

					        			        <div class="input">
			                                        <select class="form-control selectpicker" data-live-search="true" name="rh" id="rh">
			                                        	
			                                            <option value="O+" <?php if ($lci['grupo_sanguineo'] == 'O+'){ ?> selected="selected" <?php } ?> >O +</option>
			                                        	
			                                            <option value="O-" <?php if ($lci['grupo_sanguineo'] == 'O-'){ ?> selected="selected"<?php } ?> >O -</option>

			                                        	<option value="A+" <?php if ($lci['grupo_sanguineo'] == 'A+'){ ?> selected="selected" <?php } ?>> A +</option>

			                                            <option value="A-" <?php if ($lci['grupo_sanguineo'] == 'A-'){ ?> selected="selected"<?php } ?>> A -</option>

			                                        	<option value="B+" <?php if ($lci['grupo_sanguineo'] == 'B+'){ ?> selected="selected"<?php } ?>>B +</option>
														
														<option value="B-" <?php if ($lci['grupo_sanguineo'] == 'B-'){ ?> selected="selected"<?php } ?>>B -</option>
														
														<option value="AB+" <?php if ($lci['grupo_sanguineo'] == 'AB+'){ ?> selected="selected"<?php } ?>>AB +</option>
														
														<option value="AB-" <?php if ($lci['grupo_sanguineo'] == 'AB-'){ ?> selected="selected"<?php } ?>>AB -</option>

			                                        </select>
			                                    </div>


			                                    <input type="hidden" name="rh_act" value="<?php echo $lci['grupo_sanguineo'] ?>">       		
					        		        </div>

					        		   	<!-- ESTADO CIVIL --> 
					        		        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>Estado Civil</b></label>
					        			        </div>
					        			        <div class="input">
			                                        <select class="form-control selectpicker" data-live-search="true" name="estado_civil" id="estado_civil">

			                                        	<option value="S" <?php if ($lci['estado_civil'] == 'S'){ ?> selected="selected"<?php } ?>>Soltero(a)</option>
														
														<option value="C" <?php if ($lci['estado_civil'] == 'C'){ ?>selected="selected"<?php } ?>>Casado(a)</option>
														
				                                        <option value="U"<?php if ($lci['estado_civil'] == 'U'){ ?> selected="selected"<?php } ?>>Unión Libre</option>
				                                        
														<option value="D"<?php if ($lci['estado_civil'] == 'D'){ ?> selected="selected"<?php } ?>>Divorciado(a)</option>
														
														<option value="V" <?php if ($lci['estado_civil'] == 'V'){ ?> selected="selected"<?php } ?>>Viudo(a)</option>
				                                        
			                                        </select>

			                                        <input type="hidden" name="estado_civil_act" value="<?php echo $lci['estado_civil']; ?>">
			                                    </div>      		
					        		        </div>

				        		  		<!-- VEHICULO --> 
					        		        <div class="row mt-3 ">
					        			        <div class="label">
					        				        <label><b>Vehículo</b></label>
					        			        </div>
					        			        <div class="input">
			                                        <select class="form-control" name="id_vehiculo[]" id="id_vehiculo" multiple="multiple">
			                                            <?php foreach ($listarVehi as $lv){ ?>
			                                                <option value="<?php echo $lv['id_vehiculo'] ?>" <?php if(in_array($lv['id_vehiculo'], $id_vehiculos)){ ?> selected="selected" <?php } ?>>
			                                                    <?php echo $lv['placa'] . ' - ' . $lv['marca']?>
			                                                </option>
			                                            <?php } ?>
			                                        </select>
			                                    </div>      		
					        		        </div>

					        		</div>

		                        <!-- DOCUMENTACIÓN-->
		                            <div id="tabs-2">

		                            	<!--FOTOGRAFIA DEL CONDUCTOR-->
					                        <div class="row mt-3">
					        	                <div class="label">
					        		                <label><b>Fotografia</b></label>
					        	                </div>
					        	                <div class="input">
					        	                    <input type="file" name="fotografia_conductor"  id="fotografia_conductor" class="form-control">
					        	                    <input type="hidden" name="act_fotografia_conductor"  id="act_fotografia_conductor" class="form-control" value="<?php echo $lci['fotografia_conductor'] ?>">

					        	                     <?php if ($lci['fotografia_conductor'] == '') { ?>
					        	                        <label class="mt-2" for="act_fotografia_conductor"><strong>Fotografia Actual: </strong> No hay fotografias cargadas</label>
					        	                    <?php } else{ ?>
					        	                        <label class="mt-2" for="act_fotografia_conductor"><strong>Fotografia Actual: </strong> <?php echo $lci['fotografia_conductor'] ?></label>
					        	                    <?php }  ?>
					        	                </div>      		
					                        </div>

					                    <!--FOTOCOPIA DEL DOCUMENTO-->
					                        <div class="row mt-3 ">
					        	                <div class="label">
					        		                <label><b>Fotocopia documento</b></label>
					        	                </div>
					        	                <div class="input">
					        	                    <input type="file" name="fotocopia_documento"  id="fotocopia_documento" class="form-control">
					        	                    <input type="hidden" name="act_fotocopia_documento" id="act_fotocopia_documento" value="<?php echo $lci['fotocopia_documento'] ?>">
					        	                    
					        	                    <?php if ($lci['fotocopia_documento'] == '') { ?>
					        	                        <label class="mt-2" for="act_fotocopia_documento"><strong>Documento Actual: </strong> No hay documentos cargados</label>
					        	                    <?php } else{ ?>
					        	                        <label class="mt-2" for="act_fotocopia_documento"><strong>Documento Actual: </strong> <?php echo $lci['fotocopia_documento'] ?></label>
					        	                    <?php }  ?>
					        	                </div>      		
					                        </div>

					                    <!--NUMERO DE LICENCIA-->
					                        <div class="row mt-3 ">
					        	                <div class="label">
					        		                <label><b>Numero Licencia</b></label>
					        	                </div>
					        	                <div class="input">
					        	                    <input type="text" name="num_licencia"  id="num_licencia" value="<?php echo $lci['num_licencia'] ?>" class="form-control">
					        	                    <input type="hidden" name="num_licencia_act"  id="num_licencia_act" value="<?php echo $lci['num_licencia'] ?>" class="form-control">
					        	                </div>      		
					                        </div>

					                    <!-- CATEGORIA LICENCIA -->
					        		        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>Categoria Licencia</b></label>
					        			        </div>
					        			        <div class="input">
			                                        <select class="form-control" name="categoria_licencia" id="categoria_licencia">
			                                        	
			                                        	<option value="B1" <?php if ($lci['categoria_licencia'] == 'B1'){ ?>selected="selected"<?php } ?>>B1</option>
			                                        	
														<option value="B2" <?php if ($lci['categoria_licencia'] == 'B2'){ ?>selected="selected"<?php } ?>>B2</option>
			                                            

			                                            
			                                            <option value="B3" <?php if ($lci['categoria_licencia'] == 'B3'){ ?>selected="selected"<?php } ?>>B3</option>
			                                            

			                                            
			                                            <option value="C1" <?php if ($lci['categoria_licencia'] == 'C1'){ ?>selected="selected"<?php } ?>>C1</option>
			                                            

			                                            
			                                            <option value="C2" <?php if ($lci['categoria_licencia'] == 'C2'){ ?>selected="selected"<?php } ?>>C2</option>
			                                            

			                                            
			                                            <option value="C3" <?php if ($lci['categoria_licencia'] == 'C3'){ ?>selected="selected"<?php } ?>>C3</option>
			                                            

			                                        </select>

			                                        <input type="hidden" name="act_categoria_licencia" value="<?php echo $lci['categoria_licencia'] ?>">
			                                    </div>      		
					        		        </div>
					        		        
					                    <!--LICENCIA DE CONDUCCIÓN-->
					                    	<?php if ($lci['fecha_vencimiento_licencia'] <= $hoy) { ?>

						                        <div class="row mt-3">
						        	                <section class="col">
						        		                <div class="row">
						        			                <div class="label">
						        				                <label><b>Licencia de conducción</b></label>
						        			                </div>
						        			                <div class="input">
						        				                <input style="border: 2px solid red" type="file" name="fotocopia_licencia"  id="fotocopia_licencia" class="form-control">
						        	                            <input type="hidden" name="fotocopia_licencia_act" id="fotocopia_licencia_act" value="<?php echo $lci['fotocopia_licencia'] ?>">
						        			                </div>      		
						        		                </div>
						        	                </section>
						        	                <section class="col">
						        		                <div class="row">
						        			                <div class="label">
						        				                <label><b>Fecha vencimiento</b></label>
						        			                </div>
						        			                <div class="input">
						        				                <input style="border: 2px solid red" type="text" name="fecha_vencimiento_licencia" id="datepicker1" class="form-control" value="<?php echo $lci['fecha_vencimiento_licencia'] ?>">
						        				                <input type="hidden" name="fecha_vencimiento_licencia_act" id="datepicker1" class="form-control" value="<?php echo $lci['fecha_vencimiento_licencia'] ?>">
						        			                </div>      		
						        		                </div>
						        	                </section>
						                        </div>

											<?php } else if(($lci['fecha_vencimiento_licencia'] <= $plazoVencimiento) && ($lci['fecha_vencimiento_licencia'] > $hoy)){ ?>
											
												<div class="row mt-3">
						        	                <section class="col">
						        		                <div class="row">
						        			                <div class="label">
						        				                <label><b>Licencia de conducción</b></label>
						        			                </div>
						        			                <div class="input">
						        				                <input style="border: 2px solid orange" type="file" name="fotocopia_licencia"  id="fotocopia_licencia" class="form-control">
						        	                            <input type="hidden" name="fotocopia_licencia_act" id="fotocopia_licencia_act" value="<?php echo $lci['fotocopia_licencia'] ?>">
						        			                </div>      		
						        		                </div>
						        	                </section>
						        	                <section class="col">
						        		                <div class="row">
						        			                <div class="label">
						        				                <label><b>Fecha vencimiento</b></label>
						        			                </div>
						        			                <div class="input">
						        				                <input style="border: 2px solid orange" type="text" name="fecha_vencimiento_licencia" id="datepicker1" class="form-control" value="<?php echo $lci['fecha_vencimiento_licencia'] ?>">
						        				                <input type="hidden" name="fecha_vencimiento_licencia_act" id="datepicker1" class="form-control" value="<?php echo $lci['fecha_vencimiento_licencia'] ?>">
						        			                </div>      		
						        		                </div>
						        	                </section>
						                        </div>
											<?php } else { ?>

						                        <div class="row mt-3">
						        	                <section class="col">
						        		                <div class="row">
						        			                <div class="label">
						        				                <label><b>Licencia de conducción</b></label>
						        			                </div>
						        			                <div class="input">
						        				                <input  type="file" name="fotocopia_licencia"  id="fotocopia_licencia" class="form-control">
						        	                            <input type="hidden" name="fotocopia_licencia_act" id="fotocopia_licencia_act" value="<?php echo $lci['fotocopia_licencia'] ?>">
						        			                </div>      		
						        		                </div>
						        	                </section>
						        	                <section class="col">
						        		                <div class="row">
						        			                <div class="label">
						        				                <label><b>Fecha vencimiento</b></label>
						        			                </div>
						        			                <div class="input">
						        				                <input type="text" name="fecha_vencimiento_licencia" id="datepicker1" class="form-control" value="<?php echo $lci['fecha_vencimiento_licencia'] ?>">
						        				                <input type="hidden" name="fecha_vencimiento_licencia_act" id="datepicker1" class="form-control" value="<?php echo $lci['fecha_vencimiento_licencia'] ?>">
						        			                </div>      		
						        		                </div>
						        	                </section>
						                        </div>
						                    
											<?php } ?>
											
					                        <div class="row justify-content-around">
					                        	<?php if ($lci['fotocopia_licencia'] == '') { ?>
					        	                   	<label class="mt-2" for="fotocopia_licencia_act"><strong>Documento Actual: </strong> No hay documentos cargados</label>
					        	                <?php } else{ ?>
					        	                   	<label class="mt-2" for="fotocopia_licencia_act"><strong>Documento Actual: </strong> <?php echo $lci['fotocopia_licencia'] ?></label>
					        	                <?php }  ?>
					                        </div>

					                    <!--CERTIFICADOS LABORALES-->
					                        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>Certificados Laborales</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="file" name="certificados_laborales"  id="certificados_laborales" class="form-control">
					        				        <input type="hidden" name="act_certificados_laborales" id="act_certificados_laborales" value="<?php echo $lci['certificados_laborales'] ?>">
						        			        <?php if ($lci['certificados_laborales'] == '') { ?>
							        	                <label class="mt-2" for="act_certificados_laborales"><strong>Documento Actual: </strong> No hay documentos cargados</label>
							        	            <?php } else{ ?>
							        	                <label class="mt-2" for="act_certificados_laborales"><strong>Documento Actual: </strong> <?php echo $lci['certificados_laborales'] ?></label>
							        	            <?php }  ?>
					        			        </div> 

					                        </div>

					                    <!--CERTIFICADOS ESTUDIOS-->
					                        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>Certificados Estudios</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="file" name="certificados_estudios"  id="certificados_estudios" class="form-control">
					        				        <input type="hidden" name="act_certificados_estudios" id="act_certificados_estudios" value="<?php echo $lci['certificados_estudios'] ?>">

						        			        <?php if ($lci['certificados_estudios'] == '') { ?>
							        	                <label class="mt-2" for="act_certificados_estudios"><strong>Documento Actual: </strong> No hay documentos cargados</label>
							        	            <?php } else{ ?>
							        	                <label class="mt-2" for="act_certificados_estudios"><strong>Documento Actual: </strong> <?php echo $lci['certificados_estudios'] ?></label>
							        	            <?php }  ?>
					        			        </div>
					                        </div>

					                    <!--CERTIFICADOS CURSOS-->
					                        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>Certificados Cursos</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="file" name="certificados_cursos"  id="certificados_cursos" class="form-control">
					        				        <input type="hidden" name="act_certificados_cursos" id="act_certificados_cursos" value="<?php echo $lci['certificados_cursos'] ?>">

							        			        <?php if ($lci['certificados_cursos'] == '') { ?>
								        	                <label class="mt-2" for="act_certificados_cursos"><strong>Documento Actual: </strong> No hay documentos cargados</label>
								        	            <?php } else{ ?>
								        	                <label class="mt-2" for="act_certificados_cursos"><strong>Documento Actual: </strong> <?php echo $lci['certificados_cursos'] ?></label>
								        	            <?php }  ?>
					        			        </div>   
					                        </div>

					                    <!--LIBRETA MILITAR-->
					                        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>Libreta Militar</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="file" name="libreta_militar"  id="libreta_militar" class="form-control">
					        				        <input type="hidden" name="act_libreta_militar" id="act_libreta_militar" value="<?php echo $lci['antecedentes'] ?>">

						        			        <?php if ($lci['libreta_militar'] == '') { ?>
							        	                <label class="mt-2" for="act_libreta_militar"><strong>Documento Actual: </strong> No hay documentos cargados</label>
							        	            <?php } else{ ?>
							        	                <label class="mt-2" for="act_libreta_militar"><strong>Documento Actual: </strong> <?php echo $lci['libreta_militar'] ?></label>
							        	            <?php }  ?>
					        			        </div>  
					                        </div>

					                    <!--EXAMEN MEDICO-->

											<?php
												if ($lci['fecha_expedicion_examen_medico'] != '0000-00-00') {
													$fechaVencimientoEMMasUnAño = strtotime('1 year',strtotime($lci['fecha_expedicion_examen_medico'])); 
													$fechaVencimientoExamenMedico = date('Y-m-d',$fechaVencimientoEMMasUnAño); 
												
													$fecha1 = strtotime('+3 days',strtotime(date('Y-m-d')));
													$fechaHoyMasTresDias = date('Y-m-d',$fecha1);
												}
											
											?>

											
						                    <?php if (($lci['fecha_expedicion_examen_medico'] == '0000-00-00') || ($fechaVencimientoExamenMedico < date('Y-m-d'))){ ?>
						                    	
							                        <div class="row mt-3">
							                        	<section class="col">
							        		                <div class="row mt-3">
									        			        <div class="label">
									        				        <label><b>Examen Medico (IPS Autorizada)</b></label>
									        			        </div>
									        			        <div class="input">
									        				        <input style="border: 2px solid red" type="file" name="examen_medico"  id="examen_medico" class="form-control"> <input type="hidden" name="act_examen_medico" id="act_examen_medico" value="<?php echo $lci['examen_medico'] ?>">
									        			        </div> 
									                        </div>
							        		            </section>
							        		            <section class="col">
							        		                <div class="row mt-3">
							        			                <div class="label">
							        				                <label><b>Fecha Expedición Examen Medico</b></label>
							        			                </div>
							        			                <div class="input">
							        				                <input style="border: 2px solid red" type="text" name="fecha_expedicion_examen_medico" value="<?php echo $lci['fecha_expedicion_examen_medico'] ?>" id="datepicker2" class="form-control">
							        				                <input type="hidden" name="act_fecha_expedicion_examen_medico" id="datepicker2" class="form-control" value="<?php echo $lci['fecha_expedicion_examen_medico'] ?>">
							        			                </div>      		
							        		                </div>
							        		            </section>
							                        </div>

						                    <?php } else if (($fechaVencimientoExamenMedico <= $fechaHoyMasTresDias) && ($fechaVencimientoExamenMedico >= date('Y-m-d'))) { ?>
						                    		
						                    		<div class="row mt-3">
							                        	<section class="col">
							        		                <div class="row mt-3">
									        			        <div class="label">
									        				        <label>Examen Medico (IPS Autorizada)</label>
									        			        </div>
									        			        <div class="input">
									        				        <input style="border: 2px solid orange" type="file" name="examen_medico"  id="examen_medico" class="form-control"> <input type="hidden" name="act_examen_medico" id="act_examen_medico" value="<?php echo $lci['examen_medico'] ?>">
									        			        </div> 
									                        </div>
							        		            </section>
							        		            <section class="col">
							        		                <div class="row mt-3">
							        			                <div class="label">
							        				                <label>Fecha Expedición Examen Medico</label>
							        			                </div>
							        			                <div class="input">
							        				                <input style="border: 2px solid orange" type="text" name="fecha_expedicion_examen_medico" value="<?php echo $lci['fecha_expedicion_examen_medico'] ?>" id="datepicker2" class="form-control">
							        				                <input type="hidden" name="act_fecha_expedicion_examen_medico" id="datepicker2" class="form-control" value="<?php echo $lci['fecha_expedicion_examen_medico'] ?>">
							        			                </div>      		
							        		                </div>
							        		            </section>
							                        </div>

						                    <?php } else { ?>
													<div class="row mt-3">

							                        	<section class="col">
							        		                <div class="row mt-3">
									        			        <div class="label">
									        				        <label>Examen Medico (IPS Autorizada)</label>
									        			        </div>
									        			        <div class="input">
									        				        <input type="file" name="examen_medico"  id="examen_medico" class="form-control"> <input type="hidden" name="act_examen_medico" id="act_examen_medico" value="<?php echo $lci['examen_medico'] ?>">
									        			        </div> 
									                        </div>
							        		            </section>
							        		            <section class="col">
							        		                <div class="row mt-3">
							        			                <div class="label">
							        				                <label>Fecha Expedición Examen Medico</label>
							        			                </div>
							        			                <div class="input">
							        				                <input type="text" name="fecha_expedicion_examen_medico" value="<?php echo $lci['fecha_expedicion_examen_medico'] ?>" id="datepicker2" class="form-control">
							        				                <input type="hidden" name="act_fecha_expedicion_examen_medico" id="datepicker2" class="form-control" value="<?php echo $lci['fecha_expedicion_examen_medico'] ?>">
							        			                </div>      		
							        		                </div>
							        		            </section>
							                        </div>
						                    <?php } ?>
						                        <div class="row justify-content-around">
						                        	<?php if ($lci['examen_medico'] == '') { ?>
										        	    <label class="mt-2" for="act_examen_medico"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										        	<?php } else{ ?>
										        	    <label class="mt-2" for="act_examen_medico"><strong>Documento Actual: </strong> <?php echo $lci['examen_medico'] ?></label>
										        	<?php }  ?>
										        </div> 

					                    <!-- SEGURIDAD SOCIAL-->
										<input type="hidden" name="planilla_ss"  id="planilla_ss" value="<?php echo $lci['planilla_ss'] ?>" >
					        			<input type="hidden" name="act_planilla_ss" id="act_planilla_ss" value="<?php echo $lci['planilla_ss'] ?>">
										
										<!-- RUT-->
					                        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>RUT</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="file" name="rut"  id="rut" class="form-control">
					        				        <input type="hidden" name="act_rut" id="act_rut" value="<?php echo $lci['rut'] ?>">

							        			        <?php if ($lci['rut'] == '') { ?>
								        	                <label class="mt-2" for="act_rut"><strong>Documento Actual: </strong> No hay documentos cargados</label>
								        	            <?php } else{ ?>
								        	                <label class="mt-2" for="act_rut"><strong>Documento Actual: </strong> <?php echo $lci['rut'] ?></label>
								        	            <?php }  ?>
					        			        </div>
					                        </div>
										
										<!-- HOJA DE VIDA-->
					                        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>Hoja de Vida</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="file" name="hoja_vida"  id="hoja_vida" class="form-control">
					        				        <input type="hidden" name="act_hoja_vida" id="act_hoja_vida" value="<?php echo $lci['hoja_vida'] ?>">

							        			        <?php if ($lci['hoja_vida'] == '') { ?>
								        	                <label class="mt-2" for="act_hoja_vida"><strong>Documento Actual: </strong> No hay documentos cargados</label>
								        	            <?php } else{ ?>
								        	                <label class="mt-2" for="act_hoja_vida"><strong>Documento Actual: </strong> <?php echo $lci['hoja_vida'] ?></label>
								        	            <?php }  ?>
					        			        </div>
					                        </div>
											
										<!-- CARNET VACUNAS-->
					                        <div class="row mt-3">
					        			        <div class="label">
					        				        <label><b>Carnet de Vacunas</b></label>
					        			        </div>
					        			        <div class="input">
					        				        <input type="file" name="vacunas"  id="vacunas" class="form-control">
					        				        <input type="hidden" name="act_vacunas" id="act_vacunas" value="<?php echo $lci['vacunas'] ?>">

							        			        <?php if ($lci['vacunas'] == '') { ?>
								        	                <label class="mt-2" for="act_vacunas"><strong>Documento Actual: </strong> No hay documentos cargados</label>
								        	            <?php } else{ ?>
								        	                <label class="mt-2" for="act_vacunas"><strong>Documento Actual: </strong> <?php echo $lci['vacunas'] ?></label>
								        	            <?php }  ?>
					        			        </div>
					                        </div>
											
										<!--CONTRATO TRABAJO-->
											<?php if (($lci['fecha_contrato'] == '0000-00-00')){ ?>
						                    	
							                        <div class="row mt-3">
							                        	<section class="col">
							        		                <div class="row mt-3">
									        			        <div class="label">
									        				        <label><b>Contrato de Trabajo</b></label>
									        			        </div>
									        			        <div class="input">
									        				        <input style="border: 2px solid red" type="file" name="contrato_trabajo"  id="contrato_trabajo" class="form-control"> <input type="hidden" name="act_contrato_trabajo" id="act_contrato_trabajo" value="<?php echo $lci['contrato_trabajo'] ?>">
									        			        </div> 
									                        </div>
							        		            </section>
							        		            <section class="col">
							        		                <div class="row mt-3">
							        			                <div class="label">
							        				                <label><b>Fecha Expedición Contrato</b></label>
							        			                </div>
							        			                <div class="input">
							        				                <input style="border: 2px solid red" type="text" name="fecha_contrato" value="<?php echo $lci['fecha_contrato'] ?>" id="datepicker4" class="form-control">
							        				                <input type="hidden" name="act_fecha_contrato" class="form-control" value="<?php echo $lci['fecha_contrato'] ?>">
							        			                </div>      		
							        		                </div>
							        		            </section>
							                        </div>

						                    <?php } else { ?>
													<div class="row mt-3">

							                        	<section class="col">
							        		                <div class="row mt-3">
									        			        <div class="label">
									        				        <label>Contrato de Trabajo</label>
									        			        </div>
									        			        <div class="input">
									        				        <input type="file" name="contrato_trabajo"  id="contrato_trabajo" class="form-control"> <input type="hidden" name="act_contrato_trabajo" id="act_contrato_trabajo" value="<?php echo $lci['contrato_trabajo'] ?>">
									        			        </div> 
									                        </div>
							        		            </section>
							        		            <section class="col">
							        		                <div class="row mt-3">
							        			                <div class="label">
							        				                <label>Fecha Expedición Contrato</label>
							        			                </div>
							        			                <div class="input">
							        				                <input type="text" name="fecha_contrato" value="<?php echo $lci['fecha_contrato'] ?>" id="datepicker4" class="form-control">
							        				                <input type="hidden" name="act_fecha_contrato" id="datepicker2" class="form-control" value="<?php echo $lci['fecha_contrato'] ?>">
							        			                </div>      		
							        		                </div>
							        		            </section>
							                        </div>
						                    <?php } ?>
						                        <div class="row justify-content-around">
						                        	<?php if ($lci['contrato_trabajo'] == '') { ?>
										        	    <label class="mt-2" for="act_contrato_trabajo"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										        	<?php } else{ ?>
										        	    <label class="mt-2" for="act_contrato_trabajo"><strong>Documento Actual: </strong> <?php echo $lci['contrato_trabajo'] ?></label>
										        	<?php }  ?>
										        </div> 
		                            </div>
								
								<!-- SEGURIDAD SOCIAL-->
			                        <div id="tabs-3">
										<input type="hidden" name="anno" value="<?php echo $year;?>"/>
										<?php $datosSS = $conductor->buscarPlanillasPorConductor($id_conductor,$year);?>
			                    	    <!--Planilla Enero-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Enero <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_1"  id="planilla_1" class="form-control">
												<input type="hidden" name="act_ene" value="<?php echo $datosSS[0]['enero'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['enero'] == '') { ?>
												<label class="mt-2" for="act_ene"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_ene"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['enero']; ?>"><?php echo $datosSS[0]['enero'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Febrero-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Febrero <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_2"  id="planilla_2" class="form-control">
												<input type="hidden" name="act_feb" value="<?php echo $datosSS[0]['febrero'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['febrero'] == '') { ?>
												<label class="mt-2" for="act_feb"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_feb"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['febrero']; ?>"><?php echo $datosSS[0]['febrero'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Marzo-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Marzo <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_3"  id="planilla_3" class="form-control">
												<input type="hidden" name="act_mar" value="<?php echo $datosSS[0]['marzo'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['marzo'] == '') { ?>
												<label class="mt-2" for="act_mar"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_mar"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['marzo']; ?>"><?php echo $datosSS[0]['marzo'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Abril-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Abril <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_4"  id="planilla_4" class="form-control">
												<input type="hidden" name="act_abr" value="<?php echo $datosSS[0]['abril'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['abril'] == '') { ?>
												<label class="mt-2" for="act_abr"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_abr"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['abril']; ?>"><?php echo $datosSS[0]['abril'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Mayo-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Mayo <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_5"  id="planilla_5" class="form-control">
												<input type="hidden" name="act_may" value="<?php echo $datosSS[0]['mayo'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['mayo'] == '') { ?>
												<label class="mt-2" for="act_may"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_may"><strong>Documento Actual: </strong> <?php echo $datosSS[0]['mayo'] ?></label>
												<label class="mt-2" for="act_may"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['mayo']; ?>"><?php echo $datosSS[0]['mayo'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Junio-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Junio <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_6"  id="planilla_6" class="form-control">
												<input type="hidden" name="act_jun" value="<?php echo $datosSS[0]['junio'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['junio'] == '') { ?>
												<label class="mt-2" for="act_jun"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_jun"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['junio']; ?>"><?php echo $datosSS[0]['junio'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Julio-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Julio <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_7"  id="planilla_7" class="form-control">
												<input type="hidden" name="act_jul" value="<?php echo $datosSS[0]['julio'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['julio'] == '') { ?>
												<label class="mt-2" for="act_jul"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_jul"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['julio']; ?>"><?php echo $datosSS[0]['julio'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Agosto-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Agosto <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_8"  id="planilla_8" class="form-control">
												<input type="hidden" name="act_ago" value="<?php echo $datosSS[0]['agosto'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['agosto'] == '') { ?>
												<label class="mt-2" for="act_ago"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_ago"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['agosto']; ?>"><?php echo $datosSS[0]['agosto'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Septiembre-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Septiembre <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_9"  id="planilla_9" class="form-control">
												<input type="hidden" name="act_sep" value="<?php echo $datosSS[0]['septiembre'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['septiembre'] == '') { ?>
												<label class="mt-2" for="act_sep"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_sep"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['septiembre']; ?>"><?php echo $datosSS[0]['septiembre'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Octubre-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Octubre <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_10"  id="planilla_10" class="form-control">
												<input type="hidden" name="act_oct" value="<?php echo $datosSS[0]['octubre'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['octubre'] == '') { ?>
												<label class="mt-2" for="act_oct"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_oct"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['octubre']; ?>"><?php echo $datosSS[0]['octubre'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Noviembre-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Noviembre <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_11"  id="planilla_11" class="form-control">
												<input type="hidden" name="act_nov" value="<?php echo $datosSS[0]['noviembre'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['noviembre'] == '') { ?>
												<label class="mt-2" for="act_nov"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_nov"><strong>Documento Actual: </strong> <?php echo $datosSS[0]['noviembre'] ?></label>
												<label class="mt-2" for="act_nov"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['noviembre']; ?>"><?php echo $datosSS[0]['noviembre'] ?></a></label>
											<?php }  ?>
										</div>
										
										<!--Planilla Diciembre-->
										<div class="row mt-3">
											<div class="label">
												<label>Planilla Diciembre <?php echo $year;?></label>
											</div>
											<div class="input">
												<input type="file" name="planilla_12"  id="planilla_12" class="form-control">
												<input type="hidden" name="act_dic" value="<?php echo $datosSS[0]['diciembre'];?>"/>
											</div>      		
										</div>
										<div class="row justify-content-around">
											<?php if ($datosSS[0]['diciembre'] == '') { ?>
												<label class="mt-2" for="act_dic"><strong>Documento Actual: </strong> No hay documentos cargados</label>
											<?php } else{ ?>
												<label class="mt-2" for="act_dic"><strong>Documento Actual: </strong> <a style="color:blue;" target="_blank" href="../Documentos/Conductores/<?php echo $lci['numero_documento_conductor']; ?>/<?php echo $datosSS[0]['diciembre']; ?>"><?php echo $datosSS[0]['diciembre'] ?></a></label>
											<?php }  ?>
										</div>
									</div>
							
								<!--ANTECEDENTES-->
								<div id="tabs-4">
									
									<div class="row mt-3">
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>Policia</label>
												</div>
												<div class="input">
													<input type="file" name="policia"  id="policia" class="form-control">
													<input type="hidden" name="act_policia" value="<?php echo $lci['policia'];?>"/>
												</div>
											</div>
										</section>
										
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>Fecha Vencimiento</label>
												</div>
												<div class="input">
													<input type="text" name="fecha_policia" id="datepicker5" class="form-control" value="<?php echo $lci['fecha_policia'];?>">
													<input type="hidden" name="act_fecha_policia" value="<?php echo $lci['fecha_policia'];?>"/>
												</div>      		
											</div>
										</section>
									</div>
									<div class="row justify-content-around">
										<?php if ($lci['policia'] == '') { ?>
											<label class="mt-2" for="act_policia"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
											<label class="mt-2" for="act_policia"><strong>Documento Actual: </strong> <?php echo $lci['policia'] ?></label>
										<?php }  ?>
									</div>
									
									<div class="row mt-3">
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>Procuraduria</label>
												</div>
												<div class="input">
													<input type="file" name="procuraduria"  id="procuraduria" class="form-control">
													<input type="hidden" name="act_procuraduria" value="<?php echo $lci['procuraduria'];?>"/>
												</div>
											</div>
										</section>
										
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>Fecha Vencimiento</label>
												</div>
												<div class="input">
													<input type="text" name="fecha_procuraduria" id="datepicker6" class="form-control" value="<?php echo $lci['fecha_procuraduria'];?>">
													<input type="hidden" name="act_fecha_procuraduria" value="<?php echo $lci['fecha_procuraduria'];?>"/>
												</div>      		
											</div>
										</section>
									</div>
									<div class="row justify-content-around">
										<?php if ($lci['procuraduria'] == '') { ?>
											<label class="mt-2" for="act_procuraduria"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
											<label class="mt-2" for="act_procuraduria"><strong>Documento Actual: </strong> <?php echo $lci['procuraduria'] ?></label>
										<?php }  ?>
									</div>
									
									<div class="row mt-3">
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>Contraloria</label>
												</div>
												<div class="input">
													<input type="file" name="contraloria"  id="contraloria" class="form-control">
													<input type="hidden" name="act_contraloria" value="<?php echo $lci['contraloria'];?>"/>
												</div>
											</div>
										</section>
										
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>Fecha Vencimiento</label>
												</div>
												<div class="input">
													<input type="text" name="fecha_contraloria" id="datepicker7" class="form-control" value="<?php echo $lci['fecha_contraloria'];?>">
													<input type="hidden" name="act_fecha_contraloria" value="<?php echo $lci['fecha_contraloria'];?>"/>
												</div>      		
											</div>
										</section>
									</div>
									<div class="row justify-content-around">
										<?php if ($lci['contraloria'] == '') { ?>
											<label class="mt-2" for="act_contraloria"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
											<label class="mt-2" for="act_contraloria"><strong>Documento Actual: </strong> <?php echo $lci['contraloria'] ?></label>
										<?php }  ?>
									</div>
									
									<div class="row mt-3">
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>Personeria</label>
												</div>
												<div class="input">
													<input type="file" name="personeria"  id="personeria" class="form-control">
													<input type="hidden" name="act_personeria" value="<?php echo $lci['personeria'];?>"/>
												</div>
											</div>
										</section>
										
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>Fecha Vencimiento</label>
												</div>
												<div class="input">
													<input type="text" name="fecha_personeria" id="datepicker8" class="form-control" value="<?php echo $lci['fecha_personeria'];?>">
													<input type="hidden" name="act_fecha_personeria" value="<?php echo $lci['fecha_personeria'];?>"/>
												</div>      		
											</div>
										</section>
									</div>
									<div class="row justify-content-around">
										<?php if ($lci['personeria'] == '') { ?>
											<label class="mt-2" for="act_personeria"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
											<label class="mt-2" for="act_personeria"><strong>Documento Actual: </strong> <?php echo $lci['personeria'] ?></label>
										<?php }  ?>
									</div>
									
									<div class="row mt-3">
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>SIMIT</label>
												</div>
												<div class="input">
													<input type="file" name="simit"  id="simit" class="form-control">
													<input type="hidden" name="act_simit" value="<?php echo $lci['simit'];?>"/>
												</div>
											</div>
										</section>
										
										<section class="col">
											<div class="row mt-3">
												<div class="label">
													<label>Fecha Vencimiento</label>
												</div>
												<div class="input">
													<input type="text" name="fecha_simit" id="datepicker9" class="form-control" value="<?php echo $lci['fecha_simit'];?>">
													<input type="hidden" name="act_fecha_simit" value="<?php echo $lci['fecha_simit'];?>"/>
												</div>      		
											</div>
										</section>
									</div>
									<div class="row justify-content-around">
										<?php if ($lci['simit'] == '') { ?>
											<label class="mt-2" for="act_simit"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
											<label class="mt-2" for="act_simit"><strong>Documento Actual: </strong> <?php echo $lci['simit'] ?></label>
										<?php }  ?>
									</div>
									
								</div>
								
		                        <!--REFERENCIAS-->
		                        	<div id="tabs-5">

		                        		<!-- REFERENCIAS COMERCIALES -->

		                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
		                                        <p>Referencias Comerciales</p>
		                                    </div>
		                                    <?php foreach ($listarPorTipoReferenciaComercial as $lrc){ ?>
		                                    	<input type="hidden" name="id_referencia_rc" value="<?php echo $lrc['id_referencia'] ?>">
		                                    	<input type="hidden" name="estado_rc" value="<?php echo $lrc['estado'] ?>">
		                                    	<?php if ($comercial >= 1){ ?>
		                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
				                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Nombre</label>
				                                            <input type="text" name="nombre_rc" id="nombre_rc" value="<?php echo $lrc['nombre_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="nombre_rc_act" value="<?php echo $lrc['nombre_referencia'] ?>">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rc" id="telefono_rc" value="<?php echo $lrc['telefono_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="telefono_rc_act" value="<?php echo $lrc['nombre_referencia'] ?>">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rc" id="direccion_rc" value="<?php echo $lrc['direccion_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="direccion_rc_act" value="<?php echo $lrc['nombre_referencia'] ?>">
				                                        </div>
			                                    	</div>
			                                    <?php } ?>
			                                <?php } ?>

			                                <?php if ($comercial == 0){ ?>
			                                	
		                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
				                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Nombre</label>
				                                            <input type="text" name="nombre_rc" id="nombre_rc" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rc" id="telefono_rc" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rc" id="direccion_rc" class="form-control">
				                                        </div>
			                                    	</div>
			                                <?php } ?>

			                            <!-- REFERENCIAS LABORALES -->
		                                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
				                                <p>Referencias Laborales</p>
				                            </div>
											<?php foreach ($listarPorTipoReferenciaLaboral as $lrl){ ?>
												<input type="hidden" name="id_referencia_rl" value="<?php echo $lrl['id_referencia'] ?>">
		                                    	<input type="hidden" name="estado_rl" value="<?php echo $lrl['estado'] ?>">
				                                <?php if ($laboral >= 1){ ?>
				                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Nombre</label>
				                                            <input type="text" name="nombre_rl" id="nombre_rl" value="<?php echo $lrl['nombre_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="nombre_rl_act" id="nombre_rl_act" value="<?php echo $lrl['nombre_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rl" id="telefono_rl" value="<?php echo $lrl['telefono_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="telefono_rl_act" id="telefono_rl_act" value="<?php echo $lrl['telefono_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rl" id="direccion_rl" value="<?php echo $lrl['direccion_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="direccion_rl_act" id="direccion_rl_act" value="<?php echo $lrl['direccion_referencia'] ?>" class="form-control">
				                                        </div>
				                                    </div>
												<?php } ?>
					                        <?php } ?>

					                        <?php if ($laboral == 0){ ?>
			                                	
		                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
				                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Nombre</label>
				                                            <input type="text" name="nombre_rl" id="nombre_rl" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rl" id="telefono_rl" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rl" id="direccion_rl" class="form-control">
				                                        </div>
			                                    	</div>
			                                <?php } ?>

			                            <!-- REFERENCIAS FAMILIARES -->
		                                  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
				                                <p>Referencias Familiares</p>
				                            </div>
											<?php foreach ($listarPorTipoReferenciaFamiliar as $lrf){ ?>
												<input type="hidden" name="id_referencia_rf" value="<?php echo $lrf['id_referencia'] ?>">
		                                    	<input type="hidden" name="estado_rf" value="<?php echo $lrf['estado'] ?>">
												<?php if ($familiar >= 1){ ?>
				                                    
				                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Nombre</label>
				                                            <input type="text" name="nombre_rf" id="nombre_rf" value="<?php echo $lrf['nombre_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="nombre_rf_act" id="nombre_rf_act" value="<?php echo $lrf['nombre_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rf" id="telefono_rf" value="<?php echo $lrf['telefono_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="telefono_rf_act" id="telefono_rf_act" value="<?php echo $lrf['telefono_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rf" id="direccion_rf" value="<?php echo $lrf['direccion_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="direccion_rf_act" id="direccion_rf_act" value="<?php echo $lrf['direccion_referencia'] ?>" class="form-control">
				                                        </div>
				                                    </div>
				                            	<?php } ?>
				                            <?php } ?>

				                            <?php if ($familiar == 0){ ?>
			                                	
		                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
				                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Nombre</label>
				                                            <input type="text" name="nombre_rf" id="nombre_rf" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rf" id="telefono_rf" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rf" id="direccion_rf" class="form-control">
				                                        </div>
			                                    	</div>
			                                <?php } ?>

			                            <!-- REFERENCIAS PERSONALES -->
			                            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
				                                <p>Referencias Personales</p>
				                            </div>
		                                	<?php foreach ($listarPorTipoReferenciaPersonal as $lrp){ ?>
		                                		<input type="hidden" name="id_referencia_rp" value="<?php echo $lrp['id_referencia'] ?>">
		                                    	<input type="hidden" name="estado_rp" value="<?php echo $lrp['estado'] ?>">
				                                <?php if ($personal >= 1){ ?>
				                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Nombre</label>
				                                            <input type="text" name="nombre_rp" id="nombre_rp" value="<?php echo $lrp['nombre_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="nombre_rp_act" id="nombre_rp_act" value="<?php echo $lrp['nombre_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rp" id="telefono_rp" value="<?php echo $lrp['telefono_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="telefono_rp_act" id="telefono_rp_act" value="<?php echo $lrp['telefono_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rp" id="direccion_rp" value="<?php echo $lrp['direccion_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="direccion_rp_act" id="direccion_rp_act" value="<?php echo $lrp['direccion_referencia'] ?>" class="form-control">
				                                        </div>
				                                    </div>
				                                <?php } ?>
				                            <?php } ?> 

				                            <?php if ($personal == 0){ ?>
			                                	
		                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
				                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Nombre</label>
				                                            <input type="text" name="nombre_rp" id="nombre_rp" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rp" id="telefono_rp" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rp" id="direccion_rp" class="form-control">
				                                        </div>
			                                    	</div>
			                                <?php } ?>  
		    
		                        	</div>

		                    <?php } ?>
		                </div>

	                    <section class="col-12 mt-4 d-flex justify-content-center">
		        			<?php if ($_SESSION['id_perfil'] == 2){ ?>
	                        	<a href="inicioPropietarios.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
	                        <?php } else { ?>
		        				<a href="conductores.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
		        			<?php }?>	
                            
                            <?php if(($permisos[0]['edicion'] == 1)or($_SESSION['id_perfil'] == 2)){ ?>
	                        <button type="submit" id="buttonsKV" class="btn col-3">Actualizar</button>
	                        <?php } ?>
	                    </section>
                    
			        </form>

		        </div>

		    </section>

		</section>

	<!-- FIN CONTENIDO -->

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	 $( function() {

            $( "#datepicker" ).datepicker({ dateFormat:'yy/mm/dd'});
            $( "#datepicker1" ).datepicker({ dateFormat:'yy/mm/dd'});
            $( "#datepicker2" ).datepicker({ dateFormat:'yy/mm/dd'});
			$( "#datepicker3" ).datepicker({ dateFormat:'yy/mm/dd'});
			$( "#datepicker4" ).datepicker({ dateFormat:'yy/mm/dd'});
			$( "#datepicker5" ).datepicker({ dateFormat:'yy/mm/dd'});
            $( "#datepicker6" ).datepicker({ dateFormat:'yy/mm/dd'});
            $( "#datepicker7" ).datepicker({ dateFormat:'yy/mm/dd'});
			$( "#datepicker8" ).datepicker({ dateFormat:'yy/mm/dd'});
			$( "#datepicker9" ).datepicker({ dateFormat:'yy/mm/dd'});
        } );

    	$( function() {
          $( "#tabs" ).tabs();
        } ); 

        $( function()  {
           $('#id_vehiculo').chosen();
        } );

        function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }
    </script>
</body>
</html>