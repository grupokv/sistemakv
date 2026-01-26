<?php
require_once "../Modelo/Conductor.php";

$id_conductor = $_POST['id_conductor'];
$conductor = new Conductor();
$listarConId = $conductor->listarPorId($id_conductor);

$cant = count($listarConId);
date_default_timezone_set('America/Bogota');

$fecha = date('YmdHis');
$ip = '../Documentos/Conductores';


$html = '<ul>';

if($cant > 0){
	foreach($listarConId as $lci){
	    
		/*FOTOGRAFIA CONDUCTOR*/
			if ($lci['fotografia_conductor'] == '') {
            	$html .= '<p><strong>Fotografia del Conductor</strong> | No hay documento cargado actualmente.</p><hr>';
            }else{
            	 $html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['fotografia_conductor'].'" target="_blank"><strong>Fotografia del Conductor </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
            }


		/*FOTOCOPIA DOCUMENTO*/
			if ($lci['fotocopia_documento'] == '') {
            	$html .= '<p><strong>Fotocopia del Documento</strong> | No hay documento cargado actualmente.</p><hr>';
            }else{
            	 $html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['fotocopia_documento'].'" target="_blank"><strong>Fotocopia del Documento </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
            }

                
		/*CERTIFICADOS LABORALES*/
            if ($lci['fotocopia_licencia'] == '') {
        		$html .= '<p><strong>Licencia de Conducción</strong> | No hay documento cargado actualmente.</p><hr>';
        	}else{
            	$html .= '<a href="'.$ip.'/'. $lci['numero_documento_conductor'] .'/'.$lci['fotocopia_licencia'].'" target="_blank"><strong>Licencia de Conducción </strong><span class="fa fa-file-text ml-3"></span></a>' . '  |  ' . $lci['fecha_vencimiento_licencia'] . '<hr>';
            }


        /*CERTIFICADOS LABORALES*/
            if ($lci['certificados_laborales'] == '') {
            	$html .= '<p><strong>Certificados laborales</strong> | No hay documento cargado actualmente.</p><hr>';
            }else{
            	$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['certificados_laborales'].'" target="_blank"><strong>Certificados de laborales </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
            }


        /*CERTIFICADOS ESTUDIOS*/
			if ($lci['certificados_estudios'] == '') {
				$html .= '<p><strong>Certificado estudios</strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
            	$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['certificados_estudios'].'" target="_blank"><strong>Certificado estudios </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*CERTIFICADOS CURSOS*/
			if ($lci['certificados_cursos'] == '') {
				$html .= '<p><strong>Certificado cursos</strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['certificados_cursos'].'" target="_blank"><strong>Certificado cursos </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*LIBRETA MILITAR*/
			if ($lci['libreta_militar'] == '') {
				$html .= '<p><strong>Libreta Militar</strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['libreta_militar'].'" target="_blank"><strong>Libreta Militar </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*EXAMEN MEDICO*/
			if ($lci['examen_medico'] == '') {
				$html .= '<p><strong>Examen Medico</strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['examen_medico'].'" target="_blank"><strong>Examen Medico </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}

			
			
		/*HOJA DE VIDA*/
			if ($lci['hoja_vida'] == '') {
				$html .= '<p><strong>Hoja de Vida</strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['hoja_vida'].'" target="_blank"><strong>Hoja de Vida</strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*PROCURADORIA*/
			if ($lci['procuraduria'] == '') {
				$html .= '<p><strong>Procuraduria </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['procuraduria'].'" target="_blank"><strong>Procuraduria </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*CONTRALORIA*/
			if ($lci['contraloria'] == '') {
				$html .= '<p><strong>Contraloria </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['contraloria'].'" target="_blank"><strong>Contraloria </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*PERSONERIA*/
			if ($lci['personeria'] == '') {
				$html .= '<p><strong>Personeria </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['personeria'].'" target="_blank"><strong>Personeria </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*SIMIT*/
			if ($lci['simit'] == '') {
				$html .= '<p><strong>SIMIT </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['simit'].'" target="_blank"><strong>SIMIT </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*POLICIA*/
			if ($lci['policia'] == '') {
				$html .= '<p><strong>Policia </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['policia'].'" target="_blank"><strong>Policia </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*RUT*/
			if ($lci['rut'] == '') {
			    $html .= '<p><strong>Registro Único Tributario </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['rut'].'" target="_blank"><strong>Registro Único Tributario </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*VACUNAS*/
			if ($lci['vacunas'] == '') {
				$html .= '<p><strong>Vacunas</strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['vacunas'].'" target="_blank"><strong>Vacunas </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*CONTRATO TRABAJO*/
			if ($lci['contrato_trabajo'] == '') {
				$html .= '<p><strong>Contrato de Trabajo </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['numero_documento_conductor'] .'/'.$lci['contrato_trabajo'].'" target="_blank"><strong>Contrato de Trabajo </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}
	}

} 



$html .= '</ul>';

echo $html;





?>