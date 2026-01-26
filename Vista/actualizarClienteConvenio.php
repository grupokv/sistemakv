<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Segmento.php");
require_once("../Modelo/Cliente-Convenio.php");

/* VARIABLES MENU*/
$titulo = 'Actualizar Cliente Convenio';
$redireccion = 'clientes_convenios.php';
$icono = 'fa fa-briefcase';

$id_cliente = $_GET['id_cliente'];

if (!isset($id_cliente)) {
	
} else {

$paises = Paises();


$cliente = new Cliente_Convenio();
$datos = $cliente->listarClientePorId($id_cliente);

$ciudad = new Ciudad();
$datosciudad_rl = $ciudad->listarCiudadPorId($datos[0]['ciudad_residencia_rl']);
$datosciudad_exp = $ciudad->listarCiudadPorId($datos[0]['lugar_expedicionC']);

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Cliente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

<section class="home_content">  

    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="clientes_convenios.php">Empresas Convenio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Empresa Convenio</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR EMPRESA CONVENIO</b></strong>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">

            <!--FORMULARIO -->
	            <form method="POST" action="../Controlador/actualizarClienteConvenio.php">

	            		<input type="hidden" name="id_cliente" value="<?php echo $id_cliente;?>" >

    	        		<div id="tabs" class="mt-3">
	                    <ul>
	                      <li><a href="#tabs-1">Información</a></li>
	                      <li><a href="#tabs-2">Representante Legal</a></li>
	                    </ul>

				            	<div id="tabs-1">

				            		<!-- RAZON SOCIAL-->
		                    	<div class="row mt-3">
				                    	<section class="label">
							     	            <label>Razon Social</label>
							     	        	</section>
				                    	<section class="input">
		                            	<input type="text" name="razon_social" id="razon_social" class="form-control" value="<?php echo $datos[0]['razon_social'];?>" maxlength="82">

		                            	<input type="hidden" name="razon_social_act" id="razon_social_act" class="form-control" value="<?php echo $datos[0]['razon_social'];?>" maxlength="82" >
							     	        	</section>
			                    </div>

	                    	<!-- NIT -->
				                  <div class="row mt-3">
			                    	<section class="label">
						     	            <label>NIT o Cedula</label>
						     	        	</section>
			                    	<section class="input">
								     	    			<input type="text" name="nit_cliente" id="nit_cliente" class="form-control" value="<?php echo $datos[0]['nit_cliente'];?>">

								     	    			<input type="hidden" name="nit_cliente_act" id="nit_cliente_act" class="form-control" value="<?php echo $datos[0]['nit_cliente'];?>">
						     	        	</section>
			                    </div>

			                	<!-- DIRECCIÓN -->
			                    <div class="row mt-3">
			                    	<section class="label">
					     	            		<label>Direccion</label>
						     	        	</section>
			                    	<section class="input">
								     	    			<input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo $datos[0]['direccionC'];?>">
								     	    			<input type="hidden" name="direccion_act" id="direccion_act" class="form-control" value="<?php echo $datos[0]['direccionC'];?>">
						     	        	</section>
			                    </div>

			                	<!-- TELEFONO -->
			                    <div class="row mt-3">
				                    <section class="label">
						     	            	<label>Telefono</label>
						     	        	</section>
			                    	<section class="input">
								     	    			<input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo $datos[0]['telefonoC'];?>">
								     	    			<input type="hidden" name="telefono_act" id="telefono_act" class="form-control" value="<?php echo $datos[0]['telefonoC'];?>">
					     	        		</section>
			                    </div>

			                	<!-- PAIS CLIENTE-->
			                    <div class="row  mt-3 ">
				                    	<section class="label">
							     	            	<label>Pais Cliente</label>
							     	        	</section>
				                    	<section class="input">
									     	    			<select name="id_pais" id="id_pais" class="form-control" onchange="cargar_departamentos(this.value,0)">
											        				<option value="0">SELECCIONAR</option>
											        				<?php foreach ($paises as $lcl){ ?>
											        						<option value="<?php echo $lcl['id_pais'] ?>" <?php if($datos[0]['id_pais'] == $lcl['id_pais']) { ?> selected="selected" <?php } ?>>
											        								<?php echo $lcl['pais'] ?>
											        						</option>
											        				<?php } ?>
											    				</select>

											    				<input type="hidden" name="id_pais_act" id="id_pais_act" class="form-control" value="<?php echo $datos[0]['id_pais'];?>">
											 				</section>
			                    </div>
									    
												<!-- DEPARTAMENTO CLIENTE-->
			                    <div class="row  mt-3 ">
			                    	<section class="label">
						     	            	<label>Departamento Cliente</label>
						     	        	</section>
			                    	<section class="input">
								     	    			<select name="id_departamento" id="id_departamento" class="form-control" onchange="cargar_ciudades(this.value,0)">
								     	    					<option value="0" selected="selected"><option>
										    				</select>

										    				<input type="hidden" name="id_departamento_act" id="id_departamento_act" class="form-control" value="<?php echo $datos[0]['id_departamento'];?>">
										 				</section>
			                    </div>

			                	<!-- CIUDAD CLIENTE-->
	                    		<div class="row  mt-3 ">
		                    		<section class="label">
						     	           	 <label>Ciudad Cliente</label>
						     	        	</section>
		                    		<section class="input">
								     	    			<select name="id_ciudad" id="id_ciudad" class="form-control">
										    				</select>

										    				<input type="hidden" name="id_ciudad_act" id="id_ciudad_act" class="form-control" value="<?php echo $datos[0]['id_ciudad'];?>">
										 				</section>
			                    </div>  
			                </div>

	                    <div id="tabs-2">
			                    <!-- REPRESENTANTE LEGAL-->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            		<label>Nombre Representante Legal</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<input type="text" name="nombre_rl" id="nombre_rl" class="form-control" value="<?php echo $datos[0]['representante_legalC'];?>">
								     	   	 				<input type="hidden" name="nombre_rl_act" id="nombre_rl_act" class="form-control" value="<?php echo $datos[0]['representante_legalC'];?>">
						     	        		</section>
				                    </div>

				                	<!-- PAIS REPRESENTANTE-->
				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            		<label>Pais Representante Legal</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<select name="id_pais_rl" id="id_pais_rl" class="form-control" onchange="cargar_departamentos_rl(this.value,0)">
										        					<option value="0">SELECCIONAR</option>
										       		 				<?php foreach ($paises as $lcl){ ?>
										        							<option value="<?php echo $lcl['id_pais'] ?>" <?php if($datosciudad_rl[0]['id_pais'] == $lcl['id_pais']){ ?> selected="selected" <?php } ?> >
										        									<?php echo $lcl['pais'] ?>
										        							</option>
										        					<?php } ?>
										    					</select>
										 					</section>
				                    </div>
									    
													<!-- DEPARTAMENTO REPRESENTANTE-->
				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            		<label>Departamento Representante Legal</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<select name="id_departamento_rl" id="id_departamento_rl" class="form-control" onchange="cargar_ciudades_rl(this.value,0)">
										    					</select>
										 					</section>
				                    </div>

				                	<!-- CIUDAD RESIDENCIA REPRESENTANTE -->
				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            		<label>Ciudad Representante Legal</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<select name="id_ciudad_rl" id="id_ciudad_rl" class="form-control">
										    					</select>

										    					<input type="hidden" name="id_ciudad_rl_act" id="id_ciudad_rl_act" class="form-control" value="<?php echo $datos[0]['id_ciudad'];?>">
										 					</section>
				                    </div>

				               	  <!-- NUM DOCUMENTO REPRESENTANTE -->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            		<label>No. Documento</label>
						     	       			</section>
				                    	<section class="input">
								     	    				<input type="text" name="doc_rl" id="doc_rl" class="form-control" value="<?php echo $datos[0]['numero_documentoC'];?>">

								     	    				<input type="hidden" name="doc_rl_act" id="doc_rl_act" class="form-control" value="<?php echo $datos[0]['numero_documentoC'];?>">
						     	        		</section>
				                    </div>

				                	<!-- FECHA EXPEDICIÓN DOC REPRESENTANTE -->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            		<label>Fecha de Expedicion</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<input type="text" name="fecha_doc_rl" id="fecha_doc_rl" class="form-control" value="<?php echo $datos[0]['fecha_expedicionC'];?>">
								     	    				
								     	    				<input type="hidden" name="fecha_doc_rl_act" id="fecha_doc_rl_act" class="form-control" value="<?php echo $datos[0]['fecha_expedicionC'];?>">
						     	        		</section>
				                    </div>
		     	   			
				                	<!-- PAIS EXPEDICIÓN RL -->
				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            		<label>Pais Expedicion</label>
			     	        					</section>
				                    	<section class="input">
								     	    				<select name="id_pais_exp" id="id_pais_exp" class="form-control" onchange="cargar_departamentos_exp(this.value,0)">
										        					<option value="0">SELECCIONAR</option>

										        					<?php foreach ($paises as $lcl){ ?>
										        							<option value="<?php echo $lcl['id_pais'] ?>" <?php if($datosciudad_exp[0]['id_pais'] == $lcl['id_pais']){ ?> selected="selected" <?php } ?> >
																        			<?php echo $lcl['pais'] ?>
																        	</option>
										        					<?php } ?>
										    					</select>
										 					</section>
				                    </div>
									    
													<!--DEPARTAMENTO EXPEDICIÓN RL -->
														<div class="row  mt-3">
				                    	<section class="label">
						     	            		<label>Departamento Expedicion</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<select name="id_departamento_exp" id="id_departamento_exp" class="form-control" onchange="cargar_ciudades_exp(this.value,0)">
										    					</select>
										 					</section>
				                    </div>

				                  <!-- CIUDAD EXPEDICIÓN RL -->
														<div class="row  mt-3">
				                    	<section class="label">
						     	            		<label>Ciudad Expedicion</label>
						     	        		</section>
				                    	<section class="input">
												     	    <select name="id_ciudad_exp" id="id_ciudad_exp" class="form-control">
														    	</select>

										   	 					<input type="hidden" name="id_ciudad_exp_act" id="id_ciudad_exp_act" class="form-control" value="<?php echo $datos[0]['lugar_expedicionC'];?>">
										 					</section>
				                    </div>
			                </div>
			            </div>


				          <section class="col-12 mt-4 mb-4 d-flex justify-content-center">
				              <a href="clientes_convenios.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
				              <button type="submit" class="btn btn-outline-info col-3">Actualizar</button>
				          </section>

	            </form> 

        </div>
    </section>


</section>

  <?php include("Template/scripts.php"); ?>
	<script type="text/javascript">

        $( function() {
          $( "#tabs" ).tabs();
        } ); 

        $( function() {
            $( "#fecha_doc_rl" ).datepicker({ dateFormat:'yy/mm/dd'});
        } );

        function cargar_departamentos(id_pais,id_departamento){
          //alert(id_departamento); 
          if(id_pais != ''){
              var parametros = {
                "id_pais" : id_pais,
                "id_departamento" : id_departamento
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarDepartamentosEditar.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_departamento").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");

                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_departamento").html(response);
                      
                  }
              });
          }
          
        }

        function cargar_ciudades(id_departamento,id_ciudad){
          //alert(id_departamento); 
          if(id_departamento != ''){
              var parametros = {
                "id_departamento" : id_departamento,
                "id_ciudad" : id_ciudad
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarCiudadesEditar.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_ciudad").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_ciudad").html(response);
                  }
              });
          }

        }

        function cargar_departamentos_rl(id_pais,id_departamento){
          //alert(id_pais); 
          if(id_pais != ''){
              var parametros = {
                "id_pais" : id_pais,
                "id_departamento" : id_departamento
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarDepartamentosEditar.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_departamento_rl").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_departamento_rl").html(response);
                  }
              });
          }
          
        }

        function cargar_ciudades_rl(id_departamento,id_ciudad){
          //alert(id_departamento); 
          if(id_departamento != ''){
              var parametros = {
                "id_departamento" : id_departamento,
                "id_ciudad" : id_ciudad
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarCiudadesEditar.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_ciudad_rl").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_ciudad_rl").html(response);
                  }
              });
          }
        }

		function cargar_departamentos_exp(id_pais,id_departamento){

		  //alert(id_pais); 
          if(id_pais != ''){
              var parametros = {
                "id_pais" : id_pais,
                "id_departamento" : id_departamento
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarDepartamentosEditar.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_departamento_exp").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_departamento_exp").html(response);
                  }
              });
          }
          
        }

        function cargar_ciudades_exp(id_departamento,id_ciudad){
          //alert(id_departamento); 
          if(id_departamento != ''){
              var parametros = {
                "id_departamento" : id_departamento,
                "id_ciudad" : id_ciudad
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarCiudadesEditar.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_ciudad_exp").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_ciudad_exp").html(response);
                  }
              });
          }

        }

	</script>

	<?php
	if($datos[0]['id_pais'] != '0'){ 
		echo "<script>
			cargar_departamentos(".$datos[0]['id_pais'].",".$datos[0]['id_departamento'].");
		</script>";
	}
	if($datos[0]['id_departamento'] != '0'){ 
		echo "<script>
			cargar_ciudades(".$datos[0]['id_departamento'].",".$datos[0]['id_ciudad'].");
		</script>";
	}

	if($datosciudad_rl[0]['id_ciudad'] != '0'){
		echo "<script>
			cargar_departamentos_rl(".$datosciudad_rl[0]['id_pais'].",".$datosciudad_rl[0]['id_departamento'].");
			cargar_ciudades_rl(".$datosciudad_rl[0]['id_departamento'].",".$datosciudad_rl[0]['id_ciudad'].");
		</script>";
	}

	if($datosciudad_exp[0]['id_ciudad'] != '0'){
		echo "<script>
			cargar_departamentos_exp(".$datosciudad_exp[0]['id_pais'].",".$datosciudad_exp[0]['id_departamento'].");
			cargar_ciudades_exp(".$datosciudad_exp[0]['id_departamento'].",".$datosciudad_exp[0]['id_ciudad'].");
		</script>";
	}	

	?>

</body>
</html>