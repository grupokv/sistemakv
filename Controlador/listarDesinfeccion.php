<?php 
require_once("../Modelo/Pre-operacionales.php");

$id = $_POST['id'];

$preoperacional = new PreOperacionales();

$listarId = $preoperacional->listarDesinfeccionId($id);

$html = '';

if (count($listarId) > 0) {

$html .= '<div class="row mb-3">';
	$html .= '<section class="col-12 text-center">';
				$html .= '<h5><strong> PROTOCOLO DESINFECCION </strong></h5>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
				$html .= '<p> REALIZO LAVADO DE MANOS CON JABON Y AGUA? </p>';
	$html .= '</section>';
	if($listarId[0]['lavado_manos'] == 'C'){ $val1 = 'CUMPLE'; } else { $val1 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
		$html .= '<p>' . $val1 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
				$html .= '<p> TIENE LOS ELEMENTOS DE PROTECCION TAPABOCAS Y GUANTES? </p>';
	$html .= '</section>';
	if($listarId[0]['elementos_proteccion'] == 'C'){ $val2 = 'CUMPLE'; } else { $val2 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
		$html .= '<p>' . $val2 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
				$html .= '<p> CUENTA CON DESINFECTANTE EN EL VEHICULO? </p>';
	$html .= '</section>';
	if($listarId[0]['desinfectante'] == 'C'){ $val3 = 'CUMPLE'; } else { $val3 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
		$html .= '<p>' . $val3 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> TIENE BAYETILLAS O TOALLAS DE TELA DE USO PERMANENTE? </p>';
	$html .= '</section>';
	if($listarId[0]['bayetillas'] == 'C'){ $val4 = 'CUMPLE'; } else { $val4 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val4 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO ESCOBA Y TRAPERO? </p>';
	$html .= '</section>';
	if($listarId[0]['escoba'] == 'C'){ $val5 = 'CUMPLE'; } else { $val5 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val5 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO BAYETILLA, TOALLA Y PAPEL DESECHABLE? </p>';
	$html .= '</section>';
	if($listarId[0]['alisto_toalla'] == 'C'){ $val6 = 'CUMPLE'; } else { $val6 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val6 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO BALDE CON AGUA? </p>';
	$html .= '</section>';
	if($listarId[0]['balde'] == 'C'){ $val7 = 'CUMPLE'; } else { $val7 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val7 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO BOLSA PARA RESIDUOS? </p>';
	$html .= '</section>';
	if($listarId[0]['bolsa'] == 'C'){ $val8 = 'CUMPLE'; } else { $val8 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val8 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO PRODUCTOS DE LIMPIEZA Y DESINFECCION? </p>';
	$html .= '</section>';
	if($listarId[0]['productos'] == 'C'){ $val9 = 'CUMPLE'; } else { $val9 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val9 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> BARRIO, SACUDIO Y DESINFECTO LOS TAPETES? </p>';
	$html .= '</section>';
	if($listarId[0]['tapetes'] == 'C'){ $val10 = 'CUMPLE'; } else { $val10 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val10 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> LIMPIO Y DESINFECTO PROTECTOR DE VOLANTE? </p>';
	$html .= '</section>';
	if($listarId[0]['volante'] == 'C'){ $val11 = 'CUMPLE'; } else { $val11 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val11 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> LIMPIO Y DESINFECTO LA ZONA DE PASAJEROS? </p>';
	$html .= '</section>';
	if($listarId[0]['zona_pasajeros'] == 'C'){ $val12 = 'CUMPLE'; } else { $val12 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val12 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> LIMPIO Y DESINFECTO LA ZONA DEL CONDUCTOR? </p>';
	$html .= '</section>';
	if($listarId[0]['zona_conductor'] == 'C'){ $val13 = 'CUMPLE'; } else { $val13 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val13 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> BARRIO, LIMPIO Y DESINFECTO EL PISO DEL VEHICULO? </p>';
	$html .= '</section>';
	if($listarId[0]['piso_vehiculo'] == 'C'){ $val14 = 'CUMPLE'; } else { $val14 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';
	$html .= '<p>' . $val14 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';	
	$html .= '<section class="col-8 text-center">';	
	$html .= '<p> REALIZO ASPERSION? </p>';	
	$html .= '</section>';
	if($listarId[0]['aspersion'] == 'C'){ $val15 = 'CUMPLE'; } else { $val15 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';	
	$html .= '<p>' . $val15 . '</p>';	
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';	
	$html .= '<section class="col-8 text-center">';	
	$html .= '<p> REALIZO DESINFECCION DE LOS ELEMENTOS DE LIMPIEZA Y HIZO DISPOSICION FINAL DE LOS RESIDUOS? </p>';			$html .= '</section>';
	if($listarId[0]['disposicion'] == 'C'){ $val16 = 'CUMPLE'; } else { $val16 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';	
	$html .= '<p>' . $val16 . '</p>';	
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';	
	$html .= '<section class="col-8 text-center">';	
	$html .= '<p> ORGANIZO BODEGA? </p>';	
	$html .= '</section>';
	if($listarId[0]['bodega'] == 'C'){ $val17 = 'CUMPLE'; } else { $val17 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';	
	$html .= '<p>' . $val17 . '</p>';	
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';	
	$html .= '<section class="col-8 text-center">';	
	$html .= '<p> SE LAVO LAS MANOS NUEVAMENTE Y SE HIDRATO? </p>';	
	$html .= '</section>';
	if($listarId[0]['hidratacion'] == 'C'){ $val18 = 'CUMPLE'; } else { $val18 = 'NO CUMPLE'; }
	$html .= '<section class="col-4 text-center">';	
	$html .= '<p>' . $val18 . '</p>';	
	$html .= '</section>';
$html .= '</div>';
}

echo $html;
?>