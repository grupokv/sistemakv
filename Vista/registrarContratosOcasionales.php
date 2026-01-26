<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");

$id_responsable = $_SESSION['id_usuario'];


if ($_SESSION['id_perfil'] == 3){	
	$redireccion = 'inicioConductores.php';
}else{
	$redireccion = 'contratosOcasionales.php';
}

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
<head><meta charset="gb18030">
    
	<title>SistemaKV | Generar Contrato Ocasional</title>
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
            <li class="breadcrumb-item " aria-current="page"><a href="contratosOcasionales.php">Contratos Ocasionales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Contrato Ocasional</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR CONTRATO OCASIONAL</b></strong>
    </div>

    <section class="form-usuarios mt-1 mb-4">
        <div class="formulario mb-3">
	        <form method="POST" action="../Controlador/registrarContraOcasional.php">
				<input type="hidden" name="id_responsable" id="id_responsable" value="<?php echo $id_responsable ?>" class="form-control">
			        	
                    <!-- Empresa-->

	                    <div class="row mt-3">
	                    	<section class="label">
			     	            <label>Empresa contratista</label>
			     	        </section>
	                    	<section class="input">
					     	    <select name="id_empresa" id="id_empresa" class="form-control selectpicker" data-live-search="true">
							        <option value="">SELECCIONAR</option>
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
							        <option value="">SELECCIONAR</option>
							        <?php foreach ($listarCl as $lcl){ ?>
							        	<option value="<?php echo $lcl['id_cliente'] ?>">
							        		<?php echo $lcl['razon_social'] ?>
							        	</option>
							        <?php } ?>
							    </select>
			     	        </section>
	                    </div>

	                <!-- OBJETO CONTRATO -->

	                    <div class="row  mt-3 ">
	                    	<section class="label">
			     	            <label>Objeto del contrato</label>
			     	        </section>
	                    	<section class="input">
					     	    <textarea name="objeto_contrato" id="objeto_contrato" class="form-control">SERVICIO DE TRANSPORTE ESPECIAL DE PASAJEROS CON GRUPO ESPECÍFICO DE USUARIOS</textarea> 
			     	        </section>
	                    </div>

				    <!-- VEHÍCULO -->

	                    <div class="row mt-3 mb-3 ">
	                    	<section class="label">
			     	            <label>Vehiculo</label>
			     	        </section>
	                    	<section class="input">
					     	    <select name="id_vehiculo" id="id_vehiculo" class="form-control selectpicker" data-live-search="true" onchange="validarDocsConductor(this.value);">
							        <option value="">SELECCIONAR</option>
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

	                <!-- OIGEN -->
	                	<div class="row mt-3" id="orig">
	                    	<section class="label">
			     	            <label>Origen</label>
			     	        </section>
	                    	<section class="input">
                                  <select class="form-control selectpicker" data-live-search="true" name="origen" id="origen">
                                      	<option value="">SELECCIONAR</option>
									 	<?php foreach ($listar as $lc){ ?>
									 		<option value="<?php echo $lc['id_ciudad'] ?>">
									 			<?php echo $lc['ciudad'] ?>
									 		</option>
									 	<?php } ?>
                                  </select>
			     	        </section>
	                    </div>

	                <!-- DESTINO -->
	                    <div class="row mt-3" id="dest">
	                    	<section class="label">
			     	            <label>Destino</label>
			     	        </section>
	                    	<section class="input">
                                    <select class="form-control selectpicker" data-live-search="true" name="destino"  id="destino">
                                      	<option value="">SELECCIONAR</option>
									 	<?php foreach ($listar as $lc){ ?>
									 		<option value="<?php echo $lc['id_ciudad'] ?>">
									 			<?php echo $lc['ciudad'] ?>
									 		</option>
									 	<?php } ?>
                                  </select>
			     	        </section>
	                    </div>

	                <!-- CIUDAD -->
	                    <div class="row mt-3">
	                    	<section class="label">
			     	            <label>Ciudad emisión del contrato</label>
			     	        </section>
	                    	<section class="input">
					     	    <select class="form-control selectpicker" data-live-search="true" name="id_ciudad" id="id_ciudad" >
								 	<option value="">SELECCIONAR</option>
								 	<?php foreach ($listar as $lc){ ?>
								 		<option value="<?php echo $lc['id_ciudad'] ?>">
								 			<?php echo $lc['ciudad'] ?>
								 		</option>
								 	<?php } ?>
								</select>
			     	        </section>
	                    </div>

	                <!-- FECHA INICIO -->
                    
	                    <div class="row mt-3 ">
	                    	<section class="label">
	                    	 	<label>Fecha inicial del contrato</label>
	                    	</section>
	                    	<section class="input">
	                    	 	<input type="text" name="fecha_inicial_contrato_ocasional" id="datepicker" class="form-control">
	                    	</section>
	                    </div>

	                    <!-- 
                    
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

                    
	                    <div class="row mt-3 " id="fecha_familiar" style="display: none;">
	                    	<section class="label">
	                    	 	<label>Fecha final del contrato</label>
	                    	</section>
	                    	<section class="input">
	                    	 	<input type="text" name="fecha_final_familiar" id="datepicker1" class="form-control">
	                    	</section>
	                    </div>
	                    -->

	                <!-- VALOR CONTRATO-->

	                    <div class="row mt-3">
	                    	<section class="label">
			     	            <label>Valor del contrato</label>
			     	        </section>
		                   	<section class="input">
		                   		    <input type="number" name="valor_contrato" id="valor_contrato" class="form-control">
				     	    </section>
	                    </div>

	                <!-- TIPO EXTRACTO -->
	                    <div class="row mt-3">
	                    	<section class="label">  
	                            <label>Tipo Extracto</label>
	                        </section>
		                   	<section class="input"> 
		                   		<input type="text" class="form-control" name="tipo_extracto" id="tipo_extracto" style="border-style: dashed;" value="N/A"  readonly="readonly">
	                       </section>
	                    </div>


		          	<section class="col-12 mt-5 mb-3 d-flex justify-content-center">
		              	<a href="<?php echo $redireccion; ?>" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
		              	<button type="submit" class="btn btn-outline-info col-3">Registrar</button>
		          	</section>

	            </form> 
        </div>
    </section>

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
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    $("#mensaje_conductor").html(response);
                    
                    var con = document.getElementById('verificarDocsConductor').value;
                    if(con >= 1){
                        $("#origen").attr("disabled","disabled");                      
                        $("#destino").attr("disabled","disabled");                      
                        $("#id_ciudad").attr("disabled","disabled");                      
                        $("#datepicker").attr("disabled","disabled");                      
                        $("#datepicker1").attr("disabled","disabled");                      
                        $("#familiar").attr("disabled","disabled");                      
                        $("#valor_contrato").attr("disabled","disabled");                      
                        $("#tipo_extracto").attr("disabled","disabled");                      
                        $("#extracto_con").attr("disabled","disabled");                      

                    }
                }
            });
        }

      



	</script>

</body>
</html>