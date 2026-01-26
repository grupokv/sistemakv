<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once('../Modelo/Salud.php');
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/EmpresaEnt.php");

/* VARIABLES MENU*/
$titulo = 'Filtrar reporte salud';
$redireccion = 'reporte_salud.php';
$icono = 'fa fa-file-text-o';

$contrato = new Contrato();
$empresa = new Empresa();
$cliente = new Cliente();
$salud = new Salud();


$hoy = date('Y-m-d');
$listadoContratos = $contrato->listarContratosHabiles($hoy);

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Reporte Salud</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
    
</head>
<body>



    <?php include("Template/menu.php"); ?>

    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="reporte_salud.php">Reporte Salud</a></li>
			<li class="breadcrumb-item active" aria-current="page">Filtro</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">

            <!--FORMULARIO -->
	            <form method="POST" action="../Vista/resultadoReporteSalud.php">	
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

                    <!-- Fecha final -->
                        <div class="row mt-4 mb-4 ">
                              <div class="label">    
                                  <label>Contrato</label>
                              </div>
                              <div class="input">    
                                  <select class="form-control selectpicker" data-live-search="true" id="id_contrato" name="id_contrato">
                                      <option value="">SELECCIONAR</option>
                                      <?php foreach ($listadoContratos as $lc){ ?>            
                                          <?php $datos_cliente = $cliente->cliente_ID($lc['id_cliente']);           
                                          $datos_empresa = $empresa->listarPorId($lc['id_empresa']);?>                                    

                                          <option width="100" value="<?php echo $lc['id_contrato'];?>">   
                                              <?php echo $lc['id_contrato']. " | " . $datos_cliente[0]['razon_social']; ?>
                                          </option>                                
                                      <?php } ?> 
                                  </select>
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

    $(function(){
        $("#datepicker").datepicker({ dateFormat:'yy-mm-dd'});
        $("#datepicker1").datepicker({ dateFormat:'yy-mm-dd'});
        
    });

    </script>
	
</body>
</html>