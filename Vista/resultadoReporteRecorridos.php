<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");

$fechai = $_POST['fecha_inicial'];
$fechaf = $_POST['fecha_final'];
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
$veh = new Vehiculo();$recorridos = $veh->recorridosFechas($fechai,$fechaf);
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

    <hr>
    <div class="row">
      <div class="mt-2 p-4 table-responsive">
        <form action="../Vista/resultadoReporteRecorridos.php" method="POST">
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
            <tr>
              
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
          <form action="exportar_reporte_recorridos.php" method="post">
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
              <th>ID RECORRIDO</th>	      <th>ID RUTA</th>
              <th>FECHA</th>
              <th>CANT. PASAJEROS</th>
      				<th>OPCIONES</th>
      			</tr>
      		</thead>
    		  <tbody>
            <?php foreach ($recorridos as $lv){ ?>
              <tr>
                  <td><?php echo $lv['id_recorrido'] ?></td>		  <td><?php $datos_ruta = $veh->listarRutaPorId($lv['id_ruta']); echo $datos_ruta[0]['num_ruta']; ?></td>
                  <td><?php echo $lv['fecha_inicio'] ?></td>
                  <td>		      <?php $pas = $veh->buscarRecorridoId($lv['id_recorrido']);?>
                      <?php if(count($pas) == 1){
                            echo count($pas) . " Pasajero";
                      }else{
                            echo count($pas) . " Pasajeros";
                      }?>
                  </td>
                 
                  <td>
                        <a href="" class="btn btn-outline-primary"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#vehiModal" onclick="modal(<?php echo $lv['id_recorrido'];?>)"><span class="fa fa-search"></span></a>
                  </td>
              </tr>
            <?php } ?>
    		  </tbody>
    	  </table>
      </div>
    
    <!-- FIN CONTENIDO -->
<!-- Modal CONDUCTORES-->          <div class="modal fade" id="vehiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">            <div class="modal-dialog " role="document">              <div class="modal-content f-flex justify-content-center">                <div class="modal-header">                    <h5 class="modal-title " id="exampleModalLabel">DETALLE RECORRIDO</h5>                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">                      <span aria-hidden="true">&times;</span>                    </button>                </div>                <div class="modal-body">                    <section id="contenido_modal" name="contenido_modal">                    </section>                </div>                <div class="modal-footer">                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>                </div>              </div>            </div>          </div>

  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">


function modal(id){

   var parametros = {
                "id" : id
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/listarPasajerosRecorrido.php', //archivo que recibe la peticion
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