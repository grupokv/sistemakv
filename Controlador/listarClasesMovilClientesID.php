<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Operativo.php");

$id_cliente = $_POST['id_cliente'];

$operativo = new Operativo();
$tipoVehiculo = new TipoVehiculo();

$listarClasesMovilPorIdCliente = $operativo->listarClasesMovilPorIdCliente($id_cliente); 
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

if (count($listarClasesMovilPorIdCliente) > 0) {

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
		                        $html .= '<input type="text" id="cpd_cliente" name="cpd_cliente' . strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="CLIENTE">';
		                        $html .= '<input type="text" id="cpd_movil" name="cpd_movil' . strtolower($lcmpic['id']) .'" class="input_tarifas form-control form-control-sm" placeholder="MOVIL">';
		                    $html .= '</td>';
		                $html .= '</tr>';
		            }
            $html .= '</tbody>';
        $html .= '</table>';
}else{
	$html .= '<div class="col-12 text-center">';
		$html .= '<p>EL CLIENTE NO TIENE CLASES ANCLADAS</p>';
	$html .= '</div>';
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
        var parametros = {
            "id_cliente" : value,
        };

        $.ajax({
            data:  parametros, 
            url:   '../Controlador/listarClasesMovilClientesID.php',
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