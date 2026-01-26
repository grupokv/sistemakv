<?php
require_once "../Modelo/Cartera.php";

$id_vehiculo = $_POST['id_vehiculo'];

$cartera = new Cartera();
$listado = $cartera->listarAcuerdosPorVehiculo($id_vehiculo);
$cant = count($listado);

$html = '<table class="table table-hover table-sm display" style="width:100%">';
    if($cant > 0){
        
        $html .= '<tr>';
        $html .= '<td><strong>VALOR</strong></td>';
        $html .= '<td><strong>FECHA</strong></td>';
        $html .= '<td><strong>ESTADO</strong></td>';
        $html .= '<td><strong>ACUERDO FIRMADO</strong></td>';
        $html .= '<td><strong>COMPROBANTE</strong></td>';
        $html .= '<td><strong>OPCIONES</strong></td>';
        $html .= '</tr>';
        
        foreach($listado as $ls){
        
        $html .= '<tr>';
        $html .= '<td> $ '.number_format($ls['valor'],0,',','.').'</td>';
        $html .= '<td>'.$ls['fecha_pago'].'</td>';
        $det_estado = $cartera->listarPorIdEstadoAcuerdosPago($ls['estado']);
        $html .= '<td>'.$det_estado[0]['detalle'].'</td>';
        if($ls['doc_firmado'] != ''){
            $acuerdo_firmado = '<a href="../Documentos/Cartera/'.$ls['doc_firmado'].'" target="_blank">'.$ls['doc_firmado'].'</a>';
        } else {
            $acuerdo_firmado = '';
        }
        $html .= '<td>'.$acuerdo_firmado.'</td>';
        $det_comprobante = $cartera->listarComprobantePorAcuerdo($ls['id_acuerdo']);
        if($det_comprobante[0]['estado'] == 2){
            $comprobante = '<a href="../Documentos/Cartera/'.$det_comprobante[0]['archivo'].'" target="_blank">'.$det_comprobante[0]['archivo'].'</a>';
        } else {
            $comprobante = '';
        }
        $html .= '<td>'.$comprobante.'</td>';
        if(($ls['estado'] != 2)and($ls['estado'] != 4)){
            if($ls['doc_firmado'] != ''){
            $html .= '<td>
                    <a href="javascript:void(0)" title="Cargar Acuerdo Firmado" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#doc_firmado" onclick="modalCargarDoc('.$ls['id_acuerdo'].')">
                    <span class="fa fa-upload"></span>
                    </a>
                    <a href="javascript:void(0)" title="Pagado" class="btn btn-sm btn-outline-success" onclick="acuerdoPagado('.$ls['id_acuerdo'].')">
                    <span class="fa fa-check"></span>
                    </a>
                    <a href="javascript:void(0)" title="Cancelar" class="btn btn-sm btn-outline-danger" onclick="acuerdoCancelado('.$ls['id_acuerdo'].')">
                    <span class="fa fa-trash"></span>
                    </a>
                </td>';
            } else {
                $html .= '<td>
                    <a href="javascript:void(0)" title="Cargar Acuerdo Firmado" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#doc_firmado" onclick="modalCargarDoc('.$ls['id_acuerdo'].')">
                    <span class="fa fa-upload"></span>
                    </a>
                </td>';
            }
                
        } else {
        $html .= '<td></td>';
        }
        $html .= '</tr>';
        
        }
        
        
    }else{
            $html .= '<tr><td><p class="text-center"><strong>SIN ACUERDOS</strong></p></td></tr>';
    } 

$html .= '</table>';

echo $html;

?>