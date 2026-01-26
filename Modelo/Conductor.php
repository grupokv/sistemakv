<?php 

require_once("Conexion/conexionBD.php");

class Conductor
{

	public function listar(){
		$listar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM conductores");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	}

	public function listarPorId($id_conductor){
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM conductores WHERE id_conductor = ?");
		$sql->bindParam(1, $id_conductor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarId[] = $filas;
        }

        return $listarId;
	}

	public function listarSSPorId($id_conductor){
		$listarSSId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM conductor_seg_social WHERE id_conductor = :id_conductor");
		$sql->bindParam(":id_conductor", $id_conductor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarSSId[] = $filas;
        }

        return $listarSSId;
	}

	public function actualizarPorDocumentoYFechaVencimiento($id_conductor, $nombre_documento, $nuevo_documento, $fecha_vencimiento, $nueva_fecha_vencimiento){

            try {

                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE conductores SET :nombre_documento = :nuevo_documento, $fecha_vencimiento = :nueva_fecha_vencimiento WHERE id_conductor = :id_conductor");
                $sql->bindParam(":id_conductor", $id_conductor);
                $sql->bindParam(":nombre_documento", $nombre_documento);
                $sql->bindParam(":nuevo_documento", $nuevo_documento);
                $sql->bindParam(":nueva_fecha_vencimiento", $nueva_fecha_vencimiento);
                $sql->execute();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
    }

	public function actualizarPorDocumento($id_conductor, $nombre_documento, $nuevo_documento){

            try {

                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE conductores SET :nombre_documento = :nuevo_documento WHERE id_conductor = :id_conductor");
                $sql->bindParam(":id_conductor", $id_conductor);
                $sql->bindParam(":nombre_documento", $nombre_documento);
                $sql->bindParam(":nuevo_documento", $nuevo_documento);
                $sql->execute();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
    }

    public function registrarDocumentoSS($id_conductor, $mes, $nuevo_documento){

            try {

                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO (id_conductor, anno :mes) VALUES(:id_conductor, :anno, :nuevo_documento)");
                $sql->bindParam(":id_conductor", $id_conductor);
                $sql->bindParam(":anno", $anno);
                $sql->bindParam(":mes", $mes);
                $sql->bindParam(":nuevo_documento", $nuevo_documento);
                $sql->execute();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
    }

	public function actualizarDocumentoSeguridadSocial($id_conductor, $mes_ss, $nuevo_documento){

            try {

                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE conductor_seg_social SET :mes_ss = :nuevo_documento WHERE id_conductor = :id_conductor");
                $sql->bindParam(":id_conductor", $id_conductor);
                $sql->bindParam(":mes_ss", $mes_ss);
                $sql->bindParam(":nuevo_documento", $nuevo_documento);
                $sql->execute();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
    }

	public function buscarPlanillasPorConductor($id_conductor,$anno){
          
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM conductor_seg_social WHERE id_conductor = ? and anno = ?");
		$sql->bindParam(1, $id_conductor);
		$sql->bindParam(2, $anno);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarId[] = $filas;
        }

        return $listarId;
	}

	public function bloquear($id_conductor){
          try {
          	$con = Conexion::conectar();
          	$sql = $con->prepare("UPDATE conductores SET estado = 0 WHERE id_conductor = ?");
          	$sql->bindParam(1, $id_conductor);
          	$sql->execute();

          	if ($sql) {
          		header("Location: ../Vista/conductores.php");
          	}
          } catch (Exception $e) {
          	echo $e->getMessage();
          }
	}

	public function desbloquear($id_conductor){
          try {
          	$con = Conexion::conectar();
          	$sql = $con->prepare("UPDATE conductores SET estado = 1 WHERE id_conductor = ?");
          	$sql->bindParam(1, $id_conductor);
          	$sql->execute();

          	if ($sql) {
          		header("Location: ../Vista/conductores.php");
          	}
          } catch (Exception $e) {
          	echo $e->getMessage();
          }
	}

	public function registrar($nombre_conductor, $numero_documento_conductor, $correo, $fecha_nacimiento_conductor, $fotocopia_documento, $fotocopia_licencia, $categoria_licencia, $num_licencia, $fecha_vencimiento_licencia, $direccion, $genero, $grupo_sanguineo, $estado_civil, $telefono1, $telefono2, $telefono3, $pago_pactado, $certificados_laborales, $certificados_estudios, $certificados_cursos, $libreta_militar, $examen_medico, $fecha_expedicion_examen_medico, $planilla_ss, $fotografia_conductor, $hoja_vida, $procuraduria, $fecha_procuraduria, $contraloria, $fecha_contraloria, $personeria, $fecha_personeria, $simit, $fecha_simit, $policia, $fecha_policia, $rut, $vacunas, $contrato_trabajo, $fecha_contrato){

		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO conductores(nombre_conductor, numero_documento_conductor, correo_electronico, fecha_nacimiento_conductor, fotocopia_documento, fotocopia_licencia, categoria_licencia, num_licencia, fecha_vencimiento_licencia, direccion, genero, grupo_sanguineo, estado_civil, telefono1, telefono2, telefono3, pago_pactado, certificados_laborales, certificados_estudios, certificados_cursos, libreta_militar, examen_medico, fecha_expedicion_examen_medico, planilla_ss, fotografia_conductor, hoja_vida, procuraduria, fecha_procuraduria, contraloria, fecha_contraloria, personeria, fecha_personeria, simit, fecha_simit, policia, fecha_policia, rut, vacunas, contrato_trabajo, fecha_contrato, estado) VALUES (:nombre_conductor, :numero_documento_conductor, :correo, :fecha_nacimiento_conductor, :fotocopia_documento, :fotocopia_licencia, :categoria_licencia, :num_licencia, :fecha_vencimiento_licencia, :direccion, :genero, :grupo_sanguineo, :estado_civil, :telefono1, :telefono2, :telefono3, :pago_pactado, :certificados_laborales, :certificados_estudios, :certificados_cursos, :libreta_militar, :examen_medico, :fecha_expedicion_examen_medico, :planilla_ss, :fotografia_conductor, :hoja_vida, :procuraduria, :fecha_procuraduria, :contraloria, :fecha_contraloria, :personeria, :fecha_personeria, :simit, :fecha_simit, :policia, :fecha_policia, :rut, :vacunas, :contrato_trabajo, :fecha_contrato, 1)");

			$sql->bindParam(':nombre_conductor', $nombre_conductor);
			$sql->bindParam(':numero_documento_conductor', $numero_documento_conductor);
			$sql->bindParam(':correo', $correo);
			$sql->bindParam(':fecha_nacimiento_conductor', $fecha_nacimiento_conductor);
			$sql->bindParam(':fotocopia_documento', $fotocopia_documento);
			$sql->bindParam(':fotocopia_licencia', $fotocopia_licencia);
			$sql->bindParam(':categoria_licencia', $categoria_licencia);
			$sql->bindParam(':num_licencia', $num_licencia);
			$sql->bindParam(':fecha_vencimiento_licencia', $fecha_vencimiento_licencia);
			$sql->bindParam(':direccion', $direccion);
			$sql->bindParam(':genero', $genero);
			$sql->bindParam(':grupo_sanguineo', $grupo_sanguineo);
			$sql->bindParam(':estado_civil', $estado_civil);
			$sql->bindParam(':telefono1', $telefono1);
			$sql->bindParam(':telefono2', $telefono2);
			$sql->bindParam(':telefono3', $telefono3);
			$sql->bindParam(':pago_pactado', $pago_pactado);
			$sql->bindParam(':certificados_laborales', $certificados_laborales);
			$sql->bindParam(':certificados_estudios', $certificados_estudios);
			$sql->bindParam(':certificados_cursos', $certificados_cursos);
			$sql->bindParam(':libreta_militar', $libreta_militar);
			$sql->bindParam(':examen_medico', $examen_medico);
			$sql->bindParam(':fecha_expedicion_examen_medico', $fecha_expedicion_examen_medico);
			$sql->bindParam(':planilla_ss', $planilla_ss);
			$sql->bindParam(':fotografia_conductor', $fotografia_conductor);
			$sql->bindParam(':hoja_vida', $hoja_vida);
			$sql->bindParam(':procuraduria', $procuraduria);
			$sql->bindParam(':fecha_procuraduria', $fecha_procuraduria);
			$sql->bindParam(':contraloria', $contraloria);
			$sql->bindParam(':fecha_contraloria', $fecha_contraloria);
			$sql->bindParam(':personeria', $personeria);
			$sql->bindParam(':fecha_personeria', $fecha_personeria);
			$sql->bindParam(':simit', $simit);
			$sql->bindParam(':fecha_simit', $fecha_simit);
			$sql->bindParam(':policia', $policia);
			$sql->bindParam(':fecha_policia', $fecha_policia);
			$sql->bindParam(':rut', $rut);
			$sql->bindParam(':vacunas', $vacunas);
			$sql->bindParam(':contrato_trabajo', $contrato_trabajo);
			$sql->bindParam(':fecha_contrato', $fecha_contrato);

			$sql->execute();
							//echo "INSERT INTO conductores(nombre_conductor, numero_documento_conductor, correo_electronico, fecha_nacimiento_conductor, fotocopia_documento, fotocopia_licencia, categoria_licencia, num_licencia, fecha_vencimiento_licencia, direccion, genero, grupo_sanguineo, estado_civil, telefono1, telefono2, telefono3, pago_pactado, certificados_laborales, certificados_estudios, certificados_cursos, libreta_militar, examen_medico, fecha_expedicion_examen_medico, planilla_ss, fotografia_conductor, hoja_vida, procuraduria, fecha_procuraduria, contraloria, fecha_contraloria, personeria, fecha_personeria, simit, fecha_simit, policia, fecha_policia, rut, vacunas, contrato_trabajo, fecha_contrato, estado) VALUES ('$nombre_conductor', '$numero_documento_conductor', '$correo', '$fecha_nacimiento_conductor', '$fotocopia_documento', '$fotocopia_licencia', '$categoria_licencia', '$num_licencia', '$fecha_vencimiento_licencia', '$direccion', '$genero', '$grupo_sanguineo', '$estado_civil', '$telefono1', '$telefono2', '$telefono3', '$pago_pactado', '$certificados_laborales', '$certificados_estudios', '$certificados_cursos', '$libreta_militar', '$examen_medico', '$fecha_expedicion_examen_medico', '$planilla_ss', '$fotografia_conductor', '$hoja_vida', '$procuraduria', '$fecha_procuraduria', '$contraloria', '$fecha_contraloria', '$personeria', '$fecha_personeria', '$simit', '$fecha_simit', '$policia', '$fecha_policia', '$rut', '$vacunas', '$contrato_trabajo', '$fecha_contrato', 1)";
			return $id_conductor = $con->lastInsertId();

			

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function registrarSS($id_conductor, $anno, $ene, $feb, $mar, $abr, $may, $jun, $jul, $ago, $sep, $oct, $nov, $dic){

		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO conductor_seg_social(id_conductor, anno, enero, febrero, marzo, abril, mayo, junio, julio, agosto, septiembre, octubre, noviembre, diciembre) VALUES (:id_conductor, :anno, :ene, :feb, :mar, :abr, :may, :jun, :jul, :ago, :sep, :oct, :nov, :dic)");

			$sql->bindParam(":ene", $ene);
			$sql->bindParam(":feb", $feb);
			$sql->bindParam(":mar", $mar);
			$sql->bindParam(":abr", $abr);
			$sql->bindParam(":may", $may);
			$sql->bindParam(":jun", $jun);
			$sql->bindParam(":jul", $jul);
			$sql->bindParam(":ago", $ago);
			$sql->bindParam(":sep", $sep);
			$sql->bindParam(":oct", $oct);
			$sql->bindParam(":nov", $nov);
			$sql->bindParam(":dic", $dic);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":anno", $anno);

			$sql->execute();
			
			echo "INSERT INTO conductor_seg_social(id_conductor, anno, enero, febrero, marzo, abril, mayo, junio, julio, agosto, septiembre, octubre, noviembre, diciembre) VALUES ('$id_conductor', '$anno', '$ene', '$feb', '$mar', '$abr', '$may', '$jun', '$jul', '$ago', '$sep', '$oct', '$nov', '$dic')";
			
			return $id_conductor = $con->lastInsertId();

			

		} catch (Exception $e) {
			$e->getMessage();
		}
	}
	
	public function actualizarConductor($id_conductor, $nombre_conductor, $numero_documento_conductor, $correo, $fecha_nacimiento_conductor, $fotocopia_documento, $fotocopia_licencia, $categoria_licencia, $num_licencia, $fecha_vencimiento_licencia, $direccion, $genero, $grupo_sanguineo, $estado_civil, $telefono1, $telefono2, $telefono3, $pago_pactado, $certificados_laborales, $certificados_estudios, $certificados_cursos, $libreta_militar, $examen_medico, $fecha_expedicion_examen_medico, $planilla_ss, $fotografia_conductor, $hoja_vida, $procuraduria, $fecha_procuraduria, $contraloria, $fecha_contraloria, $personeria, $fecha_personeria, $simit, $fecha_simit, $policia, $fecha_policia, $rut, $vacunas, $contrato_trabajo, $fecha_contrato, $estado){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE conductores SET nombre_conductor = :nombre_conductor, numero_documento_conductor = :numero_documento_conductor, correo_electronico = :correo, fecha_nacimiento_conductor = :fecha_nacimiento_conductor, fotocopia_documento = :fotocopia_documento, fotocopia_licencia = :fotocopia_licencia, categoria_licencia = :categoria_licencia, num_licencia = :num_licencia, fecha_vencimiento_licencia = :fecha_vencimiento_licencia, direccion = :direccion, genero = :genero, grupo_sanguineo = :grupo_sanguineo, estado_civil = :estado_civil, telefono1 = :telefono1, telefono2 = :telefono2, telefono3 = :telefono3, pago_pactado = :pago_pactado, certificados_laborales = :certificados_laborales, certificados_estudios = :certificados_estudios, certificados_cursos = :certificados_cursos, libreta_militar = :libreta_militar, examen_medico = :examen_medico, fecha_expedicion_examen_medico = :fecha_expedicion_examen_medico, planilla_ss = :planilla_ss, fotografia_conductor = :fotografia_conductor, hoja_vida = :hoja_vida, procuraduria = :procuraduria, fecha_procuraduria = :fecha_procuraduria, contraloria = :contraloria, fecha_contraloria = :fecha_contraloria, personeria = :personeria, fecha_personeria = :fecha_personeria, simit = :simit, fecha_simit = :fecha_simit, policia = :policia, fecha_policia = :fecha_policia, rut = :rut, vacunas = :vacunas, contrato_trabajo = :contrato_trabajo, fecha_contrato = :fecha_contrato, estado = :estado WHERE id_conductor = :id_conductor");

			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":nombre_conductor", $nombre_conductor);
			$sql->bindParam(":numero_documento_conductor", $numero_documento_conductor);
			$sql->bindParam(':correo', $correo);
			$sql->bindParam(":fecha_nacimiento_conductor", $fecha_nacimiento_conductor);
			$sql->bindParam(":fotocopia_documento", $fotocopia_documento);
			$sql->bindParam(":fotocopia_licencia", $fotocopia_licencia);
			$sql->bindParam(":categoria_licencia", $categoria_licencia);
			$sql->bindParam(":num_licencia", $num_licencia);
			$sql->bindParam(":fecha_vencimiento_licencia", $fecha_vencimiento_licencia);
			$sql->bindParam(":direccion", $direccion);
			$sql->bindParam(":genero", $genero);
			$sql->bindParam(":grupo_sanguineo", $grupo_sanguineo);
			$sql->bindParam(":estado_civil", $estado_civil);
			$sql->bindParam(":telefono1", $telefono1);
			$sql->bindParam(":telefono2", $telefono2);
			$sql->bindParam(":telefono3", $telefono3);
			$sql->bindParam(":pago_pactado", $pago_pactado);
			$sql->bindParam(":certificados_laborales", $certificados_laborales);
			$sql->bindParam(":certificados_estudios", $certificados_estudios);
			$sql->bindParam(":certificados_cursos", $certificados_cursos);
			$sql->bindParam(":libreta_militar", $libreta_militar);
			$sql->bindParam(":examen_medico", $examen_medico);
			$sql->bindParam(":fecha_expedicion_examen_medico", $fecha_expedicion_examen_medico);
			$sql->bindParam(":planilla_ss", $planilla_ss);
			$sql->bindParam(":fotografia_conductor", $fotografia_conductor);
			$sql->bindParam(':hoja_vida', $hoja_vida);
			$sql->bindParam(':procuraduria', $procuraduria);
			$sql->bindParam(':fecha_procuraduria', $fecha_procuraduria);
			$sql->bindParam(':contraloria', $contraloria);
			$sql->bindParam(':fecha_contraloria', $fecha_contraloria);
			$sql->bindParam(':personeria', $personeria);
			$sql->bindParam(':fecha_personeria', $fecha_personeria);
			$sql->bindParam(':simit', $simit);
			$sql->bindParam(':fecha_simit', $fecha_simit);
			$sql->bindParam(':policia', $policia);
			$sql->bindParam(':fecha_policia', $fecha_policia);
			$sql->bindParam(':rut', $rut);
			$sql->bindParam(':vacunas', $vacunas);
			$sql->bindParam(':contrato_trabajo', $contrato_trabajo);
			$sql->bindParam(':fecha_contrato', $fecha_contrato);
			$sql->bindParam(":estado", $estado);

			$sql->execute();

			//echo "UPDATE conductores SET nombre_conductor = '$nombre_conductor', numero_documento_conductor = '$numero_documento_conductor',  = '$correo', fecha_nacimiento_conductor = '$fecha_nacimiento_conductor', fotocopia_documento = '$fotocopia_documento', fotocopia_licencia = '$fotocopia_licencia', categoria_licencia = '$categoria_licencia', num_licencia = '$num_licencia', fecha_vencimiento_licencia = '$fecha_vencimiento_licencia', direccion = '$direccion', genero = '$genero', grupo_sanguineo = '$grupo_sanguineo', estado_civil = '$estado_civil', telefono1 = '$telefono1', telefono2 = '$telefono2', telefono3 = '$telefono3', pago_pactado = '$pago_pactado', certificados_laborales = '$certificados_laborales', certificados_estudios = '$certificados_estudios', certificados_cursos = '$certificados_cursos', libreta_militar = '$libreta_militar', examen_medico = '$examen_medico', fecha_expedicion_examen_medico = '$fecha_expedicion_examen_medico', planilla_ss = '$planilla_ss', fotografia_conductor = '$fotografia_conductor', hoja_vida = '$hoja_vida', procuraduria = '$procuraduria', fecha_procuraduria = '$fecha_procuraduria', contraloria = '$contraloria', fecha_contraloria = '$fecha_contraloria', personeria = '$personeria', fecha_personeria = '$fecha_personeria', simit = '$simit', fecha_simit = '$fecha_simit', policia = '$policia', fecha_policia = '$fecha_policia', rut = '$rut', vacunas = '$vacunas', contrato_trabajo = '$contrato_trabajo', fecha_contrato = '$fecha_contrato', estado = '$estado' WHERE id_conductor = '$id_conductor'";

		} catch (Exception $e) {
			$e->getMessage();
		}
	}

	public function actualizarSS($id_conductor,$anno,$ene,$feb,$mar,$abr,$may,$jun,$jul,$ago,$sep,$oct,$nov,$dic){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE conductor_seg_social SET enero = :ene, febrero = :feb, marzo = :mar, abril = :abr, mayo = :may, junio = :jun, julio = :jul, agosto = :ago, septiembre = :sep, octubre = :oct, noviembre = :nov, diciembre = :dic WHERE id_conductor = :id_conductor and anno = :anno");
			
			$sql->bindParam(":ene", $ene);
			$sql->bindParam(":feb", $feb);
			$sql->bindParam(":mar", $mar);
			$sql->bindParam(":abr", $abr);
			$sql->bindParam(":may", $may);
			$sql->bindParam(":jun", $jun);
			$sql->bindParam(":jul", $jul);
			$sql->bindParam(":ago", $ago);
			$sql->bindParam(":sep", $sep);
			$sql->bindParam(":oct", $oct);
			$sql->bindParam(":nov", $nov);
			$sql->bindParam(":dic", $dic);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":anno", $anno);
			$sql->execute();
			
			/*echo "UPDATE conductor_seg_social SET enero = '$ene', febrero = '$feb', marzo = '$mar', abril = '$abr', mayo = '$may', junio = '$jun', julio = '$jul', agosto = '$ago', septiembre = '$sep', octubre = '$oct', noviembre = '$nov', diciembre = '$dic' WHERE id_conductor = '$id_conductor' and anno = '$anno'";*/
			
		} catch (Exception $e) {
			$e->getMessage();
		}
	}

	public function buscarConductorPorDocumento($num_documento){
    	
    	$numDoc = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM conductores WHERE numero_documento_conductor = :num_documento");
		$sql->bindParam(":num_documento", $num_documento);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$numDoc[] = $filas;
		}

		return $numDoc;	
    }


    /*REPORTES*/

    public function listarConductoresActivos(){
		$listarActivo = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM conductores WHERE estado = 1 ");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarActivo[] = $filas;
        }

        return $listarActivo;
	}
	
	/* ---------------------------------------------- */
    /* ------------------ DOC VACIA ----------------- */
    /* ---------------------------------------------- */

    public function listarDocsFDVacios(){
    	$fdVacios = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE fotocopia_documento = '' AND estado = 1 ");
    	$sql->execute();

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$fdVacios[] = $filas;
    	}

    	return $fdVacios;
    }

    public function listarDocsLCVacios(){
    	$lcVacios = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE (fotocopia_licencia = '' OR fecha_vencimiento_licencia = '0000-00-00') AND estado = 1 ");
    	$sql->execute();

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$lcVacios[] = $filas;
    	}

    	return $lcVacios;
    }
    
    public function listarDocsCLVacios(){
    	$clVacios = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE certificados_laborales = '' AND  estado = 1 ");
    	$sql->execute();

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$clVacios[] = $filas;
    	}

    	return $clVacios;
    }
    
    public function listarDocsCEVacios(){
    	$ceVacios = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE certificados_estudios = '' AND  estado = 1");
    	$sql->execute();

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$ceVacios[] = $filas;
    	}

    	return $ceVacios;
    }
    
    public function listarDocsCCVacios(){
    	$ccVacios = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE certificados_cursos = '' AND  estado = 1");
    	$sql->execute();

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$ccVacios[] = $filas;
    	}

    	return $ccVacios;
    }
    
    public function listarDocsLMVacios(){
    	$lmVacios = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE libreta_militar = '' AND  estado = 1");
    	$sql->execute();

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$lmVacios[] = $filas;
    	}

    	return $lmVacios;
    }

    public function listarDocsEMVacios(){
    	$emVacios = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE examen_medico = '' AND estado = 1");
    	$sql->execute();

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$emVacios[] = $filas;
    	}

    	return $emVacios;
    }

    public function listarDocsPSSVacios(){
    	$pssVacios = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE planilla_ss = '' AND estado = 1 ");
    	$sql->execute();

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$pssVacios[] = $filas;
    	}

    	return $pssVacios;
    }
    
    /* ------------------------------------ */
    /* ---------- FIN DOC VACIA ----------- */
    /* ------------------------------------ */
    
    
    public function listarDocsConductorLcVencidosPorId($id_conductor, $notificarFecha){
    	$lcVencidosId = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE id_conductor = :id_conductor AND (fecha_vencimiento_licencia <= :notificarFecha OR fecha_vencimiento_licencia = '0000-00-00')");
    	$sql->bindParam(":id_conductor", $id_conductor);
    	$sql->bindParam(":notificarFecha", $notificarFecha);
    	$sql->execute();
    	
    	//echo "SELECT * FROM conductores WHERE id_conductor = '$id_conductor' AND (fecha_vencimiento_licencia <= '$notificarFecha' OR fecha_vencimiento_licencia = '0000-00-00')";

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$lcVencidosId[] = $filas;
    	}
    	return $lcVencidosId;
    }
	
	public function listarDocsConductorLcVencidosConductores($conductores, $notificarFecha){
    	$lcVencidosId = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE id_conductor IN ($conductores) AND (fecha_vencimiento_licencia <= :notificarFecha OR fecha_vencimiento_licencia = '0000-00-00')");
    	$sql->bindParam(":notificarFecha", $notificarFecha);
    	$sql->execute();
    	
    	//echo "SELECT * FROM conductores WHERE id_conductor IN ($conductores) AND (fecha_vencimiento_licencia <= '$notificarFecha' OR fecha_vencimiento_licencia = '0000-00-00')";

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$lcVencidosId[] = $filas;
    	}
    	return $lcVencidosId;
    }
    
    public function listarDocsConductorLcVencidos($hoy){
    	$lcVencidos = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE fecha_vencimiento_licencia < '$hoy' AND fecha_vencimiento_licencia != '0000-00-00'");
    	$sql->execute();
    	
    	//echo "SELECT * FROM conductores WHERE fecha_vencimiento_licencia < '$hoy' AND fecha_vencimiento_licencia != '0000-00-00' AND estado = 1";

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$lcVencidos[] = $filas;
    	}
    	return $lcVencidos;
    }

    public function listarDocsConductorEMVencidos($hoy){
    	$emVencidos = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE fecha_expedicion_examen_medico != '000-00-00' AND (DATE_ADD(fecha_expedicion_examen_medico, INTERVAL 1 YEAR) < '$hoy') AND estado = 1 ORDER BY `conductores`.`fecha_expedicion_examen_medico` DESC  ");
    	$sql->execute();
    	
    	
    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$emVencidos[] = $filas;
    	}
    	return $emVencidos;
    }
    
    public function listarDocsConductorEMVencidosPorId($id_conductor, $notificarFecha){
    	$emVencidosId = array();
    	$con = Conexion::conectar();
    	$sql = $con->prepare("SELECT * FROM conductores WHERE id_conductor = :id_conductor AND (DATE_ADD(fecha_expedicion_examen_medico, INTERVAL 1 YEAR) <= :notificarFecha) or fecha_expedicion_examen_medico = '000-00-00' AND estado = 1 ");
    	$sql->bindParam(":notificarFecha", $notificarFecha);
    	$sql->bindParam(":id_conductor", $id_conductor);
    	$sql->execute();

    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
    		$emVencidosId[] = $filas;
    	}
    	return $emVencidosId;
    }

    public function listarDocsVencidosPorIdConductor($id_conductor, $fecha1){
        $docsVencidos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM  conductores WHERE id_conductor = :id_conductor AND (fotocopia_licencia = '' OR fecha_vencimiento_licencia  <= :fecha1 OR fecha_vencimiento_licencia = '0000-00-00')");
        $sql->bindParam(":id_conductor", $id_conductor);
        $sql->bindParam(":fecha1", $fecha1);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $docsVencidos[] = $filas;
        }

        return $docsVencidos;
    }
    
    
    /* ------------------------------------------- */
    /* ---------- FILTRO POR DOCUMENTO ----------- */
    /* ------------------------------------------- */
    
    
    public function listarDocVaciosfiltroPorDoc($nombre_documento, $nombre_fecha_documento){
        $filtroReporteCond = array();
        $con = Conexion::conectar();
        if(($nombre_documento == 'fotocopia_licencia' && $nombre_fecha_documento == 'fecha_vencimiento_licencia') || ($nombre_documento == 'examen_medico' && $nombre_fecha_documento == 'fecha_expedicion_examen_medico')){
            $sql = $con->prepare("SELECT * FROM  conductores WHERE ($nombre_documento = '' OR $nombre_fecha_documento = '0000-00-00') AND estado = 1 ");
        }else{
            $sql = $con->prepare("SELECT * FROM  conductores WHERE $nombre_documento = '' AND  estado = 1 ");
        }
        $sql->execute();
       
        /*if(($nombre_documento == 'fotocopia_licencia' && $nombre_fecha_documento == 'fecha_vencimiento_licencia') || ($nombre_documento == 'examen_medico' && $nombre_fecha_documento == 'fecha_expedicion_examen_medico')){
            echo "SELECT * FROM  conductores WHERE ($nombre_documento = '' OR $nombre_fecha_documento = '0000-00-00') AND estado = 1 ";
        }else{
            echo "SELECT * FROM  conductores WHERE $nombre_documento = '' AND  estado = 1 ";
        }*/
        
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $filtroReporteCond[] = $filas;
        }

        return $filtroReporteCond;
    }
    

    
    /* ------------------------------------------- */
    /* ---------- FILTRO POR CONTRATO ------------ */
    /* --------------- VACIOS ID ----------------- */
    
    
    public function listarFiltroReporteConductoresContratos($id_contrato){
        $filtroReporteCondContratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM  vehiculos_contratos  WHERE id_contrato = :id_contrato");
        $sql->bindParam(":id_contrato", $id_contrato);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $filtroReporteCondContratos[] = $filas;
        }

        return $filtroReporteCondContratos;
    }
    
    public function listarDocsFDVaciosId($id_conductor){
        $fdVaciosId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM conductores WHERE id_conductor = :id_conductor AND fotocopia_documento = '' ");
        $sql->bindParam(":id_conductor", $id_conductor);
        $sql->execute();


        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $fdVaciosId[] = $filas;
        }

        return $fdVaciosId;
    }

    public function listarDocsLCVaciosId($id_conductor){
        $lcVacios = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM conductores WHERE fotocopia_licencia = '' AND id_conductor = :id_conductor  ");
        $sql->bindParam(":id_conductor", $id_conductor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $lcVacios[] = $filas;
        }

        return $lcVacios;
    }
    
    public function listarDocsCLVaciosId($id_conductor){
        $clVaciosId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM conductores WHERE certificados_laborales = '' AND id_conductor = :id_conductor  ");
        $sql->bindParam(":id_conductor", $id_conductor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $clVaciosId[] = $filas;
        }

        return $clVaciosId;
    }
    
    public function listarDocsCEVaciosId($id_conductor){
        $ceVaciosId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM conductores WHERE certificados_estudios = '' AND id_conductor = :id_conductor ");
        $sql->bindParam(":id_conductor", $id_conductor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $ceVaciosId[] = $filas;
        }

        return $ceVaciosId;
    }
    
    public function listarDocsCCVaciosId($id_conductor){
        $ccVaciosId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM conductores WHERE certificados_cursos = '' AND id_conductor = :id_conductor ");
        $sql->bindParam(":id_conductor", $id_conductor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $ccVaciosId[] = $filas;
        }

        return $ccVaciosId;
    }
    
    public function listarDocsLMVaciosId($id_conductor){
        $lmVaciosId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM conductores WHERE libreta_militar = '' AND id_conductor = :id_conductor ");
        $sql->bindParam(":id_conductor", $id_conductor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $lmVaciosId[] = $filas;
        }

        return $lmVaciosId;
    }

    public function listarDocsEMVaciosId($id_conductor){
        $emVaciosId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM conductores WHERE examen_medico = ''AND id_conductor = :id_conductor ");
        $sql->bindParam(":id_conductor", $id_conductor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $emVaciosId[] = $filas;
        }

        return $emVaciosId;
    }

    public function listarDocsPSSVaciosId($id_conductor){
        $pssVaciosId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM conductores WHERE planilla_ss = '' AND id_conductor = :id_conductor  ");
        $sql->bindParam(":id_conductor", $id_conductor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $pssVaciosId[] = $filas;
        }

        return $pssVaciosId;
    }
    

}

 ?>