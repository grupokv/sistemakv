<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");

$hoy = date('Y-m-d');
$contrato = new Contrato();
$vehiculo = new Vehiculo();
$empresa = new Empresa();
$cliente = new Cliente();

$listarVehiculos = $vehiculo->listarVehiculosVinculados();

$listarC = $contrato->listarContratosHabiles($hoy);

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Activar Aval</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
	<!-- STYLES -->
	    <?php include("Template/styles.php"); ?>
	    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
	<!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->

	    <section class="home_content"> 

			<div aria-label="breadcrumb" class="mt-1"> 
		         <ol class="breadcrumb" style="background-color: #fff;">
		            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
		            <li class="breadcrumb-item " aria-current="page"><a href="avalVehiculosCartera.php">Avales</a></li>
		            <li class="breadcrumb-item active" aria-current="page">Activar Aval</li>
		         </ol>
		    </div>

	        <div class="notice notice-sistemakv">
	            <strong><i class="fa fa-server mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTIVAR AVAL</b></strong>
	        </div>

		    <section class="form-usuarios mt1">
		        <div class="formulario mb-5">

		            <form action="../Controlador/activarCobroAval.php" method="POST">
							        
						<!-- TIPO ACTIVACIÓN -->
						    <div class="row mt-3 mb-4">
						        <div class="label">
						            <label>Activar el cobro del aval por</label>
						        </div>
						        <div class="input">
						      		<select class="form-control form-control-sm selectpicker" data-live-search="true" name="opcion_activacion" id="opcion_activacion" onchange="validarOpcion(this.value);" title="SELECCIONAR">
						        		<option value="1">VEHICULO(S) EN ESPECÍFICO</option>
						        		<option value="2">CONTRATO</option>
						        		
						      		</select>
						        </div>
						    </div>

						<!--VEHICULO-->
						    <div class="row mt-3 mb-4" id="Vehiculo" style="display: none;">
						        <div class="label">
						            <label>Vehiculo</label>
						        </div>
						        <div class="input">
						      		<select class="form-control form-control-sm selectpicker" title="SELECCIONAR" data-live-search="true" multiple="multiple" name="id_vehiculo[]" id="id_vehiculo">
						        		<?php foreach ($listarVehiculos as $lv){ ?>
						        			<option value="<?php echo $lv['id_vehiculo']; ?>"><?php echo $lv['placa'] . ' | ' . $lv['numero_movil'];  ?></option>
						        		<?php } ?>
						      		</select>
						        </div>
						    </div>

						<!--CONTRATO-->
						    <div class="row mt-3 mb-4">
						        <div class="label">
						            <label>Contrato</label>
						        </div>
						        <div class="input">
						      		<select class="form-control form-control-sm selectpicker" title="SELECCIONAR" data-live-search="true" name="id_contrato" id="id_contrato">
						        		<?php foreach ($listarC as $lc){ ?>
	                                        <option value="<?php echo $lc['id_contrato']; ?>">
	                                            <?php
		                                            $emp = $empresa->listarPorId($lc['id_empresa']);
		                                            $cli = $cliente->listarClientePorId($lc['id_cliente']);
		                                            echo "CONTRATO N° " . $lc['id_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa']; 
		                                        ?>
	                                        </option>           
	                                    <?php } ?>
						      		</select>
						        </div>
						    </div>

						<!-- TIPO ACTIVACIÓN -->
						    <div class="row mt-3 mb-4" id="mesActivacion">
						        <div class="label">
						            <label>Activación</label>
						        </div>
						        <div class="input">
						      		<select class="form-control form-control-sm selectpicker" title="SELECCIONAR" data-live-search="true" name="activacion" id="activacion">
						        		<option value="IC">INICIO DEL CONTRATO</option>
						        		<option value="ME">A PARTIR DE UN MES EN ESPECÍFICO</option>
						      		</select>
						        </div>
						    </div>

						<!-- MES -->
						<div class="row mt-3" id="mesEspecifico" style="display: none;">
								<div class="label">
									<label>Mes</label>
								</div>
								<div class="input">
								    <input type="text" onfocusout="validarMesesDeActivacion();" class="form-control form-control-sm" name="mes_especifico" id="mes_especifico">
								</div>
						    </div>


						<!--FECHA -->
							<div class="row mt-3" id="mes" style="display: none;">
								<div class="label">
									<label>Mes(es) a Activar</label>
								</div>
								<div class="input" id="mesesAval">
								    
								</div>
						    </div>

						<!--VALOR -->
							<div class="row mt-3" id="Valor" style="display: none;">
								<div class="label">
									<label>Valor</label>
								</div>
								<div class="input">
								    <input type="text" name="valor_aval" id="valor_aval" class="form-control form-control-sm">
								</div>
						    </div>

						<!-- BOTONES -->
	                        
	                        <section class="col-12 mt-5 d-flex justify-content-center">
	                              
	                            <!-- CANCELAR REGISTRO -->
	                                <a href="avalVehiculosCartera.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
	                              
	                            <!-- REGISTRAR -->
	                                <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Registrar</button>
	                          
	                        </section>
	                        
		            </form>
		        </div>
		    </section>
		</section>

	<!-- FIN CONTENIDO -->

    <!--**************************--->

	<!-- STYLES -->

	    <?php include("Template/scripts.php"); ?>

	    <script>

		  	$('#valor_aval').keypress(function (tecla) {
	            if (tecla.charCode < 48 || tecla.charCode > 57) return false;
	        });

	        $("#mes_especifico").MonthPicker({
			    i18n: {
			        months: ["Enero", "Feb", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agos", "Sept", "Oct","Nov", "Dic"],
			        buttonText: "",
			    }
		    });

			function validarMesesDeActivacion(){
				const id_contrato = $("#id_contrato").val();
				const mes_especifico = $("#mes_especifico").val();
				const activacion = $("#activacion option:selected").val();

				const parametros = {
					"id_contrato" : id_contrato,
					"tipo_activacion" : activacion,
					"mes_especifico" : mes_especifico
				};

				$.ajax({
					data:  parametros,
					url:   '../Controlador/validarMesesContratoAval.php',
					type:  'POST',
					beforeSend: function () {
						$("#mesesAval").html("<i class='fa fa-spinner fa-pulse' aria-hidden='true'></i> Validando Meses del Contrato");
					},
					success:  function (response) {
						//alert(response);
						$("#mesesAval").html(response);
					}
				});
			}

			$("#activacion").change(function() {
				const mes_especifico = $("#mes_especifico").val();

				if(this.value == 'ME'){
					$("#mesEspecifico").css('display', 'flex');
					$("#mesesAval").empty("");
				}else{
					$("#mesEspecifico").css('display', 'none');
					$("#mes_especifico").val("");
					$("#mesesAval").empty("");
					if(this.value == 'IC'){
						validarMesesDeActivacion();
					}
				}
			});

	    	function validarOpcion(value){
	    		if(value == 1){
	    			document.getElementById('Vehiculo').style.display = 'flex';
	    			document.getElementById('mes').style.display = 'flex';
	    			document.getElementById('Valor').style.display = 'flex';

	    			document.getElementById('valor_aval').value = '';
	    			document.getElementById('activacion').value = '';
	    		}else if(value == 2){
	    			document.getElementById('Vehiculo').style.display = 'none';
	    			document.getElementById('mes').style.display = 'flex';
	    			document.getElementById('Valor').style.display = 'flex';

	    			document.getElementById('valor_aval').value = '';
	    			document.getElementById('activacion').value = '';
	    		}else{
	    			document.getElementById('Vehiculo').style.display = 'none';
	    			document.getElementById('mes').style.display = 'none';
	    			document.getElementById('Valor').style.display = 'none';

	    			document.getElementById('valor_aval').value = '';
	    			document.getElementById('activacion').value = '';
	    		}
	    	}

	    </script>

	<!-- FIN STYLES -->

</body>
</html>

