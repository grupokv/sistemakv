<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Categoria_Mantenimiento.php");
require_once("../Modelo/Subcategoria_Mantenimiento.php");
require_once("../Modelo/TipoServicioMantenimiento.php");
require_once("../Modelo/Area.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/ProveedorMantenimiento.php");
require_once("../Modelo/TipoServicioMantenimiento.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Orden Servicio';
$redireccion = 'ordenes_servicio.php';
$icono = 'fa fa-wrench';

if(isset($_GET['id'])){
	$id_v = $_GET['id'];
}
$id = '';

$vehiculo = new Vehiculo();
$listarV = $vehiculo->listarVehiculoFlotaPropia();

$proveedor = new ProveedorMantenimiento();
$listarP = $proveedor->listar();

$tipo_servicio = new TipoServicioMantenimiento();
$listarTS = $tipo_servicio->listar();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Orden de Servicio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
</head>
<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>


    <section class="home_content">  

    	<div aria-label="breadcrumb" class="mt-1"> 
            <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="ordenes_servicio.php">Ordenes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar orden</li>
            </ol>
        </div>
        
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-wrench mr-3" style="font-size: 2rem;"></i>REGISTRO ORDEN DE SERVICIO</strong>
        </div>


    <section class="form-usuarios">
        <div class="formulario mb-5">
            <form action="../Controlador/registrarOrdenServicio.php" method="POST">
					
			        <!-- VEHICULO -->
				        <div class="row mt-5">
				        	<div class="label">
					            <label><b>Vehículo</b></label>
				        	</div>
				        	<div class="input">
				        		<select name="vehiculo" id="vehiculo" required="required" class="form-control selectpicker" data-live-search="true">
				        		<option value="">SELECCIONAR</option>
				        		<?php foreach($listarV as $veh){ ?>
				        			<?php if($id_v != ''){ ?>
					        			<option value="<?php echo $veh['id_vehiculo'] ;?>" <?php if($id_v == $veh['id_vehiculo']){ ?> selected="selected" <?php } ?> >
					        				<?php echo $veh['numero_movil'] . ' | ' . $veh['placa'];?>
					        			</option>
				        			<?php } else { ?>
					        			<option value="<?php echo $veh['id_vehiculo']; ?>">
					        				<?php echo $veh['numero_movil'] . ' | ' . $veh['placa'];?>
					        			</option>
				        			<?php } ?>
				        		<?php } ?>
				        		</select>
				        	</div>
				        </div>
					
			        <!-- EMPRESA -->
				        <div class="row mt-3 ">
				        	<div class="label">
					            <label><b>Empresa</b></label>
				        	</div>
				        	<div class="input">
				        		<select name="id_empresa" id="id_empresa" required="required" class="form-control selectpicker" data-live-search="true">
					        		<option value="">SELECCIONAR</option>
					        		<option value="1">ORGANIZACIÓN ORT S.A.S </option>
					        		<option value="2">LINEAS PREMIUM S.A.S </option>
				        		</select>
				        		
				        	</div>
				        </div>
							        
			        <!--TIPO COMBUSTIBLE-->
				        <div class="row mt-3 ">
				        	<div class="label">
				                <label><b>Tipo Combustible</b></label>
				            </div>
				        	<div class="input">
				                <select name="tipo_combustible" id="tipo_combustible" required="required" class="form-control selectpicker" data-live-search="true">
				        		<option value="">SELECCIONAR</option>
				        		<option value="GASOLINA">GASOLINA</option>
				        		<option value="DIESEL">DIESEL</option>
				        		</select>
				            </div>
				        </div>

			        <!--PROVEEDOR-->
				        <div class="row mt-3 ">
				        	<div class="label">
				                <label><b>Proveedor</b></label>
				            </div>
				        	<div class="input">
				                <select name="proveedor" id="proveedor" required="required" class="form-control selectpicker" data-live-search="true">
				        		<option value="">SELECCIONAR</option>
				        		<?php foreach($listarP as $prov){ ?>
				        			<option value="<?php echo $prov['id_proveedor'];?>">
				        				<?php echo $prov['razon_social'];?>
				        			</option>
				        		<?php } ?>
				        		</select>
				            </div>
				        </div>

				    <!-- TIPO SERVICIO--> 
				        <div class="row mt-3 ">
				        	<div class="label">
				                <label><b>Tipo Servicio</b></label>
				            </div>
				        	<div class="input">
				                <select name="tipo_servicio" id="tipo_servicio"  required="required" class="form-control selectpicker" data-live-search="true">
				        		<option value="">SELECCIONAR</option>
				        		<?php foreach($listarTS as $tiposerv){ ?>
				        			<option value="<?php echo $tiposerv['id_tipo_servicio'];?>">
				        				<?php echo $tiposerv['detalle_tipo'];?>
				        			</option>
				        		<?php } ?>
				        		</select>
				            </div>
				        </div>

			        <!-- CRONOGRAMA -->
				        <div class="row mt-3 ">
				        	<div class="label">
				                <label><b>Cronograma</b></label>
				            </div>
				        	<div class="input">
				                <select name="cronograma" id="cronograma" required="required" class="form-control selectpicker" data-live-search="true" onchange="habilitar_conductores(this.value)">
				        		<option value="" selected="selected">SELECCIONAR</option>
				        		<option value="S">SI</option>
				        		<option value="N">NO</option>
				        		</select>
				            </div>
				        </div>

				    <!-- DEPARTAMENTO -->

					    <div class="row mt-3" id="conductores" style="display:none;">
			                <section class="label">
					     	    <label><b>Solicitado Por</b></label>
					     	</section>
			                <section class="input">
							    <select class="form-control" name="conductor" id="conductor" >
								</select>
					     	</section>
					    </div>

					<!-- FECHA INICIAL -->

					    <div class="row mt-3">
			                <section class="label">
					     	    <label><b>Fecha Inicial</b></label>
					     	</section>
			                <section class="input">
							    <input type="text" class="form-control" name="fecha_inicial" id="datepicker" required="required" />
					     	</section>
					    </div>

					<!-- FECHA FINAL -->

					    <div class="row mt-3">
			                <section class="label">
					     	    <label><b>Fecha Final</b></label>
					     	</section>
			                <section class="input">
							    <input type="text" class="form-control" name="fecha_final" id="datepicker1" required="required" />
					     	</section>
					    </div>

					<!-- OBSERVACIONES -->

					    <div class="row mt-3 mb-5">
			                <section class="label">
					     	    <label><b>Observaciones</b></label>
					     	</section>
			                <section class="input">
							    <textarea class="form-control" name="observaciones" id="observaciones"></textarea>
					     	</section>
					    </div>


                    <section class="col-12 mt-4 d-flex justify-content-center">
                        <a href="ordenes_servicio.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                        <button type="submit" class="btn btn-outline-info col-3">Registrar</button>
                    </section>

            </form>
        </div>
    </section>

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	$( function() {

            $("#datepicker").datepicker({ dateFormat:'yy/mm/dd'});
            $("#datepicker1").datepicker({ dateFormat:'yy/mm/dd'});
        } );

    	function habilitar_conductores(valor){
    		if(valor == 'N'){
			id_vehiculo = document.getElementById('vehiculo').value;
				if(id_vehiculo != ''){

				var datos = id_vehiculo.split("|");
				id_vehiculo = datos[1];

				var parametros = {
					   "id_vehiculo" : id_vehiculo
				};

				$.ajax({
			         data: parametros,
			         url: '../Controlador/listarConductoresVehiculoMant.php',
			         type: 'post',
			         beforeSend: function(){

			         },
			         success: function(response){
			         	//alert(response);
			               $('#conductor').html(response);
			               document.getElementById('conductores').style.display = 'flex';
			         }

				});
				} else {
					document.getElementById('conductores').style.display = 'none';
				}
			} else {
				document.getElementById('conductores').style.display = 'none';
			}
		}

    </script>
</body>
</html>

