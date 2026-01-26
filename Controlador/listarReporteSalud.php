<?php
require_once "../Modelo/Salud.php";
require_once "../Modelo/Usuario.php";
require_once "../Modelo/Contrato.php";
require_once "../Modelo/Cliente.php";

$id = $_POST['id'];
$salud = new Salud();
$listarConId = $salud->listarPorId($id);

$usuario = new Usuario();
$datos_usu = $usuario->listarUsuarioPorId($listarConId[0]['id_usuario']);

$contrato = new Contrato();
$cliente = new Cliente();

$cant = count($listarConId);
date_default_timezone_set('America/Bogota');

if($listarConId[0]['contrato'] == 0){
	$det_contrato = 'ADMINISTRATIVO';
} else {
	$datos_contrato = $contrato->listarId($listarConId[0]['contrato']);
	$datos_cliente = $cliente->cliente_ID($datos_contrato[0]['id_cliente']);
	$det_contrato = $listarConId[0]['contrato'].' - '.$datos_cliente[0]['nombre'];
}

$html = '<ul><table border="0" width="95%">';

if($cant > 0){
	foreach($listarConId as $lci){
	    
		$html .= '<tr><td width="60%"><strong>Nombre:</strong></td><td>'.$datos_usu[0]['nombre'].'</td></tr>';
		$html .= '<tr><td><strong>Numero Documento:</strong></td><td>'.$datos_usu[0]['usuario'].'</td></tr>';
		$html .= '<tr><td><strong>Correo Electronico:</strong></td><td>'.$lci['email'].'</td></tr>';
		$html .= '<tr><td><strong>Numero Celular:</strong></td><td>'.$lci['celular'].'</td></tr>';
		$html .= '<tr><td><strong>Direccion:</strong></td><td>'.$lci['direccion'].'</td></tr>';
		$html .= '<tr><td><strong>Empresa:</strong></td><td>'.$lci['empresa'].'</td></tr>';
		$html .= '<tr><td><strong>Fecha Nacimiento:</strong></td><td>'.$lci['fechanac'].'</td></tr>';
		$html .= '<tr><td><strong>EPS:</strong></td><td>'.$lci['eps'].'</td></tr>';
		$html .= '<tr><td><strong>ARL:</strong></td><td>'.$lci['arl'].'</td></tr>';
		$html .= '<tr><td><strong>Cargo:</strong></td><td>'.$lci['cargo'].'</td></tr>';
		$html .= '<tr><td><strong>Contrato:</strong></td><td>'.$det_contrato.'</td></tr>';
		$html .= '<tr><td><strong>Medio de Transporte:</strong></td><td>'.$lci['transporte'].'</td></tr>';
		$html .= '<tr><td><strong>Nombre Persona Contacto:</strong></td><td>'.$lci['nombre_contacto'].'</td></tr>';
		$html .= '<tr><td><strong>Telefono Persona Contacto:</strong></td><td>'.$lci['tel_contacto'].'</td></tr>';
		$html .= '<tr><td colspan="2"><hr/></td></tr>';
		$html .= '<tr align="center"><td colspan="2"><b>Le han diagnosticado alguna de estas enfermedades?</b></td></tr>';
		$html .= '<tr><td><strong>Hipertension:</strong></td><td>'.$lci['hipertension'].'</td></tr>';
		$html .= '<tr><td><strong>EPOC:</strong></td><td>'.$lci['epoc'].'</td></tr>';
		$html .= '<tr><td><strong>Cancer:</strong></td><td>'.$lci['cancer'].'</td></tr>';
		$html .= '<tr><td><strong>Diabetes:</strong></td><td>'.$lci['diabetes'].'</td></tr>';
		$html .= '<tr><td><strong>VIH:</strong></td><td>'.$lci['vih'].'</td></tr>';
		$html .= '<tr><td><strong>Cardiaca:</strong></td><td>'.$lci['cardiaca'].'</td></tr>';
		$html .= '<tr><td><strong>Renal:</strong></td><td>'.$lci['renal'].'</td></tr>';
		$html .= '<tr><td><strong>Asma:</strong></td><td>'.$lci['asma'].'</td></tr>';
		$html .= '<tr><td><strong>Ninguna:</strong></td><td>'.$lci['ninguna'].'</td></tr>';
		$html .= '<tr><td colspan="2"><hr/></td></tr>';
		$html .= '<tr><td><strong>Actualmente toma medicamentos:</strong></td><td>'.$lci['medicamentos'].'</td></tr>';
		$html .= '<tr><td><strong>Tiene mas de 60 años:</strong></td><td>'.$lci['edad'].'</td></tr>';
		$html .= '<tr><td colspan="2"><hr/></td></tr>';
		$html .= '<tr align="center"><td colspan="2"><b>Ha tenido alguno de los siguientes sintomas en las ultimas 24 horas?</b></td></tr>';
		$html .= '<tr><td><strong>Dolor de garganta:</strong></td><td>'.$lci['dolor_garganta'].'</td></tr>';
		$html .= '<tr><td><strong>Malestar general y dolor muscular que le limite las actividades de la vida diaria:</strong></td><td>'.$lci['malestar_general'].'</td></tr>';
		$html .= '<tr><td><strong>Fiebre igual o mayor a 38 grados medida con termometro:</strong></td><td>'.$lci['fiebre'].'</td></tr>';
		$html .= '<tr><td><strong>Tos seca y persistente de inicio reciente:</strong></td><td>'.$lci['tos'].'</td></tr>';
		$html .= '<tr><td><strong>Dificultad para respirar de inicio reciente:</strong></td><td>'.$lci['respirar'].'</td></tr>';
		$html .= '<tr><td><strong>Perdida del olfato y/o el gusto:</strong></td><td>'.$lci['olfato'].'</td></tr>';
		$html .= '<tr><td><strong>Actualmente esta en aislamiento y en espera del resultado de una prueba para COVID-19:</strong></td><td>'.$lci['aislamiento_sin'].'</td></tr>';
		$html .= '<tr><td><strong>Actualmente esta en aislamiento luego de haber sido diagnosticado con prueba positiva para COVID-19:</strong></td><td>'.$lci['aislamiento_con'].'</td></tr>';
		$html .= '<tr><td><strong>Vive con alguien en proceso de diagnostico o confirmado de tener COVID-19:</strong></td><td>'.$lci['caso_confirmado'].'</td></tr>';
		$html .= '<tr><td><strong>En los ultimos 14 dias ha tenido contacto estrecho (por mas de 15 minutos, a menos de 2 metrosy sin usar elementos de proteccion personal) con alguien en proceso de diagnostico o confirmado de COVID-19:</strong></td><td>'.$lci['contacto_estrecho'].'</td></tr>';
		$html .= '<tr><td><strong>Convive con personas vulnerables al COVID-19:</strong></td><td>'.$lci['vulnerables'].'</td></tr>';
		$html .= '<tr><td><strong>Toma de temperatura corporal el día de hoy:</strong></td><td>'.$lci['temperatura'].'</td></tr>';
		$html .= '<tr><td colspan="2"><hr/></td></tr>';
		$html .= '<tr><td><strong>Se ha realizo examen de COVID-19:</strong></td><td>'.$lci['prueba_covid'].'</td></tr>';
		if($lci['prueba_covid'] == 'S'){
			$html .= '<tr><td><strong>Fecha en la que se realizo la prueba:</strong></td><td>'.$lci['fecha_prueba'].'</td></tr>';
			if($lci['resultado'] == 'P'){ $resultado = 'PENDIENTE'; } else if ($lci['resultado'] == 'S'){ $resultado = 'POSITIVO'; } else if ($lci['resultado'] == 'N'){ $resultado = 'NEGATIVO'; }
			$html .= '<tr><td><strong>Resultado de la prueba:</strong></td><td>'.$resultado.'</td></tr>';
			if($lci['resultado'] != 'P'){
				$html .= '<tr><td><strong>Fecha entrega de los resultados:</strong></td><td>'.$lci['fecha_resultado'].'</td></tr>';
			}		
		}
		$html .= '<tr><td colspan="2"><hr/></td></tr>';

		$html .= '<tr class="mb-3" align="center"><td colspan="2"><b>SIGNOS DE SUEÑO Y FATIGA</b></td></tr>';
		$html .= '<tr><td><strong>¿Descanso adecuadamente en las ultimas doce horas?</strong></td><td>'.$lci['horas_descanso'].'</td></tr>';
		$html .= '<tr><td><strong>¿Cuántas horas durmio durante las ultimas doce horas?</strong></td><td>'.$lci['horas_totales_suenio'].'</td></tr>';
		$html .= '<tr><td><strong>¿Se siente fatigado?</strong></td><td>'.$lci['fatiga'].'</td></tr>';
		$html .= '<tr><td><strong>¿Tiene alguna situación personas que le ha limitado dormir/descansar apropiadamente en los ultimos días?</strong></td><td>'.$lci['situacion_personal'].'</td></tr>';
		$html .= '<tr><td><strong>¿Está tomando algun medicamento? </strong></td><td>'.$lci['medicamento'].'</td></tr>';
		$html .= '<tr><td><strong>¿Se siente en condiciones de trabajar?</strong></td><td>'.$lci['condicion_trabajo'].'</td></tr>';
	}

} 

$html .= '</table></ul>';

echo $html;
?>