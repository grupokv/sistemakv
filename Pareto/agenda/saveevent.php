<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='../index.php';
	</SCRIPT>");
}
require('../bd/datos.php');
$querys = new consultas;

$fechahoy = date('Y-m-d H:i:s');

$meses = array();
$meses["Jan"] = 0;
$meses["Feb"] = 1;
$meses["Mar"] = 2;
$meses["Apr"] = 3;
$meses["May"] = 4;
$meses["Jun"] = 5;
$meses["Jul"] = 6;
$meses["Aug"] = 7;
$meses["Sep"] = 8;
$meses["Oct"] = 9;
$meses["Nov"] = 10;
$meses["Dec"] = 11;

$datos1 = $_GET["datos"];
$datos = str_replace('/%/','#',$datos1);

$evento = explode('=',$datos);

$navegador = $evento[10];

$aplica = $evento[11];
if($aplica == 'S'){
$objetivo = $evento[12];
} else {
$objetivo = 0;
}

$id = $evento[0];
$fechaini = $evento[1];
$fechafin = $evento[2];

$fechasini = explode(' ', $fechaini);
$fechasfin = explode(' ', $fechafin);


if($navegador == "Microsoft Internet Explorer")
{
	/*fechas de inicio*/
	$diaini = $fechasini[2];
	$mesini = ($meses[$fechasini[1]]+1);
	$yearini = $fechasini[5];
	
	$horaI = explode(':', $fechasini[3]);
	
	$horaini = $horaI[0];
	$minutoini = $horaI[1];
	$segundoini = $horaI[2];
	/*fechas de inicio*/
	
	/*fechas de fin*/
	$diafin = $fechasfin[2];
	$mesfin = ($meses[$fechasfin[1]]+1);
	$yearfin = $fechasfin[5];
	
	$horaF = explode(':', $fechasfin[3]);
	
	$horafin = $horaF[0];
	$minutofin = $horaF[1];
	$segundofin = $horaF[2];
	/*fechas de fin*/
}
else
{
	/*fechas de inicio*/
	$diaini = $fechasini[2];
	$mesini = ($meses[$fechasini[1]]+1);
	$yearini = $fechasini[3];
	
	$horaI = explode(':', $fechasini[4]);
	
	$horaini = $horaI[0];
	$minutoini = $horaI[1];
	$segundoini = $horaI[2];
	/*fechas de inicio*/
	
	/*fechas de fin*/
	$diafin = $fechasfin[2];
	$mesfin = ($meses[$fechasfin[1]]+1);
	$yearfin = $fechasfin[3];
	
	$horaF = explode(':', $fechasfin[4]);
	
	$horafin = $horaF[0];
	$minutofin = $horaF[1];
	$segundofin = $horaF[2];
	/*fechas de fin*/
}


$titulo = $evento[3];
$descrip = $evento[4];
$creador = $evento[5];

$invitados = explode('-',$evento[6]);
//echo $evento[7];
//echo $sigla_entidad = explode(" - ", $evento[7]);
$entidad = $evento[7];
$tpevento = $evento[8];
$nivelS = $evento[9];
$idpersona = $_SESSION["idus"];
$cantEsp = 0;

$fechaievento = $yearini.'-'.$mesini.'-'.$diaini;
$horaievento = $fechasini[4];
$fechafevento = $yearfin.'-'.$mesfin.'-'.$diafin;
$horafevento = $fechasfin[4];

if($cantEsp == "0")
{
	
	$eventos = array();
	$sqlU = "SELECT * FROM pareto WHERE id_usuario = '$creador' and fecha_inicial <= '$fechaievento' and fecha_final >= '$fechaievento'";
	$consU = new base_datos;
	$consU->connect();
	$resU = $consU->query($sqlU);
	while($itemU = $consU->fetch_row($resU))	{
		array_push($eventos,$itemU);
	}
	$cantpareto = count($eventos);
	if($cantpareto > 0){
		$idpareto = $eventos[0]['id'];
	} else {
		$idpareto = 0;
	}
	$sqlTicket = "insert into pareto_actividades (id_usuario,id_pareto,descripcion,id_tipoactividad,estado,fecha,hora,fecha_fin,hora_fin,fecha_creacion,id_creador,id_frecuencia,aplica_objetivo,id_objetivo,fecha_modificacion,activo) values ('$idpersona','$idpareto','$descrip','$tpevento','0','$fechaievento','$horaievento','$fechaievento','$horafevento','$fechahoy','$idpersona','1','$aplica','$objetivo','$fechahoy','A')";
	$insertTicket = new base_datos;
	$insertTicket->connect();
	$insertTicket->query($sqlTicket);

	$ultimo_id = mysql_insert_id();
	$link = 'newcalen.php?user='.$creador.'&espacio=';
	echo "<script>window.location='".$link."'</script>";
	
} else {
	$link = 'newcalen.php?user='.$creador.'&espacio=false';
	echo "<script>window.location='".$link."'</script>";
}
?>
