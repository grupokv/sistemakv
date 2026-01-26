<?php  
require_once ("../Modelo/Programacion.php");
require_once ("../Modelo/Conductor.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/Usuario.php");

$fecha = $_POST['fecha'];
$id = $_POST['id'];

$programacion = new Programacion();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
$usuario = new Usuario();


$listar_programacion_servicios = $programacion->listarServiciosProgramadosPorFecha($fecha);
//print_r($listar_programacion_servicios);
$html = '';
	if (count($listar_programacion_servicios) > 0) {
        $html .= '<div class="mt-2 p-4 table-responsive">';
            $html .= '<table id="dataTable-' . $id .'" class="table table-hover table-sm display" style="width:100%;">';
                $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                    $html .= '<tr class="text-center">';
                        $html .= '<th style="vertical-align: top;"></th>';
                        $html .= '<th style="vertical-align: top;">ESTADO</th>';
                        $html .= '<th style="vertical-align: top;">CODIGO</th>';
                        $html .= '<th style="vertical-align: top;">FECHA</th>';
                        $html .= '<th style="vertical-align: top;">LOCALIDAD</th>';
                        $html .= '<th style="vertical-align: top;">PROYECTO</th>';
                        $html .= '<th style="vertical-align: top;">UN. OPERATIVA</th>';
                        $html .= '<th style="vertical-align: top;">PUNTO INICIO</th>';
                        $html .= '<th style="vertical-align: top;">PUNTO FINAL</th>';
                        $html .= '<th style="vertical-align: top;">E/S</th>';
                        $html .= '<th style="vertical-align: top;">HORA</th>';
                        $html .= '<th style="vertical-align: top;">FRECUENCIA</th>';
                        $html .= '<th style="vertical-align: top;">OBSERVACIONES</th>';
                        $html .= '<th style="vertical-align: top;">CAPACIDAD</th>';
                        //$html .= '<th style="vertical-align: top;">PROGRAMADO</th>';
                        $html .= '<th style="vertical-align: top;">MONITORA</th>';
                        $html .= '<th style="vertical-align: top;">CONTACTO MONITORA</th>';
                        $html .= '<th style="vertical-align: top; width: 150px;">NOVEDADES</th>';
                        $html .= '<th style="vertical-align: top;">PLACA FACT</th>';
                        $html .= '<th style="vertical-align: top;">PLACA LIQ</th>';
                        $html .= '<th style="vertical-align: top;">CAPACIDAD VEHICULO</th>';
                        $html .= '<th style="vertical-align: top;">PROPIETARIO</th>';
                        $html .= '<th style="vertical-align: top;">CONDUCTOR</th>';
                        $html .= '<th style="vertical-align: top;">CONTACTO CONDUCTOR</th>';
                        $html .= '<th style="vertical-align: top;">VALOR PAGAR VEHICULO</th>';
                        $html .= '<th style="vertical-align: top;">VALOR PAGAR MONITORA</th>';
                        $html .= '<th style="vertical-align: top;">VALOR FACTURAR</th>';
                    $html .= '</tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                    foreach ($listar_programacion_servicios as $lps){
                        $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_facturacion']);
                        $listarVehiculoliquiID = $vehiculo->listarPorId($lps['id_vehiculo_liquidacion']);
						$listarUsuarioPorId = $usuario->listarUsuarioPorId($listarVehiculoID[0]['id_propietario']);
                        $listarConductorID = $conductor->listarPorId($lps['id_conductor']);
                        $listarUnidadOperativaId = $programacion->listarUnidadOperativaId($lps['unidad_operativa']);

                        $html .= '<tr class="text-center" style=" font-size: .8rem;">';

                            if($lps['estado'] == 'A'){
                                $html .= '<td><i class="fa fa-check-circle-o" style="color: green; cursor: pointer; font-size: 1.3rem;" onclick="finalizarServicio(' . $lps['id_programacion'] . ');"></i></td>';
                            }else{
                                $html .= '<td>-</td>';
                            }

                            if($lps['estado'] == 'A'){
                                $html .= '<td style=" font-size: .9rem; color: green;" ><strong>ACTIVO</strong></td>';
                            }else if($lps['estado'] == 'F'){
                                $html .= '<td style=" font-size: .9rem; color: #db2a2a;" ><strong>FINALIZADO</strong></td>';
                            }else if($lps['estado'] == 'C'){
                                $html .= '<td style=" font-size: .9rem; color: #f5c127;" ><strong>CANCELADO</strong></td>';
                            }else{
                                $html .= '<td style=" font-size: .9rem;><strong></strong></td>';
                            }

                            $html .= '<td style=" font-size: .9rem;" ><strong>' . $lps['codigo_identificativo'] . '</strong></td>';
                            $html .= '<td style=" font-size: .9rem;" ><strong>' . $lps['fecha'] . '</strong></td>';
                            $html .= '<td>' . $lps['localidad'] . '</td>';
                            $html .= '<td>' . $lps['proyecto'] . '</td>';
                            $html .= '<td>' . $listarUnidadOperativaId[0]['unidad_operativa'] . '</td>';
                            $html .= '<td>' . $lps['punto_inicio'] . '</td>';
                            $html .= '<td>' . $lps['punto_final'] . '</td>';
                            $html .= '<td><strong>' . $lps['entrada_salida'] . '</strong></td>';
                            $html .= '<td>'. strtoupper(date('g:i a', strtotime($lps['horario']))) . '</td>';
                            $html .= '<td>'.  $lps['frecuencia'] . '</td>';
                            $html .= '<td>'.  $lps['observaciones'] . '</td>';
                            $html .= '<td>'.  $lps['capacidad_servicio'] . '</td>';
                            /*$html .= '<td>'.  $lps['programado'] . '</td>';*/
                            $html .= '<td>'.  strtoupper($lps['nombre_monitora']) . '</td>';
                            $html .= '<td>'.  $lps['telefono_monitora'] . '</td>';
                            $html .= '<td>'.  $lps['novedades'] . '</td>';

                            $html .= '<td><a style="color: darkcyan; cursor: pointer;" data-toggle="modal" data-target="#vehiModal" onclick="modal('. $lps['id_vehiculo_facturacion']. ')">' . $listarVehiculoID[0]['placa'] . '</a></td>';

                            $html .= '<td><a style="color: darkcyan; cursor: pointer;" data-toggle="modal" data-target="#vehiModal" onclick="modal('. $lps['id_vehiculo_liquidacion']. ')">' . $listarVehiculoliquiID[0]['placa'] . '</a></td>';

                            $html .= '<td>' . $listarVehiculoliquiID[0]['cant_pasajeros'] . '</td>';
                            $html .= '<td>' . $listarUsuarioPorId[0]['nombre'] . '</td>';
                            $html .= '<td>' . $listarConductorID[0]['nombre_conductor'] .'</td>';
                            $html .= '<td>' . $listarConductorID[0]['telefono1'] . '</td>';
                            $html .= '<td><b>$ </b>' . number_format($lps['valor_pagar']) .'</td>';
                            $html .= '<td><b>$ </b>' . number_format($lps['valor_pagar_monitora']) .'</td>';
                            $html .= '<td><b>$ </b>' . number_format($lps['valor_facturar']) .'</td>';
                        
                                
                        $html .= '</tr>';

                    }
                $html .= '</tbody>';
            $html .= '</table>';

        $html .= '</div>';
    }else{

    	$html .= '<div class="mt-2 p-4 table-responsive text-center">';
    		$html .= '<p>No hay servicios programados para este día.</p>';
    	$html .= '</div>';

    }

echo $html;

?>

<script type="text/javascript">

$( function() {
	
	var id = <?php echo $id; ?>;
	
	$('#dataTable-'+id).DataTable({
        "responsive": true,
        "scrollX": true,
        "destroy": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
        },
    });

});



</script>