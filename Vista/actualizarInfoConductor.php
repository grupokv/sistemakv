<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo-Conductor.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");

$fecha = strtotime('+3 days',strtotime(date('Y-m-d')));
$plazoVencimiento = date('Y-m-d',$fecha);


$titulo = 'Actualizar Información y Documentación';
$redireccion = 'inicioConductores.php';
$icono = 'fa fa-address-card-o';

$num_doc = $_GET['num_doc'];

if (!isset($num_doc)) {
	
}else{

$conductor = new Conductor();
$listarPorDocumento = $conductor->buscarConductorPorDocumento($num_doc);

$vehiculoConductor = new Vehiculo_Conductor();

$vehiculo = new Vehiculo();
$listarVehi = $vehiculo->listar();

$usuario = new Usuario();
$id_vehiculos = array();



}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Conductor</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="conductores.php">Conductores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar conductor</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
	        <form action="../Controlador/seguimientoActualizacionesDocsVehiculo.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()"> 
	        	<?php include("Template/header-form.php") ?>
	        	<div id="tabs">
                    <ul>
                      <li><a href="#tabs-1">Información </a></li>
                      <li><a href="#tabs-2">Documentación </a></li>
                    </ul>

                    <?php foreach ($listarPorDocumento as $lcd){ ?>

                    	<?php 
                    		$listarVC = $vehiculoConductor->listarPorId($lcd['id_conductor']);
							
							foreach ($listarVC as $lvc) {
								array_push($id_vehiculos, $lvc['id_vehiculo']);
							}
						 ?>

                    	<input type="hidden" name="id_conductor" value="<?php echo $lcd['id_conductor'] ?>">
                    	<input type="hidden" name="estado" value="<?php echo $lcd['estado'] ?>">

                    	<!-- INFORMACION BASICA-->
                            <div id="tabs-1">
	                        	<!--NOMBRE-->
			                        <div class="row mt-3 ">
			        	                <div class="label">
			        		                <label>Nombre</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="nombre_conductor"  id="nombre_conductor" class="form-control" value="<?php echo $lcd['nombre_conductor'] ?>">
			        	                    <input type="hidden" name="nombre_conductor_act"  id="nombre_conductor_act" class="form-control" value="<?php echo $lcd['nombre_conductor'] ?>">
			        	                </div>      		
			                        </div>

	                            <!-- NUMERO DE DOCUMENTO-->
									<div class="row mt-3 ">
			        			        <div class="label">
			        				        <label>Numero de Documento</label>
			        			        </div>
			        			        <div class="input">
			        	            		<input type="text" name="numero_documento_conductor"  id="numero_documento_conductor" class="form-control" value="<?php echo $lcd['numero_documento_conductor'] ?>" readonly>

			        			        </div>      		
			        		        </div>

			                    <!--PAGO PACTADO-->

			        	            <input type="hidden" name="pago_pactado"  id="pago_pactado" class="form-control" value="<?php echo $lcd['pago_pactado'] ?>">
                            
	                            <!--TELEFONO 1 -->
			        		        <div class="row mt-3 ">
			        			        <div class="label">
			        				        <label>Telefono 1</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="telefono1"  id="telefono1" class="form-control" value="<?php echo $lcd['telefono1'] ?>">
			        				        <input type="hidden" name="telefono1_act"  id="telefono1_act" class="form-control" value="<?php echo $lcd['telefono1'] ?>">
			        			        </div>      		
			        		        </div>

			        	        <!--TELEFONO 2 -->
			        		        <div class="row mt-3 ">
			        			        <div class="label">
			        				        <label>Telefono 2</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="telefono2"  id="telefono2" class="form-control" value="<?php echo $lcd['telefono2'] ?>">
			        				        <input type="hidden" name="telefono2_act"  id="telefono2_act" class="form-control" value="<?php echo $lcd['telefono2'] ?>">
			        			        </div>      		
			        		        </div>

		        	     	   	<!--TELEFONO 3 --> 
			        		        <div class="row mt-3 ">
			        			        <div class="label">
			        				        <label>Telefono 3</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="telefono3"  id="telefono3" class="form-control" value="<?php echo $lcd['telefono3'] ?>">
			        				        <input type="hidden" name="telefono3_act"  id="telefono3_act" class="form-control" value="<?php echo $lcd['telefono3'] ?>">
			        			        </div>      		
			        		        </div>

			        		    <!-- FECHA DE NACIMIENTO-->

									<div class="row mt-3 ">
			        			        <div class="label">
			        				        <label>Fecha Nacimiento</label>
			        			        </div>
			        			        <div class="input">
			        				        <input type="text" name="fecha_nacimiento_conductor" id="datepicker" class="form-control" value="<?php echo $lcd['fecha_nacimiento_conductor'] ?>">
			        				        <input type="hidden" name="fecha_nacimiento_conductor_act" id="datepicker" class="form-control" value="<?php echo $lcd['fecha_nacimiento_conductor'] ?>">
			        			        </div>      		
			        		        </div>

			        		    <!-- CORREO ELECTRONICO-->

									<div class="row mt-3 ">
			        			        <div class="label">
			        				        <label>Correo Electronico</label>
			        			        </div>
			        			        <div class="input">

			        			        	<?php  $listarUsuPorId = $usuario->listarUsuarioPorCedula($lcd['numero_documento_conductor']); ?>
			        			        	
			        			        		<input type="text" name="correo_electronico" id="datepicker" class="form-control" value="<?php echo $listarUsuPorId[0]['correo_electronico'] ?>">
			        				        	<input type="hidden" name="correo_electronico_act" id="datepicker" class="form-control" value="<?php echo $listarUsuPorId[0]['correo_electronico'] ?>">
			        			        	
			        			        	
			        			        	
			        			        </div>      		
			        		        </div>

		        		  		<!-- VEHICULO --> 
			        		        <div class="row mt-3 ">
			        			        <div class="label">
			        				        <label>Vehiculo</label>
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

	                    	    <!--HOJA DE VIDA-->
			                        <div class="row mt-3 ">
			        	                <div class="label">
			        		                <label>Hoja de vida</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="file" name="hoja_vida"  id="hoja_vida" class="form-control">
			        	                    <input type="hidden" name="act_hoja_vida" id="act_hoja_vida" value="<?php echo $lcd['hoja_vida'] ?>">
			        	                    
			        	                    <?php if ($lcd['hoja_vida'] == '') { ?>
			        	                        <label class="mt-2" for="act_hoja_vida"><strong>Documento Actual: </strong> No hay documentos cargados</label>
			        	                    <?php } else{ ?>
			        	                        <label class="mt-2" for="act_hoja_vida"><strong>Documento Actual: </strong> <?php echo $lcd['hoja_vida'] ?></label>
			        	                    <?php }  ?>
			        	                </div>      		
			                        </div>

			                    <!--FOTOCOPIA DEL DOCUMENTO-->
			                        <div class="row mt-3 ">
			        	                <div class="label">
			        		                <label>Fotocopia documento</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="file" name="fotocopia_documento"  id="fotocopia_documento" class="form-control">
			        	                    <input type="hidden" name="act_fotocopia_documento" id="act_fotocopia_documento" value="<?php echo $lcd['fotocopia_documento'] ?>">
			        	                    
			        	                    <?php if ($lcd['fotocopia_documento'] == '') { ?>
			        	                        <label class="mt-2" for="act_fotocopia_documento"><strong>Documento Actual: </strong> No hay documentos cargados</label>
			        	                    <?php } else{ ?>
			        	                        <label class="mt-2" for="act_fotocopia_documento"><strong>Documento Actual: </strong> <?php echo $lcd['fotocopia_documento'] ?></label>
			        	                    <?php }  ?>
			        	                </div>      		
			                        </div>

			                    <!-- NUMERO DE LICENCIA-->
			                        <div class="row mt-3 ">
			        	                <div class="label">
			        		                <label>Numero Licencia</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="text" name="num_licencia"  id="num_licencia" value="<?php echo $lcd['num_licencia'] ?>" class="form-control">
			        	                    <input type="hidden" name="num_licencia_act"  id="num_licencia_act" value="<?php echo $lcd['num_licencia'] ?>" class="form-control">
			        	                </div>      		
			                        </div>

			                    <!--LICENCIA DE CONDUCCIÓN-->

			                   	 	<?php if ($lcd['fecha_vencimiento_licencia']  <= date('Y-m-d')) { ?>
										<div class="row mt-5">
				        	                <section class="col">
				        		                <div class="row">
				        			                <div class="label">
				        				                <label>Licencia de conducción</label>
				        			                </div>
				        			                <div class="input">
				        				                <input style="border: 2px solid red" type="file" name="fotocopia_licencia"  id="fotocopia_licencia" class="form-control">
				        	                            <input type="hidden" name="fotocopia_licencia_act" id="fotocopia_licencia_act" value="<?php echo $lcd['fotocopia_licencia'] ?>">
				        			                </div>      		
				        		                </div>
				        	                </section>
				        	                <section class="col">
				        		                <div class="row">
				        			                <div class="label">
				        				                <label>Fecha vencimiento</label>
				        			                </div>
				        			                <div class="input">
				        				                <input style="border: 2px solid red" type="text" name="fecha_vencimiento_licencia" id="datepicker1" class="form-control" value="<?php echo $lcd['fecha_vencimiento_licencia'] ?>">
				        				                <input type="hidden" name="fecha_vencimiento_licencia_act" id="datepicker1" class="form-control" value="<?php echo $lcd['fecha_vencimiento_licencia'] ?>">
				        			                </div>      		
				        		                </div>
				        	                </section>
				                        </div>
									<?php } else if(($lvi['fecha_vencimiento_licencia'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_licencia'] > date('Y-m-d'))){ ?>
										<div class="row mt-5">
				        	                <section class="col">
				        		                <div class="row">
				        			                <div class="label">
				        				                <label>Licencia de conducción</label>
				        			                </div>
				        			                <div class="input">
				        				                <input style="border: 2px solid orange" type="file" name="fotocopia_licencia"  id="fotocopia_licencia" class="form-control">
				        	                            <input type="hidden" name="fotocopia_licencia_act" id="fotocopia_licencia_act" value="<?php echo $lcd['fotocopia_licencia'] ?>">
				        			                </div>      		
				        		                </div>
				        	                </section>
				        	                <section class="col">
				        		                <div class="row">
				        			                <div class="label">
				        				                <label>Fecha vencimiento</label>
				        			                </div>
				        			                <div class="input">
				        				                <input style="border: 2px solid orange" type="text" name="fecha_vencimiento_licencia" id="datepicker1" class="form-control" value="<?php echo $lcd['fecha_vencimiento_licencia'] ?>">
				        				                <input type="hidden" name="fecha_vencimiento_licencia_act" id="datepicker1" class="form-control" value="<?php echo $lcd['fecha_vencimiento_licencia'] ?>">
				        			                </div>      		
				        		                </div>
				        	                </section>
				                        </div>
									<?php } else { ?>
										<div class="row mt-5">
				        	                <section class="col">
				        		                <div class="row">
				        			                <div class="label">
				        				                <label>Licencia de conducción</label>
				        			                </div>
				        			                <div class="input">
				        				                <input type="file" name="fotocopia_licencia"  id="fotocopia_licencia" class="form-control">
				        	                            <input type="hidden" name="fotocopia_licencia_act" id="fotocopia_licencia_act" value="<?php echo $lcd['fotocopia_licencia'] ?>">
				        			                </div>      		
				        		                </div>
				        	                </section>
				        	                <section class="col">
				        		                <div class="row">
				        			                <div class="label">
				        				                <label>Fecha vencimiento</label>
				        			                </div>
				        			                <div class="input">
				        				                <input type="text" name="fecha_vencimiento_licencia" id="datepicker1" class="form-control" value="<?php echo $lcd['fecha_vencimiento_licencia'] ?>">
				        				                <input type="hidden" name="fecha_vencimiento_licencia_act" id="datepicker1" class="form-control" value="<?php echo $lcd['fecha_vencimiento_licencia'] ?>">
				        			                </div>      		
				        		                </div>
				        	                </section>
				                        </div>
									<?php } ?>
			                        

			                        <div class="row justify-content-around">
			                        	<?php if ($lcd['fotocopia_licencia'] == '') { ?>
			        	                   	<label class="mt-2" for="fotocopia_licencia_act"><strong>Documento Actual: </strong> No hay documentos cargados</label>
			        	                <?php } else{ ?>
			        	                   	<label class="mt-2" for="fotocopia_licencia_act"><strong>Documento Actual: </strong> <?php echo $lcd['fotocopia_licencia'] ?></label>
			        	                <?php }  ?>
			                        </div>
                          
                            </div>
                    <?php } ?>
                </div>
                <?php include("Template/bottom-form.php"); ?>
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	 $( function() {

            $( "#datepicker" ).datepicker({ dateFormat:'yy/mm/dd'});
            $( "#datepicker1" ).datepicker({ dateFormat:'yy/mm/dd'});
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