<?php 
require_once("../Modelo/Pre-operacionales.php");

$id_preoperacional = $_POST['id_preoperacional'];

$preoperacional = new PreOperacionales();

$listarId = $preoperacional->listarId($id_preoperacional);

$html = '';

if (count($listarId) > 0) {

$html .= '<div class="row mb-3">';
	$html .= '<section class="col-4 text-center">';
		$html .= '<h5><strong> EXTERIOR </strong></h5>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		$html .= '<h5><strong> REQUISITO </strong></h5>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		$html .= '<h5><strong> ESTADO </strong></h5>';
	$html .= '</section>';

$html .= '</div>';


$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
		$html .= '<p> Puertas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		$html .= '<p> Que abran por dentro y por fuera. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['puertas'] == 'C'){ $var1 = 'CUMPLE'; } else { $var1 = 'NO CUMPLE'; }
		$html .= '<p>' . $var1 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Espejos Retrovisores. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sin roturas / Bien Ajustadas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['espejos_retrovisores'] == 'C'){ $var2 = 'CUMPLE'; } else { $var2 = 'NO CUMPLE'; }
		$html .= '<p>' . $var2 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Ventanas </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Vidrios sin roturas / Sin distorsiones o manchas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['ventanas'] == 'C'){ $var3 = 'CUMPLE'; } else { $var3 = 'NO CUMPLE'; }
		$html .= '<p>' . $var3 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Vidrio fontral (Panoramico) </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sin fracturas o chispas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['vidrio_frontal'] == 'C'){ $var4 = 'CUMPLE'; } else { $var4 = 'NO CUMPLE'; }
		$html .= '<p>' . $var4 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Llantas y Rines. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Profundidad de labrado no menor a 2 mm / Presión correcta / Sin cortaduras ni deformaciones. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['llantas_rines'] == 'C'){ $var5 = 'CUMPLE'; } else { $var5 = 'NO CUMPLE'; }
		$html .= '<p>' . $var5 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Llanta de Repuesto. </strong></p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Profundidad de labrado no menor a 2 mm / Presión. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['llanta_repuesto'] == 'C'){ $var6 = 'CUMPLE'; } else { $var6 = 'NO CUMPLE'; }
		$html .= '<p>' . $var6 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Luces delanteras </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Unidades sin roturas / Funcionando. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['luces_delanteras'] == 'C'){ $var7 = 'CUMPLE'; } else { $var7 = 'NO CUMPLE'; }
		$html .= '<p>' . $var7 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Luces de freno </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Encienden al pisar el pedal / Sin roturas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['luces_freno'] == 'C'){ $var8 = 'CUMPLE'; } else { $var8 = 'NO CUMPLE'; }
		$html .= '<p>' . $var8 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Luces de reserva </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Enciende automáticamente al activar la reserva. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['luces_reserva'] == 'C'){ $var9 = 'CUMPLE'; } else { $var9 = 'NO CUMPLE'; }
		$html .= '<p>' . $var9 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Luces de parqueo / Direccionales </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Intermitentes / Encienden al accionar el interruptor, </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['luces_parqueo_direccionales'] == 'C'){ $var10 = 'CUMPLE'; } else { $var10 = 'NO CUMPLE'; }
		$html .= '<p>' . $var10 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sistema de suspensión </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Amortiguadores sin fugas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['sistema_suspension'] == 'C'){ $var11 = 'CUMPLE'; } else { $var11 = 'NO CUMPLE'; }
		$html .= '<p>' . $var11 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sistema de frenos </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Que no presente fugas de liquido de frenos. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['sistema_frenos'] == 'C'){ $var12 = 'CUMPLE'; } else { $var12 = 'NO CUMPLE'; }
		$html .= '<p>' . $var12 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sistema de Dirección </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Que no presente fugas de liquido de aceite hidraulico, juego excesivo en el volante ni ruidos extraños. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['sistema_direccion'] == 'C'){ $var13 = 'CUMPLE'; } else { $var13 = 'NO CUMPLE'; }
		$html .= '<p>' . $var13 . '</p>';
	$html .= '</section>';

$html .= '</div>';

/*COMPARTIMIENTO DEL MOTOR */

$html .= '<div class="row mb-3">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<h5><strong> COMPARTIMIENTO DEL MOTOR </strong></h5>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<h5><strong> REQUISITO </strong></h5>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		$html .= '<h5><strong> ESTADO </strong></h5>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Tapas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Completas y Bien ajustadas.  </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['tapas'] == 'C'){ $var14 = 'CUMPLE'; } else { $var14 = 'NO CUMPLE'; }
		$html .= '<p>' . $var14 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Niveles de aceite de motor. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Niveles de acuerdo al indicador en la varilla. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['niveles_aceite_motor'] == 'C'){ $var15 = 'CUMPLE'; } else { $var15 = 'NO CUMPLE'; }
		$html .= '<p>' . $var15 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Radiador / Ventilador / Correas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sin fugas / Nivel de agua correcto / Hélices completas / Correas tensionadas / Mangueras sin fugas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['radiador_ventilador_correas'] == 'C'){ $var16 = 'CUMPLE'; } else { $var16 = 'NO CUMPLE'; }
		$html .= '<p>' . $var16 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Mangueras. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Conectadas y Sin fugas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['mangueras'] == 'C'){ $var17 = 'CUMPLE'; } else { $var17 = 'NO CUMPLE'; }
		$html .= '<p>' . $var17 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Transmision. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sin fugas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['transmision'] == 'C'){ $var18 = 'CUMPLE'; } else { $var18 = 'NO CUMPLE'; }
		$html .= '<p>' . $var18 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Filtro de aire. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Limpios y Sin humedades. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['filtro_aire'] == 'C'){ $var19 = 'CUMPLE'; } else { $var19 = 'NO CUMPLE'; }
		$html .= '<p>' . $var19 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Fugas de motor. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sin fugas, Ni humedades. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['fugas_motor'] == 'C'){ $var20 = 'CUMPLE'; } else { $var20 = 'NO CUMPLE'; }
		$html .= '<p>' . $var20 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Bomba de freno / Bomba de clutch. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sin fugas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['bomba_freno_clutch'] == 'C'){ $var21 = 'CUMPLE'; } else { $var21 = 'NO CUMPLE'; }
		$html .= '<p>' . $var21 . '</p>';
	$html .= '</section>';

$html .= '</div>';


$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Batería / Bornes / Soporte. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Asegurada / Limpios / Nivel de agua correcto. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['bateria_bornes_soporte'] == 'C'){ $var22 = 'CUMPLE'; } else { $var22 = 'NO CUMPLE'; }
		$html .= '<p>' . $var22 . '</p>';
	$html .= '</section>';

$html .= '</div>';


$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Dirección / Nivel de aceite hidraulico. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sin juego excesivo / Bien alineada / Nivel de aceite ok. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['direccion_nivel_aceite_hidraulico'] == 'C'){ $var23 = 'CUMPLE'; } else { $var23 = 'NO CUMPLE'; }
		$html .= '<p>' . $var23 . '</p>';
	$html .= '</section>';

$html .= '</div>';


$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Deposito de lavaparabrisas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Full que garantice la visibilidad. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['depositivo_lavabrisas'] == 'C'){ $var24 = 'CUMPLE'; } else { $var24 = 'NO CUMPLE'; }
		$html .= '<p>' . $var24 . '</p>';
	$html .= '</section>';

$html .= '</div>';


$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Conexiones electricas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Revisar cables y Conexiones electricas. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['conexiones_electricas'] == 'C'){ $var25 = 'CUMPLE'; } else { $var25 = 'NO CUMPLE'; }
		$html .= '<p>' . $var25 . '</p>';
	$html .= '</section>';

$html .= '</div>';


/* CABINA INTERIOR */

$html .= '<div class="row mb-3">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<h5><strong> INTERIOR DE LA CABINA </strong></h5>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<h5><strong> REQUISITO </strong></h5>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		$html .= '<h5><strong> ESTADO </strong></h5>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Plumillas Limpiavidrios. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Funcionando / Empaques sin desgaste. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['plumillas_limpiavidrios'] == 'C'){ $var26 = 'CUMPLE'; } else { $var26 = 'NO CUMPLE'; }
		$html .= '<p>' . $var26 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Indicadores luces tablero. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Luces frontales altas / Direccionales / Parqueo. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['indicadores_luces_tablero'] == 'C'){ $var27 = 'CUMPLE'; } else { $var27 = 'NO CUMPLE'; }
		$html .= '<p>' . $var27 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Indicador de velocidad. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> La aguja indica la velocidad al transitar (Rodando). </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['indicador_velocidad'] == 'C'){ $var28 = 'CUMPLE'; } else { $var28 = 'NO CUMPLE'; }
		$html .= '<p>' . $var28 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Indicador de combustible. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> La aguja muestra el nivel de combustible. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['indicador_combustible'] == 'C'){ $var29 = 'CUMPLE'; } else { $var29 = 'NO CUMPLE'; }
		$html .= '<p>' . $var29 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Indicador de aceite motor. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Enciende al iniciar el motor. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['indicador_aceite_motor'] == 'C'){ $var30 = 'CUMPLE'; } else { $var30 = 'NO CUMPLE'; }
		$html .= '<p>' . $var30 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Pito. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Funcionando / Se oye a unas distancia de 50 m.</p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['pito'] == 'C'){ $var31 = 'CUMPLE'; } else { $var31 = 'NO CUMPLE'; }
		$html .= '<p>' . $var31 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Freno de emergencia. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Prueba antes del arranque. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['freno_emergencia'] == 'C'){ $var32 = 'CUMPLE'; } else { $var32 = 'NO CUMPLE'; }
		$html .= '<p>' . $var32 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Pito reversa. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Funciona automáticamente con la reversa. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['pito_reserva'] == 'C'){ $var33 = 'CUMPLE'; } else { $var33 = 'NO CUMPLE'; }
		$html .= '<p>' . $var33 . '</p>';
	$html .= '</section>';

$html .= '</div>';


$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Botiquin. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Sin elementos vencidos. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['botiquin'] == 'C'){ $var34 = 'CUMPLE'; } else { $var34 = 'NO CUMPLE'; }
		$html .= '<p>' . $var34 . '</p>';
	$html .= '</section>';

$html .= '</div>';


$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Equipo de carretera. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Un (1) gato, Dos (2) tacos, Dos (2) señales en forma de triangulo,  Copa de ruedas o cruceta herramienta, Botiquín, Extintor  y Una (1) linterna de mano con baterías. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['equipo_carretera'] == 'C'){ $var35 = 'CUMPLE'; } else { $var35 = 'NO CUMPLE'; }
		$html .= '<p>' . $var35 . '</p>';
	$html .= '</section>';

$html .= '</div>';


$html .= '<div class="row">';
	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Kilometraje. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
				$html .= '<p> Kilometraje del vehiculo en el momento de la revision. </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		$html .= '<p>' . $listarId[0]['kilometraje'] . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row mb-3">';
	$html .= '<section class="col-12 text-center">';
				$html .= '<h5><strong> PROTOCOLO DESINFECCION </strong></h5>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
				$html .= '<p> REALIZO LAVADO DE MANOS CON JABON Y AGUA? </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['lavado_manos'] == 'C'){ $var36 = 'CUMPLE'; } else { $var36 = 'NO CUMPLE'; }
		$html .= '<p>' . $var36 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
				$html .= '<p> TIENE LOS ELEMENTOS DE PROTECCION TAPABOCAS Y GUANTES? </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['elementos_proteccion'] == 'C'){ $var37 = 'CUMPLE'; } else { $var37 = 'NO CUMPLE'; }
		$html .= '<p>' . $var37 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
				$html .= '<p> CUENTA CON DESINFECTANTE EN EL VEHICULO? </p>';
	$html .= '</section>';

	$html .= '<section class="col-4 text-center">';
		if($listarId[0]['desinfectante'] == 'C'){ $var38 = 'CUMPLE'; } else { $var38 = 'NO CUMPLE'; }
		$html .= '<p>' . $var38 . '</p>';
	$html .= '</section>';

$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> TIENE BAYETILLAS O TOALLAS DE TELA DE USO PERMANENTE? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['bayetillas'] == 'C'){ $var39 = 'CUMPLE'; } else { $var39 = 'NO CUMPLE'; }
	$html .= '<p>' . $var39 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO ESCOBA Y TRAPERO? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['escoba'] == 'C'){ $var40 = 'CUMPLE'; } else { $var40 = 'NO CUMPLE'; }
	$html .= '<p>' . $var40 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO BAYETILLA, TOALLA Y PAPEL DESECHABLE? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['alisto_toalla'] == 'C'){ $var41 = 'CUMPLE'; } else { $var41 = 'NO CUMPLE'; }
	$html .= '<p>' . $var41 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO BALDE CON AGUA? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['balde'] == 'C'){ $var42 = 'CUMPLE'; } else { $var42 = 'NO CUMPLE'; }
	$html .= '<p>' . $var42 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO BOLSA PARA RESIDUOS? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['bolsa'] == 'C'){ $var43 = 'CUMPLE'; } else { $var43 = 'NO CUMPLE'; }
	$html .= '<p>' . $var43 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> ALISTO PRODUCTOS DE LIMPIEZA Y DESINFECCION? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['productos'] == 'C'){ $var44 = 'CUMPLE'; } else { $var44 = 'NO CUMPLE'; }
	$html .= '<p>' . $var44 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> BARRIO, SACUDIO Y DESINFECTO LOS TAPETES? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['tapetes'] == 'C'){ $var45 = 'CUMPLE'; } else { $var45 = 'NO CUMPLE'; }
	$html .= '<p>' . $var45 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> LIMPIO Y DESINFECTO PROTECTOR DE VOLANTE? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['volante'] == 'C'){ $var46 = 'CUMPLE'; } else { $var46 = 'NO CUMPLE'; }
	$html .= '<p>' . $var46 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> LIMPIO Y DESINFECTO LA ZONA DE PASAJEROS? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['zona_pasajeros'] == 'C'){ $var47 = 'CUMPLE'; } else { $var47 = 'NO CUMPLE'; }
	$html .= '<p>' . $var47 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> LIMPIO Y DESINFECTO LA ZONA DEL CONDUCTOR? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['zona_conductor'] == 'C'){ $var48 = 'CUMPLE'; } else { $var48 = 'NO CUMPLE'; }
	$html .= '<p>' . $var48 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';
	$html .= '<section class="col-8 text-center">';
	$html .= '<p> BARRIO, LIMPIO Y DESINFECTO EL PISO DEL VEHICULO? </p>';
	$html .= '</section>';
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['piso_vehiculo'] == 'C'){ $var49 = 'CUMPLE'; } else { $var49 = 'NO CUMPLE'; }
	$html .= '<p>' . $var49 . '</p>';
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';	
	$html .= '<section class="col-8 text-center">';	
	$html .= '<p> REALIZO ASPERSION? </p>';	
	$html .= '</section>';	
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['aspersion'] == 'C'){ $var50 = 'CUMPLE'; } else { $var50 = 'NO CUMPLE'; }
	$html .= '<p>' . $var50 . '</p>';	
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';	
	$html .= '<section class="col-8 text-center">';	
	$html .= '<p> REALIZO DESINFECCION DE LOS ELEMENTOS DE LIMPIEZA Y HIZO DISPOSICION FINAL DE LOS RESIDUOS? </p>';			$html .= '</section>';	
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['disposicion'] == 'C'){ $var51 = 'CUMPLE'; } else { $var51 = 'NO CUMPLE'; }
	$html .= '<p>' . $var51 . '</p>';	
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';	
	$html .= '<section class="col-8 text-center">';	
	$html .= '<p> ORGANIZO BODEGA? </p>';	
	$html .= '</section>';	
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['bodega'] == 'C'){ $var52 = 'CUMPLE'; } else { $var52 = 'NO CUMPLE'; }
	$html .= '<p>' . $var52 . '</p>';	
	$html .= '</section>';
$html .= '</div>';

$html .= '<div class="row">';	
	$html .= '<section class="col-8 text-center">';	
	$html .= '<p> SE LAVO LAS MANOS NUEVAMENTE Y SE HIDRATO? </p>';	
	$html .= '</section>';	
	$html .= '<section class="col-4 text-center">';
	if($listarId[0]['hidratacion'] == 'C'){ $var53 = 'CUMPLE'; } else { $var53 = 'NO CUMPLE'; }
	$html .= '<p>' . $var53 . '</p>';	
	$html .= '</section>';
$html .= '</div>';

}

echo $html;
?>