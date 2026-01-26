<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Segmento.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Cliente';
if ($_SESSION['id_perfil'] == 2) {
	$redireccion = 'clientesPropietarios.php';
}else{
	$redireccion = 'clientes.php';
}

$icono = 'fa fa-briefcase';


$paises = Paises();

$segmento = new Segmento();
$segmentos = $segmento->listar();

 ?>

<!DOCTYPE html>
<html>
	<head><meta charset="utf-8">
	<title>SistemaKV | Registrar Cliente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES-->
	    <?php include("Template/styles.php"); ?>
	    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

	    <style type="text/css">
	    	.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
	            background: #5e99b1 !important;
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

    
    <!-- CONTENIDO -->
	    <section class="home_content">  
	    
	    	<div aria-label="breadcrumb" class="mt-1"> 
	            <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="clientes.php">Clientes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Cliente</li>
	            </ol>
	        </div>
	        
	        <div class="notice notice-sistemakv">
	            <strong><i class="fa fa-briefcase mr-3" style="font-size: 2rem;"></i>REGISTRO CLIENTE</strong>
	        </div>

		    <section class="form-usuarios mt-1 mb-4">
		        <div class="formulario mb-3">
		            <form method="POST" action="../Controlador/registrarCliente.php">
			        	<div id="tabs" class="mt-3">

		                    <ul>
		                      <li><a href="#tabs-1">Información</a></li>
		                      <li><a href="#tabs-2">Representante Legal</a></li>
		                    </ul>

				            <div id="tabs-1">

					            <!-- Razon Social-->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label>Razon Social</label>
						     	        </section>
				                    	<section class="input">
		                                        <input type="text" name="razon_social" id="razon_social" class="form-control" required="true">
						     	        </section>
				                    </div>


					            <!-- Razon Social-->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label>Siglas del Cliente</label>
						     	        </section>
				                    	<section class="input">
		                                        <input type="text" name="sigla" id="sigla" class="form-control">
						     	        </section>
				                    </div>

			                    <!-- Nit-->

				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label>NIT o Cedula</label>
						     	        </section>
				                    	<section class="input">
								     	    <input type="text" name="nit_cliente" id="nit_cliente"  class="form-control" required="true">
								     	    <!-- <input type="text" name="nit_cliente" id="nit_cliente"  class="form-control" onchange="validarNitCliente(this.value);" required="true"> -->
						     	        </section>
				                    </div>
				                    
				                    <section class="row d-flex justify-content-center">
		    		                    <div class="col-10 mt-3 text-center" style="border-radius: 8px; background-color: red;" class="validarValorCliente" id="validarValorCliente">
		    		                    </div>
		    		                </section>

				                <!-- Direccion-->

				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label>Direccion</label>
						     	        </section>
				                    	<section class="input">
								     	    <input type="text" name="direccion" id="direccion" class="form-control" required="true">
						     	        </section>
				                    </div>
				                    
				                    
				                <!-- Correo Eletrónico -->

				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label>Correo Eletrónico</label>
						     	        </section>
				                    	<section class="input">
								     	    <input type="email" name="correo_electronico" id="correo_electronico" class="form-control">
						     	        </section>
				                    </div>

				                <!-- Telefono-->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label>Telefono</label>
						     	        </section>
				                    	<section class="input">
								     	    <input type="text" name="telefono" id="telefono" class="form-control" required="true">
						     	        </section>
				                    </div>

				                <!-- Pais Cliente-->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label>Pais Cliente</label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_pais" id="id_pais" class="form-control" onchange="cargar_departamentos(this.value)" required="true">
										        <option>Seleccionar</option>
										        <?php foreach ($paises as $lcl){ ?>
										        	<option value="<?php echo $lcl['id_pais'] ?>">
										        		<?php echo $lcl['pais'] ?>
										        	</option>
										        <?php } ?>
										    </select>
										 </section>
				                    </div>
									    
								<!-- Departamento Cliente-->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label>Departamento Cliente</label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_departamento" id="id_departamento" class="form-control" onchange="cargar_ciudades(this.value)" required="true">
										    </select>
										 </section>
				                    </div>

				                <!-- Ciudad Cliente-->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label>Ciudad Cliente</label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_ciudad" id="id_ciudad" class="form-control" required="true">
										    </select>
										 </section>
				                    </div>

				                <!-- Tipo Cliente-->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label>Tipo Cliente</label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="tipo_cliente" id="tipo_cliente" class="form-control" required="true">
										        <option>Seleccionar</option>
										        <?php foreach ($segmentos as $sg){ ?>
										        	<option value="<?php echo $sg['id_segmento'] ?>">
										        		<?php echo $sg['detalle'] ?>
										        	</option>
										        <?php } ?>
										    </select>
										 </section>
				                    </div>
			                </div>
		                    
		                    <div id="tabs-2">

			                    <!-- Representante Legal-->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label>Nombre Representante Legal</label>
						     	        </section>
				                    	<section class="input">
								     	    <input type="text" name="nombre_rl" id="nombre_rl" class="form-control" required="true">
						     	        </section>
				                    </div>

				                <!-- Pais Representante Legal-->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label>Pais Representante Legal</label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_pais_rl" id="id_pais_rl" class="form-control" onchange="cargar_departamentos_rl(this.value)" required="true">
										        <option>Seleccionar</option>
										        <?php foreach ($paises as $lcl){ ?>
										        	<option value="<?php echo $lcl['id_pais'] ?>">
										        		<?php echo $lcl['pais'] ?>
										        	</option>
										        <?php } ?>
										    </select>
										 </section>
				                    </div>
										    
								<!-- Departamento Representante Legal-->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label>Departamento Representante Legal</label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_departamento_rl" id="id_departamento_rl" class="form-control" onchange="cargar_ciudades_rl(this.value)" required="true">
										    </select>
										 </section>
				                    </div>

				                <!-- Ciudad Representante Legal-->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label>Ciudad Representante Legal</label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_ciudad_rl" id="id_ciudad_rl" class="form-control" required="true">
										    </select>
										 </section>
				                    </div>

				                <!-- Identificacion Representante Legal-->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label>No. Documento</label>
						     	        </section>
				                    	<section class="input">
								     	    <input type="text" name="doc_rl" id="doc_rl" class="form-control" required="true">
						     	        </section>
				                    </div>

				                <!-- Fecha Expedicion Identificacion Representante Legal-->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label>Fecha de Expedicion</label>
						     	        </section>
				                    	<section class="input">
								     	    <input type="text" name="fecha_doc_rl" id="fecha_doc_rl" class="form-control">
						     	        </section>
				                    </div>
		     	   			
				                <!-- Pais Expedicion RL-->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label>Pais Expedicion</label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_pais_exp" id="id_pais_exp" class="form-control" onchange="cargar_departamentos_exp(this.value)" >
										        <option>Seleccionar</option>
										        <?php foreach ($paises as $lcl){ ?>
										        	<option value="<?php echo $lcl['id_pais'] ?>">
										        		<?php echo $lcl['pais'] ?>
										        	</option>
										        <?php } ?>
										    </select>
										 </section>
				                    </div>
										    
								<!-- Departamento Expedicion RL-->
									<div class="row  mt-3">
				                    	<section class="label">
						     	            <label>Departamento Expedicion</label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_departamento_exp" id="id_departamento_exp" class="form-control" onchange="cargar_ciudades_exp(this.value)">
										    </select>
										 </section>
				                    </div>

				                <!-- Ciudad Representante Legal-->
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

	                    <section class="col-12 mt-4 mb-3 p-3 d-flex justify-content-center">
	                        <a href="clientes.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
	                        <button type="submit" class="btn btn-outline-info col-3">Actualizar</button>
	                    </section>

		            </form> 
		        </div>
		    </section>

		</section>


    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">
	
	   function validarNitCliente(nit_cliente){
            var parametros = {
                "nit_cliente" : nit_cliente
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/ValidarRegistroCliente.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                },
                success:  function (response) {
                    //alert(response);
                    $("#validarValorCliente").html(response);
                    var valorVerificar = document.getElementById('valorVerificar').value;
                    
                    if(valorVerificar == 2){
                        $("#validarValorCliente").html("<p class='mt-3' style='color:#fff;'>Ya se encuentra registrado un cliente con el NIT O CEDULA dilegenciada</p>");
                        $("#direccion").attr("disabled","disabled");                      
                        $("#telefono").attr("disabled","disabled");                      
                        $("#id_pais").attr("disabled","disabled");                      
                        $("#id_departamento").attr("disabled","disabled");   
                        $("#id_ciudad").attr("disabled","disabled");   
                        $("#tipo_cliente").attr("disabled","disabled");   
                        $("#nombre_rl").attr("disabled","disabled");   
                        $("#id_pais_rl").attr("disabled","disabled");   
                        $("#id_departamento_rl").attr("disabled","disabled");   
                        $("#id_ciudad_rl").attr("disabled","disabled");   
                        $("#doc_rl").attr("disabled","disabled");   
                        $("#fecha_doc_rl").attr("disabled","disabled");   
                        $("#id_pais_exp").attr("disabled","disabled");   
                        $("#id_departamento_exp").attr("disabled","disabled");   
                        $("#id_ciudad_exp").attr("disabled","disabled");   
                    }else{
                        $("#direccion").removeAttr("disabled");                     
                        $("#telefono").removeAttr("disabled");                      
                        $("#id_pais").removeAttr("disabled");                      
                        $("#id_departamento").removeAttr("disabled");   
                        $("#id_ciudad").removeAttr("disabled");   
                        $("#tipo_cliente").removeAttr("disabled");   
                        $("#nombre_rl").removeAttr("disabled");   
                        $("#id_pais_rl").removeAttr("disabled");   
                        $("#id_departamento_rl").removeAttr("disabled");   
                        $("#id_ciudad_rl").removeAttr("disabled");   
                        $("#doc_rl").removeAttr("disabled");   
                        $("#fecha_doc_rl").removeAttr("disabled");   
                        $("#id_pais_exp").removeAttr("disabled");   
                        $("#id_departamento_exp").removeAttr("disabled");   
                        $("#id_ciudad_exp").removeAttr("disabled"); 
                    }
                   
                }
            });
        }
        
        

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