<?php 
require_once("Conexion/conexionBD.php");

    function mes($mes){

		switch ($mes) {
			case 1:
				$mes = 'enero';
				break;
			case 2:
				$mes = 'febrero';
				break;
			case 3:
				$mes = 'marzo';
				break;
			case 4:
				$mes = 'abril';
				break;
			case 5:
				$mes = 'mayo';
				break;
			case 6:
				$mes = 'junio';
				break;
			case 7:
				$mes = 'julio';
				break;
			case 8:
				$mes = 'agosto';
				break;
			case 9:
				$mes = 'septiembre';
				break;
			case 10:
				$mes = 'octubre';
				break;
			case 11:
				$mes = 'noviembre';
				break;
			case 12:
				$mes = 'diciembre';
				break;
		}

		return $mes;
	}

	function obtenerIP(){
      	if (isset($_SERVER["HTTP_CLIENT_IP"])){
          	return $_SERVER["HTTP_CLIENT_IP"];
      	}elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
          	return $_SERVER["HTTP_X_FORWARDED_FOR"];
      	}elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
          	return $_SERVER["HTTP_X_FORWARDED"];
      	}elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
          	return $_SERVER["HTTP_FORWARDED_FOR"];
      	}elseif (isset($_SERVER["HTTP_FORWARDED"])){
          	return $_SERVER["HTTP_FORWARDED"];
      	}else{
          	return $_SERVER["REMOTE_ADDR"];
      	}
  	}
                  


    function basico($numero) {
		$valor = array ('un','dos','tres','cuatro','cinco','seis','siete','ocho',
		'nueve','diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte','veintiuno','veintidos','veintitres','veinticuatro','veinticinco',
		'veintiséis','veintisiete','veintiocho','veintinueve');
		return $valor[$numero - 1];
	}
	 
	function decenas($n) {
		$decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
		70=>'setenta',80=>'ochenta',90=>'noventa');
		if( $n <= 29) return basico($n);
		$x = $n % 10;
		if ( $x == 0 ) {
			return $decenas[$n];
		} else {
			return $decenas[$n - $x].' y '. basico($x);
		}
	}
	 
	function centenas($n) {
		$cientos = array (100 =>'cien',200 =>'doscientos',300=>'trescientos',
		400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
		700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
		if( $n >= 100) {
			if ( $n % 100 == 0 ) {
				return $cientos[$n];
			} else {
				$u = (int) substr($n,0,1);
				$d = (int) substr($n,1,2);
				return (($u == 1)?'ciento':$cientos[$u*100]).' '.decenas($d);
			}
		} else {
			return decenas($n);
		}
	}
	 
	function miles($n) {
		if($n > 999) {
			if( $n == 1000) {
				return 'mil';
			} else {
				$l = strlen($n);
				$c = (int)substr($n,0,$l-3);
				$x = (int)substr($n,-3);
				if($c == 1) {
					$cadena = 'mil '.centenas($x);
				} else if($x != 0) {
					$cadena = centenas($c).' mil '.centenas($x);
				} else {
					$cadena = centenas($c). ' mil';
				}
				return $cadena;
			}
		} else {
			return centenas($n);
		}
	}
	
	function millones($n) {
        if($n == 1000000) {
            return 'UN MILLÓN';
            
        }else {
            $l = strlen($n);
            $c = (int)substr($n,0,$l-6);
            $x = (int)substr($n,-6);
            if($c == 1) {
                $cadena = ' MILLÓN ';
            } else {
                $cadena = ' millones ';
            }
            
            return miles($c).$cadena.(($x > 0)?miles($x):'');
        }
    }
	 

	function convertir($n) {
		switch (true) {
		case ( $n >= 1 && $n <= 29) : return basico($n); break;
		case ( $n >= 30 && $n < 100) : return decenas($n); break;
		case ( $n >= 100 && $n < 1000) : return centenas($n); break;
		case ( $n >= 1000 && $n <= 999999): return miles($n); break;
		case ( $n >= 1000000): return millones($n);
		}
	}

	function Paises(){
		$paises = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM paises");

        $sql->execute();
        while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
        	$paises[] = $filas;
        }

        return $paises;
	}

	function listarDepartamentos(){
		$dep = array();
		$con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM departamentos");

        $sql->execute();
        while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
        	$dep[] = $filas;
         }

        return $dep;
	}

	function Departamentos($id_pais){
		$departamentos = array();
		$con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM departamentos WHERE id_pais = :id_pais");
        $sql->bindParam(":id_pais", $id_pais);

        $sql->execute();
        while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
        	$departamentos[] = $filas;
        }

        return $departamentos;
	}

	function Ciudades($id_departamento){
		$ciudades = array();
		$con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM ciudades WHERE id_departamento = :id_departamento");
        $sql->bindParam(":id_departamento", $id_departamento);

        $sql->execute();
        while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
        	$ciudades[] = $filas;
        }

        return $ciudades;
	}

	function registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO bitacora_acciones (id_modulo, id_registro, tipo_actividad, columnas_modulo, valores_antiguos, valores_nuevos, id_usuario, fecha_actividad, hora_actividad) 
				VALUES (:id_modulo, :id_registro, :tipo_actividad, :columnas_modulo, :valores_antiguos, :valores_nuevos, :id_usuario, :fecha_actividad, :hora_actividad);");

			$sql->bindParam(":id_modulo", $id_modulo);
			$sql->bindParam(":id_registro", $id_registro);
			$sql->bindParam(":tipo_actividad", $tipo_actividad);
			$sql->bindParam(":columnas_modulo", $columnas_modulo);
			$sql->bindParam(":valores_antiguos", $valores_antiguos);
			$sql->bindParam(":valores_nuevos", $valores_nuevos);
			$sql->bindParam(":id_usuario", $id_usuario);
			$sql->bindParam(":fecha_actividad", $fecha_actividad);
			$sql->bindParam(":hora_actividad", $hora_actividad);

			$sql->execute();
			//echo "INSERT INTO bitacora_acciones (id_modulo, id_registro, tipo_actividad, columnas_modulo, valores_antiguos, valores_nuevos, id_usuario, fecha_actividad, hora_actividad) VALUES ('$id_modulo', '$id_registro', '$tipo_actividad', '$columnas_modulo', '$valores_antiguos', '$valores_nuevos', '$id_usuario', '$fecha_actividad', '$hora_actividad');";
			
		} catch (Exception $e) {
			$e->getMessage();
		}
	}

	function validar_archivo($archivo, $tamaño){
		$respuesta = 0;
		$archivo = mb_strtolower($archivo);
		$tipos_permitidos = array("pdf","doc","docx","txt","xls","xlsx","ppt","pptx","gif","jpg","jpeg","png");
		$ext = explode('.',$archivo);
		$ext = end($ext);
		if(in_array($ext, $tipos_permitidos))
		{
			if ($tamaño <= 20000000) {
				$respuesta = 1;
			}else{
				$respuesta = 0;
			}
			
		} else {
			$respuesta = 0;
		}
		return $respuesta;
	}

	function quitar_simbolos($texto){
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã","ÃŠ","ÃŽ","Ã","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã","Ã‹","Ñ","*","%","=","/");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","N","","","","");
		$texto = str_replace($no_permitidas, $permitidas ,$texto);
		return $texto;
	}

	function permisos($modulo,$usuario){
		$permisos = array();
		$con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM roles WHERE id_modulo = :modulo and id_usuario = :usuario");
        $sql->bindParam(":modulo", $modulo);
        $sql->bindParam(":usuario", $usuario);
        
        $sql->execute();
        while ($filas= $sql->fetch(PDO::FETCH_ASSOC)) {
        	$permisos[] = $filas;
        }

        return $permisos;
	}

	function registrarEncuestaDataOperativa($id_referenciador, $id_usuario_registro, $departamento, $ciudad, $nombres_apellidos, $telefono_celular, $telefono_fijo, $correo_electronico, $transporte_logistica, $logistica_producto, $logistica_servicio, $logistica_ambas_prod, $logistica_ambas_serv, $propietario, $tipo_vehiculo, $otro, $modelo, $capacidad, $disponibilidad_horario_inicial, $disponibilidad_horario_final, $vinculo, $empresaAfiliada, $ubicacion_vehiculo, $direccion_ubicacion, $envio_papeles, $status_propuesta, $observaciones, $fecha_registro){
		try {
			$con = Conexion::conectar();
	        $sql = $con->prepare("INSERT INTO encuesta_data_operativa (id_referenciador, id_usuario_registro, departamento, ciudad, nombres_apellidos, telefono_celular, telefono_fijo, correo_electronico, transporte_logistica, logistica_producto, logistica_servicio, logistica_ambas_prod, logistica_ambas_serv, propietario, tipo_vehiculo, otro, modelo, capacidad, disponibilidad_horario_inicial, disponibilidad_horario_final, vinculo, empresaAfiliada, ubicacion_vehiculo, direccion_ubicacion, envio_papeles, status_propuesta, observaciones, fecha_registro) VALUES (:id_referenciador, :id_usuario_registro, :departamento, :ciudad, :nombres_apellidos, :telefono_celular, :telefono_fijo, :correo_electronico, :transporte_logistica, :logistica_producto, :logistica_servicio, :logistica_ambas_prod, :logistica_ambas_serv, :propietario, :tipo_vehiculo, :otro, :modelo, :capacidad, :disponibilidad_horario_inicial, :disponibilidad_horario_final, :vinculo, :empresaAfiliada, :ubicacion_vehiculo, :direccion_ubicacion, :envio_papeles, :status_propuesta, :observaciones, :fecha_registro)");

	        $sql->bindParam(":id_referenciador", $id_referenciador);
	        $sql->bindParam(":id_usuario_registro", $id_usuario_registro);
	        $sql->bindParam(":departamento", $departamento);
	        $sql->bindParam(":ciudad", $ciudad);
	        $sql->bindParam(":nombres_apellidos", $nombres_apellidos);
	        $sql->bindParam(":telefono_celular", $telefono_celular);
	        $sql->bindParam(":telefono_fijo", $telefono_fijo);
	        $sql->bindParam(":correo_electronico", $correo_electronico);
	        $sql->bindParam(":transporte_logistica", $transporte_logistica);
	        $sql->bindParam(":logistica_producto", $logistica_producto);
	        $sql->bindParam(":logistica_servicio", $logistica_servicio);
	        $sql->bindParam(":logistica_ambas_prod", $logistica_ambas_prod);
	        $sql->bindParam(":logistica_ambas_serv", $logistica_ambas_serv);
	        $sql->bindParam(":propietario", $propietario);
	        $sql->bindParam(":tipo_vehiculo", $tipo_vehiculo);
	        $sql->bindParam(":otro", $otro);
	        $sql->bindParam(":modelo", $modelo);
	        $sql->bindParam(":capacidad", $capacidad);
	        $sql->bindParam(":disponibilidad_horario_inicial", $disponibilidad_horario_inicial);
	        $sql->bindParam(":disponibilidad_horario_final", $disponibilidad_horario_final);
	        $sql->bindParam(":vinculo", $vinculo);
	        $sql->bindParam(":empresaAfiliada", $empresaAfiliada);
	        $sql->bindParam(":ubicacion_vehiculo", $ubicacion_vehiculo);
	        $sql->bindParam(":direccion_ubicacion", $direccion_ubicacion);
	        $sql->bindParam(":envio_papeles", $envio_papeles);
	        $sql->bindParam(":status_propuesta", $status_propuesta);
	        $sql->bindParam(":observaciones", $observaciones);
	        $sql->bindParam(":fecha_registro", $fecha_registro);

	        $sql->execute();

	        if ($sql) {
	        	return 1;
	        }else{
	        	return 0;
	        }


	        //echo "INSERT INTO encuesta_data_operativa (id_referenciador, id_usuario_registro departamento, ciudad, nombres_apellidos, telefono_celular, telefono_fijo, correo_electronico, transporte_logistica, logistica_producto, logistica_servicio, logistica_ambas_prod, logistica_ambas_serv, propietario, tipo_vehiculo, otro, modelo, capacidad, disponibilidad_horario_inicial, disponibilidad_horario_final, vinculo, empresaAfiliada, ubicacion_vehiculo, direccion_ubicacion, envio_papeles, status_propuesta, observaciones, fecha_registro) VALUES ('$id_referenciador', '$id_usuario_registro', '$departamento', '$ciudad', '$nombres_apellidos', '$telefono_celular', '$telefono_fijo', '$correo_electronico', '$transporte_logistica', '$logistica_producto', '$logistica_servicio', '$logistica_ambas_prod', '$logistica_ambas_serv', '$propietario', '$tipo_vehiculo', '$otro', '$modelo', '$capacidad', '$disponibilidad_horario_inicial', '$disponibilidad_horario_final', '$vinculo', '$empresaAfiliada', '$ubicacion_vehiculo', '$direccion_ubicacion', '$envio_papeles', '$status_propuesta', '$observaciones', '$fecha_registro')";


		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function filtroDataOperativa($capacidad, $tipo_vehiculo, $modelo, $fecha_inicial, $fecha_final){
		$filtroData = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM encuesta_data_operativa WHERE (capacidad LIKE '$capacidad') AND (tipo_vehiculo LIKE '$tipo_vehiculo') AND (modelo LIKE '$modelo') AND (DATE(fecha_registro) >= '$fecha_inicial') AND (DATE(fecha_registro) <= '$fecha_final')");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $filtroData[] = $filas;
        }
        
        return $filtroData;

	}

	function listarDataOperativaID($id_data_operativa){
		$listarDataID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM encuesta_data_operativa WHERE id_data_operativa = :id_data_operativa");
        $sql->bindParam(":id_data_operativa", $id_data_operativa);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarDataID[] = $filas;
        }
        
        return $listarDataID;

	}

	function registrarEncuestaNotificacionPositiva($nombres_trabajador, $apellidos_trabajador, $telefono, $direccion, $correo_electronico, $id_referenciador, $fecha_registro, $cant_personas_contacto){
		try {
			$con = Conexion::conectar();
	        $sql = $con->prepare("INSERT INTO encuesta_notificacion_positiva (nombres_trabajador, apellidos_trabajador, telefono, direccion, correo_electronico, id_referenciador, fecha_registro, cant_personas_contacto) VALUES (:nombres_trabajador, :apellidos_trabajador, :telefono, :direccion, :correo_electronico, :id_referenciador, :fecha_registro, :cant_personas_contacto)");
	        $sql->bindParam(":nombres_trabajador", $nombres_trabajador);
	        $sql->bindParam(":apellidos_trabajador", $apellidos_trabajador);
	        $sql->bindParam(":telefono", $telefono);
	        $sql->bindParam(":direccion", $direccion);
	        $sql->bindParam(":correo_electronico", $correo_electronico);
	        $sql->bindParam(":id_referenciador", $id_referenciador);
	        $sql->bindParam(":fecha_registro", $fecha_registro);
	        $sql->bindParam(":cant_personas_contacto", $cant_personas_contacto);

	        $sql->execute();

	        //echo "INSERT INTO encuesta_notificacion_positiva (nombres_trabajador, apellidos_trabajador, telefono, direccion, correo_electronico, id_referenciador, fecha_registro, cant_personas_contacto) VALUES ('$nombres_trabajador', '$apellidos_trabajador', '$telefono', '$direccion', '$correo_electronico', '$id_referenciador', '$fecha_registro', '$cant_personas_contacto')";

	        if ($sql) {
	        	return $id = $con->lastInsertId();
	        }
	        
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function registrarPersonasNotificacionPositiva($id_notificacion, $nombre_persona, $fecha_contacto, $lugar_contacto){
		try {
			$con = Conexion::conectar();
	        $sql = $con->prepare("INSERT INTO encuesta_notificacion_positiva_personas_contacto (id_notificacion, nombre_persona, fecha_contacto, lugar_contacto) VALUES (:id_notificacion, :nombre_persona, :fecha_contacto, :lugar_contacto)");
	        $sql->bindParam(":id_notificacion", $id_notificacion);
	        $sql->bindParam(":nombre_persona", $nombre_persona);
	        $sql->bindParam(":fecha_contacto", $fecha_contacto);
	        $sql->bindParam(":lugar_contacto", $lugar_contacto);

	        $sql->execute();

	        //echo "INSERT INTO encuesta_notificacion_positiva_personas_contacto (id_notificacion, nombre_persona, fecha_contacto, lugar_contacto) VALUES ('$id_notificacion', '$nombre_persona', '$fecha_contacto', '$lugar_contacto')";
	        
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function listarNotificaciones(){
		$listarN = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM encuesta_notificacion_positiva ORDER BY fecha_registro ASC");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarN[] = $filas;
        }
        
        return $listarN;

	}

	function listarPersonasContactoNotificaciones($id_notificacion){
		$listarPersonasContactoN = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM encuesta_notificacion_positiva_personas_contacto WHERE id_notificacion = :id_notificacion");
        $sql->bindParam(":id_notificacion", $id_notificacion);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarPersonasContactoN[] = $filas;
        }
        
        return $listarPersonasContactoN;

	}

	function registrarMensajeAfiliado($id_usuario_destinatario, $mensaje, $id_usuario_remitente, $fecha){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO mensajes_afiliados(id_usuario_destinatario, mensaje, id_usuario_remitente, fecha) VALUES(:id_usuario_destinatario, :mensaje, :id_usuario_remitente, :fecha); ");
       		$sql->bindParam(":id_usuario_destinatario", $id_usuario_destinatario);
       		$sql->bindParam(":mensaje", $mensaje);
       		$sql->bindParam(":id_usuario_remitente", $id_usuario_remitente);
       		$sql->bindParam(":fecha", $fecha);
        	$sql->execute();

        	//echo "INSERT INTO (id_usuario_destinatario, mensaje, id_usuario_remitente, fecha) VALUES('$id_usuario_destinatario', '$mensaje', '$id_usuario_remitente', '$fecha')";

	        if ($sql) {
	        	return 1;
	        }else{
	        	return 0;
	        }

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	function listarMensajesAfiliados(){
		$mensajesAfi = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM mensajes_afiliados ORDER BY fecha ASC");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $mensajesAfi[] = $filas;
        }
        
        return $mensajesAfi;

	}


	function listarProyectosDO(){
		$listarProyDo = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM proyectos_data_operativa");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarProyDo[] = $filas;
        }
        
        return $listarProyDo;

	}

?>