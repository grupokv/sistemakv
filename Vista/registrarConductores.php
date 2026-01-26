<?php
include ("../Controlador/Sesion/autenticar.php");
require("../Modelo/Vehiculo.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Conductor';
$redireccion = 'conductores.php';
$icono = 'fa fa-address-card-o';

$vehiculo = new Vehiculo();
$listarVehi = $vehiculo->listar();

$year = date('Y');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Conductor</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
  	<link rel="stylesheet" href="../Resources/css/stylesHeader.css">
</head>
<body>

    <!--MENU-->
	    <?php include("Template/header.php"); ?>
	    <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->
    
    <!-- CONTENIDO -->

    <section class="home_content">  

	    <div aria-label="breadcrumb" class="mt-1"> 
	        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="conductores.php">Conductores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar conductor</li>
	        </ol>
	    </div>
    
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-id-card-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR CONDUCTORES</b></strong>
        </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarCon.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">

                <div id="tabs" class="mt-3">
                    <ul>
                      <li><a href="#tabs-1">Información </a></li>
                      <li><a href="#tabs-2">Documentación </a></li>
					  <li><a href="#tabs-3">Seguridad Social </a></li>
					  <li><a href="#tabs-4">Antecedentes </a></li>
                      <li><a href="#tabs-5">Referencias </a></li>
                    </ul>

                    <!-- INFORMACION BASICA-->
                        <div id="tabs-1">
                        	<!--NOMBRE-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Nombre</label>
		        	                </div>
		        	                <div class="input">
		        	                    <input type="text" name="nombre_conductor"  id="nombre_conductor" class="form-control" required="true">
		        	                </div>      		
		                        </div>

                            <!-- NUMERO DE DOCUMENTO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Numero documento</label>
		        	                </div>
		        	                <div class="input">
		        	                    <input type="text" name="numero_documento_conductor"  id="numero_documento_conductor" class="form-control" required="true">
		        	                </div>      		
		                        </div>

		                    <!--CORREO ELECTRONICO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Correo electronico</label>
		        	                </div>
		        	                <div class="input">
		        		                <input type="text" name="correo_electronico" id="correo_electronico" class="form-control">
		        	                </div>      		
		                        </div>

		                    <!-- FECHA DE NACIMIENTO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Fecha nacimiento</label>
		        	                </div>
		        	                <div class="input">
		        		                <input type="text" name="fecha_nacimiento_conductor" id="datepicker" class="form-control">
		        	                </div>      		
		                        </div>

		                    <input type="hidden" name="pago_pactado"  id="pago_pactado" class="form-control" value="0">
                            
		                    <!--DIRECCION -->
		        		        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Dirección</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="text" name="direccion"  id="direccion" class="form-control">
		        			        </div>      		
		        		        </div>

                            <!--TELEFONO 1 -->
		        		        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Telefono 1</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="text" name="telefono1"  id="telefono1" class="form-control">
		        			        </div>      		
		        		        </div>

		        	        <!--TELEFONO 2 -->
		        		        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Telefono 2</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="text" name="telefono2"  id="telefono2" class="form-control">
		        			        </div>      		
		        		        </div>

		        	        <!--TELEFONO 3 --> 
		        		        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Telefono 3</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="text" name="telefono3"  id="telefono3" class="form-control">
		        			        </div>      		
		        		        </div>
		        		    
		        		    <!-- GENERO --> 
		        		        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Genero</label>
		        			        </div>
		        			        <div class="input">
                                        <select class="form-control" name="genero" id="genero">
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>      		
		        		        </div>
		        		    
		        		    <!-- RH --> 
		        		        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>RH</label>
		        			        </div>
		        			        <div class="input">
                                        <select class="form-control selectpicker" data-live-search="true" name="grupo_sanguineo" id="grupo_sanguineo">
                                            <option value="O+">O +</option>
                                            <option value="O-">O -</option>
                                            <option value="A+">A +</option>
                                            <option value="A-">A -</option>
                                            <option value="B+">B +</option>
                                            <option value="B-">B -</option>
                                            <option value="AB+">AB +</option>
                                            <option value="AB-">AB -</option>
                                        </select>
                                    </div>      		
		        		        </div>

		        		   	<!-- ESTADO CIVIL --> 
		        		        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Estado Civil</label>
		        			        </div>
		        			        <div class="input">
                                        <select class="form-control selectpicker" data-live-search="true" name="estado_civil" id="estado_civil">
                                            <option value="S">Soltero(a)</option>
                                            <option value="C">Casado(a)</option>
                                            <option value="U">Unión Libre</option>
                                            <option value="D">Divorciado(a)</option>
                                            <option value="V">Viudo(a)</option>
                                        </select>
                                    </div>      		
		        		        </div>

		        		    <!-- VEHICULO --> 
		        		        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Vehiculo</label>
		        			        </div>
		        			        <div class="input">
                                        <select class="form-control" name="id_vehiculo[]" id="id_vehiculo" multiple="multiple" required="true">
                                            <?php foreach ($listarVehi as $lv){ ?>
                                                <option value="<?php echo $lv['id_vehiculo'] ?>">
                                                    <?php echo $lv['placa'] . ' - ' . $lv['marca']?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>      		
		        		        </div>
                        </div>
                    <!-- FIN INFORMACION BASICA-->

                    <!-- ****************** -->

                    <!-- DOCUMENTACIÓN-->
                        <div id="tabs-2">

                    	    <!--FOTOGRAFIA DEL CONDUCTOR-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Fotografia</label>
		        	                </div>
		        	                <div class="input">
		        	                    <input type="file" name="fotografia_conductor"  id="fotografia_conductor" class="form-control">
		        	                </div>      		
		                        </div>

		                    <!--FOTOCOPIA DEL DOCUMENTO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Fotocopia documento</label>
		        	                </div>
		        	                <div class="input">
		        	                    <input type="file" name="fotocopia_documento"  id="fotocopia_documento" class="form-control">
		        	                </div>      		
		                        </div>

		                    <!--NUMERO DE LICENCIA -->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Numero Licencia</label>
		        	                </div>
		        	                <div class="input">
		        	                    <input type="text" name="num_licencia"  id="num_licencia" class="form-control" required="true">
		        	                </div>      		
		                        </div>
		                    
		                    <!-- CATEGORIA --> 
		        		        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Categoria Licencia</label>
		        			        </div>
		        			        <div class="input">
                                        <select class="form-control selectpicker" data-live-search="true" name="categoria_licencia" id="categoria_licencia" required="true">
                                            <option value="B1">B1</option>
                                            <option value="B2">B2</option>
                                            <option value="B3">B3</option>
                                            <option value="C1">C1</option>
                                            <option value="C2">C2</option>
                                            <option value="C3">C3</option>
                                        </select>
                                    </div>      		
		        		        </div>

		                    <!--LICENCIA DE CONDUCCIÓN-->
		                        <div class="row mt-3">
		                        	<section class="col">
		        		                <div class="row">
		        			                <div class="label">
		        				                <label>Licencia de conducción</label>
		        			                </div>
		        			                <div class="input">
		        				                <input type="file" name="fotocopia_licencia"  id="fotocopia_licencia" class="form-control" required="true">
		        			                </div>      		
		        		                </div> 
		        		            </section>
		        		            <section class="col">
		        		                <div class="row">
		        			                <div class="label">
		        				                <label>Fecha vencimiento</label>
		        			                </div>
		        			                <div class="input">
		        				                <input type="text" name="fecha_vencimiento_licencia" id="datepicker1" class="form-control" required="true">
		        			                </div>      		
		        		                </div>
		        		            </section>
		                        </div>

		                    <!--CERTIFICADOS LABORALES-->
		                        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Certificados Laborales</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="file" name="certificados_laborales"  id="certificados_laborales" class="form-control">
		        			        </div> 
		                        </div>

		                    <!--CERTIFICADOS ESTUDIOS-->
		                        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Certificados Estudios</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="file" name="certificados_estudios" id="certificados_estudios" class="form-control">
		        			        </div>   
		                        </div>

		                    <!--CERTIFICADOS CURSOS-->
		                        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Certificados Cursos</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="file" name="certificados_cursos"  id="certificados_cursos" class="form-control">
		        			        </div>   
		                        </div>

		                    <!--LIBRETA MILITAR-->
		                        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Libreta Militar</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="file" name="libreta_militar"  id="libreta_militar" class="form-control">
		        			        </div>  
		                        </div>

		                    <!--EXAMEN MEDICO-->

		                        <div class="row mt-3">
		                        	<section class="col">
		        		                <div class="row mt-3">
				        			        <div class="label">
				        				        <label>Examen Medico (IPS Autorizada)</label>
				        			        </div>
				        			        <div class="input">
				        				        <input type="file" name="examen_medico"  id="examen_medico" class="form-control">
				        			        </div>  
				                        </div>
		        		            </section>
		        		            <section class="col">
		        		                <div class="row mt-3">
		        			                <div class="label">
		        				                <label>Fecha Expedición Examen Medico</label>
		        			                </div>
		        			                <div class="input">
		        				                <input type="text" name="fecha_expedicion_examen_medico" id="datepicker2" class="form-control">
		        			                </div>      		
		        		                </div>
		        		            </section>
		                        </div>

							<input name="planilla_ss" type="hidden" value=""/>
		                    <!--RUT-->
		                        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>RUT</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="file" name="rut"  id="rut" class="form-control">
		        			        </div>
		                        </div>
								
							<!--HOJA DE VIDA-->
		                        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Hoja de Vida</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="file" name="hoja_vida"  id="hoja_vida" class="form-control">
		        			        </div>
		                        </div>
								
							<!--CARNET VACUNAS-->
		                        <div class="row mt-3">
		        			        <div class="label">
		        				        <label>Carnet Vacunas</label>
		        			        </div>
		        			        <div class="input">
		        				        <input type="file" name="vacunas"  id="vacunas" class="form-control">
		        			        </div>
		                        </div>
								
							<!--CONTRATO TRABAJO-->
		                        <div class="row mt-3">
									<section class="col">
		        		                <div class="row mt-3">
											<div class="label">
												<label>Contrato de Trabajo</label>
											</div>
											<div class="input">
												<input type="file" name="contrato_trabajo"  id="contrato_trabajo" class="form-control">
											</div>
										</div>
									</section>
									
									<section class="col">
		        		                <div class="row mt-3">
		        			                <div class="label">
		        				                <label>Fecha Expedición Contrato</label>
		        			                </div>
		        			                <div class="input">
		        				                <input type="text" name="fecha_contrato" id="datepicker4" class="form-control">
		        			                </div>      		
		        		                </div>
		        		            </section>
									
									
		                        </div>
                        </div>
                    <!-- FIN DOCUMENTACIÓN-->

                    <!-- ****************** -->
					
					<!-- SEGURIDAD SOCIAL-->
                        <div id="tabs-3">
							<input type="hidden" name="anno" value="<?php echo $year;?>"/>
                    	    <!--Planilla Enero-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Enero <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_1"  id="planilla_1" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Febrero-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Febrero <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_2"  id="planilla_2" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Marzo-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Marzo <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_3"  id="planilla_3" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Abril-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Abril <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_4"  id="planilla_4" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Mayo-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Mayo <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_5"  id="planilla_5" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Junio-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Junio <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_6"  id="planilla_6" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Julio-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Julio <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_7"  id="planilla_7" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Agosto-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Agosto <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_8"  id="planilla_8" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Septiembre-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Septiembre <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_9"  id="planilla_9" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Octubre-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Octubre <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_10"  id="planilla_10" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Noviembre-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Noviembre <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_11"  id="planilla_11" class="form-control">
								</div>      		
							</div>
							
							<!--Planilla Diciembre-->
							<div class="row mt-3">
								<div class="label">
									<label>Planilla Diciembre <?php echo $year;?></label>
								</div>
								<div class="input">
									<input type="file" name="planilla_12"  id="planilla_12" class="form-control">
								</div>      		
							</div>
							
						</div>
					<!-- FIN SEGURIDAD SOCIAL-->
					
                    <!-- ****************** -->

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
										</div>
									</div>
								</section>
								
								<section class="col">
									<div class="row mt-3">
										<div class="label">
											<label>Fecha Vencimiento</label>
										</div>
										<div class="input">
											<input type="text" name="fecha_policia" id="datepicker5" class="form-control">
										</div>      		
									</div>
								</section>
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
								
								<section class="col">
									<div class="row mt-3">
										<div class="label">
											<label>Fecha Vencimiento</label>
										</div>
										<div class="input">
											<input type="text" name="fecha_procuraduria" id="datepicker6" class="form-control">
										</div>      		
									</div>
								</section>
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
								
								<section class="col">
									<div class="row mt-3">
										<div class="label">
											<label>Fecha Vencimiento</label>
										</div>
										<div class="input">
											<input type="text" name="fecha_contraloria" id="datepicker7" class="form-control">
										</div>      		
									</div>
								</section>
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
								
								<section class="col">
									<div class="row mt-3">
										<div class="label">
											<label>Fecha Vencimiento</label>
										</div>
										<div class="input">
											<input type="text" name="fecha_personeria" id="datepicker8" class="form-control">
										</div>      		
									</div>
								</section>
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
								
								<section class="col">
									<div class="row mt-3">
										<div class="label">
											<label>Fecha Vencimiento</label>
										</div>
										<div class="input">
											<input type="text" name="fecha_simit" id="datepicker9" class="form-control">
										</div>      		
									</div>
								</section>
							</div>
							
						</div>
					<!-- FIN ANTECEDENTES-->
					

                    <!-- ****************** -->

                    <!-- REFERENCIAS-->
                    	<div id="tabs-5">

                    		<!-- REFERENCIAS COMERCIALES -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Referencias Comerciales</p>
                                    </div>
                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
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

                            <!-- REFERENCIAS LABORALES -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Referencias Laborales</p>
                                    </div>
                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
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

                            <!-- REFERENCIAS FAMILIARES -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Referencias Familiares</p>
                                    </div>
                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
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
                                
                            <!-- REFERENCIAS PERSONALES -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Referencias Personales</p>
                                    </div>
                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
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
                    	</div>
                    <!-- FIN REFERENCIAS-->
                
                </div>

                <section class="col-12 mt-4 mb-3 d-flex justify-content-center">
	              	<a href="conductores.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
	              	<button type="submit" class="btn btn-outline-info col-3">Registrar</button>
	          </section>

	        </form>
        </div>
    </section>


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

        $( function(){
      	  $("#id_vehiculo").chosen(); 
        });

        function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }


    </script>
</body>
</html>