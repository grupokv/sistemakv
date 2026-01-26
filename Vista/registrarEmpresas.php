<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Ciudad.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Empresas';
$redireccion = 'empresas.php';
$icono = 'fa fa-building-o';


$paises = Paises();

$ciudad = new Ciudad();
$listarC = $ciudad->listar();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Empresa</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style>
	        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
	            background: #1b2d3b !important;
	            border: #fff;
	        }
	    </style>

    <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->

    <section class="home_content">  

		<div aria-label="breadcrumb" class="mt-1"> 
	         <ol class="breadcrumb" style="background-color: #fff;">
	            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
	            <li class="breadcrumb-item " aria-current="page"><a href="empresas.php">Empresas</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Registrar empresas</li>
	         </ol>
	    </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR EMPRESA</b></strong>
        </div>

	    <section class="form-usuarios mb-3">
	        <div class="formulario mb-3">
	            <form action="../Controlador/registrarEmp.php" method="POST" enctype="multipart/form-data"> 

                    <div id="tabs" class="mt-3">
	                    <ul>
		                    <li><a href="#tabs-1"><b>Empresa</b></a></li>
		                    <li><a href="#tabs-2"><b>Representante legal</b></a></li>
	                    </ul>

	                    <!-- INFO EMPRESA -->
		                    <div id="tabs-1">

						        <!--NOMBRE EMPRESA-->
							        <div class="row mt-3 ">
							        	<div class="label">
								            <label>Nombre empresa</label>
							        	</div>
							        	<div class="input">
							        		<input type="text" name="nombre_empresa" id="nombre_empresa" class="form-control">
							        	</div>
							        </div>
							        
						        <!--NIT-->
							        <div class="row mt-3 ">
							        	<div class="label">
							                <label>Nit</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="nit_empresa" id="nit_empresa" class="form-control" >
							            </div>
							        </div>

						        <!--DIRECCION-->
							        <div class="row mt-3 ">
							        	<div class="label">
							                <label>Direccion</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="direccion" id="direccion" class="form-control" >
							            </div>
							        </div>

						        <!--TELEFONO-->
							        <div class="row mt-3 ">
							        	<div class="label">
							                <label>Telefono</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="telefono" id="telefono" class="form-control" >
							            </div>
							        </div>

							    <!--LOGO-->
							        <div class="row mt-3 mb-4 ">
							        	<div class="label">
							                <label>Logo de la empresa</label>
							            </div>
							        	<div class="input">
							                <input type="file" name="logo" id="logo" class="form-control">
							            </div>
							        </div>

							    <!-- PAIS -->
						                <div class="row mt-3 mb-3 ">
						                    <section class="label">
								     	        <label>Pais</label>
								     	    </section>
						                    <section class="input">
										     	<select class="form-control selectpicker" data-live-search="true" name="id_pais" id="id_pais" onchange="buscar_d(this.value)">
													<option>Seleccionar</option>
													<?php foreach ($paises as $p){ ?>
													 	<option value="<?php echo $p['id_pais'] ?>">
													 		<?php echo utf8_encode($p['pais']) ?>
													 	</option>
													<?php } ?>
												</select>
								     	    </section>
						                </div>

						        <!-- DEPARTAMENTO -->
						            <div class="row mt-3 mb-3 ">
						                <section class="label">
								     	    <label>Departamento/ Estado</label>
								     	</section>
						                <section class="input">
										    <select class="form-control" name="id_departamento" id="id_departamento" onchange="buscar_c(this.value)">
												<option value="0">Seleccionar</option>
							                </select>
								     	</section>
						            </div>

						        <!-- CIUDAD -->
						            <div class="row mt-3">
						                <section class="label">
								     	    <label>Ciudad</label>
								     	</section>
						                <section class="input">
										    <select class="form-control" name="id_ciudad" id="id_ciudad" >
												<option value="0">Seleccionar</option>
											</select>
								     	</section>
								    </div>
								    
							    <!--TELEFONO-->
							        <div class="row mt-3 ">
							        	<div class="label">
							                <label>Registro Mercantil</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="num_registro_mercantil" id="num_registro_mercantil" class="form-control" >
							            </div>
							        </div>
							        
						        <!-- RESOLUCIÓN-->
							        <div class="row mt-3 mb-5">
							        	<div class="label">
							                <label>Resolución del Ministerio</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="num_resolucion_ministerio" id="num_resolucion_ministerio" class="form-control" >
							            </div>
							        </div>
						    </div>

					    <!-- REPRESENTANTE LEGAL -->
						    <div id="tabs-2">

						        <!--REPRESENTANTE LEGAL-->
							        <div class="row mt-3 mb-4 ">
							        	<div class="label">
							                <label>Representante Legal</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="representante_legal" id="representante_legal" class="form-control">
							            </div>
							        </div>

						        <!--NUMERO DOCUMENTO-->
							        <div class="row mt-3 mb-4 ">
							        	<div class="label">
							                <label>Numero de documento</label>
							            </div>
							        	<div class="input">
							                <input type="number" name="numero_documento" id="numero_documento" class="form-control">
							            </div>
							        </div>

						        <!--FECHA EXPEDICION DEL DOCUMENTO-->
							        <div class="row mt-3 mb-4 ">
							        	<div class="label">
							                <label>Fecha de expedicion</label>
							            </div>
							        	<div class="input">
							                <input type="date" name="fecha_expedicion" id="fecha_expedicion" class="form-control">
							            </div>
							        </div>

						        <!--LUGAR DE EXPEDICION DEL DOCUMENTO-->
							        <div class="row mt-3 mb-4 ">
							        	<div class="label">
							                <label>Lugar de expedicion</label>
							            </div>
							        	<div class="input">
							                <select class="form-control selectpicker" data-live-search="true" name="lugar_expedicion" id="lugar_expedicion">
							                	<option>Seleccionar</option>
							                	<?php foreach ($listarC as $lc){ ?>
							                		<option value="<?php echo $lc['id_ciudad'] ?>">
							                			 <?php echo utf8_encode($lc['ciudad']) ?>
							                		</option>
							                	<?php } ?>
							                </select>
							            </div>
							        </div>

							    <!--LUGAR DE RESIDENCIA DEL REPRESENTANTE-->
							        <div class="row mt-3 mb-4 ">
							        	<div class="label">
							                <label>Ciudad de residencia</label>
							            </div>
							        	<div class="input">
							                <select class="form-control selectpicker" data-live-search="true" name="ciudad_residencia" id="ciudad_residencia">
							                	<option>Seleccionar</option>
							                	<?php foreach ($listarC as $lc){ ?>
							                		<option value="<?php echo $lc['id_ciudad'] ?>">
							                			 <?php echo utf8_encode($lc['ciudad']) ?>
							                		</option>
							                	<?php } ?>
							                </select>
							            </div>
							        </div>
						    </div>
				    </div>
					
					<!-- BOTONES -->
                    
                        <section class="col-12 mt-3 d-flex justify-content-center">
                          
                            <!-- CANCELAR REGISTRO -->
                                <a href="empresas.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                          
                            <!-- REGISTRAR -->
                                <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Registrar</button>
                      
                        </section>

	            </form>
	        </div>
	    </section>

	</section>

    <!-- FIN CONTENIDO -->

    <!--**************************--->
    
    <!-- SCRIPT-->
    	<?php include("Template/scripts.php"); ?>

	    <script type="text/javascript">
	    	function buscar_d(id_pais){
				//alert(id_pais);
				var parametros = {
					   "id_pais" : id_pais
				};

				$.ajax({
			         data: parametros,
			         url: '../Controlador/listarDepartamentos.php',
			         type: 'post',
			         beforeSend: function(){

			         },
			         success: function(response){
			         	//alert(response);
			               $('#id_departamento').html(response);
			                buscar_c();
			         }

				});
			}

			function buscar_c(id_departamento){
				var parametros = {
					   "id_departamento" : id_departamento
				};

				$.ajax({
			         data: parametros,
			         url: '../Controlador/listarCiudades.php',
			         type: 'post',
			         beforeSend: function(){

			         },
			         success: function(response){
			               $('#id_ciudad').html(response);
			         }
				});
			}

			$( function() {
	            $( "#tabs" ).tabs();
	        } );
	    </script>
    <!-- FIN SCRIPT-->
</body>
</html>