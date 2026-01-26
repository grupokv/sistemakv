<?php include ("../Controlador/Sesion/autenticar.php");
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
} else {    
    $id_vehiculo = '%%';
}

$id_contrato = '';

if ($_POST['id_contrato'] != 0) {    
	$id_contrato = $_POST['id_contrato'];
}

$fecha_inicial = '0000-00-00';

if ($_POST['fecha_inicial'] != '') {    
    $fecha_inicial = $_POST['fecha_inicial'];
} else {    
    $fecha_inicial = '0000-00-00';
}

$fecha_final = '9999-12-31';

if ($_POST['fecha_final'] != '') {    
    $fecha_final = $_POST['fecha_final'];
} else {    
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

		$listarP = $preoperacional->listarTodosPreoperacionalContrato($id_vehiculo, $fecha_inicial, $fecha_final);

	} else {	
		$listarP = $preoperacional->listarTodos($id_vehiculo, $fecha_inicial, $fecha_final);
	}
} else {
	$fecha = date('Y-m-d');
    $listarP = $preoperacional->listar($fecha);
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Pre - operacionales</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- STYLES -->

    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style type="text/css" media="screen">
    </style>

  <!--FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
  
    <!-- CONTENIDO -->
<section class="home_content">  

    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item" aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Preoperacionales</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">PREOPERACIONALES</b></strong>
    </div>


    <div class="notice notice-sistemakv">
        <a id="buttonsKV" href="preoperacionalInfo.php" class="btn btn-outline-info">
            <i class="fa fa-plus ml-2 mr-2"></i>Registrar
        </a>

        <a id="buttonsKV" href="ExportFiltroPreoperacionales.php" class="btn btn-outline-info">
            <i class="fa fa-file-excel-o ml-2 mr-2"></i>Descargar Mes
        </a>
    </div>

    <!-- FILTRO REPORTE -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%">
            <p><b>FILTRAR REPORTE</b></p>
        </div>

        <div class="col-sm-12 col-md-12 mt-3 formulario_reporte" style="height: auto; width: 100%; border-radius: 4px; background-color: #fff; ">
            
            <form method="POST" action="" class="p-4">

                <div class="row mt-2 p-3" style="border: 1px dashed #ddd">		    

                    <!-- CONTRATO-->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 formulario">                            
                            <label><strong>CONTRATO</strong></label>                           
                            <select class="form-control selectpicker" data-live-search="true" name="id_contrato" onchange="listado_vehiculos(this.value)">                                
                                <option value="">SELECCIONAR</option>                                
                                <?php foreach ($listadoContratos as $lc){ ?>				    
                                    <?php $datos_cliente = $cliente->cliente_ID($lc['id_cliente']);				    
                                    $datos_empresa = $empresa->listarPorId($lc['id_empresa']);?>                                    

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
                                <option value="">SELECCIONAR</option> 
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
                            <input type="text" name="fecha_inicial" id="datepicker" class="form-control" placeholder="SELECCIONE FECHA"/>
                        </div>

                    <!-- FECHA FINAL -->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 formulario">
                            <label><strong>FECHA FINAL</strong></label>
                            <input type="text" name="fecha_final" id="datepicker1" class="form-control" placeholder="SELECCIONE FECHA"/>
                        </div>

                </div>
            
                <div class="row d-flex justify-content-center mt-3">
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" name="consultar" class="btn btn-block" style="background-color: #1b2d3b; color: #fff;">Filtrar</button>
                    </div>
                </div>

            </form>

            <form method="POST" action="../Controlador/exportarFiltroPreoperacionalExcel.php" class="d-flex justify-content-center p-0">
                <div class="col-sm-6 col-md-3">
                    <input type="hidden" class="form-control" name="contrato" id="contrato" value="<?php echo $_POST['id_contrato']; ?>">
                    <input type="hidden" class="form-control" name="vehiculo" id="vehiculo" value="<?php echo $_POST['id_vehiculo']; ?>">
                    <input type="hidden" class="form-control" name="fechaInicial" id="fechaInicial" value="<?php echo $_POST['fecha_inicial']; ?>">
                    <input type="hidden" class="form-control" name="fechaFinal" id="fechaFinal" value="<?php echo $_POST['fecha_final']; ?>">

                    <label>&nbsp;</label>
                    <button type="submit" name="consultar" class="btn btn-block mb-4" style="background-color: darkcyan; color: #fff;">Exportar Filtro</button>
                </div>
            </form>
        
        </div>

            

        <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
        	<table id="dataT" class="table table-hover table-sm display" style="width:100%">
        		<thead  class="text-center">
                    <tr style="background-color: #1b2d3b; color: #fff;">
                        <th colspan="6" style="text-align:center; border-bottom: 2px solid #fff;">TOTAL: <?php echo count($listarP);?></th>
                    </tr>
                    <tr style="background-color: #1b2d3b; color: #fff;">
        				<th>ID</th>
                        <th>VEHICULO</th>
                        <th>CONDUCTOR</th>
        				<th>FECHA CREACIÓN</th>
                        <th>USUARIO</th>
        				<th>OPCIONES</th>
        			</tr>
        		</thead>
        		<tbody class="text-center">
                        
                    <?php foreach ($listarP as $lpo){ ?>
                        <tr>
                            <td><?php echo $lpo['id']; ?></td>
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
                            <td><?php echo $lpo['fecha_creacion']; ?></td>
                            <td>
                                <?php 
                                    $listarUsuariosId = $usuario->listarUsuarioPorId($lpo['id_usuario']);
                                    echo $listarUsuariosId[0]['nombre'];
                                ?>
                            </td>
                            <td>
                                <button data-toggle="modal" data-target="#preoperacionales" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="listarPreoperacional(<?php echo $lpo['id']; ?>);"><span class="fa fa-search"></span></button>
                            </td>
                        </tr>
                    <?php } ?>

        		</tbody>
        	</table>
        </div>

    <!-- FIN CONTENIDO -->
</section>

<!-- MODAL PREOPERACIONAL -->
    <div class="modal fade" id="preoperacionales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-body">
                    
                    <div class="notice notice-sistemakv">
                        <strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRO DE PREOPERACIONAL</b></strong>
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

        function listarPreoperacional(id_preoperacional){

            var parametros = {
                "id_preoperacional" : id_preoperacional
            };
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '../Controlador/listarPreoperacional.php', //archivo que recibe la peticion
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
				$("#id_vehiculo").html("<option value=''>Procesando, espere por favor...</option>");                  	
			},      
			success:  function (response) {                      	                      	
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
					$("#id_vehiculo").html("<option value=''>Procesando, espere por favor...</option>");                  	
				},                  	
				success:  function (response) {                      	                      	
					$("#id_vehiculo").html(response);			
					$('#id_vehiculo').addClass("selectpicker").selectpicker('refresh');                  	
				}              		
			});		
		}	
	}
    </script>

</body>
</html>