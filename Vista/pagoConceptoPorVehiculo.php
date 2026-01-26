<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/ConceptosCobro.php");
require_once '../Modelo/Vehiculo.php';


$concepto = new ConceptoCobro();
$vehiculo = new Vehiculo();

$listarVehiculo = $vehiculo->listarVehiculosVinculados();

/* VARIABLES MENU*/
$titulo = 'Enviar Comprobante Pago';
$redireccion = 'activar_cobro.php';
$icono = 'fa fa-dollar';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Enviar Comprobante</title>
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
        
    <section class="home_content">  
    
        <div aria-label="breadcrumb" class="mt-1">      
            <ol class="breadcrumb" style="background-color: #fff;">            
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="activar_cobro.php">Pagos Pendientes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Enviar Comprobante</li>       
            </ol>    
        </div>    

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-money mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ENVIAR COMPROBANTE PAGO</b></strong>
        </div>
    
        <section class="form-usuarios mt-1">
            <div class="formulario mb-5">
                <!--FORMULARIO -->
    	            <form method="POST" action="../Controlador/enviarComprobante.php" enctype="multipart/form-data">
    		               
    		                <!-- Vehiculo -->

    		                    <div class="row mt-4 mb-4 ">
                                <div class="label">    
                                    <label><b>Vehiculo</b></label>
                                </div>
                                <div class="input">    
                                   <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo" id="id_vehiculo" onchange="ConceptosServiciosPorVehiculo(this.value);">
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach($listarVehiculo As $lvv){ ?>
                                            <option value="<?php echo $lvv['id_vehiculo']; ?> ">
                                                <?php echo $lvv['placa'] . " | " . $lvv['numero_movil']; ?>
                                            </option>
                                        <?php } ?>
                                   </select>
                                </div>
                            </div>
                            
    						<div class="row mt-3 d-flex justify-content-center">
    						    <section class="col-12 table-responsive" id="tabla_servicios">
        						</section>
    						</div>


                            <section class="col-12 mt-4 d-flex justify-content-center">
                                <a href="conceptos_cobro.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                                <button type="submit" class="btn btn-outline-info col-3">Registrar</button>
                            </section>
    						
    		        </form>
    		</div>
    	</section>

    </section>
    
    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">
	
	    
	    function ConceptosServiciosPorVehiculo(id_vehiculo){
	        
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            
            $.ajax({
                data:  parametros,
                url:   '../Controlador/CargarConceptoServiciosPorVehiculo.php',
                type:  'post',
                beforeSend: function () {
                    $("#tabla_servicios").html("<p>Cargando datos, espere por favor...<p>");
                },
                success:  function (response) {
                    //alert(response);
                    $("#tabla_servicios").html(response);
                }
            });
        }
        
        
        
	</script>
	
</body>
</html>



