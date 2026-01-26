<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once('../Modelo/Salud.php');

$salud = new Salud();

/* VARIABLES MENU*/
$titulo = 'Filtrar reporte salud';
$redireccion = 'reporte_vulnerabilidad.php';
$icono = 'fa fa-file-text-o';

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Reporte Vulnerabilidad</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
    
</head>
<body>



    <?php include("Template/menu.php"); ?>

    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="reporte_vulnerabilidad.php">Reporte Vulnerabilidad</a></li>
			<li class="breadcrumb-item active" aria-current="page">Filtro</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Vista/resultadoReporteVulnerabilidad.php">	
			        <?php include("Template/header-form.php"); ?> 
					
						<!-- Fecha inicial -->
                          	<div class="row mt-4 mb-4 ">
                              	<div class="label">    
                                  	<label>Fecha Inicial</label>
                              	</div>
                              	<div class="input">    
                                  	<input type="text" name="fecha_inicial" id="datepicker" class="form-control">
                             	 </div>
                         	 </div>

                        <!-- Fecha final -->
                          	<div class="row mt-4 mb-4 ">
                              	<div class="label">    
                                  	<label>Fecha Final</label>
                              	</div>
                              	<div class="input">    
                                  	<input type="text" name="fecha_final" id="datepicker1" class="form-control">
                             	</div>
                         	 </div>

                   		<hr>
            
                    <div class="row justify-content-center botones-form mt-2 mb-5">
						<div class="boton mt-2">
								<a href="<?php echo $redireccion ?>" class="btn btn-danger btn-block">Cancelar</a>
						</div>

						<div class="boton mt-2">
							<button type="submit" class="btn btn-primary btn-block" id="guardar">Filtrar</button>
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
    var dateFormat = "dd/mm/yy",
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