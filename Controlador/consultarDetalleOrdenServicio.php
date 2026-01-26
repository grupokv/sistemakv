<?php 

include("../Controlador/Sesion/autenticar.php");

require_once ("../Modelo/Subcategoria_Mantenimiento.php");
require_once ("../Modelo/TipoServicioMantenimiento.php");
require_once ("../Modelo/Categoria_Mantenimiento.php");
require_once ("../Modelo/ProveedorMantenimiento.php");
require_once ("../Modelo/OrdenServicio.php");
require_once ("../Modelo/Vehiculo.php");


$tipoServicioMantenimiento = new TipoServicioMantenimiento();
$subcategoria = new Subcategoria_Mantenimiento();
$categoria = new Categoria_Mantenimiento();
$proveedor = new ProveedorMantenimiento();
$orden = new OrdenServicio();
$vehiculo = new Vehiculo();

$id_orden = $_POST['id_orden'];

$listarPorId = $orden->listarPorId($id_orden);
$datos_v = $vehiculo->listarPorId($listarPorId[0]['id_vehiculo']);
$datos_p = $proveedor->listarPorId($listarPorId[0]['id_proveedor']);
$listarTS = $tipoServicioMantenimiento->listarPorId($listarPorId[0]['id_tipo_servicio']);

$detallePorIdOrden = $orden->detallePorIdOrden($id_orden);

$html = "";

if (count($listarPorId) > 0 ){
    $html .= '<h5 class="modal-title text-center" id="exampleModalLabel"><strong>INFORMACIÓN DE LA ORDEN DE SERVICIO</strong></h5>';
    
    $html .= '<hr>';
        $html .= '<section class="row">';
            $html .= '<div class="col-3 text-center">';
                $html .= '<strong><p>PLACA VEHICULO</p></strong>';
                $html .= '<p>' . $datos_v[0]['placa'] . '</p>';
            $html .= '</div>';

            $html .= '<div class="col-3 text-center">';
                $html .= '<strong><p>N° MOVIL</p></strong>';
                $html .= '<p>' . $datos_v[0]['numero_movil'] .'</p>';
            $html .= '</div>';

            $html .= '<div class="col-3 text-center">';
               $html .= '<strong><p>TIPO COMBUSTIBLE</p></strong>';
                $html .= '<p>' .  $listarPorId[0]['tipo_combustible'].'</p>';
            $html .= '</div> ';

            $html .= '<div class="col-3 text-center">';
                $html .= '<strong><p>PROVEEDOR</p></strong>';
                $html .= '<p>'. $datos_p[0]['razon_social']. '</p>';
            $html .= '</div>';
        $html .= '</section>';


        $html .= '<section class="row">';
            $html .= '<div class="col-3 text-center">';
                $html .= '<strong><p>TIPO SERVICIO</p></strong>';
                $html .= '<p>' . $listarTS[0]['detalle_tipo'] . '</p>';
            $html .= '</div>';

            $html .= '<div class="col-3 text-center">';
                $html .= '<strong><p>SOLICITADO POR</p></strong>';
                $html .= '<p>' .  $listarPorId[0]['solicitado_por'] . '</p>';
            $html .= '</div>';

            $html .= '<div class="col-3 text-center">';
                $html .= '<strong><p>DETALLE</p></strong>';
                $html .= '<p>' .  strtoupper($listarPorId[0]['detalle']) . '</p>';
            $html .= '</div> ';

            $html .= '<div class="col-3 text-center">';
                $html .= '<strong><p>VALOR TOTAL</p></strong>';
                $html .= '<p> $ ' .  number_format($listarPorId[0]['valor_total']) . '</p>';
            $html .= '</div>';

        $html .= '</section>';

        $html .= '<section class="row d-flex justify-content-center">';

            $html .= '<div class="col-3 text-center">';
                $html .= '<strong><p>FECHA INCIAL</p></strong>';
                $html .= '<p>' .  $listarPorId[0]['fecha_inicial'] . '</p>';
            $html .= '</div>';

            $html .= '<div class="col-3 text-center">';
                $html .= '<strong><p>FECHA FINAL</p></strong>';
                $html .= '<p>' .  $listarPorId[0]['fecha_final'] . '</p>';
            $html .= '</div>';


        $html .= '</section>';

        if(count($detallePorIdOrden) > 0){
            $html .= '<hr>';

            $html .= '<h5 class="modal-title text-center" id="exampleModalLabel">DETALLE DEL SERVICIO</h5>';
            
            $html .= '<hr>';

            foreach ($detallePorIdOrden as $dpio) {

                $listarCategoriasId = $categoria->listarPorId($dpio['id_categoria']);
                $listarSubcategoriasId = $subcategoria->listarPorId($dpio['id_subcategoria']); 
                                                        
                $html .= '<section class="row d-flex justify-content-around">';

                    $html .= '<div class="col-3 text-center">';
                        $html .= '<strong><p>CATEGORIA</p></strong>';
                        $html .= '<p>' .  $listarCategoriasId[0]['detalle_categoria'] . '</p>';
                    $html .= '</div>';

                    $html .= '<div class="col-3 text-center">';
                        $html .= '<strong><p>SUB CATEGORIA</p></strong>';
                        $html .= '<p>' .  $listarSubcategoriasId[0]['detalle_subcategoria'] . '</p>';
                    $html .= '</div> ';

                    $html .= '<div class="col-3 text-center">';
                        $html .= '<strong><p>VALOR</p></strong>';
                        $html .= '<p> $ ' .  number_format($dpio['valor']) . '</p>';
                    $html .= '</div> ';

                $html .= '</section>';
            }
        }



}


echo $html;


?>

