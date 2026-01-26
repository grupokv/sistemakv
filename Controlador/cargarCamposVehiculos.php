<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Propietario.php");
require_once ("../Modelo/Conductor.php");

$propietario = new Propietario();
$listarPropietarios = $propietario->listarPropietarios();

$conductor = new Conductor();
$listarConductores = $conductor->listar();


$cant = $_POST['cant'];
$tipo = $_POST['tipo'];

$html = '';

if($tipo == 'prop'){

    $typeRow = "'prop'";
    $html .= '<section class="d-flex justify-content-center">';
        $html .= '<div  id="botones" class="row m-3">';
            $html .= '<button class="btn btn-outline-danger mr-3" onclick="eliminarFila('.$typeRow.');" type="button" style="margin: 0px; padding: 5px 6px 5px 6px;"> Eliminar fila <i class="fa fa-trash ml-2" style="font-size: 1.2rem;"></i></button>';
            $html .= '<button class=" btn btn-outline-success" onclick="agregarFila('.$typeRow.');" type="button" style="margin: 0px; padding: 5px 6px 5px 6px;"> Agregar Fila <i class="fa fa-plus-circle ml-2" style="font-size: 1.2rem;"></i></button>';
        $html .= '</div>';
    $html .= '</section>';

    $html .= '<table id="tableProp" class="table">';
        for ($i=1; $i <= $cant; $i++) { 
            $html .= '<tr>';
                $html .= '<td><i class="fa fa-user-circle" style="color:#1b2d3b;"></i></td>';
                $html .= '<td>Propietario '.$i.'</td>';
                $html .= '<td>';
                    $html .= '<select name="propietario[]" id="propietario'.$i.'" class="form-control form-control-sm propietario" data-container="body" data-live-search="true">';
                        $html .= '<option value="">SELECCIONAR</option>';
                        foreach($listarPropietarios as $lp){
                            $html .= '<option value="' . $lp['id_propietario'] . '">' . $lp['nombre'] . ' - ' . $lp['numero_documento'] .'</option>';
                        }
                    $html .= '</select>';
                $html .= '</td>';
            $html .= '</tr>';
        }
    $html .= '</table>';

}else if($tipo == 'tene'){
    
    $typeRow = "'tene'";
    $html .= '<section class="d-flex justify-content-center">';
        $html .= '<div  id="botones" class="row m-3">';
            $html .= '<button class="btn btn-outline-danger mr-3" onclick="eliminarFila('.$typeRow.');" type="button" style="margin: 0px; padding: 5px 6px 5px 6px;"> Eliminar fila <i class="fa fa-trash ml-2" style="font-size: 1.2rem;"></i></button>';
            $html .= '<button class=" btn btn-outline-success" onclick="agregarFila('.$typeRow.');" type="button" style="margin: 0px; padding: 5px 6px 5px 6px;"> Agregar Fila <i class="fa fa-plus-circle ml-2" style="font-size: 1.2rem;"></i></button>';
        $html .= '</div>';
    $html .= '</section>';

    $html .= '<table id="tableTene" class="table">';
        for ($i=1; $i <= $cant; $i++) { 
            $html .= '<tr>';
                $html .= '<td><i class="fa fa-user-circle" style="color:#1b2d3b;"></i></td>';
                $html .= '<td>Tenedor '.$i.'</td>';
                $html .= '<td>';
                    $html .= '<select name="tenedor[]" id="tenedor'.$i.'" class="form-control form-control-sm tenedor" data-container="body" data-live-search="true">';
                        $html .= '<option value="">SELECCIONAR</option>';
                        foreach($listarPropietarios as $lp){
                            $html .= '<option value="' . $lp['id_propietario'] . '">' . $lp['nombre'] . ' - ' . $lp['numero_documento'] .'</option>';
                        }
                    $html .= '</select>';
                $html .= '</td>';
            $html .= '</tr>';
        }
    $html .= '</table>';

}else if($tipo == 'cond'){

    $typeRow = "'cond'";
    $html .= '<section class="d-flex justify-content-center">';
        $html .= '<div  id="botones" class="row m-3">';
            $html .= '<button class="btn btn-outline-danger mr-3" onclick="eliminarFila('.$typeRow.');" type="button" style="margin: 0px; padding: 5px 6px 5px 6px;"> Eliminar fila <i class="fa fa-trash ml-2" style="font-size: 1.2rem;"></i></button>';
            $html .= '<button class=" btn btn-outline-success" onclick="agregarFila('.$typeRow.');" type="button" style="margin: 0px; padding: 5px 6px 5px 6px;"> Agregar Fila <i class="fa fa-plus-circle ml-2" style="font-size: 1.2rem;"></i></button>';
        $html .= '</div>';
    $html .= '</section>';

    $html .= '<table id="tableCond" class="table">';
        for ($i=1; $i <= $cant; $i++) { 
            $html .= '<tr>';
                $html .= '<td><i class="fa fa-user-circle" style="color:#1b2d3b;"></i></td>';
                $html .= '<td>Conductor '.$i.'</td>';
                $html .= '<td>';
                    $html .= '<select name="conductor[]" id="conductor'.$i.'" class="form-control form-control-sm conductor" data-container="body" data-live-search="true">';
                        $html .= '<option value="">SELECCIONAR</option>';
                        foreach($listarConductores as $lc){
                            $html .= '<option value="' . $lc['id_conductor'] . '">' . $lc['nombre_conductor'] . ' - ' . $lc['numero_documento_conductor'] .'</option>';
                        }
                    $html .= '</select>';
                $html .= '</td>';
            $html .= '</tr>';
        }
    $html .= '</table>';

}

echo $html;

?>