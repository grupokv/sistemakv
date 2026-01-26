<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/ReferenciasPropietarioVehiculo.php");
require_once '../Modelo/SeguimientoActualizacion.php';
require_once("../Modelo/FotografiaVehiculo.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicio.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");

$ciudad = new Ciudad();
$ciudades = $ciudad->listar();

if ($_SESSION['id_perfil'] == 3) {
	$titulo = 'Actualizar Vehiculos';
	$redireccion = 'inicioConductores.php';
	$icono = 'fa fa-car';
} else if ($_SESSION['id_perfil'] == 2) {
	$titulo = 'Actualizar Vehiculos';
	$redireccion = 'inicioPropietarios.php';
	$icono = 'fa fa-car';
} else if ($_SESSION['id_perfil'] == 8) {
	$titulo = 'Actualizar Vehiculos';
	$redireccion = 'inicioPropietarios.php';
	$icono = 'fa fa-car';
} else{
	$titulo = 'Actualizar Vehiculos';
	$redireccion = 'vehiculos.php';
	$icono = 'fa fa-car';
}
                                           	
$id_vehiculo = $_GET['id_vehiculo'];

	$vehiculoContrato = new Vehiculo_Contrato();
	$listarContratosApoyo = $vehiculoContrato->listarContratosApoyo($id_vehiculo); 

	$contratos = array();
	foreach ($listarContratosApoyo as $lca) {
	    array_push($contratos, $lca['id_contrato']);
	}


$hoy = date('Y-m-d');

$fecha = strtotime('+3 days',strtotime(date('Y-m-d')));
$plazoVencimiento = date('Y-m-d',$fecha);

$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$plazoVencimiento2 = date('Y-m-d',$fecha2);


$tipoVehiculo = new TipoVehiculo();
$listarTV = $tipoVehiculo->listar();


$tipoServicio = new TipoServicio();
$listarTS = $tipoServicio->listar();


$contrato = new Contrato();
$listarC = $contrato->listarContratosHabiles($hoy);

$empresa = new Empresa();
$listadoEmpresas = $empresa->listar();

$cliente = new Cliente();

$referenciasPropietario = new ReferenciasPropietario();

//COMERCIAL
$listarPorTipoReferenciaComercial = $referenciasPropietario->listarPorTipoReferenciaComercial($id_vehiculo);
$comercial = count($listarPorTipoReferenciaComercial);

//FAMILIAR
$listarPorTipoReferenciaFamiliar = $referenciasPropietario->listarPorTipoReferenciaFamiliar($id_vehiculo);
$familiar = count($listarPorTipoReferenciaFamiliar);

//LABORAL
$listarPorTipoReferenciaLaboral = $referenciasPropietario->listarPorTipoReferenciaLaboral($id_vehiculo);
$laboral = count($listarPorTipoReferenciaLaboral);

//PERSONAL
$listarPorTipoReferenciaPersonal = $referenciasPropietario->listarPorTipoReferenciaPersonal($id_vehiculo);
$personal = count($listarPorTipoReferenciaPersonal);

$fotografiaVehiculo = new FotografiaVehiculo();
$listarFotografiasId = $fotografiaVehiculo->listarPorIdVehiculo($id_vehiculo);

if (!isset($id_vehiculo)) {
	
}else{
  	$vehiculo = new Vehiculo();
  	$listarVehiId = $vehiculo->listarPorId($id_vehiculo);

  	$usuario = new Usuario();
  	$listarPropietariosPorId = $usuario->listarPropietariosPorId($listarVehiId[0]['id_propietario']);
  	/*print_r($listarPropietariosPorId);*/
										
   	$listContrato = $vehiculo->listarContratoPorVehiculo($id_vehiculo);
   	if(count($listContrato) > 0){
   		$contratoid = $listContrato[0]['id_contrato'];
   	} else {
   		$contratoid = 0;
   	}
}

$id = $listarVehiId[0]['placa'];

$link = 'http://www.sistemakv.com/Documentos/Vehiculos/'.$id.'/';

$id_modulo = "11";

$seguimiento = new Seguimiento_Actualizacion();
$listarPorUsuarioSolicitante = $seguimiento->listarPorUsuarioSolicitante($_SESSION['id_usuario'], $id_modulo);

foreach ($listarPorUsuarioSolicitante as $lpussa) {
	$columnas = explode(" | ", $lpussa['columnas']);
	$nombre_documento = $columnas[0];
	if (($nombre_documento == 'tarjeta_operacion') && ($lpussa['estado'] == 'P')) {
		$TO = 1;
	} else if (($nombre_documento == 'licencia_transito') && ($lpussa['estado'] == 'P')) {
		$LT = 1;
	} else if (($nombre_documento == 'soat') && ($lpussa['estado'] == 'P')) {
		$SOAT = 1;
	} else if (($nombre_documento == 'revision_tecnomecanica') && ($lpussa['estado'] == 'P')) {
		$RT = 1;
	} else if (($nombre_documento == 'revision_preventiva') && ($lpussa['estado'] == 'P')) {
		$RP = 1;
	} else if (($nombre_documento == 'poliza_contra') && ($lpussa['estado'] == 'P')) {
		$PC = 1;
	} else if (($nombre_documento == 'poliza_extra') && ($lpussa['estado'] == 'P')) {
		$PE = 1;
	} else if (($nombre_documento == 'disp_velocidad') && ($lpussa['estado'] == 'P')) {
		$DV = 1;
	} else if (($nombre_documento == 'contrato_vinculacion') && ($lpussa['estado'] == 'P')) {
		$CV = 1;
	} else if (($nombre_documento == 'ficha_tecnica_homologacion') && ($lpussa['estado'] == 'P')) {
		$FTH = 1;
	} else if (($nombre_documento == 'seguro_todo_riesgo') && ($lpussa['estado'] == 'P')) {
		$STR = 1;
	} else if (($nombre_documento == 'fotografia_frontal') && ($lpussa['estado'] == 'P')) {
		$FF = 1;
	} else if (($nombre_documento == 'fotografia_trasera') && ($lpussa['estado'] == 'P')) {
		$FT = 1;
	} else if (($nombre_documento == 'fotografia_lateral_izq') && ($lpussa['estado'] == 'P')) {
		$FLI = 1;
	} else if (($nombre_documento == 'fotografia_lateral_der') && ($lpussa['estado'] == 'P')) {
		$FLD = 1;
	} else if (($nombre_documento == 'camara_comercio') && ($lpussa['estado'] == 'P')) {
		$CC = 1;
	} else if (($nombre_documento == 'contrato_banco') && ($lpussa['estado'] == 'P')) {
		$CB = 1;
	} else if (($nombre_documento == 'hoja_vida') && ($lpussa['estado'] == 'P')) {
		$HV = 1;
	} else if (($nombre_documento == 'rut') && ($lpussa['estado'] == 'P')) {
		$RUT = 1;
	} else if (($nombre_documento == 'poder_apoderado') && ($lpussa['estado'] == 'P')) {
		$PA = 1;
	}else{
		$TO = 0;
		$LT = 0;
		$SOAT = 0;
		$RT = 0;
		$RP = 0;
		$PC = 0;
		$PE = 0;
		$DV = 0;
		$CV = 0;
		$FTH = 0;
		$STR = 0;
		$FF = 0;
		$FT = 0;
		$FLI = 0;
		$FLD = 0;
		$CC = 0;
		$CB = 0;
		$HV = 0;
		$RUT = 0;
		$PA = 0;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Vehiculo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
  	<link rel="stylesheet" href="../Resources/css/stylesHeader.css">

  	<style type="text/css">
  		.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
            background: #5e99b1 !important;
            border: #fff;
        }
  	</style>
	
</head>
<body>

  	<!--MENU-->
      	<?php include("Template/header.php"); ?>
      	<?php include("Template/newMenu.php"); ?>
  	<!--FIN MENU-->


<section class="home_content">

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb" style="background-color: #FFF;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="vehiculos.php">Vehiculos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar vehiculo</li>
         </ol>
    </div>
	
	<div class="notice notice-sistemakv">
          <strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZACIÓN DE VEHÍCULO - <?php echo $id ?></b></strong>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
        	
	        <form action="../Controlador/seguimientoActualizacionesDocsVehiculo.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()" class="p-4">

                <?php foreach ($listarVehiId as $lvi){ ?>

          	        <input type="hidden" name="id_vehiculo" id="id_vehiculo" class="form-control" value="<?php echo $lvi['id_vehiculo'] ?>" >
					<input type="hidden" name="estado" id="estado" class="form-control" value="<?php echo $lvi['estado'] ?>">
					<input type="hidden" name="id_propietario" id="id_propietario" class="form-control" value="<?php echo $lvi['id_propietario'] ?>">
					<input type="hidden" name="placa" id="placa" class="form-control" value="<?php echo $id ?>">

			        <div id="tabs" class="mt-3">

	                    <ul>
	                      	<li>
	                      		<a href="#tabs-2"><b>Documentación</b></a>
	                      	</li>
                          	<li>
                          		<a href="#tabs-3"><b>Fotos del vehiculo</b></a>
                          	</li>
                          	<li>
                          		<a href="#tabs-4"><b>Propietario</b></a>
                          	</li>
                          	<li>
                          		<a href="#tabs-5"><b>Referencias del Propietario</b></a>
                          	</li>
                      	</ul>

	                    <!--DOCUMENTACION-->

	                        <div id="tabs-2">

	                        	<!-- TARJETA DE OPERACIÓN -->
		                        	<?php if ($lvi['fecha_vencimiento_to'] <= date('Y-m-d')){ ?>
		                        		<?php if ($TO == 1){ ?>
		                        			<div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Tarjeta de Operación</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="file" name="tarjeta_operacion"  id="tarjeta_operacion" class="form-control" disabled>
						       				                <input type="hidden" name="act_tarjeta_operacion"  id="act_tarjeta_operacion" class="form-control" value="<?php echo $lvi['tarjeta_operacion'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="text" name="fecha_vencimiento_to" id="datepicker" class="form-control" value="<?php echo $lvi['fecha_vencimiento_to'] ?>"  disabled>
						       				                <input type="hidden" name="act_fecha_vencimiento_to" id="datepicker" class="form-control" value="<?php echo $lvi['fecha_vencimiento_to'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
		                        		<?php } else { ?>
						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Tarjeta de Operación</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="file" name="tarjeta_operacion"  id="tarjeta_operacion" class="form-control">
						       				                <input type="hidden" name="act_tarjeta_operacion"  id="act_tarjeta_operacion" class="form-control" value="<?php echo $lvi['tarjeta_operacion'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="text" name="fecha_vencimiento_to" id="datepicker" class="form-control" value="<?php echo $lvi['fecha_vencimiento_to'] ?>" >
						       				                <input type="hidden" name="act_fecha_vencimiento_to" id="datepicker" class="form-control" value="<?php echo $lvi['fecha_vencimiento_to'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
					                	<?php } ?>
					                <?php } else if (($lvi['fecha_vencimiento_to'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_to'] > date('Y-m-d'))){ ?>
					                    <div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Tarjeta de Operación</label>
					       			                </div>
					       			                <div class="input">
					       				                <input  style="border: 2px solid orange;" type="file" name="tarjeta_operacion"  id="tarjeta_operacion" class="form-control">
					       				                <input type="hidden" name="act_tarjeta_operacion"  id="act_tarjeta_operacion" class="form-control" value="<?php echo $lvi['tarjeta_operacion'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="text" name="fecha_vencimiento_to" id="datepicker" class="form-control" value="<?php echo $lvi['fecha_vencimiento_to'] ?>" >
					       				                <input type="hidden" name="act_fecha_vencimiento_to" id="datepicker" class="form-control" value="<?php echo $lvi['fecha_vencimiento_to'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
					                
		                        	<?php }else{ ?>
					                    <div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Tarjeta de Operación</label>
					       			                </div>
					       			                <div class="input">
					       				                <input  type="file" name="tarjeta_operacion"  id="tarjeta_operacion" class="form-control">
					       				                <input type="hidden" name="act_tarjeta_operacion"  id="act_tarjeta_operacion" class="form-control" value="<?php echo $lvi['tarjeta_operacion'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input type="text" name="fecha_vencimiento_to" id="datepicker" class="form-control" value="<?php echo $lvi['fecha_vencimiento_to'] ?>" >
					       				                <input type="hidden" name="act_fecha_vencimiento_to" id="datepicker" class="form-control" value="<?php echo $lvi['fecha_vencimiento_to'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
		                        	<?php } ?>
                	            

		                        	
					                <div class="row mt-3">
					                    <?php if ($TO == 1) { ?>
			        	                        <label class="mt-3 ml-5" for="act_tarjeta_operacion"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>
			        	                <?php } else if ($lvi['tarjeta_operacion'] == '') { ?>
			        	                        <label class="mt-2 ml-5" for="act_tarjeta_operacion"><strong>Documento Actual: </strong> No hay documentos cargados</label>
			        	                <?php } else{ ?>
			        	                        <label class="mt-2 ml-5" for="act_tarjeta_operacion"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['tarjeta_operacion'];?>" target="_blank"><?php echo $lvi['tarjeta_operacion'] ?></a></label>
			        	                <?php }  ?>
		        	                </div>
	       
	                			<!-- LICENCIA DE TRANSITO -->
		                			<?php if ($lvi['fecha_vencimiento_lt'] == '0000-00-00'){ ?>
		                				
			                				<div class="row mt-3">
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		                <div class="row">
							       			                <div class="label">
							       				                <label>Licencia de Transito</label>
							       			                </div>
							       			                <div class="input">
							       				                <input style="border: 2px solid red;" type="file" name="licencia_transito"  id="licencia_transito" class="form-control">
							       				                <input type="hidden" name="act_licencia_transito"  id="act_licencia_transito" class="form-control" value="<?php echo $lvi['licencia_transito'] ?>">
							       			                </div>      		
							       		                </div>
							       	            </section>
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		            <div class="row">
							       			            <div class="label">
							       				                <label>Fecha expedición</label>
							       			            </div>
							       			            <div class="input">
							       				            <input style="border: 2px solid red;" type="text" name="fecha_vencimiento_lt" id="datepicker1" class="form-control" value="<?php echo $lvi['fecha_vencimiento_lt'] ?>">
							       				            <input type="hidden" name="act_fecha_vencimiento_lt" id="datepicker1" class="form-control" value="<?php echo $lvi['fecha_vencimiento_lt'] ?>">
							       			            </div>      		
							       		            </div>
							       	            </section>
							                </div>

		                			<?php } else { ?>
		                				<?php if ($LT == 1) { ?>
		                					
			                				<div class="row mt-3">
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		                <div class="row">
							       			                <div class="label">
							       				                <label>Licencia de Transito</label>
							       			                </div>
							       			                <div class="input">
							       				                <input type="file" name="licencia_transito"  id="licencia_transito" class="form-control" disabled >
							       				                <input type="hidden" name="act_licencia_transito"  id="act_licencia_transito" class="form-control" value="<?php echo $lvi['licencia_transito'] ?>">
							       			                </div>      		
							       		                </div>
							       	            </section>
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		            <div class="row">
							       			            <div class="label">
							       				                <label>Fecha expedición</label>
							       			            </div>
							       			            <div class="input">
							       				            <input type="text" name="fecha_vencimiento_lt" id="datepicker1" class="form-control" value="<?php echo $lvi['fecha_vencimiento_lt'] ?>" disabled >
							       				            <input type="hidden" name="act_fecha_vencimiento_lt" id="datepicker1" class="form-control" value="<?php echo $lvi['fecha_vencimiento_lt'] ?>">
							       			            </div>      		
							       		            </div>
							       	            </section>
							                </div>
		                				<? } else { ?>
							                <div class="row mt-3">
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		                <div class="row">
							       			                <div class="label">
							       				                <label>Licencia de Transito</label>
							       			                </div>
							       			                <div class="input">
							       				                <input type="file" name="licencia_transito"  id="licencia_transito" class="form-control">
							       				                <input type="hidden" name="act_licencia_transito"  id="act_licencia_transito" class="form-control" value="<?php echo $lvi['licencia_transito'] ?>">
							       			                </div>      		
							       		                </div>
							       	            </section>
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		            <div class="row">
							       			            <div class="label">
							       				                <label>Fecha expedición</label>
							       			            </div>
							       			            <div class="input">
							       				            <input type="text" name="fecha_vencimiento_lt" id="datepicker1" class="form-control" value="<?php echo $lvi['fecha_vencimiento_lt'] ?>">
							       				            <input type="hidden" name="act_fecha_vencimiento_lt" id="datepicker1" class="form-control" value="<?php echo $lvi['fecha_vencimiento_lt'] ?>">
							       			            </div>      		
							       		            </div>
							       	            </section>
							                </div>
						            	<?php } ?>
						            <?php } ?>

					                <div class="row mt-3">
			        	            	<?php if ($LT == 1) { ?>
			        	                       <label class="mt-3 ml-5" for="act_tarjeta_operacion"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>

			        	                <?php } else if ($lvi['licencia_transito'] == '') { ?>
			        	                        <label class="mt-2 ml-5" for="act_licencia_transito"><strong>Documento Actual: </strong> No hay documentos cargados</label>
			        	                <?php } else{ ?>
			        	                        <label class="mt-2 ml-5" for="act_licencia_transito"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['licencia_transito'];?>" target="_blank"><?php echo $lvi['licencia_transito'] ?></a></label>
			        	                <?php }  ?> 
			        	            </div>

				                <!-- SOAT -->
	                				<?php if ($lvi['fecha_vencimiento_soat'] <= date('Y-m-d')){ ?>
	                					<?php if ($SOAT == 1) { ?>
						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Soat</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="file" name="soat"  id="soat" class="form-control" disabled>

						       				                <input type="hidden" name="act_soat"  id="act_soat" class="form-control" value="<?php echo $lvi['soat'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="text" name="fecha_vencimiento_soat" id="datepicker2" class="form-control" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>"  disabled>
						       				                <input type="hidden" name="act_fecha_vencimiento_soat" id="datepicker2" class="form-control" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
						                <?php } else { ?>
						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Soat</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="file" name="soat"  id="soat" class="form-control">

						       				                <input type="hidden" name="act_soat"  id="act_soat" class="form-control" value="<?php echo $lvi['soat'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="text" name="fecha_vencimiento_soat" id="datepicker2" class="form-control" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>" >
						       				                <input type="hidden" name="act_fecha_vencimiento_soat" id="datepicker2" class="form-control" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
						                <?php } ?>

					                <?php }else if(($lvi['fecha_vencimiento_soat'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_soat'] > date('Y-m-d'))){ ?>
										<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Soat</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="file" name="soat"  id="soat" class="form-control">
					       				                <input type="hidden" name="act_soat"  id="act_soat" class="form-control" value="<?php echo $lvi['soat'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="text" name="fecha_vencimiento_soat" id="datepicker2" class="form-control" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>" >
					       				                <input type="hidden" name="act_fecha_vencimiento_soat" id="datepicker2" class="form-control" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
					                <?php } else {?>
										<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Soat</label>
					       			                </div>
					       			                <div class="input">
					       				                <input  type="file" name="soat"  id="soat" class="form-control">
					       				                <input type="hidden" name="act_soat"  id="act_soat" class="form-control" value="<?php echo $lvi['soat'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input type="text" name="fecha_vencimiento_soat" id="datepicker2" class="form-control" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>" >
					       				                <input type="hidden" name="act_fecha_vencimiento_soat" id="datepicker2" class="form-control" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
					                <?php } ?>

									<div class="row mt-3">
							            <?php if ($SOAT == 1) { ?>
		        	                       	<label class="mt-3 ml-5" for="act_soat"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>

			        	                <?php } else if ($lvi['soat'] == '') { ?>
					        	            <label class="mt-2 ml-5" for="act_soat"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
					        	            <label class="mt-2 ml-5" for="act_soat"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['soat'];?>" target="_blank"><?php echo $lvi['soat'] ?></a></label>
										<?php }  ?> 
									</div> 
	       
				                <!-- REVISION TECNOMECANICA -->
				                	<?php if ($lvi['fecha_vencimiento_rt'] <= date('Y-m-d')){ ?>
				                		<?php if ($RT == 1) { ?>
						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Revisión tecnomecanica</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="file" name="revision_tecnomecanica" id="revision_tecnomecanica" class="form-control"disabled>
						       				                <input type="hidden" name="act_revision_tecnomecanica"  id="act_revision_tecnomecanica" class="form-control" value="<?php echo $lvi['revision_tecnomecanica'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="text" name="fecha_vencimiento_rt" id="datepicker3" class="form-control" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>" disabled>
						       				                <input type="hidden" name="act_fecha_vencimiento_rt" id="datepicker3" class="form-control" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
						                <?php } else { ?>

						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Revisión tecnomecanica</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="file" name="revision_tecnomecanica" id="revision_tecnomecanica" class="form-control">
						       				                <input type="hidden" name="act_revision_tecnomecanica"  id="act_revision_tecnomecanica" class="form-control" value="<?php echo $lvi['revision_tecnomecanica'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="text" name="fecha_vencimiento_rt" id="datepicker3" class="form-control" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>" >
						       				                <input type="hidden" name="act_fecha_vencimiento_rt" id="datepicker3" class="form-control" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
						               	<?php } ?>

					                <?php } else if(($lvi['fecha_vencimiento_rt'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_rt'] > date('Y-m-d'))){ ?>
										<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Revisión tecnomecanica</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="file" name="revision_tecnomecanica" id="revision_tecnomecanica" class="form-control">
					       				                <input type="hidden" name="act_revision_tecnomecanica"  id="act_revision_tecnomecanica" class="form-control" value="<?php echo $lvi['revision_tecnomecanica'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="text" name="fecha_vencimiento_rt" id="datepicker3" class="form-control" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>" >
					       				                <input type="hidden" name="act_fecha_vencimiento_rt" id="datepicker3" class="form-control" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
					                <?php }else{ ?>
										<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Revisión tecnomecanica</label>
					       			                </div>
					       			                <div class="input">
					       				                <input  type="file" name="revision_tecnomecanica" id="revision_tecnomecanica" class="form-control">
					       				                <input type="hidden" name="act_revision_tecnomecanica"  id="act_revision_tecnomecanica" class="form-control" value="<?php echo $lvi['revision_tecnomecanica'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input  type="text" name="fecha_vencimiento_rt" id="datepicker3" class="form-control" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>" >
					       				                <input type="hidden" name="act_fecha_vencimiento_rt" id="datepicker3" class="form-control" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
					               	<?php } ?>

					               	<div class="row mt-3">
										<?php if ($RT == 1) { ?>
		        	                       	<label class="mt-3 ml-5" for="act_revision_tecnomecanica"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>
			        	                <?php } else if ($lvi['revision_tecnomecanica'] == '') { ?>
					        	            <label class="mt-2 ml-5" for="act_revision_tecnomecanica"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
					        	            <label class="mt-2 ml-5" for="act_revision_tecnomecanica"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['revision_tecnomecanica'];?>" target="_blank"><?php echo $lvi['revision_tecnomecanica'] ?></a></label>
										<?php }  ?>
									</div>
	       
				                <!-- REVISION PREVENTIVA -->
				                	<?php if ($lvi['fecha_vencimiento_rp'] <= date('Y-m-d')){ ?>
				                		<?php if ($RP == 1) { ?>
						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Revisión preventiva</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="file" name="revision_preventiva" id="revision_preventiva" class="form-control" disabled>
						       				                <input type="hidden" name="act_revision_preventiva"  id="act_revision_preventiva" class="form-control" value="<?php echo $lvi['revision_preventiva'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="text" name="fecha_vencimiento_rp" id="datepicker4" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_rp'] ?>" disabled>
						       				                <input type="hidden" name="act_fecha_vencimiento_rp" id="datepicker4" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_rp'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
						                <?php } else { ?>

						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Revisión preventiva</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red" type="file" name="revision_preventiva" id="revision_preventiva"  class="form-control">
						       				                <input type="hidden" name="act_revision_preventiva"  id="act_revision_preventiva" class="form-control" value="<?php echo $lvi['revision_preventiva'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red" type="text" name="fecha_vencimiento_rp" id="datepicker4" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_rp'] ?>">
						       				                <input type="hidden" name="act_fecha_vencimiento_rp" id="datepicker4" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_rp'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>

						               	<?php } ?>

					                <?php }else if(($lvi['fecha_vencimiento_rp'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_rp'] > date('Y-m-d'))){ ?>
					                	<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Revisión preventiva</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="file" name="revision_preventiva" id="revision_preventiva"  class="form-control">
					       				                <input type="hidden" name="act_revision_preventiva"  id="act_revision_preventiva" class="form-control" value="<?php echo $lvi['revision_preventiva'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="text" name="fecha_vencimiento_rp" id="datepicker4" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_rp'] ?>">
					       				                <input type="hidden" name="act_fecha_vencimiento_rp" id="datepicker4" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_rp'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
									<?php } else{ ?>
										<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Revisión preventiva</label>
					       			                </div>
					       			                <div class="input">
					       				                <input type="file" name="revision_preventiva" id="revision_preventiva"  class="form-control">
					       				                <input type="hidden" name="act_revision_preventiva"  id="act_revision_preventiva" class="form-control" value="<?php echo $lvi['revision_preventiva'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input type="text" name="fecha_vencimiento_rp" id="datepicker4" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_rp'] ?>">
					       				                <input type="hidden" name="act_fecha_vencimiento_rp" id="datepicker4" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_rp'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
									<?php } ?>

									<div class="row mt-3">
										<?php if ($RP == 1) { ?>
		        	                       	<label class="mt-3 ml-5" for="act_revision_preventiva"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>
			        	                <?php } else if ($lvi['revision_preventiva'] == '') { ?>
					        	            <label class="mt-2 ml-5" for="act_revision_preventiva"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
					        	            <label class="mt-2 ml-5" for="act_revision_preventiva"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['revision_preventiva'];?>" target="_blank"><?php echo $lvi['revision_preventiva'] ?></a></label>
										<?php }  ?>
									</div>
	       
				                <!-- POLIZAS CONTRACTUAL -->
				                	<?php if ($lvi['fecha_vencimiento_contra'] <= date('Y-m-d')){ ?>
				                		<?php if ($PC == 1) { ?>
						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Poliza - Contractual</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="file" name="poliza_contra" id="poliza_contra" class="form-control" disabled>
						       				                <input type="hidden" name="act_poliza_contra"  id="act_poliza_contra" class="form-control" value="<?php echo $lvi['poliza_contra']; ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-66">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="text" name="fecha_vencimiento_contra" id="datepicker5" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_contra'] ?>" disabled>
						       				                <input type="hidden" name="act_fecha_vencimiento_contra" id="datepicker5" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_contra'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
						                <? } else { ?>
					                	 	<div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Poliza - Contractual</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="file" name="poliza_contra" id="poliza_contra" class="form-control">
						       				                <input type="hidden" name="act_poliza_contra"  id="act_poliza_contra" class="form-control" value="<?php echo $lvi['poliza_contra']; ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="text" name="fecha_vencimiento_contra" id="datepicker5" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_contra'] ?>">
						       				                <input type="hidden" name="act_fecha_vencimiento_contra" id="datepicker5" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_contra'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
						                <?php } ?>
									<?php }else if(($lvi['fecha_vencimiento_contra'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_contra'] > date('Y-m-d'))){ ?>
										<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Poliza - Contractual</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="file" name="poliza_contra" id="poliza_contra" class="form-control">
					       				                <input type="hidden" name="act_poliza_contra"  id="act_poliza_contra" class="form-control" value="<?php echo $lvi['poliza_contra']; ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="text" name="fecha_vencimiento_contra" id="datepicker5" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_contra'] ?>">
					       				                <input type="hidden" name="act_fecha_vencimiento_contra" id="datepicker5" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_contra'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
									<?php } else{ ?>
										<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Poliza - Contractual</label>
					       			                </div>
					       			                <div class="input">
					       				                <input type="file" name="poliza_contra" id="poliza_contra" class="form-control">
					       				                <input type="hidden" name="act_poliza_contra"  id="act_poliza_contra" class="form-control" value="<?php echo $lvi['poliza_contra']; ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input type="text" name="fecha_vencimiento_contra" id="datepicker5" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_contra'] ?>">
					       				                <input type="hidden" name="act_fecha_vencimiento_contra" id="datepicker5" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_contra'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
									<?php }  ?>

				                    <div class="row mt-3">
										<?php if ($PC == 1) { ?>
		        	                       	<label class="mt-3 ml-5" for="act_poliza_contra"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>
			        	                <?php } else if ($lvi['poliza_contra'] == '') { ?>
					        	            <label class="mt-2 ml-5" for="act_poliza_contra"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
					        	            <label class="mt-2 ml-5" for="act_poliza_contra"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['poliza_contra'];?>" target="_blank"><?php echo $lvi['poliza_contra'] ?></a></label>
										<?php }  ?>
									</div>

				                <!-- POLIZAS EXTRA CONTRACTUAL -->
				                	<?php if ($lvi['fecha_vencimiento_extra'] <= date('Y-m-d')){ ?>

				                    	<?php if ($PE == 1) { ?>
						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Poliza - Extra contractual</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="file" name="poliza_extra" id="poliza_extra" class="form-control" disabled>
						       				                <input type="hidden" name="act_poliza_extra"  id="act_poliza_extra" class="form-control" value="<?php echo $lvi['poliza_extra']; ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input type="text" name="fecha_vencimiento_extra" id="datepicker6" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_extra'] ?>" disabled>
						       				                <input type="hidden" name="act_fecha_vencimiento_extra" id="datepicker6" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_extra'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
						                <?php } else { ?>
						                    <div class="row mt-3">
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Poliza - Extra contractual</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="file" name="poliza_extra" id="poliza_extra" class="form-control">
						       				                <input type="hidden" name="act_poliza_extra"  id="act_poliza_extra" class="form-control" value="<?php echo $lvi['poliza_extra']; ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Fecha vencimiento</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="text" name="fecha_vencimiento_extra" id="datepicker6" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_extra'] ?>">
						       				                <input type="hidden" name="act_fecha_vencimiento_extra" id="datepicker6" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_extra'] ?>">
						       			                </div>      		
						       		                </div>
						       	                </section>
						                    </div>
						                <?php } ?>
									<?php }else if(($lvi['fecha_vencimiento_extra'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_extra'] > date('Y-m-d'))){ ?>
										<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Poliza - Extra contractual</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="file" name="poliza_extra" id="poliza_extra" class="form-control">
					       				                <input type="hidden" name="act_poliza_extra"  id="act_poliza_extra" class="form-control" value="<?php echo $lvi['poliza_extra']; ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input style="border: 2px solid orange;" type="text" name="fecha_vencimiento_extra" id="datepicker6" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_extra'] ?>">
					       				                <input type="hidden" name="act_fecha_vencimiento_extra" id="datepicker6" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_extra'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
									<?php } else { ?>
										<div class="row mt-3">
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Poliza - Extra contractual</label>
					       			                </div>
					       			                <div class="input">
					       				                <input type="file" name="poliza_extra" id="poliza_extra" class="form-control">
					       				                <input type="hidden" name="act_poliza_extra"  id="act_poliza_extra" class="form-control" value="<?php echo $lvi['poliza_extra']; ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					       	                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					       		                <div class="row">
					       			                <div class="label">
					       				                <label>Fecha vencimiento</label>
					       			                </div>
					       			                <div class="input">
					       				                <input type="text" name="fecha_vencimiento_extra" id="datepicker6" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_extra'] ?>">
					       				                <input type="hidden" name="act_fecha_vencimiento_extra" id="datepicker6" class="form-control"  value="<?php echo $lvi['fecha_vencimiento_extra'] ?>">
					       			                </div>      		
					       		                </div>
					       	                </section>
					                    </div>
									<?php } ?>

									<div class="row mt-3">
					                    <?php if ($PE == 1) { ?>
		        	                       	<label class="mt-3 ml-5" for="act_poliza_extra"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>
			        	                <?php } else if ($lvi['poliza_extra'] == '') { ?>
					        	            <label class="mt-2 ml-5" for="act_poliza_extra"><strong>Documento Actual: </strong> No hay documentos cargados</label>
										<?php } else{ ?>
					        	            <label class="mt-2 ml-5" for="act_poliza_extra"><strong>Documento Actual: </strong> <a href="<?php echo $link . $lvi['poliza_extra'];?>" target="_blank"><?php echo $lvi['poliza_extra'] ?></a></label>
										<?php }  ?>
									</div>

								<!-- DISPOSITIVO VELOCIDAD -->
		                			<?php if (($lvi['fecha_exp_disp_velocidad'] == '0000-00-00')or($lvi['fecha_exp_disp_velocidad'] <= $plazoVencimiento2)){ ?>
		                				<div class="row mt-3">
						       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Verificación Dispositivo Velocidad</label>
						       			                </div>
						       			                <div class="input">
						       				                <input style="border: 2px solid red;" type="file" name="disp_velocidad"  id="disp_velocidad" class="form-control">
						       				                <input type="hidden" name="act_disp_velocidad"  id="act_disp_velocidad" class="form-control" value="<?php echo $lvi['disp_velocidad'] ?>">
						       			                </div>      		
						       		                </div>
						       	            </section>
						       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		            <div class="row">
						       			            <div class="label">
						       				                <label>Fecha expedición</label>
						       			            </div>
						       			            <div class="input">
						       				            <input style="border: 2px solid red;" type="text" name="fecha_exp_disp_velocidad" id="datepicker7" class="form-control" value="<?php echo $lvi['fecha_exp_disp_velocidad'] ?>">
						       				            <input type="hidden" name="act_fecha_exp_disp_velocidad" id="datepicker7" class="form-control" value="<?php echo $lvi['fecha_exp_disp_velocidad'] ?>">
						       			            </div>      		
						       		            </div>
						       	            </section>
						                </div>
		                			<?php } else { ?>
		                				<?php if ($DV == 1) { ?>
							                <div class="row mt-3">
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		                <div class="row">
							       			                <div class="label">
							       				                <label>Verificación Dispositivo Velocidad</label>
							       			                </div>
							       			                <div class="input">
							       				                <input type="file" name="disp_velocidad"  id="disp_velocidad" class="form-control" disabled>
							       				                <input type="hidden" name="act_disp_velocidad"  id="act_disp_velocidad" class="form-control" value="<?php echo $lvi['disp_velocidad'] ?>">
							       			                </div>      		
							       		                </div>
							       	            </section>
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		            <div class="row">
							       			            <div class="label">
							       				                <label>Fecha expedición</label>
							       			            </div>
							       			            <div class="input">
							       				            <input type="text" name="fecha_exp_disp_velocidad" id="datepicker7" class="form-control" value="<?php echo $lvi['fecha_exp_disp_velocidad'] ?>" disabled>
							       				            <input type="hidden" name="act_fecha_exp_disp_velocidad" id="datepicker7" class="form-control" value="<?php echo $lvi['fecha_exp_disp_velocidad'] ?>">
							       			            </div>      		
							       		            </div>
							       	            </section>
							                </div>
							            <?php } else { ?>
							                <div class="row mt-3">
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		                <div class="row">
							       			                <div class="label">
							       				                <label>Verificación Dispositivo Velocidad</label>
							       			                </div>
							       			                <div class="input">
							       				                <input type="file" name="disp_velocidad"  id="disp_velocidad" class="form-control">
							       				                <input type="hidden" name="act_disp_velocidad"  id="act_disp_velocidad" class="form-control" value="<?php echo $lvi['disp_velocidad'] ?>">
							       			                </div>      		
							       		                </div>
							       	            </section>
							       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							       		            <div class="row">
							       			            <div class="label">
							       				                <label>Fecha expedición</label>
							       			            </div>
							       			            <div class="input">
							       				            <input type="text" name="fecha_exp_disp_velocidad" id="datepicker7" class="form-control" value="<?php echo $lvi['fecha_exp_disp_velocidad'] ?>">
							       				            <input type="hidden" name="act_fecha_exp_disp_velocidad" id="datepicker7" class="form-control" value="<?php echo $lvi['fecha_exp_disp_velocidad'] ?>">
							       			            </div>      		
							       		            </div>
							       	            </section>
							                </div>
							            <?php } ?>
						            <?php } ?>

						            <div class="row">
			        	            	<?php if ($DV == 1) { ?>
		        	                       	<label class="mt-3 ml-5" for="act_disp_velocidad"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>
			        	                <?php } else if ($lvi['disp_velocidad'] == '') { ?>
			        	                        <label class="mt-2 ml-5" for="disp_velocidad"><strong>Documento Actual: </strong> No hay documentos cargados</label>
			        	                <?php } else{ ?>
			        	                        <label class="mt-2 ml-5" for="disp_velocidad"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['disp_velocidad'];?>" target="_blank"><?php echo $lvi['disp_velocidad'] ?></a></label>
			        	                <?php }  ?> 
		        	            	</div>
		        	                
	        	                <!-- CONTRATO VINCULACION -->
	        	                    <?php if (($lvi['contrato_vinculacion'] == '') || ($lvi['fecha_exp_contrato_vinculacion'] == '0000-00-00')) { ?>
			        	                <div class="row mt-3">
						       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		                <div class="row">
						       			                <div class="label">
						       				                <label>Contrato de Vinculación</label>
						       			                </div>
						       			                <div class="input">
    		                                                <input style="border: 2px solid red;" type="file" name="contrato_vinculacion"  id="contrato_vinculacion" class="form-control" >
    		                                            	<input type="hidden" name="act_contrato_vinculacion"  id="act_contrato_vinculacion" class="form-control" value="<?php echo $lvi['contrato_vinculacion'] ?>">
						       			                </div>      		
						       		                </div>
						       	            </section>
						       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						       		            <div class="row">
						       			            <div class="label">
						       				                <label>Fecha expedición</label>
						       			            </div>
						       			            <div class="input"> 
						       			                <input style="border: 2px solid red;" type="text" name="fecha_exp_contrato_vinculacion" id="datepicker9" class="form-control" value="<?php echo $lvi['fecha_exp_contrato_vinculacion'] ?>">
						       				            <input type="hidden" name="act_fecha_exp_contrato_vinculacion" id="act_fecha_exp_contrato_vinculacion" class="form-control" value="<?php echo $lvi['fecha_exp_contrato_vinculacion'] ?>">
						       			            </div>      		
						       		            </div>
						       	            </section>
					                    </div>
					                    
					                <?php }else{ ?>

                                    	<?php if ($CV == 1) { ?>
						                    <div class="row mt-3">
    						       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    						       		                <div class="row">
    						       			                <div class="label">
    						       				                <label>Contrato de Vinculación</label>
    						       			                </div>
    						       			                <div class="input">
        		                                                <input type="file" name="contrato_vinculacion"  id="contrato_vinculacion" class="form-control"  disabled>
        		                                            	<input type="hidden" name="act_contrato_vinculacion"  id="act_contrato_vinculacion" class="form-control" value="<?php echo $lvi['contrato_vinculacion'] ?>">
    						       			                </div>      		
    						       		                </div>
    						       	            </section>
    						       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    						       		            <div class="row mt-3">
    						       			            <div class="label">
    						       				                <label>Fecha expedición</label>
    						       			            </div>
    						       			            <div class="input"> 
    						       			                <input type="text" name="fecha_exp_contrato_vinculacion" id="datepicker9" class="form-control" value="<?php echo $lvi['fecha_exp_contrato_vinculacion'] ?>" disabled>
    						       				            <input type="hidden" name="act_fecha_exp_contrato_vinculacion" id="act_fecha_exp_contrato_vinculacion" class="form-control" value="<?php echo $lvi['fecha_exp_contrato_vinculacion'] ?>">
    						       			            </div>      		
    						       		            </div>
    						       	            </section>
						                    </div>
                                    	<?php } else { ?>

						                    <div class="row mt-3">
    						       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    						       		                <div class="row">
    						       			                <div class="label">
    						       				                <label>Contrato de Vinculación</label>
    						       			                </div>
    						       			                <div class="input">
        		                                                <input type="file" name="contrato_vinculacion"  id="contrato_vinculacion" class="form-control" >
        		                                            	<input type="hidden" name="act_contrato_vinculacion"  id="act_contrato_vinculacion" class="form-control" value="<?php echo $lvi['contrato_vinculacion'] ?>">
    						       			                </div>      		
    						       		                </div>
    						       	            </section>
    						       	            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    						       		            <div class="row">
    						       			            <div class="label">
    						       				                <label>Fecha expedición</label>
    						       			            </div>
    						       			            <div class="input"> 
    						       			                <input type="text" name="fecha_exp_contrato_vinculacion" id="datepicker9" class="form-control" value="<?php echo $lvi['fecha_exp_contrato_vinculacion'] ?>" >
    						       				            <input type="hidden" name="act_fecha_exp_contrato_vinculacion" id="act_fecha_exp_contrato_vinculacion" class="form-control" value="<?php echo $lvi['fecha_exp_contrato_vinculacion'] ?>">
    						       			            </div>      		
    						       		            </div>
    						       	            </section>
						                    </div>
                                    	<?php } ?>

					                <?php } ?>
					                    
					                <div class="row mt-3">
	                                    <?php if ($CV == 1) { ?>
		        	                       	<label class="mt-3 ml-5" for="act_contrato_vinculacion"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>
			        	                <?php } else  if ($lvi['contrato_vinculacion'] == '') { ?>
		        	                        <label class="mt-2 ml-5" for="act_contrato_vinculacion"><strong>Documento Actual: </strong> No hay documento cargado</label>
		        	                    <?php } else{ ?>
		        	                        <label class="mt-2 ml-5" for="act_contrato_vinculacion"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['contrato_vinculacion'];?>" target="_blank"><?php echo $lvi['contrato_vinculacion'] ?></a></label>
		        	                    <?php }  ?>
	        	                	</div>
                                       
                                <!-- FICHA TECNICA DE HOMOLOGACIÓN -->
                                
                                    <?php if (($lvi['ficha_tecnica_homologacion'] == '')) {?>
                                    	<?php if ($FTH == 1) { ?>
                                            <div class="row  mt-3 ">
                                                <div class="label">
                                                    <label>Ficha Tecnica de Homologación</label>
                                                </div>
                                                <div class="input">
                                                    <input type="file" name="ficha_tecnica_homologacion"  id="ficha_tecnica_homologacion" class="form-control" disabled >
                                                    
                                                    <input type="hidden" name="act_ficha_tecnica_homologacion"  id="act_ficha_tecnica_homologacion" class="form-control" value="<?php echo $lvi['ficha_tecnica_homologacion']; ?>">
                                                </div>  
                                            </div>
                                		<?php } else { ?>
                                            <div class="row  mt-3 ">
                                                <div class="label">
                                                    <label>Ficha Tecnica de Homologación</label>
                                                </div>
                                                <div class="input">
                                                    <input style="border: 2px solid red;" type="file" name="ficha_tecnica_homologacion"  id="ficha_tecnica_homologacion" class="form-control" >
                                                    <input type="hidden" name="act_ficha_tecnica_homologacion"  id="act_ficha_tecnica_homologacion" class="form-control" value="<?php echo $lvi['ficha_tecnica_homologacion']; ?>">
                                                </div>  
                                            </div>
                                    	<?php } ?>
                                    <?php } else { ?>
                                    	
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Ficha Tecnica de Homologación</label>
                                            </div>
                                            <div class="input">
                                                <input type="file" name="ficha_tecnica_homologacion"  id="ficha_tecnica_homologacion" class="form-control" >
                                                
                                                <input type="hidden" name="act_ficha_tecnica_homologacion"  id="act_ficha_tecnica_homologacion" class="form-control" value="<?php echo $lvi['ficha_tecnica_homologacion']; ?>">
                                            </div>  
                                        </div>

                                    <?php } ?>
                                    
                                    <div class="row mt-3">
	                                    <?php if ($FTH == 1) { ?>
		        	                       	<label class="mt-3 ml-5" for="act_ficha_tecnica_homologacion"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>
			        	                <?php } else  if ($lvi['ficha_tecnica_homologacion'] == '') { ?>
		        	                        <label class="mt-2 ml-5" for="act_ficha_tecnica_homologacion"><strong>Documento Actual: </strong> No hay documento cargado</label>
		        	                    <?php } else{ ?>
		        	                        <label class="mt-2 ml-5" for="act_ficha_tecnica_homologacion"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['ficha_tecnica_homologacion'];?>" target="_blank"><?php echo $lvi['ficha_tecnica_homologacion'] ?></a></label>
		        	                    <?php }  ?>
	        	                	</div>
        	                    
                                <!-- POLIZAS TODO RIESGO -->
                                
                                    <?php if (($lvi['fecha_vencimiento_seguro_todo_riesgo'] == '0000-00-00') || (($lvi['fecha_vencimiento_seguro_todo_riesgo'] <= $plazoVencimiento) && ($lvi['fecha_vencimiento_seguro_todo_riesgo'] > date('Y-m-d')))){ ?>

                                    	<?php if ($STR == 1) { ?>
                                            <div class="row mt-3">
                                                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="label">
                                                            <label>(Poliza - Seguro) Todo Riesgo</label>
                                                        </div>
                                                        <div class="input">
                                                            <input type="file" name="seguro_todo_riesgo"  id="seguro_todo_riesgo" class="form-control" disabled>
                                                            <input type="hidden" name="act_seguro_todo_riesgo"  id="act_seguro_todo_riesgo" class="form-control" value="<?php echo $lvi['seguro_todo_riesgo']; ?>">
                                                        </div>              
                                                    </div>
                                                </section>
                                                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="label">
                                                            <label>Fecha vencimiento</label>
                                                        </div>
                                                        <div class="input">
                                                            <input type="text" name="fecha_vencimiento_seguro_todo_riesgo" id="datepicker11" class="form-control" value="<?php echo $lvi['fecha_vencimiento_seguro_todo_riesgo']; ?>" disabled>
                                                            <input type="hidden" name="act_fecha_vencimiento_seguro_todo_riesgo" id="datepicker11" class="form-control" value="<?php echo $lvi['fecha_vencimiento_seguro_todo_riesgo']; ?>">
                                                        </div>              
                                                    </div>
                                                </section>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row mt-3">
                                                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="label">
                                                            <label>(Poliza - Seguro) Todo Riesgo</label>
                                                        </div>
                                                        <div class="input">
                                                            <input style="border: 2px solid red;" type="file" name="seguro_todo_riesgo"  id="seguro_todo_riesgo" class="form-control" >
                                                            <input type="hidden" name="act_seguro_todo_riesgo"  id="act_seguro_todo_riesgo" class="form-control" value="<?php echo $lvi['seguro_todo_riesgo']; ?>">
                                                        </div>              
                                                    </div>
                                                </section>
                                                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="label">
                                                            <label>Fecha vencimiento</label>
                                                        </div>
                                                        <div class="input">
                                                            <input style="border: 2px solid red;" type="text" name="fecha_vencimiento_seguro_todo_riesgo" id="datepicker11" class="form-control" value="<?php echo $lvi['fecha_vencimiento_seguro_todo_riesgo']; ?>">
                                                            <input type="hidden" name="act_fecha_vencimiento_seguro_todo_riesgo" id="datepicker11" class="form-control" value="<?php echo $lvi['fecha_vencimiento_seguro_todo_riesgo']; ?>">
                                                        </div>              
                                                    </div>
                                                </section>
                                            </div>
                                       	<?php } ?>
                                    
                                    <?php } else { ?>
                                        
                                        <div class="row mt-3">
                                            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="row">
                                                    <div class="label">
                                                        <label>(Poliza - Seguro) Todo Riesgo</label>
                                                    </div>
                                                    <div class="input">
                                                        <input type="file" name="seguro_todo_riesgo"  id="seguro_todo_riesgo" class="form-control" >
                                                        <input type="hidden" name="act_seguro_todo_riesgo"  id="act_seguro_todo_riesgo" class="form-control" value="<?php echo $lvi['seguro_todo_riesgo']; ?>">
                                                    </div>              
                                                </div>
                                            </section>
                                            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="row">
                                                    <div class="label">
                                                        <label>Fecha de Vencimiento</label>
                                                    </div>
                                                    <div class="input">
                                                        <input type="text" name="fecha_vencimiento_seguro_todo_riesgo" id="datepicker11" class="form-control" value="<?php echo $lvi['fecha_vencimiento_seguro_todo_riesgo']; ?>">
                                                        <input type="hidden" name="act_fecha_vencimiento_seguro_todo_riesgo" id="datepicker11" class="form-control" value="<?php echo $lvi['fecha_vencimiento_seguro_todo_riesgo']; ?>">
                                                    </div>              
                                                </div>
                                            </section>
                                        </div>
                                        
                                    <?php } ?>
                            
                            		<div class="row mt-3">
	                                    <?php if ($STR == 1) { ?>
		        	                       	<label class="mt-3 ml-5" for="act_seguro_todo_riesgo"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN PARA SU DEBIDA CARGA.</strong></label>
			        	                <?php } else  if ($lvi['seguro_todo_riesgo'] == '') { ?>
		        	                        <label class="mt-2 ml-5" for="act_seguro_todo_riesgo"><strong>Documento Actual: </strong> No hay documento cargado</label>
		        	                    <?php } else{ ?>
		        	                        <label class="mt-2 ml-5" for="act_seguro_todo_riesgo"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['seguro_todo_riesgo'];?>" target="_blank"><?php echo $lvi['seguro_todo_riesgo'] ?></a></label>
		        	                    <?php }  ?>
		        	                </div>
	        	                    
						    </div>

	                    <!--FOTOGRAFIAS-->

	                    	<div id="tabs-3">

	                    			<input type="hidden" name="id_fotografia" id="id_fotografia" value="<?php echo $listarFotografiasId[0]['id_fotografia'] ?>">
	                    		
	                    			<div class="row  mt-3 ">
	                                    <div class="label">
	                                        <label>Foto Delantera</label>
	                                    </div>
	                                    <div class="input">

                                    	<?php if ($FF == 1) { ?>
	                                        <input type="file" name="fotografia_frontal" id="fotografia_frontal" class="form-control" disabled>
	                                        <input type="hidden" name="act_fotografia_frontal" id="act_fotografia_frontal" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_frontal'] ?>">  

                                    	<?php } else { ?>
	                                        <input type="file" name="fotografia_frontal" id="fotografia_frontal" class="form-control" >
	                                        <input type="hidden" name="act_fotografia_frontal" id="act_fotografia_frontal" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_frontal'] ?>">  
                                    	<?php } ?>

	                                    <?php if ($FF == 1) { ?>
	        	                       		<label class="mt-3 ml-5" for="act_fotografia_frontal"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN.</strong></label>
	        	                		<?php } else if ($listarFotografiasId[0]['fotografia_frontal'] == '') { ?>
		        	                        <label class="mt-2 ml-5" for="act_fotografia_frontal"><strong>Fotografia Actual: </strong> No hay fotografia cargada</label>
		        	                	<?php } else{ ?>
		        	                        <label class="mt-2 ml-5" for="act_fotografia_frontal"><strong>Documento Actual: </strong> <a href="<?php echo $link.$listarFotografiasId[0]['fotografia_frontal'];?>" target="_blank"><?php echo $listarFotografiasId[0]['fotografia_frontal'] ?></a></label>
		        	                	<?php }  ?> 
	                                    </div>   

	                                         
	                                </div>

                                    <div class="row  mt-3 ">
                                        <div class="label">
                                            <label>Foto Trasera</label>
                                        </div>
                                        <div class="input">
                                        	<?php if ($FT == 1) { ?>
	                                            <input type="file" name="fotografia_trasera" id="fotografia_trasera" class="form-control" disabled>    
	                                            <input type="hidden" name="act_fotografia_trasera" id="act_fotografia_trasera" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_trasera'] ?>">  
                                            <?php } else { ?>
												<input type="file" name="fotografia_trasera" id="fotografia_trasera" class="form-control" >    
	                                            <input type="hidden" name="act_fotografia_trasera" id="act_fotografia_trasera" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_trasera'] ?>">  
                                            <?php } ?> 

                                            <?php if ($FT == 1) { ?>
	        	                       			<label class="mt-3 ml-5" for="act_fotografia_trasera"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN.</strong></label>
	        	                			<?php } else  if ($listarFotografiasId[0]['fotografia_trasera'] == '') { ?>
		        	                        	<label class="mt-2 ml-5" for="act_fotografia_trasera"><strong>Fotografia Actual: </strong> No hay fotografia cargada</label>
		        	                		<?php } else{ ?>
		        	                        	<label class="mt-2 ml-5" for="act_fotografia_trasera"><strong>Documento Actual: </strong> <a href="<?php echo $link.$listarFotografiasId[0]['fotografia_trasera'];?>" target="_blank"><?php echo $listarFotografiasId[0]['fotografia_trasera'] ?></a></label>
		        	                		<?php }  ?>    
                                        </div>              
                                    </div>

                                    <div class="row  mt-3 ">
                                        <div class="label">
                                            <label>Foto Lateral Izquierda</label>
                                        </div>
                                        <div class="input">
                                        	<?php if ($FLI == 1) { ?>
	                                            <input type="file" name="fotografia_lateral_izq" id="fotografia_lateral_izq" class="form-control" disabled>
	                                            <input type="hidden" name="act_fotografia_lateral_izq" id="act_fotografia_lateral_izq" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_lateral_izq'] ?>">    
                                            <?php } else { ?>
                                            	<input type="file" name="fotografia_lateral_izq" id="fotografia_lateral_izq" class="form-control">
	                                            <input type="hidden" name="act_fotografia_lateral_izq" id="act_fotografia_lateral_izq" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_lateral_izq'] ?>">   
                                            <?php } ?>

                                            <?php if ($FLI == 1) { ?>
	        	                       			<label class="mt-3 ml-5" for="act_fotografia_lateral_izq"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN.</strong></label>
	        	                			<?php } else if ($listarFotografiasId[0]['fotografia_lateral_izq'] == '') { ?>
		        	                        	<label class="mt-2 ml-5" for="act_fotografia_lateral_izq"><strong>Fotografia Actual: </strong> No hay fotografia cargada</label>
		        	                		<?php } else{ ?>
		        	                        	<label class="mt-2 ml-5" for="act_fotografia_lateral_izq"><strong>Documento Actual: </strong> <a href="<?php echo $link.$listarFotografiasId[0]['fotografia_lateral_izq'];?>" target="_blank"><?php echo $listarFotografiasId[0]['fotografia_lateral_izq'] ?></a></label>
		        	                		<?php }  ?>     
                                        </div>              
                                    </div>

                                    <div class="row  mt-3 ">
                                        <div class="label">
                                            <label>Foto Lateral Derecha</label>
                                        </div>
                                        <div class="input">
                                           	<?php if ($FLD == 1) { ?>
                                            	<input type="file" name="fotografia_lateral_der" id="fotografia_lateral_der" class="form-control" disabled>
                                            	<input type="hidden" name="act_fotografia_lateral_der" id="act_fotografia_lateral_der" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_lateral_der'] ?>">

                                           	<?php } else { ?>

                                            	<input type="file" name="fotografia_lateral_der" id="fotografia_lateral_der" class="form-control" >
                                            	<input type="hidden" name="act_fotografia_lateral_der" id="act_fotografia_lateral_der" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_lateral_der'] ?>">
                                           	<?php } ?>

                                           	<?php if ($FLD == 1) { ?>
	        	                       			<label class="mt-3 ml-5" for="act_fotografia_lateral_der"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN.</strong></label>
	        	                			<?php } else if ($listarFotografiasId[0]['fotografia_lateral_der'] == '') { ?>
		        	                        	<label class="mt-2 ml-5" for="act_fotografia_lateral_der"><strong>Fotografia Actual: </strong> No hay fotografia cargada</label>
		        	                		<?php } else{ ?>
		        	                        	<label class="mt-2 ml-5" for="act_fotografia_lateral_der"><strong>Documento Actual: </strong> <a href="<?php echo $link.$listarFotografiasId[0]['fotografia_lateral_der'];?>" target="_blank"><?php echo $listarFotografiasId[0]['fotografia_lateral_der'] ?></a></label>
		        	                		<?php }  ?>         
                                        </div>              
                                    </div>
                        	</div>

						<!--PROPIETARIO-->
	                   		<div id="tabs-4">
		                   		
	                   			<!-- ACTUALIZAR DATOS PROPIETARIO -->
	                   			
	                   			    <!--  TIPO PROPIETARIO   -->  
                                        <div class="row  mt-3 " id="tipoPropietario_act">
                                            <div class="label">
                                                <label>Tipo Propietario</label>
                                            </div>
                                            <div class="input">
                                                <select class="form-control" required="required" name="tipo_propietario" id="tipo_propietario_act">
                                                	<option value="0">Seleccionar</option>
                                                	option
                                                    <option value="PN" <?php if($lvi['tipo_propietario'] == 'PN'){ ?> selected="selected" <?php } ?>>Persona Natural</option>
                                                    <option value="PJ" <?php if($lvi['tipo_propietario'] == 'PJ'){ ?> selected="selected" <?php } ?>>Persona Juridica</option>
                                                    
                                                </select>
                                                <input type="hidden" name="tipo_propietario_act" id="tipo_propietario_act" value="<?php echo $lvi['tipo_propietario']; ?>" class="form-control">
                                            </div>              
                                        </div>

                                    <!-- PROPIEDAD DE   -->  
                                        <div class="row  mt-3 mb-3" id="propiedad_act" >
                                            <div class="label">
                                                <label>Propiedad de</label>
                                            </div>
                                            <div class="input">
                                                <select class="form-control" required="required" name="propiedad">
                                                    
                                                    <option value="0" >Seleccionar</option>
                                                    <option value="Propia" <?php if ($lvi['propiedad'] == 'Propia'){ ?> selected="selected" <?php } ?>>Propio</option>
                                                    <option value="Leasing" <?php if ($lvi['propiedad'] == 'Leasing'){ ?> selected="selected" <?php } ?>>Leasing</option>
                                                    <option value="Fiduciaria" <?php if ($lvi['propiedad'] == 'Fiduciaria'){ ?> selected="selected" <?php } ?>>Fiduciaria</option>
                                                </select>
                                                <input type="hidden" name="propiedad_act" id="propiedad_act" value="<?php echo $lvi['propiedad'] ?>">
                                            </div>              
                                        </div>

		                   			<!-- NOMBRES Y APELLIDOS --> 
			                   		   
			                   		    <div class="row  mb-3" id="nombre_act" >
			                   		       	<div class="label">
			                   		       		<label>Nombres y Apellidos</label>
			                   		       	</div>
			                   		       	<div class="input">
			                   		       		<input type="text" name="nombre_propietario" id="nombre_propietario" class="form-control" value="<?php echo $listarPropietariosPorId[0]['nombre'] ?>">

			                   		       		<input type="hidden" name="nombre_propietario_act" id="nombre_propietario_act" class="form-control" value="<?php echo $listarPropietariosPorId[0]['nombre'] ?>">
			                   		       	</div>      		
			                   		    </div>
									
									<!-- CEDULA --> 
			                   		    <div class="row  mb-3"  id="cedula_act" >
			                   		       	<div class="label">
			                   		       		<label>Numero Documento o Nit</label>
			                   		       	</div>
			                   		       	<div class="input">
			                   		       		<input type="text" name="numero_documento_act" id="numero_documento_act" class="form-control" value="<?php echo $listarPropietariosPorId[0]['usuario'] ?>" disabled="true" readonly="readonly">
			                   		       	</div>      		
			                   		    </div>

			                   		<!-- CORREO ELECTRONICO --> 
			                   		    
			                   		    <div class="row  mb-3"  id="correo_act" >
			                   		       	<div class="label">
			                   		       		<label>Correo Electronico</label>
			                   		       	</div>
			                   		       	<div class="input">
			                   		       		<input type="text" name="correo_electronico" id="correo_electronico" class="form-control" value="<?php echo $listarPropietariosPorId[0]['correo_electronico'] ?>">

			                   		       		<input type="hidden" name="correo_electronico_act" id="correo_electronico_act" class="form-control" value="<?php echo $listarPropietariosPorId[0]['correo_electronico'] ?>">
			                   		       	</div>      		
			                   		    </div>

			                   		<!-- TELEFONO --> 
			                   		    <div class="row  mb-3"  id="telefono_act" >
			                   		       	<div class="label">
			                   		       		<label>Telefono</label>
			                   		       	</div>
			                   		       	<div class="input">
			                   		       		<input type="text" name="telefono_propietario" id="telefono_propietario" class="form-control" value="<?php echo $lvi['telefono_propietario'] ?>">

			                   		       		<input type="hidden" name="telefono_propietario_act" id="telefono_propietario_act" class="form-control" value="<?php echo $lvi['telefono_propietario'] ?>">
			                   		       	</div>      		
			                   		    </div>

			                   		<!-- FECHA NACIMIENTO --> 
			                   		    <div class="row  mb-3"  id="fecha_nac_propietario_act" >
			                   		       	<div class="label">
			                   		       		<label>Fecha Nacimiento</label>
			                   		       	</div>
			                   		       	<div class="input">
			                   		       		<input type="date" name="fecha_nac_propietario" id="fecha_nac_propietario" class="form-control" value="<?php echo $lvi['fecha_nac_propietario'] ?>" >

			                   		       		<input type="hidden" name="fecha_nac_propietario_act" id="fecha_nac_propietario_act" class="form-control" value="<?php echo $lvi['fecha_nac_propietario'] ?>">
			                   		       	</div>      		
			                   		    </div>

			                   		<!-- DIRECCION  --> 
			                   		    <div class="row  mb-3"  id="direccion_act" >
			                   		       	<div class="label">
			                   		       		<label>Dirección</label>
			                   		       	</div>
			                   		       	<div class="input">
			                   		       		<input type="text" name="direccion_propietario" id="direccion_propietario" class="form-control" value="<?php echo $lvi['direccion_propietario'] ?>">

			                   		       		<input type="hidden" name="direccion_propietario_act" id="direccion_propietario_act" class="form-control" value="<?php echo $lvi['direccion_propietario'] ?>">
			                   		       	</div>      		
			                   		    </div>

			                   		<!-- CIUDAD --> 
			                   		    <div class="row  mb-3"  id="ciudad_act">
			                   		       	<div class="label">
			                   		       		<label>Ciudad Residencia</label>
			                   		       	</div>
			                   		       	<div class="input">
			                   		       		<input type="text" name="ciudad_propietario" id="ciudad_propietario" class="form-control" value="<?php echo $lvi['ciudad_propietario'] ?>">

			                   		       		<input type="hidden" name="act_ciudad_propietario" id="act_ciudad_propietario" class="form-control" value="<?php echo $lvi['ciudad_propietario_act'] ?>">
			                   		       	</div>      		
			                   		    </div>

	                                <!-- CAMARA DE COMERCIO -->
	                                        <div class="row  mt-3 ">
	                                            <div class="label">
	                                                <label>Camara de Comercio</label>
	                                            </div>
	                                            <?php if ($CC == 1) { ?>
		                                            <div class="input">
		                                                <input type="file" name="camara_comercio" id="camara_comercio" class="form-control" disabled>
														<input type="hidden" name="act_camara_comercio" id="act_camara_comercio" class="form-control" value="<?php echo $lvi['camara_comercio'] ?>">
		                                            </div>
		                                        <?php } else { ?>   
		                                        	<div class="input">
		                                                <input type="file" name="camara_comercio" id="camara_comercio" class="form-control" >
														<input type="hidden" name="act_camara_comercio" id="act_camara_comercio" class="form-control" value="<?php echo $lvi['camara_comercio'] ?>">
		                                            </div>           
		                                        <?php } ?>              
	                                        </div>

											<?php if ($CC == 1) { ?>
		        	                       		<label class="mt-3 ml-5" for="act_camara_comercio"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN.</strong></label>
			        	                	<?php } else if ($lvi['camara_comercio'] == '') { ?>
												<label class="mt-2 ml-5" for="act_camara_comercio"><strong>Documento Actual: </strong> No hay documento cargado</label>
											<?php } else{ ?>
												<label class="mt-2 ml-5" for="act_camara_comercio"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['camara_comercio'];?>" target="_blank"><?php echo $lvi['camara_comercio'] ?></a></label>
											<?php }  ?>

	                                <!-- CONTRATO LEASING o FIDUCIA -->
	                                        <div class="row  mt-3 ">
	                                            <div class="label">
	                                                <label>Contrato Leasing o Fiducia</label>
	                                            </div>
	                                            <?php if ($CB == 1) { ?>
		                                            <div class="input">
		                                                <input type="file" name="contrato_banco"  id="contrato_banco" class="form-control" disabled>
														<input type="hidden" name="act_contrato_banco" id="act_contrato_banco" class="form-control" value="<?php echo $lvi['contrato_banco'] ?>">
		                                            </div>        
		                                        <?php } else { ?>
		                                        	<div class="input">
		                                                <input type="file" name="contrato_banco"  id="contrato_banco" class="form-control" >
														<input type="hidden" name="act_contrato_banco" id="act_contrato_banco" class="form-control" value="<?php echo $lvi['contrato_banco'] ?>">
		                                            </div>
		                                        <?php } ?>      
	                                        </div>

											<?php if ($CB == 1) { ?>
		        	                       		<label class="mt-3 ml-5" for="act_contrato_banco"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN.</strong></label>
			        	                	<?php } else if ($lvi['contrato_banco'] == '') { ?>
												<label class="mt-2 ml-5" for="act_contrato_banco"><strong>Documento Actual: </strong> No hay documento cargado</label>
											<?php } else{ ?>
												<label class="mt-2 ml-5" for="act_contrato_banco"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['contrato_banco'];?>" target="_blank"><?php echo $lvi['contrato_banco'] ?></a></label>
											<?php }  ?>

	                                <!-- HOJA DE VIDA -->
	                                        <div class="row  mt-3 ">
	                                            <div class="label">
	                                                <label>Hoja de Vida</label>
	                                            </div>
	                                            <?php if ($HV == 1) { ?>
		                                            <div class="input">
		                                                <input type="file" name="hoja_vida"  id="hoja_vida" class="form-control" disabled>
														<input type="hidden" name="act_hoja_vida" id="act_hoja_vida" class="form-control" value="<?php echo $lvi['hoja_vida'] ?>">
		                                            </div>              
		                                        <?php } else { ?>
		                                        	<div class="input">
		                                                <input type="file" name="hoja_vida"  id="hoja_vida" class="form-control" >
														<input type="hidden" name="act_hoja_vida" id="act_hoja_vida" class="form-control" value="<?php echo $lvi['hoja_vida'] ?>">
		                                            </div>  
		                                        <?php } ?>
	                                        </div>

											<?php if ($HV == 1) { ?>
		        	                       		<label class="mt-3 ml-5" for="act_hoja_vida"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN.</strong></label>
			        	                	<?php } else if ($lvi['hoja_vida'] == '') { ?>
												<label class="mt-2 ml-5" for="act_hoja_vida"><strong>Documento Actual: </strong> No hay documento cargado</label>
											<?php } else{ ?>
												<label class="mt-2 ml-5" for="act_hoja_vida"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['hoja_vida'];?>" target="_blank"><?php echo $lvi['hoja_vida'] ?></a></label>
											<?php }  ?>
		
	                                <!-- RUT -->
	                                        <div class="row  mt-3 ">
	                                            <div class="label">
	                                                <label>Registro Único Tributario (RUT)</label>
	                                            </div>
	                                            <?php if ($RUT == 1) { ?>
		                                            <div class="input">
		                                                <input type="file" name="rut"  id="rut" class="form-control" disabled>
														<input type="hidden" name="act_rut" id="act_rut" class="form-control" value="<?php echo $lvi['rut'] ?>">
		                                            </div>        
	                                            <?php } else { ?>
	                                        		<div class="input">
		                                                <input type="file" name="rut"  id="rut" class="form-control" >
														<input type="hidden" name="act_rut" id="act_rut" class="form-control" value="<?php echo $lvi['rut'] ?>">
		                                            </div> 
	                                            <?php } ?>      
	                                        </div>

											<?php if ($RUT == 1) { ?>
		        	                       		<label class="mt-3 ml-5" for="act_rut"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN.</strong></label>
			        	                	<?php } else if ($lvi['rut'] == '') { ?>
												<label class="mt-2 ml-5" for="act_rut"><strong>Documento Actual: </strong> No hay documento cargado</label>
											<?php } else{ ?>
												<label class="mt-2 ml-5" for="act_rut"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['rut'];?>" target="_blank"><?php echo $lvi['rut'] ?></a></label>
											<?php }  ?>

	                                <!-- PODER APODERADO -->
	                                        <div class="row  mt-3 ">
	                                            <div class="label">
	                                                <label>Poder Apoderado</label>
	                                            </div>
	                                            <?php if ($PA == 1) { ?>
		                                            <div class="input">
		                                                <input type="file" name="poder_apoderado"  id="poder_apoderado" class="form-control" disabled>
														<input type="hidden" name="act_poder_apoderado" id="act_poder_apoderado" class="form-control" value="<?php echo $lvi['poder_apoderado'] ?>">
		                                            </div>    
		                                        <?php } else { ?>
		                                            <div class="input">
		                                                <input type="file" name="poder_apoderado"  id="poder_apoderado" class="form-control" >
														<input type="hidden" name="act_poder_apoderado" id="act_poder_apoderado" class="form-control" value="<?php echo $lvi['poder_apoderado'] ?>">
		                                            </div>
		                                        <?php } ?>              
	                                        </div>
											<?php if ($PA == 1) { ?>
		        	                       		<label class="mt-3 ml-5" for="act_poder_apoderado"><strong style="color: royalblue; font-size: .9rem;"><i style="font-size: 1.5rem;" class="fa fa-clock-o fa-spin"></i> ESTE DOCUMENTO ESTÁ EN REVISIÓN DE APROBACIÓN.</strong></label>
			        	                	<?php } else if ($lvi['poder_apoderado'] == '') { ?>
												<label class="mt-2 ml-5" for="act_poder_apoderado"><strong>Documento Actual: </strong> No hay documento cargado</label>
											<?php } else{ ?>
												<label class="mt-2 ml-5" for="act_poder_apoderado"><strong>Documento Actual: </strong> <a href="<?php echo $link.$lvi['poder_apoderado'];?>" target="_blank"><?php echo $lvi['poder_apoderado'] ?></a></label>
											<?php }  ?>
									
							</div>

                        <!--REFERENCIAS-->

                            <div id="tabs-5">

                                <!-- REFERENCIAS COMERCIALES -->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Referencias Comerciales</p>
                                    </div>
                                    <?php foreach ($listarPorTipoReferenciaComercial as $lrc){ ?>
                                    	<input type="hidden" name="id_referencia_rc" value="<?php echo $lrc['id_referencia'] ?>">
                                    	<input type="hidden" name="estado_rc" value="<?php echo $lrc['estado'] ?>">
                                    	<?php if ($comercial >= 1){ ?>
                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
		                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Nombre</label>
		                                            <input type="text" name="nombre_rc" id="nombre_rc" value="<?php echo $lrc['nombre_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_nombre_rc" value="<?php echo $lrc['nombre_referencia'] ?>">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Telefono</label>
		                                            <input type="text" name="telefono_rc" id="telefono_rc" value="<?php echo $lrc['telefono_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_telefono_rc" value="<?php echo $lrc['nombre_referencia'] ?>">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Dirección</label>
		                                            <input type="text" name="direccion_rc" id="direccion_rc" value="<?php echo $lrc['direccion_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_direccion_rc" value="<?php echo $lrc['nombre_referencia'] ?>">
		                                        </div>
	                                    	</div>
	                                    <?php } ?>
	                                <?php } ?>

	                                <?php if ($comercial == 0){ ?>
	                                	
                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
		                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Nombre</label>
		                                            <input type="text" name="nombre_rc" id="nombre_rc" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Telefono</label>
		                                            <input type="text" name="telefono_rc" id="telefono_rc" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Dirección</label>
		                                            <input type="text" name="direccion_rc" id="direccion_rc" class="form-control">
		                                        </div>
	                                    	</div>
	                                <?php } ?>

	                            <!-- REFERENCIAS LABORALES -->
                                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
		                                <p>Referencias Laborales</p>
		                            </div>
									<?php foreach ($listarPorTipoReferenciaLaboral as $lrl){ ?>
										<input type="hidden" name="id_referencia_rl" value="<?php echo $lrl['id_referencia'] ?>">
                                    	<input type="hidden" name="estado_rl" value="<?php echo $lrl['estado'] ?>">
		                                <?php if ($laboral >= 1){ ?>
		                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Nombre</label>
		                                            <input type="text" name="nombre_rl" id="nombre_rl" value="<?php echo $lrl['nombre_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_nombre_rl" id="act_nombre_rl" value="<?php echo $lrl['nombre_referencia'] ?>" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Telefono</label>
		                                            <input type="text" name="telefono_rl" id="telefono_rl" value="<?php echo $lrl['telefono_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_telefono_rl" id="act_telefono_rl" value="<?php echo $lrl['telefono_referencia'] ?>" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Dirección</label>
		                                            <input type="text" name="direccion_rl" id="direccion_rl" value="<?php echo $lrl['direccion_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_direccion_rl" id="act_direccion_rl" value="<?php echo $lrl['direccion_referencia'] ?>" class="form-control">
		                                        </div>
		                                    </div>
										<?php } ?>
			                        <?php } ?>

			                        <?php if ($laboral == 0){ ?>
	                                	
                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
		                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Nombre</label>
		                                            <input type="text" name="nombre_rl" id="nombre_rl" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Telefono</label>
		                                            <input type="text" name="telefono_rl" id="telefono_rl" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Dirección</label>
		                                            <input type="text" name="direccion_rl" id="direccion_rl" class="form-control">
		                                        </div>
	                                    	</div>
	                                <?php } ?>

	                            <!-- REFERENCIAS FAMILIARES -->
                                  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
		                                <p>Referencias Familiares</p>
		                            </div>
									<?php foreach ($listarPorTipoReferenciaFamiliar as $lrf){ ?>
										<input type="hidden" name="id_referencia_rf" value="<?php echo $lrf['id_referencia'] ?>">
                                    	<input type="hidden" name="estado_rf" value="<?php echo $lrf['estado'] ?>">
										<?php if ($familiar >= 1){ ?>
		                                    
		                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Nombre</label>
		                                            <input type="text" name="nombre_rf" id="nombre_rf" value="<?php echo $lrf['nombre_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_nombre_rf" id="act_nombre_rf" value="<?php echo $lrf['nombre_referencia'] ?>" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Telefono</label>
		                                            <input type="text" name="telefono_rf" id="telefono_rf" value="<?php echo $lrf['telefono_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_telefono_rf" id="act_telefono_rf" value="<?php echo $lrf['telefono_referencia'] ?>" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Dirección</label>
		                                            <input type="text" name="direccion_rf" id="direccion_rf" value="<?php echo $lrf['direccion_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_direccion_rf" id="act_direccion_rf" value="<?php echo $lrf['direccion_referencia'] ?>" class="form-control">
		                                        </div>
		                                    </div>
		                            	<?php } ?>
		                            <?php } ?>

		                            <?php if ($familiar == 0){ ?>
	                                	
                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
		                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Nombre</label>
		                                            <input type="text" name="nombre_rf" id="nombre_rf" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Telefono</label>
		                                            <input type="text" name="telefono_rf" id="telefono_rf" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Dirección</label>
		                                            <input type="text" name="direccion_rf" id="direccion_rf" class="form-control">
		                                        </div>
	                                    	</div>
	                                <?php } ?>

	                            <!-- REFERENCIAS PERSONALES -->
	                            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
		                                <p>Referencias Personales</p>
		                            </div>
                                	<?php foreach ($listarPorTipoReferenciaPersonal as $lrp){ ?>
                                		<input type="hidden" name="id_referencia_rp" value="<?php echo $lrp['id_referencia'] ?>">
                                    	<input type="hidden" name="estado_rp" value="<?php echo $lrp['estado'] ?>">
		                                <?php if ($personal >= 1){ ?>
		                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Nombre</label>
		                                            <input type="text" name="nombre_rp" id="nombre_rp" value="<?php echo $lrp['nombre_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_nombre_rp" id="act_nombre_rp" value="<?php echo $lrp['nombre_referencia'] ?>" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Telefono</label>
		                                            <input type="text" name="telefono_rp" id="telefono_rp" value="<?php echo $lrp['telefono_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_telefono_rp" id="act_telefono_rp" value="<?php echo $lrp['telefono_referencia'] ?>" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Dirección</label>
		                                            <input type="text" name="direccion_rp" id="direccion_rp" value="<?php echo $lrp['direccion_referencia'] ?>" class="form-control">
		                                            <input type="hidden" name="act_direccion_rp" id="act_direccion_rp" value="<?php echo $lrp['direccion_referencia'] ?>" class="form-control">
		                                        </div>
		                                    </div>
		                                <?php } ?>
		                            <?php } ?> 

		                            <?php if ($personal == 0){ ?>
	                                	
                                    		<div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5; margin-top: 2px;">
		                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Nombre</label>
		                                            <input type="text" name="nombre_rp" id="nombre_rp" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Telefono</label>
		                                            <input type="text" name="telefono_rp" id="telefono_rp" class="form-control">
		                                        </div>
		                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		                                            <label>Dirección</label>
		                                            <input type="text" name="direccion_rp" id="direccion_rp" class="form-control">
		                                        </div>
	                                    	</div>
	                                <?php } ?>  

                            </div>
					</div>

                <?php } ?>


                  
                <section class="row mt-5 d-flex justify-content-center">
                    
                    <!-- CANCELAR REGISTRO -->
                        <a href="inicioPropietarios.php" class="btn btn-outline-danger col-xs-10 col-sm-10 col-md-3 col-lg-3 m-1">Cancelar</a>
                    
                    <!-- REGISTRAR -->
                        <button type="submit" id="Actualizar" class="btn btn-outline-info col-xs-10 col-sm-10 col-md-3 col-lg-3 m-1">Solicitar Actualización</button>
                
                </section>

	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	 $( function() {

            $( "#datepicker" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']

            });

            $( "#datepicker1" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#datepicker2" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#datepicker3" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#datepicker4" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	maxDate: "+2M",
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'] 
			});

            $( "#datepicker5" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#datepicker6" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#datepicker7" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#datepicker8" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });
			
			$( "#fecha_registro" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

        } );

    	$( function() {
            $( "#tabs" ).tabs();
        } );

         $( function(){
            $("#id_contratoA").chosen(); 
        });

        function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }

        function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var nombres = [<?php foreach($ciudades as $ct){ ?> "<?php echo $ct['ciudad'];?>", <?php } ?> ];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("ciudad_registro"), nombres);

    </script>
</body>
</html>
