<?php 
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte_Conductores.xls');

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

$id_empresa = $_POST['valorEmpresa'];
$id_contrato = $_POST['valorContrato'];
$id_nombre_documento = $_POST['ValorPorDocumento'];

$hoy = date('Y-m-d');
$listarTodosContratos = $contrato->listarTodos();
                                                                
$listarDocsFDVacios = $conductor->listarDocsFDVacios();
$listarDocsLCVacios = $conductor->listarDocsLCVacios();
$listarDocsCLVacios = $conductor->listarDocsCLVacios();
$listarDocsCEVacios = $conductor->listarDocsCEVacios();
$listarDocsCCVacios = $conductor->listarDocsCCVacios();
$listarDocsLMVacios = $conductor->listarDocsLMVacios();
$listarDocsPSSVacios = $conductor->listarDocsPSSVacios();
//$listarDocsEMVacios = $conductor->listarDocsEMVacios();
 
$listarDocsConductorLcVencidos = $conductor->listarDocsConductorLcVencidos($hoy);
$listarDocsConductorEMVencidos = $conductor->listarDocsConductorEMVencidos($hoy);

$nombre_documento = '';
$nombre_fecha_documento = '';
    
if($id_nombre_documento == 1){
    $nombre_documento = 'fotocopia_documento';
    
}else if($id_nombre_documento == 2){
    $nombre_documento = 'fotocopia_licencia';
    $nombre_fecha_documento = 'fecha_vencimiento_licencia';
    
      
    $LcVencidosFiltroPorDoc = $conductor->listarDocsConductorLcVencidos($hoy);
    
}else if($id_nombre_documento == 3){
    $nombre_documento = 'certificados_laborales';
}else if($id_nombre_documento == 4){
    $nombre_documento = 'certificados_estudios';
}else if($id_nombre_documento == 5){
    $nombre_documento = 'certificados_cursos';
}else if($id_nombre_documento == 6){
    $nombre_documento = 'libreta_militar';
}else if($id_nombre_documento == 7){
    $nombre_documento = 'examen_medico';
    $nombre_fecha_documento = 'fecha_expedicion_examen_medico';

    
    $EMVencidosFiltroPorDoc = $conductor->listarDocsConductorEMVencidos($hoy);
    
}else if($id_nombre_documento == 8){
    $nombre_documento = 'planilla_ss';
}
    
    
$listarDocVaciosfiltroPorDoc = $conductor->listarDocVaciosfiltroPorDoc($nombre_documento, $nombre_fecha_documento);

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


for ($i=0; $i < count($conductores); $i++) {  

    $listarDocsFDVaciosId = $conductor->listarDocsFDVaciosId($conductores[$i]);
    $listarDocsLCVaciosId = $conductor->listarDocsLCVaciosId($conductores[$i]);
    $listarDocsCLVaciosId = $conductor->listarDocsCLVaciosId($conductores[$i]);
    $listarDocsCEVaciosId = $conductor->listarDocsCEVaciosId($conductores[$i]);
    $listarDocsCCVaciosId = $conductor->listarDocsCCVaciosId($conductores[$i]);
    $listarDocsLMVaciosId = $conductor->listarDocsLMVaciosId($conductores[$i]);
    $listarDocsEMVaciosId = $conductor->listarDocsEMVaciosId($conductores[$i]);
    $listarDocsPSSVaciosId = $conductor->listarDocsPSSVaciosId($conductores[$i]);

    
    $listarDocsConductorLcVencidosPorId = $conductor->listarDocsConductorLcVencidosPorId($conductores[$i], $hoy);
    //$listarDocsConductorEMVencidosPorId = $conductor->listarDocsConductorEMVencidosPorId($conductores[$i], $hoy);
    
}

$filtro = "";
$conductoresEmpresa = array();
$vehiculosEmpresa = array();

if($id_empresa == 1){
    $filtro = "numero_movil >= 1 AND numero_movil <= 999";
}else if($id_empresa == 2){
    $filtro = "numero_movil >= 1000 AND numero_movil <= 1999";
} else {
    $filtro = "numero_movil >= 0";
}

//$listarfiltroEmpresaConductores = $vehiculo->listarfiltroEmpresaConductores($filtro);

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

for ($i=0; $i < count($conductoresEmpresa); $i++) {  

    
    $listarDocsFDVaciosIdFiltroEmpresa = $conductor->listarDocsFDVaciosId($conductoresEmpresa[$i]);
    $listarDocsLCVaciosIdFiltroEmpresa = $conductor->listarDocsLCVaciosId($conductoresEmpresa[$i]);
    $listarDocsCLVaciosIdFiltroEmpresa = $conductor->listarDocsCLVaciosId($conductoresEmpresa[$i]);
    $listarDocsCEVaciosIdFiltroEmpresa = $conductor->listarDocsCEVaciosId($conductoresEmpresa[$i]);
    $listarDocsCCVaciosIdFiltroEmpresa = $conductor->listarDocsCCVaciosId($conductoresEmpresa[$i]);
    $listarDocsLMVaciosIdFiltroEmpresa = $conductor->listarDocsLMVaciosId($conductoresEmpresa[$i]);
    $listarDocsEMVaciosIdFiltroEmpresa = $conductor->listarDocsEMVaciosId($conductoresEmpresa[$i]);
    $listarDocsPSSVaciosIdFiltroEmpresa = $conductor->listarDocsPSSVaciosId($conductoresEmpresa[$i]);

    
    $listarDocsConductorLcVencidosPorIdFiltroEmpresa = $conductor->listarDocsConductorLcVencidosPorId($conductoresEmpresa[$i], $hoy);
    $listarDocsConductorEMVencidosPorIdFiltroEmpresa = $conductor->listarDocsConductorEMVencidosPorId($conductoresEmpresa[$i], $hoy);
    
}

?>

<table id="tabla" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>NOMBRE DOCUMENTO</th>
            <th>ESTADO</th>
            <th>ID</th>
            <th>NOMBRE CONDUCTOR</th>
            <th>NUMERO DOCUMENTO</th>
            <th>DIRECCIÓN</th>
            <th>TELEFONO 1</th>
            <th>TELEFONO 2</th>
            <th>TELEFONO 3</th>
        </tr>
    </thead>
    <tbody>
        <?php if(($id_empresa == 0) && ($id_contrato == 0) && ($id_nombre_documento != 0)){ ?>
            <?php foreach($listarDocVaciosfiltroPorDoc As $ldvfpd) { ?>
                <tr class = "text-center">
                    <th><?php echo utf8_decode(strtr(strtoupper($nombre_documento), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));?></th>
                    <th>VACIO</th>
                    <th><?php echo $ldvfpd['id_conductor']; ?></th>
                    <th><?php echo $ldvfpd['nombre_conductor']; ?></th>
                    <th><?php echo $ldvfpd['numero_documento_conductor']; ?></th>
                    <th><?php echo $ldvfpd['direccion']; ?></th>
                    <th><?php echo $ldvfpd['telefono1']; ?></th>
                    <th><?php echo $ldvfpd['telefono2']; ?></th>
                    <th><?php echo $ldvfpd['telefono3']; ?></th>
                </tr>
            <?php } ?>
            
            <?php if($id_nombre_documento == 2){ 
                foreach($LcVencidosFiltroPorDoc As $lcvfd) { ?>
                    <tr class = "text-center">
                        <th><?php echo utf8_decode("LICENCIA DE CONDUCCIÓN");?></th>
                        <th>VENCIDO</th>
                        <th><?php echo $lcvfd['id_conductor']; ?></th>
                        <th><?php echo $lcvfd['nombre_conductor']; ?></th>
                        <th><?php echo $lcvfd['numero_documento_conductor']; ?></th>
                        <th><?php echo $lcvfd['direccion']; ?></th>
                        <th><?php echo $lcvfd['telefono1']; ?></th>
                        <th><?php echo $lcvfd['telefono2']; ?></th>
                        <th><?php echo $lcvfd['telefono3']; ?></th>
                    </tr>
                <?php } 
                
            }else if($id_nombre_documento == 7){ 
                
                foreach($EMVencidosFiltroPorDoc As $emvfd) { ?>
                    <tr class = "text-center">
                        <th><?php echo utf8_decode("EXÁMEN MÉDICO");?></th>
                        <th>VENCIDO</th>
                        <th><?php echo $emvfd['id_conductor']; ?></th>
                        <th><?php echo $emvfd['nombre_conductor']; ?></th>
                        <th><?php echo $emvfd['numero_documento_conductor']; ?></th>
                        <th><?php echo $emvfd['direccion']; ?></th>
                        <th><?php echo $emvfd['telefono1']; ?></th>
                        <th><?php echo $emvfd['telefono2']; ?></th>
                        <th><?php echo $emvfd['telefono3']; ?></th>
                    </tr>
                <?php } 
            
            } ?>
        <?php } else { 
            if(($id_empresa != 0) && ($id_contrato == 0) && ($id_nombre_documento == 0)){ 
                
                for ($i=0; $i < count($conductoresEmpresa); $i++) {  
                    
                    //Fotocopia Documento
                                            
                    $listarDocsFDVaciosIdFiltroEmpresa = $conductor->listarDocsFDVaciosId($conductoresEmpresa[$i]); 
                
                    foreach ($listarDocsFDVaciosIdFiltroEmpresa as $ldfdvife){ ?>
                        <tr class="text-center">
                            <th>FOTOCOPIA DEL DOCUMENTO</th>
                            <th>VACIO</th>
                            <th><?php echo $ldfdvife['id_conductor']; ?></th>
                            <th><?php echo $ldfdvife['nombre_conductor']; ?></th>
                            <th><?php echo $ldfdvife['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldfdvife['direccion']; ?></th>
                            <th><?php echo $ldfdvife['telefono1']; ?></th>
                            <th><?php echo $ldfdvife['telefono2']; ?></th>
                            <th><?php echo $ldfdvife['telefono3']; ?></th>
                        </tr>
                        
                    <?php } 
                    
                    
                    $listarDocsLCVaciosIdFiltroEmpresa = $conductor->listarDocsLCVaciosId($conductoresEmpresa[$i]);
            
                    //Licencia de Conduccion
                        
                    foreach ($listarDocsLCVaciosIdFiltroEmpresa as $ldlcvife){ ?>
                        <tr class="text-center">
                            <th>LICENCIA DE CONDUCCIÓN</th></th>
                            <th>VACIO</th>
                            <th><?php echo $ldlcvife['id_conductor']; ?></th>
                            <th><?php echo $ldlcvife['nombre_conductor']; ?></th>
                            <th><?php echo $ldlcvife['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldlcvife['direccion']; ?></th>
                            <th><?php echo $ldlcvife['telefono1']; ?></th>
                            <th><?php echo $ldlcvife['telefono2']; ?></th>
                            <th><?php echo $ldlcvife['telefono3']; ?></th>
                        </tr>
                    <?php } 
                    
                    //Certificados Laborales
                                        
                    $listarDocsCLVaciosIdFiltroEmpresa = $conductor->listarDocsCLVaciosId($conductoresEmpresa[$i]);
                
                    foreach ($listarDocsCLVaciosIdFiltroEmpresa as $ldpclvife){ ?>
                        <tr class="text-center">
                            <th>CERTIFICADOS LABORALES</th></th>
                            <th>VACIO</th>
                            <th><?php echo $ldpclvife['id_conductor']; ?></th>
                            <th><?php echo $ldpclvife['nombre_conductor']; ?></th>
                            <th><?php echo $ldpclvife['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldpclvife['direccion']; ?></th>
                            <th><?php echo $ldpclvife['telefono1']; ?></th>
                            <th><?php echo $ldpclvife['telefono2']; ?></th>
                            <th><?php echo $ldpclvife['telefono3']; ?></th>
                        </tr>
                    <?php } 
                
                    //Certificados de Estudios
                    
                    $listarDocsCEVaciosIdFiltroEmpresa = $conductor->listarDocsCEVaciosId($conductoresEmpresa[$i]);
                
                    foreach ($listarDocsCEVaciosIdFiltroEmpresa as $ldcevife){ ?>
                        <tr class="text-center">
                            <th>CERTIFICADOS DE ESTUDIOS</th></th>
                            <th>VACIO</th>
                            <th><?php echo $ldcevife['id_conductor']; ?></th>
                            <th><?php echo $ldcevife['nombre_conductor']; ?></th>
                            <th><?php echo $ldcevife['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldcevife['direccion']; ?></th>
                            <th><?php echo $ldcevife['telefono1']; ?></th>
                            <th><?php echo $ldcevife['telefono2']; ?></th>
                            <th><?php echo $ldcevife['telefono3']; ?></th>
                        </tr>
                    <?php } 
                    
                    //Certificados de Cursos
                                        
                    $listarDocsCCVaciosIdFiltroEmpresa = $conductor->listarDocsCCVaciosId($conductoresEmpresa[$i]);
                
                    foreach ($listarDocsCCVaciosIdFiltroEmpresa as $ldccvife){ ?>
                        <tr class="text-center">
                            <th>CERTIFICADOS DE CURSOS</th></th>
                            <th>VACIO</th>
                            <th><?php echo $ldccvife['id_conductor']; ?></th>
                            <th><?php echo $ldccvife['nombre_conductor']; ?></th>
                            <th><?php echo $ldccvife['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldccvife['direccion']; ?></th>
                            <th><?php echo $ldccvife['telefono1']; ?></th>
                            <th><?php echo $ldccvife['telefono2']; ?></th>
                            <th><?php echo $ldccvife['telefono3']; ?></th>
                        </tr>
                    <?php }
                    
                    //Libreta Militar
                
                    $listarDocsLMVaciosIdFiltroEmpresa = $conductor->listarDocsLMVaciosId($conductoresEmpresa[$i]);
                
                    foreach ($listarDocsLMVaciosId as $ldlmvi){ ?>
                        <tr class="text-center">
                            <th>LIBRETA MILITAR</th></th>
                            <th>VACIO</th>
                            <th><?php echo $ldlmvi['id_conductor']; ?></th>
                            <th><?php echo $ldlmvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldlmvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldlmvi['direccion']; ?></th>
                            <th><?php echo $ldlmvi['telefono1']; ?></th>
                            <th><?php echo $ldlmvi['telefono2']; ?></th>
                            <th><?php echo $ldlmvi['telefono3']; ?></th>
                        </tr>
                    <?php }
                    
                    //Examen Medico
                
                    $listarDocsEMVaciosIdFiltroEmpresa = $conductor->listarDocsEMVaciosId($conductoresEmpresa[$i]);
                
                    foreach ($listarDocsEMVaciosIdFiltroEmpresa as $ldemvife){ ?>
                        <tr class="text-center">
                            <th><?php echo utf8_decode("EXÁMEN MÉDICO"); ?></th>
                            <th>VACIO</th>
                            <th><?php echo $ldemvife['id_conductor']; ?></th>
                            <th><?php echo $ldemvife['nombre_conductor']; ?></th>
                            <th><?php echo $ldemvife['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldemvife['direccion']; ?></th>
                            <th><?php echo $ldemvife['telefono1']; ?></th>
                            <th><?php echo $ldemvife['telefono2']; ?></th>
                            <th><?php echo $ldemvife['telefono3']; ?></th>
                        </tr>
                    <?php } 
                    
                    //Planilla Seguridad Social
                
                    $listarDocsPSSVaciosIdFiltroEmpresa = $conductor->listarDocsPSSVaciosId($conductoresEmpresa[$i]);
                
                    foreach ($listarDocsPSSVaciosIdFiltroEmpresa as $ldpssvife){ ?>
                        <tr class="text-center">
                            <th>PLANILLA SEGURIDAD SOCIAL</th></th>
                            <th>VACIO</th>
                            <th><?php echo $ldpssvife['id_conductor']; ?></th>
                            <th><?php echo $ldpssvife['nombre_conductor']; ?></th>
                            <th><?php echo $ldpssvife['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldpssvife['direccion']; ?></th>
                            <th><?php echo $ldpssvife['telefono1']; ?></th>
                            <th><?php echo $ldpssvife['telefono2']; ?></th>
                            <th><?php echo $ldpssvife['telefono3']; ?></th>
                        </tr>
                    <?php }
                    
                    //Licencia de Conducción 
                                        
                    $listarDocsConductorLcVencidosPorIdFiltroEmpresa = $conductor->listarDocsConductorLcVencidosPorId($conductoresEmpresa[$i], $hoy);
                
                    foreach ($listarDocsConductorLcVencidosPorIdFiltroEmpresa as $llcvfe){ ?>
                        <tr class="text-center">
                            <th>LICENCIA DE CONDUCCIÓN</th></th>
                            <th>VENCIDO</th>
                            <th><?php echo $llcvfe['id_conductor']; ?></th>
                            <th><?php echo $llcvfe['nombre_conductor']; ?></th>
                            <th><?php echo $llcvfe['numero_documento_conductor']; ?></th>
                            <th><?php echo $llcvfe['direccion']; ?></th>
                            <th><?php echo $llcvfe['telefono1']; ?></th>
                            <th><?php echo $llcvfe['telefono2']; ?></th>
                            <th><?php echo $llcvfe['telefono3']; ?></th>
                        </tr>
                        
                    <?php } 
                
                    $listarDocsConductorEMVencidosPorIdFiltroEmpresa = $conductor->listarDocsConductorEMVencidosPorId($conductoresEmpresa[$i], $hoy);
                
                    //Examen Medico
                        
                    foreach ($listarDocsConductorEMVencidosPorIdFiltroEmpresa as $lemvfe){ ?>
                        <tr class="text-center">
                            <th>EXÁMEN MÉDICO</th></th>
                            <th>VENCIDO</th>
                            <th><?php echo $lemvfe['id_conductor']; ?></th>
                            <th><?php echo $lemvfe['nombre_conductor']; ?></th>
                            <th><?php echo $lemvfe['numero_documento_conductor']; ?></th>
                            <th><?php echo $lemvfe['direccion']; ?></th>
                            <th><?php echo $lemvfe['telefono1']; ?></th>
                            <th><?php echo $lemvfe['telefono2']; ?></th>
                            <th><?php echo $lemvfe['telefono3']; ?></th>
                        </tr>
                    <?php } 
                                    
                }
            
            } else if(($id_empresa == 0) && ($id_contrato != 0) && ($id_nombre_documento == 0)){ 
                for ($i=0; $i < count($conductores); $i++) {  
                    //Fotocopia Documento
                                            
                    $listarDocsFDVaciosId = $conductor->listarDocsFDVaciosId($conductores[$i]);
                
                    foreach ($listarDocsFDVaciosId as $ldfdvi){ ?>
                        <tr class="text-center">
                            <th>FOTOCOPIA DEL DOCUMENTO</th>
                            <th>VACIO</th>
                            <th><?php echo $ldfdvi['id_conductor']; ?></th>
                            <th><?php echo $ldfdvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldfdvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldfdvi['direccion']; ?></th>
                            <th><?php echo $ldfdvi['telefono1']; ?></th>
                            <th><?php echo $ldfdvi['telefono2']; ?></th>
                            <th><?php echo $ldfdvi['telefono3']; ?></th>
                        </tr>
                        
                    <?php } 
                
                    //Licencia de Conduccion
                    
                    $listarDocsLCVaciosId = $conductor->listarDocsLCVaciosId($conductores[$i]); 
                    
                    foreach ($listarDocsLCVaciosId as $ldlcvi){ ?>
                        <tr class="text-center">
                            <th>LICENCIA DE CONDUCCIÓN</th>
                            <th>VACIO</th>
                            <th><?php echo $ldlcvi['id_conductor']; ?></th>
                            <th><?php echo $ldlcvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldlcvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldlcvi['direccion']; ?></th>
                            <th><?php echo $ldlcvi['telefono1']; ?></th>
                            <th><?php echo $ldlcvi['telefono2']; ?></th>
                            <th><?php echo $ldlcvi['telefono3']; ?></th>
                        </tr>
                    <?php } 
                
                    //Certificados Laborales
                    
                    $listarDocsCLVaciosId = $conductor->listarDocsCLVaciosId($conductores[$i]);
                
                
                    foreach ($listarDocsCLVaciosId as $ldpclvi){ ?>
                        <tr class="text-center">
                            <th>CERTIFICADOS LABORALES</th>
                            <th>VACIO</th>
                            <th><?php echo $ldpclvi['id_conductor']; ?></th>
                            <th><?php echo $ldpclvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldpclvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldpclvi['direccion']; ?></th>
                            <th><?php echo $ldpclvi['telefono1']; ?></th>
                            <th><?php echo $ldpclvi['telefono2']; ?></th>
                            <th><?php echo $ldpclvi['telefono3']; ?></th>
                        </tr>
                    <?php } 
                
                    //Certificados de Estudios
                    
                    $listarDocsCEVaciosId = $conductor->listarDocsCEVaciosId($conductores[$i]);
                
                    
                    foreach ($listarDocsCEVaciosId as $ldcevi){ ?>
                        <tr class="text-center">
                            <th>CERTIFICADOS DE ESTUDIOS</th>
                            <th>VACIO</th>
                            <th><?php echo $ldcevi['id_conductor']; ?></th>
                            <th><?php echo $ldcevi['nombre_conductor']; ?></th>
                            <th><?php echo $ldcevi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldcevi['direccion']; ?></th>
                            <th><?php echo $ldcevi['telefono1']; ?></th>
                            <th><?php echo $ldcevi['telefono2']; ?></th>
                            <th><?php echo $ldcevi['telefono3']; ?></th>
                        </tr>
                    <?php } 
                
                    //Certificados de Cursos
                
                    $listarDocsCCVaciosId = $conductor->listarDocsCCVaciosId($conductores[$i]);
                
                    
                    foreach ($listarDocsCCVaciosId as $ldccvi){ ?>
                        <tr class="text-center">
                            <th>CERTIFICADOS DE CURSOS</th>
                            <th>VACIO</th>
                            <th><?php echo $ldccvi['id_conductor']; ?></th>
                            <th><?php echo $ldccvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldccvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldccvi['direccion']; ?></th>
                            <th><?php echo $ldccvi['telefono1']; ?></th>
                            <th><?php echo $ldccvi['telefono2']; ?></th>
                            <th><?php echo $ldccvi['telefono3']; ?></th>
                        </tr>
                    <?php }
                
                    //Libreta Militar
                
                    $listarDocsLMVaciosId = $conductor->listarDocsLMVaciosId($conductores[$i]);
                
                    
                    foreach ($listarDocsLMVaciosId as $ldlmvi){ ?>
                        <tr class="text-center">
                            <th>LIBRETA MILITAR</th>
                            <th>VACIO</th>
                            <th><?php echo $ldlmvi['id_conductor']; ?></th>
                            <th><?php echo $ldlmvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldlmvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldlmvi['direccion']; ?></th>
                            <th><?php echo $ldlmvi['telefono1']; ?></th>
                            <th><?php echo $ldlmvi['telefono2']; ?></th>
                            <th><?php echo $ldlmvi['telefono3']; ?></th>
                        </tr>
                    <?php } 
                
                    //Examen Medico
                
                    $listarDocsEMVaciosId = $conductor->listarDocsEMVaciosId($conductores[$i]);
                
                    
                    foreach ($listarDocsEMVaciosId as $ldemvi){ ?>
                        <tr class="text-center">
                            <th><?php echo utf8_decode("EXÁMEN MÉDICO"); ?></th>
                            <th>VACIO</th>
                            <th><?php echo $ldemvi['id_conductor']; ?></th>
                            <th><?php echo $ldemvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldemvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldemvi['direccion']; ?></th>
                            <th><?php echo $ldemvi['telefono1']; ?></th>
                            <th><?php echo $ldemvi['telefono2']; ?></th>
                            <th><?php echo $ldemvi['telefono3']; ?></th>
                        </tr>
                    <?php } 
                
                    //Planilla Seguridad Social
                
                    $listarDocsPSSVaciosId = $conductor->listarDocsPSSVaciosId($conductores[$i]);
                
                     
                    foreach ($listarDocsPSSVaciosId as $ldpssvi){ ?>
                        <tr class="text-center">
                            <th>PLANILLA SEGURIDAD SOCIAL</th>
                            <th>VACIO</th>
                            <th><?php echo $ldpssvi['id_conductor']; ?></th>
                            <th><?php echo $ldpssvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldpssvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldpssvi['direccion']; ?></th>
                            <th><?php echo $ldpssvi['telefono1']; ?></th>
                            <th><?php echo $ldpssvi['telefono2']; ?></th>
                            <th><?php echo $ldpssvi['telefono3']; ?></th>
                        </tr>
                    <?php }
                    
                    //Licencia de Conducción
                                            
                    $listarDocsConductorLcVencidosPorId = $conductor->listarDocsConductorLcVencidosPorId($conductores[$i], $hoy);
                
                    foreach ($listarDocsConductorLcVencidosPorId as $ldclcvi){ ?>
                        <tr class="text-center">
                            <th>LICENCIA DE CONDUCCIÓN</th>
                            <th>VENCIDO</th>
                            <th><?php echo $ldclcvi['id_conductor']; ?></th>
                            <th><?php echo $ldclcvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldclcvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldclcvi['direccion']; ?></th>
                            <th><?php echo $ldclcvi['telefono1']; ?></th>
                            <th><?php echo $ldclcvi['telefono2']; ?></th>
                            <th><?php echo $ldclcvi['telefono3']; ?></th>
                        </tr>
                        
                    <?php } 
                
                    //Examen Medico
                    
                    $listarDocsConductorEMVencidosPorId = $conductor->listarDocsConductorEMVencidosPorId($conductores[$i], $hoy); 
                    
                    foreach ($listarDocsConductorEMVencidosPorId as $ldemcvi){ ?>
                        <tr class="text-center">
                            <th><?php echo utf8_decode("EXÁMEN MÉDICO"); ?></th>
                            <th>VENCIDO</th>
                            <th><?php echo $ldclcvi['id_conductor']; ?></th>
                            <th><?php echo $ldclcvi['nombre_conductor']; ?></th>
                            <th><?php echo $ldclcvi['numero_documento_conductor']; ?></th>
                            <th><?php echo $ldclcvi['direccion']; ?></th>
                            <th><?php echo $ldclcvi['telefono1']; ?></th>
                            <th><?php echo $ldclcvi['telefono2']; ?></th>
                            <th><?php echo $ldclcvi['telefono3']; ?></th>
                        </tr>
                    <?php } 
                    
                    } ?>
            <?php } else { ?>
                <?php foreach ($listarDocsFDVacios as $ldfdv){ ?>
                    <tr>
                        <th>FOTOCOPIA DOCUMENTO</th>
                        <th>VACIO</th>
                        <th><?php echo $ldfdv['id_conductor']; ?></th>
                        <th><?php echo $ldfdv['nombre_conductor']; ?></th>
                        <th><?php echo $ldfdv['numero_documento_conductor']; ?></th>
                        <th><?php echo $ldfdv['direccion']; ?></th>
                        <th><?php echo $ldfdv['telefono1']; ?></th>
                        <th><?php echo $ldfdv['telefono2']; ?></th>
                        <th><?php echo $ldfdv['telefono3']; ?></th>
                    </tr>
                <?php } ?>
                
                <?php foreach ($listarDocsLCVacios as $ldlcv){ ?>
                    <tr>
                        <th>LICENCIA DE CONDUCCIÓN</th>
                        <th>VACIO</th>
                        <th><?php echo $ldlcv['id_conductor']; ?></th>
                        <th><?php echo $ldlcv['nombre_conductor']; ?></th>
                        <th><?php echo $ldlcv['numero_documento_conductor']; ?></th>
                        <th><?php echo $ldlcv['direccion']; ?></th>
                        <th><?php echo $ldlcv['telefono1']; ?></th>
                        <th><?php echo $ldlcv['telefono2']; ?></th>
                        <th><?php echo $ldlcv['telefono3']; ?></th>
                    </tr>
                <?php } ?>
                
                <?php foreach ($listarDocsCLVacios  as $ldclv){ ?>
                    <tr>
                        <th>CERTIFICADOS LABORALES</th>
                        <th>VACIO</th>
                        <th><?php echo $ldclcvi['id_conductor']; ?></th>
                        <th><?php echo $ldclcvi['nombre_conductor']; ?></th>
                        <th><?php echo $ldclcvi['numero_documento_conductor']; ?></th>
                        <th><?php echo $ldclcvi['direccion']; ?></th>
                        <th><?php echo $ldclcvi['telefono1']; ?></th>
                        <th><?php echo $ldclcvi['telefono2']; ?></th>
                        <th><?php echo $ldclcvi['telefono3']; ?></th>
                    </tr>
                <?php } ?>
                
                <?php foreach ($listarDocsCEVacios  as $ldcev){ ?>
                    <tr>
                        <th>CERTIFICADOS DE ESTUDIOS</th>
                        <th>VACIO</th>
                        <th><?php echo $ldclcvi['id_conductor']; ?></th>
                        <th><?php echo $ldclcvi['nombre_conductor']; ?></th>
                        <th><?php echo $ldclcvi['numero_documento_conductor']; ?></th>
                        <th><?php echo $ldclcvi['direccion']; ?></th>
                        <th><?php echo $ldclcvi['telefono1']; ?></th>
                        <th><?php echo $ldclcvi['telefono2']; ?></th>
                        <th><?php echo $ldclcvi['telefono3']; ?></th>
                    </tr>
                <?php } ?>
                
                <?php foreach ($listarDocsCCVacios  as $ldccv){ ?>
                    <tr>
                        <th>CERTIFICADOS DE CURSOS</th>
                        <th>VACIO</th>
                        <th><?php echo $ldclcvi['id_conductor']; ?></th>
                        <th><?php echo $ldclcvi['nombre_conductor']; ?></th>
                        <th><?php echo $ldclcvi['numero_documento_conductor']; ?></th>
                        <th><?php echo $ldclcvi['direccion']; ?></th>
                        <th><?php echo $ldclcvi['telefono1']; ?></th>
                        <th><?php echo $ldclcvi['telefono2']; ?></th>
                        <th><?php echo $ldclcvi['telefono3']; ?></th>
                    </tr>
                <?php } ?>
                
                <?php foreach ($listarDocsLMVacios  as $ldlmv){ ?>
                    <tr>
                        <th>LIBRETA MILITAR</th>
                        <th>VACIO</th>
                        <th><?php echo $ldlmv['id_conductor']; ?></th>
                        <th><?php echo $ldlmv['nombre_conductor']; ?></th>
                        <th><?php echo $ldlmv['numero_documento_conductor']; ?></th>
                        <th><?php echo $ldlmv['direccion']; ?></th>
                        <th><?php echo $ldlmv['telefono1']; ?></th>
                        <th><?php echo $ldlmv['telefono2']; ?></th>
                        <th><?php echo $ldlmv['telefono3']; ?></th>
                    </tr>
                <?php } ?>
                
                <?php foreach ($listarDocsEMVacios as $ldemv){ ?>
                    <tr>
                        <th><?php echo utf8_decode("EXÁMEN MÉDICO"); ?></th>
                        <th>VACIO</th>
                        <th><?php echo $ldemv['id_conductor']; ?></th>
                        <th><?php echo $ldemv['nombre_conductor']; ?></th>
                        <th><?php echo $ldemv['numero_documento_conductor']; ?></th>
                        <th><?php echo $ldemv['direccion']; ?></th>
                        <th><?php echo $ldemv['telefono1']; ?></th>
                        <th><?php echo $ldemv['telefono2']; ?></th>
                        <th><?php echo $ldemv['telefono3']; ?></th>
                    </tr>
                <?php } ?>
                
                <?php foreach ($listarDocsPSSVacios as $ldpssv){ ?>
                    <tr>
                        <th>PLANILLA SEGURIDAD SOCIAL</th>
                        <th>VACIO</th>
                        <th><?php echo $ldpssv['id_conductor']; ?></th>
                        <th><?php echo $ldpssv['nombre_conductor']; ?></th>
                        <th><?php echo $ldpssv['numero_documento_conductor']; ?></th>
                        <th><?php echo $ldpssv['direccion']; ?></th>
                        <th><?php echo $ldpssv['telefono1']; ?></th>
                        <th><?php echo $ldpssv['telefono2']; ?></th>
                        <th><?php echo $ldpssv['telefono3']; ?></th>
                    </tr>
                <?php } ?>
                
            <?php } ?>
        <?php } ?>
    </tbody>
</table>