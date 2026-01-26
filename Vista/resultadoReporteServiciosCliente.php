<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
$fechai = $_POST['fecha_inicial'];
$fechaf = $_POST['fecha_final'];
$cliente1 = $_POST['id_cliente'];

if($cliente1 == ''){
  $cliente1 = '%%';
}
$tipo_servicio = '%%';
if($fechai == ''){
  $fechai = '0000-00-00';
} else {
  $fechai = date("Y-m-d", strtotime($fechai));
}
if($fechaf == ''){
  $fechaf = '9999-12-31';
} else {
  $fechaf = date("Y-m-d", strtotime($fechaf));
}

$programacion = new Programacion();
$listarV = $programacion->consultaReporte1($cliente1,$tipo_servicio,$fechai,$fechaf);
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
            <li class="breadcrumb-item " aria-current="page"><a href="inicioCliente.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="reporteServiciosCliente.php">Filtro Reporte</a></li>
            <li class="breadcrumb-item active" aria-current="page">Resultados Reporte</li>
         </ol>
    </div>
    
    <hr>
    <div class="row">
      <div class="mt-2 p-4 table-responsive">
        <form action="../Vista/resultadoReporteServiciosCliente.php" method="POST">
        <table class="table table-sm display" style="width:98%">
            <tr>

              <td width="40%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Fecha Inicial</label>
                </div>
              </td>
              <td width="40%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Fecha Final</label>
                </div>
              </td>
              <td width="20%">
                <div class="label" style="width:100%">
                    <label>&nbsp;</label>
                </div>
              </td>
            </tr>
            
                <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $_SESSION['id_cliente'];?>">
              <td>
                <input type="text" name="fecha_inicial" id="datepicker" class="form-control" autocomplete="off">
              </td>
              <td>
                <input type="text" name="fecha_final" id="datepicker1" class="form-control" autocomplete="off">
              </td>
              <td>
                <button type="submit" class="btn btn-primary btn-block" id="guardar">Generar Reporte</button>
              </td>
            </tr>
          </table>
          </form>
      </div>
    </div>

    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">
    	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-6">
    		  <h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-file" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Resultado Reporte</h2>
    	</div>
    	<div class="col-lg-6 col-md-6 col-sm-4 col-xs-6 d-flex justify-content-end">
          <form action="exportar_reporte_servicio.php" method="post">
          <input type="hidden" name="export_cliente" value="<?php echo $_SESSION['id_cliente']; ?>">
          <input type="hidden" name="export_vehiculo" value="<?php echo $vehiculo1; ?>">
          <input type="hidden" name="export_tiposervicio" value="<?php echo $tipo_servicio; ?>">
          <input type="hidden" name="export_fechai" value="<?php echo $fechai; ?>">
          <input type="hidden" name="export_fechaf" value="<?php echo $fechaf; ?>">
          <button type="submit" class="btn mr-4 boton-registro" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">
          <span class="fa fa-download ml-2 mr-2"></span>Exportar</button>
          </form>
      </div>
    </div>

    <hr style="background-color:#5e99b1;">
      <div class="mt-2 p-4 table-responsive">
    	  <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
      		<thead>
      			<tr>
              <th>ID SERVICIO</th>
              <th>FECHA SERVICIO</th>
              <th>HORA SERVICIO</th>
              <th>ORIGEN</th>
              <th>DESTINO</th>
              <th>CANTIDAD</th>
              <th>ESTADO</th>
      			</tr>
      		</thead>
    		  <tbody>
            <?php foreach ($listarV as $lv){ ?>
              <tr>
                  <td><?php echo $lv['id_detalle'] ?></td>
                  <td><?php echo $lv['fecha_servicio'] ?></td>
                  <td><?php echo $lv['hora_servicio'] ?></td>
                  <td><?php echo $lv['origen'] ?></td>
                  <td><?php echo $lv['destino'] ?></td>
                  <td>
                      <?php if($lv['cant_pasajeros'] == 1){
                            echo $lv['cantidad'] . " Pasajero";
                      }else{
                            echo $lv['cantidad'] . " Pasajeros";
                      }?>
                  </td>
                  <td>
                    <?php 
                      if($lv['estado'] == 'P'){
                        echo "Pendiente";
                      } else if($lv['estado'] == 'C'){
                        echo "Cancelado";
                      } else if($lv['estado'] == 'A'){
                        echo "Asignado";
                      } else {
                        echo "Finalizado";
                      }
                    ?>
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