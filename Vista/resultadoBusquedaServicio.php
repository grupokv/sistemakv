<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");

$filtro = $_POST['filtro'];
$dato = $_POST['dato'];

$programacion = new Programacion();

if($filtro == 1){
	$filtro = 'contacto';
} else if($filtro == 2){
	$filtro = 'solicitante';
} else if($filtro == 3){
	$filtro = 'origen';
} else {
	$filtro = 'destino';
}
$busqueda = $programacion->buscarServicioFiltro($filtro,$dato);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Resultado Reporte</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <style type="text/css">
    
    @media (max-width: 760px){
      
        .icono-principal{
          display: none;
        }

        .fa-plus{
           display: none;
        }
    }

    .barra-principal{
      background-color: #5e99b1;
    }

  </style>
  <!--fin  styles -->

</head>
<body>

    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="filtroServicios.php">Filtro</a></li>
            <li class="breadcrumb-item active" aria-current="page">Resultado</li>
         </ol>
    </div>
    
    <hr>
    <div class="row">
      <div class="mt-2 p-4 table-responsive">
        <form action="../Vista/resultadoReporteServicios.php" method="POST">
        <table class="table table-sm display" style="width:98%">
            <tr>
              <td width="40%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Filtro</label>
                </div>
              </td>
              <td width="40%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Dato</label>
                </div>
              </td>
              <td width="20%">
                <div class="label" style="width:100%">
                    <label>&nbsp;</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <select class="form-control" name="filtro" id="filtro" required="required">
					<option value="">Seleccionar</option>
					<option value="1">Por Contacto</option>
					<option value="2">Por Solicitante</option>
					<option value="3">Por Origen</option>
					<option value="4">Por Destino</option>
				</select>
              </td>
              <td>
                <input type="text" name="dato" id="dato" class="form-control" required="required">
              </td>
              <td>
                <button type="submit" class="btn btn-primary btn-block" id="guardar">Filtrar</button>
              </td>
            </tr>
          </table>
          </form>
      </div>
    </div>

    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">
    	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-6">
    		  <h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-file" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Resultado</h2>
    	</div>
    </div>

    <hr style="background-color:#5e99b1;">
      <div class="mt-2 p-4 table-responsive">
    	  <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
      		<thead>
      			<tr>
              <th>ID SERVICIO</th>
              <th>CLIENTE</th>
              <th>FECHA SERVICIO</th>
              <th>HORA SERVICIO</th>
              <th>ORIGEN</th>
              <th>DESTINO</th>
              <th>CONTACTO</th>
              <th>SOLICITADO POR</th>
      		 <th>OPCIONES</th>
      		</tr>
      		</thead>
    		  <tbody>
            <?php foreach ($busqueda as $lv){ ?>
              <tr>
                  <td><?php echo $lv['id_detalle'] ?></td>
                  <td><?php echo $lv['id_cliente'] ?></td>
                  <td><?php echo $lv['fecha_servicio'] ?></td>
                  <td><?php echo $lv['hora_servicio'] ?></td>
                  <td><?php echo $lv['origen'] ?></td>
                  <td><?php echo $lv['destino'] ?></td>
                  <td><?php echo $lv['contacto'];?></td>
				  <td><?php echo $lv['solicitante'];?></td>
                        
                  <td>
                        <a href="duplicarSolucitud.php?id_s=<?php echo $lv['id_detalle'];?>" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;">
						<span class="fa fa-files-o"></span></a>
                  </td>
              </tr>
            <?php } ?>
    		  </tbody>
    	  </table>
      </div>
    
    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">


function modal(id_vehiculo){
  /*alert(id_vehiculo);*/
  document.getElementById('id_veh').value = id_vehiculo;

   var parametros = {
                "id_vehiculo" : id_vehiculo
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/listarDocsVehiculo.php', //archivo que recibe la peticion
                type:  'post', //método de envio
                beforeSend: function () {
                  $("#contenido_modal").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        //alert(response);
                  $("#contenido_modal").html(response);
                }
        });
}

function modalCond(id_vehiculo){
  /*alert(id_vehiculo);*/
  document.getElementById('id_veh').value = id_vehiculo;

   var parametros = {
                "id_vehiculo" : id_vehiculo
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/listarCondsVehiculo.php', //archivo que recibe la peticion
                type:  'POST', //método de envio
                beforeSend: function () {
                        $("#contenido_modal_cond").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        //alert(response);
                        $("#contenido_modal_cond").html(response);
                }
        });
}


  </script>
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