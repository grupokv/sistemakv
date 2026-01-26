<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Cliente-Convenio.php");

/* VARIABLES MENU*/
$titulo = 'Gerenciamiento de Viaje';
$redireccion = 'serviciosAsignadosConductor.php';
$icono = 'fa fa-file-text-o';

$empresa = new Empresa();
$listarE = $empresa->listar();

$vehiculo = new Vehiculo();
$listarV = $vehiculo->listar();

$ciudad = new Ciudad();
$listarC = $ciudad->listar();

$cliente = new Cliente_Convenio();
$listarCl = $cliente->listar();

$hoy = date('Y-m-d');
$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$fecha2 = date('Y-m-d',$fecha2);

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV |Gerenciamiento de Viajes</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
   
</head>
<body>



    <?php include("Template/menu.php"); ?>

    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Gerenciamiento de Viajes</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/registrarConve.php" class="p-2">	
			        <?php include("Template/header-form.php"); ?> 

	                   

		                <!--  INFORMACIÓN GENERAL DEL CONDUCTOR -->
                          	<table class="table mt-4">
                              	<thead>
                                  	<tr class="text-center">
                                    	<th width="100%" style="border: 0"> INFORMACIÓN GENERAL DEL CONDUCTOR</th>
                                  	</tr>
                              	</thead>
                          	</table>

                          	<table class="table">
                              	<tbody>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> La categoría de la licencia de conducción corresponde con el tipo de servicio del vehículo a conducir <b>?</b> </td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> Tiene toda la documentación requerida y vigente para la realización del viaje <b>?</b> </td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> La condición de salud actual le permite desarrollar el viaje con seguridad <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> Conoce las condiciones de la ruta por la que debe transitar <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> El resultado de la prueba de alcoholimetría es <b>NEGATIVA ?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> Las condiciones de seguridad física, el clima y el estado de la vía fueron validados por centro de control <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> Cuenta con un sistema de comunicación mediante el cual pueda generar llamadas <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>

	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> El pernocto se dio en el origen del viaje <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>

	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> El desplazamiento se desarrollará en horario permitido por la organización <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>

	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> El conductor es consiente que el desplazamiento a realizar se da bajo las medidas de seguridad pertinentes, sin presión alguna para el cumplimiento del mismo y es para cumplir un objetivo organizacional <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>

	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> Después de realizar la inspección pre operacional encuentra que el vehículo esta en optimas condiciones <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>



	                            </tbody>
	                        </table>

		               
		                <!-- CONDICIONES DE SALUD ANTES DE INICIO DEL VIAJE -->
                          	<table class="table mt-4 mb-4">
                              	<thead>
                                  	<tr class="text-center">
                                    	<th width="100%" style="border: 0"> CONDICIONES DE SALUD ANTES DE INICIO DEL VIAJE</th>
                                  	</tr>
                              	</thead>
                          	</table>

                          	<table class="table">
                              	<tbody>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> El conductor está consumiendo algún medicamento que afecte los sentidos <b>?</b> </td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> El conductor presenta algún trastorno de ansiedad o depresión <b>?</b> </td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> El conductor presenta algún  trastorno neurológico (mareo, vértigo) <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td style="border: 0px"><b>¿</b> El conductor presenta trastornos  visuales (Visión borrosa, dificultad para ver bien) <b>?</b></td>
	                                    <td style="border: 0px" class="d-flex justify-content-end">
	                                        <label class="switch">
	                                            <input type="checkbox" name="categoriaLicencia" id="categoriaLicencia" value="C">
	                                            <span class="slider"></span>
	                                        </label>
	                                    </td>
	                                </tr>
	                                
	                            </tbody>
	                        </table>

		               
		                <!-- CONDICIONES PARA EL ANALISIS DE RIESGOS -->

                          	<table class="table mt-4 mb-4">
                              	<thead>
                                  	<tr class="text-center">
                                    	<th width="100%" style="border: 0"> CONDICIONES PARA EL ANALISIS DE RIESGOS</th>
                                  	</tr>
                              	</thead>
                          	</table>

                          	<table class="table">
                              	<tbody>
	                                <tr>
	                                    <td width="50%"  style="border: 0px">Distancia desde Origen</td>
	                                    <td width="100%"  style="border: 0px" class="d-flex justify-content-end">
								     	    <select name="distancia_desde_origen" id="distancia_desde_origen" class="form-control">
								     	    	<option value="">SELECCIONAR</option>
										        <option value="1">Menos de 50 Km</option>
										        <option value="2">Menos de 100 Km</option>
										        <option value="5">Menos de 200 Km</option>
										        <option value="8">Mas de 200 Km</option>
										        
										    </select>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td width="50%"  style="border: 0px">Clima</td>
	                                    <td width="100%"  style="border: 0px" class="d-flex justify-content-end">
								     	    <select name="clima" id="clima" class="form-control">
								     	    	<option value="">SELECCIONAR</option>
										        <option value="1">Seco</option>
										        <option value="2">Viento</option>
										        <option value="4">Lluvia</option>
										        <option value="8">Lluvia con Tormenta</option>
										        
										    </select>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td width="50%" style="border: 0px">Vehiculo y Personas</td>
	                                    <td width="100%"  style="border: 0px" class="d-flex justify-content-end">
								     	    <select name="vehiculos_personas" id="vehiculos_personas" class="form-control">
								     	    	<option value="">SELECCIONAR</option>
										        <option value="8">2+ vehículos con 2+ personas por vehículo</option>
										        <option value="5">2+ vehículos con 1 persona por vehículo</option>
										        <option value="2">1 vehículo con 2 o mas personas</option>
										        <option value="1">1 vehículo con 1 persona</option>
										        
										    </select>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td width="50%"  style="border: 0px">Condiciones de la Ruta</td>
	                                    <td width="100%"  style="border: 0px" class="d-flex justify-content-end">
								     	    <select name="condiciones_ruta" id="condiciones_ruta" class="form-control">
								     	    	<option value="">SELECCIONAR</option>
										        <option value="1">Pavimentada</option>
										        <option value="2">Mista (50% Pavimentada)</option>
										        <option value="4">No Pavimentada</option>
										    </select>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td width="50%"  style="border: 0px">Comunicación Disponible</td>
	                                    <td width="100%"  style="border: 0px" class="d-flex justify-content-end">
								     	    <select name="comunicacion_disponible" id="comunicacion_disponible" class="form-control">
								     	    	<option value="">SELECCIONAR</option>
										        <option value="0">Teléfono celular o sat / radio</option>
										        <option value="2">Sin comunicación en grupo</option>
										        <option value="4">Sin comunicación y sin grupo</option>
										    </select>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td width="50%"  style="border: 0px">Hrs Trabajadas + Tiempo de viaje</td>
	                                    <td width="100%"  style="border: 0px" class="d-flex justify-content-end">
								     	    <select name="hrs_trabajo" id="hrs_trabajo" class="form-control">
								     	    	<option value="">SELECCIONAR</option>
										        <option value="1">Hs. Trabajadas + hs. previstas de viaje <12 hs</option>
										        <option value="3">Hs. Trabajadas + hs. previstas de viaje entre 12hs y 14 hs.</option>
										        <option value="6">Hs. Trabajadas + hs. previstas de viaje entre 14 hs y 16 hs.</option>
										    </select>
	                                    </td>
	                                </tr>
	                                
	                            </tbody>
	                        </table>

	                        <div class="d-flex justify-content-center mt-5 p-4">
		                        <table class="table">
		                        	<thead>
		                        		<tr>
	                                        <th colspan="3" style="border: 0px; text-align:center">TOTAL DE ANALISIS DE RIESGO: </th>
	                                    </tr>
		                        		<tr class="text-center">
			                        		<th width="20%" style="border: 0px">RIESGO</th>
			                        		<th width="20%" style="border: 0px">RANGO</th>
			                        		<th width="60%" style="border: 0px">AUTORIZACIÓN REQUERIDA</th>
		                        		</tr>
		                        	</thead>
		                        	<tbody>

		                        		<tr class="text-center" id="rango1" style="display: none;">
		                        			<td style="background: #6ab053; color: #fff; border: 3px solid #fff"><b>RIESGO 1</b></td>
		                        			<td style="background: #6ab053; color: #fff; border: 3px solid #fff"><b>Mayor o igual a 12</b></td>
		                        			<td style="background: #6ab053; color: #fff; border: 3px solid #fff;">Requiere autorización del Coordinador de Logística (o quien haga sus veces dentro de la organización)</td>
		                        		</tr>

		                        		<tr class="text-center" id="rango2" style="display: none;">
		                        			<td style="background: #f2ef4b; color: #fff; border: 3px solid #fff"><b>RIESGO 2</b></td>
		                        			<td style="background: #f2ef4b; color: #fff; border: 3px solid #fff"><b>13 A 18</b></td>
		                        			<td style="background: #f2ef4b; color: #fff; border: 3px solid #fff;">Requiere autorización del Coordinador de Logística y Encargado de SST (o quien haga sus veces dentro de la organización)</td>
		                        		</tr>

		                        		<tr class="text-center" id="rango3" style="display: none;">
		                        			<td style="background: #e6413e; color: #fff; border: 3px solid #fff"><b>RIESGO 3</b></td>
		                        			<td style="background: #e6413e; color: #fff; border: 3px solid #fff"><b> Mayor 18</b></td>
		                        			<td style="background: #e6413e; color: #fff; border: 3px solid #fff; ">Requiere autorización de la Gerencia.</td>
		                        		</tr>
		                        	</tbody>
		                        </table>
	                        </div>
		               
           					
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

        
	$('select').on('click', function(){
    
     	resultado = 0;

     	$('select').each(function(){   
       		resultado += ($(this).val())*1
      	});

     	if (resultado <= 12) {
     		document.getElementById('rango1').style.display = 'none';
     		alert(resultado);
     	}

    });
    
	</script>
	
</body>
</html>