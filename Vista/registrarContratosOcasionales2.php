<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");

$id_responsable = $_SESSION['id_usuario'];


/* VARIABLES MENU*/
$titulo = 'Generar Contrato Ocasional';

if ($_SESSION['id_perfil'] == 3){	
	$redireccion = 'inicioConductores.php';
}else{
	$redireccion = 'contratosOcasionales.php';
}

$icono = 'fa fa-file-text-o';
/**/
$empresa = new Empresa();
$listarE = $empresa->listar();

$usuario = new Usuario();
$listarU = $usuario->listar();

$vehiculo = new Vehiculo();
$listarV = $vehiculo->listar();

$cliente = new Cliente();
$listarCl = $cliente->listar();

$ciudad = new Ciudad();
$listar = $ciudad->listar();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Generar Contrato Ocasional</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Contrato Ocasional</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/registrarContraOcasional2.php">
	            	    <?php include("Template/header-form.php"); ?>

	            	    <input type="hidden" name="id_responsable" id="id_responsable" value="<?php echo $id_responsable ?>" class="form-control">
			        	
			            <hr>

		                    <!-- Empresa-->

			                    <div class="row mt-3">
			                    	<section class="label">
					     	            <label>Empresa contratista</label>
					     	        </section>
			                    	<section class="input">
							     	    <select name="id_empresa" id="id_empresa" class="form-control">
									        <option>SELECCIONAR</option>
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
									        <option>SELECCIONAR</option>
									        <?php foreach ($listarCl as $lcl){ ?>
									        	<option value="<?php echo $lcl['id_cliente'] ?>">
									        		<?php echo $lcl['razon_social'] ?>
									        	</option>
									        <?php } ?>
									    </select>
					     	        </section>
			                    </div>

			                <!-- Objeto contrato-->

			                    <div class="row  mt-3 ">
			                    	<section class="label">
					     	            <label>Objeto del contrato</label>
					     	        </section>
			                    	<section class="input">
							     	    <textarea name="objeto_contrato" id="objeto_contrato" class="form-control">SERVICIO DE TRANSPORTE ESPECIAL DE PASAJEROS CON GRUPO ESPECÍFICO DE USUARIOS</textarea> 
					     	        </section>
			                    </div>

						    <!-- Vehiculo -->

			                    <div class="row mt-3 mb-3 ">
			                    	<section class="label">
					     	            <label>Vehiculo</label>
					     	        </section>
			                    	<section class="input">
							     	    <select name="id_vehiculo" id="id_vehiculo" class="form-control selectpicker" data-live-search="true" onchange="validarDocsConductor(this.value);">
									        <option value="0">SELECCIONAR</option>
									        <?php foreach ($listarV as $lv){ ?>
									        	<?php 
									        		
													$hoy = date('Y-m-d');
													$fecha2 = date('Y-m-d',strtotime('-1 year',strtotime(date('Y-m-d'))));
													
													$docs_vacios = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'],$hoy,$fecha2);

													if (count($docs_vacios) >0 ) {?>
														<option value="<?php echo $lv['id_vehiculo'] ?>" disabled style="color:red;font-weight:bolder">
											        		<?php echo $lv['placa'] ?>
											        	</option>
													<?php }else{ ?>
														<option value="<?php echo $lv['id_vehiculo'] ?>">
											        		<?php echo $lv['placa'] ?>
											        	</option>
													<?php } ?>
												
									        	
									        <?php } ?>
									    </select>
					     	        </section>
			                    </div>

							<!-- CONDUCTORES-->
			                <div class="row ml-5 mb-3" class="mensaje_conductor" id="mensaje_conductor">
		                        <div class="col-12 ml-5">
		                            
		                        </div>
		                    </div>

			                <!--Origen-->
			                	<div class="row mt-3" id="orig">
			                    	<section class="label">
					     	            <label>Origen</label>
					     	        </section>
			                    	<section class="input">
	                                      <select class="form-control" name="origen" id="origen">
		                                      	<option value="0">SELECCIONAR</option>
											 	<?php foreach ($listar as $lc){ ?>
											 		<option value="<?php echo $lc['id_ciudad'] ?>">
											 			<?php echo $lc['ciudad'] ?>
											 		</option>
											 	<?php } ?>
	                                      </select>
					     	        </section>
			                    </div>

			                <!--Destino-->
			                    <div class="row mt-3" id="dest">
			                    	<section class="label">
					     	            <label>Destino</label>
					     	        </section>
			                    	<section class="input">
	                                        <select class="form-control" name="destino"  id="destino" onchange="ocultarRutas()">
		                                      	<option value="0">SELECCIONAR</option>
											 	<?php foreach ($listar as $lc){ ?>
											 		<option value="<?php echo $lc['id_ciudad'] ?>">
											 			<?php echo $lc['ciudad'] ?>
											 		</option>
											 	<?php } ?>
	                                      </select>
					     	        </section>
			                    </div>

			                <!--Ruta 1-->
								<div class="row mt-3" id="rutaUno" style="display: none;">
			                    	<section class="label">
					     	            <label>Ruta principal</label>
					     	        </section>
			                    	<section class="input">
	                                        <input type="text" name="ruta1"  id="ruta1" class="form-control">
					     	        </section>
			                    </div>

			                <!--Ruta 2-->
								<div class="row mt-3"  id="rutaDos" style="display: none;">
			                    	<section class="label">
					     	            <label>Ruta Secundaria</label>
					     	        </section>
			                    	<section class="input">
	                                        <input type="text" name="ruta2" id="ruta2" class="form-control">
					     	        </section>
			                    </div>

			                <!-- Ciudad -->
			                    <div class="row mt-3">
			                    	<section class="label">
					     	            <label>Ciudad emisión del contrato</label>
					     	        </section>
			                    	<section class="input">
							     	    <select class="form-control" name="id_ciudad" id="id_ciudad" >
										 	<option value="0">Seleccionar</option>
										 	<?php foreach ($listar as $lc){ ?>
										 		<option value="<?php echo $lc['id_ciudad'] ?>">
										 			<?php echo $lc['ciudad'] ?>
										 		</option>
										 	<?php } ?>
										</select>
					     	        </section>
			                    </div>

			                <!--Fecha Inicio-->
		                    
			                    <div class="row mt-3 ">
			                    	<section class="label">
			                    	 	<label>Fecha inicial del contrato</label>
			                    	</section>
			                    	<section class="input">
			                    	 	<input type="text" name="fecha_inicial_contrato_ocasional" id="datepicker" class="form-control">
			                    	</section>
			                    </div>

			                    <!-- Familiar-->
		                    
			                    <div class="row mt-3 ">
			                    	<section class="label">
			                    	 	<label>¿Es un contrato familiar?</label>
			                    	</section>
			                    	<section class="input">
			                    	 	<select name="familiar" id="familiar" class="form-control" onchange="fechaFamiliar();">
			                    	 		<option value="N">NO</option>
			                    	 		<option value="S">SI</option>
			                    	 	</select>
			                    	</section>
			                    </div>

			                    <!--Fecha Final familiar-->
		                    
			                    <div class="row mt-3 " id="fecha_familiar" style="display: none;">
			                    	<section class="label">
			                    	 	<label>Fecha final del contrato</label>
			                    	</section>
			                    	<section class="input">
			                    	 	<input type="text" name="fecha_final_familiar" id="datepicker1" class="form-control">
			                    	</section>
			                    </div>



			                <!-- Valor Contrato-->

			                    <div class="row mt-3">
			                    	<section class="label">
					     	            <label>Valor del contrato</label>
					     	        </section>
				                   	<section class="input">
				                   		    <input type="number" name="valor_contrato" id="valor_contrato" class="form-control">
						     	    </section>
			                    </div>

			                <!-- TIPO CONVENIO -->
			                     <div class="row mt-3">
			                    	<section class="label">  
			                            <label>Tipo Extracto</label>
			                        </section>
				                   	<section class="input"> 
			                            <select class="form-control" name="tipo_extracto" id="tipo_extracto" onchange="tipoextracto();">
			                              <option value="" selected="selected">N/A</option>
			                              <option value="CONVENIO">CONVENIO</option>
			                              <option value="CONSORCIO">CONSORCIO</option>
			                              <option value="UNION TEMPORAL">UNION TEMPORAL</option>
			                            </select>
			                       </section>
			                    </div>
							
							<!--EXTRACTO CON-->
			                    <div class="row mt-3 mb-5" id="otros" style="display: none">
			                    	<section class="label">      
			                            <label>Con</label>
			                        </section>
				                   	<section class="input">
			                            <input type="text" class="form-control" name="extracto_con" id="extracto_con" onkeyup=""/>
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

        function ocultarRutas(){
        	var origen = document.getElementById('origen').value;
        	var destino = document.getElementById('destino').value;

        	if (destino == origen) {
        		document.getElementById('rutaUno').style.display = 'none';
        		document.getElementById('rutaDos').style.display = 'none';
        	}else{
        		document.getElementById('rutaUno').style.display = 'flex';
        		document.getElementById('rutaDos').style.display = 'flex';
        	}
        }

        function tipoextracto(){
	          var tipo_extracto = document.getElementById('tipo_extracto').value;
	          if(tipo_extracto != ''){
	            document.getElementById('otros').style.display = 'flex';
	          } else {
	            document.getElementById('otros').style.display = 'none';
	          }
        }

        function fechaFamiliar(){

	          var familiar = document.getElementById('familiar').value;
	      
	          if(familiar == 'S'){
	            document.getElementById('fecha_familiar').style.display = 'flex';
	          } else {
	            document.getElementById('fecha_familiar').style.display = 'none';
	          }
        }

        function validarDocsConductor(id_vehiculo){
              var parametros = {
                "id_vehiculo" : id_vehiculo,
              };

              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/VerificarDocConductorPorVehiculo.php',
                  type:  'post',
                  beforeSend: function () {
                  },
                  success:  function (response) {
                    
                      $("#mensaje_conductor").html(response);
                      
                      validarMensajeConds();
                  }
              });
        }

        function validarMensajeConds(){
            var mensaje = document.getElementById('verificarDocsConductor').value;

            if (mensaje == 1) {
               document.getElementById('guardar').disabled = "true";
               document.getElementById('origen').disabled = "true";
               document.getElementById('destino').disabled = "true";
               document.getElementById('id_ciudad').disabled = "true";
               document.getElementById('datepicker').disabled = "true";
               document.getElementById('datepicker1').disabled = "true";
               document.getElementById('familiar').disabled = "true";
               document.getElementById('valor_contrato').disabled = "true";
               document.getElementById('tipo_extracto').disabled = "true";
               document.getElementById('extracto_con').disabled = "true";
            }else if(mensaje == 2){
               document.getElementById('guardar').disabled = false;
               document.getElementById('origen').disabled = false;
               document.getElementById('destino').disabled = false;
               document.getElementById('id_ciudad').disabled = false;
               document.getElementById('datepicker').disabled = false;
               document.getElementById('datepicker1').disabled = false;
               document.getElementById('familiar').disabled = false;
               document.getElementById('valor_contrato').disabled = false;
               document.getElementById('tipo_extracto').disabled = false;
               document.getElementById('extracto_con').disabled = false;
            }

        }



	</script>

</body>
</html>