<?php 
//include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/InspeccionVehicular.php");
require_once("../Modelo/General.php");
date_default_timezone_set('America/Bogota');
$fecha_archivo = date('YmdHis');

$entrega_vehiculo = $_POST['entrega_vehiculo'];
$existe_vehiculo = $_POST['existe_vehiculo'];
$existe_conductor = $_POST['existe_conductor'];
$id_empresa = $_POST['empresa'];
$contrato = $_POST['contrato'];
if($existe_vehiculo == 'SI'){
    $id_vehiculo = $_POST['id_vehiculo'];
} else {
    $id_vehiculo = 0;
}
$placa = $_POST['placa'];
$movil = $_POST['movil'];
$cantidad = $_POST['cantidad'];
$modelo = $_POST['modelo'];
$tipo_vehiculo = $_POST['tipo_vehiculo'];
$tipo_combustible = $_POST['tipo_combustible'];
if($existe_conductor == 'SI'){
    $id_conductor = $_POST['id_conductor'];
} else {
    $id_conductor = 0;
}
$nombre_conductor = $_POST['nombre_conductor'];
$num_doc_conductor = $_POST['num_doc_conductor'];
$num_lic_conductor = $_POST['num_lic_conductor'];
$tel_conductor = $_POST['tel_conductor'];
$fecha_lic_conductor = $_POST['fecha_lic_conductor'];
$kilometraje = $_POST['kilometraje'];
$nivel_gasolina = $_POST['nivel_gasolina'];
$fecha_proximo_mtto = $_POST['fecha_proximo_mtto'];

$rev_tecnomecanica = $_POST['revision_tecnomecanica'];
$polizas_extra_contra = $_POST['polizas_extra_contra'];
$preventiva = $_POST['revision_preventiva'];
$tarjeta_operacion = $_POST['tarjeta_operacion'];
$soat = $_POST['soat'];
$fuec = $_POST['fuec'];
//$tarjeta_propiedad_veh = $_POST['tarjeta_propiedad'];
$dispositivo_velocidad = $_POST['dispositivo_velocidad'];
$licencia_transito = $_POST['licencia_transito'];
$licencia_conduccion = $_POST['licencia_conduccion'];
$seguridad_social = $_POST['seguridad_social'];

//$tarjeta_propiedad_fv = $_POST['tarjeta_propiedad_fv'];
$tarjeta_operacion_fv = $_POST['tarjeta_operacion_fv'];
$soat_fv = $_POST['soat_fv'];
$poliza_extra_fv = $_POST['poliza_extra_fv'];
$tecnomecanica_fv = $_POST['tecnomecanica_fv'];
$preventiva_fv = $_POST['preventiva_fv'];
$fuec_fv = $_POST['fuec_fv'];
$disp_velocidad_fv = $_POST['disp_velocidad_fv'];
$licencia_transito_fv = $_POST['licencia_transito_fv'];
$licencia_conduccion_fv = $_POST['licencia_conduccion_fv'];
$seguridad_social_fv = $_POST['seguridad_social_fv'];

$gato = $_POST['gato'];
$cruceta = $_POST['cruceta'];
$seniales_carretera = $_POST['seniales_carretera'];
$tacos = $_POST['tacos'];
$linterna = $_POST['linterna'];
$llaves_fijas = $_POST['llaves_fijas'];
$alicates = $_POST['alicates'];
$llave_expansiva = $_POST['llave_expansiva'];
$destornillador = $_POST['destornillador'];
$chaleco_reflectivo = $_POST['chaleco_reflectivo'];
$martillo_frag = $_POST['martillo_frag'];
$extintor = $_POST['extintor'];
$extintor_fv = $_POST['extintor_fv'];
$extintor_cap = $_POST['extintor_cap'];

$gasas_esteriles = $_POST['gasas_esteriles'];
$gasas_esteriles_fv = $_POST['gasas_esteriles_fv'];
$algodon = $_POST['algodon'];
$algodon_fv = $_POST['algodon_fv'];
$venda_elastica = $_POST['venda_elastica'];
$venda_elastica_fv = $_POST['venda_elastica_fv'];
$micropore = $_POST['micropore'];
$micropore_fv = $_POST['micropore_fv'];
$curas = $_POST['curas'];
$curas_fv = $_POST['curas_fv'];
$bajalenguas = $_POST['bajalenguas'];
$bajalenguas_fv = $_POST['bajalenguas_fv'];
$guantes_latex = $_POST['guantes_latex'];
$guantes_fv = $_POST['guantes_fv'];
$copitos = $_POST['copitos'];
$copitos_fv = $_POST['copitos_fv'];
$pito_botiquin = $_POST['pito_botiquin'];
$bolsas_rojas = $_POST['bolsas_rojas'];
$suero = $_POST['suero'];
$suero_fv = $_POST['suero_fv'];
$antiseptico = $_POST['antiseptico'];
$antiseptico_fv = $_POST['antiseptico_fv'];
$tijeras = $_POST['tijeras'];
$tijeras_fv = $_POST['tijeras_fv'];
$aseo_personal = $_POST['aseo_personal'];
$sistema_comunicacion = $_POST['sistema_comunicacion'];
$gps = $_POST['gps'];
$rutero = $_POST['rutero'];
$aseo_interno = $_POST['aseo_interno'];
$aseo_externo = $_POST['aseo_externo'];
$luces = $_POST['luces'];
$luces_obs = $_POST['luces_obs'];
$direccionales = $_POST['direccionales'];
$direccionales_obs = $_POST['direccionales_obs'];
$panoramico = $_POST['panoramico'];
$panoramico_obs = $_POST['panoramico_obs'];
$limpiabrisas = $_POST['limpiabrisas'];
$limpiabrisas_obs = $_POST['limpiabrisas_obs'];
$stops = $_POST['stops'];
$stops_obs = $_POST['stops_obs'];
$luces_internas = $_POST['luces_internas'];
$luces_internas_obs = $_POST['luces_internas_obs'];
$luces_tablero = $_POST['luces_tablero'];
$luces_tablero_obs = $_POST['luces_tablero_obs'];
$aire_acondicionado = $_POST['aire_acondicionado'];
$aire_acondicionado_obs = $_POST['aire_acondicionado_obs'];
$radio = $_POST['radio'];
$radio_obs = $_POST['radio_obs'];
$televisor = $_POST['televisor'];
$televisor_obs = $_POST['televisor_obs'];
$boceles = $_POST['boceles'];
$boceles_obs = $_POST['boceles_obs'];
$antenas = $_POST['antenas'];
$antenas_obs = $_POST['antenas_obs'];
$rines = $_POST['rines'];
$rines_obs = $_POST['rines_obs'];
$airbag = $_POST['airbag'];
$airbag_obs = $_POST['airbag_obs'];
$tapiceria = $_POST['tapiceria'];
$tapiceria_obs = $_POST['tapiceria_obs'];
$silleteria = $_POST['silleteria'];
$silleteria_obs = $_POST['silleteria_obs'];
$disp_velocidad = $_POST['disp_velocidad'];
$disp_velocidad_obs = $_POST['disp_velocidad_obs'];
$cinturon_seguridad = $_POST['cinturon_seguridad'];
$cinturon_seguridad_obs = $_POST['cinturon_seguridad_obs'];
$cortinas = $_POST['cortinas'];
$cortinas_obs = $_POST['cortinas_obs'];
$salida_emergencia = $_POST['salida_emergencia'];
$salida_emergencia_obs = $_POST['salida_emergencia_obs'];
$martillos = $_POST['martillos'];
$martillos_obs = $_POST['martillos_obs'];
$estado_bano = $_POST['estado_bano'];
$estado_bano_obs = $_POST['estado_bano_obs'];
$vidrios = $_POST['vidrios'];
$vidrios_obs = $_POST['vidrios_obs'];
$llantas = $_POST['llantas'];
$llantas_obs = $_POST['llantas_obs'];
$repuesto = $_POST['repuesto'];
$repuesto_obs = $_POST['repuesto_obs'];
$tapetes = $_POST['tapetes'];
$tapetes_obs = $_POST['tapetes_obs'];
$encendedor = $_POST['encendedor'];
$encendedor_obs = $_POST['encendedor_obs'];
$latoneria = $_POST['latoneria'];
$latoneria_obs = $_POST['latoneria_obs'];
$distintivos = $_POST['distintivos'];
$distintivos_obs = $_POST['distintivos_obs'];
$bodegas = $_POST['bodegas'];
$bodegas_obs = $_POST['bodegas_obs'];
$fluidos = $_POST['fluidos'];
$fluidos_obs = $_POST['fluidos_obs'];
$palomeras = $_POST['palomeras'];
$palomeras_obs = $_POST['palomeras_obs'];
$calcomania = $_POST['calcomania'];
$calcomania_obs = $_POST['calcomania_obs'];
$como_conduzco = $_POST['como_conduzco'];
$como_conduzco_obs = $_POST['como_conduzco_obs'];
$cierre_puertas = $_POST['cierre_puertas'];
$cierre_puertas_obs = $_POST['cierre_puertas_obs'];
$frenos = $_POST['frenos'];
$frenos_obs = $_POST['frenos_obs'];
$embrague = $_POST['embrague'];
$embrague_obs = $_POST['embrague_obs'];
$suspension = $_POST['suspension'];
$suspension_obs = $_POST['suspension_obs'];
$cambios = $_POST['cambios'];
$cambios_obs = $_POST['cambios_obs'];
$pito = $_POST['pito'];
$pito_obs = $_POST['pito_obs'];
$bateria = $_POST['bateria'];
$bateria_obs = $_POST['bateria_obs'];
$freno_mano = $_POST['freno_mano'];
$freno_mano_obs = $_POST['freno_mano_obs'];
$direccion = $_POST['direccion'];
$direccion_obs = $_POST['direccion_obs'];

$novedades_danios = $_POST['novedades_danios'];
$observaciones = $_POST['observaciones'];
$evidencias = $_FILES['evidencias'];
if($entrega_vehiculo == 'SI'){
    $observaciones_entrega = $_POST['observaciones_entrega'];
} else {
    $observaciones_entrega = '';
}
$id_usuario_registro = $_SESSION['id_usuario'];
$id_usuario_registro = '2';
$fecha_registro = date('Y-m-d H:i:s');

$inspeccionVehicular = new InspeccionVehicular();

$registrarInspeccionVehicular = $inspeccionVehicular->registrar($entrega_vehiculo,$id_empresa,$contrato,$existe_vehiculo,$id_vehiculo,$movil,$placa,$cantidad,$modelo,$tipo_vehiculo,
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
    $pito,$pito_obs,$bateria,$bateria_obs,$freno_mano,$freno_mano_obs,$direccion,$direccion_obs,$novedades_danios,$observaciones,$observaciones_entrega,$id_usuario_registro,$fecha_registro);

echo "ID: ".$registrarInspeccionVehicular;

//print_r($evidencias);
if($registrarInspeccionVehicular > 0){
    if(count($evidencias) > 0){
        $carpeta = "../Documentos/Inspeccion/".$registrarInspeccionVehicular;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        
        for($i=0;$i<count($evidencias);$i++){
            if($evidencias['name'][$i] != ''){
                $archivo = quitar_simbolos($evidencias['name'][$i]);
                $archivo = $fecha_archivo.'_'.$archivo;                    
                $ruta = $carpeta .'/'. $archivo;                    
                $ruta_temp = $evidencias['tmp_name'][$i];
                move_uploaded_file($ruta_temp, $ruta);
                
                $registrar_evidencia = $inspeccionVehicular->registrarEvidencia($registrarInspeccionVehicular,$archivo,$fecha_registro);
            }
        }
    }
}

if($registrarInspeccionVehicular > 0){
    if($entrega_vehiculo == 'SI'){
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Registro Inspeccion Entrega Realizado Correctamente, Continue Al Proceso De Firmas');
        window.location.href='../Vista/firmaEntregaInspeccionVehicular.php?id=".$registrarInspeccionVehicular."';
        </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Registro Inspeccion Realizado Correctamente');
        window.location.href='../Vista/inspeccionVehicular.php';
        </script>");
    }
} else {
    /*echo ("<script LANGUAGE='JavaScript'>
    window.alert('Error al Registrar, Intente Nuevamente');
    history.back();
    </script>");*/
}
?>