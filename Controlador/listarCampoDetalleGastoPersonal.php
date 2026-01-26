<?php 

$id_detalle_gasto = $_POST['id_detalle_gasto'];

$html = '<div class="col-12">';
	$html .= '<p style="font-size: 0.8rem;">MOTIVO DE FINALIZACIÓN</p>';
	$html .= '<textarea type="text" class="form-control" aria-label="Novedad de finalización" aria-describedby="basic-addon1" name="novedad_finalizacion" id="novedad_finalizacion" required="true"></textarea>';
	$html .= '<input type="hidden" name="id_detalle_gasto" id="id_detalle_gasto" value="' . $id_detalle_gasto .  '">';
$html .= '</div>';

echo $html;

 ?>
                                                                