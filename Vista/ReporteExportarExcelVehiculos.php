<?php

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte-Vehiculos.xls');

require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/TipoVehiculo.php';
require_once '../Modelo/TipoServicio.php';
require_once '../Modelo/Vehiculo-Contrato.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Contrato.php';
require_once '../Modelo/EmpresaEnt.php';
require_once '../Modelo/Cliente.php';

$vehiculo = new Vehiculo();
$contrato = new Contrato();
$tipoServicio = new TipoServicio();
$cliente = new Cliente();
$empresa = new Empresa();
$tipoVehiculo = new TipoVehiculo();
$vehiculoContrato = new Vehiculo_Contrato();
$usuario = new Usuario();

$hoy = date('Y-m-d');

if($_POST){

    $flota_propia = '%%';
    if($_POST['filtro_flota_propia'] != ''){
        $flota_propia = $_POST['filtro_flota_propia'];
    }

    $empresa = "numero_movil LIKE '%%' ";

    if($_POST['filtro_empresa'] == 1){
        $empresa = "(numero_movil < 1000 AND numero_movil != 0)";
    }else if($_POST['filtro_empresa'] == 2){
        $empresa = "(numero_movil >= 1000 AND numero_movil != 0 )";
    }else if($_POST['filtro_empresa'] == 3){
        $empresa = "numero_movil != 0";
    }
    
    $id_tipo_vehiculo = '%%';
    if($_POST['filtro_tipo_vehiculo'] != ''){
        $id_tipo_vehiculo = $_POST['filtro_tipo_vehiculo'];
    }
  
} else {
    $flota_propia = '%%';
    $id_tipo_vehiculo = '%%';
    $empresa = "numero_movil LIKE '%%' ";
}

$reporte = $vehiculo->listarTodosFiltroVehiculos($flota_propia, $empresa, $id_tipo_vehiculo);

?>

<table border="1" width="70%" style="text-align: center;">
    <caption style="background-color: #357338">TOTAL DE VEHICULOS: <?php echo count($reporte);?></caption>
    <thead style="background-color: #357338">
        <tr style="text-align: center">
            <th>PLACA</th>
            <th>MARCA Y LINEA</th>
            <th>MODELO</th>
            <th>TIPO VEHICULO</th>
            <th>TIPO COMBUSTIBLE</th>
            <th>CANT DE PASAJEROS</th>
            <th>TIPO SERVICIO</th>
            <th>NUMERO MOVIL</th>
            <th>NOMBRE PROPIETARIO</th>
            <th>DOCUMENTO PROPIETARIO</th>
            <th>FECHA NACIMIENTO PROPIETARIO</th>
            <th>DIRECCION PROPIETARIO</th>
            <th>TELEFONO PROPIETARIO</th>
            <th>CIUDAD PROPIETARIO</th>
            <th>NUM TARJETA OPERACION</th>
            <th>FOTOCOPIA CC</th>
            <th>T.O.</th>
            <th>L.T.</th>
            <th>SOAT</th>
            <th>R.T.</th>
            <th>R.P.</th>
            <th>CONTRA ACTUAL</th>
            <th>EXTRA CONTRA ACTUAL</th>
            <th>D.V.</th>
            <th>FLOTA PROPIA</th>
            <th>EMPRESA</th>
            <th>ESTADO</th>
            
            <!-- CONDUCTORES-->
            <th>NOMBRE CONDUCTOR</th>
            <th>NUM DOCUMENTO</th>
            <th>FECHA NACIMIENTO</th>
            <th>FECHA VEN. LICENCIA</th>
            <th>CATEGORIA</th>
            <th>DIRECCION</th>
            <th>RH</th>
            <th>ESTADO CIVIL</th>
            <th>TELEFONO 1</th>
            <th>TELEFONO 2</th>
            <th>TELEFONO 3</th>
        </tr>
    </thead>
    <tbody> 
            <?php   foreach ($reporte as $lrv) { 

                        $listarConductorPorVehiculo = $vehiculo->listarConductoresPorId($lrv['id_vehiculo']);
                        $cant = count($listarConductorPorVehiculo);
                    ?>  
                    <tr style="text-align: center">
                        <td <?php if($cant != 0){ ?> rowspan="<?php echo $cant ?>" <?php } ?> ><?php echo $lrv['placa']; ?></td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['marca']; ?></td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['modelo']; ?></td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php 

                                $listarPorIdVehiculo = $tipoVehiculo->listarPorId($lrv['id_tipo_vehiculo']); 
                                echo $listarPorIdVehiculo[0]['nombre_tipo_vehiculo']; 

                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['tipo_combustible']; ?></td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['cant_pasajeros']; ?></td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php 
                                $listarPorIdServicio = $tipoServicio->listarPorId($lrv['id_tipo_servicio']);
                                echo $listarPorIdServicio[0]['nombre_tipo_servicio']; 
                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['numero_movil']; ?></td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php 
                                $listarUsuarioPorId = $usuario->listarUsuarioPorId($lrv['id_propietario']);
                                echo $listarUsuarioPorId[0]['nombre']; 
                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $listarUsuarioPorId[0]['usuario']; ?></td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['fecha_nac_propietario']; ?></td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['direccion_propietario']; ?></td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['telefono_propietario']; ?></td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['ciudad_propietario']; ?></td>
                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['num_tarjeta_operacion']; ?></td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php 

                                if($lrv['fotocopia_cedula_propietario'] == ''){
                                    echo "VACIO";
                                }else{
                                    echo "DOC CARGADO";
                                }

                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php 

                                if(($lrv['tarjeta_operacion'] == '') || ($lrv['fecha_vencimiento_to'] == '0000-00-00')){
                                    echo "VACIO";
                                }else{
                                    echo $lrv['fecha_vencimiento_to'];
                                }

                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>"> 
                            <?php  
                                if(($lrv['licencia_transito'] == '') || ($lrv['fecha_vencimiento_lt'] == '0000-00-00')){
                                    echo "VACIO";
                                }else{
                                    echo $lrv['fecha_vencimiento_lt'];
                                }
                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php  
                                if(($lrv['soat'] == '') || ($lrv['fecha_vencimiento_soat'] == '0000-00-00') ){
                                    echo "VACIO";
                                }else{
                                    echo $lrv['fecha_vencimiento_soat'];
                                }
                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php  
                                if(($lrv['revision_tecnomecanica'] == '') || ($lrv['fecha_vencimiento_rt'] == '0000-00-00')){
                                    echo "VACIO";
                                }else{
                                    echo $lrv['fecha_vencimiento_rt'];
                                }
                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php  
                                if(($lrv['revision_preventiva'] == '' ) || ($lrv['fecha_vencimiento_rp'] == '0000-00-00')){
                                    echo "VACIO";
                                }else{
                                    echo $lrv['fecha_vencimiento_rp'];
                                }
                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php  
                                if(($lrv['poliza_contra'] == '' ) || ($lrv['fecha_vencimiento_contra'] == '0000-00-00')){
                                    echo "VACIO";
                                }else{
                                    echo $lrv['fecha_vencimiento_contra'];
                                }
                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php  
                                if(($lrv['poliza_extra'] == '' ) || ($lrv['fecha_vencimiento_extra'] == '0000-00-00')){
                                    echo "VACIO";
                                }else{
                                    echo $lrv['fecha_vencimiento_extra'];
                                }
                            ?>
                        </td> 

                        <td rowspan="<?php echo $cant ?>">
                            <?php  
                                if(($lrv['disp_velocidad'] == '') || ($lrv['fecha_exp_disp_velocidad'] == '0000-00-00')){
                                    echo "VACIO";
                                }else{
                                    echo $lrv['fecha_exp_disp_velocidad'];
                                }
                            ?>
                        </td>

                        <td rowspan="<?php echo $cant ?>"><?php echo $lrv['flota_propia'] ?></td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php 
                                if($lrv['id_empresa'] == 1){ 
                                    echo 'ORT'; 
                                } else if($lrv['id_empresa'] == 2){ 
                                    echo 'LINEAS PREMIUM'; 
                                } 
                            ?>
                        </td>
                        <td rowspan="<?php echo $cant ?>">
                            <?php 
                              if($lrv['estado'] == 1){
                                echo "Activo";
                              } else if($lrv['estado'] == 0){
                                echo "Inactivo";
                              } else if($lrv['estado'] == 2){
                                echo "Desvinculado";
                              } else {
                                echo "Retirado";
                              } 
                            ?>
                        </td> 
                        <?php foreach ($listarConductorPorVehiculo as $lcpv){ ?>
                        
                            <!-- CONDUCTORES-->
                            <td><?php echo $lcpv['nombre_conductor']; ?></td>
                            <td><?php echo $lcpv['numero_documento_conductor']; ?></td>
                            <td><?php echo utf8_decode($lcpv['fecha_nacimiento_conductor']); ?></td>
                            <td><?php echo utf8_decode($lcpv['fecha_vencimiento_licencia']); ?></td>
                            <td><?php echo utf8_decode($lcpv['categoria_licencia']); ?></td>
                            <td><?php echo $lcpv['direccion']; ?></td>
                            <td><?php echo utf8_decode($lcpv['grupo_sanguineo']); ?></td>
                            <td><?php echo utf8_decode($lcpv['estado_civil']); ?></td>
                            <td><?php echo utf8_decode($lcpv['telefono1']); ?></td>
                            <td><?php echo utf8_decode($lcpv['telefono2']); ?></td>
                            <td><?php echo utf8_decode($lcpv['telefono3']); ?></td>

                    </tr> 
                        <?php } ?>

            <?php } ?>  
    </tbody>

</table>
