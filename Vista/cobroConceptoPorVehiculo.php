<?php 
include ("../Controlador/Sesion/autenticar.php");
include("../Modelo/ConceptosCobro.php");
include("../Modelo/Vehiculo.php");

$conceptoCobro = new ConceptoCobro();
$listarConceptos = $conceptoCobro->listar();

$vehiculo = new Vehiculo();

$listarVehiculosVinculados = $vehiculo->listarVehiculosVinculados();

?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8">
    
	<title>SistemaKV | Activar cobro por vehiculo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
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
                    <li class="breadcrumb-item " aria-current="page"><a href="conceptos_cobro.php">Conceptos Cobro</a></li>
                    <li class="breadcrumb-item " aria-current="page"><a href="activar_cobro.php">Activar Cobro</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Activar cobro por vehiculo</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-money mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTIVAR COBRO POR VEHÍCULO</b></strong>
            </div>

            <section class="form-usuarios">
                <div class="formulario mb-5">
        	        <form action="../Controlador/generarCobros.php?>" method="POST">
        	        	<?php include("Template/header-form.php"); ?>
        	        	    
        	        	    <input type="hidden" name="cobroPorVehiculo" id="cobroPorVehiculo" class="form-control" value="S">
                            
                            <!--NOMBRE AREA-->
                                <div class="row mt-3 mb-4">
                                    <div class="label">
                                        <label>Detalle Servicio a Cobrar</label>
                                    </div>
                                    <div class="input">
                                        <select name="detalle_servicio" id="detalle_servicio" class="form-control selectpicker" data-live-search="true">
                                            <option value="">SELECCIONAR</option>
                                            <?php foreach($listarConceptos As $lc){ ?>
                                                <option value="<?php echo $lc['id_concepto']; ?>"><?php echo $lc['detalle_concepto']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mt-3 mb-4">
                                    <div class="label">
                                        <label>Vehiculo</label>
                                    </div>
                                    <div class="input">
                                        <select name="id_vehiculo" id="id_vehiculo" required="required" class="form-control selectpicker" data-live-search="true" onchange="cargarPropietario(this.value);">
                                            <option value="">SELECCIONAR</option>
                                            <?php foreach($listarVehiculosVinculados As $lvv){ ?>
                                                <option value="<?php echo $lvv['id_vehiculo'] ?>"><?php echo $lvv['placa'] . ' | N° MOVIL ' . $lvv['numero_movil'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mt-3 mb-4">
                                    <div class="label">
                                        <label>Propietario</label>
                                    </div>
                                    <div class="input" id="campo_propietario">
                                        
                                    </div>
                                </div>
                                
                                
                                <div class="row mt-3 mb-4">
                                    <div class="label">
                                        <label>Precio a Cobrar</label>
                                    </div>
                                    <div class="input" id="campo_propietario">
                                        <input type="text" name="cobro" id="cobro" class="form-control">
                                    </div>
                                </div>
                                
                                
                                <section class="col-12 mt-5 d-flex justify-content-center">
                          
                                    <!-- CANCELAR REGISTRO -->
                                        <a href="activar_cobro.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                                  
                                    <!-- REGISTRAR -->
                                        <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Activar</button>
                              
                                </section>

        	        </form>
                </div>
            </section>

        </section>

    <!-- FIN CONTENIDO -->

    <?php include("Template/scripts.php"); ?>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({ dateFormat:'yy/mm/dd'});
        } );
        
        function cargarPropietario(id_vehiculo){
            
            //alert(id_vehiculo);
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            
            $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarPropietarioVehiculo.php',
                  type:  'POST',
                  beforeSend: function () {
                      //alert('envio');
                      $("#campo_propietario").html("<p>Cargando datos, por favor espere</p>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#campo_propietario").html(response);
                  }
            });
        }        
    </script>
</body>
</html>