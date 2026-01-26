<?php 
require_once("../Modelo/Contrato.php");
require_once("../Modelo/General.php");
$contrato = new Contrato();

$id_contrato = $_POST['id_contrato'];
$tipo_activacion = $_POST['tipo_activacion'];

$mes_especifico = explode("/", $_POST['mes_especifico']);

$listarContratoID = $contrato->listarId($id_contrato);
$fechaContrato = explode("-", $listarContratoID[0]['fecha_inicial_contrato']);
$fecha = $mes_especifico[1] . '-' . $mes_especifico[0] . '-' . $fechaContrato[2];


if($tipo_activacion == 'IC'){
    $fechainicial = new dateTime($listarContratoID[0]['fecha_inicial_contrato']);
}else if ($tipo_activacion == 'ME'){
    $fecha = $mes_especifico[1] . '-' . $mes_especifico[0] . '-' . $fechaContrato[2];
    $fechainicial = new dateTime($fecha);
}

$fechafinal = new dateTime($listarContratoID[0]['fecha_final_contrato']);
$interval = $fechafinal->diff($fechainicial);

$intervalMeses = $interval->format("%m");
$intervalAnos = $interval->format("%y")*12;
$mesesTotal = ($intervalMeses + $intervalAnos);

$html = '';
$fechaAval = "";
$mesesActivacionAvales = "";

$html .= '<div class="col-12">';

    $html .= '<p><b>Fecha Inicial Contrato:</b> ' . $listarContratoID[0]['fecha_inicial_contrato'] . '</p>'; 
    $html .= '<p><b>Fecha Final Contrato:</b> ' . $listarContratoID[0]['fecha_final_contrato'] . '</p>'; 
    $html .= '<hr>'; 

    $cant = 1;
    for ($i=0; $i < $mesesTotal ; $i++) { 
        if($fechaAval == ''){
            if($tipo_activacion == 'IC'){
                $fechaAval = $listarContratoID[0]['fecha_inicial_contrato'];
            }else if ($tipo_activacion == 'ME'){
                $fechaAval = $fecha;
            }
            
        }else{
            $fechaAval = date('Y-m-d', strtotime('+1 month', strtotime($fechaAval)));
        }

        if($cant < $mesesTotal){
            $mesesActivacionAvales .= $fechaAval . '|';
        }else{
            $mesesActivacionAvales .= $fechaAval;
        }
        
        $month = date('m', strtotime($fechaAval));
        $year = date('Y', strtotime($fechaAval));
        $html .= '<p><b><i class="fa fa-calendar-times-o mr-1"></i></b> ' . $fechaAval . ' ○ ' . ucfirst(mes($month)) . ' ' . $year . ' ○ </p>'; 
        $cant = $cant+1;
    }

    $html .= '<input type="hidden" name="mesesAvalActivos" id="mesesAvalActivos" class="form-control" value="' . $mesesActivacionAvales . '" />'; 

$html .= '</div>';

echo $html;

?>