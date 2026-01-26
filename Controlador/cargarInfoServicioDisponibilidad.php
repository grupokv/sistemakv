<?php

include("Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");

$id = $_POST['id'];
$tipo = $_POST['tipo'];

$operativo = new Operativo();
$usuario = new Usuario();
$cliente = new Cliente();

if($tipo == 'mtto'){
    $result = $operativo->listarControlMantenimientosID($id);
}else if($tipo == 'servicio'){
    $result = $operativo->listarServiciosPorID($id);
}

$html = '';

if(count($result) > 0){
   
    $html .= '<div class="col-12">';
        $html .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i aria-hidden="true">&times;</i></button>';
        $html .= '<b style="font-size:1.2rem;"><i class="fa fa-info-circle mr-2"></i>DETALLE - ' . $id . '</b>';
    $html .= '</div>';
 
    if($tipo == 'servicio'){

        foreach ($result as $r) {
            $cliente_ID = $cliente->cliente_ID($r['id_cliente']);
            $listarUsuarioPorId = $usuario->listarUsuarioPorId($r['id_usuario_creador']);
            $listarProductosPorID = $operativo->listarProductosPorID($r['id_producto']);
            
            $html .= '<div class="row p-4">';
                $html .= '<section class="col-12">';
                    
                    $html .= '<div class="row mb-1">';

                        $html .= '<div class="col-6 text-center p-1" style="border-right: 1px dashed #d3d3d3; ">';
                            $html .= '<p>' . $cliente_ID[0]['razon_social']. '</p>';
                        $html .= '</div>';

                        $html .= '<div class="col-6 text-center">';
                            $html .= '<label>REGISTRADO POR: ' . $listarUsuarioPorId[0]['nombre']. '</label>';
                        $html .= '</div>';

                    $html .= '</div>';

                    $html .= '<div class="row mb-1" style="border: 1px dashed #d3d3d3;">';
                        $html .= '<label class="col-12 ml-4 mt-2"><b>Producto: </b>'. $listarProductosPorID[0]['detalle_producto'] .'</label>';
                    $html .= '</div>';
                    
                    $html .= '<div class="row mb-1" style="border: 1px dashed #d3d3d3;">';
                        $html .= '<label class="col-12 ml-4 mt-2"><b>Tipo Servicio: </b> SERVICIO '. $r['tipo_servicio'] .'</label>';
                    $html .= '</div>';
                    
                    $html .= '<div class="row mb-1 text-center p-1" style="border: 1px dashed #d3d3d3;">';

                        $fecha1 = explode("-", $r['fecha_inicio']);
                        
                        $html .= '<div class="col-6">';
                            $html .= '<label><b>Fecha - Hora Inicial</b></label>';
                            $html .= '<p class="text-center">'. $fecha1[2].' DE '. strtoupper(mes($fecha1[1])) .' DEL '. $fecha1[0] . ' - ' . strtoupper(date('g:i a', strtotime($r['hora_inicio']))) .'</p>';
                        $html .= '</div>';

                        $fecha2 = explode("-", $r['fecha_final']);

                        $html .= '<div class="col-6">';
                            $html .= '<label ><b>Fecha - Hora Final</b></label>';
                            $html .= '<p class="text-center">'. $fecha2[2].' DE '. strtoupper(mes($fecha2[1])) .' DEL '. $fecha2[0] . ' - ' . strtoupper(date('g:i a', strtotime($r['hora_final']))) .'</p>';
                        $html .= '</div>';

                    $html .= '</div>';
                    
                    $html .= '<div class="row mb-1 text-center p-1" style="border: 1px dashed #d3d3d3;">';

                        $html .= '<div class="col-6">';
                            $html .= '<label><b>Origen</b></label>';
                            $html .= '<p class="text-center">' . $r['origen'] . '</p>';
                        $html .= '</div>';

                        $html .= '<div class="col-6">';
                            $html .= '<label ><b>Destino</b></label>';
                            $html .= '<p class="text-center">' . $r['destino'] . '</p>';
                        $html .= '</div>';

                    $html .= '</div>';

                $html .= '</section>';
            $html .= '</div>';  
        }

    }else if($tipo == 'mtto'){

        foreach ($result as $r) {

            $html .= '<div class="row p-4">';
                $html .= '<section class="col-12">';
                    $html .= '<div class="row mb-1">';

                        $html .= '<div class="col-12 pl-3 pt-3 mb-1" style="border: 1px dashed #d3d3d3; ">';
                            if($r['estado'] == 1){
                                $html .= '<p><b>Estado: </b> EN PROCESO</p>';
                            }else{
                                $html .= '<p><b>Estado: </b> FINAZALIDO</p>';
                            }
                        $html .= '</div>';

                        $html .= '<div class="col-12 pl-3 pt-3 mb-1" style="border: 1px dashed #d3d3d3; ">';
                                $html .= '<p><b>Tipo Servicio: </b>' . $r['tipo_servicio'] . '</p>';
                        $html .= '</div>';
                        
                        $html .= '<div class="col-12 pl-3 pt-3 mb-1" style="border: 1px dashed #d3d3d3; ">';
                                $html .= '<p><b>Enviado Por: </b>' . $r['enviado_por'] . '</p>';
                        $html .= '</div>';
                        
                        $html .= '<div class="col-12 pl-3 pt-3 mb-1" style="border: 1px dashed #d3d3d3; ">';
                                $html .= '<p><b>Fecha: </b>' . $r['fecha_mtto'] . '</p>';
                        $html .= '</div>';
                        
                        $html .= '<div class="col-12 pl-3 pt-3 mb-1" style="border: 1px dashed #d3d3d3; ">';
                                $html .= '<p><b>Detalle: </b>' . $r['detalle_mtto'] . '</p>';
                        $html .= '</div>';
                        
                        $html .= '<div class="col-12 pl-3 pt-3 mb-1" style="border: 1px dashed #d3d3d3; ">';
                                $html .= '<p><b>Valor: </b> $ ' . number_format($r['valor_mtto']) . ' COP</p>';
                        $html .= '</div>';
                        
                        $html .= '<div class="col-12 pl-3 pt-3 mb-1" style="border: 1px dashed #d3d3d3; ">';
                                $html .= '<p><b>Forma de Pago: </b>' . $r['forma_pago'] . '</p>';
                        $html .= '</div>';

                    $html .= '</div>';
                $html .= '</section>';
            $html .= '</div>';

        }
    }
}

echo $html;

?>