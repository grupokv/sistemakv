<?php

include ("../Controlador/Sesion/autenticar.php"); 
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/General.php");

$titulo = 'Actualizar Empresas';
$redireccion = 'empresas.php';
$icono = 'fa fa-building-o';


$id_empresa = $_GET['id_empresa'];

if (!isset($id_empresa)) {
}else{
   $objE = new Empresa();
   $listarId = $objE->listarPorId($id_empresa);
}

$listarD = listarDepartamentos();
$listarP = Paises();

$ciudad = new Ciudad();
$listarC = $ciudad->listar();


 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>SistemaKV | Actualizar empresa</title>
	<!--ESTILOS-->
	<?php include("../Vista/Template/styles.php"); ?>
	<link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
	<!--FIN ESTILOS-->

</head>
<body>
	<!--MENU-->
	<?php include("../Vista/Template/menu.php"); ?>
	<!--FIN MENU-->

	<!--CONTENIDO-->
	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="empresas.php">Empresas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar empresas</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            
            <!-- Formulario -->
            <?php foreach ($listarId as $li){ ?>

	        	<form action="../Controlador/actualizarEmp.php" method="POST" enctype="multipart/form-data">
	                
	                <?php include("Template/header-form.php") ?>

	                    <div id="tabs">
		                    <ul>
			                    <li><a href="#tabs-1">Empresa </a></li>
			                    <li><a href="#tabs-2">Representante legal </a></li>
		                    </ul>

					        <!-- EMPRESA -->
			                    <div id="tabs-1">


					        		<!--ID EMPRESA-->

							       		<input type="hidden" name="id_empresa" id="id_empresa" class="form-control" value="<?php echo $li['id_empresa']; ?>">
					        
							        <!--ESTADO-->

							        	<input type="hidden" name="estado" id="estado" class="form-control" value="<?php echo $li['estado']; ?>">

							        <!--NOMBRE EMPRESA-->
								        <div class="row mt-3 ">
								        	<div class="label">
									            <label>Nombre empresa</label>
								        	</div>
								        	<div class="input">
								        		<input type="text" name="nombre_empresa" value="<?php echo $li['nombre_empresa'] ?>" id="nombre_empresa" class="form-control">
								        		<input type="hidden" name="nombre_empresa_act" value="<?php echo $li['nombre_empresa'] ?>" id="nombre_empresa_act" class="form-control">
								        	</div>
								        </div>
								        
							        <!--NIT-->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label>Nit</label>
								            </div>
								        	<div class="input">
								                <input type="text" name="nit_empresa" value="<?php echo $li['nit_empresa'] ?>" id="nit_empresa" class="form-control" >
								                <input type="hidden" name="nit_empresa_act" value="<?php echo $li['nit_empresa'] ?>" id="nit_empresa_act" class="form-control" >
								            </div>
								        </div>

							        <!--DIRECCION-->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label>Direccion</label>
								            </div>
								        	<div class="input">
								                <input type="text" name="direccion" value="<?php echo $li['direccion'] ?>" id="direccion" class="form-control" >
								                <input type="hidden" name="direccion_act" value="<?php echo $li['direccion'] ?>" id="direccion_act" class="form-control" >
								            </div>
								        </div>

							        <!--TELEFONO-->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label>Telefono</label>
								            </div>
								        	<div class="input">
								                <input type="text" name="telefono" value="<?php echo $li['telefono'] ?>" id="telefono" class="form-control" >
								                <input type="hidden" name="telefono_act" value="<?php echo $li['telefono'] ?>" id="telefono_act" class="form-control" >
								            </div>
								        </div>

								    <!--LOGO-->
								        <div class="row mt-3 mb-4 ">
								        	<div class="label">
								                <label>Logo de la empresa</label>
								            </div>
								        	<div class="input">
								                <input type="file" name="logo" id="logo" class="form-control">
								                <input type="hidden" name="act_logo" value="<?php echo $li['logo'] ?>" id="act_logo" class="form-control">
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
														<?php foreach ($listarP as $lp){ ?>
														 	<option value="<?php echo $lp['id_pais'] ?>" <?php if($lp['id_pais'] == $li['id_pais']){ ?> selected ="selected"<?php } ?>>
														 		<?php echo $lp['pais'] ?>
														 	</option>
														<?php } ?>
													</select>
													<input type="hidden" name="id_pais_act" value="<?php echo $li['id_pais'] ?>" id="id_pais_act" class="form-control">
									     	    </section>
							                </div>

							        <!-- DEPARTAMENTO -->
							            <div class="row mt-3 mb-3 ">
							                <section class="label">
									     	    <label>Departamento/ Estado</label>
									     	</section>
							                <section class="input">
											    <select class="form-control selectpicker" data-live-search="true" name="id_departamento" id="id_departamento" onchange="buscar_c(this.value)">
													<?php foreach ($listarD as $ld){ ?>
														<option value="<?php echo $ld['id_departamento'] ?>" <?php if($ld['id_departamento'] == $li['id_departamento']){ ?> selected ="selected"<?php } ?> >
															<?php echo $ld['departamento'] ?>
														</option>
													<?php } ?>
								                </select>
								                <input type="hidden" name="id_departamento_act" value="<?php echo $li['id_departamento'] ?>" id="id_departamento_act" class="form-control">
									     	</section>
							            </div>

							        <!-- CIUDAD -->
							            <div class="row mt-3 mb-5 ">
							                <section class="label">
									     	    <label>Ciudad</label>
									     	</section>
							                <section class="input">
											    <select class="form-control selectpicker" data-live-search="true" name="id_ciudad" id="id_ciudad" >
													<?php foreach ($listarC as $lc){ ?>
														<option value="<?php echo $lc['id_ciudad'] ?>" <?php if($lc['id_ciudad'] == $li['id_ciudad']){ ?> selected ="selected"<?php } ?> >
															<?php echo $lc['ciudad'] ?>
														</option>
													<?php } ?>
												</select>
												<input type="hidden" name="id_ciudad_act" value="<?php echo $li['id_ciudad'] ?>" id="id_ciudad_act" class="form-control">
									     	</section>
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
								                <input type="text" name="representante_legal" id="representante_legal" class="form-control" value="<?php echo $li['representante_legal'] ?>">
								                <input type="hidden" name="representante_legal_act" id="representante_legal_act" class="form-control" value="<?php echo $li['representante_legal'] ?>">
								            </div>
								        </div>

							        <!--NUMERO DOCUMENTO-->
								        <div class="row mt-3 mb-4 ">
								        	<div class="label">
								                <label>Numero de documento</label>
								            </div>
								        	<div class="input">
								                <input type="number" name="numero_documento" id="numero_documento" class="form-control" value="<?php echo $li['numero_documento'] ?>">
								                <input type="hidden" name="numero_documento_act" id="numero_documento_act" class="form-control" value="<?php echo $li['numero_documento'] ?>">
								            </div>
								        </div>

							        <!--FECHA EXPEDICION DEL DOCUMENTO-->
								        <div class="row mt-3 mb-4 ">
								        	<div class="label">
								                <label>Fecha de expedicion</label>
								            </div>
								        	<div class="input">
								                <input type="date" name="fecha_expedicion" id="fecha_expedicion" class="form-control" value="<?php echo $li['fecha_expedicion'] ?>">
								                <input type="hidden" name="fecha_expedicion_act" id="fecha_expedicion_act" class="form-control" value="<?php echo $li['fecha_expedicion'] ?>">
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
								                		<option value="<?php echo $lc['id_ciudad'] ?>" <?php if($lc['id_ciudad'] == $li['lugar_expedicion']){ ?> selected="selected" <?php } ?> >
								                			 <?php echo $lc['ciudad'] ?>
								                		</option>
								                	<?php } ?>
								                </select>
								                <input type="hidden" name="lugar_expedicion_act" id="lugar_expedicion_act" class="form-control" value="<?php echo $li['lugar_expedicion'] ?>">
								            </div>
								        </div>

								    <!--LUGAR DE RESIDENCIA DEL REPRESENTANTE-->
								        <div class="row mt-3 mb-4 ">
								        	<div class="label">
								                <label>Ciudad de residencia</label>
								            </div>
								        	<div class="input">
								                <select class="form-control selectpicker" data-live-search="true" name="ciudad_residencia" id="ciudad_residencia">
								                	<?php foreach ($listarC as $lc){ ?>
								                		<option value="<?php echo $lc['id_ciudad'] ?>" <?php if($lc['id_ciudad'] == $li['ciudad_residencia']){ ?> selected="selected" <?php } ?>>
								                			 <?php echo $lc['ciudad'] ?>
								                		</option>
								                	<?php } ?>
								                </select>
								                <input type="hidden" name="ciudad_residencia_act" id="ciudad_residencia_act" class="form-control" value="<?php echo $li['ciudad_residencia'] ?>">
								            </div>
								        </div>
							    </div>



			        <?php include("Template/bottom-form.php") ?>	 
		        </form>
		<?php } ?>
        </div>
    </section>
	<!--FIN CONTENIDO-->

<!--SCRIPTS-->
    <?php include("../Vista/Template/scripts.php");  ?>

    <script type="text/javascript">

    	$( function() {
            $( "#tabs" ).tabs();
        } );

    </script>
<!--SCRIPTS-->
</body>
</html>