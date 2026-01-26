<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Ciudad.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Cliente Convenio';
$redireccion = 'clientes_convenios.php';
$icono = 'fa fa-briefcase';


$paises = Paises();

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
		<title>SistemaKV | Registrar Cliente Convenio</title>
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
            <li class="breadcrumb-item " aria-current="page"><a href="clientes_convenios.php">Empresas Convenios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Empresa Convenio</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR EMPRESA CONVENIO</b></strong>
    </div>

   
    <section class="form-usuarios mt-1 mb-5">
        <div class="formulario mb-3">
            
            <form method="POST" action="../Controlador/registrarClienteConvenio.php">
  	        		<div id="tabs" class="mt-4">
	                  <ul>
	                      <li><a href="#tabs-1">Información</a></li>
	                      <li><a href="#tabs-2">Representante Legal</a></li>
	                  </ul>

	                  <!-- INFORMACIÓN EMPRESA -->
					            <div id="tabs-1">
				                  
				                  <!-- RAZON SOCIAL-->
					                  <div class="row mt-3">
					                    <section class="label">
							     	            	<label>Razon Social</label>
							     	        	</section>
				                    	<section class="input">
			                            <input type="text" name="razon_social" id="razon_social" class="form-control" maxlength="82" required="true">
							     	        	</section>
				                    </div>

				                  <!-- NIT -->
					                    <div class="row mt-3">
					                    	<section class="label">
							     	            		<label>NIT o Cedula</label>
							     	        		</section>
					                    	<section class="input">
									     	    				<input type="text" name="nit_cliente" id="nit_cliente" class="form-control">
							     	        		</section>
					                    </div>

					                <!-- DIRECCIÓN-->
					                  <div class="row mt-3">
					                    <section class="label">
							     	            	<label>Direccion</label>
							     	        	</section>
					                    <section class="input">
									     	    			<input type="text" name="direccion" id="direccion" class="form-control">
							     	        	</section>
					                  </div>

					                <!-- TELEFONO-->
					                  <div class="row mt-3">
					                    <section class="label">
							     	            	<label>Telefono</label>
							     	        	</section>
					                    <section class="input">
									     	    			<input type="text" name="telefono" id="telefono" class="form-control">
							     	        	</section>
					                  </div>

					                <!-- PAIS CLIENTE-->
					                  <div class="row  mt-3 ">
					                   	<section class="label">
							     	            	<label>Pais Cliente</label>
							     	        	</section>
					                    <section class="input">
									     	    			<select name="id_pais" id="id_pais" class="form-control" onchange="cargar_departamentos(this.value)">
											        				<option value="">SELECCIONAR</option>
											        				<?php foreach ($paises as $lcl){ ?>
											        						<option value="<?php echo $lcl['id_pais'] ?>">
											        								<?php echo $lcl['pais'] ?>
											        						</option>
											        				<?php } ?>
											    				</select>
											 				</section>
					                  </div>
											    
													<!-- DEPARTAMENTO CLIENTE-->
					                  <div class="row  mt-3 ">
					                    <section class="label">
							     	            	<label>Departamento Cliente</label>
							     	        	</section>
					                    <section class="input">
									     	    			<select name="id_departamento" id="id_departamento" class="form-control" onchange="cargar_ciudades(this.value)">
											    				</select>
											 				</section>
					                  </div>

					                <!-- CIUDAD CLIENTE -->
					                  <div class="row  mt-3 ">
					                    <section class="label">
							     	            	<label>Ciudad Cliente</label>
							     	        	</section>
					                    <section class="input">
									     	    			<select name="id_ciudad" id="id_ciudad" class="form-control">
											    				</select>
											 				</section>
					                  </div>
				              </div>
			                                    
										<!-- REPRESENTANTE LEGAL -->

											<div id="tabs-2">

				                  <!-- REPRESENTANTE LEGAL -->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            		<label>Nombre Representante Legal</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<input type="text" name="nombre_rl" id="nombre_rl" class="form-control">
						     	        		</section>
				                    </div>

				                	<!-- PAIS RL-->
				                    <div class="row  mt-3 ">
				                    	<section class="label">
								     	            <label>Pais Representante Legal</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<select name="id_pais_rl" id="id_pais_rl" class="form-control" onchange="cargar_departamentos_rl(this.value)">
										        					<option value="">SELECCIONAR</option>
										        					
										        					<?php foreach ($paises as $lcl){ ?>
										        							<option value="<?php echo $lcl['id_pais'] ?>">
										        									<?php echo $lcl['pais'] ?>
										        							</option>
										        					<?php } ?>
										    					</select>
										 					</section>
				                    </div>
										    
													<!-- DEPARTAMENTO RL-->
				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            		<label>Departamento Representante Legal</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<select name="id_departamento_rl" id="id_departamento_rl" class="form-control" onchange="cargar_ciudades_rl(this.value)">
										    					</select>
										 					</section>
				                    </div>

				                	<!-- CIUDAD RL-->
				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            		<label>Ciudad Representante Legal</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<select name="id_ciudad_rl" id="id_ciudad_rl" class="form-control">
										    					</select>
										 					</section>
				                    </div>

				                	<!-- NUM DOCUMENTO RL-->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            		<label>No. Documento</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<input type="text" name="doc_rl" id="doc_rl" class="form-control">
						     	        		</section>
				                    </div>

				                	<!-- FECHA DOC EXPEDICIÓN RL-->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            		<label>Fecha de Expedicion</label>
						     	        		</section>
				                    	<section class="input">
								     	    				<input type="text" name="fecha_doc_rl" id="fecha_doc_rl" class="form-control">
						     	       	 		</section>
				                    </div>
			     	   			
				                	<!-- PAIS EXPEDICIÓN RL-->
				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            		<label>Pais Expedicion</label>
						     	       	 		</section>
				                    	<section class="input">
								     	    				<select name="id_pais_exp" id="id_pais_exp" class="form-control" onchange="cargar_departamentos_exp(this.value)">
										        					<option value="">SELECCIONAR</option>
										        					<?php foreach ($paises as $lcl){ ?>
										        							<option value="<?php echo $lcl['id_pais'] ?>">
										        									<?php echo $lcl['pais'] ?>
										        							</option>
										        					<?php } ?>
										    					</select>
										 					</section>
				                    </div>
										    
													<!-- DEPARTAMENTO EXPEDICIÓN RL-->
														<div class="row  mt-3">
					                    	<section class="label">
											     	        <label>Departamento Expedicion</label>
											     	    </section>
									              <section class="input">
													     	    <select name="id_departamento_exp" id="id_departamento_exp" class="form-control" onchange="cargar_ciudades_exp(this.value)">
															    	</select>
															 </section>
				                    </div>

					                <!-- CIUDAD RL-->
														<div class="row  mt-3">
				                    	<section class="label">
								     	            <label>Ciudad Expedicion</label>
								     	        </section>
								              <section class="input">
												     	    <select name="id_ciudad_exp" id="id_ciudad_exp" class="form-control">
														    	</select>
														 	</section>
				                    </div>
				              </div>
			          
			          </div>

			          <section class="col-12 mt-4 mb-3 d-flex justify-content-center">
			              <a href="clientes_convenios.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
			              <button type="submit" class="btn btn-outline-info col-3">Registrar</button>
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

        function cargar_departamentos(id_pais){
          //alert(id_pais); 
          if(id_pais != ''){
              var parametros = {
                "id_pais" : id_pais
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarDepartamentos.php',
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
          cargar_ciudades(0);
        }

        function cargar_ciudades(id_departamento){
          //alert(id_departamento); 
          if(id_departamento != ''){
              var parametros = {
                "id_departamento" : id_departamento
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarCiudades.php',
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

        function cargar_departamentos_rl(id_pais){
          //alert(id_pais); 
          if(id_pais != ''){
              var parametros = {
                "id_pais" : id_pais
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarDepartamentos.php',
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
          cargar_ciudades_rl(0);
        }

        function cargar_ciudades_rl(id_departamento){
          //alert(id_departamento); 
          if(id_departamento != ''){
              var parametros = {
                "id_departamento" : id_departamento
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarCiudades.php',
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

		function cargar_departamentos_exp(id_pais){
          //alert(id_pais); 
          if(id_pais != ''){
              var parametros = {
                "id_pais" : id_pais
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarDepartamentos.php',
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
          cargar_ciudades_exp(0);
        }

        function cargar_ciudades_exp(id_departamento){
          //alert(id_departamento); 
          if(id_departamento != ''){
              var parametros = {
                "id_departamento" : id_departamento
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarCiudades.php',
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


</body>
</html>