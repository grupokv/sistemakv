<?php 

include ("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/ReferenciasPropietarioVehiculo.php");
require_once("../Modelo/FotografiaVehiculo.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/Cliente-Convenio.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicio.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Ciudad.php");

$ciudad = new Ciudad();
$ciudades = $ciudad->listar();

if (($_SESSION['id_perfil'] == 3) || ($_SESSION['id_perfil'] == 2) || ($_SESSION['id_perfil'] == 8)) {
	$redireccion = 'inicioConductores.php';
}else{
	$redireccion = 'vehiculos.php';
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


$empresaConvenio = new Cliente_Convenio();
$listarEmpresasConvenio = $empresaConvenio->listar();

$paises = Paises();

$listarEmpresaConvenioPorVehiculo = $empresaConvenio->listarEmpresaConvenioPorVehiculo($id_vehiculo);

$cantEmpVeh = count($listarEmpresaConvenioPorVehiculo);
$empresaConvenio_ID = $empresaConvenio->cliente_ID($listarEmpresaConvenioPorVehiculo[0]['id_cliente']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Vehiculo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
	    <?php include("Template/styles.php"); ?>
    	<link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    	<style>
	        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
	            background: #1b2d3b !important;
	            border: #fff;
	        }
	    </style>
    <!-- FIN STYLES -->
	
</head>
<body>

	<!-- MENU -->
	    <?php include("Template/header.php"); ?>
	    <?php include("Template/newMenu.php"); ?>
    <!-- FIN MENU -->

    <!-- ************************************ -->

    <!-- CONTENIDO -->

	    <section class="home_content">

			<div aria-label="breadcrumb" class="mt-1"> 
		         <ol class="breadcrumb" style="background-color: #fff;">
		            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
		            <li class="breadcrumb-item " aria-current="page"><a href="vehiculos.php">Vehiculos</a></li>
		            <li class="breadcrumb-item active" aria-current="page">Actualizar vehiculo</li>
		         </ol>
		    </div>

		    <section class="form-usuarios mt-1">
		        <div class="formulario mb-5">
			        <form action="../Controlador/actualizarVehi.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">

		                <?php foreach ($listarVehiId as $lvi){ ?>

		          	        <!--ID VEHICULO-->
		          	            <input type="hidden" name="id_vehiculo" id="id_vehiculo" class="form-control" value="<?php echo $lvi['id_vehiculo'] ?>" >
	                
	                        <!--ESTADO-->
		          	            <input type="hidden" name="estado" id="estado" class="form-control" value="<?php echo $lvi['estado'] ?>">
		          
			                <!--ID PROPIETARIO-->
			                    <input type="hidden" name="id_propietario" id="id_propietario" class="form-control" value="<?php echo $lvi['id_propietario'] ?>">

					        <div id="tabs" class="mt-3">
			                    <ul>
			                      <li><a href="#tabs-1">Información </a></li>
		                          <li><a href="#tabs-2">Documentación </a></li>
		                          <li><a href="#tabs-3">Fotografias</a></li>
		                          <li><a href="#tabs-4">Propietario</a></li>
		                          <li><a href="#tabs-5">Referencias Propietario</a></li>
		                          <li><a href="#tabs-6">Contrato</a></li>
		                          <li><a href="#tabs-7">Flota propia</a></li>
		                          <li><a href="#tabs-8">Empresa Conv</a></li>
			                    </ul>

			                    <!-- INFORMACION BASICA-->
				                    <div id="tabs-1">
				                    	
			                    	    <!-- TIPO VEHICULO -->
				                    		<div class="row mb-3 ">
				                    		    <div class="label">
				                    		       	<label>Tipo Vehiculo</label>
				                    		    </div>
				                    		    <div class="input">
				                    		       	<select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_tipo_vehiculo" id="id_tipo_vehiculo">
				                    		            <?php foreach ($listarTV as $ltv){ ?>
				                    		                <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>" <?php if($ltv['id_tipo_vehiculo'] == $lvi['id_tipo_vehiculo']){?> selected = "selected"<?php }  ?>>
				                    		                        <?php echo $ltv['nombre_tipo_vehiculo'] ?>
				                    		                </option>
				                    		            <?php } ?>
				                    		        </select>
				                    		        <input type="hidden" name="id_tipo_vehiculo_act" id="id_tipo_vehiculo_act" class="form-control" value="<?php echo $lvi['id_tipo_vehiculo'] ?>">
				                    		    </div>      		
				                    		</div>

		                                <!-- TIPO SERVICIO-->
		                    		       	<div class="row mb-3 ">
		                    		       		<div class="label">
		                    		       			<label>Tipo servicio</label>
		                    		       		</div>
		                    		       		<div class="input">
		                    		       			<select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_tipo_servicio" id="id_tipo_servicio">
		                    		       				<option >Seleccionar</option>
		                    		                    <?php foreach ($listarTS as $lts){ ?>
		                    		                        <option value="<?php echo $lts['id_tipo_servicio'] ?>" <?php if($lts['id_tipo_servicio'] == $lvi['id_tipo_servicio']){?> selected = "selected"<?php }  ?>>
		                    		                                <?php echo $lts['nombre_tipo_servicio'] ?>
		                    		                        </option>
		                    		                    <?php } ?>
		                    		                </select>
		                    		                <input type="hidden" name="id_tipo_servicio_act" id="id_tipo_servicio_act" class="form-control" value="<?php echo $lvi['id_tipo_servicio'] ?>">
		                    		       		</div>      		
		                    		       	</div>

		                    		    <!--PLACA-->
											<div class="row mb-3 ">
				                    		    <div class="label">
				                    		       	<label>Placa</label>
				                    		    </div>
				                    		    <div class="input">
				                    		       	<input type="text" name="placa" id="placa" class="form-control form-control-sm" readonly value="<?php echo $lvi['placa']; ?>">
				                    		       	<input type="hidden" name="placa_act" id="placa_act" class="form-control" value="<?php echo $lvi['placa']; ?>">
				                    		    </div>      		
				                    		</div>																					

				                    	<!-- CANT PASAJEROS -->
		                                    <div class="row mb-3 ">
				                    		    <div class="label">
				                    		       	<label>Cantidad de pasajeros</label>
				                    		    </div>
				                    		    <div class="input">
				                    		       	<input type="number" name="cant_pasajeros" id="cant_pasajeros" class="form-control form-control-sm" value="<?php echo $lvi['cant_pasajeros'] ?>">
				                    		       	<input type="hidden" name="cant_pasajeros_act" id="cant_pasajeros_act" class="form-control" value="<?php echo $lvi['cant_pasajeros'] ?>" >
				                    		    </div>      		
				                    		</div>

		                    	        <!-- MARCA -->
			                    		    <div class="row  mb-3">
			                    		       	<div class="label">
			                    		       		<label>Marca y Linea</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="text" name="marca" id="marca" class="form-control form-control-sm" value="<?php echo $lvi['marca'] ?>">
			                    		       		<input type="hidden" name="marca_act" id="marca_act" class="form-control" value="<?php echo $lvi['marca'] ?>">
			                    		        </div>      		
			                    		    </div>

		                    	        <!-- MODELO-->
		                    	   
			                    		    <div class="row  mb-3">
			                    		       	<div class="label">
			                    		       		<label>Modelo</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="text" maxlength="4" name="modelo" id="modelo" class="form-control form-control-sm" value="<?php echo $lvi['modelo'] ?>">
			                    		       		<input type="hidden" maxlength="4" name="modelo_act" id="modelo_act" class="form-control" value="<?php echo $lvi['modelo'] ?>" >
			                    		       	</div>      		
			                    		    </div>

										<!-- TIPO DE AFILIACIÓN -->
                                            <div class="row  mt-3 ">
                                                <div class="label">
                                                    <label>Tipo Afiliación<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                                </div>
                                                <div class="input">
                                                    <select name="tipo_afiliacion" id="tipo_afiliacion" class="form-control form-control-sm selectpicker" data-live-search="true" title="SELECCIONAR">
                                                        <option value="TERCERO" <?php if($lvi['tipo_afiliacion'] == 'TERCERO'){ ?> selected <?php } ?> >EXTERNO (TERCERO)</option>
                                                        <option value="AFILIADO" <?php if($lvi['tipo_afiliacion'] == 'AFILIADO'){ ?> selected <?php } ?> >AFILIADO</option>
                                                    </select>
                                                </div>              
                                            </div>

                                            <input type="hidden" name="tipo_afiliacion_act" id="tipo_afiliacion_act" value="<?php echo $lvi['tipo_afiliacion']; ?>">

                                            <?php if($lvi['tipo_afiliacion'] == 'TERCERO'){	 ?>

                                                <div class="row m-3 p-3" id="empresa_afiliada" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <label>Empresa Afiliada</label>
                                                        <input type="text" name="empresa_afiliada" id="empresa_afiliada" class="form-control form-control-sm" placeholder="Razon Social" value="<?php echo $lvi['empresa_afiliada']; ?>">     
                                                        <input type="hidden" name="empresa_afiliada_act" id="empresa_afiliada_act" value="<?php echo $lvi['empresa_afiliada']; ?>">     
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <label>NIT Empresa Afiliada</label>
                                                        <input type="text" name="nit_empresa_afiliada" id="nit_empresa_afiliada" class="form-control form-control-sm" placeholder="NIT" value="<?php echo $lvi['nit_empresa_afiliada']; ?>">     
                                                        <input type="hidden" name="nit_empresa_afiliada_act" id="nit_empresa_afiliada_act" value="<?php echo $lvi['nit_empresa_afiliada']; ?>">
                                                    </div>
                                                </div>   

                                            <?php }else{ ?>

                                                <div class="row m-3 p-3" id="empresa_afiliada" style="border: 1px dashed #d3d3d3; border-radius:5px; display:none;">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <label>Empresa Afiliada</label>
                                                        <input type="text" name="empresa_afiliada" id="empresa_afiliada" class="form-control form-control-sm" placeholder="Razon Social" value="<?php echo $lvi['empresa_afiliada']; ?>">     
                                                        <input type="hidden" name="empresa_afiliada_act" id="empresa_afiliada_act" value="<?php echo $lvi['empresa_afiliada']; ?>">     
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <label>NIT Empresa Afiliada</label>
                                                        <input type="text" name="nit_empresa_afiliada" id="nit_empresa_afiliada" class="form-control form-control-sm" placeholder="NIT" value="<?php echo $lvi['nit_empresa_afiliada']; ?>">     
                                                        <input type="hidden" name="nit_empresa_afiliada_act" id="nit_empresa_afiliada_act" value="<?php echo $lvi['nit_empresa_afiliada']; ?>">     
                                                    </div>
                                                </div>   

                                            <?php } ?>

			                    		<!--NUMERO MOVIL-->
											<div class="row mt-3">
			                    		       	<div class="label">
			                    		       		<label>Numero movil</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		 <input type="text" name="movil" id="movil" class="form-control form-control-sm" value="<?php echo $lvi['numero_movil'] ?>">
			                    		       		 <input type="hidden" name="movil_act" id="movil_act" class="form-control" value="<?php echo $lvi['numero_movil'] ?>">
			                    		       	</div>      		
			                    		    </div>													

	                        			<!--NUMERO DE MOTOR-->

											<div class="row mt-3">
			                    		       	<div class="label">
			                    		       		<label>Numero de motor</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="text" name="numero_motor" id="numero_motor" class="form-control form-control-sm" value="<?php echo $lvi['numero_motor'] ?>">
			                    		       		<input type="hidden" name="numero_motor_act" id="numero_motor_act" class="form-control" value="<?php echo $lvi['numero_motor'] ?>">
			                    		       	</div>      		
			                    		    </div>				
			                    			
	                        			<!--NUMERO DE CHASIS-->
											<div class="row mt-3">
			                    		       	<div class="label">
			                    		       		<label>Numero de chasis</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="text" name="numero_chasis" id="numero_chasis" class="form-control form-control-sm" value="<?php echo $lvi['numero_chasis'] ?>">
			                    		       		<input type="hidden" name="numero_chasis_act" id="numero_chasis_act" class="form-control" value="<?php echo $lvi['numero_chasis'] ?>">
			                    		       	</div>      		
			                    		    </div>	
			                    		    		              			
			                    		<!-- FECHA DE REGISTRO -->
											<div class="row mt-3">
			                    		       	<div class="label">
			                    		       		<label>Fecha Registro</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="text" name="fecha_registro" id="fecha_registro" class="form-control form-control-sm" value="<?php echo $lvi['fecha_registro'] ?>" required="required" >
			                    		       		<input type="hidden" name="fecha_registro_act" id="fecha_registro_act" class="form-control" value="<?php echo $lvi['fecha_registro'] ?>">
			                    		       		
			                    		       	</div>      		
			                    		    </div>
                                        <!-- CIUDAD DE REGISTRO -->
											<div class="row mt-3">
			                    		       	<div class="label">
			                    		       		<label>Ciudad Registro</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="text" name="ciudad_registro" id="ciudad_registro" class="form-control form-control-sm" value="<?php echo $lvi['ciudad_registro'] ?>" required="required" >
			                    		       		<input type="hidden" name="ciudad_registro_act" id="ciudad_registro_act" class="form-control" value="<?php echo $lvi['ciudad_registro'] ?>" >
			                    		       		
			                    		       	</div>      		
			                    		    </div>
                                        <!-- NUMERO DE PUERTAS -->
											<div class="row mt-3">
			                    		       	<div class="label">
			                    		       		<label>Numero de Puertas</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="number" name="num_puertas" id="num_puertas" class="form-control form-control-sm" value="<?php echo $lvi['num_puertas'] ?>" required="required" min="0" >
			                    		       		<input type="hidden" name="num_puertas_act" id="num_puertas_act" class="form-control" value="<?php echo $lvi['num_puertas'] ?>" >
			                    		       		
			                    		       	</div>      		
			                    		    </div>

                                        <!-- CILINDRAJE -->
											<div class="row mt-3">
			                    		       	<div class="label">
			                    		       		<label>Cilindraje</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="number" name="cilindraje" id="cilindraje" class="form-control form-control-sm" value="<?php echo $lvi['cilindraje'] ?>" required="required" min="0" >
			                    		       		<input type="hidden" name="cilindraje_act" id="cilindraje_act" class="form-control" value="<?php echo $lvi['cilindraje'] ?>" >
			                    		       		
			                    		       	</div>      		
			                    		    </div>
                                        <!-- TIPO CARROCERIA -->
											<div class="row mt-3">
			                    		       	<div class="label">
			                    		       		<label>Tipo Carroceria</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="text" name="tipo_carroceria" id="tipo_carroceria" class="form-control form-control-sm" value="<?php echo $lvi['tipo_carroceria'] ?>" required="required" >
			                    		       		<input type="hidden" name="tipo_carroceria_act" id="tipo_carroceria_act" class="form-control" value="<?php echo $lvi['tipo_carroceria'] ?>" >
			                    		       		
			                    		       	</div>      		
			                    		    </div>

                                        <!-- TIPO COMBUSTIBLE -->
											<div class="row mt-3">
			                    		       	<div class="label">
			                    		       		<label>Tipo Combustible</label>
			                    		       	</div>
			                    		       	<div class="input">
			                    		       		<input type="text" name="tipo_combustible" id="tipo_combustible" class="form-control form-control-sm" value="<?php echo $lvi['tipo_combustible'] ?>" required="required" >
			                    		       		<input type="hidden" name="tipo_combustible_act" id="tipo_combustible_act" class="form-control" value="<?php echo $lvi['tipo_combustible'] ?>" >
			                    		       		
			                    		       	</div>      		
			                    		    </div>

			                        </div>

			                    <!--DOCUMENTACION-->

			                        <div id="tabs-2">

                                        <!-- TARJETA DE OPERACIÓN -->
                                
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>Tarjeta de Operación</p>
                                            </div>

                                            <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                                    <?php if (($lvi['fecha_vencimiento_to'] == '0000-00-00') || ($lvi['tarjeta_operacion'] == '')){ ?>
                                                        <label>Documento Tarj. Operación <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado"></i></label>
                                                    <?php } else{ ?>
                                                        <label>Documento Tarj. Operación </label>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                    <?php if (($lvi['fecha_vencimiento_to'] == '0000-00-00') || ($lvi['tarjeta_operacion'] == '')){ ?>
                                                        <input type="file" name="tarjeta_operacion" id="tarjeta_operacion" class="form-control form-control-sm" style="border: 2px solid #349fd9;">
                                                    <?php } else{ ?>
                                                        <input type="file" name="tarjeta_operacion" id="tarjeta_operacion" class="form-control form-control-sm">
                                                    <?php } ?>
                                                </div>        
                                            </div>  

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label>Número Tarj. Operación</label>
                                                    <input type="text" value="<?php echo $lvi['num_tarjeta_operacion'] ?>" name="num_tarjeta_operacion" id="num_tarjeta_operacion" class="form-control form-control-sm">
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <?php if ($lvi['fecha_vencimiento_to'] < date('Y-m-d')){ ?>
                                                        <label>Vencimiento Tarj. Operación <i class="fa fa-exclamation-circle" style="color: red; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Vencido"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_to'] ?>" name="fecha_vencimiento_to" id="fecha_vencimiento_to" class="form-control form-control-sm" style="border: 2px solid red;">
                                                    <?php } else if (($lvi['fecha_vencimiento_to'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_to'] >= date('Y-m-d'))){ ?>	
                                                        <label>Vencimiento Tarj. Operación <i class="fa fa-exclamation-circle" style="color: orange; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Pronto a vencer"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_to'] ?>" name="fecha_vencimiento_to" id="fecha_vencimiento_to" class="form-control form-control-sm" style="border: 2px solid orange;">
                                                    <?php }else{ ?>
                                                        <label>Vencimiento Tarj. Operación</label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_to'] ?>" name="fecha_vencimiento_to" id="fecha_vencimiento_to" class="form-control form-control-sm">
                                                    <?php } ?>
                                                </div>           
                                            </div>

                                            <input type="hidden" name="num_tarjeta_operacion_act" id="num_tarjeta_operacion_act" class="form-control" value="<?php echo $lvi['num_tarjeta_operacion'] ?>">
                                            <input type="hidden" name="act_tarjeta_operacion"  id="act_tarjeta_operacion" value="<?php echo $lvi['tarjeta_operacion'] ?>">
                                            <input type="hidden" name="fecha_vencimiento_to_act" id="fecha_vencimiento_to_act"  value="<?php echo $lvi['fecha_vencimiento_to'] ?>">

                                            <?php if ($lvi['tarjeta_operacion'] == '') { ?>
                                                    <label class="mt-2 mb-4 ml-5" for="act_tarjeta_operacion"><strong>Documento Actual: </strong> No hay documentos cargados</label>
                                            <?php } else{ ?>
                                                    <label class="mt-2 mb-4 ml-5" for="act_tarjeta_operacion"><strong>Documento Actual: </strong> <?php echo $lvi['tarjeta_operacion'] ?></label>
                                            <?php }  ?>
                
                                            
                                        <!--  ---------------------  -->

                                        <!---------  LICENCIA  -------->

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>Licencia de Tránsito</p>
                                            </div>

                                            <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                                    <?php if (($lvi['fecha_vencimiento_lt'] == '0000-00-00') || ($lvi['licencia_transito'] == '')){ ?>
                                                        <label>Documento Licencia de Tránsito <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado"></i></label>
                                                    <?php } else{ ?>
                                                        <label>Documento Licencia de Tránsito</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                    <?php if (($lvi['fecha_vencimiento_lt'] == '0000-00-00') || ($lvi['licencia_transito'] == '')){ ?>
                                                        <input type="file" style="border: 2px solid #349fd9;" name="licencia_transito" id="licencia_transito" class="form-control form-control-sm" >
                                                    <?php } else{ ?>
                                                        <input type="file" name="licencia_transito" id="licencia_transito" class="form-control form-control-sm" >
                                                    <?php } ?>
                                                </div>        
                                            </div> 

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Número Lic. Tránsito</label>
                                                    <input type="text" name="num_licencia_transito" id="num_licencia_transito" class="form-control form-control-sm" value="<?php echo $lvi['num_licencia_transito']; ?>">     
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Expedición Lic. Tránsito</label>
                                                    <input type="text" name="fecha_vencimiento_lt" id="fecha_vencimiento_lt" class="form-control form-control-sm" value="<?php echo $lvi['fecha_vencimiento_lt']; ?>" >    
                                                </div>
                                            </div>   

                                            <input type="hidden" name="act_licencia_transito"  id="act_licencia_transito" value="<?php echo $lvi['licencia_transito'] ?>">
                                            <input type="hidden" name="fecha_vencimiento_lt_act" id="fecha_vencimiento_lt_act" value="<?php echo $lvi['fecha_vencimiento_lt'] ?>">
                                            <input type="hidden" name="num_licencia_transito_act" id="num_licencia_transito_act" value="<?php echo $lvi['num_licencia_transito'] ?>">  

                                            <?php if ($lvi['licencia_transito'] == '') { ?>
                                                    <label class="mt-2 mb-4 ml-5" for="act_licencia_transito"><strong>Documento Actual: </strong> No hay documentos cargados</label>
                                            <?php } else{ ?>
                                                    <label class="mt-2 mb-4 ml-5" for="act_licencia_transito"><strong>Documento Actual: </strong> <?php echo $lvi['licencia_transito'] ?></label>
                                            <?php }  ?> 

                                        <!--  ---------------------  -->
                                    
                                        <!----------- SOAT ------------>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>SOAT</p>
                                            </div>

                                            <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                                    <label>Documento SOAT</label>
                                                    <?php if (($lvi['soat'] == '') || ($lvi['fecha_vencimiento_soat'] == '0000-00-00')){ ?>
                                                        <label>Documento SOAT <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado."></i></label>
                                                    <?php }else{ ?>
                                                        <label>Documento SOAT </label>     
                                                    <?php } ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                    <?php if (($lvi['soat'] == '') || ($lvi['fecha_vencimiento_soat'] == '0000-00-00')){ ?>
                                                        <input type="file" name="soat" id="soat" class="form-control form-control-sm" style="border: 2px solid #349fd9;">
                                                    <?php }else{ ?>
                                                        <input type="file" name="soat" id="soat" class="form-control form-control-sm" >     
                                                    <?php } ?>
                                                </div>        
                                            </div>  

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label>Número SOAT</label>
                                                    <input type="text" name="num_soat" id="num_soat" class="form-control form-control-sm" value="<?php echo $lvi['num_soat'] ?>">
                                                </div>   
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <?php if ($lvi['fecha_vencimiento_soat'] < date('Y-m-d')){ ?>
                                                        <label>Vencimiento SOAT <i class="fa fa-exclamation-circle" style="color: red; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Vencido"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>" name="fecha_vencimiento_soat" id="fecha_vencimiento_soat" class="form-control form-control-sm" style="border: 2px solid red;">
                                                    <?php } else if (($lvi['fecha_vencimiento_soat'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_soat'] >= date('Y-m-d'))){ ?>	
                                                        <label>Vencimiento SOAT <i class="fa fa-exclamation-circle" style="color: orange; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Pronto a vencer"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>" name="fecha_vencimiento_soat" id="fecha_vencimiento_soat" class="form-control form-control-sm" style="border: 2px solid orange;">
                                                    <?php }else{ ?>
                                                        <label>Vencimiento SOAT </label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>" name="fecha_vencimiento_soat" id="fecha_vencimiento_soat" class="form-control form-control-sm">
                                                    <?php } ?>
                                                </div>           
                                            </div>  

                                            <input type="hidden" name="act_soat"  id="act_soat" value="<?php echo $lvi['soat'] ?>">
                                            <input type="hidden" name="num_soat_act" id="num_soat_act" value="<?php echo $lvi['num_soat'] ?>">
                                            <input type="hidden" name="fecha_vencimiento_soat_act" id="fecha_vencimiento_soat_act" value="<?php echo $lvi['fecha_vencimiento_soat'] ?>">

                                            <?php if ($lvi['soat'] == '') { ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_soat"><strong>Documento Actual: </strong> No hay documentos cargados</label>
                                            <?php } else{ ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_soat"><strong>Documento Actual: </strong> <?php echo $lvi['soat'] ?></label>
                                            <?php }  ?>  

                                        <!--  ---------------------  -->
                                        
                                        <!------- REVISION TECNOMECANICA ------>
                            
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>Revisión Tecnomecanica</p>
                                            </div>

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                                    <?php if (($lvi['revision_tecnomecanica'] == '') || ($lvi['fecha_vencimiento_rt'] == '0000-00-00')){ ?>
                                                        <label>Documento Rev. Tecnomecanica <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado."></i></label>
                                                    <?php }else{ ?>
                                                        <label>Documento Rev. Tecnomecanica</label>     
                                                    <?php } ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                    <?php if (($lvi['revision_tecnomecanica'] == '') || ($lvi['fecha_vencimiento_rt'] == '0000-00-00')){ ?>
                                                        <input type="file" name="revision_tecnomecanica" id="revision_tecnomecanica" class="form-control form-control-sm" style="border: 2px solid #349fd9;">
                                                    <?php }else{ ?>
                                                        <input type="file" name="revision_tecnomecanica" id="revision_tecnomecanica" class="form-control form-control-sm">     
                                                    <?php } ?>
                                                </div>
                                            </div>  

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
                                                    <label>Número Tecnomecanica</label>
                                                    <input type="text" name="num_revision_tecnomecanica" id="num_revision_tecnomecanica" class="form-control form-control-sm" value="<?php echo $lvi['num_revision_tecnomecanica'] ?>">    
                                                </div>   
                                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-6">
                                                    <?php if ($lvi['fecha_vencimiento_rt'] < date('Y-m-d')){ ?>
                                                        <label>Vencimiento Rev. Tecnomecanica <i class="fa fa-exclamation-circle" style="color: red; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Vencido"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>" name="fecha_vencimiento_rt" id="fecha_vencimiento_rt" class="form-control form-control-sm" style="border: 2px solid red;">
                                                    <?php } else if (($lvi['fecha_vencimiento_rt'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_rt'] >= date('Y-m-d'))){ ?>	
                                                        <label>Vencimiento Rev. Tecnomecanica <i class="fa fa-exclamation-circle" style="color: orange; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Pronto a vencer"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>" name="fecha_vencimiento_rt" id="fecha_vencimiento_rt" class="form-control form-control-sm" style="border: 2px solid orange;">
                                                    <?php }else{ ?>
                                                        <label>Vencimiento Rev. Tecnomecanica</label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>" name="fecha_vencimiento_rt" id="fecha_vencimiento_rt" class="form-control form-control-sm">
                                                    <?php } ?>
                                                </div>           
                                            </div>  

                                            <input type="hidden" name="act_revision_tecnomecanica" id="act_revision_tecnomecanica" value="<?php echo $lvi['revision_tecnomecanica'] ?>">
                                            <input type="hidden" name="num_revision_tecnomecanica_act" id="num_revision_tecnomecanica_act" value="<?php echo $lvi['num_revision_tecnomecanica'] ?>">
                                            <input type="hidden" name="fecha_vencimiento_rt_act" id="fecha_vencimiento_rt_act" value="<?php echo $lvi['fecha_vencimiento_rt'] ?>">
                                            
                                            <?php if ($lvi['revision_tecnomecanica'] == '') { ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_revision_tecnomecanica"><strong>Documento Actual: </strong> No hay documentos cargados</label>
                                            <?php } else{ ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_revision_tecnomecanica"><strong>Documento Actual: </strong> <?php echo $lvi['revision_tecnomecanica'] ?></label>
                                            <?php }  ?>

                                        <!--  -----------------------------  -->
                                        
                                        <!-------  PREVENTIVA -------->

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>Revisión Preventiva</p>
                                            </div>

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <?php if (($lvi['revision_preventiva'] == '') || ($lvi['fecha_vencimiento_rp'] == '0000-00-00')){ ?>
                                                        <label>Documento Rev. Preventiva <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado."></i></label>
                                                        <input type="file" name="revision_preventiva" id="revision_preventiva" class="form-control form-control-sm"  style="border: 2px solid #349fd9;">     
                                                    <?php }else{ ?>
                                                        <label>Documento Rev. Preventiva</label>
                                                        <input type="file" name="revision_preventiva" id="revision_preventiva" class="form-control form-control-sm"  >     
                                                    <?php } ?>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <?php if ($lvi['fecha_vencimiento_rp'] < date('Y-m-d')){ ?>
                                                        <label>Vencimiento Rev. Preventiva <i class="fa fa-exclamation-circle" style="color: red; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Vencido"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_rp'] ?>" name="fecha_vencimiento_rp" id="fecha_vencimiento_rp" class="form-control form-control-sm" style="border: 2px solid red;">     
                                                    <?php } else if (($lvi['fecha_vencimiento_rp'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_rp'] >= date('Y-m-d'))){ ?>	
                                                        <label>Vencimiento Rev. Preventiva <i class="fa fa-exclamation-circle" style="color: orange; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Pronto a vencer"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_rp'] ?>" name="fecha_vencimiento_rp" id="fecha_vencimiento_rp" class="form-control form-control-sm" style="border: 2px solid orange;">
                                                    <?php }else{ ?>
                                                        <label>Vencimiento Rev. Preventiva</label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_rp'] ?>" name="fecha_vencimiento_rp" id="fecha_vencimiento_rp" class="form-control form-control-sm">
                                                    <?php } ?>
                                                </div>
                                            </div>   

                                            <input type="hidden" name="act_revision_preventiva"  id="act_revision_preventiva" value="<?php echo $lvi['revision_preventiva'] ?>">
                                            <input type="hidden" name="fecha_vencimiento_rp_act" id="fecha_vencimiento_rp_act" value="<?php echo $lvi['fecha_vencimiento_rp'] ?>">

                                            <?php if ($lvi['revision_preventiva'] == '') { ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_revision_preventiva"><strong>Documento Actual: </strong> No hay documentos cargados</label>
                                            <?php } else{ ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_revision_preventiva"><strong>Documento Actual: </strong> <?php echo $lvi['revision_preventiva'] ?></label>
                                            <?php }  ?>

                                        <!--  ---------------------  -->
                
                                        <!-------- RCE  --------->

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>Póliza de RCC (Responsabilidad Civil Contractual)</p>
                                            </div>

                                            <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                                    <?php if (($lvi['poliza_contra'] == '') || ($lvi['fecha_vencimiento_contra'] == '0000-00-00')){ ?>
                                                        <label>Documento Póliza de RCC <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado."></i></label>
                                                    <?php }else{ ?>
                                                        <label>Documento Póliza de RCC</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                    <?php if (($lvi['poliza_contra'] == '') || ($lvi['fecha_vencimiento_contra'] == '0000-00-00')){ ?>
                                                        <input type="file" name="poliza_contra" id="poliza_contra" class="form-control form-control-sm" style="border: 2px solid #349fd9;">
                                                    <?php }else{ ?>
                                                        <input type="file" name="poliza_contra" id="poliza_contra" class="form-control form-control-sm" >
                                                    <?php } ?>
                                                </div>        
                                            </div>  

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label>Número Póliza de RCC</label>
                                                    <input type="text" name="num_poliza_contra" id="num_poliza_contra" class="form-control form-control-sm" value="<?php echo $lvi['num_poliza_contra'] ?>">
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                                                    <?php if ($lvi['fecha_vencimiento_contra'] < date('Y-m-d')){ ?>
                                                        <label>Vencimiento Póliza de RCC <i class="fa fa-exclamation-circle" style="color: red; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Vencido"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_contra'] ?>" name="fecha_vencimiento_contra" id="fecha_vencimiento_contra" class="form-control form-control-sm" style="border: 2px solid red;">     
                                                    <?php } else if (($lvi['fecha_vencimiento_contra'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_contra'] >= date('Y-m-d'))){ ?>	
                                                        <label>Vencimiento Póliza de RCC <i class="fa fa-exclamation-circle" style="color: orange; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Pronto a vencer"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_contra'] ?>" name="fecha_vencimiento_contra" id="fecha_vencimiento_contra" class="form-control form-control-sm" style="border: 2px solid orange;">
                                                    <?php }else{ ?>
                                                        <label>Vencimiento Póliza de RCC </label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_contra'] ?>" name="fecha_vencimiento_contra" id="fecha_vencimiento_contra" class="form-control form-control-sm">
                                                    <?php } ?>

                                                </div>           
                                            </div>  

                                            <input type="hidden" name="act_poliza_contra"  id="act_poliza_contra" value="<?php echo $lvi['poliza_contra']; ?>">
                                            <input type="hidden" name="num_poliza_contra_act"  id="num_poliza_contra_act" value="<?php echo $lvi['num_poliza_contra']; ?>">
                                            <input type="hidden" name="fecha_vencimiento_contra_act" id="fecha_vencimiento_contra_act" value="<?php echo $lvi['fecha_vencimiento_contra'] ?>">

                                            <?php if ($lvi['poliza_contra'] == '') { ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_poliza_contra"><strong>Documento Actual: </strong> No hay documentos cargados</label>
                                            <?php } else{ ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_poliza_contra"><strong>Documento Actual: </strong> <?php echo $lvi['poliza_contra'] ?></label>
                                            <?php }  ?>

                                        <!--  --------------------- -->

                                        <!--------  RCC --------->

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>Póliza de RCE (Responsabilidad Civil Extracontractual)</p>
                                            </div>

                                            <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                                    <?php if (($lvi['poliza_extra'] == '') || ($lvi['fecha_vencimiento_extra'] == '0000-00-00')){ ?>
                                                        <label>Documento Póliza de RCE <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado."></i></label>
                                                    <?php }else{ ?>
                                                        <label>Documento Póliza de RCE</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                    <?php if ($lvi['poliza_extra'] == ''){ ?>
                                                        <input type="file" style="border: 2px solid #349fd9" name="poliza_extra"  id="poliza_extra" class="form-control form-control-sm" >
                                                    <?php }else{ ?>
                                                        <input type="file" style="border: 2px solid #349fd9" name="poliza_extra"  id="poliza_extra" class="form-control form-control-sm" >
                                                    <?php } ?>
                                                </div>        
                                            </div>  

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label>Número Póliza de RCE</label>
                                                    <input type="text" name="num_poliza_extra" id="num_poliza_extra" class="form-control form-control-sm" value="<?php echo $lvi['num_poliza_extra'] ?>">
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    
                                                    <?php if ($lvi['fecha_vencimiento_extra'] < date('Y-m-d')){ ?>
                                                        <label>Vencimiento Póliza de RCE <i class="fa fa-exclamation-circle" style="color: red; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Vencido"></i></label>
                                                        <input type="text" style="border: 2px solid red;" value="<?php echo $lvi['fecha_vencimiento_extra'] ?>" name="fecha_vencimiento_extra" id="fecha_vencimiento_extra" class="form-control form-control-sm">     
                                                    <?php } else if (($lvi['fecha_vencimiento_extra'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_extra'] >= date('Y-m-d'))){ ?>	
                                                        <label>Vencimiento Póliza de RCE <i class="fa fa-exclamation-circle" style="color: orange; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Pronto a vencer"></i></label>
                                                        <input type="text" style="border: 2px solid orange;" value="<?php echo $lvi['fecha_vencimiento_extra'] ?>" name="fecha_vencimiento_extra" id="fecha_vencimiento_extra" class="form-control form-control-sm">
                                                    <?php }else{ ?>
                                                        <label>Vencimiento Póliza de RCE </label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_extra'] ?>" name="fecha_vencimiento_extra" id="fecha_vencimiento_extra" class="form-control form-control-sm">
                                                    <?php } ?>

                                                </div>           
                                            </div>  

                                            <input type="hidden" name="act_poliza_extra"  id="act_poliza_extra" value="<?php echo $lvi['poliza_extra']; ?>">
                                            <input type="hidden" name="num_poliza_extra_act"  id="num_poliza_extra_act" value="<?php echo $lvi['num_poliza_extra']; ?>">
                                            <input type="hidden" name="fecha_vencimiento_extra_act" id="fecha_vencimiento_extra_act" value="<?php echo $lvi['fecha_vencimiento_extra'] ?>">

                                            <?php if ($lvi['poliza_extra'] == '') { ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_poliza_extra"><strong>Documento Actual: </strong> No hay documentos cargados</label>
                                            <?php } else{ ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_poliza_extra"><strong>Documento Actual: </strong> <?php echo $lvi['poliza_extra'] ?></label>
                                            <?php }  ?>

                                        <!--  --------------------- -->

                                        <!-- DISPOSITIVO DE VELOCIDAD -->

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>Verificación Dispositivo Velocidad</p>
                                            </div>

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <?php if(($lvi['fecha_exp_disp_velocidad'] == '0000-00-00') || ($lvi['disp_velocidad'] == '')){ ?>
                                                            <label>Documento Disp. de Velocidad <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado."></i></label>
                                                            <input type="file" name="disp_velocidad" id="disp_velocidad" class="form-control" style="border: 2px solid #349fd9;">
                                                    <?php } ?>
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <?php if ($lvi['fecha_exp_disp_velocidad'] <= $plazoVencimiento2){ ?>
                                                        <label>Expedición Disp. de Velocidad <i class="fa fa-exclamation-circle" style="color: red; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Vencido"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_exp_disp_velocidad'] ?>" name="fecha_exp_disp_velocidad" id="fecha_exp_disp_velocidad" class="form-control form-control-sm">
                                                    <?php }else { ?>
                                                        <label>Expedición Disp. de Velocidad</label>
                                                        <input type="text" value="<?php echo $lvi['fecha_exp_disp_velocidad'] ?>" name="fecha_exp_disp_velocidad" id="fecha_exp_disp_velocidad" class="form-control form-control-sm">
                                                    <?php } ?>
                                                </div>           
                                            </div>  

                                            <input type="hidden" name="act_disp_velocidad"  id="act_disp_velocidad" value="<?php echo $lvi['disp_velocidad'] ?>">
                                            <input type="hidden" name="act_fecha_exp_disp_velocidad" id="act_fecha_exp_disp_velocidad" value="<?php echo $lvi['fecha_exp_disp_velocidad'] ?>">

                                            <?php if ($lvi['disp_velocidad'] == '') { ?>
                                                    <label class="mt-2 mb-4 ml-5" for="act_licencia_transito"><strong>Documento Actual: </strong> No hay documentos cargados</label>
                                            <?php } else{ ?>
                                                    <label class="mt-2 mb-4 ml-5" for="act_licencia_transito"><strong>Documento Actual: </strong> <?php echo $lvi['disp_velocidad'] ?></label>
                                            <?php }  ?> 

                                        <!--  ----------------------- -->

                                        <!-- FICHA TECNICA DE HOMOLOGACIÓN -->

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>Ficha Tecnica de Homologación</p>
                                            </div>

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <?php if (($lvi['ficha_tecnica_homologacion'] == '')) { ?>    
                                                        <label>Documento Ficha Tec. de Homologación <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado."></i></label>
                                                    <?php } else { ?>
                                                        <label>Documento Ficha Tec. de Homologación</label>
                                                    <?php } ?>
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <?php if (($lvi['ficha_tecnica_homologacion'] == '')) { ?>   
                                                        <input type="file" style="border:2px solid #349fd9;" name="ficha_tecnica_homologacion"  id="ficha_tecnica_homologacion" class="form-control" >
                                                    <?php } else { ?>
                                                        <input type="file" name="ficha_tecnica_homologacion"  id="ficha_tecnica_homologacion" class="form-control" >
                                                    <?php } ?>
                                                </div>           
                                            </div>  

                                            <input type="hidden" name="act_ficha_tecnica_homologacion" id="act_ficha_tecnica_homologacion" value="<?php echo $lvi['ficha_tecnica_homologacion']; ?>">

                                            <?php if ($lvi['ficha_tecnica_homologacion'] == '') { ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_ficha_tecnica_homologacion"><strong>Documento Actual: </strong> No hay documento cargado</label>
                                            <?php } else{ ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_ficha_tecnica_homologacion"><strong>Documento Actual: </strong> <?php echo $lvi['ficha_tecnica_homologacion']; ?></label>
                                            <?php }  ?>

                                        <!--  ---------------------------- -->
                                                
                                        <!------- TODO RIESGO -------->

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                                <p>Seguro Todo Riesgo</p>
                                            </div>

                                            <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                                    <?php if ($lvi['seguro_todo_riesgo'] == ''){ ?>
                                                        <label>Documento Seguro Todo Riesgo <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado."></i></label>
                                                    <?php }else{ ?>
                                                        <label>Documento Seguro Todo Riesgo</label>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                    <?php if ($lvi['seguro_todo_riesgo'] == ''){ ?>
                                                        <input type="file" style="border: 2px solid #349fd9;" name="seguro_todo_riesgo" id="seguro_todo_riesgo" class="form-control form-control-sm" >
                                                    <?php }else{ ?>
                                                        <input type="file" style="border: 2px solid #349fd9;" name="seguro_todo_riesgo" id="seguro_todo_riesgo" class="form-control form-control-sm" >
                                                    <?php } ?>
                                                </div>        
                                            </div>  

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label>Número Seguro Todo Riesgo</label>
                                                    <input type="text" name="num_seguro_todo_riesgo" id="num_seguro_todo_riesgo" class="form-control form-control-sm" value="<?php echo $lvi['num_seguro_todo_riesgo'] ?>">
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                                                    <?php if (($lvi['fecha_vencimiento_seguro_todo_riesgo'] <= $plazoVencimiento) && ($lvi['fecha_vencimiento_seguro_todo_riesgo'] > date('Y-m-d'))){ ?>
                                                        <label>Vencimiento Seguro Todo Riesgo <i class="fa fa-exclamation-circle" style="color: red; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Vencido"></i></label>
                                                        <input type="text" name="fecha_vencimiento_seguro_todo_riesgo" id="fecha_vencimiento_seguro_todo_riesgo" class="form-control form-control-sm">     
                                                    <?php } else if (($lvi['fecha_vencimiento_seguro_todo_riesgo'] <= $plazoVencimiento)&&($lvi['fecha_vencimiento_seguro_todo_riesgo'] >= date('Y-m-d'))){ ?>	
                                                        <label>Vencimiento Seguro Todo Riesgo <i class="fa fa-exclamation-circle" style="color: orange; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="Documento Pronto a vencer"></i></label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_seguro_todo_riesgo'] ?>" name="fecha_vencimiento_seguro_todo_riesgo" id="fecha_vencimiento_seguro_todo_riesgo" class="form-control form-control-sm" style="border: 2px solid orange;">
                                                    <?php }else{ ?>
                                                        <label>Vencimiento Seguro Todo Riesgo </label>
                                                        <input type="text" value="<?php echo $lvi['fecha_vencimiento_seguro_todo_riesgo'] ?>" name="fecha_vencimiento_seguro_todo_riesgo" id="fecha_vencimiento_seguro_todo_riesgo" class="form-control form-control-sm">
                                                    <?php } ?>

                                                </div>           
                                            </div>  

                                            <input type="hidden" name="act_seguro_todo_riesgo"  id="act_seguro_todo_riesgo" class="form-control" value="<?php echo $lvi['seguro_todo_riesgo']; ?>">
                                            <input type="hidden" name="num_seguro_todo_riesgo_act"  id="num_seguro_todo_riesgo_act" class="form-control" value="<?php echo $lvi['num_seguro_todo_riesgo']; ?>">
                                            <input type="hidden" name="act_fecha_vencimiento_seguro_todo_riesgo" id="datepicker11" class="form-control" value="<?php echo $lvi['fecha_vencimiento_seguro_todo_riesgo']; ?>">

                                            <?php if ($lvi['seguro_todo_riesgo'] == '') { ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_seguro_todo_riesgo"><strong>Documento Actual: </strong> No hay documento cargado</label>
                                            <?php } else{ ?>
                                                <label class="mt-2 mb-4 ml-5" for="act_seguro_todo_riesgo"><strong>Documento Actual: </strong> <?php echo $lvi['seguro_todo_riesgo']; ?></label>
                                            <?php }  ?>

                                        <!--  --------------------- -->
				        	                
								    </div>

			                    <!--FOTOGRAFIAS-->

			                    	<div id="tabs-3">

			                    			<input type="hidden" name="id_fotografia" id="id_fotografia" value="<?php echo $listarFotografiasId[0]['id_fotografia'] ?>">
			                    		
			                    			<div class="row  mt-3 ">
			                                    <div class="label">
			                                        <label>Foto Delantera</label>
			                                    </div>
			                                    <div class="input">
			                                        <input type="file" name="fotografia_frontal" id="fotografia_frontal" class="form-control" >
			                                        <input type="hidden" name="act_fotografia_frontal" id="act_fotografia_frontal" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_frontal'] ?>">  

			                                    <?php if ($listarFotografiasId[0]['fotografia_frontal'] == '') { ?>
				        	                        <label class="mt-2 ml-5" for="act_fotografia_frontal"><strong>Fotografia Actual: </strong> No hay fotografia cargada</label>
				        	                	<?php } else{ ?>
				        	                        <label class="mt-2 ml-5" for="act_fotografia_frontal"><strong>Documento Actual: </strong> <?php echo $listarFotografiasId[0]['fotografia_frontal'] ?></label>
				        	                	<?php }  ?> 
			                                    </div>   

			                                         
			                                </div>

		                                    <div class="row  mt-3 ">
		                                        <div class="label">
		                                            <label>Foto Trasera</label>
		                                        </div>
		                                        <div class="input">
		                                            <input type="file" name="fotografia_trasera" id="fotografia_trasera" class="form-control" >    
		                                            <input type="hidden" name="act_fotografia_trasera" id="act_fotografia_trasera" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_trasera'] ?>">   

		                                            <?php if ($listarFotografiasId[0]['fotografia_trasera'] == '') { ?>
				        	                        	<label class="mt-2 ml-5" for="act_fotografia_trasera"><strong>Fotografia Actual: </strong> No hay fotografia cargada</label>
				        	                		<?php } else{ ?>
				        	                        	<label class="mt-2 ml-5" for="act_fotografia_trasera"><strong>Documento Actual: </strong> <?php echo $listarFotografiasId[0]['fotografia_trasera'] ?></label>
				        	                		<?php }  ?>    
		                                        </div>              
		                                    </div>

		                                    <div class="row  mt-3 ">
		                                        <div class="label">
		                                            <label>Foto Lateral Izquierda</label>
		                                        </div>
		                                        <div class="input">
		                                            <input type="file" name="fotografia_lateral_izq" id="fotografia_lateral_izq" class="form-control" ><input type="hidden" name="act_fotografia_lateral_izq" id="act_fotografia_lateral_izq" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_lateral_izq'] ?>">    

		                                            <?php if ($listarFotografiasId[0]['fotografia_lateral_izq'] == '') { ?>
				        	                        	<label class="mt-2 ml-5" for="act_fotografia_lateral_izq"><strong>Fotografia Actual: </strong> No hay fotografia cargada</label>
				        	                		<?php } else{ ?>
				        	                        	<label class="mt-2 ml-5" for="act_fotografia_lateral_izq"><strong>Documento Actual: </strong> <?php echo $listarFotografiasId[0]['fotografia_lateral_izq'] ?></label>
				        	                		<?php }  ?>     
		                                        </div>              
		                                    </div>

		                                    <div class="row  mt-3 ">
		                                        <div class="label">
		                                            <label>Foto Lateral Derecha</label>
		                                        </div>
		                                        <div class="input">
		                                            <input type="file" name="fotografia_lateral_der" id="fotografia_lateral_der" class="form-control" ><input type="hidden" name="act_fotografia_lateral_der" id="act_fotografia_lateral_der" class="form-control" value="<?php echo $listarFotografiasId[0]['fotografia_lateral_der'] ?>">

		                                            <?php if ($listarFotografiasId[0]['fotografia_lateral_der'] == '') { ?>
				        	                        	<label class="mt-2 ml-5" for="act_fotografia_lateral_der"><strong>Fotografia Actual: </strong> No hay fotografia cargada</label>
				        	                		<?php } else{ ?>
				        	                        	<label class="mt-2 ml-5" for="act_fotografia_lateral_der"><strong>Documento Actual: </strong> <?php echo $listarFotografiasId[0]['fotografia_lateral_der'] ?></label>
				        	                		<?php }  ?>         
		                                        </div>              
		                                    </div>
	                                    

	                            	</div>
		
								<!--PROPIETARIO-->

			                   		<div id="tabs-4">
				                   		<!-- OPCIONES CAMBIOS DE PROPIETARIO -->

				                   				<div class="row  mb-3 mt-3">
					                   		       	<div class="label">
					                   		       		<label>¿Que desea realizar con el propietario?</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<select class="form-control" id="propietario_cambio" name="propietario_cambio" onchange="propietario()">
					                   		       			<option value="0">Seleccionar</option>
					                   		       			<option value="1">Cambiar Propietario</option>
					                   		       			<option value="2">Actualizar datos</option>
					                   		       		</select>
					                   		       	</div>      		
					                   		    </div>	

			                   			<!-- ############################## -->

			                   			<!-- ACTUALIZAR DATOS PROPIETARIO -->
			                   			
			                   			    <!--  TIPO PROPIETARIO   -->  
	                                            <div class="row  mt-3 " id="tipoPropietario_act" style="display: none;">
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
	                                            <div class="row  mt-3 mb-3" id="propiedad_act" style="display: none;">
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
										
											<!-- USUARIO -->

			                    				<input type="hidden" name="usuario_act" id="usuario_act" class="form-control" value="<?php echo $listarPropietariosPorId[0]['usuario'] ?>">

			                    			<!-- CLAVE -->

			                    				<input type="hidden" name="clave_act" id="clave_act" class="form-control" value="<?php echo  base64_decode($listarPropietariosPorId[0]['clave']) ?>">

											<!-- ID PERFIL -->

			                    				<input type="hidden" name="id_perfil_act" id="id_perfil_act" class="form-control" value="<?php echo  $listarPropietariosPorId[0]['id_perfil'] ?>">

				                   			<!-- NOMBRES Y APELLIDOS --> 
					                   		   
					                   		    <div class="row  mb-3" id="nombre_act" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Nombres y Apellidos</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="nombre_propietario" id="nombre_propietario" class="form-control" value="<?php echo $listarPropietariosPorId[0]['nombre'] ?>">

					                   		       		<input type="hidden" name="nombre_propietario_act" id="nombre_propietario_act" class="form-control" value="<?php echo $listarPropietariosPorId[0]['nombre'] ?>">
					                   		       	</div>      		
					                   		    </div>
											
											<!-- CEDULA --> 
					                   		    <div class="row  mb-3"  id="cedula_act" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Numero Documento o Nit</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="numero_documento_act" id="numero_documento_act" class="form-control" value="<?php echo $listarPropietariosPorId[0]['usuario'] ?>" disabled="true">
					                   		       	</div>      		
					                   		    </div>

					                   		<!-- CORREO ELECTRONICO --> 
					                   		    
					                   		    <div class="row  mb-3"  id="correo_act" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Correo Electronico</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="correo_electronico" id="correo_electronico" class="form-control" value="<?php echo $listarPropietariosPorId[0]['correo_electronico'] ?>">

					                   		       		<input type="hidden" name="correo_electronico_act" id="correo_electronico_act" class="form-control" value="<?php echo $listarPropietariosPorId[0]['correo_electronico'] ?>">
					                   		       	</div>      		
					                   		    </div>

					                   		<!-- TELEFONO --> 
					                   		    <div class="row  mb-3"  id="telefono_act" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Telefono</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="telefono_propietario" id="telefono_propietario" class="form-control" value="<?php echo $lvi['telefono_propietario'] ?>">

					                   		       		<input type="hidden" name="telefono_propietario_act" id="telefono_propietario_act" class="form-control" value="<?php echo $lvi['telefono_propietario'] ?>">
					                   		       	</div>      		
					                   		    </div>

											<!-- ESTADO PROPIETARIO -->

			                    				<input type="hidden" name="estado_propietario_act" id="estado_propietario_act" class="form-control" value="<?php echo  $listarPropietariosPorId[0]['estado'] ?>">
											
											<!-- ID CARGO -->

			                    				<input type="hidden" name="id_cargo_act" id="id_cargo_act" class="form-control" value="<?php echo  $listarPropietariosPorId[0]['id_cargo'] ?>">

											<!-- CANT INGRESOS -->

			                    				<input type="hidden" name="cant_ingresos_act" id="cant_ingresos_act" class="form-control" value="<?php echo  $listarPropietariosPorId[0]['cant_ingresos'] ?>">

											<!-- FECHA ULTIMO INGRESO -->

			                    				<input type="hidden" name="fecha_ultimo_ingreso_act" id="fecha_ultimo_ingreso_act" class="form-control" value="<?php echo  $listarPropietariosPorId[0]['fecha_ultimo_ingreso'] ?>">

					                   		<!-- FECHA NACIMIENTO --> 
					                   		    <div class="row  mb-3"  id="fecha_nac_propietario_act" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Fecha Nacimiento</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="date" name="fecha_nac_propietario" id="fecha_nac_propietario" class="form-control" value="<?php echo $lvi['fecha_nac_propietario'] ?>" >

					                   		       		<input type="hidden" name="fecha_nac_propietario_act" id="fecha_nac_propietario_act" class="form-control" value="<?php echo $lvi['fecha_nac_propietario'] ?>">
					                   		       	</div>      		
					                   		    </div>

					                   		<!-- DIRECCION  --> 
					                   		    <div class="row  mb-3"  id="direccion_act" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Dirección</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="direccion_propietario" id="direccion_propietario" class="form-control" value="<?php echo $lvi['direccion_propietario'] ?>">

					                   		       		<input type="hidden" name="direccion_propietario_act" id="direccion_propietario_act" class="form-control" value="<?php echo $lvi['direccion_propietario'] ?>">
					                   		       	</div>      		
					                   		    </div>

					                   		<!-- CIUDAD --> 
					                   		    <div class="row  mb-3"  id="ciudad_act" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Ciudad Residencia</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="ciudad_propietario" id="ciudad_propietario" class="form-control" value="<?php echo $lvi['ciudad_propietario'] ?>">

					                   		       		<input type="hidden" name="act_ciudad_propietario" id="act_ciudad_propietario" class="form-control" value="<?php echo $lvi['ciudad_propietario_act'] ?>">
					                   		       	</div>      		
					                   		    </div>

					                   	<!-- ############################## -->

					                   	<!-- CAMBIAR DE PROPIETARIO -->
											
											<!--  TIPO PROPIETARIO   -->  
		                                        <div class="row  mt-3 mb-3" style="display: none;" id="tipoPropietario_nuevo">
		                                            <div class="label">
		                                                <label>Tipo Propietario</label>
		                                            </div>
		                                            <div class="input">
		                                                <select class="form-control" required="required" name="tipo_propietario_nuevo">
		                                                	<option value="0">SELECCIONAR</option>
		                                                	<option value="PN">Persona Natural</option>
		                                                	<option value="PJ">Persona Juridica</option>
		                                                </select>
		                                            </div>              
		                                        </div>

	                                		<!-- PROPIEDAD DE   -->  
		                                        <div class="row mb-3 " style="display: none;" id="propiedad_nuevo">
		                                            <div class="label">
		                                                <label>Propiedad de</label>
		                                            </div>
		                                            <div class="input">
		                                                <select class="form-control" required="required" name="propiedad_nuevo">
		                                                	<option value="0">SELECCIONAR</option>
		                                                	<option value="Propia">Propio</option>
		                                                	<option value="Leasing">Leasing</option>
		                                                	<option value="Fiduciaria">Fiduciaria</option>
		                                                </select>
		                                            </div>              
		                                        </div>
				                 
				                   			<!-- NOMBRES Y APELLIDOS --> 
					                   		    <div class="row  mb-3" id="nombre_nuevo" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Nombres y Apellidos</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="nombre" id="nombre" class="form-control" >
					                   		       	</div>      		
					                   		    </div>

											<!-- CEDULA --> 
					                   		    <div class="row  mb-3"  id="cedula_nuevo" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Numero de Documento / Cedula</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="numero_documento_nue" id="numero_documento_nue" class="form-control" >
					                   		       	</div>      		
					                   		    </div>

					                   		<!-- CORREO ELECTRONICO --> 
					                   		    <div class="row  mb-3"  id="correo_nuevo" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Correo Electronico</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="correo_electronico_nue" id="correo_electronico_nue" class="form-control" >
					                   		       	</div>      		
					                   		    </div>

					                     	<!-- TELEFONO --> 
					                   		    <div class="row  mb-3"  id="telefono_nuevo" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Telefono</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="telefono_propietario_nuevo" id="telefono_propietario_nue" class="form-control" >
					                   		       	</div>      		
					                   		    </div>

						               		<!-- FECHA NACIMIENTO --> 
					                   		    <div class="row  mb-3"  id="fecha_nac_nuevo" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Fecha Nacimiento</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="date" name="fecha_nac_propietario_nuevo" id="fecha_nac_propietario_nuevo" class="form-control" >
					                   		       	</div>      		
					                   		    </div>

					                   		<!-- DIRECCION PROPIETARIO --> 
					                   		    <div class="row  mb-3"  id="direccion_nuevo" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Dirección</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="direccion_propietario_nuevo" id="direccion_propietario_nnuevo" class="form-control" >
					                   		       	</div>      		
					                   		    </div>

					                   		<!-- CIUDAD PROPIETARIO --> 
					                   		    <div class="row  mb-3"  id="ciudad_nuevo" style="display: none;">
					                   		       	<div class="label">
					                   		       		<label>Ciudad</label>
					                   		       	</div>
					                   		       	<div class="input">
					                   		       		<input type="text" name="ciudad_propietario_nuevo" id="ciudad_propietario_nuevo" class="form-control" >
					                   		       	</div>      		
					                   		    </div>

						              		<!-- FOTOCOPIA CEDULA -->
						               			<div class="row  mb-3"  id="fotocopiaCedula" style="display: none;">
						               				<div class="label">
						               					<label>Fotocopia de la Cedula</label>
						               				</div>
						               				<div class="input">
						               					<input type="file" name="fotocopia_cedula_propietario"  id="fotocopia_cedula_propietario" class="form-control" > 
						               
						               					<input type="hidden" name="act_fotocopia_cedula_propietario"  id="act_fotocopia_cedula_propietario" class="form-control" value="<?php echo $lvi['fotocopia_cedula_propietario'] ?>">
														
														<section id="mostrarDocumentoFotocopiaCedula" style="display: none;">
							               					<?php if ($lvi['fotocopia_cedula_propietario'] == '') { ?>
							        	                        <label class="mt-2" for="act_fotocopia_cedula_propietario"><strong>Documento Actual: </strong> No hay documentos cargados</label>
							        	                    <?php } else{ ?>
							        	                        <label class="mt-2" for="act_fotocopia_cedula_propietario"><strong>Documento Actual: </strong> <?php echo $lvi['fotocopia_cedula_propietario'] ?></label>
							        	                    <?php }  ?>
						        	                	</section>
						               				</div>        		
						               			</div>

						               		<!-- CAMARA DE COMERCIO -->
			                                        <div class="row  mt-3 " id="camaraComercio" style="display: none;">
			                                            <div class="label">
			                                                <label>Camara de Comercio</label>
			                                            </div>
			                                            <div class="input">
			                                                <input type="file" name="camara_comercio"  id="camara_comercio" class="form-control" >
														
						               						<input type="hidden" name="act_camara_comercio"  id="act_camara_comercio" class="form-control" value="<?php echo $lvi['camara_comercio'] ?>">
															

															<section id="mostrarDocumentoCamaraComercio" style="display: none;">
				                                                <?php if ($lvi['camara_comercio'] == '') { ?>
								        	                        <label class="mt-2" for="act_camara_comercio"><strong>Documento Actual: </strong> No hay documentos cargados</label>
								        	                    <?php } else{ ?>
								        	                        <label class="mt-2" for="act_camara_comercio"><strong>Documento Actual: </strong> <?php echo $lvi['camara_comercio'] ?></label>
								        	                    <?php }  ?>
							        	                	</section>
			                                            </div>              
			                                        </div>

			                                <!-- CONTRATO LEASING O FIDUCIA -->
			                                        <div class="row  mt-3 " id="contratoBanco" style="display: none;">
			                                            <div class="label">
			                                                <label>Contrato Leasing o Fiducia</label>
			                                            </div>
			                                            <div class="input">
			                                                <input type="file" name="contrato_banco"  id="contrato_banco" class="form-control" >
			                                                <input type="hidden" name="act_contrato_banco"  id="act_contrato_banco" class="form-control" value="<?php echo $lvi['contrato_banco'] ?>">
															

															<section id="mostrarDocumentoContratoBanco" style="display: none;">
				                                                <?php if ($lvi['contrato_banco'] == '') { ?>
								        	                        <label class="mt-2" for="act_contrato_banco"><strong>Documento Actual: </strong> No hay documentos cargados</label>
								        	                    <?php } else{ ?>
								        	                        <label class="mt-2" for="act_contrato_banco"><strong>Documento Actual: </strong> <?php echo $lvi['contrato_banco'] ?></label>
								        	                    <?php }  ?>
								        	                </section>
			                                            </div>              
			                                        </div>
			                                        
			                                <!-- HOJA DE VIDA -->
	                                            <div class="row  mt-3" id="HojaVida" style="display: none;">
	                                                <div class="label">
	                                                    <label>Hoja de Vida</label>
	                                                </div>
	                                                <div class="input">
	                                                    <input type="file" name="hoja_vida"  id="hoja_vida" class="form-control">
	                                                    <input type="hidden" name="act_hoja_vida"  id="act_hoja_vida" class="form-control" value="<?php echo $lvi['hoja_vida']; ?>">
	                                                    
	                                                    
														<section id="mostrarHojaVida" style="display: none;">
			                                                <?php if ($lvi['hoja_vida'] == '') { ?>
							        	                        <label class="mt-2" for="act_hoja_vida"><strong>Documento Actual: </strong> No hay documentos cargados</label>
							        	                    <?php } else{ ?>
							        	                        <label class="mt-2" for="act_hoja_vida"><strong>Documento Actual: </strong> <?php echo $lvi['hoja_vida'] ?></label>
							        	                    <?php }  ?>
							        	                </section>
							        	                
	                                                </div>              
	                                            </div>
	    
	                                        <!-- RUT -->
	                                            <div class="row  mt-3 "  id="DocRUT" style="display: none;">
	                                                <div class="label">
	                                                    <label>Registro Único Tributario (RUT)</label>
	                                                </div>
	                                                <div class="input">
	                                                    <input type="file" name="rut"  id="rut" class="form-control" >
	                                                    <input type="hidden" name="act_rut"  id="act_rut" class="form-control" value="<?php echo $lvi['rut']; ?>">
	                                                    
	                                                    <section id="mostrarRut" style="display: none;">
			                                                <?php if ($lvi['hoja_vida'] == '') { ?>
							        	                        <label class="mt-2" for="act_rut"><strong>Documento Actual: </strong> No hay documentos cargados</label>
							        	                    <?php } else{ ?>
							        	                        <label class="mt-2" for="act_rut"><strong>Documento Actual: </strong> <?php echo $lvi['rut'] ?></label>
							        	                    <?php }  ?>
							        	                </section>
	                                                </div>              
	                                            </div>
	        
	                                        <!-- PODER APODERADO -->
	                                            <div class="row  mt-3 "  id="PoderApoderado" style="display: none;">
	                                                <div class="label">
	                                                    <label>Poder Apoderado</label>
	                                                </div>
	                                                <div class="input">
	                                                    <input type="file" name="poder_apoderado"  id="poder_apoderado" class="form-control" >
	                                                    <input type="hidden" name="act_poder_apoderado"  id="act_poder_apoderado" class="form-control" value="<?php echo $lvi['poder_apoderado']; ?>">
	                                                    
	                                                    <section id="mostrarPoderApoderado" style="display: none;">
			                                                <?php if ($lvi['poder_apoderado'] == '') { ?>
							        	                        <label class="mt-2" for="act_poder_apoderado"><strong>Documento Actual: </strong> No hay documentos cargados</label>
							        	                    <?php } else{ ?>
							        	                        <label class="mt-2" for="act_poder_apoderado"><strong>Documento Actual: </strong> <?php echo $lvi['poder_apoderado'] ?></label>
							        	                    <?php }  ?>
							        	                </section>
	                                                </div>              
	                                            </div>

			                                
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
				                                            <input type="hidden" name="nombre_rc_act" value="<?php echo $lrc['nombre_referencia'] ?>">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rc" id="telefono_rc" value="<?php echo $lrc['telefono_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="telefono_rc_act" value="<?php echo $lrc['nombre_referencia'] ?>">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rc" id="direccion_rc" value="<?php echo $lrc['direccion_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="direccion_rc_act" value="<?php echo $lrc['nombre_referencia'] ?>">
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
				                                            <input type="hidden" name="nombre_rl_act" id="nombre_rl_act" value="<?php echo $lrl['nombre_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rl" id="telefono_rl" value="<?php echo $lrl['telefono_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="telefono_rl_act" id="telefono_rl_act" value="<?php echo $lrl['telefono_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rl" id="direccion_rl" value="<?php echo $lrl['direccion_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="direccion_rl_act" id="direccion_rl_act" value="<?php echo $lrl['direccion_referencia'] ?>" class="form-control">
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
				                                            <input type="hidden" name="nombre_rf_act" id="nombre_rf_act" value="<?php echo $lrf['nombre_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rf" id="telefono_rf" value="<?php echo $lrf['telefono_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="telefono_rf_act" id="telefono_rf_act" value="<?php echo $lrf['telefono_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rf" id="direccion_rf" value="<?php echo $lrf['direccion_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="direccion_rf_act" id="direccion_rf_act" value="<?php echo $lrf['direccion_referencia'] ?>" class="form-control">
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
				                                            <input type="hidden" name="nombre_rp_act" id="nombre_rp_act" value="<?php echo $lrp['nombre_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Telefono</label>
				                                            <input type="text" name="telefono_rp" id="telefono_rp" value="<?php echo $lrp['telefono_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="telefono_rp_act" id="telefono_rp_act" value="<?php echo $lrp['telefono_referencia'] ?>" class="form-control">
				                                        </div>
				                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				                                            <label>Dirección</label>
				                                            <input type="text" name="direccion_rp" id="direccion_rp" value="<?php echo $lrp['direccion_referencia'] ?>" class="form-control">
				                                            <input type="hidden" name="direccion_rp_act" id="direccion_rp_act" value="<?php echo $lrp['direccion_referencia'] ?>" class="form-control">
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

	                            <!--CONTRATO-->
		                            <div id="tabs-6">

		                                <!-- CONTRATO VINCULACIÓN --> 
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                            <p>Contrato Vinculación</p>
                                        </div>

                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    
                                                    <?php if ($lvi['contrato_vinculacion'] == ''){ ?>
                                                        <label>Documento Cont. de Transporte / Vinculación <i class="fa fa-exclamation-circle" style="color: #349fd9; font-size: 1.2rem; cursor: pointer;" data-toggle="tooltip" data-placement="right" title="No hay documento cargado"></i></label>
                                                        <input type="file" style="border:2px solid #349fd9;" name="contrato_vinculacion" id="contrato_vinculacion" class="form-control form-control-sm">
                                                    <?php } else{ ?>
                                                        <label>Documento Cont. de Transporte / Vinculación</label>
                                                        <input type="file" name="contrato_vinculacion" id="contrato_vinculacion" class="form-control form-control-sm">
                                                    <?php } ?>

                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label>Expedición Cont. de Vinculación</label>
                                                    <input type="text" name="fecha_exp_contrato_vinculacion" id="fecha_exp_contrato_vinculacion" class="form-control form-control-sm">
                                                </div>           
                                            </div>  

                                            <input type="hidden" name="act_contrato_vinculacion"  id="act_contrato_vinculacion" value="<?php echo $lvi['contrato_vinculacion'] ?>">
                                            <input type="hidden" name="act_fecha_exp_contrato_vinculacion" id="act_fecha_exp_contrato_vinculacion" value="<?php echo $lvi['fecha_exp_contrato_vinculacion'] ?>">

                                            <?php if ($lvi['contrato_vinculacion'] == '') { ?>
                                                <label class="mt-2 ml-5" for="act_contrato_vinculacion"><strong>Documento Actual: </strong> No hay documento cargado</label>
                                            <?php } else{ ?>
                                                <label class="mt-2 ml-5" for="act_contrato_vinculacion"><strong>Documento Actual: </strong> <?php echo $lvi['contrato_vinculacion'] ?></label>
                                            <?php }  ?>
                                            
                                            <hr>

		                                <!-- CONTRATO --> 
                                            <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
		                                            <label>Contrato Base</label>
		                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_contratoB" id="id_contratoB" onchange="validarContratos(this.value, <?php echo $id_vehiculo; ?>);">
		                                                <option value="0">ESTE VEHíCULO NO TIENE CONTRATO ANCLADO</option>
		                                                <?php
		                                                	$listarContratosBase = $vehiculoContrato->listarContratosBase($id_vehiculo);
		                                                	foreach ($listarC as $lc) {?>
		                                                		<option value="<?php echo $lc['id_contrato'] ?>" <?php if($listarContratosBase[0]['id_contrato'] == $lc['id_contrato']){?> selected="selected" <?php } ?>>
		                                                			<?php
				                                                        $emp = $empresa->listarPorId($lc['id_empresa']);
				                                                        $cli = $cliente->listarClientePorId($lc['id_cliente']);
				                                                        echo "No. interno ".$lc['id_contrato']." - CONTRATO N° " . $lc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa']; 
				                                                    ?>    	
				                                                </option>
		                                                	<?php }

		                                                ?>
		                                                <option value=""></option>
		                                                      
		                                            </select>
		                                        </div>  

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
		                                            <label>Contratos de Apoyo</label>
		                                            <select class="form-control form-control-sm" name="id_contratoA[]" id="id_contratoA" multiple="multiple">	

		                                            	<option value="0" <?php if(count($contratos) == 0) { ?> selected="selected" <?php } ?>>ESTE VEHíCULO NO TIENE CONTRATO ANCLADO</option>
		                                                
		                                                <?php foreach ($listarC as $lc){ ?>
	                                                    	<option value="<?php echo $lc['id_contrato']; ?>" <?php if(in_array($lc['id_contrato'], $contratos)) { ?> selected="selected" <?php } ?>>
		                                                        <?php
			                                                        $emp = $empresa->listarPorId($lc['id_empresa']);
			                                                        $cli = $cliente->listarClientePorId($lc['id_cliente']);
			                                                        echo "No. interno ".$lc['id_contrato']." - CONTRATO N° " . $lc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'];
			                                                    ?>
	                                                   	 	</option> 
	                                                   	<?php } ?>	
		                                            </select>
		                                        </div> 

		                                    </div>
  
		                            </div> 

		                        <!--FLOTA PROPIA-->
		                            <div id="tabs-7">
		                                <!-- FLOTA PROPIA --> 
		                                    <div class="row  mt-3  ">
		                                            
		                                            <div class="label">
		                                                <label>¿Es una flota propia?</label>
		                                            </div>
		                                            <div class="input">
		                                                <select name="flota_propia" id="flota_propia" class="form-control" required="required" onchange="flota(this.value)">
		                                                    <option value="">Seleccionar</option>
		                                                    <option value="S" <?php if ($lvi['flota_propia'] == 'S'){?> selected="selected" <?php } ?>>Si</option>
		                                                    <option value="N" <?php if ($lvi['flota_propia'] == 'N'){?> selected="selected" <?php } ?>>No</option>
		                                                </select>
		                                                <input type="hidden" name="flota_propia_act" id="flota_propia_act" class="form-control" value="<?php echo $lvi['flota_propia'] ?>">
		                                            </div>              
		                                    </div>
		                                    <div class="row  mt-3  " id="empresas" <?php if($lvi['flota_propia'] == 'S') { ?> style="display: flex" <?php } else { ?> style="display:none" <?php } ?>  >
	                                            
	                                            <div class="label">
	                                                <label>Empresa</label>
	                                            </div>
	                                            <div class="input">
	                                                <select name="id_empresa" id="id_empresa" class="form-control selectpicker" data-live-search="true" >
	                                                    <option value="">Seleccionar</option>
	                                                    <?php foreach($listadoEmpresas as $le){?>
	                                                    <option value="<?php echo $le['id_empresa'];?>" <?php if($lvi['id_empresa'] == $le['id_empresa']) { ?> selected="selected" <?php } ?> >
	                                                    	<?php echo $le['nombre_empresa'];?></option>
	                                                    <?php } ?>

	                                                </select>
	                                                <input type="hidden" name="id_empresa_act" value="<?php echo $lvi['id_empresa'];?>">
	                                            </div>              
	                                    </div>    
		                            </div> 

		                        <!--EMPRESA CONVENIO-->
		                            <div id="tabs-8">

		                            	<?php if ($cantEmpVeh > 0){ ?>
		                            		
			                            	<!-- Razón Social-->

		                                        <div class="row mt-3">
		                                            <section class="label">
		                                                <label>Empresa Convenio</label>
		                                            </section>
		                                            <section class="input">
		                                                    <input type="text" name="razon_socialEmpConve" id="razon_socialEmpConve" class="form-control" value="<?php echo $empresaConvenio_ID[0]['razon_social'] . ' - Nit: ' . $empresaConvenio_ID[0]['nit_cliente'] ?>" readonly>
		                                            </section>
		                                        </div>

		                                        <hr>

		                            	<?php } ?>

		                                <div class="row  mt-3 ">
		                                    <div class="label">
		                                        <label>Seleccione una opción para actualizar la empresa convenio</label>
		                                    </div>
		                                    <div class="input">
		                                        <select name="tipo_registroEmpConv" id="tipo_registroEmpConv" class="form-control" onchange="validarOpcionRegistro(this.value);">
		                                            <option value="">Seleccionar</option>
		                                            <option value="BA">Buscar y Anclar</option>
		                                            <option value="NR">Nuevo Registro</option>
		                                        </select>
		                                    </div>              
		                                </div> 

		                                <!-- EMPRESAS CONVENIO --> 
		                                    <div class="row  mt-3 " id="empresaConvenio" style="display: none;">
		                                        <div class="label">
		                                            <label>Empresas Convenio</label>
		                                        </div>
		                                        <div class="input">
		                                            <select name="id_empresa_convenio" id="id_empresa_convenio" class="form-control selectpicker" data-live-search="true">
		                                                <option value="">SELECCIONAR</option>
		                                                <?php foreach ($listarEmpresasConvenio as $lec){ ?>
		                                                    <option value="<?php echo $lec['id_cliente'] ?>"><?php echo $lec['razon_social'] . " - Nit " . $lec['nit_cliente']; ?></option>
		                                                <?php } ?>
		                                            </select>
		                                        </div>              
		                                    </div> 

		                                <!-- NUEVO REGISTRO --> 

		                                    <section class="col-12" id="nuevoRegistroEmpresa" style="display: none;">

		                                        <!-- Razón Social-->
		                                            <div class="row mt-3">
		                                                <section class="label">
		                                                    <label>Razon Social</label>
		                                                </section>
		                                                <section class="input">
		                                                        <input type="text" name="razon_social" id="razon_social" class="form-control" maxlength="82">
		                                                </section>
		                                            </div>

		                                        <!-- Nit-->

		                                            <div class="row mt-3">
		                                                <section class="label">
		                                                    <label>NIT o Cedula</label>
		                                                </section>
		                                                <section class="input">
		                                                    <input type="text" name="nit_cliente" id="nit_cliente" class="form-control">
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
		                                            
		                                        <!-- Representante Legal-->

		                                            <div class="row mt-3">
		                                                <section class="label">
		                                                    <label>Nombre Representante Legal</label>
		                                                </section>
		                                                <section class="input">
		                                                    <input type="text" name="nombre_rl" id="nombre_rl" class="form-control">
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

		                                        <!-- Pais Expedicion RL-->

		                                            <div class="row  mt-3 ">
		                                                <section class="label">
		                                                    <label>Pais Expedicion</label>
		                                                </section>
		                                                <section class="input">
		                                                    <select name="id_pais_exp" id="id_pais_exp" class="form-control" onchange="cargar_departamentos_exp(this.value)">
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

		                                    </section>
		                            </div>
	                        </div>

		                    <section class="col-12 mt-4 d-flex justify-content-center">
		                        <a href="<?php echo $redireccion; ?>" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
		                        <button type="submit" id="buttonsKV" class="btn col-3">Actualizar</button>
		                    </section>

		                <?php } ?>

			        </form>
		        </div>
		    </section>

		</section>

    <!-- FIN CONTENIDO -->

    <!-- ************************************ -->

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

		$('#tipo_afiliacion').on('change', function(){
            if(this.value == 'TERCERO'){
                $('#empresa_afiliada').css('display' , 'flex');
                $('#movil_tercero').css('display' , 'flex');
                $('#movil_afiliado').css('display' , 'none');
            }else{
                $('#empresa_afiliada').css('display', 'none');
                $('#movil_afiliado').css('display' , 'flex');
                $('#movil_tercero').css('display' , 'none');
            }
        })


 	 	function validarOpcionRegistro(val){
            if (val == 'BA') {
                document.getElementById('empresaConvenio').style.display = 'flex';
                document.getElementById('nuevoRegistroEmpresa').style.display = 'none';
            }else if(val == 'NR'){
                document.getElementById('nuevoRegistroEmpresa').style.display = 'block';
                document.getElementById('empresaConvenio').style.display = 'none';
            }else{
                document.getElementById('empresaConvenio').style.display = 'none';
                document.getElementById('nuevoRegistroEmpresa').style.display = 'none';
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
                        $("#id_departamento_exp").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                    },
                    success:  function (response) {
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

	 	$( function(){

            $( "#fecha_vencimiento_to" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']

            });

            $( "#fecha_vencimiento_lt" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#fecha_vencimiento_soat" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#fecha_vencimiento_rt" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#fecha_vencimiento_rp" ).datepicker({ 
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

            $( "#fecha_vencimiento_contra" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#fecha_vencimiento_extra" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#fecha_exp_disp_velocidad" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#fecha_vencimiento_seguro_todo_riesgo" ).datepicker({ 
            	dateFormat:'yy/mm/dd',
            	changeMonth:true,
            	changeYear:true,
            	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

            $( "#fecha_exp_contrato_vinculacion" ).datepicker({ 
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
        });

    	$(function(){
            $("#tabs").tabs();
        });

        $(function(){
            $("#id_contratoA").chosen(); 
        });

        function propietario(){
        	var opcion = document.getElementById('propietario_cambio').value;


        	/*CAMBIAR PROPIETARIO*/

        	if (opcion == 1) {

        		/*Ocultar*/
        		document.getElementById('tipoPropietario_act').style.display = 'none';
        		document.getElementById('propiedad_act').style.display = 'none';
        		document.getElementById('nombre_act').style.display = 'none';
        		document.getElementById('cedula_act').style.display = 'none';
        		document.getElementById('correo_act').style.display = 'none';
        		document.getElementById('telefono_act').style.display = 'none';
        		document.getElementById('fecha_nac_propietario_act').style.display = 'none';
        		document.getElementById('direccion_act').style.display = 'none';
        		document.getElementById('ciudad_act').style.display = 'none';

        		/*Mostrar*/
        		document.getElementById('tipoPropietario_nuevo').style.display = 'flex';
        		document.getElementById('propiedad_nuevo').style.display = 'flex';
        		document.getElementById('nombre_nuevo').style.display = 'flex';
        		document.getElementById('cedula_nuevo').style.display = 'flex';
        		document.getElementById('correo_nuevo').style.display = 'flex';
        		document.getElementById('telefono_nuevo').style.display = 'flex';
        		document.getElementById('fecha_nac_nuevo').style.display = 'flex';
        		document.getElementById('direccion_nuevo').style.display = 'flex';
        		document.getElementById('ciudad_nuevo').style.display = 'flex';

        		document.getElementById('fotocopiaCedula').style.display = 'flex';
        		document.getElementById('mostrarDocumentoFotocopiaCedula').style.display = 'none';
        		document.getElementById('camaraComercio').style.display = 'flex';
        		document.getElementById('mostrarDocumentoCamaraComercio').style.display = 'none';
        		document.getElementById('contratoBanco').style.display = 'flex';
        		document.getElementById('mostrarDocumentoContratoBanco').style.display = 'none';
        		document.getElementById('HojaVida').style.display = 'flex';
        		document.getElementById('mostrarHojaVida').style.display = 'none';
        		document.getElementById('DocRUT').style.display = 'flex';
        		document.getElementById('mostrarRut').style.display = 'none';
        		document.getElementById('PoderApoderado').style.display = 'flex';
        		document.getElementById('mostrarPoderApoderado').style.display = 'none';

        	/*ACTUALIZAR PROPIETARIO*/

        	}else if (opcion == 2) {

        		/*Ocultar*/
	        		document.getElementById('tipoPropietario_nuevo').style.display = 'none';
	        		document.getElementById('propiedad_nuevo').style.display = 'none';
	        		document.getElementById('nombre_nuevo').style.display = 'none';
	        		document.getElementById('cedula_nuevo').style.display = 'none';
	        		document.getElementById('correo_nuevo').style.display = 'none';
	        		document.getElementById('telefono_nuevo').style.display = 'none';
	        		document.getElementById('fecha_nac_nuevo').style.display = 'none';
	        		document.getElementById('direccion_nuevo').style.display = 'none';
	        		document.getElementById('ciudad_nuevo').style.display = 'none';

        		/*Mostrar*/
	        		/*Información propietario*/
	        		document.getElementById('tipoPropietario_act').style.display = 'flex';
	        		document.getElementById('propiedad_act').style.display = 'flex';
	        		document.getElementById('nombre_act').style.display = 'flex';
	        		document.getElementById('cedula_act').style.display = 'flex';
	        		document.getElementById('correo_act').style.display = 'flex';
	        		document.getElementById('telefono_act').style.display = 'flex';
	        		document.getElementById('fecha_nac_propietario_act').style.display = 'flex';
	        		document.getElementById('direccion_act').style.display = 'flex';
	        		document.getElementById('ciudad_act').style.display = 'flex';

	        		/*Documentación Propietario*/
	        		document.getElementById('fotocopiaCedula').style.display = 'flex';
        			document.getElementById('mostrarDocumentoFotocopiaCedula').style.display = 'flex';
        			document.getElementById('camaraComercio').style.display = 'flex';
        			document.getElementById('mostrarDocumentoCamaraComercio').style.display = 'flex';
        			document.getElementById('camaraComercio').style.display = 'flex';
        			document.getElementById('mostrarDocumentoCamaraComercio').style.display = 'flex';
        			document.getElementById('contratoBanco').style.display = 'flex';
        			document.getElementById('mostrarDocumentoContratoBanco').style.display = 'flex';
            		document.getElementById('HojaVida').style.display = 'flex';
            		document.getElementById('mostrarHojaVida').style.display = 'flex';
            		document.getElementById('DocRUT').style.display = 'flex';
            		document.getElementById('mostrarRut').style.display = 'flex';
            		document.getElementById('PoderApoderado').style.display = 'flex';
            		document.getElementById('mostrarPoderApoderado').style.display = 'flex';
        	}else{

	        	/*Ocultar*/
	        		/*Información nueva propietario*/
	        		document.getElementById('tipoPropietario_nuevo').style.display = 'none';
	        		document.getElementById('propiedad_nuevo').style.display = 'none';
	        		document.getElementById('nombre_nuevo').style.display = 'none';
	        		document.getElementById('cedula_nuevo').style.display = 'none';
	        		document.getElementById('correo_nuevo').style.display = 'none';
	        		document.getElementById('telefono_nuevo').style.display = 'none';
	        		document.getElementById('fecha_nac_nuevo').style.display = 'none';
	        		document.getElementById('direccion_nuevo').style.display = 'none';
	        		document.getElementById('ciudad_nuevo').style.display = 'none';


        			/*Información actual propietario*/
	        		document.getElementById('tipoPropietario_act').style.display = 'none';
	        		document.getElementById('propiedad_act').style.display = 'none';
	        		document.getElementById('nombre_act').style.display = 'none';
	        		document.getElementById('cedula_act').style.display = 'none';
	        		document.getElementById('correo_act').style.display = 'none';
	        		document.getElementById('telefono_act').style.display = 'none';
	        		document.getElementById('fecha_nac_propietario_act').style.display = 'none';
	        		document.getElementById('direccion_act').style.display = 'none';
	        		document.getElementById('ciudad_act').style.display = 'none';

        			/*Doc propietario actual*/
	        		document.getElementById('fotocopiaCedula').style.display = 'none';
        			document.getElementById('camaraComercio').style.display = 'none';
        			document.getElementById('contratoBanco').style.display = 'none';
            		document.getElementById('HojaVida').style.display = 'none';
            		document.getElementById('DocRUT').style.display = 'none';
            		document.getElementById('PoderApoderado').style.display = 'none';
        	}
        }
        
        function flota(opcion){
            if(opcion == 'S'){
                document.getElementById('empresas').style.display = "flex";
                document.getElementById('id_empresa').required = true;
            } else {
                document.getElementById('empresas').style.display = "none";
                document.getElementById('id_empresa').required = false;
            }
        }

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
