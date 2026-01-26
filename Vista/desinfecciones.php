<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Pre-operacionales.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/EmpresaEnt.php");

$vehiculo = new Vehiculo();
$veh_con = new Vehiculo_Contrato();
$contrato = new Contrato();

$hoy = date('Y-m-d');

$listadoContratos = $contrato->listarContratosHabiles($hoy);
$listarTodosVehiculos = $vehiculo->listarActivos();
$conductor = new Conductor();
$usuario = new Usuario();
$empresa = new Empresa();
$cliente = new Cliente();

$id_vehiculo = '';
if ($_POST['id_vehiculo'] != 0) {
    $id_vehiculo = $_POST['id_vehiculo'];
}else{
    $id_vehiculo = '%%';
}

$id_contrato = '';
if ($_POST['id_contrato'] != 0) {
    $id_contrato = $_POST['id_contrato'];
}

$fecha_inicial = '0000-00-00';
if ($_POST['fecha_inicial'] != '') {
    $fecha_inicial = $_POST['fecha_inicial'];
}else{
    $fecha_inicial = '0000-00-00';
}

$fecha_final = '9999-12-31';
if ($_POST['fecha_final'] != '') {
    $fecha_final = $_POST['fecha_final'];
}else{
    $fecha_final = '9999-12-31';
}

$preoperacional = new PreOperacionales();
if($_POST){
if($id_contrato != ''){
	if($id_vehiculo == '%%'){
	  $id_vehiculo = '';
	  $listado_veh = $veh_con->listarPorContrato($id_contrato);
	  $cant = count($listado_veh);
	  $i = 1;
	  foreach($listado_veh as $lv){
		if($i == $cant){
		$id_vehiculo = $id_vehiculo.''.$lv['id_vehiculo'];
		} else {
		$id_vehiculo = $id_vehiculo.''.$lv['id_vehiculo'].',';
		}
		$i++;
	  }
	} 
	$listarP = $preoperacional->listarTodosDesinfeccionesContrato($id_vehiculo, $fecha_inicial, $fecha_final);
} else {
	$listarP = $preoperacional->listarTodosDesinfecciones($id_vehiculo, $fecha_inicial, $fecha_final);
}
} else {
$listarP = array();    
}


?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Desinfecciones</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <!--fin  styles -->
    <style type="text/css" media="screen">


        .barra-principal{
            background-color: #5e99b1;
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


        .titulo_reporte{
            margin-left: 25px;
        }

        .formulario_reporte{
            margin-left: 25px;
        }

        .linea_reporte{
            margin-left: 25px;
        }

        @media (max-width: 760px){
            .titulo_principal{
              text-align: center;
            }

            .botones_principal{
              display: flex;
              justify-content: center;
            }

            .titulo_reporte{
                margin-left: 9px;
            }
            
            .formulario_reporte{
                margin-left: 9px;
            }

            .linea_reporte{
                margin-left: 9px;
            }

            .formulario{
                margin-top: 2px; 
                margin-bottom: 2px;
            }
        }

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
            <li class="breadcrumb-item active" aria-current="page">Preoperacionales</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
              <h2 class="mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-file-text-o icono-principal ml-2" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> desinfecciones</h2>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 botones_principal">
            
        </div>
    </div>

    <!-- FILTRO REPORTE -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 96%">
            <p>FILTRAR REPORTE</p>
        </div>

        <div class="col-sm-12 col-md-12 mt-3 formulario_reporte" style="height: auto; width: 96%; border-radius: 4px; background-color: #fafafa; ">
            
            <form method="POST" action="">
                <div class="row mt-2">
		   <!-- CONTRATO-->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 formulario">
                            <label><strong>CONTRATO</strong></label>
                            <select class="form-control selectpicker" data-live-search="true" name="id_contrato" onchange="listado_vehiculos(this.value)">
                                <option value="">SELECCIONAR</strong></option>
                                <?php foreach ($listadoContratos as $lc){ ?>
				    <?php
				    $datos_cliente = $cliente->cliente_ID($lc['id_cliente']);
				    $datos_empresa = $empresa->listarPorId($lc['id_empresa']);
				    ?>
                                    <option value="<?php echo $lc['id_contrato'];?>">
                                       <?php echo $lc['id_contrato']." | entre ".$datos_empresa[0]['nombre_empresa']." Y ".$datos_cliente[0]['razon_social']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                    <!-- VEHICULO-->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 formulario">
                            <label><strong>VEHICULO</strong></label>
                            <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo" id="id_vehiculo">
                                <option value="0">SELECCIONAR</strong></option>
                                <?php foreach ($listarTodosVehiculos as $ltv){ ?>
                                    <option value="<?php echo $ltv['id_vehiculo'] ?>">
                                        <?php echo $ltv['placa'] . ' - ' . $ltv['numero_movil']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                     <!-- FECHA INICIAL -->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 formulario">
                            <label><strong>FECHA INICIAL</strong></label>
                            <input type="text" name="fecha_inicial" id="datepicker" class="form-control" placeholder="SELECCIONE FECHA">
                        </div>

                    <!-- FECHA FINAL -->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 formulario">
                            <label><strong>FECHA FINAL</strong></label>
                            <input type="text" name="fecha_final" id="datepicker1" class="form-control" placeholder="SELECCIONE FECHA">
                        </div>
                </div>
                
            
                <div class="row mt-2 d-flex justify-content-center">
                    <div class="col-sm-6 col-md-3">
                        <label>&nbsp;</label>
                        <button name="consultar" class="btn btn-block" style="background-color: #1b2d3b; color: #fff;">Filtrar</button>
                    </div>
                </div>

            </form>
        </div>
        

        <div class="mt-2 p-4 table-responsive">
        	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
        		<thead>
        			<tr>
        				<th>ID</th>
                        <th>VEHICULO</th>
                        <th>CONDUCTOR</th>
        				<th>FECHA CREACIÓN</th>
                        <th>USUARIO</th>
        				<th>OPCIONES</th>
        			</tr>
        		</thead>
        		<tbody>
                        
                    <?php foreach ($listarP as $lpo){ ?>
                        <tr>
                            <td><?php echo $lpo['id_desinfeccion']; ?></td>
                            <td>
                                <?php 
                                    $listarPorId = $vehiculo->listarPorId($lpo['id_vehiculo']);
                                    echo $listarPorId[0]['placa'] . ' - ' . $listarPorId[0]['numero_movil']; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $listarConductorId = $conductor->listarPorId($lpo['id_conductor']);
                                    echo $listarConductorId[0]['nombre_conductor']; 
                                ?>
                            </td>
                            <td><?php echo $lpo['fecha']; ?></td>
                            <td>
                                <?php 
                                    $listarUsuariosId = $usuario->listarUsuarioPorId($lpo['id_usuario']);
                                    echo $listarUsuariosId[0]['nombre'];
                                ?>
                            </td>
                            <td>
                                <button data-toggle="modal" data-target="#preoperacionales" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="listarPreoperacional(<?php echo $lpo['id_desinfeccion']; ?>);"><span class="fa fa-search"></span></button>
                            </td>
                        </tr>
                    <?php } ?>

        		</tbody>
        	</table>
        </div>

        <!-- Modal -->
            <div class="modal fade" id="preoperacionales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content ">
                        <div class="modal-body">
                            <div class="alert alert-info text-center" role="alert">
                                <strong> DESINFECCION </strong>
                            </div>
                            
                            <section class="ml-3" id="contenido_modal">
                                
                            </section>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
    
    <!-- FIN CONTENIDO -->


    <!-- script -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
        $( function() {

            $( "#datepicker" ).datepicker({ 
                dateFormat:'yy-mm-dd',
                changeMonth:true,
                changeYear:true,
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']

            });

            $( "#datepicker1" ).datepicker({ 
                dateFormat:'yy-mm-dd',
                changeMonth:true,
                changeYear:true,
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
            });

        } );

        function listarPreoperacional(id){
	    
	    var parametros = {
                "id" : id
            };
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/listarDesinfeccion.php', //archivo que recibe la peticion
                    type:  'POST', //método de envio
                    beforeSend: function () {
                            $("#contenido_modal").html("<p class='text-center'><strong> PROCESANDO, ESPERE POR FAVOR... </strong></p>");
                    },
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                            //alert(response);
                            $("#contenido_modal").html(response);
                    }
            });
        }
	function listado_vehiculos(id_contrato){
		if(id_contrato == ''){
			var parametros = {
                	"contrato" : 0
              		};
              		$.ajax({
                  	data:  parametros,
                  	url:   '../Modelo/CargarVehiculosFiltroContrato.php',
                  	type:  'post',
                  	beforeSend: function () {
                      	//alert('envio');
                      	$("#id_vehiculo").html("<option value=''>Procesando, espere por favor...</option>");
                  	},
                  	success:  function (response) {
                      	//alert(response);
                      	$("#id_vehiculo").html(response);
			$('#id_vehiculo').addClass("selectpicker").selectpicker('refresh');
                  	}
              		});
		} else {
			var parametros = {
                	"contrato" : id_contrato
              		};
              		$.ajax({
                  	data:  parametros,
                  	url:   '../Modelo/CargarVehiculosFiltroContrato.php',
                  	type:  'post',
                  	beforeSend: function () {
                      	//alert('envio');
                      	$("#id_vehiculo").html("<option value=''>Procesando, espere por favor...</option>");
                  	},
                  	success:  function (response) {
                      	//alert(response);
                      	$("#id_vehiculo").html(response);
			$('#id_vehiculo').addClass("selectpicker").selectpicker('refresh');
                  	}
              		});
		}
	}
    </script>

</body>
</html>