<?php 
require_once("Conexion/conexionBD.php");

class InspeccionVehicular 
{

    public function listar(){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT id_inspeccion, empresa, placa, nombre, fecha_registro, id_usuario_registro FROM inspeccion_vehicular ORDER BY id_inspeccion DESC");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }

        return $listar;
    }

    public function listarID($id_inspeccion){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM inspeccion_vehicular WHERE id_inspeccion = :id_inspeccion ");
        $sql->bindParam(":id_inspeccion", $id_inspeccion);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }

        return $listar;
    }
    
    public function listarPorRangoFechas($inicio,$fin){
        
        $inicio = $inicio.' 00:00:00';
        $fin = $fin.' 23:59:59';
        
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM inspeccion_vehicular WHERE fecha_registro >= :inicio and fecha_registro <= :fin");
        $sql->bindParam(":inicio", $inicio);
        $sql->bindParam(":fin", $fin);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }

        return $listar;
    }
    
    public function listarEvidenciaID($id_inspeccion){
        $listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM inspeccion_evidencias WHERE id_inspeccion = :id_inspeccion order by id_evidencia Asc");
        $sql->bindParam(":id_inspeccion", $id_inspeccion);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listar[] = $filas;
        }

        return $listar;
    }

          public function registrar($entrega_vehiculo,$id_empresa,$contrato,$existe_vehiculo,$id_vehiculo,$movil,$placa,$cantidad,$modelo,$tipo_vehiculo,
    $tipo_combustible,$existe_conductor,$id_conductor,$nombre_conductor,$num_doc_conductor,$num_lic_conductor,$tel_conductor,$fecha_lic_conductor,$kilometraje,$nivel_gasolina,
    $fecha_proximo_mtto,$rev_tecnomecanica,$polizas_extra_contra,$preventiva,$tarjeta_operacion,$soat,$fuec,$dispositivo_velocidad,
    $tarjeta_operacion_fv,$soat_fv,$poliza_extra_fv,$tecnomecanica_fv,$preventiva_fv,$fuec_fv,$disp_velocidad_fv,$licencia_transito,$licencia_transito_fv,$licencia_conduccion,
    $licencia_conduccion_fv,$seguridad_social,$seguridad_social_fv,$gato,$cruceta,$seniales_carretera,$tacos,$linterna,$llaves_fijas,$alicates,$llave_expansiva,$destornillador,$chaleco_reflectivo,
    $martillo_frag,$extintor,$extintor_cap,$extintor_fv,$gasas_esteriles,$gasas_esteriles_fv,$algodon,$algodon_fv,$venda_elastica,$venda_elastica_fv,$micropore,$micropore_fv,
    $curas,$curas_fv,$bajalenguas,$bajalenguas_fv,$guantes_latex,$guantes_fv,$copitos,$copitos_fv,$pito_botiquin,$bolsas_rojas,$suero,$suero_fv,$antiseptico,$antiseptico_fv,$tijeras,$tijeras_fv,$aseo_personal,
    $sistema_comunicacion,$gps,$rutero,$aseo_interno,$aseo_externo,$luces,$luces_obs,$direccionales,$direccionales_obs,$panoramico,$panoramico_obs,$limpiabrisas,$limpiabrisas_obs,
    $stops,$stops_obs,$luces_internas,$luces_internas_obs,$luces_tablero,$luces_tablero_obs,$aire_acondicionado,$aire_acondicionado_obs,$radio,$radio_obs,$televisor,$televisor_obs,$boceles,$boceles_obs,
    $antenas,$antenas_obs,$rines,$rines_obs,$airbag,$airbag_obs,$tapiceria,$tapiceria_obs,$silleteria,$silleteria_obs,$disp_velocidad,$disp_velocidad_obs,$cinturon_seguridad,$cinturon_seguridad_obs,
    $cortinas,$cortinas_obs,$salida_emergencia,$salida_emergencia_obs,$martillos,$martillos_obs,$estado_bano,$estado_bano_obs,$vidrios,$vidrios_obs,$llantas,$llantas_obs,$repuesto,$repuesto_obs,
    $tapetes,$tapetes_obs,$encendedor,$encendedor_obs,$latoneria,$latoneria_obs,$distintivos,$distintivos_obs,$bodegas,$bodegas_obs,$fluidos,$fluidos_obs,$palomeras,$palomeras_obs,$calcomania,$calcomania_obs,
    $como_conduzco,$como_conduzco_obs,$cierre_puertas,$cierre_puertas_obs,$frenos,$frenos_obs,$embrague,$embrague_obs,$suspension,$suspension_obs,$cambios,$cambios_obs,
    $pito,$pito_obs,$bateria,$bateria_obs,$freno_mano,$freno_mano_obs,$direccion,$direccion_obs,$novedades_danios,$observaciones,$observaciones_entrega,$id_usuario_registro,$fecha_registro){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("INSERT INTO inspeccion_vehicular 
            (entrega_vehiculo, empresa, contrato, vehiculo_nuevo, id_vehiculo, movil, placa, capacidad, modelo, tipo_vehiculo, tipo_combustible, conductor_nuevo, id_conductor, nombre, 
            num_cedula, celular, num_licencia, fecha_venc_licencia, kilometraje, nivel_gasolina, fecha_proximo_mtto, rev_tecnomecanica, polizas_extra_contra, preventiva, 
            tarjeta_operacion, soat, fuec, dispositivo_velocidad, tarjeta_operacion_fecha, soat_fecha, poliza_extra_fecha, tecnomecanica_fecha, preventiva_fecha, fuec_fecha, 
            disp_velocidad_fecha, licencia_transito, licencia_transito_fv, licencia_conduccion, licencia_conduccion_fv, seguridad_social, seguridad_social_fv, gato, cruceta, seniales_carretera, 
            tacos, linterna, llaves_fijas, alicates, llave_expansiva, destornillador, chaleco_reflectivo, martillo_frag, extintor, extintor_cap, extintor_fv, gasas_esteriles, 
            gasas_esteriles_fv, algodon, algodon_fv, venda_elastica, venda_elastica_fv, micropore, micropore_fv, curas, curas_fv, bajalenguas, bajalenguas_fv, guantes_latex, guantes_fv, copitos, 
            copitos_fv, pito_botiquin, bolsas_rojas, suero, suero_fv, antiseptico, antiseptico_fv, tijeras, tijeras_fv, aseo_personal, sistema_comunicacion, gps, rutero, aseo_interno, aseo_externo, 
            luces, luces_obs, direccionales, direccionales_obs, panoramico, panoramico_obs, limpiabrisas, limpiabrisas_obs, stops, stops_obs, luces_internas, luces_internas_obs, luces_tablero, 
            luces_tablero_obs, aire_acondicionado, aire_acondicionado_obs, radio, radio_obs, televisor, televisor_obs, boceles, boceles_obs, antenas, antenas_obs, rines, rines_obs, airbag, airbag_obs, 
            tapiceria, tapiceria_obs, silleteria, silleteria_obs, disp_velocidad, disp_velocidad_obs, cinturon_seguridad, cinturon_seguridad_obs, cortinas, cortinas_obs, salida_emergencia, 
            salida_emergencia_obs, martillos, martillos_obs, estado_bano, estado_bano_obs, vidrios, vidrios_obs, llantas, llantas_obs, repuesto, repuesto_obs, tapetes, tapetes_obs, encendedor, 
            encendedor_obs, latoneria, latoneria_obs, distintivos, distintivos_obs, bodegas, bodegas_obs, fluidos, fluidos_obs, palomeras, palomeras_obs, calcomania, calcomania_obs, como_conduzco, 
            como_conduzco_obs, cierre_puertas, cierre_puertas_obs, frenos, frenos_obs, embrague, embrague_obs, suspension, suspension_obs, cambios, cambios_obs, pito, 
            pito_obs, bateria, bateria_obs, freno_mano, freno_mano_obs, direccion, direccion_obs, descripcion_danos_observados, observaciones, observaciones_entrega, id_usuario_registro, fecha_registro) 
            VALUES 
            ('$entrega_vehiculo','$id_empresa','$contrato','$existe_vehiculo','$id_vehiculo','$movil','$placa','$cantidad','$modelo','$tipo_vehiculo','$tipo_combustible','$existe_conductor','$id_conductor','$nombre_conductor', '$num_doc_conductor','$num_lic_conductor','$tel_conductor','$fecha_lic_conductor','$kilometraje','$nivel_gasolina','$fecha_proximo_mtto','$rev_tecnomecanica','$polizas_extra_contra','$preventiva','$tarjeta_operacion','$soat','$fuec','$dispositivo_velocidad','$tarjeta_operacion_fv','$soat_fv','$poliza_extra_fv','$tecnomecanica_fv','$preventiva_fv','$fuec_fv','$disp_velocidad_fv','$licencia_transito','$licencia_transito_fv','$licencia_conduccion','$licencia_conduccion_fv','$seguridad_social','$seguridad_social_fv','$gato','$cruceta','$seniales_carretera','$tacos','$linterna','$llaves_fijas','$alicates','$llave_expansiva','$destornillador','$chaleco_reflectivo','$martillo_frag','$extintor','$extintor_cap','$extintor_fv','$gasas_esteriles','$gasas_esteriles_fv','$algodon','$algodon_fv','$venda_elastica','$venda_elastica_fv','$micropore','$micropore_fv','$curas','$curas_fv','$bajalenguas','$bajalenguas_fv','$guantes_latex','$guantes_fv','$copitos','$copitos_fv','$pito_botiquin','$bolsas_rojas','$suero','$suero_fv','$antiseptico','$antiseptico_fv','$tijeras','$tijeras_fv','$aseo_personal','$sistema_comunicacion','$gps','$rutero','$aseo_interno','$aseo_externo','$luces','$luces_obs','$direccionales','$direccionales_obs','$panoramico','$panoramico_obs','$limpiabrisas','$limpiabrisas_obs','$stops','$stops_obs','$luces_internas','$luces_internas_obs','$luces_tablero','$luces_tablero_obs','$aire_acondicionado','$aire_acondicionado_obs','$radio','$radio_obs','$televisor','$televisor_obs','$boceles','$boceles_obs','$antenas','$antenas_obs','$rines','$rines_obs','$airbag','$airbag_obs','$tapiceria','$tapiceria_obs','$silleteria','$silleteria_obs','$disp_velocidad','$disp_velocidad_obs','$cinturon_seguridad','$cinturon_seguridad_obs','$cortinas','$cortinas_obs','$salida_emergencia','$salida_emergencia_obs','$martillos','$martillos_obs','$estado_bano','$estado_bano_obs','$vidrios','$vidrios_obs','$llantas','$llantas_obs','$repuesto','$repuesto_obs','$tapetes','$tapetes_obs','$encendedor','$encendedor_obs','$latoneria','$latoneria_obs','$distintivos','$distintivos_obs','$bodegas','$bodegas_obs','$fluidos','$fluidos_obs','$palomeras','$palomeras_obs','$calcomania','$calcomania_obs','$como_conduzco','$como_conduzco_obs','$cierre_puertas','$cierre_puertas_obs','$frenos','$frenos_obs','$embrague','$embrague_obs','$suspension','$suspension_obs','$cambios','$cambios_obs','$pito','$pito_obs','$bateria','$bateria_obs','$freno_mano','$freno_mano_obs','$direccion','$direccion_obs','$novedades_danios','$observaciones','$observaciones_entrega','$id_usuario_registro','$fecha_registro')");
            
            /*$sql->bindParam(":entrega_vehiculo", $entrega_vehiculo);
            $sql->bindParam(":id_empresa", $id_empresa);
            $sql->bindParam(":contrato", $contrato);
            $sql->bindParam(":existe_vehiculo", $existe_vehiculo);
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->bindParam(":movil", $movil);
            $sql->bindParam(":placa", $placa);
            $sql->bindParam(":cantidad", $cantidad);
            $sql->bindParam(":modelo", $modelo);
            $sql->bindParam(":tipo_vehiculo", $tipo_vehiculo);
            $sql->bindParam(":tipo_combustible", $tipo_combustible);
            $sql->bindParam(":existe_conductor", $existe_conductor);
            $sql->bindParam(":id_conductor", $id_conductor);
            $sql->bindParam(":nombre_conductor ", $nombre_conductor );
            $sql->bindParam(":num_doc_conductor", $num_doc_conductor);
            $sql->bindParam(":tel_conductor", $tel_conductor);
            $sql->bindParam(":num_lic_conductor", $num_lic_conductor);
            $sql->bindParam(":fecha_lic_conductor", $fecha_lic_conductor);
            $sql->bindParam(":kilometraje", $kilometraje);
            $sql->bindParam(":nivel_gasolina", $nivel_gasolina);
            $sql->bindParam(":fecha_proximo_mtto", $fecha_proximo_mtto);
            $sql->bindParam(":rev_tecnomecanica", $rev_tecnomecanica);
            $sql->bindParam(":polizas_extra_contra", $polizas_extra_contra);
            $sql->bindParam(":preventiva", $preventiva );
            $sql->bindParam(":tarjeta_operacion", $tarjeta_operacion);
            $sql->bindParam(":soat", $soat);
            $sql->bindParam(":fuec", $fuec);
            $sql->bindParam(":tarjeta_propiedad_veh", $tarjeta_propiedad_veh);
            $sql->bindParam(":dispositivo_velocidad", $dispositivo_velocidad);
            $sql->bindParam(":tarjeta_propiedad_fv", $tarjeta_propiedad_fv);
            $sql->bindParam(":tarjeta_operacion_fv", $tarjeta_operacion_fv);
            $sql->bindParam(":soat_fv", $soat_fv);
            $sql->bindParam(":poliza_extra_fv", $poliza_extra_fv);
            $sql->bindParam(":tecnomecanica_fv", $tecnomecanica_fv);
            $sql->bindParam(":preventiva_fv", $preventiva_fv);
            $sql->bindParam(":fuec_fv", $fuec_fv);
            $sql->bindParam(":disp_velocidad_fv", $disp_velocidad_fv);
            $sql->bindParam(":licencia_transito", $licencia_transito);
            $sql->bindParam(":licencia_transito_fv", $licencia_transito_fv);
            $sql->bindParam(":licencia_conduccion", $licencia_conduccion);
            $sql->bindParam(":licencia_conduccion_fv", $licencia_conduccion_fv);
            $sql->bindParam(":seguridad_social", $seguridad_social);
            $sql->bindParam(":seguridad_social_fv", $seguridad_social_fv);
            $sql->bindParam(":gato", $gato);
            $sql->bindParam(":cruceta", $cruceta);
            $sql->bindParam(":seniales_carretera", $seniales_carretera);
            $sql->bindParam(":tacos", $tacos);
            $sql->bindParam(":linterna", $linterna);
            $sql->bindParam(":llaves_fijas", $llaves_fijas);
            $sql->bindParam(":alicates", $alicates);
            $sql->bindParam(":llave_expansiva", $llave_expansiva);
            $sql->bindParam(":destornillador", $destornillador);
            $sql->bindParam(":chaleco_reflectivo", $chaleco_reflectivo);
            $sql->bindParam(":martillo_frag", $martillo_frag);
            $sql->bindParam(":extintor", $extintor);
            $sql->bindParam(":extintor_cap", $extintor_cap);
            $sql->bindParam(":extintor_fv", $extintor_fv);
            $sql->bindParam(":gasas_esteriles", $gasas_esteriles);
            $sql->bindParam(":gasas_esteriles_fv", $gasas_esteriles_fv);
            $sql->bindParam(":algodon", $algodon);
            $sql->bindParam(":algodon_fv", $algodon_fv);
            $sql->bindParam(":venda_elastica", $venda_elastica);
            $sql->bindParam(":venda_elastica_fv", $venda_elastica_fv);
            $sql->bindParam(":micropore", $micropore);
            $sql->bindParam(":micropore_fv", $micropore_fv);
            $sql->bindParam(":curas", $curas);
            $sql->bindParam(":curas_fv", $curas_fv);
            $sql->bindParam(":bajalenguas", $bajalenguas);
            $sql->bindParam(":bajalenguas_fv", $bajalenguas_fv);
            $sql->bindParam(":guantes_latex", $guantes_latex);
            $sql->bindParam(":guantes_fv", $guantes_fv);
            $sql->bindParam(":copitos", $copitos);
            $sql->bindParam(":copitos_fv", $copitos_fv);
            $sql->bindParam(":pito_botiquin", $pito_botiquin);
            $sql->bindParam(":bolsas_rojas", $bolsas_rojas);
            $sql->bindParam(":suero", $suero);
            $sql->bindParam(":suero_fv", $suero_fv);
            $sql->bindParam(":antiseptico", $antiseptico);
            $sql->bindParam(":antiseptico_fv", $antiseptico_fv);
            $sql->bindParam(":tijeras", $tijeras);
            $sql->bindParam(":tijeras_fv", $tijeras_fv);
            $sql->bindParam(":aseo_personal", $aseo_personal);
            $sql->bindParam(":sistema_comunicacion", $sistema_comunicacion);
            $sql->bindParam(":gps", $gps);
            $sql->bindParam(":rutero", $rutero);
            $sql->bindParam(":aseo_interno", $aseo_interno);
            $sql->bindParam(":aseo_externo", $aseo_externo);
            $sql->bindParam(":luces", $luces);
            $sql->bindParam(":luces_obs", $luces_obs);
            $sql->bindParam(":direccionales", $direccionales);
            $sql->bindParam(":direccionales_obs", $direccionales_obs);
            $sql->bindParam(":panoramico", $panoramico);
            $sql->bindParam(":panoramico_obs", $panoramico_obs);
            $sql->bindParam(":limpiabrisas", $limpiabrisas);
            $sql->bindParam(":limpiabrisas_obs", $limpiabrisas_obs);
            $sql->bindParam(":stops", $stops);
            $sql->bindParam(":stops_obs", $stops_obs);
            $sql->bindParam(":luces_internas", $luces_internas);
            $sql->bindParam(":luces_internas_obs", $luces_internas_obs);
            $sql->bindParam(":luces_tablero", $luces_tablero);
            $sql->bindParam(":luces_tablero_obs", $luces_tablero_obs);
            $sql->bindParam(":aire_acondicionado", $aire_acondicionado);
            $sql->bindParam(":aire_acondicionado_obs", $aire_acondicionado_obs);
            $sql->bindParam(":radio", $radio);
            $sql->bindParam(":radio_obs", $radio_obs);
            $sql->bindParam(":televisor", $televisor);
            $sql->bindParam(":televisor_obs", $televisor_obs);
            $sql->bindParam(":boceles", $boceles);
            $sql->bindParam(":boceles_obs", $boceles_obs);
            $sql->bindParam(":antenas", $antenas);
            $sql->bindParam(":antenas_obs", $antenas_obs);
            $sql->bindParam(":rines", $rines);
            $sql->bindParam(":rines_obs", $rines_obs);
            $sql->bindParam(":airbag", $airbag);
            $sql->bindParam(":airbag_obs", $airbag_obs);
            $sql->bindParam(":tapiceria", $tapiceria);
            $sql->bindParam(":tapiceria_obs", $tapiceria_obs);
            $sql->bindParam(":silleteria", $silleteria);
            $sql->bindParam(":silleteria_obs", $silleteria_obs);
            $sql->bindParam(":disp_velocidad", $disp_velocidad);
            $sql->bindParam(":disp_velocidad_obs", $disp_velocidad_obs);
            $sql->bindParam(":cinturon_seguridad", $cinturon_seguridad);
            $sql->bindParam(":cinturon_seguridad_obs", $cinturon_seguridad_obs);
            $sql->bindParam(":cortinas", $cortinas);
            $sql->bindParam(":cortinas_obs", $cortinas_obs);
            $sql->bindParam(":salida_emergencia", $salida_emergencia);
            $sql->bindParam(":salida_emergencia_obs", $salida_emergencia_obs);
            $sql->bindParam(":martillos", $martillos);
            $sql->bindParam(":martillos_obs", $martillos_obs);
            $sql->bindParam(":estado_bano", $estado_bano);
            $sql->bindParam(":estado_bano_obs", $estado_bano_obs);
            $sql->bindParam(":vidrios", $vidrios);
            $sql->bindParam(":vidrios_obs", $vidrios_obs);
            $sql->bindParam(":llantas", $llantas);
            $sql->bindParam(":llantas_obs", $llantas_obs);
            $sql->bindParam(":repuesto", $repuesto);
            $sql->bindParam(":repuesto_obs", $repuesto_obs);
            $sql->bindParam(":tapetes", $tapetes);
            $sql->bindParam(":tapetes_obs", $tapetes_obs);
            $sql->bindParam(":encendedor", $encendedor);
            $sql->bindParam(":encendedor_obs", $encendedor_obs);
            $sql->bindParam(":latoneria", $latoneria);
            $sql->bindParam(":latoneria_obs", $latoneria_obs);
            $sql->bindParam(":distintivos", $distintivos);
            $sql->bindParam(":distintivos_obs", $distintivos_obs);
            $sql->bindParam(":bodegas", $bodegas);
            $sql->bindParam(":bodegas_obs", $bodegas_obs);
            $sql->bindParam(":fluidos", $fluidos);
            $sql->bindParam(":fluidos_obs", $fluidos_obs);
            $sql->bindParam(":palomeras", $palomeras);
            $sql->bindParam(":palomeras_obs", $palomeras_obs);
            $sql->bindParam(":calcomania", $calcomania);
            $sql->bindParam(":calcomania_obs", $calcomania_obs);
            $sql->bindParam(":como_conduzco", $como_conduzco);
            $sql->bindParam(":como_conduzco_obs", $como_conduzco_obs);
            $sql->bindParam(":cierre_puertas", $cierre_puertas);
            $sql->bindParam(":cierre_puertas_obs", $cierre_puertas_obs);
            $sql->bindParam(":frenos", $frenos);
            $sql->bindParam(":frenos_obs", $frenos_obs);
            $sql->bindParam(":embrague", $embrague);
            $sql->bindParam(":embrague_obs", $embrague_obs);
            $sql->bindParam(":suspension", $suspension);
            $sql->bindParam(":suspension_obs", $suspension_obs);
            $sql->bindParam(":cambios", $cambios);
            $sql->bindParam(":cambios_obs", $cambios_obs);
            $sql->bindParam(":pito", $pito);
            $sql->bindParam(":pito_obs", $pito_obs);
            $sql->bindParam(":bateria", $bateria);
            $sql->bindParam(":bateria_obs", $bateria_obs);
            $sql->bindParam(":freno_mano", $freno_mano);
            $sql->bindParam(":freno_mano_obs", $freno_mano_obs);
            $sql->bindParam(":direccion", $direccion);
            $sql->bindParam(":direccion_obs", $direccion_obs);
            $sql->bindParam(":novedades_danios", $novedades_danios);
            $sql->bindParam(":observaciones", $observaciones);
            $sql->bindParam(":observaciones_entrega", $observaciones_entrega);
            $sql->bindParam(":id_usuario_registro", $id_usuario_registro);
            $sql->bindParam(":fecha_registro", $fecha_registro);*/
  
            //echo "INSERT INTO inspeccion_vehicular (entrega_vehiculo, empresa, contrato, vehiculo_nuevo, id_vehiculo, movil, placa, capacidad, modelo, tipo_vehiculo, tipo_combustible, conductor_nuevo, id_conductor, nombre, num_cedula, num_licencia, celular, fecha_venc_licencia, kilometraje, nivel_gasolina, fecha_proximo_mtto, rev_tecnomecanica, polizas_extra_contra, preventiva, tarjeta_operacion, soat, fuec, tarjeta_propiedad_veh, dispositivo_velocidad, tarjeta_propiedad_fecha, tarjeta_operacion_fecha, soat_fecha, poliza_extra_fecha, tecnomecanica_fecha, preventiva_fecha, fuec_fecha, disp_velocidad_fecha, licencia_transito, licencia_transito_fv, licencia_conduccion, licencia_conduccion_fv, seguridad_social, seguridad_social_fv, gato, cruceta, seniales_carretera, tacos, linterna, llaves_fijas, alicates, llave_expansiva, destornillador, chaleco_reflectivo, martillo_frag, extintor, extintor_cap, extintor_fv, gasas_esteriles, gasas_esteriles_fv, algodon, algodon_fv, venda_elastica, venda_elastica_fv, micropore, micropore_fv, curas, curas_fv, bajalenguas, bajalenguas_fv, guantes_latex, guantes_fv, copitos, copitos_fv, pito_botiquin, bolsas_rojas, suero, suero_fv, antiseptico, antiseptico_fv, tijeras, tijeras_fv, aseo_personal, sistema_comunicacion, gps, rutero, aseo_interno, aseo_externo, luces, luces_obs, direccionales, direccionales_obs, panoramico, panoramico_obs, limpiabrisas, limpiabrisas_obs, stops, stops_obs, luces_internas, luces_internas_obs, luces_tablero, luces_tablero_obs, aire_acondicionado, aire_acondicionado_obs, radio, radio_obs, televisor, televisor_obs, boceles, boceles_obs, antenas, antenas_obs, rines, rines_obs, airbag, airbag_obs, tapiceria, tapiceria_obs, silleteria, silleteria_obs, disp_velocidad, disp_velocidad_obs, cinturon_seguridad, cinturon_seguridad_obs, cortinas, cortinas_obs, salida_emergencia, salida_emergencia_obs, martillos, martillos_obs, estado_bano, estado_bano_obs, vidrios, vidrios_obs, llantas, llantas_obs, repuesto, repuesto_obs, tapetes, tapetes_obs, encendedor, encendedor_obs, latoneria, latoneria_obs, distintivos, distintivos_obs, bodegas, bodegas_obs, fluidos, fluidos_obs, palomeras, palomeras_obs, calcomania, calcomania_obs, como_conduzco, como_conduzco_obs, cierre_puertas, cierre_puertas_obs, frenos, frenos_obs, embrague, embrague_obs, suspension, suspension_obs, cambios, cambios_obs, pito, pito_obs, bateria, bateria_obs, freno_mano, freno_mano_obs, direccion, direccion_obs, descripcion_danos_observados, observaciones, observaciones_entrega, id_usuario_registro, fecha_registro) VALUES ('$entrega_vehiculo','$id_empresa','$contrato','$existe_vehiculo','$id_vehiculo','$movil','$placa','$cantidad','$modelo','$tipo_vehiculo','$tipo_combustible','$existe_conductor','$id_conductor','$nombre_conductor', '$num_doc_conductor','$num_lic_conductor','$tel_conductor','$fecha_lic_conductor','$kilometraje','$nivel_gasolina','$fecha_proximo_mtto','$rev_tecnomecanica','$polizas_extra_contra','$preventiva','$tarjeta_operacion','$soat','$fuec','$tarjeta_propiedad_veh','$dispositivo_velocidad','$tarjeta_propiedad_fv','$tarjeta_operacion_fv','$soat_fv','$poliza_extra_fv','$tecnomecanica_fv','$preventiva_fv','$fuec_fv','$disp_velocidad_fv','$licencia_transito','$licencia_transito_fv','$licencia_conduccion','$licencia_conduccion_fv','$seguridad_social','$seguridad_social_fv','$gato','$cruceta','$seniales_carretera','$tacos','$linterna','$llaves_fijas','$alicates','$llave_expansiva','$destornillador','$chaleco_reflectivo','$martillo_frag','$extintor','$extintor_cap','$extintor_fv','$gasas_esteriles','$gasas_esteriles_fv','$algodon','$algodon_fv','$venda_elastica','$venda_elastica_fv','$micropore','$micropore_fv','$curas','$curas_fv','$bajalenguas','$bajalenguas_fv','$guantes_latex','$guantes_fv','$copitos','$copitos_fv','$pito_botiquin','$bolsas_rojas','$suero','$suero_fv','$antiseptico','$antiseptico_fv','$tijeras','$tijeras_fv','$aseo_personal','$sistema_comunicacion','$gps','$rutero','$aseo_interno','$aseo_externo','$luces','$luces_obs','$direccionales','$direccionales_obs','$panoramico','$panoramico_obs','$limpiabrisas','$limpiabrisas_obs','$stops','$stops_obs','$luces_internas','$luces_internas_obs','$luces_tablero','$luces_tablero_obs','$aire_acondicionado','$aire_acondicionado_obs','$radio','$radio_obs','$televisor','$televisor_obs','$boceles','$boceles_obs','$antenas','$antenas_obs','$rines','$rines_obs','$airbag','$airbag_obs','$tapiceria','$tapiceria_obs','$silleteria','$silleteria_obs','$disp_velocidad','$disp_velocidad_obs','$cinturon_seguridad','$cinturon_seguridad_obs','$cortinas','$cortinas_obs','$salida_emergencia','$salida_emergencia_obs','$martillos','$martillos_obs','$estado_bano','$estado_bano_obs','$vidrios','$vidrios_obs','$llantas','$llantas_obs','$repuesto','$repuesto_obs','$tapetes','$tapetes_obs','$encendedor','$encendedor_obs','$latoneria','$latoneria_obs','$distintivos','$distintivos_obs','$bodegas','$bodegas_obs','$fluidos','$fluidos_obs','$palomeras','$palomeras_obs','$calcomania','$calcomania_obs','$como_conduzco','$como_conduzco_obs','$cierre_puertas','$cierre_puertas_obs','$frenos','$frenos_obs','$embrague','$embrague_obs','$suspension','$suspension_obs','$cambios','$cambios_obs','$pito','$pito_obs','$bateria','$bateria_obs','$freno_mano','$freno_mano_obs','$direccion','$direccion_obs','$novedades_danios','$observaciones','$observaciones_entrega','$id_usuario_registro','$fecha_registro');";
  
            $sql->execute();
            return $id = $con->lastInsertId();          
            if (!$sql) {
                
                echo "\nPDO::errorInfo():\n";
                print_r($dbh->errorInfo());
            }
        
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function registrarEvidencia($id_inspeccion,$archivo,$fecha){        
	    try {
		    $con = Conexion::conectar();            
		    $sql = $con->prepare("INSERT INTO inspeccion_evidencias (id_inspeccion,archivo,fecha) VALUES (?,?,?)");
		    $sql->bindParam(1, $id_inspeccion);
		    $sql->bindParam(2, $archivo);
		    $sql->bindParam(3, $fecha);
		    $sql->execute();            
		    return $id = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage(); 
			return 0;
		}    
	}
	
	public function guardarFirmaEntrega($id,$firma,$nombre){
	    try {
		    $con = Conexion::conectar();            
		    $sql = $con->prepare("UPDATE inspeccion_vehicular SET entregado_por = :nombre, firma_entrega = :firma WHERE id_inspeccion = :id");
		    $sql->bindParam(":nombre", $nombre);
		    $sql->bindParam(":firma", $firma);
		    $sql->bindParam(":id", $id);
		    $sql->execute();
		    if (!$sql) {
		        return 0;
		    } else {
		        return $id;
		    }
		} catch (Exception $e) {
			return 0;
		}
	}
	
	public function guardarFirmaRecibe($id,$firma,$nombre){
	    try {
		    $con = Conexion::conectar();            
		    $sql = $con->prepare("UPDATE inspeccion_vehicular SET recibido_por = :nombre, firma_recibido = :firma WHERE id_inspeccion = :id");
		    $sql->bindParam(":nombre", $nombre);
		    $sql->bindParam(":firma", $firma);
		    $sql->bindParam(":id", $id);
		    $sql->execute();
		    if (!$sql) {
		        return 0;
		    } else {
		        return $id;
		    }
		} catch (Exception $e) {
			return 0;
		}
	}
	    
}

?>