<?php 

$id_agenda = $_POST['id_agenda'];
$id_acta = $_POST['id_acta'];

$html = '';

$html .= '<div class="modal" id="modal" tabindex="-1" role="dialog" style="display: block;">';
    $html .= '<div class="modal-dialog" role="document">';
        $html .= '<div class="modal-content">';
            $html .= '<div class="modal-header">';
                $html .= '<h5 class="modal-title">Eliminar Tema N°' . $id_agenda .'</h5>';
                $html .= '<button type="button" class="close" onclick="cerrar_modal();" aria-label="Close">';
                    $html .= '<span aria-hidden="true">&times;</span>';
                $html .= '</button>';
            $html .= '</div>';
            $html .= '<div class="modal-body">';
                $html .= '<p class="text-center">¿Esta seguro de eliminar este registro?</p>';
            $html .= '</div>';
            $html .= '<div class="modal-footer">';
                $html .= '<button type="button" class="btn btn-danger" onclick="cerrar_modal();">Cancelar</button>';
                $html .= '<a href="../Controlador/borrarTema.php?id_agenda='. $id_agenda .'&id_acta=' . $id_acta . '" class="btn btn-success">Eliminar</a>';
            $html .= '</div>';
        $html .= '</div>';
    $html .= '</div>';
$html .= '</div>';

echo $html;

 ?>