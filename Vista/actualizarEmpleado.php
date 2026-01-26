<?php
include ("../Controlador/Sesion/autenticar.php");
require("../Modelo/Empleado.php");

$id = $_GET['id_empleado'];

$empleado = new Empleado();
$listado = $empleado->listarPorId($id);

$year = date('Y');
$link = 'http://www.sistemakv.com/Documentos/Empleados/'.$listado[0]['num_documento'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Empleado</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
  	<link rel="stylesheet" href="../Resources/css/stylesHeader.css">

</head>
<body>

    <!--MENU-->
	    <?php include("Template/header.php"); ?>
	    <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->


  	<!--**************************--->
  
  	<section class="home_content">  
    
	    <div aria-label="breadcrumb" class="mt-1"> 
	        <ol class="breadcrumb" style="background: #fff;">
	            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
	            <li class="breadcrumb-item " aria-current="page"><a href="empleados.php">Empleados</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Actualizar Empleado</li>
	        </ol>
	    </div>	

      	<div class="notice notice-sistemakv">
          	<strong><i class="fa fa-user mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR EMPLEADO - <?php echo $id; ?></b></strong>
      	</div>


	    <section class="form-usuarios">
	        <div class="formulario mb-5">
		        <form action="../Controlador/actualizarEmpleado.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
					<input type="hidden" name="id" id="id" value="<?php echo $listado[0]['id_empleado'];?>"/>

	                <div id="tabs" class="mt-3">
	                    <ul>
	                      <li><a href="#tabs-1">Información </a></li>
	                      <li><a href="#tabs-2">Documentación </a></li>
						  <li><a href="#tabs-3">Afiliaciones </a></li>
						  <li><a href="#tabs-4">Otros Documentos </a></li>
						  <li><a href="#tabs-5">Antecedentes </a></li>
						  <li><a href="#tabs-6">Estudios </a></li>
						  <li><a href="#tabs-7">Experiencia </a></li>
						  <li><a href="#tabs-8">Cursos </a></li>
	                    </ul>

	                    <!-- INFORMACION BASICA-->
	                        <div id="tabs-1">

	                        	<!--NOMBRE-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Nombres</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="nombres"  id="nombres" class="form-control" required="true" value="<?php echo $listado[0]['nombres'];?>">
			        	                </div>      		
			                        </div>
									
								<!--APELLIDOS-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Apellidos</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="apellidos"  id="apellidos" class="form-control" required="true" value="<?php echo $listado[0]['apellidos'];?>">
			        	                </div>      		
			                        </div>

	                            <!-- NUMERO DE DOCUMENTO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Numero documento</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="num_documento"  id="num_documento" class="form-control" required="true" value="<?php echo $listado[0]['num_documento'];?>">
			        	                </div>      		
			                        </div>

			                    <!--CORREO ELECTRONICO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Correo electronico</label>
			        	                </div>
			        	                <div class="input">
			        		                <input type="text" name="correo_electronico" id="correo_electronico" class="form-control" value="<?php echo $listado[0]['correo'];?>">
			        	                </div>      		
			                        </div>

			                    <!-- FECHA DE NACIMIENTO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Fecha nacimiento</label>
			        	                </div>
			        	                <div class="input">
			        		                <input type="text" name="fecha_nacimiento" id="fecha_nac" class="form-control" value="<?php echo $listado[0]['fecha_nac'];?>">
			        	                </div>      		
			                        </div>
	                            
			                    <!--DIRECCION -->
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Dirección</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="direccion"  id="direccion" class="form-control" value="<?php echo $listado[0]['direccion'];?>">
			        			        </div>      		
			        		        </div>

	                            <!--TELEFONO 1 -->
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Telefono Fijo</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="telefono"  id="telefono" class="form-control" value="<?php echo $listado[0]['telefono'];?>">
			        			        </div>      		
			        		        </div>

			        	        <!--TELEFONO 2 -->
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Telefono Celular</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="celular"  id="celular" class="form-control" value="<?php echo $listado[0]['celular'];?>">
			        			        </div>      		
			        		        </div>

			        	        <!--EMPRESA --> 
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Empresa</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="empresa"  id="empresa" class="form-control" value="<?php echo $listado[0]['empresa'];?>">
			        			        </div>      		
			        		        </div>
									
								<!--CARGO --> 
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Cargo</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="cargo"  id="cargo" class="form-control" value="<?php echo $listado[0]['cargo'];?>">
			        			        </div>      		
			        		        </div>
									
								<!--EPS --> 
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>EPS</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="eps"  id="eps" class="form-control" value="<?php echo $listado[0]['eps'];?>">
			        			        </div>      		
			        		        </div>
									
			        		    <!--ARL --> 
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>ARL</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="arl"  id="arl" class="form-control" value="<?php echo $listado[0]['arl'];?>">
			        			        </div>      		
			        		        </div>
									
								<!--PENSION --> 
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Pension</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="pension"  id="pension" class="form-control" value="<?php echo $listado[0]['pension'];?>">
			        			        </div>      		
			        		        </div>
									
								<!--CESANTIAS --> 
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Cesantias</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="cesantias"  id="cesantias" class="form-control" value="<?php echo $listado[0]['cesantias'];?>">
			        			        </div>      		
			        		        </div>
									
								<!--CAJA COMPENSACION --> 
			        		        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Caja Compensacion</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="caja_compensacion"  id="caja_compensacion" class="form-control" value="<?php echo $listado[0]['caja_compensacion'];?>">
			        			        </div>      		
			        		        </div>
			        		   
	                        </div>
	                    <!-- FIN INFORMACION BASICA-->

	                    <!-- ****************** -->

	                    <!-- DOCUMENTACIÓN-->
	                        <div id="tabs-2">
								
								<!--FECHA CONTRATO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Tipo Contrato</label>
			        	                </div>
			        	                <div class="input">
			        	                    <select name="tipo_contrato" id="tipo_contrato" class="form-control" required="required" onchange="tipocontrato(this.value)">
												<option value="">Seleccione Opcion</option>
												<option value="Indefinido" <?php if($listado[0]['tipo_contrato'] == 'Indefinido'){ ?> selected="selected" <?php } ?> >Indefinido</option>
												<option value="Obra Labor" <?php if($listado[0]['tipo_contrato'] == 'Obra Labor'){ ?> selected="selected" <?php } ?> >Obra Labor</option>
												<option value="Fijo" <?php if($listado[0]['tipo_contrato'] == 'Fijo'){ ?> selected="selected" <?php } ?> >Fijo</option>
												<option value="Por Servicios" <?php if($listado[0]['tipo_contrato'] == 'Por Servicios'){ ?> selected="selected" <?php } ?> >Por Servicios</option>
												<option value="Periodo Prueba" <?php if($listado[0]['tipo_contrato'] == 'Periodo Prueba'){ ?> selected="selected" <?php } ?> >Periodo Prueba</option>
											</select>
			        	                </div>      		
			                        </div>
								
	                    	    <!--FECHA CONTRATO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Fecha Inicio Contrato</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="fecha_contrato"  id="fecha_contrato" class="form-control" value="<?php echo $listado[0]['fecha_contrato'];?>">
			        	                </div>      		
			                        </div>
									
								<!--FECHA CONTRATO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Fecha Final Contrato</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="fecha_final_contrato"  id="fecha_final_contrato" class="form-control" disabled="disabled"  value="<?php echo $listado[0]['fecha_fin_contrato'];?>">
			        	                </div>      		
			                        </div>

			                    <!--FOTOCOPIA DEL DOCUMENTO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Contrato Firmado</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="file" name="contrato"  id="contrato" class="form-control">
			        	                </div>      		
			                        </div>
									
									<input type="hidden" name="act_contrato" value="<?php echo $listado[0]['contrato'];?>"/>
									<?php if ($listado[0]['contrato'] == '') { ?>
											<label class="mt-2 ml-5" for="act_contrato"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_contrato"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['contrato'];?>" target="_blank"><?php echo $listado[0]['contrato']; ?></a></label>
									<?php }  ?>

			                    <!--LICENCIA DE CONDUCCIÓN-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Fotocopia documento</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="file" name="fotocopia_documento"  id="fotocopia_documento" class="form-control">
			        	                </div>      		
			                        </div>
									<input type="hidden" name="act_fotocopia_documento" value="<?php echo $listado[0]['fotocopia_doc'];?>"/>
									<?php if ($listado[0]['fotocopia_doc'] == '') { ?>
											<label class="mt-2 ml-5" for="act_fotocopia_documento"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_fotocopia_documento"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['fotocopia_doc'];?>" target="_blank"><?php echo $listado[0]['fotocopia_doc']; ?></a></label>
									<?php }  ?>
									
								<!--HOJA DE VIDA-->
			                        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Hoja de Vida</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="file" name="hoja_vida"  id="hoja_vida" class="form-control">
			        			        </div>
			                        </div>
									<input type="hidden" name="act_hoja_vida" value="<?php echo $listado[0]['hoja_vida'];?>"/>
									<?php if ($listado[0]['hoja_vida'] == '') { ?>
											<label class="mt-2 ml-5" for="act_hoja_vida"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_hoja_vida"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['hoja_vida'];?>" target="_blank"><?php echo $listado[0]['hoja_vida']; ?></a></label>
									<?php }  ?>
								
								<!--HOJA DE VIDA-->
			                        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Examen Medico</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="file" name="examen_medico"  id="examen_medico" class="form-control">
			        			        </div>
			                        </div>
									<input type="hidden" name="act_examen_medico" value="<?php echo $listado[0]['examen_medico'];?>"/>
									<?php if ($listado[0]['examen_medico'] == '') { ?>
											<label class="mt-2 ml-5" for="act_examen_medico"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_examen_medico"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['examen_medico'];?>" target="_blank"><?php echo $listado[0]['examen_medico']; ?></a></label>
									<?php }  ?>
								
									<!--FECHA CONTRATO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Fecha Examen</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="fecha_examen"  id="fecha_examen" class="form-control" value="<?php echo $listado[0]['fecha_examen'];?>">
			        	                </div>      		
			                        </div>
								
								<!--HOJA DE VIDA-->
			                        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Actualizacion Datos</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="file" name="actualizacion_datos"  id="actualizacion_datos" class="form-control">
			        			        </div>
			                        </div>
									<input type="hidden" name="act_actualizacion_datos" value="<?php echo $listado[0]['actualizacion_datos'];?>"/>
									<?php if ($listado[0]['actualizacion_datos'] == '') { ?>
											<label class="mt-2 ml-5" for="act_actualizacion_datos"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_actualizacion_datos"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['actualizacion_datos'];?>" target="_blank"><?php echo $listado[0]['actualizacion_datos']; ?></a></label>
									<?php }  ?>
									
									<!--FECHA CONTRATO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Fecha Actualizacion</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="fecha_actualizacion"  id="fecha_actualizacion" class="form-control" value="<?php echo $listado[0]['fecha_actualizacion'];?>">
			        	                </div>      		
			                        </div>
									
								<!--HOJA DE VIDA-->
			                        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Formato Inducción</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="file" name="induccion"  id="induccion" class="form-control">
			        			        </div>
			                        </div>
									<input type="hidden" name="act_induccion" value="<?php echo $listado[0]['induccion'];?>"/>
									<?php if ($listado[0]['induccion'] == '') { ?>
											<label class="mt-2 ml-5" for="act_induccion"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_induccion"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['induccion'];?>" target="_blank"><?php echo $listado[0]['induccion']; ?></a></label>
									<?php }  ?>
									
									<!--FECHA CONTRATO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Fecha Expedición Inducción</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="fecha_induccion"  id="fecha_induccion" class="form-control" value="<?php echo $listado[0]['fecha_exp_induccion'];?>">
			        	                </div>      		
			                        </div>
									
								<!--HOJA DE VIDA-->
			                        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Evaluación Desempeño</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="file" name="evaluacion"  id="evaluacion" class="form-control">
			        			        </div>
			                        </div>
									<input type="hidden" name="act_evaluacion" value="<?php echo $listado[0]['evaluacion'];?>"/>
									<?php if ($listado[0]['evaluacion'] == '') { ?>
											<label class="mt-2 ml-5" for="act_evaluacion"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_evaluacion"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['evaluacion'];?>" target="_blank"><?php echo $listado[0]['evaluacion']; ?></a></label>
									<?php }  ?>
									
									<!--FECHA CONTRATO-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Fecha Expedición Evaluación</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="fecha_evaluacion"  id="fecha_evaluacion" class="form-control" value="<?php echo $listado[0]['fecha_exp_evaluacion'];?>">
			        	                </div>      		
			                        </div>
									
								<!--HOJA DE VIDA-->
			                        <div class="row mt-3">
			        			        <div class="label">
			        				        <label>Manual Funciones</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="file" name="manual_funciones"  id="manual_funciones" class="form-control">
			        			        </div>
			                        </div>
									<input type="hidden" name="act_manual_funciones" value="<?php echo $listado[0]['manual_funciones'];?>"/>
									<?php if ($listado[0]['manual_funciones'] == '') { ?>
											<label class="mt-2 ml-5" for="act_manual_funciones"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_manual_funciones"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['manual_funciones'];?>" target="_blank"><?php echo $listado[0]['manual_funciones']; ?></a></label>
									<?php }  ?>
								
	                        </div>
	                    <!-- FIN DOCUMENTACIÓN-->

						<!-- AFILIACIONES-->
	                        <div id="tabs-3">

	                    	    <!--AFILIACION EPS-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Afiliacion EPS</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="file" name="afiliacion_eps"  id="afiliacion_eps" class="form-control">
			        	                </div>      		
			                        </div>
									<input type="hidden" name="act_afiliacion_eps" value="<?php echo $listado[0]['afiliacion_eps'];?>"/>
									<?php if ($listado[0]['afiliacion_eps'] == '') { ?>
											<label class="mt-2 ml-5" for="act_afiliacion_eps"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_afiliacion_eps"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['afiliacion_eps'];?>" target="_blank"><?php echo $listado[0]['afiliacion_eps']; ?></a></label>
									<?php }  ?>
									
								<!--AFILIACION ARL-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Afiliacion ARL</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="file" name="afiliacion_arl"  id="afiliacion_arl" class="form-control">
			        	                </div>      		
			                        </div>
									<input type="hidden" name="act_afiliacion_arl" value="<?php echo $listado[0]['afiliacion_arl'];?>"/>
									<?php if ($listado[0]['afiliacion_arl'] == '') { ?>
											<label class="mt-2 ml-5" for="act_afiliacion_arl"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_afiliacion_arl"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['afiliacion_arl'];?>" target="_blank"><?php echo $listado[0]['afiliacion_arl']; ?></a></label>
									<?php }  ?>
									
								<!--AFILIACION CAJA-->
			                        <div class="row mt-3">
			        	                <div class="label">
			        		                <label>Afiliacion Caja Compensacion</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="file" name="afiliacion_caja"  id="afiliacion_caja" class="form-control">
			        	                </div>      		
			                        </div>
									<input type="hidden" name="act_afiliacion_caja" value="<?php echo $listado[0]['afiliacion_caja'];?>"/>
									<?php if ($listado[0]['afiliacion_caja'] == '') { ?>
											<label class="mt-2 ml-5" for="act_afiliacion_caja"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_afiliacion_caja"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['afiliacion_caja'];?>" target="_blank"><?php echo $listado[0]['afiliacion_caja']; ?></a></label>
									<?php }  ?>
							</div>
						<!-- FIN AFILIACIONES-->
							
						<!-- OTROS DOCUMENTOS-->
							<?php $otros = $empleado->listarDocumentosEmpleado($listado[0]['id_empleado']);?>
							<div id="tabs-4">
							<?php if(count($otros) < 1){ $cantidad1 = 1; } else { $cantidad1 = count($otros); } ?>
							<input type="hidden" name="cant_otros" id="cant_otros" value="<?php echo $cantidad1;?>"/>
							<div class="row mt-3">
							<section class="col">
							<div class="col-md-6 col-sm-4 col-xs-4">
								<button id="btnAdd4" name="btnAdd4" type="button" class="btn btn-info">+</button>
								<button id="btnDel4" name="btnDel4" type="button" class="btn btn-danger">-</button>
							</div>
							</section>
							</div>
							
							<div class="row mt-3">
							<section class="col">
								
								<?php if(count($otros) < 1){ ?>
								<div id="documentos1" class="clonedInput4">

								<div style="width:100%; background-color:#CCC; height:5px;" class="mt-3"></div>	

								<div class="row mt-3">
									<div class="label">
										<label>Nombre Archivo</label>
									</div>
									<div class="input">
										<input type="text" name="nombre_archivo[]"  id="nombre_archivo1" class="form-control input_docs1">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Archivo</label>
									</div>
									<div class="input">
										<input type="file" name="archivos[]"  id="archivos1" class="form-control input_docs2">
									</div>      		
								</div>
								
								<?php } else { ?>
								
								<?php $i = 1; foreach($otros as $ot){ ?>
								<div id="documentos<?php echo $i;?>" class="clonedInput4">

								<div style="width:100%; background-color:#CCC; height:5px;" class="mt-3"></div>	

								<div class="row mt-3">
									<div class="label">
										<label>Nombre Archivo</label>
									</div>
									<div class="input">
										<input type="text" name="nombre_archivo[]"  id="nombre_archivo<?php echo $i;?>" class="form-control input_docs1" value="<?php echo $ot['nombre_doc'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Archivo</label>
									</div>
									<div class="input">
										<input type="file" name="archivos[]"  id="archivos<?php echo $i;?>" class="form-control input_docs2">
										<input type="hidden" name="act_archivos[]" value="<?php echo $ot['archivo'];?>"/>
									</div>      		
								</div>
								<div class="row">
									<?php if ($ot['archivo'] == '') { ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$ot['archivo'];?>" target="_blank"><?php echo $ot['archivo']; ?></a></label>
									<?php }  ?>
								</div>
								<?php $i++; } ?>
								
								<?php } ?>
							
							</section>
							</div>
								
							</div>
						<!-- FIN OTROS DOCUMENTOS-->

	                    <!--ANTECEDENTES-->
							<div id="tabs-5">
								
								<div class="row mt-3">
									<section class="col">
										<div class="row mt-3">
											<div class="label">
												<label>Policia</label>
											</div>
											<div class="input">
												<input type="file" name="policia"  id="policia" class="form-control">
											</div>
										</div>
									</section>
								</div>
								<div class="row">
									<input type="hidden" name="act_policia" value="<?php echo $listado[0]['policia'];?>"/>
									<?php if ($listado[0]['policia'] == '') { ?>
											<label class="mt-2 ml-5" for="act_policia"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_policia"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['policia'];?>" target="_blank"><?php echo $listado[0]['policia']; ?></a></label>
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
											</div>
										</div>
									</section>
								</div>
								<div class="row">
									<input type="hidden" name="act_procuraduria" value="<?php echo $listado[0]['procuraduria'];?>"/>
									<?php if ($listado[0]['procuraduria'] == '') { ?>
											<label class="mt-2 ml-5" for="act_procuraduria"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_procuraduria"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['procuraduria'];?>" target="_blank"><?php echo $listado[0]['procuraduria']; ?></a></label>
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
											</div>
										</div>
									</section>
								</div>
								<div class="row">
									<input type="hidden" name="act_contraloria" value="<?php echo $listado[0]['contraloria'];?>"/>
									<?php if ($listado[0]['contraloria'] == '') { ?>
											<label class="mt-2 ml-5" for="act_contraloria"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_contraloria"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['contraloria'];?>" target="_blank"><?php echo $listado[0]['contraloria']; ?></a></label>
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
											</div>
										</div>
									</section>
								</div>
								<div class="row">
									<input type="hidden" name="act_personeria" value="<?php echo $listado[0]['personeria'];?>"/>
									<?php if ($listado[0]['personeria'] == '') { ?>
											<label class="mt-2 ml-5" for="act_personeria"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_personeria"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['personeria'];?>" target="_blank"><?php echo $listado[0]['personeria']; ?></a></label>
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
											</div>
										</div>
									</section>
								</div>
								<div class="row">
									<input type="hidden" name="act_simit" value="<?php echo $listado[0]['simit'];?>"/>
									<?php if ($listado[0]['simit'] == '') { ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$listado[0]['simit'];?>" target="_blank"><?php echo $listado[0]['simit']; ?></a></label>
									<?php }  ?>
								</div>
								
							</div>
						<!-- FIN ANTECEDENTES-->
						
	                    <!-- ESTUDIOS-->
	                    	<div id="tabs-6">
							<?php $estudios = $empleado->listarEstudiosEmpleado($listado[0]['id_empleado']);?>
							<?php if(count($estudios) < 1){ $cantidad2 = 1; } else { $cantidad2 = count($estudios); } ?>
							<input type="hidden" name="cant_estudios" id="cant_estudios" value="<?php echo $cantidad2;?>"/>
							<div class="row mt-3">
							<section class="col">
							<div class="col-md-6 col-sm-4 col-xs-4">
								<button id="btnAdd1" name="btnAdd1" type="button" class="btn btn-info">+</button>
								<button id="btnDel1" name="btnDel1" type="button" class="btn btn-danger">-</button>
							</div>
							</section>
							</div>
							
							<div class="row mt-3">
							<section class="col">
								<?php if(count($estudios) < 1){ ?>
								<div id="estudio1" class="clonedInput1">

								<div style="width:100%; background-color:#CCC; height:5px;" class="mt-3"></div>	

								<div class="row mt-3">
									<div class="label">
										<label>Titulo Obtenido</label>
									</div>
									<div class="input">
										<input type="text" name="titulo[]"  id="titulo1" class="form-control input_est1">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Universidad o Institucion</label>
									</div>
									<div class="input">
										<input type="text" name="universidad[]"  id="universidad1" class="form-control input_est2">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Nivel Academico</label>
									</div>
									<div class="input">
										<input type="text" name="nivel[]"  id="nivel1" class="form-control input_est3">
									</div>
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Fecha Grado</label>
									</div>
									<div class="input">
										<input type="date" name="fecha_grado[]"  id="fecha_grado1" class="form-control input_est4">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Diploma</label>
									</div>
									<div class="input">
										<input type="file" name="diploma[]"  id="diploma1" class="form-control input_est5">
									</div>      		
								</div>
								<?php } else { ?>
								<?php $a = 1; foreach($estudios as $es){ ?>
								<div id="estudio<?php echo $a;?>" class="clonedInput1">

								<div style="width:100%; background-color:#CCC; height:5px;" class="mt-3"></div>	

								<div class="row mt-3">
									<div class="label">
										<label>Titulo Obtenido</label>
									</div>
									<div class="input">
										<input type="text" name="titulo[]"  id="titulo<?php echo $a;?>" class="form-control input_est1" value="<?php echo $es['titulo'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Universidad o Institucion</label>
									</div>
									<div class="input">
										<input type="text" name="universidad[]"  id="universidad<?php echo $a;?>" class="form-control input_est2" value="<?php echo $es['universidad'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Nivel Academico</label>
									</div>
									<div class="input">
										<input type="text" name="nivel[]"  id="nivel<?php echo $a;?>" class="form-control input_est3" value="<?php echo $es['nivel'];?>">
									</div>
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Fecha Grado</label>
									</div>
									<div class="input">
										<input type="date" name="fecha_grado[]"  id="fecha_grado<?php echo $a;?>" class="form-control input_est4" value="<?php echo $es['fecha_grado'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Diploma</label>
									</div>
									<div class="input">
										<input type="file" name="diploma[]"  id="diploma<?php echo $a;?>" class="form-control input_est5">
									</div>
									<input type="hidden" name="act_diploma[]" value="<?php echo $es['diploma'];?>"/>
								</div>
								<div class="row">
									<?php if ($es['diploma'] == '') { ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$es['diploma'];?>" target="_blank"><?php echo $es['diploma']; ?></a></label>
									<?php }  ?>
								</div>
								<?php $a++; } ?>
								<?php } ?>
							</section>
							</div>
							
							
	                    	</div>
	                    <!-- FIN ESTUDIOS-->
						
						<!-- EXPERIENCIA-->
	                    	<div id="tabs-7">
							<?php $experiencias = $empleado->listarExperienciaEmpleado($listado[0]['id_empleado']);?>
							<?php if(count($experiencias) < 1){ $cantidad3 = 1; } else { $cantidad3 = count($experiencias); } ?>
							<input type="hidden" name="cant_experiencias" id="cant_experiencias" value="<?php echo $cantidad3;?>"/>
							<div class="row mt-3">
							<section class="col">
							<div class="col-md-6 col-sm-4 col-xs-4">
								<button id="btnAdd2" name="btnAdd2" type="button" class="btn btn-info">+</button>
								<button id="btnDel2" name="btnDel2" type="button" class="btn btn-danger">-</button>
							</div>
							</section>
							</div>
							
							<div class="row mt-3">
							<section class="col">
								<?php if(count($experiencias) < 1){ ?>
								<div id="experiencia1" class="clonedInput2">

								<div style="width:100%; background-color:#CCC; height:5px;" class="mt-3"></div>	

								<div class="row mt-3">
									<div class="label">
										<label>Empresa</label>
									</div>
									<div class="input">
										<input type="text" name="empresa_exp[]"  id="empresa_exp1" class="form-control input_exp1">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Fecha Inicio</label>
									</div>
									<div class="input">
										<input type="date" name="fecha_inicio[]"  id="fecha_inicio1" class="form-control input_exp2">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Fecha Fin</label>
									</div>
									<div class="input">
										<input type="date" name="fecha_fin[]"  id="fecha_fin1" class="form-control input_exp3">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Cargo</label>
									</div>
									<div class="input">
										<input type="text" name="cargo_exp[]"  id="cargo_exp1" class="form-control input_exp4">
									</div>
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Telefono</label>
									</div>
									<div class="input">
										<input type="text" name="telefono_exp[]"  id="telefono_exp1" class="form-control input_exp5">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Jefe Inmediato</label>
									</div>
									<div class="input">
										<input type="text" name="jefe_exp[]"  id="jefe_exp1" class="form-control input_exp6">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Certificado Laboral</label>
									</div>
									<div class="input">
										<input type="file" name="certificado_exp[]"  id="certificado_exp1" class="form-control input_exp7">
									</div>      		
								</div>
								<?php } else { ?>
								<?php $b = 1; foreach($experiencias as $ex){ ?>
								<div id="experiencia<?php echo $b;?>" class="clonedInput2">

								<div style="width:100%; background-color:#CCC; height:5px;" class="mt-3"></div>	

								<div class="row mt-3">
									<div class="label">
										<label>Empresa</label>
									</div>
									<div class="input">
										<input type="text" name="empresa_exp[]"  id="empresa_exp<?php echo $b;?>" class="form-control input_exp1" value="<?php echo $ex['nombre_empresa'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Fecha Inicio</label>
									</div>
									<div class="input">
										<input type="date" name="fecha_inicio[]"  id="fecha_inicio<?php echo $b;?>" class="form-control input_exp2" value="<?php echo $ex['fecha_inicio'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Fecha Fin</label>
									</div>
									<div class="input">
										<input type="date" name="fecha_fin[]"  id="fecha_fin<?php echo $b;?>" class="form-control input_exp3" value="<?php echo $ex['fecha_fin'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Cargo</label>
									</div>
									<div class="input">
										<input type="text" name="cargo_exp[]"  id="cargo_exp<?php echo $b;?>" class="form-control input_exp4" value="<?php echo $ex['cargo'];?>">
									</div>
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Telefono</label>
									</div>
									<div class="input">
										<input type="text" name="telefono_exp[]"  id="telefono_exp<?php echo $b;?>" class="form-control input_exp5" value="<?php echo $ex['telefono'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Jefe Inmediato</label>
									</div>
									<div class="input">
										<input type="text" name="jefe_exp[]"  id="jefe_exp<?php echo $b;?>" class="form-control input_exp6" value="<?php echo $ex['jefe_inmediato'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Certificado Laboral</label>
									</div>
									<div class="input">
										<input type="file" name="certificado_exp[]"  id="certificado_exp<?php echo $b;?>" class="form-control input_exp7">
										<input type="hidden" name="act_certificado_exp[]" value="<?php echo $ex['certificado'];?>"/>
									</div>      		
								</div>
								<div class="row">
									<?php if ($ex['certificado'] == '') { ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$ex['certificado'];?>" target="_blank"><?php echo $ex['certificado']; ?></a></label>
									<?php }  ?>
								</div>
								<?php $b++; } ?>
								<?php } ?>
							</section>
							</div>
							
							
	                    	</div>
	                    <!-- FIN EXPERIENCIA-->
	                   
					   <!-- CURSOS-->
	                    	<div id="tabs-8">
							<?php $cursos = $empleado->listarCursosEmpleado($listado[0]['id_empleado']);?>
							<?php if(count($cursos) < 1){ $cantidad4 = 1; } else { $cantidad4 = count($cursos); } ?>
							<input type="hidden" name="cant_cursos" id="cant_cursos" value="<?php echo $cantidad4;?>"/>
							<div class="row mt-3">
							<section class="col">
							<div class="col-md-6 col-sm-4 col-xs-4">
								<button id="btnAdd3" name="btnAdd3" type="button" class="btn btn-info">+</button>
								<button id="btnDel3" name="btnDel3" type="button" class="btn btn-danger">-</button>
							</div>
							</section>
							</div>
							
							<div class="row mt-3">
							<section class="col">
								<?php if(count($cursos) < 1){ ?>
								<div id="cursos1" class="clonedInput3">

								<div style="width:100%; background-color:#CCC; height:5px;" class="mt-3"></div>	

								<div class="row mt-3">
									<div class="label">
										<label>Nombre Curso</label>
									</div>
									<div class="input">
										<input type="text" name="nombre_curso[]"  id="nombre_curso1" class="form-control input_cur1">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Intensidad Horas</label>
									</div>
									<div class="input">
										<input type="text" name="intensidad[]"  id="intensidad1" class="form-control input_cur2">
									</div>
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Institucion</label>
									</div>
									<div class="input">
										<input type="text" name="institucion[]"  id="institucion1" class="form-control input_cur3">
									</div>
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Fecha Curso</label>
									</div>
									<div class="input">
										<input type="date" name="fecha_curso[]"  id="fecha_curso1" class="form-control input_cur4">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Certificado</label>
									</div>
									<div class="input">
										<input type="file" name="certificado_cur[]"  id="certificado_cur1" class="form-control input_cur5">
									</div>      		
								</div>
								<?php } else { ?>
								<?php $c = 1; foreach($cursos as $cu){ ?>
								<div id="cursos<?php echo $c;?>" class="clonedInput3">

								<div style="width:100%; background-color:#CCC; height:5px;" class="mt-3"></div>	

								<div class="row mt-3">
									<div class="label">
										<label>Nombre Curso</label>
									</div>
									<div class="input">
										<input type="text" name="nombre_curso[]"  id="nombre_curso<?php echo $c;?>" class="form-control input_cur1" value="<?php echo $cu['nombre_curso'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Intensidad Horas</label>
									</div>
									<div class="input">
										<input type="text" name="intensidad[]"  id="intensidad<?php echo $c;?>" class="form-control input_cur2" value="<?php echo $cu['intensidad_horas'];?>">
									</div>
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Institucion</label>
									</div>
									<div class="input">
										<input type="text" name="institucion[]"  id="institucion<?php echo $c;?>" class="form-control input_cur3" value="<?php echo $cu['institucion'];?>">
									</div>
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Fecha Curso</label>
									</div>
									<div class="input">
										<input type="date" name="fecha_curso[]"  id="fecha_curso<?php echo $c;?>" class="form-control input_cur4" value="<?php echo $cu['fecha_curso'];?>">
									</div>      		
								</div>
								
								<div class="row mt-3">
									<div class="label">
										<label>Certificado</label>
									</div>
									<div class="input">
										<input type="file" name="certificado_cur[]"  id="certificado_cur<?php echo $c;?>" class="form-control input_cur5">
										<input type="hidden" name="act_certificado_cur[]" value="<?php echo $cu['certificado'];?>"/>
									</div>      		
								</div>
								<div class="row">
									<?php if ($cu['certificado'] == '') { ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> No hay documentos cargados</label>
									<?php } else{ ?>
											<label class="mt-2 ml-5" for="act_simit"><strong>Documento Actual: </strong> <a style="color: #478096;" href="<?php echo $link.'/'.$cu['certificado'];?>" target="_blank"><?php echo $cu['certificado']; ?></a></label>
									<?php }  ?>
								</div>
								<?php $c++; } ?>
								<?php } ?>
							</section>
							</div>
							
	                    	</div>
	                    <!-- FIN CURSOS-->
	                </div>

                    <section class="col-12 mt-4 d-flex justify-content-center">
                        <a href="empleados.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                        <button type="submit" class="btn btn-outline-info col-3">Actualizar</button>
                    </section>
                    
		        </form>
	        </div>
	    </section>
	</section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">
		function tipocontrato(val){
			if(val == 'Indefinido'){
				document.getElementById('fecha_final_contrato').disabled = true;
			} else {
				document.getElementById('fecha_final_contrato').disabled = false;
			} 
		}
    	$( function() {
            $( "#fecha_nac" ).datepicker({ dateFormat:'yy/mm/dd'});
			$( "#fecha_contrato" ).datepicker({ dateFormat:'yy/mm/dd'});
			$( "#fecha_final_contrato" ).datepicker({ dateFormat:'yy/mm/dd'});
			$( "#fecha_examen" ).datepicker({ dateFormat:'yy/mm/dd'});
			$( "#fecha_actualizacion" ).datepicker({ dateFormat:'yy/mm/dd'});
        } );

    	$( function() {
          $( "#tabs" ).tabs();
        } ); 

        $( function(){
      	  $("#id_vehiculo").chosen(); 
        });

        function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }

		tipocontrato(<?php $listado[0]['tipo_contrato'];?>);
    </script>
	<script>
    $(function() {
  $('#btnAdd1').click(function() {
	var cant1 = document.getElementById('cant_estudios').value;
	var new_cant1 = (new Number(cant1) + 1);
	document.getElementById('cant_estudios').value = new_cant1;
    var num = $('.clonedInput1').length,
    newNum = new Number(num + 1)
    newElem = $('#estudio' + num).clone().attr('id', 'estudio' + newNum).fadeIn('slow');

	newElem.find('.input_est1').attr('id', 'titulo' + newNum).val('');
	newElem.find('.input_est2').attr('id', 'universidad' + newNum).val('');
	newElem.find('.input_est3').attr('id', 'nivel' + newNum).val('');
	newElem.find('.input_est4').attr('id', 'fecha_grado' + newNum).val('');
	newElem.find('.input_est5').attr('id', 'diploma' + newNum).val('');

    $('#estudio' + num).after(newElem);
    $('#btnDel1').attr('disabled', false);

    if (newNum == 5)
      $('#btnAdd1').attr('disabled', true).prop('value', "No se pueden agregar mas");
  });

  $('#btnDel1').click(function() {
	  
    if (confirm("Esta seguro que desea remover esta seccion?")) {
	  var cant1_1 = document.getElementById('cant_estudios').value;
	  var new_cant1_1 = cant1_1 - 1;
	  document.getElementById('cant_estudios').value = new_cant1_1;
      var num = $('.clonedInput1').length;
      $('#estudio' + num).slideDown('slow', function() {
        $(this).remove();
        if (num - 1 === 1)
          $('#btnDel1').attr('disabled', true);
		  $('#btnAdd1').attr('disabled', false).prop('value', "+");
      });
    }
    return false;
  });
  $('#btnAdd1').attr('disabled', false);
  <?php if(count($estudios) > 1){ ?>
  $('#btnDel1').attr('disabled', false);
  <?php } else { ?>
  $('#btnDel1').attr('disabled', true);
  <?php } ?>
});

$(function() {
  $('#btnAdd2').click(function() {
	var cant2 = document.getElementById('cant_experiencias').value;
	var new_cant2 = (new Number(cant2) + 1);
	document.getElementById('cant_experiencias').value = new_cant2;
    var num = $('.clonedInput2').length,
    newNum = new Number(num + 1)
    newElem = $('#experiencia' + num).clone().attr('id', 'experiencia' + newNum).fadeIn('slow');

	newElem.find('.input_exp1').attr('id', 'empresa_exp' + newNum).val('');
	newElem.find('.input_exp2').attr('id', 'fecha_inicio' + newNum).val('');
	newElem.find('.input_exp3').attr('id', 'fecha_fin' + newNum).val('');
	newElem.find('.input_exp4').attr('id', 'cargo_exp' + newNum).val('');
	newElem.find('.input_exp5').attr('id', 'telefono_exp' + newNum).val('');
	newElem.find('.input_exp6').attr('id', 'jefe_exp' + newNum).val('');
	newElem.find('.input_exp7').attr('id', 'certificado_exp' + newNum).val('');

    $('#experiencia' + num).after(newElem);
    $('#btnDel2').attr('disabled', false);

    if (newNum == 3)
      $('#btnAdd2').attr('disabled', true).prop('value', "No se pueden agregar mas");
  });

  $('#btnDel2').click(function() {
	  
    if (confirm("Esta seguro que desea remover esta seccion?")) {
	  var cant2_1 = document.getElementById('cant_experiencias').value;
	  var new_cant2_1 = cant2_1 - 1;
	  document.getElementById('cant_experiencias').value = new_cant2_1;
      var num = $('.clonedInput2').length;
      $('#experiencia' + num).slideDown('slow', function() {
        $(this).remove();
        if (num - 1 === 1)
          $('#btnDel2').attr('disabled', true);
		  $('#btnAdd2').attr('disabled', false).prop('value', "+");
      });
    }
    return false;
  });
  $('#btnAdd2').attr('disabled', false);
  <?php if(count($experiencias) > 1){ ?>
  $('#btnDel2').attr('disabled', true);
  <?php } else { ?>
  $('#btnDel2').attr('disabled', false);
  <?php } ?>
});

$(function() {
  $('#btnAdd3').click(function() {
	var cant3 = document.getElementById('cant_cursos').value;
	var new_cant3 = (new Number(cant3) + 1);
	document.getElementById('cant_cursos').value = new_cant3;
    var num = $('.clonedInput3').length,
    newNum = new Number(num + 1)
    newElem = $('#cursos' + num).clone().attr('id', 'cursos' + newNum).fadeIn('slow');

	newElem.find('.input_cur1').attr('id', 'nombre_curso' + newNum).val('');
	newElem.find('.input_cur2').attr('id', 'intensidad' + newNum).val('');
	newElem.find('.input_cur3').attr('id', 'institucion' + newNum).val('');
	newElem.find('.input_cur4').attr('id', 'fecha_curso' + newNum).val('');
	newElem.find('.input_cur5').attr('id', 'certificado_cur' + newNum).val('');

    $('#cursos' + num).after(newElem);
    $('#btnDel3').attr('disabled', false);

    if (newNum == 3)
      $('#btnAdd3').attr('disabled', true).prop('value', "No se pueden agregar mas");
  });

  $('#btnDel3').click(function() {
	  
    if (confirm("Esta seguro que desea remover esta seccion?")) {
	  var cant3_1 = document.getElementById('cant_cursos').value;
	  var new_cant3_1 = cant3_1 - 1;
	  document.getElementById('cant_cursos').value = new_cant3_1;
      var num = $('.clonedInput3').length;
      $('#cursos' + num).slideDown('slow', function() {
        $(this).remove();
        if (num - 1 === 1)
          $('#btnDel3').attr('disabled', true);
		  $('#btnAdd3').attr('disabled', false).prop('value', "+");
      });
    }
    return false;
  });
  $('#btnAdd3').attr('disabled', false);
  <?php if(count($cursos) > 1){ ?>
  $('#btnDel3').attr('disabled', true);
  <?php } else { ?>
  $('#btnDel3').attr('disabled', false);
  <?php } ?>
});

$(function() {
  $('#btnAdd4').click(function() {
	var cant4 = document.getElementById('cant_otros').value;
	var new_cant4 = (new Number(cant4) + 1);
	document.getElementById('cant_otros').value = new_cant4;
    var num = $('.clonedInput4').length,
    newNum = new Number(num + 1)
    newElem = $('#documentos' + num).clone().attr('id', 'documentos' + newNum).fadeIn('slow');

	newElem.find('.input_docs1').attr('id', 'nombre_archivo' + newNum).val('');
	newElem.find('.input_docs2').attr('id', 'archivos' + newNum).val('');

    $('#documentos' + num).after(newElem);
    $('#btnDel4').attr('disabled', false);

    if (newNum == 8)
      $('#btnAdd4').attr('disabled', true).prop('value', "No se pueden agregar mas");
  });

  $('#btnDel4').click(function() {
	  
    if (confirm("Esta seguro que desea remover esta seccion?")) {
	  var cant4_1 = document.getElementById('cant_otros').value;
	  var new_cant4_1 = cant4_1 - 1;
	  document.getElementById('cant_otros').value = new_cant4_1;
      var num = $('.clonedInput4').length;
      $('#documentos' + num).slideDown('slow', function() {
        $(this).remove();
        if (num - 1 === 1)
          $('#btnDel4').attr('disabled', true);
		  $('#btnAdd4').attr('disabled', false).prop('value', "+");
      });
    }
    return false;
  });
  $('#btnAdd4').attr('disabled', false);
  <?php if(count($otros) > 1){ ?>
  $('#btnDel4').attr('disabled', false);
  <?php } else { ?>
  $('#btnDel4').attr('disabled', true);
  <?php } ?>
});
   </script>
</body>
</html>