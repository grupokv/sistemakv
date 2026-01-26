<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Cliente-Convenio.php");
require_once("../Modelo/Convenio.php");

/* VARIABLES MENU*/
$titulo = 'Actualizar Convenios';
$redireccion = 'convenios.php';
$icono = 'fa fa-file-text-o';

$id_convenio = $_GET['id_convenio'];

$empresa = new Empresa();
$listarE = $empresa->listar();
//print_r($listarE);

$vehiculo = new Vehiculo();
$listarV = $vehiculo->listar();

$ciudad = new Ciudad();
$listarC = $ciudad->listar();

$cliente = new Cliente_Convenio();
$listarCl = $cliente->listar();

$convenio = new Convenio();
$listarConvenioPorId = $convenio->listarId($id_convenio);
//print_r($listarConvenioPorId);

$hoy = date('Y-m-d');
$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$fecha2 = date('Y-m-d',$fecha2);

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Convenio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
   
</head>
<body>



    <?php include("Template/menu.php"); ?>

    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="convenios.php">Convenios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Convenio</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/actualizarCargarConvenio.php" enctype="multipart/form-data">	
			        <?php include("Template/header-form.php"); ?> 
						<?php foreach ($listarConvenioPorId as $lcpi){ ?>

							<!-- Id Convenio -->
								<input type="hidden" name="id_convenio" id="id_convenio" value="<?php echo $lcpi['id_convenio']; ?>">

							<!-- Fecha Creacion Convenio -->
								<input type="hidden" name="fecha_creacion_convenio" id="fecha_creacion_convenio" value="<?php echo $lcpi['fecha_creacion_convenio']; ?>">

							<!-- Hora Creacion Convenio-->
								<input type="hidden" name="hora_creacion_convenio" id="hora_creacion_convenio" value="<?php echo $lcpi['hora_creacion_convenio']; ?>">

							<!-- Responsable-->
								<input type="hidden" name="id_responsable" id="id_responsable" value="<?php echo $lcpi['id_responsable']; ?>">

							<!-- Documento-->
		
			                    <div class="row mt-5">
			                    	<section class="label">
					     	            <label>Fotocopia del convenio</label>
					     	        </section>
			                    	<section class="input">
							     	    <input type="file" name="doc_convenio"  id="doc_convenio" class="form-control" >
							     	    <input type="hidden" name="act_doc_convenio"  id="act_doc_convenio" class="form-control" value="<?php echo $lcpi['doc_convenio']; ?>" >

						     	        <?php if ($lcpi['doc_convenio'] == '') { ?>
			        	                        <label class="mt-2 ml-5 mb-2" for="act_doc_convenio"><strong>Documento Actual: </strong> No hay documentos cargados</label>
			        	                <?php } else{ ?>
			        	                        <label class="mt-2 ml-5 mb-2" for="act_doc_convenio"><strong>Documento Actual: </strong> <?php echo $lcpi['doc_convenio'] ?></label>
			        	                <?php }  ?>
					     	        </section>
			                    </div>

							<!-- Empresa-->

			                    <div class="row mt-3">
			                    	<section class="label">
					     	            <label>Empresa Contratista</label>
					     	        </section>
			                    	<section class="input">
							     	    <select name="id_empresa" id="id_empresa" class="form-control">
									        <option value="">SELECCIONAR</option>
									        <?php foreach ($listarE as $le){ ?>
									        	<option value="<?php echo $le['id_empresa'] ?>" <?php if($lcpi['id_empresa'] == $le['id_empresa']){ ?> selected="selected" <?php } ?> >
									        		<?php echo $le['nombre_empresa']; ?>
									        	</option>
									        <?php } ?>
									    </select>
					     	        </section>
			                    </div>

							<!-- Cliente-->

			                    <div class="row  mt-3">
			                    	<section class="label">
					     	            <label>Empresa Colaboradora</label>
					     	        </section>
			                    	<section class="input">
							     	    <select name="id_cliente" id="id_cliente"  class="form-control">
									        <option>Seleccionar</option>
									        <?php foreach ($listarCl as $lcl){ ?>
									        	<option value="<?php echo $lcl['id_cliente'] ?>" <?php if($lcpi['id_cliente'] == $lcl['id_cliente']){ ?> selected = "selected" <?php } ?>>
									        		<?php echo $lcl['razon_social'];
									        		 ?>
									        	</option>
									        <?php } ?>
									    </select>
					     	        </section>
			                    </div>

			                <!-- Ciudad -->

			                    <div class="row mt-3">
			                    	<section class="label">
					     	            <label>Ciudad del Convenio</label>
					     	        </section>
			                    	<section class="input">
							     	    <select name="id_ciudad_convenio" id="id_ciudad_convenio" class="form-control">
									        <option>Seleccionar</option>
									        <?php foreach ($listarC as $lc){ ?>
									        	<option value="<?php echo $lc['id_ciudad'] ?>" <?php if($lcpi['id_ciudad_convenio'] == $lc['id_ciudad']) { ?> selected = "selected" <?php } ?>>
									        		<?php echo $lc['ciudad'] ?>
									        	</option>
									        <?php } ?>
									    </select>
									</section>
			                    </div>

			                <!-- Vehiculo -->

			                    <div class="row mt-3 mb-3" id="vehiculo">
			                    	<section class="label">
					     	            <label>Vehiculo</label>
					     	        </section>
			                    	<section class="input">
							     	    <select name="id_vehiculo" id="id_vehiculo"  class="form-control" onchange="listarConductoresPorVehiculo(this.value, 0); listarContratosPorVehiculo(this.value, 0);">
									        <option>Seleccionar</option>
									        <?php foreach ($listarV as $lv){ 

												$documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
												if (count($documentosvencidosPorId)>0) {?>
													<option value="<?php echo $lv['id_vehiculo'] ?>"disabled style="color:red;font-weight:bolder" <?php if($lcpi['id_vehiculo'] == $lv['id_vehiculo']) { ?> selected="selected" <?php } ?>>
									        			<?php echo $lv['placa'] ?>
									        		</option>
												<?php } else { ?>
													<option value="<?php echo $lv['id_vehiculo'] ?>" <?php if($lcpi['id_vehiculo'] == $lv['id_vehiculo']) { ?> selected="selected" <?php } ?>>
									        			<?php echo $lv['placa'] ?>
									        		</option>
												<?php } ?>
									        	
									        <?php } ?>
									    </select>
					     	        </section>
			                    </div>

			                <!-- Conductor -->

			                    <div class="row mt-3 mb-3" id="conductor">
			                    	<section class="label">
					     	            <label>Conductores del vehiculo</label>
					     	        </section>
			                    	<section class="input">
							     	    <select name="id_conductor" id="id_conductor" class="form-control" >
									    </select>
					     	        </section>
			                    </div>

		                	<!-- Contratos -->

			                    <div class="row mt-3 mb-3" id="contratos">
			                    	<section class="label">
					     	            <label>Contratos del vehiculo</label>
					     	        </section>
			                    	<section class="input">
							     	    <select name="id_contrato" id="id_contrato" class="form-control"  >
									        <option value="0">Seleccionar</option>
									    </select>
					     	        </section>
			                    </div>

			                <!--Fecha Inicio-->
	                    
			                    <div class="row mt-3">
			                    	<section class="label">
			                    	 	<label>Desde: </label>
			                    	</section>
			                    	<section class="input">
			                    	 	<input type="text" name="fecha_inicio_convenio" id="datepicker" class="form-control" value="<?php echo $lcpi['fecha_inicio_convenio']; ?>">
			                    	</section>
			                    </div>

	     	   				<!--Fecha final-->

			     	   			<div class="row mt-3 mb-5	">
			                    	<section class="label">
			     	                    <label>Hasta: </label>
			     	                </section>
			                    	<section class="input">
			     	                    <input type="text" name="fecha_final_convenio" id="datepicker1" class="form-control" value="<?php echo $lcpi['fecha_final_convenio'] ?>">
			     	                </section>
			                    </div>


						<?php } ?>

                        <hr>
            
                        <!--Botones-->

					       
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

        function listarConductoresPorVehiculo(id_vehiculo, id_conductor){
        	//alert(id_vehiculo);
            var parametros = {
                "id_vehiculo" : id_vehiculo,
                "id_conductor" : id_conductor
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarConductoresVehiculo.php',
                type: 'post',
                beforeSend: function () {
                	$("#id_conductor").html('<option value=""> Cargando Conductores</option>');
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        //alert(response);
                        $("#id_conductor").html(response);
                }
            })

        }

        function listarContratosPorVehiculo(id_vehiculo, id_contrato){
        	//alert(id_vehiculo);
            var parametros = {
                "id_vehiculo" : id_vehiculo,
                "id_contrato" : id_contrato

            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarContratosVehiculo.php',
                type: 'POST',
                beforeSend: function () {
                	$("#id_contrato").html('<option value=""> Cargando Contratos</option>');
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    //alert(response);
                    $("#id_contrato").html(response);
                }
            })

        }

        listarConductoresPorVehiculo(<?php echo $listarConvenioPorId[0]['id_vehiculo']; ?>, <?php echo $listarConvenioPorId[0]['id_conductor']; ?>);
        listarContratosPorVehiculo(<?php echo $listarConvenioPorId[0]['id_vehiculo']; ?>, <?php echo $listarConvenioPorId[0]['id_contrato']; ?>);
	</script>
	
</body>
</html>