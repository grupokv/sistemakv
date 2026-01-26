<?php
$fecha= date('Y-m-d');
$dia   = substr($fecha,8,2);
$mes = substr($fecha,5,2);
$anio = substr($fecha,0,4);
$semana = date('W',  mktime(0,0,0,$mes,$dia,$anio));

$pareto=$querys->pareto_activo($_SESSION['idus'],$fecha);
$cantidad = count($pareto);

if($cantidad < 1){
	
	$diaInicio="Monday";
    $diaFin="Sunday";

    $strFecha = strtotime($fecha);

    $fechainicial = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
    $fechafinal = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));

    if(date("l",$strFecha)==$diaInicio){
        $fechainicial= date("Y-m-d",$strFecha);
    }
    if(date("l",$strFecha)==$diaFin){
        $fechafinal= date("Y-m-d",$strFecha);
    }
	
	$idusuario = $_SESSION['idus'];
	
	$sql = "update pareto set estado = '0' where id_usuario = '$idusuario' and estado = '1'";
	$insert = new base_datos;
	$insert->connect();
	$insert->query($sql);
	
	$sql1 = "insert into pareto(fecha_inicial,fecha_final,estado,semana,id_usuario) values ('$fechainicial','$fechafinal','1','$semana','$idusuario')";
	$insert1 = new base_datos;
	$insert1->connect();
	$insert1->query($sql1);
	$idpareto = mysql_insert_id();
	
	$actividades = array();
	$cons = new base_datos;
	$cons->connect();
	$sql = "Select * from pareto_actividades where fecha >= '$fechainicial' and fecha <= '$fechafinal' and id_usuario = '$idusuario'";
	$res = $cons->query($sql);
	while($item = $cons->fetch_row($res))	{
		array_push($actividades,$item);
	}
	$cant = count($actividades);
	if($cant > 0){
		foreach($actividades as $act){
			$idactividad = $act['id'];
			$sql1 = "update pareto_actividades set id_pareto = '$idpareto' where id = '$idactividad'";
			$insert1 = new base_datos;
			$insert1->connect();
			$insert1->query($sql1);
		}
	}
	
	
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	alert('Se ha iniciado una nueva semana');
	</SCRIPT>");
}
?>