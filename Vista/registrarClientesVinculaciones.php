<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Segmento.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Cliente';
$redireccion = 'clientes.php';
$icono = 'fa fa-briefcase';


$paises = Paises();

$segmento = new Segmento();
$segmentos = $segmento->listar();

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Cliente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Cliente</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/registrarCliente.php">
	            	    <?php include("Template/header-form.php"); ?>
    	        	<div id="tabs">
                        <ul>
                          <li><a href="#tabs-1">Informaci贸n</a></li>
                          <li><a href="#tabs-2">Representante Legal</a></li>
                        </ul>

			            <!-- Razon Social-->
			             <div id="tabs-1">
		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Razon Social</label>
				     	        </section>
		                    	<section class="input">
                                        <input type="text" name="razon_social" id="razon_social" class="form-control" required="true">
				     	        </section>
		                    </div>

	                    <!-- Nit-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>NIT o Cedula</label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="text" name="nit" id="nit" class="form-control">
				     	        </section>
		                    </div>

		                <!-- Direccion-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Direccion</label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="text" name="direccion" id="direccion" class="form-control">
				     	        </section>
		                    </div>

		                <!-- Telefono-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Telefono</label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="text" name="telefono" id="telefono" class="form-control">
				     	        </section>
		                    </div>

		                <!-- Tipo Cliente-->

		                    <div class="row  mt-3 ">
		                    	<section class="label">
				     	            <label>Tipo Cliente</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="tipo_cliente" id="tipo_cliente" class="form-control">
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
						     	    <input type="text" name="nombre_rl" id="nombre_rl" class="form-control">
				     	        </section>
		                    </div>

		                <!-- Ciudad Representante Legal-->

		                    <div class="row  mt-3 ">
		                    	<section class="label">
				     	            <label>Ciudad Representante Legal</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_ciudad_rl" id="id_ciudad_rl" class="form-control">
								    </select>
								 </section>
		                    </div>

		                <!-- Identificacion Representante Legal-->
		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>No. Documento</label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="text" name="doc_rl" id="doc_rl" class="form-control">
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
	     	   			
		                <!-- Ciudad Representante Legal-->
							<div class="row  mt-3">
		                    	<section class="label">
				     	            <label>Ciudad Expedición</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_ciudad_exp" id="id_ciudad_exp" class="form-control">
								    </select>
								 </section>
		                    </div>

		                </div>

                        <hr>
            
                        <?php include("Template/bottom-form.php"); ?>
	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">

        $( function() {
          $( "#tabs" ).tabs();
        } ); 

        $( function() {
            $( "#fecha_doc_rl" ).datepicker({ dateFormat:'yy/mm/dd'});
        } );

	</script>


</body>
</html>