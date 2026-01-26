<?php
require_once "../Modelo/Cartera.php";

$id_vehiculo = $_POST['id_vehiculo'];

$cartera = new Cartera();
$listado = $cartera->listarAcuerdosPorVehiculo($id_vehiculo);
$cant = count($listado);

$listado1 = $cartera->listarComprobantesSinAcuerdos($id_vehiculo);
$cant1 = count($listado1);

$html = '<table class="table table-hover table-sm display" style="width:100%">';
    if($cant > 0){
        
        $html .= '<tr><td colspan="6" align="center"><strong>CON ACUERDO</strong></td></tr>';
        
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
        if($det_comprobante[0]['archivo'] != ''){
            $comprobante = '<a href="../Documentos/Cartera/'.$det_comprobante[0]['archivo'].'" target="_blank">'.$det_comprobante[0]['archivo'].'</a>';
        } else {
            $comprobante = '';
        }
        $html .= '<td>'.$comprobante.'</td>';
        if(($ls['estado'] != 2)and($ls['estado'] != 4)){
            if($ls['comprobante'] != ''){
            $html .= '<td>
                    <a href="javascript:void(0)" title="Cargar Comprobante" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#doc_comprobante" onclick="modalCargarComprobante('.$ls['id_acuerdo'].')">
                    <span class="fa fa-upload"></span>
                    </a>
                </td>';
            } else {
                $html .= '<td>
                    <a href="javascript:void(0)" title="Cargar Comprobante" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#doc_comprobante" onclick="modalCargarComprobante('.$ls['id_acuerdo'].')">
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
    
    if($cant1 > 0){
        
        $html .= '<tr><td colspan="6" align="center"><strong>SIN ACUERDO</strong></td></tr>';
        
        $html .= '<tr>';
        $html .= '<td><strong>VALOR</strong></td>';
        $html .= '<td><strong>FECHA</strong></td>';
        $html .= '<td colspan="2"><strong>COMPROBANTE</strong></td>';
        $html .= '<td><strong>FECHA CARGA</strong></td>';
        $html .= '<td><strong>OPCIONES</strong></td>';
        $html .= '</tr>';
        
        foreach($listado1 as $ls){
        
        $html .= '<tr>';
        $html .= '<td> $ '.number_format($ls['valor'],0,',','.').'</td>';
        $html .= '<td>'.$ls['fecha_pago'].'</td>';
        if($ls['archivo'] != ''){
            $comprobante = '<a href="../Documentos/Cartera/'.$ls['archivo'].'" target="_blank">'.$ls['archivo'].'</a>';
        } else {
            $comprobante = '';
        }
        $html .= '<td colspan="2">'.$comprobante.'</td>';
        $html .= '<td>'.$ls['fecha_carga'].'</td>';
        $html .= '<td></td>';
        }
        $html .= '</tr>';
        
    } else {
        $html .= '<tr><td><p class="text-center"><strong>SIN COMPROBANTES</strong></p></td></tr>';
    }

$html .= '</table>';

echo $html;

?>