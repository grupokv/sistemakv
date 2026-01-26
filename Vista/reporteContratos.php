<?php 
include ("../Controlador/Sesion/autenticar.php");

require_once ('../Modelo/Contrato.php');
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/EmpresaEnt.php");

$contrato = new Contrato();
$cliente = new Cliente();
$empresa = new Empresa();
$usuario = new Usuario();
$ciudad = new Ciudad();

if($_POST){

    $fecha_inicial = '0000-00-00';
    if($_POST['fecha_inicial'] != ''){
        $fecha_inicial = $_POST['fecha_inicial'];
    }

    $fecha_final = '9999-12-31';
    if($_POST['fecha_final'] != ''){
        $fecha_final = $_POST['fecha_final'];
    }
   $filtrar = $contrato->filtrarRangoFechas($fecha_inicial, $fecha_final);
  
} else {
    $filtrar = array();
}

$total = count($filtrar);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Reporte Contratos Fijos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- styles -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!--fin  styles -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->


<section class="home_content"> 

    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="contratos.php">Contratos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte Contrato Fijos</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-clipboard mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REPORTE CONTRATOS FIJOS</b></strong>
    </div>

    <!--**************************--->
   
    <!-- FILTRO REPORTE -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%">
            <p><b>FILTRAR</b></p>
        </div>

        <div class="col-12 p-4" style="height: auto; width: 100%; border-radius: 4px; background-color: #fff; ">
            
            <form method="POST" action="">

                <!-- °°°°°°°°°°°°°°°°° -->

                <div class="row mt-2 d-flex justify-content-center">
                    <!-- FECHA INICIAL -->
                        <div class="col-3">
                            <label><b>FECHA INICIAL</b></label>
                            <input type="text" name="fecha_inicial" id="datepicker" class="form-control">
                        </div>

                    <!-- FECHA FINAL -->
                        <div class="col-3">
                            <label><b>FECHA FINAL</b></label>
                            <input type="text" name="fecha_final" id="datepicker2" class="form-control">
                        </div>
                </div>

                
                <!-- °°°°°°°°°°°°°°°°° -->
                
                <div class="row mt-2 d-flex justify-content-center">
                    <div class="col-3">
                        <label>&nbsp;</label>
                        <button type="submit" name="consultar" class="btn btn-outline-info btn-block">Filtrar</button>
			
                    </div>
                </div>
            </form>

            <form action="exportarReporteContratosFijos.php" method="post">
                <div class="row mt-2 d-flex justify-content-center">
                    <div class="col-3">
                        <input type="hidden" name="fecha_inicial" value="<?php echo $fecha_inicial;?>" />
                    	<input type="hidden" name="fecha_final" value="<?php echo $fecha_final;?>" />

		                <button type="submit" name="exportar" class="btn btn-outline-success btn-block">Exportar Resultado <i class="fa fa-file-excel-o ml-1"></i></button>
                    </div>
                </div>
            </form>

        </div>

    
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; height: 3px; width: 100%;">
        </div>
        
        <!-- TABLA INFORMACION BASICA-->
                <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
                        <table  id="dataT" class="table table-hover text-center table-sm display" style="width:100%">
                                <thead>
                                    <tr style="background-color: #1b2d3b; color: #fff;">
                                        <th colspan="8" style="text-align:center; border-bottom: 2px solid #fff;"><b>TOTAL EXTRACTOS: <?php echo $total; ?> </b></th>
                                    </tr>
                                    <tr style="background-color: #1b2d3b; color: #fff;">
                                        <th style="width: 10px;">NEM INTERNO</th>
                                        <th>NUM CONTRATO</th>
                                        <th>EMPRESA</th>
                                        <th>CLIENTE</th>
                    					<th>FECHA INICIAL</th>
                    					<th>FECHA FINAL</th>
                                        <th>FECHA CREACIÓN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($filtrar as $lffo){ ?>
                                        <tr>
                                            <td><?php echo $lffo['id_contrato']; ?></td>
                                            <td><?php echo $lffo['numero_contrato']; ?></td>
                                            <td><?php echo $lffo['nombre_empresa']; ?></td>
                                            <td><?php echo $lffo['razon_social']; ?></td>
                    					    <td><?php echo $lffo['fecha_inicial_contrato']; ?></td>
                    					    <td><?php echo $lffo['fecha_final_contrato']; ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($lffo['fecha_creacion_contrato'])); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                        </table>
                    </div>

        <!-- FIN CONTENIDO -->
        
    </div>

    <!-- script -->
        <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
        $( function() {
            $( "#datepicker" ).datepicker({ dateFormat:'yy/mm/dd'});
            $( "#datepicker2" ).datepicker({ dateFormat:'yy/mm/dd'});
            
        } );
    </script>
</body>
</html>