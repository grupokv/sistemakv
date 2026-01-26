<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Programacion.php");
require ("../Modelo/Cliente.php");
require ("../Modelo/TipoServicio.php");

$tipo_servicio = $_POST['id_tiposervicio'];
$fechai = $_POST['fecha_inicial'];
$fechaf = $_POST['fecha_final'];
$cliente1 = $_POST['id_cliente'];
$vehiculo1 = $_POST['id_vehiculo'];

if($cliente1 == ''){
  $cliente1 = '%%';
}
if($tipo_servicio == ''){
  $tipo_servicio = '%%';
}
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
if($vehiculo1 == ''){
  $listarV = $programacion->consultaReporte1($cliente1,$tipo_servicio,$fechai,$fechaf);
} else {
  $serv = $programacion->buscarServiciosPorVehiculoTodos($vehiculo1);
  $cant = count($serv);
  $servicios = '';
  $a = 1;
  foreach($serv as $ser){
    if($a == $cant){
      $servicios .= $ser['id_servicio'];
    } else {
      $servicios .= $ser['id_servicio'].',';
    }
    $a++;
  }
  $listarV = $programacion->consultaReporte2($cliente1,$tipo_servicio,$servicios,$fechai,$fechaf);
}

$cliente = new Cliente();
$listarA = $cliente->listar();
$vehiculo = new Vehiculo();
$listarVE = $vehiculo->listarActivos();
$tiposervicio = new TipoServicio();
$listarTS = $tiposervicio->listarCliente();

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
            <li class="breadcrumb-item " aria-current="page"><a href="reporteServicios.php">Filtro Reporte</a></li>
            <li class="breadcrumb-item active" aria-current="page">Resultados Reporte</li>
         </ol>
    </div>
    
    <hr>
    <div class="row">
      <div class="mt-2 p-4 table-responsive">
        <form action="../Vista/resultadoReporteServicios.php" method="POST">
        <table class="table table-sm display" style="width:98%">
            <tr>
              <td width="19%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Por Cliente</label>
                </div>
              </td>
              <td width="19%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Por Vehiculo</label>
                </div>
              </td>
              <td width="19%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Por Tipo Servicio</label>
                </div>
              </td>
              <td width="15%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Fecha Inicial</label>
                </div>
              </td>
              <td width="15%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Fecha Final</label>
                </div>
              </td>
              <td width="13%">
                <div class="label" style="width:100%">
                    <label>&nbsp;</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente">
                  <option value="">Seleccionar </option>
                  <?php foreach ($listarA as $la){ ?>
                    <option value="<?php echo $la['id_cliente'] ?>">
                      <?php echo $la['nit_cliente'].' | '.$la['razon_social']; ?>
                    </option>
                  <?php } ?>
                </select>
              </td>
              <td>
                <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo" id="id_vehiculo">
                  <option value="">Seleccionar </option>
                  <?php foreach ($listarVE as $la){ ?>
                    <option value="<?php echo $la['id_vehiculo'] ?>">
                      <?php echo $la['placa'].' | '.$la['numero_movil']; ?>
                    </option>
                  <?php } ?>
                </select>
              </td>
              <td>
                <select class="form-control selectpicker" data-live-search="true" name="id_tiposervicio" id="id_tiposervicio">
                  <option value="">Seleccionar </option>
                  <?php foreach ($listarTS as $la){ ?>
                    <option value="<?php echo $la['id_tipo_servicio'] ?>">
                      <?php echo $la['nombre_tipo_servicio'] ?>
                    </option>
                  <?php } ?>
                </select>
              </td>
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
          <input type="hidden" name="export_cliente" value="<?php echo $cliente1; ?>">
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
      			<tr class="text-center">
              <th>ID SERVICIO</th>
              <th>CLIENTE</th>
              <th>FECHA SERVICIO</th>
              <th>HORA SERVICIO</th>
              <th>ORIGEN</th>
              <th>DESTINO</th>
              <th>CANTIDAD</th>
              <th>ESTADO</th>
      				<th>OPCIONES</th>
      			</tr>
      		</thead>
    		  <tbody>
            <?php foreach ($listarV as $lv){ ?>
              <tr class="text-center">
                  <td><?php echo $lv['id_detalle'] ?></td>
                  <td>
                    <?php 
                        $listarClienteID = $cliente->cliente_ID($lv['id_cliente']);
                        echo strtoupper($listarClienteID[0]['razon_social']); 
                    ?>
                  </td>
                  <td><?php echo $lv['fecha_servicio'] ?></td>
                  <td><?php echo $lv['hora_servicio'] ?></td>
                  <td><?php echo strtoupper($lv['origen'] ); ?></td>
                  <td><?php echo strtoupper($lv['destino']);  ?></td>
                  <td>
                      <?php if($lv['cant_pasajeros'] == 1){
                            echo $lv['cantidad'] . " PASAJERO";
                      }else{
                            echo $lv['cantidad'] . " PASAJEROS";
                      }?>
                  </td>
                  <td>
                    <?php 
                      if($lv['estado'] == 'P'){
                        echo "PENDIENTE";
                      } else if($lv['estado'] == 'C'){
                        echo "CANCELADO";
                      } else if($lv['estado'] == 'A'){
                        echo "ASIGNADO";
                      } else if($lv['estado'] == 'I'){
                        echo "INICIADO";
                      } else {
                        echo "FINALIZADO";
                      }
                    ?>
                  </td>       
                  <td>
                        <a href="" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#modal_servicio" onclick="modal_servicio(<?php echo $lv['id_detalle'];?>)"><span class="fa fa-search"></span></a>
                  </td>
              </tr>
            <?php } ?>
    		  </tbody>
    	  </table>
      </div>
    
    <!-- FIN CONTENIDO -->

    <!--INICIO DETALLE SERVICIO-->

      <div class="modal fade" id="modal_servicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

          <div class="modal-content d-flex justify-content-center">

            <div class="modal-header" style="height: 60px; background-color: #1b2d3b; color: #FFF " >

              <h5 class="modal-title" id="titulo_servicio"></h5>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true" style="color:#FFF">&times;</span>

              </button>

            </div>

            <div class="modal-body">

               <section id="contenido_modal_servicio" name="contenido_modal_servicio"></section>

            </div>

            <div class="modal-footer d-flex justify-content-center">

              <button type="button" class="btn btn-outline-danger btn-block col-3" data-dismiss="modal">Cerrar</button>

            </div>

          </div>

        </div>

      </div>

  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">


function modal_servicio(id){

    $("#titulo_servicio").html('DETALLE SERVICIO No. '+id );

    $('#contenido_modal_servicio').load('contenido_modal_servicio.php?ids='+id,function(){

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