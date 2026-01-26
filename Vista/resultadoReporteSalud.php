<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Salud.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/EmpresaEnt.php");

$salud = new Salud();
$usuario = new Usuario();
$contrato = new Contrato();
$empresa = new Empresa();
$cliente = new Cliente();

$fechai = $_POST['fecha_inicial'];
$fechaf = $_POST['fecha_final'];
$id_contrato = $_POST['id_contrato'];

$listarC = $salud->listarPorRangoFecha($fechai, $fechaf, $id_contrato);

$modulo = 97;
$permisos = permisos($modulo,$_SESSION['id_usuario']);

$hoy = date('Y-m-d');
$listadoContratos = $contrato->listarContratosHabiles($hoy);

//print_r($permisos);
if(count($permisos) < 1){
  echo ("<script LANGUAGE='JavaScript'>window.location.href='https://www.sistemakv.com/';</script>");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Reporte Salud</title>
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
            <li class="breadcrumb-item active" aria-current="page">Reporte Salud</li>
         </ol>
    </div>
    
    <!-- BARRA PRINCIPAL-->
    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">
    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-users" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Reporte Salud</h2>
    	</div>
    </div>

    <!------------------------------------------------------>

    <!-- FILTRO REPORTE -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 ml-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 96%">
        <p>OPCIONES FILTRO</p>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2 ml-4" style="height: auto; width: 96%; border-radius: 4px; background-color: #fafafa; ">
        
      <div class="row d-flex justify-content-center p-3">
            <section class="col-5 d-flex justify-content-end">
                <a href="filtroReporteSalud.php" class="btn col-6" style="background-color: #5e99b1; color: #fff;">Filtro</a>
            </section>
            <section class="col-5">
      					<form action="exportarReporteSalud.php" method="POST">
				            <input type="hidden" name="fecha_inicial" value="<?php echo $fechai; ?>"/>
          					<input type="hidden" name="fecha_final" value="<?php echo $fechaf; ?>"/>
                    <input type="hidden" name="contrato" value="<?php echo $id_contrato; ?>"/>
          					<button type="submit" class="btn btn-success  col-6" id="exportar">Exportar Resultado</button>
      					</form>
            </section>
      </div>

    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 ml-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 96%; height: 2px;">
    </div>
	
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr class="text-center" style="border: none !important;">
            <th>NOMBRE</th>
            <th>DOCUMENTO</th>
            <th>EMPRESA</th>
            <th>EMAIL</th>
            <th>CELULAR</th>
				    <th>FECHA</th>
            <th>CONTRATO</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
          <?php foreach ($listarC as $lc){ ?>
              <tr  class="text-center">
                  <td>
                      <?php 
                          $datos_usu = $usuario->listarUsuarioPorId($lc['id_usuario']); 
                          echo $datos_usu[0]['nombre']; 
                      ?>
                  </td>
                  <td><?php echo $datos_usu[0]['usuario']; ?></td>
                  <td><?php echo strtoupper($lc['empresa']) ?></td>
			            <td width="130"><?php echo strtoupper($lc['email']) ?></td>
                  <td><?php echo $lc['celular'] ?></td>
			            <td width="150"><?php echo $lc['fecha_diligenciamiento'] ?></td>
                  <td width="150"><?php echo $lc['contrato'] ?></td>
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
                url:   '../Controlador/listarReporteSalud.php', //archivo que recibe la peticion
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

    $(function(){
        $("#datepicker").datepicker({ dateFormat:'yy-mm-dd'});
        $("#datepicker1").datepicker({ dateFormat:'yy-mm-dd'});
        
    });

    </script>
  
</body>
</html>