<?php
require_once "../Modelo/Empleado.php";

$id = $_POST['id'];
$empleado = new Empleado();
$listarConId = $empleado->listarPorId($id);


$cant = count($listarConId);
date_default_timezone_set('America/Bogota');

$fecha = date('YmdHis');
$ip = '../Documentos/Empleados';


$html = '<ul>';

if($cant > 0){
	foreach($listarConId as $lci){
	    
		/*EXAMEN MEDICO*/
			if ($lci['examen_medico'] == '') {
				$html .= '<p><strong>Examen Medico</strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['num_documento'] .'/'.$lci['examen_medico'].'" target="_blank"><strong>Examen Medico </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}

			
			
		/*HOJA DE VIDA*/
			if ($lci['hoja_vida'] == '') {
				$html .= '<p><strong>Hoja de Vida</strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['num_documento'] .'/'.$lci['hoja_vida'].'" target="_blank"><strong>Hoja de Vida</strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*PROCURADORIA*/
			if ($lci['procuraduria'] == '') {
				$html .= '<p><strong>Procuraduria </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['num_documento'] .'/'.$lci['procuraduria'].'" target="_blank"><strong>Procuraduria </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*CONTRALORIA*/
			if ($lci['contraloria'] == '') {
				$html .= '<p><strong>Contraloria </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['num_documento'] .'/'.$lci['contraloria'].'" target="_blank"><strong>Contraloria </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*PERSONERIA*/
			if ($lci['personeria'] == '') {
				$html .= '<p><strong>Personeria </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['num_documento'] .'/'.$lci['personeria'].'" target="_blank"><strong>Personeria </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*SIMIT*/
			if ($lci['simit'] == '') {
				$html .= '<p><strong>SIMIT </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['num_documento'] .'/'.$lci['simit'].'" target="_blank"><strong>SIMIT </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*POLICIA*/
			if ($lci['policia'] == '') {
				$html .= '<p><strong>Policia </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['num_documento'] .'/'.$lci['policia'].'" target="_blank"><strong>Policia </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}


		/*CONTRATO TRABAJO*/
			if ($lci['contrato'] == '') {
				$html .= '<p><strong>Contrato de Trabajo </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['num_documento'] .'/'.$lci['contrato'].'" target="_blank"><strong>Contrato de Trabajo </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}

		/*CEDULA*/
			if ($lci['contrato'] == '') {
				$html .= '<p><strong>Cedula de Ciudadania </strong> | No hay documento cargado actualmente.</p><hr>';
			}else{
				$html .= '<a href="'.$ip.'/'.  $lci['num_documento'] .'/'.$lci['fotocopia_doc'].'" target="_blank"><strong>Cedula de Ciudadania </strong><span class="fa fa-file-text ml-3"></span></a><hr>';
			}
	}

} 



$html .= '</ul>';

echo $html;





?>