<?php 
include ("../Controlador/Sesion/autenticar.php");
require ("../Modelo/Cliente.php");
require ("../Modelo/Vehiculo.php");
require ("../Modelo/TipoServicio.php");

/* VARIABLES MENU*/
$titulo = 'Reporte Servicios';
$redireccion = 'asignaciones.php';
$icono = 'fa fa-car';

$cliente = new Cliente();
$listarA = $cliente->listar();
$vehiculo = new Vehiculo();
$listarV = $vehiculo->listarActivos();
$tiposervicio = new TipoServicio();
$listarTS = $tiposervicio->listarCliente();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Reporte Servicios</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="asignaciones.php">Asignaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
            <form action="../Vista/resultadoReporteServicios.php" method="POST">
				<?php include("Template/header-form.php"); ?> 
					        
						<div class="row mt-3">
						    <div class="label">
						        <label>Por Cliente</label>
						    </div>
						    <div class="input">
						        <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente">
						        	<option value="">Seleccionar </option>
						        	<?php foreach ($listarA as $la){ ?>
						        		<option value="<?php echo $la['id_cliente'] ?>">
						        			<?php echo $la['nit_cliente'].' | '.$la['razon_social']; ?>
						        		</option>
						        	<?php } ?>
						        </select>
						    </div>
						</div>

						<div class="row mt-3">
						    <div class="label">
						        <label>Por Vehiculo</label>
						    </div>
						    <div class="input">
						        <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo" id="id_vehiculo">
						        	<option value="">Seleccionar </option>
						        	<?php foreach ($listarV as $la){ ?>
						        		<option value="<?php echo $la['id_vehiculo'] ?>">
						        			<?php echo $la['placa'].' | '.$la['numero_movil']; ?>
						        		</option>
						        	<?php } ?>
						        </select>
						    </div>
						</div>

						<div class="row mt-3">
						    <div class="label">
						        <label>Por Tipo Servicio</label>
						    </div>
						    <div class="input">
						        <select class="form-control selectpicker" data-live-search="true" name="id_tiposervicio" id="id_tiposervicio">
						        	<option value="">Seleccionar </option>
						        	<?php foreach ($listarTS as $la){ ?>
						        		<option value="<?php echo $la['id_tipo_servicio'] ?>">
						        			<?php echo $la['nombre_tipo_servicio'] ?>
						        		</option>
						        	<?php } ?>
						        </select>
						    </div>
						</div>
                    
	                    <div class="row mt-3 ">
	                    	<section class="label">
	                    	 	<label>Fecha inicial</label>
	                    	</section>
	                    	<section class="input">
	                    	 	<input type="text" name="fecha_inicial" id="datepicker" class="form-control">
	                    	</section>
	                    </div>

	     	   			<div class="row mt-3 " id="fechaFinal">
	                    	<section class="label">
	     	                    <label>Fecha final</label>
	     	                </section>
	                    	<section class="input">
	     	                    <input type="text" name="fecha_final" id="datepicker1" class="form-control">
	     	                </section>
	                    </div>

	                    <div class="row justify-content-center botones-form mt-2 mb-5">
							<div class="boton mt-2">
									<a href="<?php echo $redireccion ?>" class="btn btn-danger btn-block">Cancelar</a>
							</div>

							<div class="boton mt-2">
								<button type="submit" class="btn btn-primary btn-block" id="guardar">Generar Reporte</button>
							</div>
						</div>
						
            </form>
        </div>
    </section>

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">
		$.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Ant',
 nextText: 'Sig >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
	    $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#datepicker" )
        .datepicker({
          maxDate: 0,
          changeMonth: true,
          changeYear: true,
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#datepicker1" ).datepicker({
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
    </script>
</body>
</html>

