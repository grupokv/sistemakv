<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Contrato.php");

$cliente = new Cliente();
$empresa = new Empresa();
$contrato = new Contrato();
$conductor = new Conductor();
$vehiculo = new Vehiculo();

$hoy = date('Y-m-d');
$listarTodosContratos = $contrato->listarTodos();

/* ----- TOTAL GENERAL DE DOCUMENTOS POR CONDUCTORES ------ */                    
                   
$listarConductoresActivos = $conductor->listarConductoresActivos();
$totalDocs = (count($listarConductoresActivos) * 8);

            /* ----- DOCUMENTOS VENCIDOS ------ */                    
 
$listarDocsConductorLcVencidos = $conductor->listarDocsConductorLcVencidos($hoy);
$listarDocsConductorEMVencidos = $conductor->listarDocsConductorEMVencidos($hoy);

$totalVencidos = (count($listarDocsConductorLcVencidos) + count($listarDocsConductorEMVencidos));
/* ------------------------------------------------------------------- */
/* -------------- FIN FILTRO GENERAl DE CONDUCTORES ------------------ */
/* ------------------------------------------------------------------- */

/* ------------------------- °°°°°°°°° ------------------------------- */

/* ------------------------------------------------------------------- */
/* --------------------- FILTRO POR DOCUMENTO ------------------------ */
/* ------------------------------------------------------------------- */


$nombre_documento = '';
$nombre_fecha_documento = '';

if($_POST['nombre_documento'] == 1){
    $nombre_documento = 'fotocopia_documento';
    $totalVencidosFiltroPorDoc = 0;
} else if($_POST['nombre_documento'] == 2){
    $nombre_documento = 'fotocopia_licencia';
    $nombre_fecha_documento = 'fecha_vencimiento_licencia';
    
    /* ----- TOTAL DOCS VENCIDOS ------ */  
    
    $LcVencidosFiltroPorDoc = $conductor->listarDocsConductorLcVencidos($hoy);
    $totalVencidosFiltroPorDoc = (count($LcVencidosFiltroPorDoc));
    
    
}else if($_POST['nombre_documento'] == 3){
    $nombre_documento = 'certificados_laborales';
    $totalVencidosFiltroPorDoc = 0;
}else if($_POST['nombre_documento'] == 4){
    $nombre_documento = 'certificados_estudios';
    $totalVencidosFiltroPorDoc = 0;
}else if($_POST['nombre_documento'] == 5){
    $nombre_documento = 'certificados_cursos';
    $totalVencidosFiltroPorDoc = 0;
}else if($_POST['nombre_documento'] == 6){
    $nombre_documento = 'libreta_militar';
    $totalVencidosFiltroPorDoc = 0;
}else if($_POST['nombre_documento'] == 7){
    $nombre_documento = 'examen_medico';
    $nombre_fecha_documento = 'fecha_expedicion_examen_medico';

    
    /* ----- TOTAL DOCS VENCIDOS ------ */  
    
    $EMVencidosFiltroPorDoc = $conductor->listarDocsConductorEMVencidos($hoy);
    $totalVencidosFiltroPorDoc = (count($EMVencidosFiltroPorDoc));
    
}else if($_POST['nombre_documento'] == 8){
    $nombre_documento = 'planilla_ss';
    $totalVencidosFiltroPorDoc = 0;
}
                /* ----- DOCS VACIOS ------ */         
    
$listarDocVaciosfiltroPorDoc = $conductor->listarDocVaciosfiltroPorDoc($nombre_documento, $nombre_fecha_documento);
$totalVaciosFiltroPorDoc = count($listarDocVaciosfiltroPorDoc);

/* ------------------------------------------------------------------- */
/* -------------------- FIN FILTRO POR DOCUMENTO --------------------- */
/* ------------------------------------------------------------------- */

/* --------------------------- °°°°°°°°° ----------------------------- */

/* ------------------------------------------------------------------- */
/* ---------------------- FILTRO POR CONTRATO ------------------------ */
/* ------------------------------------------------------------------- */

$id_contrato = $_POST['contrato'];
$listarFiltroReporteConductoresContratos = $conductor->listarFiltroReporteConductoresContratos($id_contrato);

$vehiculos = array();
$conductores = array();

foreach ($listarFiltroReporteConductoresContratos as $lfrcc) {
    array_push($vehiculos, $lfrcc['id_vehiculo']);
}


for ($i=0; $i < count($vehiculos); $i++) {     
    $listarConductoresPorVehiculo = $vehiculo->ConductoresPorVehiculo($vehiculos[$i]);

    foreach ($listarConductoresPorVehiculo as $lcpv) {
        array_push($conductores, $lcpv['id_conductor']);
    }
}

$conductores = array_values(array_unique($conductores));

$TotalDocsvaciosFiltroPorContrato = 0;
$TotalDocsvencidosFiltroPorContrato = 0;
$totalDocumentosFiltroPorContrato = (count($conductores) * 8);
$totalConductoresFiltroPorContrato = count($conductores);

for ($i=0; $i < count($conductores); $i++) {  


    $listarDocsFDVaciosId = $conductor->listarDocsFDVaciosId($conductores[$i]);

    if (count($listarDocsFDVaciosId) > 0) {
      $TotalDocsvaciosFiltroPorContrato = $TotalDocsvaciosFiltroPorContrato + 1;
    }

    $listarDocsLCVaciosId = $conductor->listarDocsLCVaciosId($conductores[$i]);

    if (count($listarDocsLCVaciosId) != 0) {
      $TotalDocsvaciosFiltroPorContrato = $TotalDocsvaciosFiltroPorContrato + 1;
    }

    $listarDocsCLVaciosId = $conductor->listarDocsCLVaciosId($conductores[$i]);

    if (count($listarDocsCLVaciosId) != 0) {
      $TotalDocsvaciosFiltroPorContrato = $TotalDocsvaciosFiltroPorContrato + 1;
    }

    $listarDocsCEVaciosId = $conductor->listarDocsCEVaciosId($conductores[$i]);

    if (count($listarDocsCEVaciosId) != 0) {
      $TotalDocsvaciosFiltroPorContrato = $TotalDocsvaciosFiltroPorContrato + 1;
    }

    $listarDocsCCVaciosId = $conductor->listarDocsCCVaciosId($conductores[$i]);

    if (count($listarDocsCCVaciosId) != 0) {
      $TotalDocsvaciosFiltroPorContrato = $TotalDocsvaciosFiltroPorContrato + 1;
    }

    $listarDocsLMVaciosId = $conductor->listarDocsLMVaciosId($conductores[$i]);

    if (count($listarDocsLMVaciosId) != 0) {
      $TotalDocsvaciosFiltroPorContrato = $TotalDocsvaciosFiltroPorContrato + 1;
    }

    $listarDocsEMVaciosId = $conductor->listarDocsEMVaciosId($conductores[$i]);

    if (count($listarDocsEMVaciosId) != 0) {
      $TotalDocsvaciosFiltroPorContrato = $TotalDocsvaciosFiltroPorContrato + 1;
    }

    $listarDocsPSSVaciosId = $conductor->listarDocsPSSVaciosId($conductores[$i]);

    if (count($listarDocsPSSVaciosId) != 0) {
      $TotalDocsvaciosFiltroPorContrato = $TotalDocsvaciosFiltroPorContrato + 1;
    }

    $listarDocsConductorLcVencidosPorId = $conductor->listarDocsConductorLcVencidosPorId($conductores[$i], $hoy);
    //print_r($listarDocsConductorLcVencidosPorId);
    
    if (count($listarDocsConductorLcVencidosPorId) > 0) {
       $TotalDocsvencidosFiltroPorContrato = $TotalDocsvencidosFiltroPorContrato + 1;
    }
    
    $listarDocsConductorEMVencidosPorId = $conductor->listarDocsConductorEMVencidosPorId($conductores[$i], $hoy);
    //print_r($listarDocsConductorEMVencidosPorId);
    
    if (count($listarDocsConductorEMVencidosPorId) > 0) {
       $TotalDocsvencidosFiltroPorContrato = $TotalDocsvencidosFiltroPorContrato + 1;
    }
}



/* ------------------------------------------------------------------- */
/* -------------------- FIN FILTRO POR CONTRATO ---------------------- */
/* ------------------------------------------------------------------- */

/* --------------------------- °°°°°°°°° ----------------------------- */

/* ------------------------------------------------------------------- */
/* ----------------------- FILTRO POR EMPRESA ------------------------ */
/* ------------------------------------------------------------------- */


$id_empresa = $_POST['empresa'];

$filtro = "";
$conductoresEmpresa = array();
$vehiculosEmpresa = array();
$TotalDocsvaciosFiltroEmpresa = 0;
$TotalDocsvencidosFiltroEmpresa = 0;

if($id_empresa == 1){
    $filtro = "numero_movil >= 1 AND numero_movil <= 999";
}else if($id_empresa == 2){
    $filtro = "numero_movil >= 1000 AND numero_movil <= 1999";
}

$listarfiltroEmpresaConductores = $vehiculo->listarfiltroEmpresaConductores($filtro);

foreach ($listarfiltroEmpresaConductores as $lfec) {
   array_push($vehiculosEmpresa, $lfec['id_vehiculo']);
}

$vehiculosEmpresa = array_values(array_unique($vehiculosEmpresa));

for ($i=0; $i < count($vehiculosEmpresa); $i++) { 
    $listarCPE = $vehiculo->ConductoresPorVehiculo($vehiculosEmpresa[$i]);

    foreach ($listarCPE as $cpe) {
        array_push($conductoresEmpresa, $cpe['id_conductor']);
    }
}

$conductoresEmpresa = array_values(array_unique($conductoresEmpresa));


    /* -------- TOTAL VACIOS Y VENCIDOS ----------*/
    
for ($i=0; $i < count($conductoresEmpresa); $i++) {  

    $listarDocsFDVaciosIdFiltroEmpresa = $conductor->listarDocsFDVaciosId($conductoresEmpresa[$i]);

    if (count($listarDocsFDVaciosIdFiltroEmpresa) > 0) {
      $TotalDocsvaciosFiltroEmpresa = $TotalDocsvaciosFiltroEmpresa + 1;
    }

    $listarDocsLCVaciosIdFiltroEmpresa = $conductor->listarDocsLCVaciosId($conductoresEmpresa[$i]);

    if (count($listarDocsLCVaciosIdFiltroEmpresa) != 0) {
      $TotalDocsvaciosFiltroEmpresa = $TotalDocsvaciosFiltroEmpresa + 1;
    }

    $listarDocsCLVaciosIdFiltroEmpresa = $conductor->listarDocsCLVaciosId($conductoresEmpresa[$i]);

    if (count($listarDocsCLVaciosIdFiltroEmpresa) != 0) {
      $TotalDocsvaciosFiltroEmpresa = $TotalDocsvaciosFiltroEmpresa + 1;
    }

    $listarDocsCEVaciosIdFiltroEmpresa = $conductor->listarDocsCEVaciosId($conductoresEmpresa[$i]);

    if (count($listarDocsCEVaciosIdFiltroEmpresa) != 0) {
      $TotalDocsvaciosFiltroEmpresa = $TotalDocsvaciosFiltroEmpresa + 1;
    }

    $listarDocsCCVaciosIdFiltroEmpresa = $conductor->listarDocsCCVaciosId($conductoresEmpresa[$i]);

    if (count($listarDocsCCVaciosIdFiltroEmpresa) != 0) {
      $TotalDocsvaciosFiltroEmpresa = $TotalDocsvaciosFiltroEmpresa + 1;
    }

    $listarDocsLMVaciosIdFiltroEmpresa = $conductor->listarDocsLMVaciosId($conductoresEmpresa[$i]);

    if (count($listarDocsLMVaciosIdFiltroEmpresa) != 0) {
      $TotalDocsvaciosFiltroEmpresa = $TotalDocsvaciosFiltroEmpresa + 1;
    }

    $listarDocsEMVaciosIdFiltroEmpresa = $conductor->listarDocsEMVaciosId($conductoresEmpresa[$i]);

    if (count($listarDocsEMVaciosIdFiltroEmpresa) != 0) {
      $TotalDocsvaciosFiltroEmpresa = $TotalDocsvaciosFiltroEmpresa + 1;
    }

    $listarDocsPSSVaciosIdFiltroEmpresa = $conductor->listarDocsPSSVaciosId($conductoresEmpresa[$i]);

    if (count($listarDocsPSSVaciosIdFiltroEmpresa) != 0) {
      $TotalDocsvaciosFiltroEmpresa = $TotalDocsvaciosFiltroEmpresa + 1;
    }

    $listarDocsConductorLcVencidosPorIdFiltroEmpresa = $conductor->listarDocsConductorLcVencidosPorId($conductoresEmpresa[$i], $hoy);

    if (count($listarDocsConductorLcVencidosPorIdFiltroEmpresa) != 0) {
       $TotalDocsvencidosFiltroEmpresa = $TotalDocsvencidosFiltroEmpresa + 1;
    }
    
    $listarDocsConductorEMVencidosPorIdFiltroEmpresa = $conductor->listarDocsConductorEMVencidosPorId($conductoresEmpresa[$i], $hoy);
    
     if (count($listarDocsConductorEMVencidosPorIdFiltroEmpresa) != 0) {
       $TotalDocsvencidosFiltroEmpresa = $TotalDocsvencidosFiltroEmpresa + 1;
    }
    
}

    /* -------- TOTAL DOCUMENTOS ----------*/

$TotalDocsPorConductorFiltroEmpresa = (count($conductoresEmpresa) * 8);
$TotalConductoresFiltroEmpresa = count($conductoresEmpresa);

 ?>
 
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <title>SistemaKV | Reporte Conductores</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
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
            <li class="breadcrumb-item " aria-current="page"><a href="conductores.php">Conductores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte Conductores</li>
         </ol>
    </div>
     <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4" style="color: #fff; line-height: 52px;"><span class="fa fa-clipboard" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Reporte de Conductores</h2>
    	</div>
    </div>
    <hr style="background-color:#5e99b1;">
    
      <!-- FILTRO REPORTE -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 96%">
            <p>FILTRAR REPORTE</p>
        </div>

        <div class="col-sm-12 col-md-12 mt-3 formulario_reporte" style="height: auto; width: 96%; border-radius: 4px; background-color: #fafafa; ">
            
            <form method="POST" action="">
                
                <div class="row mt-2">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 formulario">
                        <label>Empresa</label>
                        <select class="form-control " name="empresa" id="empresa" onchange="validarFiltroReporteEmpresa(this.value);">
                            <option value="0">SELECCIONAR</option>
                            <option value="1">ORT</option>
                            <option value="2">LINEAS PREMIUM</option>
                        </select>
                    </div>
                
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 formulario">
                        <label>Contratos</label>
                        <select class="form-control " name="contrato" id="contrato" onchange="validarFiltroReporteContrato(this.value);">
                            <option value="0">SELECCIONAR</option>
                            <?php foreach ($listarTodosContratos as $ltc){ ?>
                                <option value="<?php echo $ltc['id_contrato']; ?>">
                                    <?php 
                                        $emp = $empresa->listarPorId($ltc['id_empresa']);
                                        $cli = $cliente->listarClientePorId($ltc['id_cliente']);

                                        echo "No. interno ".$ltc['id_contrato']." - CONTRATO N° " . $ltc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'];
                                    ?>
                                </option>
                            <?php } ?>
                            
                        </select>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 formulario">
                        <label>Documento</label>
                        <select class="form-control display" name="nombre_documento" id="nombre_documento" onchange="validarFiltroReporteNombreDocumento(this.value);">
                            <option value="0">SELECCIONAR</option>
                            <option value="1">DOCUMENTO DE IDENTIDAD</option>
                            <option value="2">LICENCIA DE CONDUCCIÓN</option>
                            <option value="3">CERTIFICADOS LABORALES</option>
                            <option value="4">CERTIFICADOS ESTUDIOS</option>
                            <option value="5">CERTIFICADOS CURSOS</option>
                            <option value="6">LIBRETA MILITAR</option>
                            <option value="7">EXÁMEN MÉDICO</option>
                            <option value="8">SEGURIDAD SOCIAL</option>
                        </select>
                    </div>
                    
                </div>
                

                <div class="row mt-2 d-flex justify-content-center">
                    <div class="col-sm-6 col-md-3">
                        <label>&nbsp;</label>
                        <button type="submit" name="consultar" class="btn btn-block" style="background-color: #1b2d3b; color: #fff;">Filtrar</button>
                    </div>
                </div>

            </form>
            
    	    <form action="reporteExportarExcelConductores.php" method="post" target="_blank">
        		<div class="row mt-2 d-flex justify-content-center">
                    <div class="col-3">
                	    <input type="hidden" name="valorEmpresa" id="valorEmpresa" value="<?php echo $_POST['empresa']; ?>" />
    	                <input type="hidden" name="valorContrato" id="valorContrato" value="<?php echo $_POST['contrato']; ?>" />
    	                <input type="hidden" name="ValorPorDocumento" id="ValorPorDocumento" value="<?php echo $_POST['nombre_documento']; ?>" />
    	                
                        <button type="submit" class="btn mr-4 btn-block" style="background-color: #4caf50; height: 40px; margin-top: 10px; color: #fff;">Excel <span class="fa fa-file-excel-o"></span></button>
        
        		     </div>
        		</div>
    	    </form>
        </div>

    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 linea_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; height: 3px; width: 96%;"></div>
        
    
    
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
                <th colspan="4" style="text-align:center">
                    TOTAL DE CONDUCTORES: 
                    <?php 
                        if(($_POST['empresa'] == 0) && ($_POST['contrato'] != 0) && ($_POST['nombre_documento'] == 0)){
                            echo $totalConductoresFiltroPorContrato;
                        }else if(($_POST['empresa'] != 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] == 0)){
                            echo $TotalConductoresFiltroEmpresa;
                        }else{
                            echo count($listarConductoresActivos);
                        } 
                         
                    ?>
                </th>
          </tr>
          <tr class="text-center">
              <th>TOTAL DE DOCUMENTOS</th>
              <th>DOCUMENTOS VACIOS</th>
              <th>DOCUMENTOS VENCIDOS</th>
              <th>PORCENTAJE CUMPLIMIENTO</th>
          </tr>
    		</thead>
    		<tbody>
          <tr class="text-center">
            <td>    
                <?php 
                    if(($_POST['empresa'] == 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] != 0)){
                        echo count($listarConductoresActivos);
                    }else if(($_POST['empresa'] == 0) && ($_POST['contrato'] != 0) && ($_POST['nombre_documento'] == 0)){
                        echo $totalDocumentosFiltroPorContrato;
                    }else if(($_POST['empresa'] != 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] == 0)){
                        echo $TotalDocsPorConductorFiltroEmpresa;
                    }else{
                        echo $totalDocs;
                    }
                    
                ?>
            </td>
            <td>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#vacios">
                    <?php 
                        if(($_POST['empresa'] == 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] != 0)){
                            echo $totalVaciosFiltroPorDoc;
                        }else if(($_POST['empresa'] == 0) && ($_POST['contrato'] != 0) && ($_POST['nombre_documento'] == 0)){
                            echo $TotalDocsvaciosFiltroPorContrato;
                        }else if(($_POST['empresa'] != 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] == 0)){
                            echo $TotalDocsvaciosFiltroEmpresa;
                        }else{
                            echo $totalVacios;
                        }
                    ?>
                </a>
            </td>
            <td>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#vencidos">
                    <?php  
                        if(($_POST['empresa'] == 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] != 0)){
                            echo $totalVencidosFiltroPorDoc;
                        }else if(($_POST['empresa'] == 0) && ($_POST['contrato'] != 0) && ($_POST['nombre_documento'] == 0)){
                            echo $TotalDocsvencidosFiltroPorContrato;
                        }else if(($_POST['empresa'] != 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] == 0)){
                            echo $TotalDocsvencidosFiltroEmpresa;
                        }else{
                            echo $totalVencidos;
                        }
                    ?>
                </a>
            </td>
            <td>
                <?php 
                    if(($_POST['empresa'] == 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] != 0)){
                        
                        $totalVV = ($totalVaciosFiltroPorDoc + $totalVencidosFiltroPorDoc);
                        
                        $porcentaje = ($totalVV * 100) / count($listarConductoresActivos); 
                        $totalCumplimientos = (100 - $porcentaje); 
                        echo number_format($totalCumplimientos, 2, ",", ".")." %";
                        
                    }else if(($_POST['empresa'] == 0) && ($_POST['contrato'] != 0) && ($_POST['nombre_documento'] == 0)){
                        
                        $totalVV = ($TotalDocsvaciosFiltroPorContrato + $TotalDocsvencidosFiltroPorContrato);
                        
                        $porcentaje = ($totalVV * 100) / $totalDocumentosFiltroPorContrato; 
                        $totalCumplimientos = (100 - $porcentaje); 
                        echo number_format($totalCumplimientos, 2, ",", ".")." %";
                        
                    }else if(($_POST['empresa'] != 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] == 0)){
                        
                        $totalVV = ($TotalDocsvaciosFiltroEmpresa + $TotalDocsvencidosFiltroEmpresa);
                        
                        $porcentaje = ($totalVV * 100) / $TotalDocsPorConductorFiltroEmpresa; 
                        $totalCumplimientos = (100 - $porcentaje); 
                        echo number_format($totalCumplimientos, 2, ",", ".")." %";
                        
                    }else{
                        $totalVV = ($totalVacios + $totalVencidos);
                        
                        $porcentaje = ($totalVV * 100) / $totalDocs; 
                        $totalCumplimientos = (100 - $porcentaje); 
                        echo number_format($totalCumplimientos, 2, ",", ".")." %";
                    }
                ?>
            </td>
          </tr> 
    		</tbody>
    	</table>

      <!-- Modal -->
              <div class="modal fade" id="vacios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    
                    <div class="modal-body">
                        
                        <h5 class="text-center"><strong> DOCUMENTOS VACIOS </strong></h5>
                        
                        <section class="table-responsive">
                          <table id="dataT2" class="table table-hover table-sm display" style="width:100%">
                            <thead>
                              <tr class="text-center">
                                <th>CONDUCTOR</th>
                                <th>DOCUMENTO</th>
                                <th>OPCIONES</th>
                              </tr>
                            </thead>
                            <tbody>
                                <!-- LISTAR FILTRO POR EMPRESA -->
                                <?php if(($_POST['empresa'] != 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] == 0)) { 
                                
                                    for ($i=0; $i < count($conductoresEmpresa); $i++) {  
                                    
                                        //Fotocopia Documento
                                        
                                        $listarDocsFDVaciosIdFiltroEmpresa = $conductor->listarDocsFDVaciosId($conductoresEmpresa[$i]); 
                                    
                                        foreach ($listarDocsFDVaciosIdFiltroEmpresa as $ldfdvife){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $ldfdvife['numero_documento_conductor'] ?></td>
                                                <td> Fotocopia del Documento</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldfdvife['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                            
                                        <?php } 
                                    
                                        $listarDocsLCVaciosIdFiltroEmpresa = $conductor->listarDocsLCVaciosId($conductoresEmpresa[$i]);
                                    
                                        //Licencia de Conduccion
                                            
                                        foreach ($listarDocsLCVaciosIdFiltroEmpresa as $ldlcvife){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $ldlcvife['numero_documento_conductor'] ?></td>
                                                <td> Licencia de Conducción</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldlcvife['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php } 
                                    
                                        //Certificados Laborales
                                        
                                        $listarDocsCLVaciosIdFiltroEmpresa = $conductor->listarDocsCLVaciosId($conductoresEmpresa[$i]);
                                    
                                        foreach ($listarDocsCLVaciosIdFiltroEmpresa as $ldpclvife){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $ldpclvife['numero_documento_conductor'] ?></td>
                                                <td> Certificados Laborales</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldpclvife['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php } 
                                    
                                        //Certificados de Estudios
                                        
                                        $listarDocsCEVaciosIdFiltroEmpresa = $conductor->listarDocsCEVaciosId($conductoresEmpresa[$i]);
                                    
                                        foreach ($listarDocsCEVaciosIdFiltroEmpresa as $ldcevife){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $ldcevife['numero_documento_conductor'] ?></td>
                                                <td> Certificados de Estudios</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldcevife['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php } 
                                    
                                        //Certificados de Cursos
                                        
                                        $listarDocsCCVaciosIdFiltroEmpresa = $conductor->listarDocsCCVaciosId($conductoresEmpresa[$i]);
                                    
                                        foreach ($listarDocsCCVaciosIdFiltroEmpresa as $ldccvife){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $ldccvife['numero_documento_conductor'] ?></td>
                                                <td> Certificados de Cursos</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldccvife['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php }
                                        
                                        //Libreta Militar
                                    
                                        $listarDocsLMVaciosIdFiltroEmpresa = $conductor->listarDocsLMVaciosId($conductoresEmpresa[$i]);
                                    
                                        foreach ($listarDocsLMVaciosId as $ldlmvi){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $ldlmvi['numero_documento_conductor'] ?></td>
                                                <td> Libreta Militar</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldlmvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php }
                                        
                                        //Examen Medico
                                    
                                        $listarDocsEMVaciosIdFiltroEmpresa = $conductor->listarDocsEMVaciosId($conductoresEmpresa[$i]);
                                    
                                        foreach ($listarDocsEMVaciosIdFiltroEmpresa as $ldemvife){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $ldemvife['numero_documento_conductor'] ?></td>
                                                <td> Examen Medico</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldemvife['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php } 
                                        
                                        //Planilla Seguridad Social
                                    
                                        $listarDocsPSSVaciosIdFiltroEmpresa = $conductor->listarDocsPSSVaciosId($conductoresEmpresa[$i]);
                                    
                                        foreach ($listarDocsPSSVaciosIdFiltroEmpresa as $ldpssvife){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $ldpssvife['numero_documento_conductor'] ?></td>
                                                <td> Planilla Seguridad Social</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldpssvife['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php } 
                                    
                                    } 
                                
                                ?>
                                
                                
                                <!-- LISTAR FILTRO POR CONTRATO -->
                                <?php }else if(($_POST['empresa'] == 0) && ($_POST['contrato'] != 0) && ($_POST['nombre_documento'] == 0)) { 
                                    
                                        for ($i=0; $i < count($conductores); $i++) {  
                                            
                                            //Fotocopia Documento
                                            
                                            $listarDocsFDVaciosId = $conductor->listarDocsFDVaciosId($conductores[$i]);
                                        
                                            foreach ($listarDocsFDVaciosId as $ldfdvi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldfdvi['numero_documento_conductor'] ?></td>
                                                    <td> Fotocopia del Documento</td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldfdvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                                
                                            <?php } 
                                        
                                            //Licencia de Conduccion
                                            
                                            $listarDocsLCVaciosId = $conductor->listarDocsLCVaciosId($conductores[$i]); 
                                            
                                            foreach ($listarDocsLCVaciosId as $ldlcvi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldlcvi['numero_documento_conductor'] ?></td>
                                                    <td> Licencia de Conducción</td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldlcvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                            <?php } 
                                        
                                            //Certificados Laborales
                                            
                                            $listarDocsCLVaciosId = $conductor->listarDocsCLVaciosId($conductores[$i]);
                                        
                                        
                                            foreach ($listarDocsCLVaciosId as $ldpclvi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldpclvi['numero_documento_conductor'] ?></td>
                                                    <td> Certificados Laborales</td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldpclvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                            <?php } 
                                        
                                            //Certificados de Estudios
                                            
                                            $listarDocsCEVaciosId = $conductor->listarDocsCEVaciosId($conductores[$i]);
                                        
                                            
                                            foreach ($listarDocsCEVaciosId as $ldcevi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldcevi['numero_documento_conductor'] ?></td>
                                                    <td> Certificados de Estudios</td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldcevi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                            <?php } 
                                        
                                            //Certificados de Cursos
                                        
                                            $listarDocsCCVaciosId = $conductor->listarDocsCCVaciosId($conductores[$i]);
                                        
                                            
                                            foreach ($listarDocsCCVaciosId as $ldccvi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldccvi['numero_documento_conductor'] ?></td>
                                                    <td> Certificados de Cursos</td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldccvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                            <?php }
                                        
                                            //Libreta Militar
                                        
                                            $listarDocsLMVaciosId = $conductor->listarDocsLMVaciosId($conductores[$i]);
                                        
                                            
                                            foreach ($listarDocsLMVaciosId as $ldlmvi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldlmvi['numero_documento_conductor'] ?></td>
                                                    <td> Libreta Militar</td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldlmvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                            <?php } 
                                        
                                            //Examen Medico
                                        
                                            $listarDocsEMVaciosId = $conductor->listarDocsEMVaciosId($conductores[$i]);
                                        
                                            
                                            foreach ($listarDocsEMVaciosId as $ldemvi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldemvi['numero_documento_conductor'] ?></td>
                                                    <td> Examen Medico</td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldemvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                            <?php } 
                                        
                                            //Planilla Seguridad Social
                                        
                                            $listarDocsPSSVaciosId = $conductor->listarDocsPSSVaciosId($conductores[$i]);
                                        
                                             
                                            foreach ($listarDocsPSSVaciosId as $ldpssvi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldpssvi['numero_documento_conductor'] ?></td>
                                                    <td> Planilla Seguridad Social</td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldpssvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                            <?php } 
                                        }
                                ?>

                                  
                                <!-- LISTAR FILTRO POR DOCUMENTO -->
                                <?php }else if(($_POST['empresa'] == 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] != 0)) { ?>
                                
                                    <?php foreach($listarDocVaciosfiltroPorDoc As $ldvfpd) { ?>
                                        <tr class = "text-center">
                                            <td><?php echo $ldvfpd['numero_documento_conductor'] ?></td>
                                            <td><?php echo $nombre_documento ?></td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldvfpd['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } ?>
                                
                                <!-- LISTAR FILTRO GENERAL -->
                                <?php }else { ?>
                                
                                    <?php foreach ($listarDocsFDVacios as $ldfdv){ ?>
                                        <tr>
                                            <td><?php echo $ldfdv['numero_documento_conductor'] ?></td>
                                            <td> Fotocopia del Documento</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldfdv['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach ($listarDocsLCVacios as $ldlcv){ ?>
                                        <tr>
                                            <td><?php echo $ldlcv['numero_documento_conductor'] ?></td>
                                            <td> Licencia de Conducción</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldlcv['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach ($listarDocsCLVacios  as $ldclv){ ?>
                                        <tr>
                                            <td><?php echo $ldclv['numero_documento_conductor'] ?></td>
                                            <td> Licencia de Conducción</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldclv['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach ($listarDocsCEVacios  as $ldcev){ ?>
                                        <tr>
                                            <td><?php echo $ldcev['numero_documento_conductor'] ?></td>
                                            <td> Licencia de Conducción</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldcev['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach ($listarDocsCCVacios  as $ldccv){ ?>
                                        <tr>
                                            <td><?php echo $ldccv['numero_documento_conductor'] ?></td>
                                            <td> Licencia de Conducción</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldccv['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach ($listarDocsLMVacios  as $ldlmv){ ?>
                                        <tr>
                                            <td><?php echo $ldlmv['numero_documento_conductor'] ?></td>
                                            <td> Licencia de Conducción</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldlmv['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach ($listarDocsEMVacios as $ldemv){ ?>
                                        <tr>
                                            <td><?php echo $ldemv['numero_documento_conductor'] ?></td>
                                            <td> Examen Medico</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldemv['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach ($listarDocsPSSVacios as $ldpssv){ ?>
                                        <tr>
                                            <td><?php echo $ldpssv['numero_documento_conductor'] ?></td>
                                            <td> Planilla de Seguridad Social</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldpssv['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php }
                                    
                                } 
                                
                                ?>
                            </tbody>
                          </table>
                      </section>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>

       <!-- Modal -->
              <div class="modal fade" id="vencidos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    
                    <div class="modal-body">
                        <h5 class="text-center"><strong> DOCUMENTOS VENCIDOS </strong></h5>
                        
                        <section class="table-responsive">
                            <table id="dataT3" class="table table-hover table-sm display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>CONDUCTOR</th>
                                        <th>DOCUMENTO</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                            <tbody>
                                
                                <!-- LISTAR FILTRO POR EMPRESA -->
                                
                                <?php if(($_POST['empresa'] != 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] == 0)) { 
                                
                                    for ($i=0; $i < count($conductoresEmpresa); $i++) {  
                                        
                                        //Licencia de Conducción 
                                        
                                        $listarDocsConductorLcVencidosPorIdFiltroEmpresa = $conductor->listarDocsConductorLcVencidosPorId($conductoresEmpresa[$i], $hoy);
                                    
                                        foreach ($listarDocsConductorLcVencidosPorIdFiltroEmpresa as $llcvfe){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $llcvfe['numero_documento_conductor'] ?></td>
                                                <td> Licencia de Conducción</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $llcvfe['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                            
                                        <?php } 
                                    
                                        $listarDocsConductorEMVencidosPorIdFiltroEmpresa = $conductor->listarDocsConductorEMVencidosPorId($conductoresEmpresa[$i], $hoy);
                                    
                                        //Examen Medico
                                            
                                        foreach ($listarDocsConductorEMVencidosPorIdFiltroEmpresa as $lemvfe){ ?>
                                            <tr class="text-center">
                                                <td><?php echo $lemvfe['numero_documento_conductor'] ?></td>
                                                <td> Exámen Médico </td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $lemvfe['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php } 
                                    
                                    } 
                                
                                ?>
                                
                                
                                <!-- LISTAR FILTRO POR CONTRATO -->
                                <?php } else if(($_POST['empresa'] == 0) && ($_POST['contrato'] != 0) && ($_POST['nombre_documento'] == 0)) { 
                                    
                                        for ($i=0; $i < count($conductores); $i++) {  
                                        
                                            
                                            //Licencia de Conducción
                                            
                                            $listarDocsConductorLcVencidosPorId = $conductor->listarDocsConductorLcVencidosPorId($conductores[$i], $hoy);
                                        
                                            foreach ($listarDocsConductorLcVencidosPorId as $ldclcvi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldclcvi['numero_documento_conductor'] ?></td>
                                                    <td> Licencia de Conducción</td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldclcvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                                
                                            <?php } 
                                        
                                            //Examen Medico
                                            
                                            $listarDocsConductorEMVencidosPorId = $conductor->listarDocsConductorEMVencidosPorId($conductores[$i], $hoy); 
                                            
                                            foreach ($listarDocsConductorEMVencidosPorId as $ldemcvi){ ?>
                                                <tr class="text-center">
                                                    <td><?php echo $ldemcvi['numero_documento_conductor'] ?></td>
                                                    <td> Exámen Médico </td>
                                                    <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldemcvi['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                                </tr>
                                            <?php } 
                                        
                                        }
                                ?>

                                  
                                <!-- LISTAR FILTRO POR DOCUMENTO -->
                                
                                <?php }else if(($_POST['empresa'] == 0) && ($_POST['contrato'] == 0) && ($_POST['nombre_documento'] != 0)) { 
                                    
                                    if($_POST['nombre_documento'] == 2){ 
                                        foreach($LcVencidosFiltroPorDoc As $lcvfd) { ?>
                                            <tr class = "text-center">
                                                <td><?php echo $lcvfd['numero_documento_conductor'] ?></td>
                                                <td> Licencia de Conducción</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $lcvfd['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php } 
                                        
                                    }else if($_POST['nombre_documento'] == 7){ 
                                        
                                        foreach($EMVencidosFiltroPorDoc As $emvfd) { ?>
                                            <tr class = "text-center">
                                                <td><?php echo $emvfd['numero_documento_conductor'] ?></td>
                                                <td> Examen Medico</td>
                                                <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $emvfd['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                            </tr>
                                        <?php } 
                                    
                                    } ?>
                                    
                                
                                <!-- LISTAR FILTRO GENERAL -->
                                <?php }else { 
                                    
                                    foreach ($listarDocsConductorLcVencidos as $ldlcv){ ?>
                                        <tr>
                                            <td><?php echo $ldlcv['numero_documento_conductor'] ?></td>
                                            <td> Licencia de Conducción</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldlcv['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } 
                                    
                                    foreach ($listarDocsConductorEMVencidos as $ldemv){ ?>
                                        <tr>
                                            <td><?php echo $ldemv['numero_documento_conductor'] ?></td>
                                            <td> Examen Medico</td>
                                            <td> <a class="btn btn-outline-success" href="actualizarConductores.php?id_conductor=<?php echo $ldemv['id_conductor'] ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-eye"></span></a> </td>
                                        </tr>
                                    <?php } 
                                }?>
                            </tbody>
                          </table>
                      </section>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>
    </div>
    
    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?>
  
  <script type="text/javascript">
  
  
    function validarFiltroReporteEmpresa(empresa){

        if(empresa != 0){
            $('#nombre_documento').attr('disabled', 'disabled');
            $('#contrato').attr('disabled', 'disabled');
        }else{
            $('#nombre_documento').attr('disabled', false);
            $('#contrato').attr('disabled', false);
        }
    }
    
    function validarFiltroReporteContrato(contrato){

        if(contrato != 0){
            $('#nombre_documento').attr('disabled', 'disabled');
            $('#empresa').attr('disabled', 'disabled');
        }else{
            $('#nombre_documento').attr('disabled', false);
            $('#empresa').attr('disabled', false);
        }
    }
    
    function validarFiltroReporteNombreDocumento(documento){

        if(documento != 0){
            $('#empresa').attr('disabled', 'disabled');
            $('#contrato').attr('disabled', 'disabled');
        }else{
            $('#empresa').attr('disabled', false);
            $('#contrato').attr('disabled', false);
        }
    }
      
      

  </script>
  

  
</body>
</html>
