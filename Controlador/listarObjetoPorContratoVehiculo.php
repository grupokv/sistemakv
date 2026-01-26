<?php  
require_once "../Modelo/Contrato.php";
require_once "../Modelo/Cliente.php";
$contrato = new Contrato();
$cliente = new Cliente();

$id_contrato = $_POST['id_contrato'];
$cantContratos = $_POST['cantContratos'];
$listarContratoPorId = $contrato->listarId($id_contrato);
$cliente_ID = $cliente->cliente_ID($listarContratoPorId[0]['id_cliente']);

if ($cantContratos > 1) {
	echo "Por medio del presente convenio LA EMPRESA COLABORADORA pone a disposición de LA EMPRESA CONTRATISTA al vehículo descrito a continuación, vinculado a la empresa colaboradora, con el objeto de colaborar en la ejecución de contratos de prestación de servicio de transporte de pasajeros  a que haya lugar, según requerimiento de la empresa contratista.";
} else if ($cantContratos == 1) {

	if (count($listarContratoPorId) > 0) {
		if ($id_contrato == 249) {
			echo "PRESTACION DE SERVICIO PUBLICO DE TRANSPORTE TERRESTRE AUTOMOTOR ESPECIAL, CARGA Y TAXIS PARA LA SECRETARIA DISTRITAL DE INTEGRACION SOCIAL EN LAS DIFERENTES MODALIDADES: GRUPO 1: BUSES Y BUSETAS. haciendo todos aquellos desplazamientos que se encuentren previstos o sean programados dentro de la ciudad de Bogotá D.C., en el casco urbano y en las zonas rurales, así como en los municipios del departamento de Cundinamarca y Departamentos aledaños (Meta, Boyacá y Tolima), en los cuales se transportarán los niños-as, jóvenes, adultos/as, adultos mayores y sus familias, usuarios/as y servidores/as públicos/as que ejecutan e interactúan en los diferentes proyectos que desarrolla la Secretaría Distrital de Integración Social y que permiten el desarrollo de actividades de tipo formativo, lúdico, recreativo y misional, la ejecución de acciones de promoción, prevención, protección y restablecimiento de derechos, que contribuyan a la inclusión social de la población que está en situación de fragilidad social, en el marco de los proyectos 7564, 7730, 7735, 7744, 7745, 7770, 7756, 7757, 7771, 7740, 7748, y los demás que durante la ejecución del contrato se requieran., asimismo para todos los clientes con los cuales la empresa Contratista requiera durante el término de duración del presente acuerdo, dentro de todo el territorio nacional.";
		}else{
			echo $listarContratoPorId[0]['objeto_contrato'];
		}
	}else{
		echo "ESTE CONTRATO NO TIENE OBJETO";
	}

}

?>