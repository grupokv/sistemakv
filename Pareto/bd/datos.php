<?php
include_once('conexion.php');
date_default_timezone_set("America/Bogota");
class consultas 
{
	//OBJETIVO GENERAL
	function obj_general($idu){
		$objgeneral = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from obj_general where id_usuario = '$idu'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($objgeneral,$item);
		}
		$cons->close();
		return $objgeneral;	
	}
	//OBJETIVO GENERAL

	//OBJETIVO GENERAL ID
	function obj_generalID($id){
		$objgeneralid = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "SELECT * FROM obj_general WHERE id = '$id' ";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($objgeneralid,$item);
		}
		$cons->close();
		return $objgeneralid;	
	}
	//OBJETIVO GENERAL ID
		
	//OBJETIVOS ESPECIFICOS
	function obj_especificos($idu){
		$objespecifico = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from obj_especificos where id_usuario = '$idu'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($objespecifico,$item);
		}
		$cons->close();
		return $objespecifico;	
	}
	//OBJETIVOS ESPECIFICOS
	
	//OBJETIVOS ESPECIFICOS ID
	function obj_especificosid($idu, $id){
		$objespecificoid = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "SELECT * FROM obj_especificos WHERE id_usuario = '$idu' AND id = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($objespecificoid,$item);
		}
		$cons->close();
		return $objespecificoid;	
	}
	//OBJETIVOS ESPECIFICOS ID
	
	//OBJETIVOS ESPECIFICOS ID
	function obj_especificosid2($id){
		$objespecificoid = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from obj_especificos where id = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($objespecificoid,$item);
		}
		$cons->close();
		return $objespecificoid;	
	}
	//OBJETIVOS ESPECIFICOS ID

	//EVIDENCIA
	function evidencia(){
		$evidencia = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from evidencia";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($evidencia,$item);
		}
		$cons->close();
		return $evidencia;	
	}
	//EVIDENCIA
	
	//EVIDENCIA ID
	function evidenciaid($id){
		$evidenciaid = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from evidencia where id = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($evidenciaid,$item);
		}
		$cons->close();
		return $evidenciaid;	
	}
	//EVIDENCIA ID

	//PORCENTAJE ESPECIFICOS
	function porcen_especificos($idu){
		$porcen_especificos = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select sum(cuantificador) as total from obj_especificos where id_usuario = '$idu'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($porcen_especificos,$item);
		}
		$cons->close();
		return $porcen_especificos;	
	}
	//PORCENTAJE ESPECIFICOS

	//PARETO ACTIVO
	function pareto_activo($idu,$fecha){
		$pareto_act = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto where id_usuario = '$idu' and fecha_inicial <= '$fecha' and fecha_final >= '$fecha' and estado = '1' order by fecha_inicial Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($pareto_act,$item);
		}
		$cons->close();
		return $pareto_act;	
	}
	//PARETO ACTIVO
	
	//PARETO POR FECHA
	function pareto_fecha($idu,$fecha){
		$pareto_fecha = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto where id_usuario = '$idu' and fecha_inicial <= '$fecha' and fecha_final >= '$fecha' order by fecha_inicial Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($pareto_fecha,$item);
		}
		$cons->close();
		return $pareto_fecha;	
	}
	//PARETO POR FECHA
	
	//PARETO ID
	function paretoid($id){
		$paretoid = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "SELECT * FROM pareto WHERE id = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($paretoid,$item);
		}
		$cons->close();
		return $paretoid;	
	}
	//PARETO ID
	
	//PARETOS USUARIO
	function paretos_us($idu){
		$paretos = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto where id_usuario = '$idu' order by fecha_inicial Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($paretos,$item);
		}
		$cons->close();
		return $paretos;	
	}
	//PARETOS USUARIOS

	//PARETOS USUARIO AÑO
	function paretos_us_anio($idu, $anio){
		$paretos = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "SELECT * FROM pareto WHERE id_usuario = '$idu' AND YEAR(fecha_inicial) = '$anio' ORDER BY fecha_inicial DESC";
		$res = $cons->query($sql);

		while($item = $cons->fetch_row($res))	{
			array_push($paretos,$item);
		}

		$cons->close();
		return $paretos;	
	}
	//PARETOS USUARIOS
	
	//PARETOS ACTIVIDADES
	function actividadesTodasPareto($idpareto){
		$actividades = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto_actividades where id_pareto = '$idpareto' and id_padre = 0 and activo = 'A' order by id_tipoactividad Asc, fecha Desc, hora Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actividades,$item);
		}
		$cons->close();
		return $actividades;
	}
	
	function conteoactividadesTodasPareto($idpareto){
		$actividades = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select count(*) as total, id_tipoactividad from pareto_actividades where id_pareto = '$idpareto' and id_padre = 0 and activo = 'A' group by id_tipoactividad";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actividades,$item);
		}
		$cons->close();
		return $actividades;
	}
	
	
	//PARETOS ACTIVIDADES POR TIPO
	function actividades($idpareto,$tipo){
		$actividades = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto_actividades where id_pareto = '$idpareto' and id_tipoactividad = '$tipo' and id_padre = 0 and activo = 'A' order by fecha Desc, hora Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actividades,$item);
		}
		$cons->close();
		return $actividades;	
	}
	//PARETOS ACTIVIDADES POR TIPO
	
	//PARETOS ACTIVIDADES POR PADRE
	function actividadespadre($padre){
		$actividadespadre = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto_actividades where id_padre = '$padre' and activo = 'A' order by fecha Desc, hora Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actividadespadre,$item);
		}
		$cons->close();
		return $actividadespadre;	
	}
	//PARETOS ACTIVIDADES POR PADRE
		
	//TIPOS ACTIVIDADES
	function tiposact(){
		$tiposact = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from tipo_actividad";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($tiposact,$item);
		}
		$cons->close();
		return $tiposact;	
	}
	//TIPOS ACTIVIDAD
	
	//TIPOS ACTIVIDADES ID
	function tiposactid($id){
		$tiposactid = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from tipo_actividad where id = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($tiposactid,$item);
		}
		$cons->close();
		return $tiposactid;	
	}
	//TIPOS ACTIVIDAD ID
	
	//PARETOS ACTIVIDADES ID
	function actividad_id($usuario,$idactividad){
		$actividadesid = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto_actividades where id_usuario = '$usuario' and id = '$idactividad'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actividadesid,$item);
		}
		$cons->close();
		return $actividadesid;	
	}
	//PARETOS ACTIVIDADES ID
	
	//PARETOS ACTIVIDADES ID
	function actividad_id2($idactividad){
		$actividadesid = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto_actividades where id = '$idactividad'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actividadesid,$item);
		}
		$cons->close();
		return $actividadesid;	
	}
	//PARETOS ACTIVIDADES ID
	
	//PARETOS ACTIVIDADES USUARIOS ID 
	function actividad_id_otro($idpareto,$idactividad){
		$actividad_id_otro = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto_actividades where id_pareto = '$idpareto' and id = '$idactividad'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actividad_id_otro,$item);
		}
		$cons->close();
		return $actividad_id_otro;	
	}
	//PARETOS ACTIVIDADES USUARIO ID
	
	//CARGOS
	function cargos(){
		$cargos = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from cargo";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($cargos,$item);
		}
		$cons->close();
		return $cargos;	
	}
	//CARGOS
	
	//CARGOS AREA
	function cargosarea($areaid){
		$cargosarea = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from cargo where id_area = '$areaid'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($cargosarea,$item);
		}
		$cons->close();
		return $cargosarea;	
	}
	//CARGOS AREA
	
	//CARGO ID
	function cargoid($id){
		$cargoid = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from cargo where id = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($cargoid,$item);
		}
		$cons->close();
		return $cargoid;	
	}
	//CARGO ID
	
	//USUARIOS
	function usuarios(){
		$usuarios = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "SELECT * FROM usuario WHERE estado = '1' ORDER BY nombre ASC";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($usuarios,$item);
		}
		$cons->close();
		return $usuarios;	
	}
	//USUARIOS
	
	//USUARIOS AREA
	function usuariosarea($idarea){
		$usuariosarea = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "SELECT * FROM usuario WHERE id_area = '$idarea' AND estado = 1";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($usuariosarea,$item);
		}
		$cons->close();
		return $usuariosarea;	
	}
	//USUARIOS AREA
	
	//USUARIOS ID
	function usuarioid($id){
		$usuarioid = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from usuario where id = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($usuarioid,$item);
		}
		$cons->close();
		return $usuarioid;	
	}
	//USUARIOS ID
	
	//PERFILES
	function perfiles(){
		$perfiles = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from perfil";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($perfiles,$item);
		}
		$cons->close();
		return $perfiles;	
	}
	//PERFILES
	
	//PERFILES
	function perfilesarea(){
		$perfilesarea = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from perfil where id != '1'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($perfilesarea,$item);
		}
		$cons->close();
		return $perfilesarea;	
	}
	//PERFILES
	
	//PERFILES ID
	function perfilid($id){
		$perfilid = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from perfil where id = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($perfilid,$item);
		}
		$cons->close();
		return $perfilid;	
	}
	//PERFILES ID
	
	//FRECUENCIA ACTIVIDADES
	function frecuencia(){
		$frecuencia = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from frecuencia";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($frecuencia,$item);
		}
		$cons->close();
		return $frecuencia;	
	}
	//FRECUENCIA ACTIVIDADES
	
	//AREAS
	function areas(){
		$areas = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from area";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($areas,$item);
		}
		$cons->close();
		return $areas;	
	}
	//AREAS
	
	//AREAS ID
	function areaid($id){
		$areaid = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from area where id_area = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($areaid,$item);
		}
		$cons->close();
		return $areaid;	
	}
	//AREAS ID
	
	//PARETOS ACTIVIDADES AGRUPADOS
	function actividadestodas($idpareto){
		$actividadestodas = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto_actividades where id_pareto = '$idpareto' and id_padre = 0 and activo ='A' order by fecha Desc,hora Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actividadestodas,$item);
		}
		$cons->close();
		return $actividadestodas;	
	}
	//PARETOS ACTIVIDADES AGRUPADOS
	
	//PARETOS ACTIVIDADES COMPLETAS
	function actividadescompletas($idpareto,$estado){
		$actividadescompletas = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "Select * from pareto_actividades where id_pareto = '$idpareto' and estado = '$estado' and id_padre = 0 and activo = 'A' order by id Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actividadescompletas,$item);
		}
		$cons->close();
		return $actividadescompletas;	
	}
	//PARETOS ACTIVIDADES COMPLETAS
	
	//PARETOS MES//
	function paretosmes($mes,$anno,$iduser){
		$paretosmes = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "SELECT * FROM pareto WHERE ((MONTH(fecha_inicial) = '$mes' AND YEAR(fecha_inicial) = '$anno') or (MONTH(fecha_final) = '$mes' AND YEAR(fecha_final) = '$anno')) and id_usuario = '$iduser' order by fecha_inicial";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($paretosmes,$item);
		}
		$cons->close();
		return $paretosmes;	
	}
	//PARETOS MES//
	
	//PARETOS AÑO//
	function paretosanno($anno,$iduser){
		$paretosanno = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "SELECT * FROM pareto WHERE ((YEAR(fecha_inicial) = '$anno') or ( YEAR(fecha_final) = '$anno')) and id_usuario = '$iduser' order by fecha_inicial";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($paretosanno,$item);
		}
		$cons->close();
		return $paretosanno;	
	}
	//PARETOS AÑO//
	
	//SIGUIENTE ALARMA//
	function proximaalerta($dia,$tipo){
		if($tipo == 1){
			$diahoy = date('w');
			$dif = $dia - $diahoy;
			if($dif == 0){
				$dif = 7;
			} else if ($dif < 0){
				$dif = 7 - ($diahoy - $dia);
			}

			$fecha = date('Y-m-j');
			$nuevafecha = strtotime ( '+'.$dif.' day' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
			 
		} else if ($tipo == 2){
			$diahoy = date('d');
			$meshoy = date('m');
			$annohoy = date('Y');
			if ($diahoy >= $dia){
				$fecha = date($annohoy.'-'.$meshoy.'-'.$dia);
				$nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
				$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
			} else {
				$fecha = date($annohoy.'-'.$meshoy.'-'.$dia);
				$nuevafecha = strtotime ( '+0 month' , strtotime ( $fecha ) ) ;
				$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
			}
				
		}
		return $nuevafecha;
	}
	
	//SIGUIENTE ALARMA//
	
	//SIGUIENTE ALARMA OBJETIVO//
	function proximaalertaobj($dia,$tipo,$actual){
		if($tipo == 1){
			
			$fecha = date('Y-m-j');
			$nuevafecha = strtotime ( '+7 day' , strtotime ( $actual ) ) ;
			$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
			 
		} else if ($tipo == 2){
			
			$nuevafecha = strtotime ( '+1 month' , strtotime ( $actual ) ) ;
			$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
		
		}
		return $nuevafecha;
	}
	
	//SIGUIENTE ALARMA OBJETIVO//
	
	//DIA SEMANA//
	function diasemana($dia){
		if($dia == 1){ $diaresultado = 'Lunes'; }
		else if($dia == 2){ $diaresultado = 'Martes'; }
		else if($dia == 3){ $diaresultado = 'Miercoles'; }
		else if($dia == 4){ $diaresultado = 'Jueves'; }
		else if($dia == 5){ $diaresultado = 'Viernes'; }
		else if($dia == 6){ $diaresultado = 'Sabado'; }
		else if($dia == 7){ $diaresultado = 'Domingo'; }
		return $diaresultado;	
	}
	//DIA SEMANA//
	
	//ALERTAS OBJETIVOS AMARILLO//
	function alerta_objetivo_ama($fechaact,$idus){
		$nuevafecha = strtotime('+1 day',strtotime($fechaact));
		$nuevafecha = date('Y-m-j',$nuevafecha);
		$objamarillos = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "SELECT * FROM obj_especificos WHERE proxima_alerta = '$nuevafecha' and id_usuario = '$idus'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($objamarillos,$item);
		}
		$cons->close();
		return $objamarillos;
	}
	//ALERTAS OBJETIVOS AMARILLO//
	
	//ALERTAS OBJETIVOS ROJO//
	function alerta_objetivo_roj($fechaact,$idus){
		$nuevafecha = strtotime('+0 day',strtotime($fechaact));
		$nuevafecha = date('Y-m-j',$nuevafecha);
		$objrojos = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "SELECT * FROM obj_especificos WHERE proxima_alerta = '$nuevafecha' and id_usuario = '$idus'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($objrojos,$item);
		}
		$cons->close();
		return $objrojos;
	}
	//ALERTAS OBJETIVOS ROJO//
	
	//ALERTAS ACTIVIDADES AMARILLO//
	function alerta_actividad_ama($fechaact,$idus){
		$nuevafecha = strtotime('+1 day',strtotime($fechaact));
		$nuevafecha = date('Y-m-j',$nuevafecha);
		$actamarillos = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "SELECT * FROM pareto_actividades WHERE fecha = '$nuevafecha' and id_usuario = '$idus' and estado = 0 and activo = 'A' and novedad is NULL";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actamarillos,$item);
		}
		$cons->close();
		return $actamarillos;
	}
	//ALERTAS ACTIVIDADES AMARILLO//
	
	//ALERTAS ACTIVIDADES ROJO//
	function alerta_actividad_roj($fechaact,$idus){
		$nuevafecha = strtotime('+0 day',strtotime($fechaact));
		$nuevafecha = date('Y-m-j',$nuevafecha);
		$actrojos = array();
		$cons = new base_datos;
		$cons->connect();
	    $sql = "SELECT * FROM pareto_actividades WHERE fecha = '$nuevafecha' and id_usuario = '$idus' and estado = 0 and activo = 'A' and novedad is NULL";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($actrojos,$item);
		}
		$cons->close();
		return $actrojos;
	}
	//ALERTAS ACTIVIDADES ROJO//
	
	//ALERTAS ACTIVIDADES VENCIDAS//
	function act_vencidas($fechaact,$idus){
		$nuevafecha = strtotime('+0 day',strtotime($fechaact));
		$nuevafecha = date('Y-m-d',$nuevafecha);
		$act_vencidas2 = array();
		$cons = new base_datos;
		$cons->connect();
	        $sql = "SELECT * FROM pareto_actividades WHERE fecha < '$nuevafecha' and id_usuario = '$idus' and estado = '0' and activo = 'A' and novedad is NULL";
		$res = $cons->query($sql);
		
		while($item = $cons->fetch_row($res))	{
			array_push($act_vencidas2,$item);
		}

		$cons->close();
		
		
		return $act_vencidas2;
	}
	//ALERTAS ACTIVIDADES VENCIDAS//
	
	//ALERTAS OBJETIVOS VENCIDOS//
	function obj_vencidas($fechaact,$idus){
		$nuevafecha = strtotime('+0 day',strtotime($fechaact));
		$nuevafecha = date('Y-m-j',$nuevafecha);
		$obj_vencidas = array();
		$cons = new base_datos;
		$cons->connect();
	        $sql = "SELECT * FROM obj_especificos WHERE proxima_alerta < '$nuevafecha' and id_usuario = '$idus'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($obj_vencidas,$item);
		}
		$cons->close();
		return $obj_vencidas;
	}
	//ALERTAS OBJETIVOS VENCIDOS//
	
	//INVITACIONES POR USUARIO INVITADO
	function invitaciones($iduser){
		$invitaciones = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from invitaciones where id_invitado = '$iduser' and estado = 'P'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($invitaciones,$item);
		}
		$cons->close();
		return $invitaciones;	
	}
	//INVITACIONES POR USUARIO INVITADO
	
	//INVITACIONES POR USUARIO INVITADO
	function invitacionestodas($iduser){
		$invitacionestodas = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from invitaciones where id_invitado = '$iduser' order by id_invitacion Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($invitacionestodas,$item);
		}
		$cons->close();
		return $invitacionestodas;	
	}
	//INVITACIONES POR USUARIO INVITADO
	
	//INVITACIONES POR USUARIO ANFITRION
	function invitacionestodas2($iduser){
		$invitacionestodas2 = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select distinct(id_actividad) from invitaciones where id_anfitrion = '$iduser' order by id_invitacion Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($invitacionestodas2,$item);
		}
		$cons->close();
		return $invitacionestodas2;	
	}
	//INVITACIONES POR USUARIO ANFITRION
	
	//INVITACIONES POR ACTIVIDAD
	function invitacion_actividad($idactividad){
		$invitacion_actividad = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from invitaciones where id_actividad = '$idactividad' order by id_invitacion Desc";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($invitacion_actividad,$item);
		}
		$cons->close();
		return $invitacion_actividad;	
	}
	//INVITACIONES POR ACTIVIDAD
	
	//INVITACIONES ID
	function invitacion_id($id){
		$invitacion_id = array();
		$cons = new base_datos;
		$cons->connect();
		$sql = "Select * from invitaciones where id_invitacion = '$id'";
		$res = $cons->query($sql);
		while($item = $cons->fetch_row($res))	{
			array_push($invitacion_id,$item);
		}
		$cons->close();
		return $invitacion_id;	
	}
	//INVITACIONES POR ACTIVIDAD
}
?>