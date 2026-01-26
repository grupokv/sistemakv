<?php 
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte-Cartera.xls');

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/Vehiculo.php");
require_once ("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once ("../Modelo/TipoVehiculo.php");
require_once ("../Modelo/Cartera.php");

$cartera = new Cartera();
$vehiculo = new Vehiculo();
$tipoVehiculo = new TipoVehiculo();
$usuario = new Usuario();
$cliente = new Cliente();
$concepto = new ConceptoCobro();

echo $filtro = $_POST['filtro'];
$id_vehiculo = $_POST['vehiculo'];
$id_cliente = $_POST['cliente'];
echo $id_concepto = $_POST['concepto'];
$fecha_mes = $_POST['fecha_mes'];

if($filtro == "V"){
    $listarReporteDescuentosPorVehiculo = $cartera->listarReporteDescuentosPorVehiculo($id_vehiculo);
    //print_r($listarReporteDescuentosPorVehiculo);
}else if($filtro == "NC"){
    $listarReporteDescuentosPorNomina = $cartera->listarReporteDescuentosPorNomina($id_cliente);
    //print_r($listarReporteDescuentosPorNomina);
}else if($filtro == "DC"){
    if(($id_concepto != 0) && ($fecha_mes != "")){
        $fecha_cruce = explode("/", $fecha_mes);
        $fecha_mes_cruce = $fecha_cruce[0];
        
        $listarReporteDescuentosCruzadosFiltro1 = $cartera->listarReporteDescuentosCruzadosFiltro1($id_concepto, $fecha_mes_cruce);
        //print_r($listarReporteDescuentosCruzadosFiltro1);
    }else if(($id_concepto != 0) && ($fecha_mes == "")){
        $listarReporteDescuentosCruzadosFiltro2 = $cartera->listarReporteDescuentosCruzadosFiltro2($id_concepto);
        //print_r($listarReporteDescuentosCruzadosFiltro2);
    }
}else if($filtro == "TC"){
    $listarTodosDescuentosCruzados = $cartera->listarReporteTodosDescuentosCruzados();
    //print_r($listarTodosDescuentosCruzados);
}else if($filtro == "GD"){
    $listarTodosDescuentos = $cartera->listarDescuentosCartera();
    //print_r($listarTodosDescuentos);
}

?>

<table>
    <thead>
        
        <?php if((($id_concepto != 0) & ($fecha_mes != "")) || (($id_concepto != 0) & ($fecha_mes == ""))){ ?>
        
	        <tr>
                <th>ID DESCUENTO</th>
                <th>ID COBRO</th>
                <th>PLACA</th>
                <th>NUMERO MOVIL</th>
                <th>TIPO VEHICULO</th>
                <th>PROPIETARIO</th>
                <th>NUM DOCUMENTO PROPIETARIO</th>
                <th>CONCEPTO SERVICIO</th>
                <th>FRECUENCIA</th>
                <th>FECHA COBRO</th>
                <th>VALOR COBRO</th>
                <th>DESCUENTO</th>
                <th>VALOR TOTAL</th>
                <th>PERIODO VALIDO DEL DESCUENTO</th>
                <th>DESCUENTO DE NOMINA</th>
                <th>CLIENTE</th>
                <th>ESTADO</th>
                <th>FECHA CRUCE</th>
			</tr>
	    <?php } else { ?>
	        <tr>
                <th>ID DESCUENTO</th>
                <th>PLACA</th>
                <th>NUMERO MOVIL</th>
                <th>TIPO VEHICULO</th>
                <th>PROPIETARIO</th>
                <th>NUM DOCUMENTO PROPIETARIO</th>
                <th>CONCEPTO SERVICIO</th>
                <th>FRECUENCIA</th>
                <th>VALOR</th>
                <th>DESCUENTO</th>
                <th>PERIODO VALIDO DEL DESCUENTO</th>
                <th>DESCUENTO DE NOMINA</th>
                <th>CLIENTE</th>
                <th>ESTADO</th>
			</tr>
	    <?php } ?>
    </thead>
    <tbody>
        <?php if(($id_vehiculo != 0) && ($id_cliente == 0) && ($id_concepto == 0)){
	        foreach($listarReporteDescuentosPorVehiculo As $lrdpb){ 
	            
                $listarVehiculoPorId = $vehiculo->listarPorId($lrdpb['id_vehiculo']);
                $listarConceptosPorId = $concepto->listarPorId($lrdpb['id_concepto']);
                $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); 
                $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                $listarValorConceptoPorTipoVehiculo = $concepto->buscarValor($lrdpb['id_concepto'], $listarVehiculoPorId[0]['id_tipo_vehiculo']);?>
                
				<tr>   
                    <td><?php echo $lrdpb['id_descuento']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                    <td><?php  echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                    <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                    <td>
                        <?php 
                            echo $listarConceptosPorId[0]['detalle_concepto']; 
                        ?>
                    </td>
                    <td><?php if($listarConceptosPorId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                    <td><?php echo $listarValorConceptoPorTipoVehiculo[0]['valor']; ?></td>
                    <td><?php if($lrdpb['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $lrdpb['descuento']; }else{ echo "$ " . number_format($lrdpb['descuento']); } ?></td>
                    <td>
                        <?php 
                            $datetime1 = date_create($lrdpb['fecha_inicial_valido']); 
                            $datetime2 = date_create($lrdpb['fecha_final_valido']); 
                            $diferencia = date_diff($datetime1, $datetime2);
                            echo $diferencia->format('%R%a Dias validos.') . " | " . $lrdpb['fecha_inicial_valido'] . " - " . $lrdpb['fecha_final_valido']; 
                        
                        ?>
                    </td>
                    <td><?php echo $lrdpb['descuento_nomina']; ?></td>
                    <td>
                        <?php 
                            $listarClienteId = $cliente->cliente_ID($lrdpb['id_cliente']);
                            echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                        ?>
                    </td>
                    <td>
                        <?php if($lrdpb['estado'] == "A"){ ?>
                            <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                        <?php }else{ ?>
                            <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                        <?php } ?>
                    </td>
                </tr>    
            <?php } ?>
        <?php } else if(($id_vehiculo == 0) && ($id_cliente != 0) && ($id_concepto == 0)){ 
            foreach($listarReporteDescuentosPorNomina As $lrdpn){ 
                
                $listarVehiculoPorId = $vehiculo->listarPorId($lrdpn['id_vehiculo']);
                $listarConceptosPorId = $concepto->listarPorId($lrdpn['id_concepto']);
                $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); 
                $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                $listarValorConceptoPorTipoVehiculo = $concepto->buscarValor($lrdpn['id_concepto'], $listarVehiculoPorId[0]['id_tipo_vehiculo']); ?>
            
                <tr>   
                    <td><?php echo $lrdpn['id_descuento']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                    <td><?php  echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                    <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                    <td>
                        <?php 
                            echo $listarConceptosPorId[0]['detalle_concepto']; 
                        ?>
                    </td>
                    <td><?php if($listarConceptosPorId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                    <td><?php echo $listarValorConceptoPorTipoVehiculo[0]['valor']; ?></td>
                    <td><?php if($lrdpn['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $lrdpn['descuento']; }else{ echo "$ " . number_format($lrdpn['descuento']); } ?></td>
                    <td>
                        <?php 
                            $datetime1 = date_create($lrdpn['fecha_inicial_valido']); 
                            $datetime2 = date_create($lrdpn['fecha_final_valido']); 
                            $diferencia = date_diff($datetime1, $datetime2);
                            echo $diferencia->format('%R%a Dias validos.') . " | " . $lrdpn['fecha_inicial_valido'] . " - " . $lrdpn['fecha_final_valido']; 
                        
                        ?>
                    </td>
                    <td><?php echo $lrdpn['descuento_nomina']; ?></td>
                    <td>
                        <?php 
                            $listarClienteId = $cliente->cliente_ID($lrdpn['id_cliente']);
                            echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                        ?>
                    </td>
                    <td>
                        <?php if($lrdpn['estado'] == "A"){ ?>
                            <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                        <?php }else{ ?>
                            <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                        <?php } ?>
                    </td>
                </tr> 
            <?php } ?>
        <?php } else if(($id_vehiculo == 0) && ($id_cliente == 0) && ($id_concepto != 0)){
            if(($id_concepto != 0) & ($fecha_mes != "")){ 
                foreach($listarReporteDescuentosCruzadosFiltro1 As $lrdcf1){
	            
                    $listarVehiculoPorId = $vehiculo->listarPorId($lrdcf1['id_vehiculo']);
                    $listarConceptosPorId = $concepto->listarPorId($lrdcf1['id_concepto']);
                    $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); 
                    $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                    $listaCobrosPorId = $concepto->listarPorIdCobrosPropietario($lrdcf1['id_cobro']); 
                    $listarValorConceptoPorTipoVehiculo = $concepto->buscarValor($lrdcf1['id_concepto'], $listarVehiculoPorId[0]['id_tipo_vehiculo']);?>
                    
                    <tr>   
                        <td><?php echo $lrdcf1['id_descuento']; ?></td>
                        <td><?php echo $lrdcf1['id_cobro']; ?></td>
                        <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                        <td><?php  echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                        <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                        <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                        <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                        <td>
                            <?php 
                                echo $listarConceptosPorId[0]['detalle_concepto']; 
                            ?>
                        </td>
                        <td><?php if($listarConceptosPorId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                        <td><?php echo $listaCobrosPorId[0]['fecha_cobro']; ?></td>
                        <td><?php echo $listarValorConceptoPorTipoVehiculo[0]['valor']; ?></td>
                        <td><?php if($lrdcf1['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $lrdcf1['descuento']; }else{ echo "$ " . number_format($lrdcf1['descuento']); } ?></td>
                        <td>
                            <?php 
                                if($lrdcf1['tipo_descuento'] == "PORCENTAJE"){
            		                echo $listarValorConceptoPorTipoVehiculo[0]['valor'] - ($listarValorConceptoPorTipoVehiculo[0]['valor'] * $lrdcf1['descuento'] / 100);
            		                
            		            }else if($lrdcf1['tipo_descuento'] == "FIJO"){
            		                echo $listarValorConceptoPorTipoVehiculo[0]['valor'] - $lrdcf1['descuento'];
            		            }
            		        ?>
                        </td>
                        <td>
                            <?php 
                                $datetime1 = date_create($lrdcf1['fecha_inicial_valido']); 
                                $datetime2 = date_create($lrdcf1['fecha_final_valido']); 
                                $diferencia = date_diff($datetime1, $datetime2);
                                echo $diferencia->format('%R%a Dias validos.') . " | " . $lrdcf1['fecha_inicial_valido'] . " - " . $lrdcf1['fecha_final_valido']; 
                            
                            ?>
                        </td>
                        <td><?php echo $lrdcf1['descuento_nomina']; ?></td>
                        <td>
                            <?php 
                                $listarClienteId = $cliente->cliente_ID($lrdcf1['id_cliente']);
                                echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                            ?>
                        </td>
                        <td>
                            <?php if($lrdcf1['estado'] == "A"){ ?>
                                <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                            <?php }else{ ?>
                                <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                            <?php } ?>
                        </td>
                        <td><?php echo $lrdcf1['fecha_cruce']; ?></td>
                    </tr> 
                <?php } ?>
            <?php } else if(($id_concepto != 0) && ($fecha_mes == "")){
                if($id_concepto == 0.1){  
                    foreach($listarTodosDescuentosCruzados As $ltdc){ 
                        $listaCobrosPorId = $concepto->listarPorIdCobrosPropietario($ltdc['id_cobro']); 
                        $listarDescuentosPorId = $cartera->listarDescuentosCarteraPorId($ltdc['id_descuento']);
                        $listarVehiculoPorId = $vehiculo->listarPorId($listaCobrosPorId[0]['id_vehiculo']);
                        $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); 
                        $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                        $listarValorConceptoPorTipoVehiculo = $concepto->buscarValor($listaCobrosPorId[0]['id_concepto'], $listarVehiculoPorId[0]['id_tipo_vehiculo']);
                        $listarConceptosPorId = $concepto->listarPorId($listaCobrosPorId[0]['id_concepto']); ?>
                        
                        <tr>   
                            <td><?php echo $ltdc['id_descuento']; ?></td>
                            <td><?php echo $ltdc['id_cobro']; ?></td>
                            <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                            <td><?php echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                            <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                            <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                            <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                            <td>
                                <?php 
                                    echo $listarConceptosPorId[0]['detalle_concepto']; 
                                ?>
                            </td>
                            <td><?php if($listarConceptosPorId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                            <td><?php echo $listaCobrosPorId[0]['fecha_cobro']; ?></td>
                            <td><?php echo $listarValorConceptoPorTipoVehiculo[0]['valor']; ?></td>
                            <td><?php if($listarDescuentosPorId[0]['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $listarDescuentosPorId[0]['descuento']; }else{ echo "$ " . number_format($listarDescuentosPorId[0]['descuento']); } ?></td>
                            <td>
                                <?php 
                                    if($listarDescuentosPorId[0]['tipo_descuento'] == "PORCENTAJE"){
                		                echo $listarValorConceptoPorTipoVehiculo[0]['valor'] - ($listarValorConceptoPorTipoVehiculo[0]['valor'] * $listarDescuentosPorId[0]['descuento'] / 100);
                		                
                		            }else if($listarDescuentosPorId[0]['tipo_descuento'] == "FIJO"){
                		                echo $listarValorConceptoPorTipoVehiculo[0]['valor'] - $listarDescuentosPorId[0]['descuento'];
                		            }
                		        ?>
                            </td>
                            <td>
                                <?php 
                                    $datetime1 = date_create($listarDescuentosPorId[0]['fecha_inicial_valido']); 
                                    $datetime2 = date_create($listarDescuentosPorId[0]['fecha_final_valido']); 
                                    $diferencia = date_diff($datetime1, $datetime2);
                                    echo $diferencia->format('%R%a Dias validos.') . " | " . $listarDescuentosPorId[0]['fecha_inicial_valido'] . " - " . $listarDescuentosPorId[0]['fecha_final_valido']; 
                                
                                ?>
                            </td>
                            <td><?php echo $listarDescuentosPorId[0]['descuento_nomina']; ?></td>
                            <td>
                                <?php 
                                    $listarClienteId = $cliente->cliente_ID($listarDescuentosPorId[0]['id_cliente']);
                                    echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                                ?>
                            </td>
                            <td>
                                <?php if($listarDescuentosPorId[0]['estado'] == "A"){ ?>
                                    <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                                <?php }else{ ?>
                                    <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                                <?php } ?>
                            </td>
                            <td><?php echo $ltdc['fecha_cruce'] . " a las " . $ltdc['hora_cruce']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else {  
                    foreach($listarReporteDescuentosCruzadosFiltro2 As $lrdcf2){ 
                        
                        $listarVehiculoPorId = $vehiculo->listarPorId($lrdcf2['id_vehiculo']);
                        $listarConceptosPorId = $concepto->listarPorId($lrdcf2['id_concepto']);
                        $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); 
                        $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                        $listaCobrosPorId = $concepto->listarPorIdCobrosPropietario($lrdcf2['id_cobro']); 
                        $listarValorConceptoPorTipoVehiculo = $concepto->buscarValor($lrdcf2['id_concepto'], $listarVehiculoPorId[0]['id_tipo_vehiculo']);?>
                        
                        <tr>   
                            <td><?php echo $lrdcf2['id_descuento']; ?></td>
                            <td><?php echo $lrdcf2['id_cobro']; ?></td>
                            <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                            <td><?php echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                            <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                            <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                            <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                            <td>
                                <?php 
                                    echo $listarConceptosPorId[0]['detalle_concepto']; 
                                ?>
                            </td>
                            <td><?php if($listarConceptosPorId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                            <td><?php echo $listaCobrosPorId[0]['fecha_cobro']; ?></td>
                            <td><?php echo $listarValorConceptoPorTipoVehiculo[0]['valor']; ?></td>
                            <td><?php if($lrdcf2['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $lrdcf2['descuento']; }else{ echo "$ " . number_format($lrdcf2['descuento']); } ?></td>
                            <td>
                                <?php 
                                    if($lrdcf2['tipo_descuento'] == "PORCENTAJE"){
                		                echo $listarValorConceptoPorTipoVehiculo[0]['valor'] - ($listarValorConceptoPorTipoVehiculo[0]['valor'] * $lrdcf2['descuento'] / 100);
                		                
                		            }else if($lrdcf2['tipo_descuento'] == "FIJO"){
                		                echo $listarValorConceptoPorTipoVehiculo[0]['valor'] - $lrdcf2['descuento'];
                		            }
                		        ?>
                            </td>
                            <td>
                                <?php 
                                    $datetime1 = date_create($lrdcf2['fecha_inicial_valido']); 
                                    $datetime2 = date_create($lrdcf2['fecha_final_valido']); 
                                    $diferencia = date_diff($datetime1, $datetime2);
                                    echo $diferencia->format('%R%a Dias validos.') . " | " . $lrdcf2['fecha_inicial_valido'] . " - " . $lrdcf2['fecha_final_valido']; 
                                
                                ?>
                            </td>
                            <td><?php echo $lrdcf2['descuento_nomina']; ?></td>
                            <td>
                                <?php 
                                    $listarClienteId = $cliente->cliente_ID($lrdcf2['id_cliente']);
                                    echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                                ?>
                            </td>
                            <td>
                                <?php if($lrdcf2['estado'] == "A"){ ?>
                                    <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                                <?php }else{ ?>
                                    <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                                <?php } ?>
                            </td>
                            <td><?php echo $lrdcf2['fecha_cruce'] . " a las " . $lrdcf2['hora_cruce']; ?></td>
                        </tr> 
                        
                    <?php }  ?>
                <?php } ?>
            <?php } ?>
        <?php } else if(($id_vehiculo == 0) && ($id_cliente == 0) && ($id_concepto == 0)){ 
            foreach($listarTodosDescuentos As $ltd){
                
                $listarVehiculoPorId = $vehiculo->listarPorId($ltd['id_vehiculo']);
                $listartipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']); 
                $listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']); 
                $listarValorConceptoPorTipoVehiculo = $concepto->buscarValor($ltd['id_concepto'], $listarVehiculoPorId[0]['id_tipo_vehiculo']);
                $listarConceptosPorId = $concepto->listarPorId($ltd['id_concepto']); ?>
                
                <tr>   
                    <td><?php echo $ltd['id_descuento']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['placa']; ?></td>
                    <td><?php echo $listarVehiculoPorId[0]['numero_movil']; ?></td>
                    <td><?php echo $listartipoVehiculoPorId[0]['nombre_tipo_vehiculo']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
                    <td><?php echo $listarPropietarioPorId[0]['usuario']; ?></td>
                    <td>
                        <?php 
                            echo $listarConceptosPorId[0]['detalle_concepto']; 
                        ?>
                    </td>
                    <td><?php if($listarConceptosPorId[0]['frecuencia'] == "A"){ echo "ANUAL"; }else{ echo "MENSUAL"; } ?></td>
                    <td><?php echo $listarValorConceptoPorTipoVehiculo[0]['valor']; ?></td>
                    <td><?php if($ltd['tipo_descuento'] == "PORCENTAJE"){ echo "%" . $ltd['descuento']; }else{ echo "$ " . number_format($ltd['descuento']); } ?></td>
                    <td>
                        <?php 
                            $datetime1 = date_create($ltd['fecha_inicial_valido']); 
                            $datetime2 = date_create($ltd['fecha_final_valido']); 
                            $diferencia = date_diff($datetime1, $datetime2);
                            echo $diferencia->format('%R%a Dias validos.') . " | " . $ltd['fecha_inicial_valido'] . " - " . $ltd['fecha_final_valido']; 
                        
                        ?>
                    </td>
                    <td><?php echo $ltd['descuento_nomina']; ?></td>
                    <td>
                        <?php 
                            $listarClienteId = $cliente->cliente_ID($ltd['id_cliente']);
                            echo $listarClienteId[0]['id_cliente'] . " - " . $listarClienteId[0]['razon_social']; 
                        ?>
                    </td>
                    <td>
                        <?php if($ltd['estado'] == "A"){ ?>
                            <span style="color: green; font-size:1.4rem;" class="fa fa-check-circle-o "></span> ACTIVO</p>
                        <?php }else{ ?>
                            <p><span style="color: red; font-size:1.4rem;" class="fa fa-times-circle "></span> INACTIVO</p>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>

