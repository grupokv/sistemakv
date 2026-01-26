<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Salud.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Usuario.php");

$salud = new Salud();

$fechai = $_POST['fecha_inicial'];
$fechaf = $_POST['fecha_final'];

$fechai = date("Y-m-d", strtotime($fechai));
$fechaf = date("Y-m-d", strtotime($fechaf));

$listarC = $salud->listarPorRangoFechaVulnerabilidad($fechai,$fechaf);
$usuario = new Usuario();
$modulo = 97;
$permisos = permisos($modulo,$_SESSION['id_usuario']);
//print_r($permisos);
if(count($permisos) < 1){
  echo ("<script LANGUAGE='JavaScript'>
    window.location.href='https://www.sistemakv.com/';
    </script>");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Reporte Vulnerabilidad</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <style type="text/css">
    

    .barra-principal{
      background-color: #5e99b1;
      width: auto;
    }

    .botones_principal{
      display: flex;
      justify-content: flex-end;
    }

    .boton-registro{
      background-color: #fff; 
      height: 40px; 
      margin-top: 10px; 
      margin-bottom: 10px; 
      color: #00a0df;
    }

    @media (max-width: 760px){
      
        .fa-plus{
           display: none;
        }

        .titulo_principal{
          text-align: center;
        }

        .botones_principal{
          display: flex;
          justify-content: center;
        }
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
            <li class="breadcrumb-item active" aria-current="page">Reporte Vulnerabilidad</li>
         </ol>
    </div>
    
    <!-- BARRA PRINCIPAL-->
    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">
    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-users" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Reporte Salud</h2>
    	</div>
    </div>
    <!---->
	<div class="row">
      <div class="mt-2 p-4 table-responsive">
        
        <table class="table table-sm display" style="width:98%">
            <tr>
              <td width="45%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Fecha Inicial</label>
                </div>
              </td>
              <td width="45%">
                <div class="label" style="width:100%;margin-left:2px">
                    <label>Fecha Final</label>
                </div>
              </td>
              <td width="10%">
                <div class="label" style="width:100%">
                    <label>&nbsp;</label>
                </div>
              </td>
            </tr>
			<form action="resultadoReporteVulnerabilidad.php" method="POST">
            <tr>
              <td>
                <input type="text" name="fecha_inicial" id="datepicker" class="form-control" autocomplete="off">
              </td>
              <td>
                <input type="text" name="fecha_final" id="datepicker1" class="form-control" autocomplete="off">
              </td>
              <td>
                <button type="submit" class="btn btn-primary btn-block" id="guardar">Filtrar</button>
              </td>
            </tr>
			</form>
			<tr>
				<td colspan="3" align="right">
					<form action="exportarReporteVulnerabilidad.php" method="POST">
					<input type="hidden" name="fecha_inicial" value="<?php echo $fechai; ?>"/>
					<input type="hidden" name="fecha_final" value="<?php echo $fechaf; ?>"/>
					<button type="submit" class="btn btn-success" id="exportare">Exportar Resultado</button>
					</form>
				</td>
			</tr>
          </table>
      </div>
    </div>
	
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
                    <th>NOMBRE</th>
                    <th>N° DOCUMENTO</th>
                    <th>EMPRESA</th>
                    <th>EMAIL</th>
                    <th>CELULAR</th>
					<th>FECHA</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php foreach ($listarC as $lc){ ?>
                    <tr>
                        <td><?php $datos_usu = $usuario->listarUsuarioPorId($lc['id_usuario']); echo $datos_usu[0]['nombre']; ?></td>
                        <td><?php echo $datos_usu[0]['usuario']; ?></td>
                        <td><?php echo $lc['empresa'] ?></td>
						<td><?php echo $lc['email'] ?></td>
                        <td><?php echo $lc['celular'] ?></td>
						<td><?php echo $lc['fecha_diligenciamiento'] ?></td>
                        <td>

                            <?php if($permisos[0]['consulta'] == 1){ ?>
                            <!--Consultar-->
                             <a href="" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#exampleModal" onclick="modal(<?php echo $lc['id_respuesta'];?>)">
                                    <span class="fa fa-search"></span>
                            </a>
                          <?php } ?>     

                        </td>
                </tr>
                <?php } ?>
    		</tbody>
    	</table>
    </div>
    <!-- Modal -->                                
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">                                    
			<div class="modal-content f-flex justify-content-center">                                      
				<div class="modal-header">                                        
					<h5 class="modal-title" id="exampleModalLabel">DETALLE DE LA ENCUESTA</h5>                                        
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">                                          
						<span aria-hidden="true">&times;</span>                                        
					</button>                                     
				</div>                                      
				<div class="modal-body">                                         
					<section id="contenido_modal"></section>                                      
				</div>                                      
				<div class="modal-footer">                                        
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
				</div>                                    
			</div>                                 
		</div>                               
	</div>
    <!-- FIN CONTENIDO -->

  <!-- script -->
  <?php include("Template/scripts.php"); ?>
  <script type="text/javascript">


function modal(id){
   var parametros = {
                "id" : id
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/listarReporteVulnerabilidad.php', //archivo que recibe la peticion
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