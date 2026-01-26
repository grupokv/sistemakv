<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ('../Modelo/Vehiculo.php');
require_once ('../Modelo/contratoOcasional.php');
require_once("../Modelo/Cliente.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Fuec.php");
require_once("../Modelo/Usuario.php");

$vehiculo = new Vehiculo();
$contratoOcasional = new ContratoOcasional();
$cliente = new Cliente();
$empresa = new Empresa();
$fuec = new Fuec();
$usuario = new Usuario();

$listarTodosContratosOcasionales = $contratoOcasional->listar();
$listarTodosVehiculos = $vehiculo->listarActivos();
$listarTodosClientes = $cliente->listar();
$listarEmisoresFuec = $fuec->listarEmisoresFuec();

if($_POST){

    $id_usuario_emisor = '%%';
    if($_POST['id_usuario_emisor'] != 0){
        $id_usuario_emisor = $_POST['id_usuario_emisor'];
    }

    $id_contrato_ocasional = '%%';
    if($_POST['id_contrato_ocasional'] != 0){
        $id_contrato_ocasional = $_POST['id_contrato_ocasional'];
    }

    $id_vehiculo = '%%';
    if($_POST['id_vehiculo'] != 0){
        $id_vehiculo = $_POST['id_vehiculo'];
    }
    

    $fecha_inicial = '0000-00-00';
    if($_POST['fecha_inicial'] != ''){
        $fecha_inicial = $_POST['fecha_inicial'];
    }


    $fecha_final = '9999-12-31';
    if($_POST['fecha_final'] != ''){
        $fecha_final = $_POST['fecha_final'];
    }
   $filtrarFuecsOcasionales = $fuec->filtrarFuecsOcasionales($id_usuario_emisor, $id_contrato_ocasional, $id_vehiculo, $fecha_inicial, $fecha_final);
  
} else {
    $filtrarFuecsOcasionales = array();
}


//print_r($filtrarFuecs);


$total = count($filtrarFuecsOcasionales);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Reporte Extractos Ocasionales</title>
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
            <li class="breadcrumb-item " aria-current="page"><a href="contratosOcasionales.php">Contratos Ocasionales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte Contrato Ocasional</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-clipboard mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REPORTE CONTRATOS OCASIONALES</b></strong>
    </div>

    <!--**************************--->
   
    <!-- FILTRO REPORTE -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%">
            <p><b>FILTRAR</b></p>
        </div>

        <div class="col-12 p-4" style="height: auto; width: 100%; border-radius: 4px; background-color: #fff; ">
            
            <form method="POST" action="">

                <!-- °°°°°°°°°°°°°°°°° -->
                <div class="row mt-2 d-flex justify-content-around">
                    <!-- EMISOR-->
                        <div class="col-3">
                            <label><b>EMISOR</b></label>
                            <select class="form-control selectpicker" data-live-search="true" name="id_usuario_emisor">
                                <option value="">SELECCIONAR</option>
                                <?php foreach ($listarEmisoresFuec as $lef){ 
                                        $listarUsuariosEmisores = $usuario->listarUsuarioPorId($lef['id_usuario']);
                                    ?>
                                    <option value="<?php echo $lef['id_usuario']; ?>">
                                        <?php foreach ($listarUsuariosEmisores as $lue) {
                                            echo $lue['nombre'];
                                        } ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                    <!-- CONTRATO-->
                        <div class="col-3">
                            <label><b>CONTRATO</b></label>
                            <select class="form-control selectpicker" data-live-search="true" name="id_contrato_ocasional">
                                <option value="">SELECCIONAR</option>
                                <?php foreach ($listarTodosContratosOcasionales as $ltco){ ?>
                                    <option value="<?php echo $ltco['id_contrato_ocasional']; ?>">
                                        <?php
                                            $emp = $empresa->listarPorId($ltco['id_empresa']);
                                            $cli = $cliente->listarClientePorId($ltco['id_cliente']);
                                            echo "No. interno ". $ltco['id_contrato_ocasional'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa']; 
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                    <!-- VEHIUCLO-->
                        <div class="col-3">
                            <label><b>VEHICULO</b></label>
                            <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo">
                                <option value="">SELECCIONAR</option>
                                <?php foreach ($listarTodosVehiculos as $ltv){ ?>
                                    <option value="<?php echo $ltv['id_vehiculo'] ?>">
                                        <?php echo $ltv['placa'] . ' - ' . $ltv['numero_movil']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                </div>

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

            <form action="exportarReporteFuecOcasionales.php" method="post">
                <div class="row mt-2 d-flex justify-content-center">
                    <div class="col-3">
                        <input type="hidden" name="id_usuario_emisor" value="<?php echo $id_usuario_emisor;?>"/>
	                    <input type="hidden" name="id_contrato" value="<?php echo $id_contrato_ocasional;?>"/>
                    	<input type="hidden" name="id_vehiculo" value="<?php echo $id_vehiculo;?>" />
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
                                        <th style="width: 10px;">ID</th>
                                        <th>VEHICULO</th>
                                        <th>CONTRATO OCASIONAL</th>
                                        <th>ORIGEN - DESTINO</th>
                    					<th>FECHA INICIAL</th>
                    					<th>FECHA FINAL</th>
                                        <th>FECHA CREACIÓN</th>
                                        <th>EMISOR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($filtrarFuecsOcasionales as $lffo){ ?>
                                        <tr>
                                            <td><?php echo $lffo['id_fuec']; ?></td>
                                            <td>
                                                <?php 
                                                    $listarVehiculosId = $vehiculo->listarPorId($lffo['id_vehiculo']);
                                                    
                                                    foreach ($listarVehiculosId as $lvi) {
                                                        echo $lvi['placa'] . ' - ' . $lvi['numero_movil'];
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $listarContratosOcasionalesId = $contratoOcasional->listarPorId($lffo['id_contrato_ocasional']);
                                                    foreach ($listarContratosOcasionalesId as $lci) {
                                                        $emp = $empresa->listarPorId($lci['id_empresa']);
                                                        $cli = $cliente->listarClientePorId($lci['id_cliente']);
                                                        echo "No. interno ". $lci['id_contrato_ocasional'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa']; 
                                                    }
                                                

                                                ?>
                                            </td>
                                            <td><?php echo 'DE ' . $lffo['origen'] . ' A ' . $lffo['destino']; ?></td>
                    					    <td><?php echo $lffo['fecha_inicial_fuec']; ?></td>
                    					    <td><?php echo $lffo['fecha_final_fuec']; ?></td>
                                            <td><?php echo date('Y-m-d g:i a', strtotime($lffo['fecha_creacion'])); ?></td>
                                            <td>
                                                <?php  
                                                    $listarUsuariosEmi = $usuario->listarUsuarioPorId($lffo['id_usuario']);
                                                    foreach ($listarUsuariosEmi as $luef) {
                                                        echo $luef['nombre'];
                                                    }
                                                ?>
                                            </td>
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