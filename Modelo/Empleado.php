<?php 

require_once("Conexion/conexionBD.php");

class Empleado
{

	public function listar(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function listarActivos(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado WHERE estado = 1");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}

	public function listarPorId($id){
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado WHERE id_empleado = ?");
		$sql->bindParam(1, $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarId[] = $filas;
        }

        return $listarId;
	}

	public function buscarEmpleadoPorCedula($cedula){
          
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado WHERE num_documento = ?");
		$sql->bindParam(1, $cedula);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarId[] = $filas;
        }

        return $listarId;
	}

	
	public function buscarEmpleadoActivoPorCedula($cedula){
          
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado WHERE num_documento = ? AND estado = 1 ");
		$sql->bindParam(1, $cedula);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarId[] = $filas;
        }

        return $listarId;
	}

	public function bloquear($id){
          try {
          	$con = Conexion::conectar();
          	$sql = $con->prepare("UPDATE empleado SET estado = 0 WHERE id_empleado = ?");
          	$sql->bindParam(1, $id);
          	$sql->execute();

          	if ($sql) {
          		header("Location: ../Vista/empleados.php");
          	}
          } catch (Exception $e) {
          	echo $e->getMessage();
          }
	}

	public function desbloquear($id){
          try {
          	$con = Conexion::conectar();
          	$sql = $con->prepare("UPDATE empleado SET estado = 1 WHERE id_empleado = ?");
          	$sql->bindParam(1, $id);
          	$sql->execute();

          	if ($sql) {
          		header("Location: ../Vista/empleados.php");
          	}
          } catch (Exception $e) {
          	echo $e->getMessage();
          }
	}

	public function registrar($nombres, $apellidos, $num_documento, $hoja_vida, $correo, $fotocopia_doc, $contrato, $examen_medico, $empresa, $contraloria, $procuraduria, $policia, $simit, $personeria, $actualizacion_datos, $manual_funciones, $fecha_nac, $direccion, $telefono, $celular, $cargo, $fecha_contrato, $eps, $arl, $pension, $cesantias, $caja_compensacion, $afiliacion_eps, $afiliacion_arl, $afiliacion_caja, $fecha_examen, $fecha_actualizacion, $tipo_contrato, $fecha_fin_contrato, $estado, $fecha_creacion){

		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO empleado (nombres, apellidos, num_documento, hoja_vida, correo, fotocopia_doc, contrato, examen_medico, empresa, contraloria, procuraduria, policia, simit, personeria, actualizacion_datos, manual_funciones, fecha_nac, direccion, telefono, celular, cargo, fecha_contrato, eps, arl, pension, cesantias, caja_compensacion, afiliacion_eps, afiliacion_arl, afiliacion_caja, fecha_examen, fecha_actualizacion, tipo_contrato, fecha_fin_contrato, estado, fecha_creacion) VALUES (:nombres, :apellidos, :num_documento, :hoja_vida, :correo, :fotocopia_doc, :contrato, :examen_medico, :empresa, :contraloria, :procuraduria, :policia, :simit, :personeria, :actualizacion_datos, :manual_funciones, :fecha_nac, :direccion, :telefono, :celular, :cargo, :fecha_contrato, :eps, :arl, :pension, :cesantias, :caja_compensacion, :afiliacion_eps, :afiliacion_arl, :afiliacion_caja, :fecha_examen, :fecha_actualizacion, :tipo_contrato, :fecha_fin_contrato, :estado, :fecha_creacion)");

			$sql->bindParam(':nombres', $nombres);
			$sql->bindParam(':apellidos', $apellidos);
			$sql->bindParam(':num_documento', $num_documento);
			$sql->bindParam(':hoja_vida', $hoja_vida);
			$sql->bindParam(':correo', $correo);
			$sql->bindParam(':fotocopia_doc', $fotocopia_doc);
			$sql->bindParam(':contrato', $contrato);
			$sql->bindParam(':examen_medico', $examen_medico);
			$sql->bindParam(':empresa', $empresa);
			$sql->bindParam(':contraloria', $contraloria);
			$sql->bindParam(':procuraduria', $procuraduria);
			$sql->bindParam(':policia', $policia);
			$sql->bindParam(':simit', $simit);
			$sql->bindParam(':personeria', $personeria);
			$sql->bindParam(':actualizacion_datos', $actualizacion_datos);
			$sql->bindParam(':manual_funciones', $manual_funciones);
			$sql->bindParam(':fecha_nac', $fecha_nac);
			$sql->bindParam(':direccion', $direccion);
			$sql->bindParam(':telefono', $telefono);
			$sql->bindParam(':celular', $celular);
			$sql->bindParam(':cargo', $cargo);
			$sql->bindParam(':fecha_contrato', $fecha_contrato);
			$sql->bindParam(':eps', $eps);
			$sql->bindParam(':arl', $arl);
			$sql->bindParam(':pension', $pension);
			$sql->bindParam(':cesantias', $cesantias);
			$sql->bindParam(':caja_compensacion', $caja_compensacion);
			$sql->bindParam(':afiliacion_eps', $afiliacion_eps);
			$sql->bindParam(':afiliacion_arl', $afiliacion_arl);
			$sql->bindParam(':afiliacion_caja', $afiliacion_caja);
			$sql->bindParam(':fecha_examen', $fecha_examen);
			$sql->bindParam(':fecha_actualizacion', $fecha_actualizacion);
			$sql->bindParam(':tipo_contrato', $tipo_contrato);
			$sql->bindParam(':fecha_fin_contrato', $fecha_fin_contrato);
			$sql->bindParam(':estado', $estado);
			$sql->bindParam(':fecha_creacion', $fecha_creacion);

			$sql->execute();
							
			return $id = $con->lastInsertId();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	
	public function actualizar($id, $nombres, $apellidos, $num_documento, $hoja_vida, $correo, $fotocopia_doc, $contrato, $examen_medico, $empresa, $contraloria, $procuraduria, $policia, $simit, $personeria, $actualizacion_datos, $manual_funciones, $fecha_nac, $direccion, $telefono, $celular, $cargo, $fecha_contrato, $eps, $arl, $pension, $cesantias, $caja_compensacion, $afiliacion_eps, $afiliacion_arl, $afiliacion_caja, $fecha_examen, $fecha_actualizacion, $tipo_contrato, $fecha_fin_contrato,$induccion,$fecha_induccion,$evaluacion,$fecha_evaluacion){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE empleado SET nombres = :nombres, apellidos = :apellidos, num_documento = :num_documento, hoja_vida = :hoja_vida, correo = :correo, fotocopia_doc = :fotocopia_doc, contrato = :contrato, examen_medico = :examen_medico, empresa = :empresa, contraloria = :contraloria, procuraduria = :procuraduria, policia = :policia, simit = :simit, personeria = :personeria, actualizacion_datos = :actualizacion_datos, manual_funciones = :manual_funciones, fecha_nac = :fecha_nac, direccion = :direccion, telefono = :telefono, celular = :celular, cargo = :cargo, fecha_contrato = :fecha_contrato, eps = :eps, arl = :arl, pension = :pension, cesantias = :cesantias, caja_compensacion = :caja_compensacion, afiliacion_eps = :afiliacion_eps, afiliacion_arl = :afiliacion_arl, afiliacion_caja = :afiliacion_caja, fecha_examen = :fecha_examen, fecha_actualizacion = :fecha_actualizacion, tipo_contrato = :tipo_contrato, fecha_fin_contrato = :fecha_fin_contrato, induccion = :induccion, fecha_exp_induccion = :fecha_induccion, evaluacion = :evaluacion, fecha_exp_evaluacion = :fecha_evaluacion WHERE id_empleado = :id");

			$sql->bindParam(":id", $id);
			$sql->bindParam(':nombres', $nombres);
			$sql->bindParam(':apellidos', $apellidos);
			$sql->bindParam(':num_documento', $num_documento);
			$sql->bindParam(':hoja_vida', $hoja_vida);
			$sql->bindParam(':correo', $correo);
			$sql->bindParam(':fotocopia_doc', $fotocopia_doc);
			$sql->bindParam(':contrato', $contrato);
			$sql->bindParam(':examen_medico', $examen_medico);
			$sql->bindParam(':empresa', $empresa);
			$sql->bindParam(':contraloria', $contraloria);
			$sql->bindParam(':procuraduria', $procuraduria);
			$sql->bindParam(':policia', $policia);
			$sql->bindParam(':simit', $simit);
			$sql->bindParam(':personeria', $personeria);
			$sql->bindParam(':actualizacion_datos', $actualizacion_datos);
			$sql->bindParam(':manual_funciones', $manual_funciones);
			$sql->bindParam(':fecha_nac', $fecha_nac);
			$sql->bindParam(':direccion', $direccion);
			$sql->bindParam(':telefono', $telefono);
			$sql->bindParam(':celular', $celular);
			$sql->bindParam(':cargo', $cargo);
			$sql->bindParam(':fecha_contrato', $fecha_contrato);
			$sql->bindParam(':eps', $eps);
			$sql->bindParam(':arl', $arl);
			$sql->bindParam(':pension', $pension);
			$sql->bindParam(':cesantias', $cesantias);
			$sql->bindParam(':caja_compensacion', $caja_compensacion);
			$sql->bindParam(':afiliacion_eps', $afiliacion_eps);
			$sql->bindParam(':afiliacion_arl', $afiliacion_arl);
			$sql->bindParam(':afiliacion_caja', $afiliacion_caja);
			$sql->bindParam(':fecha_examen', $fecha_examen);
			$sql->bindParam(':fecha_actualizacion', $fecha_actualizacion);
			$sql->bindParam(':tipo_contrato', $tipo_contrato);
			$sql->bindParam(':fecha_fin_contrato', $fecha_fin_contrato);
			$sql->bindParam(':induccion', $induccion);
			$sql->bindParam(':fecha_induccion', $fecha_induccion);
			$sql->bindParam(':evaluacion', $evaluacion);
			$sql->bindParam(':fecha_evaluacion', $fecha_evaluacion);

			$sql->execute();

			//echo "UPDATE empleado SET nombres = '$nombres', apellidos = '$apellidos', num_documento = '$num_documento', hoja_vida = '$hoja_vida', correo = '$correo', fotocopia_doc = '$fotocopia_doc', contrato = '$contrato', examen_medico = '$examen_medico', empresa = '$empresa', contraloria = '$contraloria', procuraduria = '$procuraduria', policia = '$policia', simit = '$simit', personeria = '$personeria', actualizacion_datos = '$actualizacion_datos', manual_funciones = '$manual_funciones', fecha_nac = '$fecha_nac', direccion = '$direccion', telefono = '$telefono', celular = '$celular', cargo = '$cargo', fecha_contrato = '$fecha_contrato', eps = '$eps', arl = '$arl', pension = '$pension', cesantias = '$cesantias', caja_compensacion = '$caja_compensacion', afiliacion_eps = '$afiliacion_eps', afiliacion_arl = '$afiliacion_arl', afiliacion_caja = '$afiliacion_caja', fecha_examen = '$fecha_examen', fecha_actualizacion = '$fecha_actualizacion', tipo_contrato = '$tipo_contrato', fecha_fin_contrato = '$fecha_fin_contrato', induccion = '$induccion', fecha_exp_induccion = '$fecha_induccion', evaluacion = '$evaluacion', fecha_exp_evaluacion = '$fecha_evaluacion' WHERE id_empleado = '$id'";

		} catch (Exception $e) {
			$e->getMessage();
		}
	}

	//INICIO CURSOS
	public function listarCursos(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_cursos");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function listarCursoPorId($id){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_cursos WHERE id = :id");
		$sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function listarCursosEmpleado($id){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_cursos WHERE id_empleado = :id order by fecha_curso Desc, id Desc");
		$sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function registrarCurso($nombre_curso, $intensidad, $institucion, $certificado, $fecha_curso, $id_empleado){

		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO empleado_cursos (nombre_curso, intensidad_horas, institucion, certificado, fecha_curso, id_empleado) VALUES (:nombre_curso, :intensidad, :institucion, :certificado, :fecha_curso, :id_empleado)");

			$sql->bindParam(':nombre_curso', $nombre_curso);
			$sql->bindParam(':intensidad', $intensidad);
			$sql->bindParam(':institucion', $institucion);
			$sql->bindParam(':certificado', $certificado);
			$sql->bindParam(':fecha_curso', $fecha_curso);
			$sql->bindParam(':id_empleado', $id_empleado);

			$sql->execute();
							
			return $id = $con->lastInsertId();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	
	public function actualizarCurso($id, $nombre_curso, $intensidad, $institucion, $certificado, $fecha_curso, $id_empleado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE empleado_cursos SET nombre_curso = :nombre_curso, intensidad_horas = :intensidad, institucion = :institucion, certificado = :certificado, fecha_curso = :fecha_curso, id_empleado = :id_empleado WHERE id = :id");

			$sql->bindParam(":id", $id);
			$sql->bindParam(':nombre_curso', $nombre_curso);
			$sql->bindParam(':intensidad', $intensidad);
			$sql->bindParam(':institucion', $institucion);
			$sql->bindParam(':certificado', $certificado);
			$sql->bindParam(':fecha_curso', $fecha_curso);
			$sql->bindParam(':id_empleado', $id_empleado);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function borrarCurso($id){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM empleado_cursos WHERE id = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function borrarCursosEmpleado($id){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM empleado_cursos WHERE id_empleado = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	//FIN CURSOS
	
	//INICIO ESTUDIOS
	public function listarEstudio(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_estudio");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function listarEstudioPorId($id){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_estudio WHERE id = :id");
		$sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function listarEstudiosEmpleado($id){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_estudio WHERE id_empleado = :id order by fecha_grado Desc, id Desc");
		$sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function registrarEstudio($titulo, $universidad, $nivel, $fecha_grado, $diploma, $id_empleado){

		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO empleado_estudio (titulo, universidad, nivel, fecha_grado, diploma, id_empleado) VALUES (:titulo, :universidad, :nivel, :fecha_grado, :diploma, :id_empleado)");

			$sql->bindParam(':titulo', $titulo);
			$sql->bindParam(':universidad', $universidad);
			$sql->bindParam(':nivel', $nivel);
			$sql->bindParam(':fecha_grado', $fecha_grado);
			$sql->bindParam(':diploma', $diploma);
			$sql->bindParam(':id_empleado', $id_empleado);

			$sql->execute();
			//echo "INSERT INTO empleado_estudio (titulo, universidad, nivel, fecha_grado, diploma, id_empleado) VALUES ('$titulo', '$universidad', '$nivel', '$fecha_grado', '$diploma', '$id_empleado')";
			return $id = $con->lastInsertId();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	
	public function actualizarEstudio($id, $titulo, $universidad, $nivel, $fecha_grado, $diploma, $id_empleado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE empleado_estudio SET titulo = :titulo, universidad = :universidad, nivel = :nivel, fecha_grado = :fecha_grado, diploma = :diploma, id_empleado = :id_empleado WHERE id = :id");

			$sql->bindParam(":id", $id);
			$sql->bindParam(':titulo', $titulo);
			$sql->bindParam(':universidad', $universidad);
			$sql->bindParam(':nivel', $nivel);
			$sql->bindParam(':fecha_grado', $fecha_grado);
			$sql->bindParam(':diploma', $diploma);
			$sql->bindParam(':id_empleado', $id_empleado);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function borrarEstudio($id){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM empleado_estudio WHERE id = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function borrarEstudiosEmpleado($id){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM empleado_estudio WHERE id_empleado = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	//FIN ESTUDIOS
	
	//INICIO EXPERIENCIA
	public function listarExperiencia(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_experiencia");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function listarExperienciaPorId($id){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_experiencia WHERE id = :id");
		$sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function listarExperienciaEmpleado($id){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_experiencia WHERE id_empleado = :id order by fecha_inicio Desc, id Desc");
		$sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function registrarExperiencia($empresa, $fechai, $fechaf, $cargo, $telefono, $jefe, $certificado, $id_empleado){

		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO empleado_experiencia (nombre_empresa, fecha_inicio, fecha_fin, cargo, telefono, jefe_inmediato, certificado, id_empleado) VALUES (:empresa, :fechai, :fechaf, :cargo, :telefono, :jefe, :certificado, :id_empleado)");

			$sql->bindParam(':empresa', $empresa);
			$sql->bindParam(':fechai', $fechai);
			$sql->bindParam(':fechaf', $fechaf);
			$sql->bindParam(':cargo', $cargo);
			$sql->bindParam(':telefono', $telefono);
			$sql->bindParam(':jefe', $jefe);
			$sql->bindParam(':certificado', $certificado);
			$sql->bindParam(':id_empleado', $id_empleado);
			
			//echo "INSERT INTO empleado_experiencia (nombre_empresa, fecha_inicio, fecha_fin, cargo, telefono, jefe_inmediato, certificado, id_empleado) VALUES ('$empresa', '$fechai', '$fechaf', '$cargo', '$telefono', '$jefe', '$certificado', '$id_empleado')";
			
			$sql->execute();
							
			return $id = $con->lastInsertId();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	
	public function actualizarExperiencia($id, $empresa, $fechai, $fechaf, $cargo, $telefono, $jefe, $certificado, $id_empleado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE empleado_experiencia SET nombre_empresa = :empresa, fecha_inicio = :fechai, fecha_fin = :fechaf, cargo = :cargo, telefono = :telefono, jefe_inmediato = :jefe, certificado = :certificado, id_empleado = :id_empleado WHERE id = :id");

			$sql->bindParam(":id", $id);
			$sql->bindParam(':empresa', $empresa);
			$sql->bindParam(':fechai', $fechai);
			$sql->bindParam(':fechaf', $fechaf);
			$sql->bindParam(':cargo', $cargo);
			$sql->bindParam(':telefono', $telefono);
			$sql->bindParam(':jefe', $jefe);
			$sql->bindParam(':certificado', $certificado);
			$sql->bindParam(':id_empleado', $id_empleado);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function borrarExperiencia($id){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM empleado_experiencia WHERE id = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function borrarExperienciasEmpleado($id){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM empleado_experiencia WHERE id_empleado = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	//FIN EXPERIENCIA
	
	//INICIO OTROS DOCUMENTOS
	public function listarDocumentos(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_otros_docs");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function listarDocumentoPorId($id){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_otros_docs WHERE id_doc = :id");
		$sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function listarDocumentosEmpleado($id){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM empleado_otros_docs WHERE id_empleado = :id order by id_doc Desc");
		$sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}
	
	public function registrarDocumento($nombre, $archivo, $id_empleado){

		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO empleado_otros_docs (nombre_doc, archivo, id_empleado) VALUES (:nombre, :archivo, :id_empleado)");

			$sql->bindParam(':nombre', $nombre);
			$sql->bindParam(':archivo', $archivo);
			$sql->bindParam(':id_empleado', $id_empleado);

			$sql->execute();
							
			return $id = $con->lastInsertId();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	
	public function actualizarDocumento($id, $nombre, $archivo, $id_empleado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE empleado_otros_docs SET nombre_doc = :nombre, archivo = :archivo, id_empleado = :id_empleado WHERE id = :id");

			$sql->bindParam(":id", $id);
			$sql->bindParam(':nombre', $nombre);
			$sql->bindParam(':archivo', $archivo);
			$sql->bindParam(':id_empleado', $id_empleado);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function borrarDocumento($id){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM empleado_otros_docs WHERE id_doc = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function borrarDocumentosEmpleado($id){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("DELETE FROM empleado_otros_docs WHERE id_empleado = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	//FIN OTROS DOCUMENTOS

	public function registrarSeguridadSocialEmpleado($nombre_documento, $seguridad_social, $anio, $mes, $usuario_carga_doc){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO seguridad_social_empleados (nombre_documento, seguridad_social, anio, mes, usuario_carga_doc) VALUES(:nombre_documento, :seguridad_social, :anio, :mes, :usuario_carga_doc) ");

			$sql->bindParam(":nombre_documento", $nombre_documento);
			$sql->bindParam(":seguridad_social", $seguridad_social);
			$sql->bindParam(":anio", $anio);
			$sql->bindParam(":mes", $mes);
			$sql->bindParam(":usuario_carga_doc", $usuario_carga_doc);

			$sql->execute();

			//echo "INSERT INTO seguridad_social_empleados (id_empleado, seguridad_social, anio, mes) VALUES('$id_empleado', '$seguridad_social', '$anio', '$mes')";

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function actualizarSeguridadSocialEmpleado($id, $nombre_documento, $seguridad_social, $anio, $mes){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE seguridad_social_empleados SET nombre_documento = :nombre_documento, seguridad_social = :seguridad_social, anio = :anio, mes = :mes WHERE id = :id ");

			$sql->bindParam(":id", $id);
			$sql->bindParam(":nombre_documento", $nombre_documento);
			$sql->bindParam(":seguridad_social", $seguridad_social);
			$sql->bindParam(":anio", $anio);
			$sql->bindParam(":mes", $mes);

			$sql->execute();

			//echo "UPDATE seguridad_social_empleados SET nombre_documento = '$nombre_documento', seguridad_social = '$seguridad_social', anio = '$anio', mes = '$mes' WHERE id = '$id' )";

		} catch (Exception $e) {
			$e->getMessage();
		}
	}

	public function listarSS(){
		$listarSS = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM seguridad_social_empleados ORDER BY id DESC");

		$sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarSS[] = $filas;
        }

        return $listarSS;
	}
	
	

	public function listarSSporID($id){
		$listarSSID = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM seguridad_social_empleados WHERE id = :id");
		$sql->bindParam(":id", $id);

		$sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarSSID[] = $filas;
        }

        return $listarSSID;
	}
	
	
	

	public function eliminarSSporID($id){
	    try{
    	    $con = Conexion::conectar();
    		$sql = $con->prepare("DELETE FROM seguridad_social_empleados WHERE id = :id");
    		$sql->bindParam(":id", $id);
    		
    		//echo "DELETE FROM seguridad_social_empleados WHERE id = '$id' ";
    
    		$sql->execute();
	    }catch(Exception $e){
	       echo $e->getMessage(); 
	    }
		
	}
	
}


?>