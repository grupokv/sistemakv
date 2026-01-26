<?php 

$id_detalle = $_POST['id_detalle'];

$html = '<div class="col-12">';
	$html .= '<p style="font-size: 0.8rem;">MOTIVO DE FINALIZACIÓN</p>';
	$html .= '<textarea type="text" class="form-control" aria-label="novedad" aria-describedby="basic-addon1" name="novedad" id="novedad" required="true"></textarea>';
	$html .= '<input type="hidden" name="id_detalle" id="id_detalle" value="' . $id_detalle .  '">';
$html .= '</div>';

echo $html;

 ?>
                                                                