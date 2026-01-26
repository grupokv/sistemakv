<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Salud
{
	public function listar(){
	     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM encuesta_salud");
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
       	    $listar[] = $filas;
       }

       return $listar;
	}

    public function listarPorId($id){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM encuesta_salud WHERE id_respuesta = ?");
       $sql->bindParam(1, $id);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
	}
	
	public function listarHoy($fecha){
	   $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM encuesta_salud WHERE date(fecha_diligenciamiento) = ?");
       $sql->bindParam(1, $fecha);
       $sql->execute();
       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }
	   //echo "SELECT * FROM encuesta_salud WHERE date(fecha_diligenciamiento) = '$fecha'";
       return $listar;
	}
	
	public function listarPorRangoFecha($fechai,$fechaf,$contrato){
		
	   	$listar = array();
       	$con = Conexion::conectar();
       	$sql = $con->prepare("SELECT * FROM encuesta_salud WHERE (date(fecha_diligenciamiento) >= ? AND date(fecha_diligenciamiento) <= ?) AND contrato = ? ORDER BY fecha_diligenciamiento ASC");
       	$sql->bindParam(1, $fechai);
	   	$sql->bindParam(2, $fechaf);
	   	$sql->bindParam(3, $contrato);
       	$sql->execute();
       
       	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       	}

	   	//echo "SELECT * FROM encuesta_salud WHERE (date(fecha_diligenciamiento) >= '$fechai' AND date(fecha_diligenciamiento) <= '$fechaf') AND contrato = '$contrato' ORDER BY fecha_diligenciamiento ASC";
       	
       	return $listar;
	}
	
	public function listarUltimaPorUsuario($usuario){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM encuesta_salud WHERE id_usuario = ? order by id_respuesta Desc limit 1");
       $sql->bindParam(1, $usuario);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
	}

 	public function buscarPorUsuario($usuario,$fecha){
		 $listar = array();
		   $con = Conexion::conectar();
		   $sql = $con->prepare("SELECT * FROM encuesta_salud WHERE id_usuario = ? and date(fecha_diligenciamiento) = ?");
		   $sql->bindParam(1, $usuario);
		   $sql->bindParam(2, $fecha);
		   $sql->execute();

		   while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				$listar[] = $filas;
		   }

		   return $listar;
    }
	
 	public function registrar($id_usuario, $email, $celular, $direccion, $empresa, $fechanac, $eps, $arl, $cargo, $contrato, $transporte, $nombre_contacto, $tel_contacto, $hipertension, $epoc, $cancer, $diabetes, $vih, $cardiaca, $renal, $asma, $ninguna, $medicamentos, $edad, $dolor_garganta, $malestar_general, $fiebre, $tos, $respirar, $olfato, $aislamiento_sin, $aislamiento_con, $caso_confirmado, $contacto_estrecho, $vulnerables, $temperatura, $prueba_covid, $fecha_prueba, $resultado, $fecha_resultado, $aplicacion_vacuna, $terminos, $fecha_diligenciamiento, $horas_descanso, $horas_totales_suenio, $fatiga, $situacion_personal, $medicamento, $medicamento_suenio, $condicion_trabajo){
		  try {
			  $con = Conexion::conectar();
			  $sql = $con->prepare("INSERT INTO encuesta_salud (id_usuario, email, celular, direccion, empresa, fechanac, eps, arl, cargo, contrato, transporte, nombre_contacto, tel_contacto, hipertension, epoc, cancer, diabetes, vih, cardiaca, renal, asma, ninguna, medicamentos, edad, dolor_garganta, malestar_general, fiebre, tos, respirar, olfato, aislamiento_sin, aislamiento_con, caso_confirmado, contacto_estrecho, vulnerables, temperatura, prueba_covid, fecha_prueba, resultado, fecha_resultado, aplicacion_vacuna, terminos, fecha_diligenciamiento, horas_descanso, horas_totales_suenio, fatiga, situacion_personal, medicamento, medicamento_suenio, condicion_trabajo) VALUES('$id_usuario', '$email', '$celular', '$direccion', '$empresa', '$fechanac', '$eps', '$arl', '$cargo', '$contrato', '$transporte', '$nombre_contacto', '$tel_contacto', '$hipertension', '$epoc', '$cancer', '$diabetes', '$vih', '$cardiaca', '$renal', '$asma', '$ninguna', '$medicamentos', '$edad', '$dolor_garganta', '$malestar_general', '$fiebre', '$tos', '$respirar', '$olfato', '$aislamiento_sin', '$aislamiento_con', '$caso_confirmado', '$contacto_estrecho', '$vulnerables', '$temperatura', '$prueba_covid', '$fecha_prueba', '$resultado', '$fecha_resultado', '$aplicacion_vacuna', '$terminos', '$fecha_diligenciamiento', '$horas_descanso', '$horas_totales_suenio', '$fatiga', '$situacion_personal', '$medicamento', '$medicamento_suenio', '$condicion_trabajo')");
			  
			  $sql->bindParam(":id_usuario", $id_usuario);
			  $sql->bindParam(":email", $email);
			  $sql->bindParam(":celular", $celular);
			  $sql->bindParam(":direccion", $direccion);
			  $sql->bindParam(":empresa", $empresa);
			  $sql->bindParam(":fechanac", $fechanac);
			  $sql->bindParam(":eps", $eps);
			  $sql->bindParam(":arl", $arl);
			  $sql->bindParam(":cargo", $cargo);
			  $sql->bindParam(":contrato", $contrato);
			  $sql->bindParam(":transporte", $transporte);
			  $sql->bindParam(":nombre_contacto", $nombre_contacto);
			  $sql->bindParam(":tel_contacto", $tel_contacto);
			  $sql->bindParam(":hipertension", $hipertension);
			  $sql->bindParam(":epoc", $epoc);
			  $sql->bindParam(":cancer", $cancer);
			  $sql->bindParam(":diabetes", $diabetes);
			  $sql->bindParam(":vih", $vih);
			  $sql->bindParam(":cardiaca", $cardiaca);
			  $sql->bindParam(":renal", $renal);
			  $sql->bindParam(":asma", $asma);
			  $sql->bindParam(":ninguna", $ninguna);
			  $sql->bindParam(":medicamentos", $medicamentos);
			  $sql->bindParam(":edad", $edad);
			  $sql->bindParam(":dolor_garganta", $dolor_garganta);
			  $sql->bindParam(":malestar_general", $malestar_general);
			  $sql->bindParam(":fiebre", $fiebre);
			  $sql->bindParam(":tos", $tos);
			  $sql->bindParam(":respirar", $respirar);
			  $sql->bindParam(":olfato", $olfato);
			  $sql->bindParam(":aislamiento_sin", $aislamiento_sin);
			  $sql->bindParam(":aislamiento_con", $aislamiento_con);
			  $sql->bindParam(":caso_confirmado", $caso_confirmado);
			  $sql->bindParam(":contacto_estrecho", $contacto_estrecho);
			  $sql->bindParam(":vulnerables", $vulnerables);
			  $sql->bindParam(":temperatura", $temperatura);
			  $sql->bindParam(":prueba_covid", $prueba_covid);
			  $sql->bindParam(":fecha_prueba", $fecha_prueba);
			  $sql->bindParam(":resultado", $resultado);
			  $sql->bindParam(":fecha_resultado", $fecha_resultado);
			  $sql->bindParam(":aplicacion_vacuna", $aplicacion_vacuna);
			  $sql->bindParam(":terminos", $terminos);
			  $sql->bindParam(":horas_descanso", $horas_descanso);
			  $sql->bindParam(":horas_totales_suenio", $horas_totales_suenio);
			  $sql->bindParam(":fatiga", $fatiga);
			  $sql->bindParam(":situacion_personal", $situacion_personal);
			  $sql->bindParam(":medicamento", $medicamento);
			  $sql->bindParam(":medicamento_suenio", $medicamento_suenio);
			  $sql->bindParam(":condicion_trabajo", $condicion_trabajo);

			  $sql->execute();
			  
			  //echo "INSERT INTO encuesta_salud (id_usuario, email, celular, direccion, empresa, fechanac, eps, arl, cargo, contrato, transporte, nombre_contacto, tel_contacto, hipertension, epoc, cancer, diabetes, vih, cardiaca, renal, asma, ninguna, medicamentos, edad, dolor_garganta, malestar_general, fiebre, tos, respirar, olfato, aislamiento_sin, aislamiento_con, caso_confirmado, contacto_estrecho, vulnerables, temperatura, prueba_covid, fecha_prueba, resultado, fecha_resultado, terminos, fecha_diligenciamiento, horas_descanso, horas_totales_suenio, fatiga, situacion_personal, medicamento, medicamento_suenio, condicion_trabajo) VALUES('$id_usuario', '$email', '$celular', '$direccion', '$empresa', '$fechanac', '$eps', '$arl', '$cargo', '$contrato', '$transporte', '$nombre_contacto', '$tel_contacto', '$hipertension', '$epoc', '$cancer', '$diabetes', '$vih', '$cardiaca', '$renal', '$asma', '$ninguna', '$medicamentos', '$edad', '$dolor_garganta', '$malestar_general', '$fiebre', '$tos', '$respirar', '$olfato', '$aislamiento_sin', '$aislamiento_con', '$caso_confirmado', '$contacto_estrecho', '$vulnerables', '$temperatura', '$prueba_covid', '$fecha_prueba', '$resultado', '$fecha_resultado', '$terminos', '$fecha_diligenciamiento', '$horas_descanso', '$horas_totales_suenio', '$fatiga', '$situacion_personal', '$medicamento', '$medicamento_suenio', '$condicion_trabajo')";			  

			  if($sql){
			  	return 1;
			  }else{
			  	return 0;
			  }


		  } catch (Exception $e) {
			  echo $e->getMessage();
		  }
	  }
	  
	  public function listarVulnerabilidad(){
	     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM encuesta_vulnerabilidad");
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
       	    $listar[] = $filas;
       }

       return $listar;
	}

    public function listarPorIdVulnerabilidad($id){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM encuesta_vulnerabilidad WHERE id_respuesta = ?");
       $sql->bindParam(1, $id);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
	}
	
	public function listarHoyVulnerabilidad($fecha){
	   $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM encuesta_vulnerabilidad WHERE date(fecha_diligenciamiento) = ?");
       $sql->bindParam(1, $fecha);
       $sql->execute();
       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }
	   //echo "SELECT * FROM encuesta_salud WHERE date(fecha_diligenciamiento) = '$fecha'";
       return $listar;
	}
	
	public function listarPorRangoFechaVulnerabilidad($fechai,$fechaf){
	   $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM encuesta_vulnerabilidad WHERE date(fecha_diligenciamiento) >= ? and date(fecha_diligenciamiento) <= ?");
       $sql->bindParam(1, $fechai);
	   $sql->bindParam(2, $fechaf);
       $sql->execute();
       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }
	   //echo "SELECT * FROM encuesta_salud WHERE date(fecha_diligenciamiento) >= '$fechai' and date(fecha_diligenciamiento) <= '$fechaf'";
       return $listar;
	}
	
	public function listarUltimaPorUsuarioVulnerabilidad($usuario){
     $listar = array();
       $con = Conexion::conectar();
       $sql = $con->prepare("SELECT * FROM encuesta_vulnerabilidad WHERE id_usuario = ? order by id_respuesta Desc limit 1");
       $sql->bindParam(1, $usuario);
       $sql->execute();

       while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
       }

       return $listar;
	}

	 public function buscarPorUsuarioVulnerabilidad($usuario,$fecha){
		 $listar = array();
		   $con = Conexion::conectar();
		   $sql = $con->prepare("SELECT * FROM encuesta_vulnerabilidad WHERE id_usuario = ? and date(fecha_diligenciamiento) = ?");
		   $sql->bindParam(1, $usuario);
		   $sql->bindParam(2, $fecha);
		   $sql->execute();

		   while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				$listar[] = $filas;
		   }

		   return $listar;
	 }
	
	 public function registrarVulnerabilidad($id_usuario, $email, $celular, $direccion, $empresa, $fechanac, $eps, $arl, $cargo, $contrato, $transporte, $nombre_contacto, $tel_contacto, $hipertension, $epoc, $cancer, $diabetes, $vih, $cardiaca, $renal, $asma, $otra, $cual, $ninguna, $embarazo, $obesidad, $medicamentos, $edad, $dolor_garganta, $malestar_general, $fiebre, $tos, $respirar, $olfato, $aislamiento_sin, $aislamiento_con, $caso_confirmado, $contacto_estrecho, $vulnerables, $temperatura, $prueba_covid, $fecha_prueba, $resultado, $fecha_resultado, $terminos, $fecha_diligenciamiento){
		  try {
			  $con = Conexion::conectar();
			  $sql = $con->prepare("INSERT INTO encuesta_vulnerabilidad (id_usuario, email, celular, direccion, empresa, fechanac, eps, arl, cargo, contrato, transporte, nombre_contacto, tel_contacto, hipertension, epoc, cancer, diabetes, vih, cardiaca, renal, asma, otra_enfermedad, cual, ninguna, embarazo, obesidad, medicamentos, edad, dolor_garganta, malestar_general, fiebre, tos, respirar, olfato, aislamiento_sin, aislamiento_con, caso_confirmado, contacto_estrecho, vulnerables, temperatura, prueba_covid, fecha_prueba, resultado, fecha_resultado, terminos, fecha_diligenciamiento) VALUES(:id_usuario, :email, :celular, :direccion, :empresa, :fechanac, :eps, :arl, :cargo, :contrato, :transporte, :nombre_contacto, :tel_contacto, :hipertension, :epoc, :cancer, :diabetes, :vih, :cardiaca, :renal, :asma, :otra, :cual, :ninguna, :embarazo, :obesidad, :medicamentos, :edad, :dolor_garganta, :malestar_general, :fiebre, :tos, :respirar, :olfato, :aislamiento_sin, :aislamiento_con, :caso_confirmado, :contacto_estrecho, :vulnerables, :temperatura, :prueba_covid, :fecha_prueba, :resultado, :fecha_resultado, :terminos, :fecha_diligenciamiento)");
			  $sql->bindParam(":id_usuario", $id_usuario);
			  $sql->bindParam(":email", $email);
			  $sql->bindParam(":celular", $celular);
			  $sql->bindParam(":direccion", $direccion);
			  $sql->bindParam(":empresa", $empresa);
			  $sql->bindParam(":fechanac", $fechanac);
			  $sql->bindParam(":eps", $eps);
			  $sql->bindParam(":arl", $arl);
			  $sql->bindParam(":cargo", $cargo);
			  $sql->bindParam(":contrato", $contrato);
			  $sql->bindParam(":transporte", $transporte);
			  $sql->bindParam(":nombre_contacto", $nombre_contacto);
			  $sql->bindParam(":tel_contacto", $tel_contacto);
			  $sql->bindParam(":hipertension", $hipertension);
			  $sql->bindParam(":epoc", $epoc);
			  $sql->bindParam(":cancer", $cancer);
			  $sql->bindParam(":diabetes", $diabetes);
			  $sql->bindParam(":vih", $vih);
			  $sql->bindParam(":cardiaca", $cardiaca);
			  $sql->bindParam(":renal", $renal);
			  $sql->bindParam(":asma", $asma);
			  $sql->bindParam(":otra", $otra);
			  $sql->bindParam(":cual", $cual);
			  $sql->bindParam(":ninguna", $ninguna);
			  $sql->bindParam(":embarazo", $embarazo);
			  $sql->bindParam(":obesidad", $obesidad);
			  $sql->bindParam(":medicamentos", $medicamentos);
			  $sql->bindParam(":edad", $edad);
			  $sql->bindParam(":dolor_garganta", $dolor_garganta);
			  $sql->bindParam(":malestar_general", $malestar_general);
			  $sql->bindParam(":fiebre", $fiebre);
			  $sql->bindParam(":tos", $tos);
			  $sql->bindParam(":respirar", $respirar);
			  $sql->bindParam(":olfato", $olfato);
			  $sql->bindParam(":aislamiento_sin", $aislamiento_sin);
			  $sql->bindParam(":aislamiento_con", $aislamiento_con);
			  $sql->bindParam(":caso_confirmado", $caso_confirmado);
			  $sql->bindParam(":contacto_estrecho", $contacto_estrecho);
			  $sql->bindParam(":vulnerables", $vulnerables);
			  $sql->bindParam(":temperatura", $temperatura);
			  $sql->bindParam(":prueba_covid", $prueba_covid);
			  $sql->bindParam(":fecha_prueba", $fecha_prueba);
			  $sql->bindParam(":resultado", $resultado);
			  $sql->bindParam(":fecha_resultado", $fecha_resultado);
			  $sql->bindParam(":terminos", $terminos);
			  $sql->bindParam(":fecha_diligenciamiento", $fecha_diligenciamiento);

			  $sql->execute();
			  
			  //echo "INSERT INTO encuesta_salud (id_usuario, email, celular, direccion, empresa, fechanac, eps, arl, cargo, contrato, transporte, nombre_contacto, tel_contacto, hipertension, epoc, cancer, diabetes, vih, cardiaca, renal, asma, ninguna, medicamentos, edad, dolor_garganta, malestar_general, fiebre, tos, respirar, olfato, aislamiento_sin, aislamiento_con, caso_confirmado, contacto_estrecho, vulnerables, temperatura, prueba_covid, fecha_prueba, resultado, fecha_resultado, terminos, fecha_diligenciamiento) VALUES('$id_usuario', '$email', '$celular', '$direccion', '$empresa', '$fechanac', '$eps', '$arl', '$cargo', '$contrato', '$transporte', '$nombre_contacto', '$tel_contacto', '$hipertension', '$epoc', '$cancer', '$diabetes', '$vih', '$cardiaca', '$renal', '$asma', '$ninguna', '$medicamentos', '$edad', '$dolor_garganta', '$malestar_general', '$fiebre', '$tos', '$respirar', '$olfato', '$aislamiento_sin', '$aislamiento_con', '$caso_confirmado', '$contacto_estrecho', '$vulnerables', '$temperatura', '$prueba_covid', '$fecha_prueba', '$resultado', '$fecha_resultado', '$terminos', '$fecha_diligenciamiento')";			  

			  return $id = $con->lastInsertId();

		  } catch (Exception $e) {
			  echo $e->getMessage();
		  }
	  }

}
 ?>