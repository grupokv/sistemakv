<?php 
require_once("Conexion/conexionBD.php");


class PreOperacionales{

	public function listarTodos($id_vehiculo, $fecha_inicial, $fecha_final){
		try {
			$preoperacionales = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM preoperacionales WHERE id_vehiculo LIKE :id_vehiculo AND (date(fecha_creacion) >= :fecha_inicial AND  date(fecha_creacion) <= :fecha_final) ORDER BY id_vehiculo ASC");

			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":fecha_inicial", $fecha_inicial);
			$sql->bindParam(":fecha_final", $fecha_final);

			$sql->execute();

			//echo "SELECT * FROM preoperacionales WHERE id_vehiculo LIKE '$id_vehiculo' AND (date(fecha_creacion) >= '$fecha_inicial' AND  date(fecha_creacion) <= '$fecha_final')";

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $preoperacionales[] = $filas;
          	}

          	return $preoperacionales;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarPorConductor($id_conductor){
		try {
			$preoperacionalesCond = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM preoperacionales WHERE id_conductor LIKE :id_conductor ORDER BY fecha_creacion ASC");
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->execute();

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $preoperacionalesCond[] = $filas;
          	}
          	return $preoperacionalesCond;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarTodosPreoperacionalContrato($id_vehiculo, $fecha_inicial, $fecha_final){
		try {
			$preoperacionales = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM preoperacionales WHERE id_vehiculo in ($id_vehiculo) AND (date(fecha_creacion) >= :fecha_inicial AND date(fecha_creacion) <= :fecha_final) ORDER BY fecha_creacion ASC");

			$sql->bindParam(":fecha_inicial", $fecha_inicial);
			$sql->bindParam(":fecha_final", $fecha_final);

			$sql->execute();

			//echo "SELECT * FROM preoperacionales WHERE id_vehiculo in ($id_vehiculo) AND (fecha_creacion >= '$fecha_inicial' AND  fecha_creacion <= '$fecha_final') ORDER BY fecha_creacion ASC";

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $preoperacionales[] = $filas;
          	}

          	return $preoperacionales;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarTodosDesinfecciones($id_vehiculo, $fecha_inicial, $fecha_final){
		try {
			$preoperacionales = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM desinfeccion WHERE id_vehiculo LIKE :id_vehiculo AND (date(fecha) >= :fecha_inicial AND date(fecha) <= :fecha_final) ORDER BY fecha ASC");

			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":fecha_inicial", $fecha_inicial);
			$sql->bindParam(":fecha_final", $fecha_final);

			$sql->execute();

			//echo "SELECT * FROM desinfeccion WHERE id_vehiculo LIKE '$id_vehiculo' AND (date(fecha) >= '$fecha_inicial' AND date(fecha) <= '$fecha_final') ORDER BY fecha ASC";

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $preoperacionales[] = $filas;
          	}

          	return $preoperacionales;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarTodosDesinfeccionesContrato($id_vehiculo, $fecha_inicial, $fecha_final){
		try {
			$preoperacionales = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM desinfeccion WHERE id_vehiculo in ($id_vehiculo) AND (date(fecha) >= :fecha_inicial AND date(fecha) <= :fecha_final) ORDER BY fecha ASC");

			$sql->bindParam(":fecha_inicial", $fecha_inicial);
			$sql->bindParam(":fecha_final", $fecha_final);

			$sql->execute();

			//echo "SELECT * FROM desinfeccion WHERE id_vehiculo in ($id_vehiculo) AND (date(fecha) >= '$fecha_inicial' AND date(fecha) <= '$fecha_final') ORDER BY fecha ASC";

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $preoperacionales[] = $filas;
          	}

          	return $preoperacionales;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarId($id){
		try {
			$preoperacionalesId = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM preoperacionales WHERE id = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

			//echo "SELECT * FROM preoperacionales WHERE id_vehiculo LIKE '$id_vehiculo' AND (fecha_creacion >= '$fecha_inicial' AND  fecha_creacion <= '$fecha_final')";

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $preoperacionalesId[] = $filas;
          	}

          	return $preoperacionalesId;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listarDesinfeccionId($id){
		try {
			$preoperacionalesId = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM desinfeccion WHERE id_desinfeccion = :id");

			$sql->bindParam(":id", $id);

			$sql->execute();

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $preoperacionalesId[] = $filas;
          	}
		
		return $preoperacionalesId;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function listarPorIdVehiculoConductorYDia($id_vehiculo, $id_conductor, $fecha_hoy){
		
			$listarIdDia = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM preoperacionales WHERE id_vehiculo = :id_vehiculo AND id_conductor = :id_conductor AND date(fecha_creacion) = :fecha_hoy");

			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":fecha_hoy", $fecha_hoy);

			$sql->execute();

			//echo "SELECT * FROM preoperacionales WHERE id_vehiculo = '$id_vehiculo' AND id_conductor = '$id_conductor' AND date(fecha_creacion) = '$fecha_hoy'";

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $listarIdDia[] = $filas;
          	}

          	return $listarIdDia;

	}

	
	public function registrar($id_vehiculo, $id_conductor, $id_usuario, $fecha_creacion){
		try {
			
			$con = Conexion::conectar();
			
			$sql = $con->prepare("INSERT INTO preoperacionales(id_vehiculo, id_conductor, id_usuario, fecha_creacion) VALUES(:id_vehiculo, :id_conductor, :id_usuario, :fecha_creacion)");
			
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":id_usuario", $id_usuario);
			$sql->bindParam(":fecha_creacion", $fecha_creacion);
			
			$sql->execute();
			//echo "INSERT INTO preoperacionales(id_vehiculo, id_conductor, id_usuario, fecha_creacion) VALUES('$id_vehiculo', '$id_conductor', '$id_usuario', '$fecha_creacion')";
			$id_vehiculo = $con->lastInsertId();
                	return $id_vehiculo;
			

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarDesinfeccion($id_vehiculo, $id_conductor, $id_usuario, $lavado_manos,$desinfectante,$tapabocas,$bayetillas,$escoba,$alisto_toalla,$balde,$bolsa,$productos,$tapetes,$volante,$zona_pasajeros, $zona_conductor,$piso_vehiculo,$aspersion,$disposicion,$bodega,$hidratacion,$fecha){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO desinfeccion (id_vehiculo, id_conductor, id_usuario, lavado_manos, desinfectante, elementos_proteccion, bayetillas, escoba, alisto_toalla, balde, bolsa, productos, tapetes, volante, zona_pasajeros, zona_conductor, piso_vehiculo, aspersion, disposicion, bodega, hidratacion, fecha) VALUES(:id_vehiculo, :id_conductor, :id_usuario, :lavado_manos, :desinfectante, :tapabocas, :bayetillas, :escoba, :alisto_toalla, :balde, :bolsa, :productos, :tapetes, :volante, :zona_pasajeros, :zona_conductor, :piso_vehiculo, :aspersion, :disposicion, :bodega, :hidratacion, :fecha)");

			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":id_usuario", $id_usuario);
			$sql->bindParam(":lavado_manos", $lavado_manos);
			$sql->bindParam(":desinfectante", $desinfectante);
			$sql->bindParam(":tapabocas", $tapabocas);
			$sql->bindParam(":bayetillas", $bayetillas);
			$sql->bindParam(":escoba", $escoba);
			$sql->bindParam(":alisto_toalla", $alisto_toalla);
			$sql->bindParam(":balde", $balde);
			$sql->bindParam(":bolsa", $bolsa);
			$sql->bindParam(":productos", $productos);
			$sql->bindParam(":tapetes", $tapetes);
			$sql->bindParam(":volante", $volante);
			$sql->bindParam(":zona_pasajeros", $zona_pasajeros);
			$sql->bindParam(":zona_conductor", $zona_conductor);
			$sql->bindParam(":piso_vehiculo", $piso_vehiculo);
			$sql->bindParam(":aspersion", $aspersion);
			$sql->bindParam(":disposicion", $disposicion);
			$sql->bindParam(":bodega", $bodega);
			$sql->bindParam(":hidratacion", $hidratacion);
			$sql->bindParam(":fecha", $fecha);

			$sql->execute();
			
			if ($sql) {
                $id_vehiculo = $con->lastInsertId();
                return $id_vehiculo;
            }

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function registrarDesinfeccionServicioConduyctor($id_vehiculo, $id_conductor, $id_usuario, $id_servicio, $lavado_manos, $desinfectante, $tapabocas, $bayetillas, $escoba, $alisto_toalla, $balde, $bolsa, $productos, $tapetes,$volante, $zona_pasajeros, $zona_conductor, $piso_vehiculo, $aspersion, $disposicion, $bodega, $hidratacion, $fecha){
		try {
			$con = Conexion::conectar();
			$sql = $con->prepare("INSERT INTO desinfeccion (id_vehiculo, id_conductor, id_usuario, id_servicio, lavado_manos, desinfectante, elementos_proteccion, bayetillas, escoba, alisto_toalla, balde, bolsa, productos, tapetes, volante, zona_pasajeros, zona_conductor, piso_vehiculo, aspersion, disposicion, bodega, hidratacion, fecha) VALUES(:id_vehiculo, :id_conductor, :id_usuario, :id_servicio, :lavado_manos, :desinfectante, :tapabocas, :bayetillas, :escoba, :alisto_toalla, :balde, :bolsa, :productos, :tapetes, :volante, :zona_pasajeros, :zona_conductor, :piso_vehiculo, :aspersion, :disposicion, :bodega, :hidratacion, :fecha)");

			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->bindParam(":id_conductor", $id_conductor);
			$sql->bindParam(":id_usuario", $id_usuario);
			$sql->bindParam(":id_servicio", $id_servicio);
			$sql->bindParam(":lavado_manos", $lavado_manos);
			$sql->bindParam(":desinfectante", $desinfectante);
			$sql->bindParam(":tapabocas", $tapabocas);
			$sql->bindParam(":bayetillas", $bayetillas);
			$sql->bindParam(":escoba", $escoba);
			$sql->bindParam(":alisto_toalla", $alisto_toalla);
			$sql->bindParam(":balde", $balde);
			$sql->bindParam(":bolsa", $bolsa);
			$sql->bindParam(":productos", $productos);
			$sql->bindParam(":tapetes", $tapetes);
			$sql->bindParam(":volante", $volante);
			$sql->bindParam(":zona_pasajeros", $zona_pasajeros);
			$sql->bindParam(":zona_conductor", $zona_conductor);
			$sql->bindParam(":piso_vehiculo", $piso_vehiculo);
			$sql->bindParam(":aspersion", $aspersion);
			$sql->bindParam(":disposicion", $disposicion);
			$sql->bindParam(":bodega", $bodega);
			$sql->bindParam(":hidratacion", $hidratacion);
			$sql->bindParam(":fecha", $fecha);

			$sql->execute();
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarExterior($id, $puertas, $espejos_retrovisores, $ventanas, $vidrio_frontal, $llantas_rines, $llanta_repuesto, $luces_delanteras, $luces_freno, $luces_reserva, $luces_parqueo_direccionales, $sistema_suspension, $sistema_frenos, $sistema_direccion){
		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE preoperacionales SET puertas = :puertas, espejos_retrovisores = :espejos_retrovisores, ventanas = :ventanas, vidrio_frontal = :vidrio_frontal, llantas_rines = :llantas_rines, llanta_repuesto = :llanta_repuesto, luces_delanteras = :luces_delanteras, luces_freno = :luces_freno, luces_reserva = :luces_reserva, luces_parqueo_direccionales = :luces_parqueo_direccionales, sistema_suspension = :sistema_suspension, sistema_frenos = :sistema_frenos, sistema_direccion = :sistema_direccion WHERE id = :id");

			$sql->bindParam(":id", $id);
			$sql->bindParam(":puertas", $puertas);
			$sql->bindParam(":espejos_retrovisores", $espejos_retrovisores);
			$sql->bindParam(":ventanas", $ventanas);
			$sql->bindParam(":vidrio_frontal", $vidrio_frontal);
			$sql->bindParam(":llantas_rines", $llantas_rines);
			$sql->bindParam(":llanta_repuesto", $llanta_repuesto);
			$sql->bindParam(":luces_delanteras", $luces_delanteras);
			$sql->bindParam(":luces_freno", $luces_freno);
			$sql->bindParam(":luces_reserva", $luces_reserva);
			$sql->bindParam(":luces_parqueo_direccionales", $luces_parqueo_direccionales);
			$sql->bindParam(":sistema_suspension", $sistema_suspension);
			$sql->bindParam(":sistema_frenos", $sistema_frenos);
			$sql->bindParam(":sistema_direccion", $sistema_direccion);

			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarCompartimientoMotor($id, $tapas, $niveles_aceite_motor, $radiador_ventilador_correas, $mangueras, $transmision, $filtro_aire, $fugas_motor, $bomba_freno_clutch, $bateria_bornes_soporte, $direccion_nivel_aceite_hidraulico, $depositivo_lavabrisas, $conexiones_electricas){
		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE preoperacionales SET tapas = :tapas, niveles_aceite_motor = :niveles_aceite_motor, radiador_ventilador_correas = :radiador_ventilador_correas, mangueras = :mangueras, transmision = :transmision, filtro_aire = :filtro_aire, fugas_motor = :fugas_motor, bomba_freno_clutch = :bomba_freno_clutch, bateria_bornes_soporte = :bateria_bornes_soporte, direccion_nivel_aceite_hidraulico = :direccion_nivel_aceite_hidraulico, depositivo_lavabrisas = :depositivo_lavabrisas, conexiones_electricas = :conexiones_electricas WHERE id = :id");

			$sql->bindParam(":id", $id);
			$sql->bindParam(":tapas", $tapas);
			$sql->bindParam(":niveles_aceite_motor", $niveles_aceite_motor);
			$sql->bindParam(":radiador_ventilador_correas", $radiador_ventilador_correas);
			$sql->bindParam(":mangueras", $mangueras);
			$sql->bindParam(":transmision", $transmision);
			$sql->bindParam(":filtro_aire", $filtro_aire);
			$sql->bindParam(":fugas_motor", $fugas_motor);
			$sql->bindParam(":bomba_freno_clutch", $bomba_freno_clutch);
			$sql->bindParam(":bateria_bornes_soporte", $bateria_bornes_soporte);
			$sql->bindParam(":direccion_nivel_aceite_hidraulico", $direccion_nivel_aceite_hidraulico);
			$sql->bindParam(":depositivo_lavabrisas", $depositivo_lavabrisas);
			$sql->bindParam(":conexiones_electricas", $conexiones_electricas);

			$sql->execute();

			//echo "UPDATE preoperacionales SET tapas = '$tapas', niveles_aceite_motor = '$niveles_aceite_motor', radiador_ventilador_correas = '$radiador_ventilador_correas', mangueras = '$mangueras', transmision = '$transmision', filtro_aire = '$filtro_aire', fugas_motor = '$fugas_motor', bomba_freno_clutch = '$bomba_freno_clutch', bateria_bornes_soporte = '$bateria_bornes_soporte', direccion_nivel_aceite_hidraulico = '$direccion_nivel_aceite_hidraulico', depositivo_lavabrisas = '$depositivo_lavabrisas', conexiones_electricas = '$conexiones_electricas' WHERE id = '$id' ";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarDatosDesinfeccion($lavado_manos,$desinfectante,$tapabocas,$bayetillas,$escoba,$alisto_toalla,$balde,$bolsa,$productos,$tapetes,$volante,$zona_pasajeros,$zona_conductor,$piso_vehiculo,$aspersion,$disposicion,$bodega,$hidratacion,$id){
		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE desinfeccion SET lavado_manos = :lavado_manos, desinfectante = :desinfectante, elementos_proteccion = :tapabocas, bayetillas = :bayetillas, escoba = :escoba, alisto_toalla = :alisto_toalla, balde = :balde, bolsa = :bolsa, productos = :productos, tapetes = :tapetes, volante = :volante, zona_pasajeros = :zona_pasajeros, zona_conductor = :zona_conductor, piso_vehiculo = :piso_vehiculo, aspersion = :aspersion, disposicion = :disposicion, bodega = :bodega, hidratacion = :hidratacion WHERE id_desinfeccion = :id");

			
			$sql->bindParam(":lavado_manos", $lavado_manos);
 			$sql->bindParam(":desinfectante", $desinfectante);
			$sql->bindParam(":tapabocas", $tapabocas);
			$sql->bindParam(":bayetillas", $bayetillas);
			$sql->bindParam(":escoba", $escoba);
			$sql->bindParam(":alisto_toalla", $alisto_toalla);
			$sql->bindParam(":balde", $balde);
			$sql->bindParam(":bolsa", $bolsa);
			$sql->bindParam(":productos", $productos);
			$sql->bindParam(":tapetes", $tapetes);
			$sql->bindParam(":volante", $volante);
			$sql->bindParam(":zona_pasajeros", $zona_pasajeros);
			$sql->bindParam(":zona_conductor", $zona_conductor);
			$sql->bindParam(":piso_vehiculo", $piso_vehiculo);
			$sql->bindParam(":aspersion", $aspersion);
			$sql->bindParam(":disposicion", $disposicion);
			$sql->bindParam(":bodega", $bodega);
			$sql->bindParam(":hidratacion", $hidratacion);
			$sql->bindParam(":id", $id);

			$sql->execute();
	
			//echo "UPDATE desinfeccion SET lavado_manos = '$lavado_manos', elementos_proteccion = '$tapabocas', bayetillas = '$bayetillas', escoba = '$escoba', alisto_toalla = '$alisto_toalla', balde = '$balde', bolsa = '$bolsa', productos = '$productos', tapetes = '$tapetes', volante = '$volante', zona_pasajeros = '$zona_pasajeros', zona_conductor = '$zona_conductor', piso_vehiculo = '$piso_vehiculo', aspersion = :aspersion, disposicion = :disposicion, bodega = :bodega, hidratacion = :hidratacion WHERE id_desinfeccion = '$id'";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarDesinfeccion($lavado_manos,$desinfectante,$tapabocas,$bayetillas,$escoba,$alisto_toalla,$balde,$bolsa,$productos,$tapetes,$volante,$zona_pasajeros,$zona_conductor,$piso_vehiculo,$aspersion,$disposicion,$bodega,$hidratacion,$id){
		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE preoperacionales SET lavado_manos = :lavado_manos, desinfectante = :desinfectante, elementos_proteccion = :tapabocas, bayetillas = :bayetillas, escoba = :escoba, alisto_toalla = :alisto_toalla, balde = :balde, bolsa = :bolsa, productos = :productos, tapetes = :tapetes, volante = :volante, zona_pasajeros = :zona_pasajeros, zona_conductor = :zona_conductor, piso_vehiculo = :piso_vehiculo, aspersion = :aspersion, disposicion = :disposicion, bodega = :bodega, hidratacion = :hidratacion WHERE id = :id");

			
			$sql->bindParam(":lavado_manos", $lavado_manos);
 			$sql->bindParam(":desinfectante", $desinfectante);
			$sql->bindParam(":tapabocas", $tapabocas);
			$sql->bindParam(":bayetillas", $bayetillas);
			$sql->bindParam(":escoba", $escoba);
			$sql->bindParam(":alisto_toalla", $alisto_toalla);
			$sql->bindParam(":balde", $balde);
			$sql->bindParam(":bolsa", $bolsa);
			$sql->bindParam(":productos", $productos);
			$sql->bindParam(":tapetes", $tapetes);
			$sql->bindParam(":volante", $volante);
			$sql->bindParam(":zona_pasajeros", $zona_pasajeros);
			$sql->bindParam(":zona_conductor", $zona_conductor);
			$sql->bindParam(":piso_vehiculo", $piso_vehiculo);
			$sql->bindParam(":aspersion", $aspersion);
			$sql->bindParam(":disposicion", $disposicion);
			$sql->bindParam(":bodega", $bodega);
			$sql->bindParam(":hidratacion", $hidratacion);
			$sql->bindParam(":id", $id);

			$sql->execute();
	
			//echo "UPDATE preoperacionales SET lavado_manos = '$lavado_manos', elementos_proteccion = '$tapabocas', bayetillas = '$bayetillas', escoba = '$escoba', alisto_toalla = '$alisto_toalla', balde = '$balde', bolsa = '$bolsa', productos = '$productos', tapetes = '$tapetes', volante = '$volante', zona_pasajeros = '$zona_pasajeros', zona_conductor = '$zona_conductor', piso_vehiculo = '$piso_vehiculo' WHERE id = '$id'";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarInteriorCabina($id, $plumillas_limpiavidrios, $indicadores_luces_tablero, $indicador_velocidad, $indicador_combustible, $indicador_aceite_motor, $pito, $freno_emergencia, $pito_reserva, $botiquin, $equipo_carretera, $kilometraje){
		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE preoperacionales SET plumillas_limpiavidrios = :plumillas_limpiavidrios, indicadores_luces_tablero = :indicadores_luces_tablero, indicador_velocidad = :indicador_velocidad, indicador_combustible = :indicador_combustible, indicador_aceite_motor = :indicador_aceite_motor, pito = :pito, freno_emergencia = :freno_emergencia, pito_reserva = :pito_reserva, botiquin = :botiquin, equipo_carretera = :equipo_carretera, kilometraje = :kilometraje WHERE id = :id");

			$sql->bindParam(":id", $id);
			$sql->bindParam(":plumillas_limpiavidrios", $plumillas_limpiavidrios);
			$sql->bindParam(":indicadores_luces_tablero", $indicadores_luces_tablero);
			$sql->bindParam(":indicador_velocidad", $indicador_velocidad);
			$sql->bindParam(":indicador_combustible", $indicador_combustible);
			$sql->bindParam(":indicador_aceite_motor", $indicador_aceite_motor);
			$sql->bindParam(":pito", $pito);
			$sql->bindParam(":freno_emergencia", $freno_emergencia);
			$sql->bindParam(":pito_reserva", $pito_reserva);
			$sql->bindParam(":botiquin", $botiquin);
			$sql->bindParam(":equipo_carretera", $equipo_carretera);
			$sql->bindParam(":kilometraje", $kilometraje);

			$sql->execute();

			//echo "UPDATE preoperacionales SET tapas = '$tapas', niveles_aceite_motor = '$niveles_aceite_motor', radiador_ventilador_correas = '$radiador_ventilador_correas', mangueras = '$mangueras', transmision = '$transmision', filtro_aire = '$filtro_aire', fugas_motor = '$fugas_motor', bomba_freno_clutch = '$bomba_freno_clutch', bateria_bornes_soporte = '$bateria_bornes_soporte', direccion_nivel_aceite_hidraulico = '$direccion_nivel_aceite_hidraulico', depositivo_lavabrisas = '$depositivo_lavabrisas', conexiones_electricas = '$conexiones_electricas' WHERE id = '$id' ";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actualizarProperacionalContratoGEB($id_preoperacional, $botiquin, $extintor_cargado, $gato, $cruceta_copa, $triangulos, $tacos_cunias, $llanta_repuesto, $herramientas, $chaleco_refractivo, $aviso_conduzco, $nivel_liquido, $nivel_aceite, $fuga_aceite, $estado_filtro_combustible, $sistema_embrague, $cierre_puertas_ventanas, $seguro_puertas, $cinturones_seguridad, $control_fugas, $estado_cojineria, $fijacion_asientos, $ajuste_silla_conductor, $estado_retrovisores, $pisos_cabina, $llanta_trasera_izq, $llanta_trasera_der, $llanta_delantera_izq, $llanta_delantera_der, $estado_latoneria, $pito, $aire_acondicionado, $apoya_cabezas, $alarma_retroceso, $freno_parqueo, $lvl_liquido_freno, $limpia_brisas, $parabrisas, $sistema_parabrisas, $estado_vidrio_trasero, $indicadores, $indicadores_luces_altas, $indicador_luces_parqueo, $indicador_lvl_gasolina, $sistema_escape, $emanacion_gases, $luces_posicion_delantera, $luces_posicion_trasera, $luces_freno, $direccionales, $luces_emergencia, $luces_retroceso, $luz_placa, $luces_bajas, $luces_altas, $luces_interiores, $luces_tablero, $sistema_electrico_aislado){
		try {

			$con = Conexion::conectar();
			$sql = $con->prepare("UPDATE preoperacionalGEB SET botiquin = :botiquin, extintor_cargado = :extintor_cargado, gato = :gato, cruceta_copa = :cruceta_copa, triangulos = :triangulos, tacos_cunias = :tacos_cunias, llanta_repuesto = :llanta_repuesto, herramientas = :herramientas, chaleco_refractivo = :chaleco_refractivo, aviso_conduzco = :aviso_conduzco, nivel_liquido = :nivel_liquido, nivel_aceite = :nivel_aceite, fuga_aceite = :fuga_aceite, estado_filtro_combustible = :estado_filtro_combustible, sistema_embrague = :sistema_embrague, cierre_puertas_ventanas = :cierre_puertas_ventanas, seguro_puertas = :seguro_puertas, cinturones_seguridad = :cinturones_seguridad, control_fugas = :control_fugas, estado_cojineria = :estado_cojineria, fijacion_asientos = :fijacion_asientos, ajuste_silla_conductor = :ajuste_silla_conductor, estado_retrovisores = :estado_retrovisores, pisos_cabina = :pisos_cabina, llanta_trasera_izq = :llanta_trasera_izq, llanta_trasera_der = :llanta_trasera_der, llanta_delantera_izq = :llanta_delantera_izq, llanta_delantera_der = :llanta_delantera_der, estado_latoneria = :estado_latoneria, pito = :pito, aire_acondicionado = :aire_acondicionado, apoya_cabezas = :apoya_cabezas, alarma_retroceso = :alarma_retroceso, freno_parqueo = :freno_parqueo, lvl_liquido_freno = :lvl_liquido_freno, limpia_brisas = :limpia_brisas, parabrisas = :parabrisas, sistema_parabrisas = :sistema_parabrisas, estado_vidrio_trasero = :estado_vidrio_trasero, indicadores = :indicadores, indicadores_luces_altas = :indicadores_luces_altas, indicador_luces_parqueo = :indicador_luces_parqueo, indicador_lvl_gasolina = :indicador_lvl_gasolina, sistema_escape = :sistema_escape, emanacion_gases = :emanacion_gases, luces_posicion_delantera = :luces_posicion_delantera, luces_posicion_trasera = :luces_posicion_trasera, luces_freno = :luces_freno, direccionales = :direccionales, luces_emergencia = :luces_emergencia, luces_retroceso = :luces_retroceso, luz_placa = :luz_placa, luces_bajas = :luces_bajas, luces_altas = :luces_altas, luces_interiores = :luces_interiores, luces_tablero = :luces_tablero, sistema_electrico_aislado = :sistema_electrico_aislado WHERE id_preoperacional = :id_preoperacional");

			$sql->bindParam(":id_preoperacional", $id_preoperacional);
			$sql->bindParam(":botiquin", $botiquin);
			$sql->bindParam(":extintor_cargado", $extintor_cargado);
			$sql->bindParam(":gato", $gato);
			$sql->bindParam(":cruceta_copa", $cruceta_copa);
			$sql->bindParam(":triangulos", $triangulos);
			$sql->bindParam(":tacos_cunias", $tacos_cunias);
			$sql->bindParam(":llanta_repuesto", $llanta_repuesto);
			$sql->bindParam(":herramientas", $herramientas);
			$sql->bindParam(":chaleco_refractivo", $chaleco_refractivo);
			$sql->bindParam(":aviso_conduzco", $aviso_conduzco);
			$sql->bindParam(":nivel_liquido", $nivel_liquido);
			$sql->bindParam(":nivel_aceite", $nivel_aceite);
			$sql->bindParam(":fuga_aceite", $fuga_aceite);
			$sql->bindParam(":estado_filtro_combustible", $estado_filtro_combustible);
			$sql->bindParam(":sistema_embrague", $sistema_embrague);
			$sql->bindParam(":cierre_puertas_ventanas", $cierre_puertas_ventanas);
			$sql->bindParam(":seguro_puertas", $seguro_puertas);
			$sql->bindParam(":cinturones_seguridad", $cinturones_seguridad);
			$sql->bindParam(":control_fugas", $control_fugas);
			$sql->bindParam(":estado_cojineria", $estado_cojineria);
			$sql->bindParam(":fijacion_asientos", $fijacion_asientos);
			$sql->bindParam(":ajuste_silla_conductor", $ajuste_silla_conductor);
			$sql->bindParam(":estado_retrovisores", $estado_retrovisores);
			$sql->bindParam(":pisos_cabina", $pisos_cabina);
			$sql->bindParam(":llanta_trasera_izq", $llanta_trasera_izq);
			$sql->bindParam(":llanta_trasera_der", $llanta_trasera_der);
			$sql->bindParam(":llanta_delantera_izq", $llanta_delantera_izq);
			$sql->bindParam(":llanta_delantera_der", $llanta_delantera_der);
			$sql->bindParam(":estado_latoneria", $estado_latoneria);
			$sql->bindParam(":pito", $pito);
			$sql->bindParam(":aire_acondicionado", $aire_acondicionado);
			$sql->bindParam(":apoya_cabezas", $apoya_cabezas);
			$sql->bindParam(":alarma_retroceso", $alarma_retroceso);
			$sql->bindParam(":freno_parqueo", $freno_parqueo);
			$sql->bindParam(":lvl_liquido_freno", $lvl_liquido_freno);
			$sql->bindParam(":limpia_brisas", $limpia_brisas);
			$sql->bindParam(":parabrisas", $parabrisas);
			$sql->bindParam(":sistema_parabrisas", $sistema_parabrisas);
			$sql->bindParam(":estado_vidrio_trasero", $estado_vidrio_trasero);
			$sql->bindParam(":indicadores", $indicadores);
			$sql->bindParam(":indicadores_luces_altas", $indicadores_luces_altas);
			$sql->bindParam(":indicador_luces_parqueo", $indicador_luces_parqueo);
			$sql->bindParam(":indicador_lvl_gasolina", $indicador_lvl_gasolina);
			$sql->bindParam(":sistema_escape", $sistema_escape);
			$sql->bindParam(":emanacion_gases", $emanacion_gases);
			$sql->bindParam(":luces_posicion_delantera", $luces_posicion_delantera);
			$sql->bindParam(":luces_posicion_trasera", $luces_posicion_trasera);
			$sql->bindParam(":luces_freno", $luces_freno);
			$sql->bindParam(":direccionales", $direccionales);
			$sql->bindParam(":luces_emergencia", $luces_emergencia);
			$sql->bindParam(":luces_retroceso", $luces_retroceso);
			$sql->bindParam(":luz_placa", $luz_placa);
			$sql->bindParam(":luces_bajas", $luces_bajas);
			$sql->bindParam(":luces_altas", $luces_altas);
			$sql->bindParam(":luces_interiores", $luces_interiores);
			$sql->bindParam(":luces_tablero", $luces_tablero);
			$sql->bindParam(":sistema_electrico_aislado", $sistema_electrico_aislado);

			//$sql->execute();

			echo "UPDATE preoperacionalGEB SET botiquin = '$botiquin', extintor_cargado = '$extintor_cargado', gato = '$gato', cruceta_copa = '$cruceta_copa', triangulos = '$triangulos', tacos_cunias = '$tacos_cunias', llanta_repuesto = '$llanta_repuesto', herramientas = '$herramientas', chaleco_refractivo = '$chaleco_refractivo', aviso_conduzco = '$aviso_conduzco', nivel_liquido = '$nivel_liquido', nivel_aceite = '$nivel_aceite', fuga_aceite = '$fuga_aceite', estado_filtro_combustible = '$estado_filtro_combustible', sistema_embrague = '$sistema_embrague', cierre_puertas_ventanas = '$cierre_puertas_ventanas', seguro_puertas = '$seguro_puertas', cinturones_seguridad = '$cinturones_seguridad', control_fugas = '$control_fugas', estado_cojineria = '$estado_cojineria', fijacion_asientos = '$fijacion_asientos', ajuste_silla_conductor = '$ajuste_silla_conductor', estado_retrovisores = '$estado_retrovisores', pisos_cabina = '$pisos_cabina', llanta_trasera_izq = '$llanta_trasera_izq', llanta_trasera_der = '$llanta_trasera_der', llanta_delantera_izq = '$llanta_delantera_izq', llanta_delantera_der = '$llanta_delantera_der', estado_latoneria = '$estado_latoneria', pito = '$pito', aire_acondicionado = '$aire_acondicionado', apoya_cabezas = '$apoya_cabezas', alarma_retroceso = '$alarma_retroceso', freno_parqueo = '$freno_parqueo', lvl_liquido_freno = '$lvl_liquido_freno', limpia_brisas = '$limpia_brisas', parabrisas = '$parabrisas', sistema_parabrisas = '$sistema_parabrisas', estado_vidrio_trasero = '$estado_vidrio_trasero', indicadores = '$indicadores', indicadores_luces_altas = '$indicadores_luces_altas', indicador_luces_parqueo = '$indicador_luces_parqueo', indicador_lvl_gasolina = '$indicador_lvl_gasolina', sistema_escape = '$sistema_escape', emanacion_gases = '$emanacion_gases', luces_posicion_delantera = '$luces_posicion_delantera', luces_posicion_trasera = '$luces_posicion_trasera', luces_freno = '$luces_freno', direccionales = '$direccionales', luces_emergencia = '$luces_emergencia', luces_retroceso = '$luces_retroceso', luz_placa = '$luz_placa', luces_bajas = '$luces_bajas', luces_altas = '$luces_altas', luces_interiores = '$luces_interiores', luces_tablero = '$luces_tablero', sistema_electrico_aislado = '$sistema_electrico_aislado' WHERE id_preoperacional = '$id_preoperacional' ";

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function listar($fecha){
		
			$allPreoperacionales = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM preoperacionales WHERE DATE(fecha_creacion) = :fecha ORDER BY fecha_creacion ASC");
			$sql->bindParam(":fecha", $fecha);
			$sql->execute();

			//echo "SELECT * FROM preoperacionales WHERE DATE(fecha_creacion) = '$fecha' ORDER BY fecha_creacion ASC";

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $allPreoperacionales[] = $filas;
          	}

          	return $allPreoperacionales;

	}
	
	

	public function listarMesContrato($mes, $anio, $id_vehiculo){
		
			$allMesContratoPreoperacionales = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM preoperacionales WHERE MONTH(fecha_creacion) = :mes AND YEAR(fecha_creacion) = :anio AND id_vehiculo = :id_vehiculo ORDER BY fecha_creacion ASC ");
			$sql->bindParam(":mes", $mes);
			$sql->bindParam(":anio", $anio);
			$sql->bindParam(":id_vehiculo", $id_vehiculo);
			$sql->execute();
			
			//echo "SELECT * FROM preoperacionales WHERE id_vehiculo IN ($id_vehiculo) AND MONTH(fecha_creacion) = '$mes' AND YEAR(fecha_creacion) = '$anio' ORDER BY fecha_creacion ASC ";

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $allMesContratoPreoperacionales[] = $filas;
          	}

          	return $allMesContratoPreoperacionales;

	}
	

	public function listarMes($mes, $anio){
		
			$allMesPreoperacionales = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM preoperacionales WHERE MONTH(fecha_creacion) = :mes AND YEAR(fecha_creacion) = :anio ORDER BY fecha_creacion ASC ");
			$sql->bindParam(":mes", $mes);
			$sql->bindParam(":anio", $anio);
			$sql->execute();
			
			//echo "SELECT * FROM preoperacionales WHERE id_vehiculo IN ($id_vehiculo) AND MONTH(fecha_creacion) = '$mes' AND YEAR(fecha_creacion) = '$anio' ORDER BY fecha_creacion ASC ";

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				 $allMesPreoperacionales[] = $filas;
          	}

          	return $allMesPreoperacionales;

	}

}

?>