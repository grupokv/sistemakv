<?php 
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Ciudad.php");

$id_empresa = $_POST['id_empresa'];

$empresa = new Empresa();
$listarEmpresa = $empresa->listarPorId($id_empresa);

$ciudad = new Ciudad();
$listarPorId = $ciudad->listarCiudadPorId($listarEmpresa[0]['id_ciudad']);


$cant = count($listarEmpresa);

$html = '<div>';
        if ($cant > 0) {
      	    foreach ($listarEmpresa as $le) {
      	    	    $html .= '<section class="row">';
		      	    	$html .= '<div class="col-5 justify-content-between">';
		      	    	      $html .= '<img src= "../Resources/fpdf/img' . '/'. $le['logo'] .'" width="100%;" class="mb-3"/>';
		      	    	$html .= '</div>';
		      	    	$html .= '<div class="col-7">';
		      	    	      $html .= '<h3 class="text-center">' .$le['nombre_empresa'] .'</h3>';
		      	    	      $html .= '<p class="mt-4"><strong>REPRESENTANTE LEGAL: </strong> ' .$le['representante_legal'] .'</p>';
		      	    	      $html .= '<p><strong>NIT: </strong> ' .$le['nit_empresa'] .'</p>';
		      	    	      $html .= '<p><strong>DIRECCIÓN: </strong> ' .$le['direccion'] .'</p>';
		      	    	      $html .= '<p><strong>TELÉFONO: </strong> ' .$le['telefono'] .'</p>';
		      	    	      $html .= '<p><strong>CIUDAD DE LA EMPRESA: </strong> ' .$listarPorId[0]['ciudad'] .'</p>';
		      	    	$html .= '</div>';
	      	    	$html .= '</section>';
      	  	}
        }
$html .= '</div>';

echo $html;
 ?>