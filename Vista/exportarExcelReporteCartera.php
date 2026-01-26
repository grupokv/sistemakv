<?php
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte-Cartera.xls');

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/Usuario.php");
require_once ("../Modelo/ConceptosCobro.php");
require_once ("../Modelo/TipoVehiculo.php");
require_once ("../Modelo/General.php");

$id_concepto = $_POST['concepto'];
$banco_consignacion = $_POST['cuentaBanco'];
$fecha_anio = $_POST['fechaAnio'];
$fecha_mes = $_POST['fechaMes'];
$id_vehiculo = $_POST['vehiculo'];

$concepto = new ConceptoCobro();
$vehiculo = new Vehiculo();
$usuario = new Usuario();
$tipoVehiculo = new TipoVehiculo();

if($_POST['tipoReporte'] == "C"){
    if($_POST['frecuenciaS'] == "A"){
        $listarFiltroServicioFrecuenciaAnual = $concepto->listarFiltroServicioFrecuenciaAnual($id_concepto, $fecha_anio);
    }else if($_POST['frecuenciaS'] == "M"){
        $listarFiltroServicioFrecuenciaMensual = $concepto->listarFiltroServicioFrecuenciaMensual($id_concepto, $fecha_mes);
    }
} else if($_POST['tipoReporte'] == "CB"){
    $listarComprobantesPorCuentaBanco = $concepto->listarComprobantesPorCuentaBanco($banco_consignacion, $fecha_mes);
} else if($_POST['tipoReporte'] == "V"){
    $listarFiltroEstadoCuentaVehiculo = $concepto->listarFiltroEstadoCuentaVehiculo($id_vehiculo, $fecha_mes);
} else if($_POST['tipoReporte'] == "N"){
    $listarVehiculosVinculados = $vehiculo->listarVehiculosVinculados();
}
?>
<table border="1">
    <thead>
        <?php if($_POST['tipoReporte'] == "C"){ ?>
            <tr>
                <th>CONCEPTO SERVICIO</th>
                <th>FRECUENCIA</th>
                <th>PLACA</th>
                <th>MARCA</th>
                <th>NUMERO MOVIL</th>
                <th>TIPO VEHICULO</th>
                <th>PROPIETARIO</th>
                <th>NUM DOCUMENTO PROPIETARIO</th>
                <th>VALOR</th>
                <th>ESTADO</th>
            </tr>
        <?php } else if($_POST['tipoReporte'] == "CB"){ ?>
            <tr>
                <th>CUENTA BANCO</th>
                <th>TIPO CUENTA</th>
                <th>PLACA</th>
                <th>MARCA</th>
                <th>NUMERO MOVIL</th>
                <th>TIPO VEHICULO</th>
                <th>PROPIETARIO</th>
                <th>NUM DOCUMENTO PROPIETARIO</th>
                <th>CONCEPTO SERVICIO</th>
                <th>FRECUENCIA</th>
                <th>COMPROBANTE PAGO</th>
                <th>FECHA PAGO</th>
                <th>VALOR</th>
            </tr>
        <?php } else if($_POST['tipoReporte'] == "V"){ ?>
            <tr>
                <th>PLACA</th>
                <th>MARCA</th>
                <th>NUMERO MOVIL</th>
                <th>TIPO VEHICULO</th>
                <th>PROPIETARIO</th>
                <th>NUM DOCUMENTO PROPIETARIO</th>
                <th>CONCEPTO SERVICIO</th>
                <th>FRECUENCIA</th>
                <th>FECHA COBRO</th>
                <th>VALOR</th>
                <th>ESTADO</th>
            </tr>
        <?php } else if($_POST['tipoReporte'] == "N"){ ?>
            <tr>
                <th>PLACA</th>
                <th>MARCA</th>
                <th>NUMERO MOVIL</th>
                <th>TIPO VEHICULO</th>
                <th>PROPIETARIO</th>
                <th>NUM DOCUMENTO PROPIETARIO</th>
                <th>CONCEPTO SERVICIO</th>
                <th>FRECUENCIA</th>
                <th>FECHA COBRO</th>
                <th>VALOR</th>
                <th>ESTADO</th>
            </tr>
        <?php }?>
    </thead>
    <tbody style="text-align: center;">
        <?php if(($_POST['tipoReporte'] == "C") && ($_POST['frecuenciaS'] == "A")){ ?>
            <?php foreach($listarFiltroServicioFrecuenciaAnual As $lfsfa){ 
            
                $listarConceptosId = $concepto->listarPorId($lfsfa['id_concepto']); 
                $listarVehiculoPorId = $vehiculo->listarPorId($lfsfa['id_vehiculo']);
                $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); ?>
                
                <tr class="text-center">
                    <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                    <td><?php if($listarConceptosId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['marca']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                    <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                    <td><?php echo $lfsfa['valor']; ?></td>
                    <td><?php if($lfsfa['estado'] == "P"){ echo "PENDIENTE"; }else{ echo "SALDADO"; } ?></td>
                </tr>
            <?php } ?>
        <?php } else if(($_POST['tipoReporte'] == "C") && ($_POST['frecuenciaS'] == "M")){ ?>
            <?php foreach($listarFiltroServicioFrecuenciaMensual As $lfsfm){
                $listarConceptosId = $concepto->listarPorId($lfsfm['id_concepto']); 
                $listarVehiculoPorId = $vehiculo->listarPorId($lfsfm['id_vehiculo']);
                $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); ?>
                
                <tr>
                    <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                    <td><?php if($listarConceptosId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['marca']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                    <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                    <td><?php echo $lfsfm['valor']; ?></td>
                    <td><?php if($lfsfm['estado'] == "P"){ echo "PENDIENTE"; }else{ echo "SALDADO"; } ?></td>
                </tr>
            <?php } ?>
        <?php } else if($_POST['tipoReporte'] == "CB"){ ?>
            <?php foreach($listarComprobantesPorCuentaBanco As $lcpcb){ 
            
                $listaCobrosPorId = $concepto->listarPorIdCobrosPropietario($lcpcb['id_cobro_propietario']); 
                $listarConceptosId = $concepto->listarPorId($listaCobrosPorId[0]['id_concepto']); 
                $listarVehiculoPorId = $vehiculo->listarPorId($listaCobrosPorId[0]['id_vehiculo']);
                $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']);
                $listarBancosId = $concepto->listarBancosId($lcpcb['banco_consignacion']) ?>
                
                <tr>
                    <td><?php echo $listarBancosId[0]['descripcion']; ?></td>
                    <td><?php echo $listarBancosId[0]['tipo_cuenta']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['marca']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                    <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                    <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                    <td><?php if($listarConceptosId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                    <td><?php echo $lcpcb['num_id_comprobante']; ?></td>
                    <td>    
                        <?php 
                            $fechaPagoServicio = explode("-", $lcpcb['fecha_pago']); 
                            echo $fechaPagoServicio[2] . " DE " . strtoupper(mes($fechaPagoServicio[1])) . " DEL " . $fechaPagoServicio[0]; 
                        ?>
                    </td>
                    <td><?php echo $lcpcb['valor_servicio']; ?></td>
                </tr>
            <?php } ?>
        <?php } else if($_POST['tipoReporte'] == "V"){ ?>
            <?php foreach($listarFiltroEstadoCuentaVehiculo As $lfecv){ 
                
                $listarConceptosId = $concepto->listarPorId($lfecv['id_concepto']); 
                $listarVehiculoPorId = $vehiculo->listarPorId($lfecv['id_vehiculo']); 
                $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']);?>
                
                <tr>
                    <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['marca']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                    <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                    <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                    <td><?php if($listarConceptosId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                    <td>    
                        <?php 
                            $fechaCobroServicio = explode("-", $lfecv['fecha_cobro']); 
                            echo $fechaCobroServicio[2] . " DE " . strtoupper(mes($fechaCobroServicio[1])) . " DE " . $fechaCobroServicio[0]; 
                        ?>
                    </td>
                    <td><?php echo $lfecv['valor']; ?></td>
                    <td><?php if($lfecv['estado'] == "P"){ echo "PENDIENTE"; }else{ echo "SALDADO";} ?></td>
                </tr>
                
            <?php } ?>
        <?php } else if($_POST['tipoReporte'] == "N"){ ?>
            <?php foreach($listarVehiculosVinculados As $lvv){ 
            
            $listarCobrosPorVehiculo = $concepto->listarCobrosPorVehiculo($lvv['id_vehiculo']);
            $cant = count($listarCobrosPorVehiculo);
            
            $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($lvv['id_tipo_vehiculo']);
            $listarPropietarioPorId = $usuario->listarUsuarioPorId($lvv['id_propietario']);  ?>
                
                <tr>
                    <td <?php if($cant != 0){ ?> rowspan="<?php echo $cant ?>" <?php } ?> ><?php echo $lvv['placa']; ?></td>
                    <td rowspan="<?php echo $cant; ?>"><?php echo $lvv['marca']; ?></td>
                    <td rowspan="<?php echo $cant; ?>"><?php echo $lvv['numero_movil']; ?></td>
                    <td rowspan="<?php echo $cant; ?>"><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                    <td rowspan="<?php echo $cant; ?>"><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                    <td rowspan="<?php echo $cant; ?>"><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                    
                    <?php foreach($listarCobrosPorVehiculo As $lcpv){ 
                        $listarConceptosId = $concepto->listarPorId($lcpv['id_concepto']); ?>
                        
                        <td><?php echo $listarConceptosId[0]['detalle_concepto']; ?></td>
                        <td>
                            <?php 
                                if($listarConceptosId[0]['frecuencia'] == "A"){ 
                                    echo "ANUAL"; 
                                }else if($listarConceptosId[0]['frecuencia'] == "M"){ 
                                    echo "MENSUAL"; 
                                }else{ 
                                    echo "NINGUNA"; 
                                }       
                            ?>
                        </td>
                        <td><?php echo $lcpv['fecha_cobro']; ?> </td>
                        <td><?php echo "$ " . $lcpv['valor']; ?></td>
                        <td><?php if($lcpv['estado'] == "P"){ echo "PENDIENTE"; }else{ echo "SALDADO";} ?></td>
                </tr>
                    <?php } ?>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>