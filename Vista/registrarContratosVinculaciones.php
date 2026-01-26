<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Contrato.php");

$id_responsable = $_SESSION['id_usuario'];


/* VARIABLES MENU*/
$titulo = 'Generar Contrato';
$redireccion = 'contratos.php';
$icono = 'fa fa-file-text-o';

/**/
$empresa = new Empresa();
$listarE = $empresa->listar();

$usuario = new Usuario();
$listarU = $usuario->listar();

$cliente = new Cliente();
$listarCl = $cliente->listar();

$ciudad = new Ciudad();
$listarCiudad = $ciudad->listar();

$contrato = new Contrato();
$listarTiposContratos = $contrato->listarTiposContratos();
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Generar Contrato</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="contratos_prestacion_servicios.php"> Contratos de Prestación de Servicios </a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Contrato</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/registrarContratoVinculacion.php" enctype="multipart/form-data">
	            	    <?php include("Template/header-form.php"); ?>

			            <hr>

			            <!--Numero Contrato-->
							<div class="row mt-3">
		                    	<section class="label">
				     	            <label>Numero Contrato Contrato</label>
				     	        </section>
		                    	<section class="input">
						     	    <input name="numero_contrato" id="numero_contrato" class="form-control">
								</section>
							</div>

			            <!-- Tipo Contrato-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Tipo Contrato</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_tipo_contrato" id="id_tipo_contrato" class="form-control selectpicker" data-live-search="true" onchange="validarTipoContrato();">
								        <option value="0">Seleccionar</option>
								        <?php foreach ($listarTiposContratos as $ltc){ ?>
								        	<option value="<?php echo $ltc['id_tipo_contrato'] ?>">
								        		<?php echo utf8_encode($ltc['tipo_contrato']) ?>
								        	</option>
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

	                    <!-- Empresa-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Empresa contratista</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_empresa" id="id_empresa" class="form-control selectpicker" data-live-search="true">
								        <option>Seleccionar</option>
								        <?php foreach ($listarE as $le){ ?>
								        	<option value="<?php echo $le['id_empresa'] ?>">
								        		<?php echo $le['nombre_empresa'] ?>
								        	</option>
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

		                <!-- Cliente-->

		                    <div class="row  mt-3 ">
		                    	<section class="label">
				     	            <label>Cliente contratante</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true">
								        <option>Seleccionar</option>
								        <?php foreach ($listarCl as $lcl){ ?>
								        	<option value="<?php echo $lcl['id_cliente'] ?>">
								        		<?php echo $lcl['razon_social'] ?>
								        	</option>
								        <?php } ?>
								    </select>
				     	        </section>
				     	        <button type="button" class="btn btn-info ml-3" onclick="refrescarClientes();"><span class="fa fa-refresh"></span></button>
		                    </div>

	                    <!--Fecha Inicio-->
	                    
		                    <div class="row mt-3 ">
		                    	<section class="label">
		                    	 	<label>Fecha inicial del contrato</label>
		                    	</section>
		                    	<section class="input">
		                    	 	<input type="text" name="fecha_inicial_contrato" id="datepicker" class="form-control">
		                    	</section>
		                    </div>

	     	   			<!--Fecha final-->

		     	   			<div class="row mt-3 " id="fechaFinal">
		                    	<section class="label">
		     	                    <label>Fecha final del contrato </label>
		     	                </section>
		                    	<section class="input">
		     	                    <input type="text" name="fecha_final_contrato" id="datepicker1" class="form-control">
		     	                </section>
		                    </div>

                        <!--DOC CONTRATO-->
            			
            				<div class="row mt-3 mb-5" id="fotocopiaContrato">
		                    	<section class="label">
		     	                    <label>Fotocopia del contrato firmado</label>
		     	                </section>
		                    	<section class="input">
		     	                    <input type="file" name="doc_fotocopia_contrato" id="doc_fotocopia_contrato" class="form-control">
		     	                </section>
		               	 	</div>
		               	 	
                        <hr>
                        <?php include("Template/bottom-form.php"); ?>
	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">
	
	
        $( function() {
	        $( "#datepicker" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        	minDate: 0
	        });
	        $( "#datepicker1" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        	minDate: 0
	        });
	    } );

        function refrescarClientes(){
        	/*alert('Hola');
*/
        	var parametros = {
                "contrato" : 1
              };
              $.ajax({
                  data:  parametros,
                url:   '../Controlador/CargarClientes.php',
                type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_cliente").html("<option value=''>Procesando, espere por favor...</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_cliente").html(response);
                  }
              });

        }

	</script>

</body>
</html>