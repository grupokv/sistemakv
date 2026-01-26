<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Conductor.php");

$conductor = new Conductor();
$listarConductores = $conductor->listar();

echo $cantFilas = $_POST['cant'];

$html = '';

if($cantFilas <= 25){
    $html .= '<tr>';

        $html .= '<td>';
            $html .= '<b><i class="fa fa-file-text-o" stye="font-size: 1.4rem;"></i><b>';
        $html .= '</td>';
        $html .= '<td>';
            $html .= '<input type="text" class="form-control form-control-sm fecha_inventario" id="fecha_inventario' . ($cantFilas + 1) . '" />';
        $html .= '</td>';

        $html .= '<td>'; 
            $html .= '<input type="file" class="form-control form-control-sm" id="doc_inventario' . ($cantFilas + 1) . '" />';
        $html .= '</td>';

        $html .= '<td>';
            $html .= '<select name="id_conductor_entrega[]" id="id_conductor_entrega'. ($cantFilas + 1).'" class="form-control form-control-sm conductor_entrega" data-container="body" data-live-search="true">';
                $html .= '<option value="">SELECCIONAR</option>';
                foreach($listarConductores as $lc){
                    $html .= '<option value="' . $lc['id_conductor'] . '">' . $lc['nombre_conductor'] . ' - ' . $lc['numero_documento_conductor'] .'</option>';
                }
            $html .= '</select>';
        $html .= '</td>';
        
        $html .= '<td>';
            $html .= '<select name="id_conductor_recibe[]" id="id_conductor_recibe'. ($cantFilas + 1) .'" class="form-control form-control-sm conductor_recibo" data-container="body" data-live-search="true">';
                $html .= '<option value="">SELECCIONAR</option>';
                foreach($listarConductores as $lc){
                    $html .= '<option value="' . $lc['id_conductor'] . '">' . $lc['nombre_conductor'] . ' - ' . $lc['numero_documento_conductor'] .'</option>';
                }
            $html .= '</select>';
        $html .= '</td>';

    $html .= '</tr>';
}

       
echo $html;

?>

<script>

    $(function() {
        $(".fecha_inventario").datepicker({dateFormat:'yy-mm-dd'});
    });

</script>