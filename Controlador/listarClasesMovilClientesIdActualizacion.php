<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Operativo.php");

$id_cliente = $_POST['id_cliente'];
$id_producto = $_POST['id_producto'];

$operativo = new Operativo();
$tipoVehiculo = new TipoVehiculo();

$listarTarifasProductosPorID = $operativo->listarTarifasProductosPorID($id_producto);
$listarClasesMovilPorIdCliente = $operativo->listarClasesMovilPorIdCliente($id_cliente); 

$tv = array();
foreach ($listarClasesMovilPorIdCliente as $ltv) {
    array_push($tv, $ltv['id']);
}

$tvt = array();
foreach ($listarTarifasProductosPorID as $ltppi) {
    array_push($tvt, $ltppi['id_tipo_vehiculo']);
}

$tvns = array_values(array_diff($tv, $tvt));

//print_r($listarClasesMovilPorIdCliente);

$html = '';

$html .= '<div class="row d-flex justify-content-center mb-4">';
    $html .= '<section class="col-6" style="text-align:right;">';
        $html .= '<a href="#tabs-2" rel="pop-up" onclick="registrarClaseMovil();" style="color: #77b9d3 !important;"><i class="fa fa-car mr-1" style="color: #1b2d3b !important;"></i>Clases Vehículos Producto</a>';
    $html .= '</section>';
    $html .= '<section class="col-6" style="text-align:left; color: #77b9d3 !important;">';
        $html .= '<a href="#tabs-2" onclick="recargarInformaciónClases();" style="color: #77b9d3 !important;"><i class="fa fa-refresh mr-1" style="color: #1b2d3b !important;"></i>Actualizar</a>';
    $html .= '</section>';
$html .= '</div>';

if (count($listarTarifasProductosPorID) > 0) {

		$html .= '<table style="text-align: center; width:100%;">';
            $html .= '<thead>';
                $html .= '<tr>';
                    $html .= '<th width="150px;">CLASE VEH.</th>';
                    $html .= '<th>VALOR RECORRIDO</th>';
                    $html .= '<th>VALOR HORA</th>';
                    $html .= '<th>RECORRIDOS X DIA</th>';
                    $html .= '<th>VALOR MENSUAL</th>';
                    $html .= '<th>VAL. RELEVO SENCILLO X RECORRIDO</th>';
                    $html .= '<th>VAL. RELEVO DOBLE X RECORRIDO</th>';
                    $html .= '<th>COSTO POR DISPONIBILIDAD</th>';
                $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
					foreach ($listarTarifasProductosPorID as $ltpi){ 
                        $listarClasesMovilClientesID = $operativo->listarClasesMovilClientesID($ltpi['id_tipo_vehiculo']);
                        $listarTipoV = $tipoVehiculo->listarPorId($listarClasesMovilClientesID[0]['id_tipo_vehiculo']);
                        

		                $html .= '<tr style="border-bottom: 3px solid #f2f2f2;">';
                            $html .= '<td id="claseVehiculos" style="color: #274054">';

                                $html .= '<b>' . strtoupper($listarClasesMovilClientesID[0]['clase_movil_producto']) . ' - ('. $listarTipoV[0]['nombre_tipo_vehiculo'] . ')</b>';

                                $html .= '<div class="col-12 d-flex justify-content-center mt-2">';
                                	if ($ltpi['id_tipo_vehiculo'] == $listarClasesMovilClientesID[0]['id']){
                                    	$html .= '<input type="checkbox" name="id_tipo_vehiculo[]" id="id_tipo_vehiculo" value="'. $listarClasesMovilClientesID[0]['id'] . '" checked >';
                                    }else{
                                    	$html .= '<input type="checkbox" name="id_tipo_vehiculo[]" id="id_tipo_vehiculo" value="'. $listarClasesMovilClientesID[0]['id'] . '">';
                                    }
                                $html .= '</div>';

                            $html .= '</td>';
                            $html .= '<td>';
                                $valor_recorrido = json_decode($ltpi['valor_recorrido']);

                                $html .= '<input type="text" id="vr_cliente" name="vr_cliente_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE" value="' . $valor_recorrido->{'cliente'} .'">';

                                $html .= '<input type="text" id="vr_movil" name="vr_movil_'.  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL" value="' . $valor_recorrido->{'movil'} .'" >';
                            $html .= '</td>';
                            $html .= '<td>';
                                   
                                $valor_hora = json_decode($ltpi['valor_hora']);

                                $html .= '<input type="text" id="vh_cliente" name="vh_cliente_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE" value="' .$valor_hora->{'cliente'} . '">';

                                $html .= '<input type="text" id="vh_movil" name="vh_movil_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL" value="' . $valor_hora->{'movil'} .'">';
                            $html .= '</td>';
                            $html .= '<td>'; 
                                $recorridos_x_dia = json_decode($ltpi['recorridos_x_dia']);
                               
                                $html .= '<input type="text" id="rxd_cliente" name="rxd_cliente_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE"value="' . $recorridos_x_dia->{'cliente'} . '">'; 

                                $html .= '<input type="text" id="rxd_movil" name="rxd_movil_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL"value="'. $recorridos_x_dia->{'movil'} . '">'; 
                            $html .= '</td>'; 
                            $html .= '<td>';  
                                $valor_mensual = json_decode($ltpi['valor_mensual']);

                                $html .= '<input type="text" id="vm_cliente" name="vm_cliente_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE"value="'. $valor_mensual->{'cliente'} .'">';

                                $html .= '<input type="text" id="vm_movil" name="vm_movil_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL"value="'. $valor_mensual->{'movil'} .'">';
                            $html .= '</td>';
                            $html .= '<td>';

                                $valor_relevo_sencillo = json_decode($ltpi['valor_relevo_sencillo']);
                                
                                $html .= '<input type="text" id="vrsxr_cliente" name="vrsxr_cliente_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE" value="' . $valor_relevo_sencillo->{'cliente'} .'">';

                                $html .= '<input type="text" id="vrsxr_movil" name="vrsxr_movil_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL" value="' . $valor_relevo_sencillo->{'movil'} .'">';
                            $html .= '</td>';
                            $html .= '<td>';

                                $valor_relevo_doble = json_decode($ltpi['valor_relevo_doble']);
                                
                                $html .= '<input type="text" id="vrdxr_cliente" name="vrdxr_cliente_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE" value="'. $valor_relevo_doble->{'cliente'} .'">';

                                $html .= '<input type="text" id="vrdxr_movil" name="vrdxr_movil_' . strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL" value="'. $valor_relevo_doble->{'movil'} .'">';
                            $html .= '</td>';
                            $html .= '<td>';

                                $costo_por_disponibilidad = json_decode($ltpi['costo_disponibilidad']);
                                
                                $html .= '<input type="text" id="cpd_cliente" name="cpd_cliente_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE" value="'. $costo_por_disponibilidad->{'cliente'} .'">';

                                $html .= '<input type="text" id="cpd_movil" name="cpd_movil_' . strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL" value="'. $costo_por_disponibilidad->{'movil'} .'">';
                            $html .= '</td>';
                            
                        $html .= '</tr>';
		            }

		            for ($i=0; $i < count($tvns) ; $i++) { 
                        $listarClasesMovilClientesID = $operativo->listarClasesMovilClientesID($tvns[$i]);
                        $listarTipoV = $tipoVehiculo->listarPorId($listarClasesMovilClientesID[0]['id_tipo_vehiculo']);

                        $html .= '<tr style="border-bottom: 3px solid #f2f2f2;">';
		                    $html .= '<td id="claseVehiculos" style="color: #274054">';
		                        $html .= '<b>' . strtoupper($listarClasesMovilClientesID[0]['clase_movil_producto']) . ' - ('. $listarTipoV[0]['nombre_tipo_vehiculo'] . ')</b>';
		                        $html .= '<div class="col-12 d-flex justify-content-center mt-2">';
		                            $html .= '<input type="checkbox" name="id_tipo_vehiculo[]" id="id_tipo_vehiculo" value="' . $listarClasesMovilClientesID[0]['id'] . '">';
		                        $html .= '</div>';
		                    $html .= '</td>';
		                    $html .= '<td>';
		                        $html .= '<input type="text" id="vr_cliente" name="vr_cliente_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                        $html .= '<input type="text" id="vr_movil" name="vr_movil_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		                    $html .= '</td>';
		                    $html .= '<td>';
		                        $html .= '<input type="text" id="vh_cliente" name="vh_cliente_' .   strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                        $html .= '<input type="text" id="vh_movil" name="vh_movil_' .   strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		                    $html .= '</td>';
		                    $html .= '<td>';
		                        $html .= '<input type="text" id="rxd_cliente" name="rxd_cliente_' .   strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                        $html .= '<input type="text" id="rxd_movil" name="rxd_movil_' .   strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		                    $html .= '</td>';
		                    $html .= '<td>';
		                        $html .= '<input type="text" id="vm_cliente" name="vm_cliente_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                       $html .= ' <input type="text" id="vm_movil" name="vm_movil_' .  strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		                    $html .= '</td>';
		                    $html .= '<td>';
		                        $html .= '<input type="text" id="vrsxr_cliente" name="vrsxr_cliente_' . strtolower($listarClasesMovilClientesID[0]['id'])  .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                        $html .= '<input type="text" id="vrsxr_movil" name="vrsxr_movil_' . strtolower($listarClasesMovilClientesID[0]['id'])  .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		                    $html .= '</td>';
		                    $html .= '<td>';
		                        $html .= '<input type="text" id="vrdxr_cliente" name="vrdxr_cliente_' . strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                        $html .= '<input type="text" id="vrdxr_movil" name="vrdxr_movil_' . strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		                    $html .= '</td>';
		                    $html .= '<td>';
		                        $html .= '<input type="text" id="cpd_cliente" name="cpd_cliente_' . strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                        $html .= '<input type="text" id="cpd_movil" name="cpd_movil_' . strtolower($listarClasesMovilClientesID[0]['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		                    $html .= '</td>';
		                $html .= '</tr>';
                    }
            $html .= '</tbody>';
        $html .= '</table>';
}else{
	$html .= '<table style="text-align: center; width:100%;">';
        $html .= '<thead>';
            $html .= '<tr>';
                $html .= '<th width="150px;">CLASE VEH.</th>';
                $html .= '<th>VALOR RECORRIDO</th>';
                $html .= '<th>VALOR HORA</th>';
                $html .= '<th>RECORRIDOS X DIA</th>';
                $html .= '<th>VALOR MENSUAL</th>';
                $html .= '<th>VAL. RELEVO SENCILLO X RECORRIDO</th>';
                $html .= '<th>VAL. RELEVO DOBLE X RECORRIDO</th>';
                $html .= '<th>COSTO POR DISPONIBILIDAD</th>';
            $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
			foreach ($listarClasesMovilPorIdCliente as $lcmpic) {
				$listarTvId = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']);

		        $html .= '<tr style="border-bottom: 3px solid #f2f2f2;">';
		            $html .= '<td id="claseVehiculos" style="color: #274054">';
		                $html .= '<b>' . strtoupper($lcmpic['clase_movil_producto']) . ' - ('. $listarTvId[0]['nombre_tipo_vehiculo'] . ')</b>';
		                $html .= '<div class="col-12 d-flex justify-content-center mt-2">';
		                    $html .= '<input type="checkbox" name="id_tipo_vehiculo[]" id="id_tipo_vehiculo" value="' . $lcmpic['id'] . '">';
		                $html .= '</div>';
		            $html .= '</td>';
		            $html .= '<td>';
		                $html .= '<input type="text" id="vr_cliente" name="vr_cliente_' .  strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                $html .= '<input type="text" id="vr_movil" name="vr_movil_' .  strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		            $html .= '</td>';
		            $html .= '<td>';
		                $html .= '<input type="text" id="vh_cliente" name="vh_cliente_' .   strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                $html .= '<input type="text" id="vh_movil" name="vh_movil_' .   strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		            $html .= '</td>';
		            $html .= '<td>';
		                $html .= '<input type="text" id="rxd_cliente" name="rxd_cliente_' .   strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                $html .= '<input type="text" id="rxd_movil" name="rxd_movil_' .   strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		            $html .= '</td>';
		            $html .= '<td>';
		                $html .= '<input type="text" id="vm_cliente" name="vm_cliente_' .  strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		               $html .= ' <input type="text" id="vm_movil" name="vm_movil_' .  strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		            $html .= '</td>';
		            $html .= '<td>';
		                $html .= '<input type="text" id="vrsxr_cliente" name="vrsxr_cliente_' . strtolower($lcmpic['id'])  .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                $html .= '<input type="text" id="vrsxr_movil" name="vrsxr_movil_' . strtolower($lcmpic['id'])  .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		            $html .= '</td>';
		            $html .= '<td>';
		                $html .= '<input type="text" id="vrdxr_cliente" name="vrdxr_cliente_' . strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                $html .= '<input type="text" id="vrdxr_movil" name="vrdxr_movil_' . strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		            $html .= '</td>';
		            $html .= '<td>';
		                $html .= '<input type="text" id="cpd_cliente" name="cpd_cliente_' . strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                $html .= '<input type="text" id="cpd_movil" name="cpd_movil_' . strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		            $html .= '</td>';
		        $html .= '</tr>';
		    }
        $html .= '</tbody>';
    $html .= '</table>';
}


echo $html;

?>

<script>

	function registrarClaseMovil(){
        var caracteristicas = "height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
        nueva = window.open("../Vista/registrarNuevaClaseMovilProducto.php", 'Popup', caracteristicas);
        return false;
    }

    function recargarInformaciónClases(){
        
        var value = $("#id_cliente").val();
        var value2 = $("#id_producto").val();

        var parametros = {
            "id_cliente" : value,
            "id_producto" : value2,
        };

        $.ajax({
            data:  parametros, 
            url:   '../Controlador/listarClasesMovilClientesIdActualizacion.php',
            type:  'POST', 
            beforeSend: function () {
                $("#tabs-2").html("Procesando, espere por favor...");
            },
            success:  function (response) { 
                //alert(response);
                $("#tabs-2").html(response);
            }
        });
    }

</script>