<?php 
//include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/InspeccionVehicular.php';
require_once '../Modelo/Usuario.php';

$inspeccion = new InspeccionVehicular();
$usuario = new Usuario();

$hoy = date('Y-m-d');
if($_POST){
    $fecha_inicial = $_POST['fecha_inicial'];
    $fecha_final = $_POST['fecha_final'];
} else {
    $fecha_inicial = $hoy;
    $fecha_final = $hoy;
}

header('Content-type: application/vnd.ms-excel;charset=iso-8859-1');
header('Content-Disposition: attachment; filename=Reporte_Inspeccion_Vehicular_'.$fecha_inicial.'_'.$fecha_final.'.xls');

$listado = $inspeccion->listarPorRangoFechas($fecha_inicial,$fecha_final);
?>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>ENTREGA_VEHICULO</th>
            <th>EMPRESA</th>
            <th>CONTRATO</th>
            <th>EXISTE_VEHICULO</th>
            <th>ID_VEHICULO</th>
            <th>MOVIL</th>
            <th>PLACA</th>
            <th>CAPACIDAD</th>
            <th>MODELO</th>
            <th>TIPO_VEHICULO</th>
            <th>TIPO_COMBUSTIBLE</th>
            <th>EXISTE_CONDUCTOR</th>
            <th>ID_CONDUCTOR</th>
            <th>NOMBRE CONDUCTOR</th>
            <th>NUM_CEDULA</th>
            <th>CELULAR</th>
            <th>NUM_LICENCIA</th>
            <th>FECHA_VENC_LICENCIA</th>
            <th>KILOMETRAJE</th>
            <th>NIVEL_GASOLINA</th>
            <th>FECHA_PROXIMO_MTTO</th>
            <th>REV_TECNOMECANICA</th>
            <th>POLIZAS_EXTRA_CONTRA</th>
            <th>PREVENTIVA</th>
            <th>TARJETA_OPERACION</th>
            <th>SOAT</th>
            <th>FUEC</th>
            <!--<th>TARJETA_PROPIEDAD_VEH</th>-->
            <th>DISPOSITIVO_VELOCIDAD</th>
            <!--<th>TARJETA_PROPIEDAD_FECHA</th>-->
            <th>TARJETA_OPERACION_FECHA</th>
            <th>SOAT_FECHA</th>
            <th>POLIZA_EXTRA_FECHA</th>
            <th>TECNOMECANICA_FECHA</th>
            <th>PREVENTIVA_FECHA</th>
            <th>FUEC_FECHA</th>
            <th>DISP_VELOCIDAD_FECHA</th>
            <th>LICENCIA_TRANSITO</th>
            <th>LICENCIA_TRANSITO_FV</th>
            <th>LICENCIA_CONDUCCION</th>
            <th>LICENCIA_CONDUCCION_FV</th>
            <th>SEGURIDAD_SOCIAL</th>
            <th>SEGURIDAD_SOCIAL_FV</th>
            <th>GATO</th>
            <th>CRUCETA</th>
            <th>SENIALES_CARRETERA</th>
            <th>TACOS</th>
            <th>LINTERNA</th>
            <th>LLAVES_FIJAS</th>
            <th>ALICATES</th>
            <th>LLAVE_EXPANSIVA</th>
            <th>DESTORNILLADOR</th>
            <th>CHALECO_REFLECTIVO</th>
            <th>MARTILLO_FRAG</th>
            <th>EXTINTOR</th>
            <th>EXTINTOR_CAP</th>
            <th>EXTINTOR_FV</th>
            <th>GASAS_ESTERILES</th>
            <th>GASAS_ESTERILES_FV</th>
            <th>ALGODON</th>
            <th>ALGODON_FV</th>
            <th>VENDA_ELASTICA</th>
            <th>VENDA_ELASTICA_FV</th>
            <th>MICROPORE</th>
            <th>MICROPORE_FV</th>
            <th>CURAS</th>
            <th>CURAS_FV</th>
            <th>BAJALENGUAS</th>
            <th>BAJALENGUAS_FV</th>
            <th>GUANTES_LATEX</th>
            <th>GUANTES_FV</th>
            <th>COPITOS</th>
            <th>COPITOS_FV</th>
            <th>PITO BOTIQUIN</th>
            <th>BOLSAS ROJAS</th>
            <th>SUERO</th>
            <th>SUERO_FV</th>
            <!--<th>ANTISEPTICO</th>
            <th>ANTISEPTICO_FV</th>-->
            <th>TIJERAS</th>
            <th>TIJERAS_FV</th>
            <th>ASEO_PERSONAL</th>
            <th>SISTEMA_COMUNICACION</th>
            <th>GPS</th>
            <th>RUTERO</th>
            <th>ASEO_INTERNO</th>
            <th>ASEO_EXTERNO</th>
            <th>LUCES</th>
            <th>LUCES_OBS</th>
            <th>DIRECCIONALES</th>
            <th>DIRECCIONALES_OBS</th>
            <th>PANORAMICO</th>
            <th>PANORAMICO_OBS</th>
            <th>LIMPIABRISAS</th>
            <th>LIMPIABRISAS_OBS</th>
            <th>STOPS</th>
            <th>STOPS_OBS</th>
            <th>LUCES_INTERNAS</th>
            <th>LUCES_INTERNAS_OBS</th>
            <th>LUCES_TABLERO</th>
            <th>LUCES_TABLERO_OBS</th>
            <th>AIRE_ACONDICIONADO</th>
            <th>AIRE_ACONDICIONADO_OBS</th>
            <th>RADIO</th>
            <th>RADIO_OBS</th>
            <th>TELEVISOR</th>
            <th>TELEVISOR_OBS</th>
            <th>BOCELES</th>
            <th>BOCELES_OBS</th>
            <th>ANTENAS</th>
            <th>ANTENAS_OBS</th>
            <th>RINES</th>
            <th>RINES_OBS</th>
            <th>AIRBAG</th>
            <th>AIRBAG_OBS</th>
            <th>TAPICERIA</th>
            <th>TAPICERIA_OBS</th>
            <th>SILLETERIA</th>
            <th>SILLETERIA_OBS</th>
            <th>DISP_VELOCIDAD</th>
            <th>DISP_VELOCIDAD_OBS</th>
            <th>CINTURON_SEGURIDAD</th>
            <th>CINTURON_SEGURIDAD_OBS</th>
            <th>CORTINAS</th>
            <th>CORTINAS_OBS</th>
            <th>SALIDA_EMERGENCIA</th>
            <th>SALIDA_EMERGENCIA_OBS</th>
            <th>MARTILLOS</th>
            <th>MARTILLOS_OBS</th>
            <th>ESTADO_BANO</th>
            <th>ESTADO_BANO_OBS</th>
            <th>VIDRIOS</th>
            <th>VIDRIOS_OBS</th>
            <th>LLANTAS</th>
            <th>LLANTAS_OBS</th>
            <th>REPUESTO</th>
            <th>REPUESTO_OBS</th>
            <th>TAPETES</th>
            <th>TAPETES_OBS</th>
            <th>ENCENDEDOR</th>
            <th>ENCENDEDOR_OBS</th>
            <th>LATONERIA</th>
            <th>LATONERIA_OBS</th>
            <th>DISTINTIVOS</th>
            <th>DISTINTIVOS_OBS</th>
            <th>BODEGAS</th>
            <th>BODEGAS_OBS</th>
            <th>FLUIDOS</th>
            <th>FLUIDOS_OBS</th>
            <th>PALOMERAS</th>
            <th>PALOMERAS_OBS</th>
            <th>CALCOMANIA</th>
            <th>CALCOMANIA_OBS</th>
            <th>COMO_CONDUZCO</th>
            <th>COMO_CONDUZCO_OBS</th>
            <th>CIERRE_PUERTAS</th>
            <th>CIERRE_PUERTAS_OBS</th>
            <th>FRENOS</th>
            <th>FRENOS_OBS</th>
            <th>EMBRAGUE</th>
            <th>EMBRAGUE_OBS</th>
            <th>SUSPENSION</th>
            <th>SUSPENSION_OBS</th>
            <th>CAMBIOS</th>
            <th>CAMBIOS_OBS</th>
            <th>PITO</th>
            <th>PITO_OBS</th>
            <th>BATERIA</th>
            <th>BATERIA_OBS</th>
            <th>FRENO_MANO</th>
            <th>FRENO_MANO_OBS</th>
            <th>DIRECCION</th>
            <th>DIRECCION_OBS</th>
            <th>DESCRIPCION_DANOS_OBSERVADOS</th>
            <th>OBSERVACIONES</th>
            <th>ENTREGADO_POR</th>
            <th>RECIBIDO_POR</th>
            <th>OBSERVACIONES_ENTREGA</th>
            <th>USUARIO_REGISTRO</th>
            <th>FECHA_REGISTRO</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        <?php foreach ($listado as $frdo){ ?>
            <tr>
                <td><?php echo $frdo['id_inspeccion']; ?></td>
                <td><?php echo $frdo['entrega_vehiculo']; ?></td>
                <td><?php echo $frdo['empresa']; ?></td>
                <td><?php echo $frdo['contrato']; ?></td>
                <td><?php echo $frdo['vehiculo_nuevo']; ?></td>
                <td><?php echo $frdo['id_vehiculo']; ?></td>
                <td><?php echo $frdo['movil']; ?></td>
                <td><?php echo $frdo['placa']; ?></td>
                <td><?php echo $frdo['capacidad']; ?></td>
                <td><?php echo $frdo['modelo']; ?></td>
                <td><?php echo $frdo['tipo_vehiculo']; ?></td>
                <td><?php echo $frdo['tipo_combustible']; ?></td>
                <td><?php echo $frdo['conductor_nuevo']; ?></td>
                <td><?php echo $frdo['id_conductor']; ?></td>
                <td><?php echo $frdo['nombre']; ?></td>
                <td><?php echo $frdo['num_cedula']; ?></td>
                <td><?php echo $frdo['celular']; ?></td>
                <td><?php echo $frdo['num_licencia']; ?></td>
                <td><?php echo $frdo['fecha_venc_licencia']; ?></td>
                <td><?php echo $frdo['kilometraje']; ?></td>
                <td>
                    <?php 
                    if ($frdo['nivel_gasolina'] == 'Empty'){
                        echo "TANQUE VACIO";
                    } else if ($frdo['nivel_gasolina'] == '1/4'){
                        echo "TANQUE 1/4";
                    } else if ($frdo['nivel_gasolina'] == '1/2'){
                        echo "TANQUE 1/2";
                    } else if ($frdo['nivel_gasolina'] == 'small'){
                        echo "TANQUE 3/$";
                    } else if ($frdo['nivel_gasolina'] == 'Full'){
                        echo "TANQUE LLENO";
                    } else {
                        echo "N/A";
                    } 
                    ?>
                </td>
                <td><?php echo $frdo['fecha_proximo_mtto']; ?></td>
                <td><?php echo $frdo['rev_tecnomecanica']; ?></td>
                <td><?php echo $frdo['polizas_extra_contra']; ?></td>
                <td><?php echo $frdo['preventiva']; ?></td>
                <td><?php echo $frdo['tarjeta_operacion']; ?></td>
                <td><?php echo $frdo['soat']; ?></td>
                <td><?php echo $frdo['fuec']; ?></td>
                <!--<td><?php echo $frdo['tarjeta_propiedad_veh']; ?></td>-->
                <td><?php echo $frdo['dispositivo_velocidad']; ?></td>
                <!--<td><?php echo $frdo['tarjeta_propiedad_fecha']; ?></td>-->
                <td><?php echo $frdo['tarjeta_operacion_fecha']; ?></td>
                <td><?php echo $frdo['soat_fecha']; ?></td>
                <td><?php echo $frdo['poliza_extra_fecha']; ?></td>
                <td><?php echo $frdo['tecnomecanica_fecha']; ?></td>
                <td><?php echo $frdo['preventiva_fecha']; ?></td>
                <td><?php echo $frdo['fuec_fecha']; ?></td>
                <td><?php echo $frdo['disp_velocidad_fecha']; ?></td>
                <td><?php echo $frdo['licencia_transito']; ?></td>
                <td><?php echo $frdo['licencia_transito_fv']; ?></td>
                <td><?php echo $frdo['licencia_conduccion']; ?></td>
                <td><?php echo $frdo['licencia_conduccion_fv']; ?></td>
                <td><?php echo $frdo['seguridad_social']; ?></td>
                <td><?php echo $frdo['seguridad_social_fv']; ?></td>
                <td><?php echo $frdo['gato']; ?></td>
                <td><?php echo $frdo['cruceta']; ?></td>
                <td><?php echo $frdo['seniales_carretera']; ?></td>
                <td><?php echo $frdo['tacos']; ?></td>
                <td><?php echo $frdo['linterna']; ?></td>
                <td><?php echo $frdo['llaves_fijas']; ?></td>
                <td><?php echo $frdo['alicates']; ?></td>
                <td><?php echo $frdo['llave_expansiva']; ?></td>
                <td><?php echo $frdo['destornillador']; ?></td>
                <td><?php echo $frdo['chaleco_reflectivo']; ?></td>
                <td><?php echo $frdo['martillo_frag']; ?></td>
                <td><?php echo $frdo['extintor']; ?></td>
                <td><?php echo $frdo['extintor_cap']; ?></td>
                <td><?php echo $frdo['extintor_fv']; ?></td>
                <td><?php echo $frdo['gasas_esteriles']; ?></td>
                <td><?php echo $frdo['gasas_esteriles_fv']; ?></td>
                <td><?php echo $frdo['algodon']; ?></td>
                <td><?php echo $frdo['algodon_fv']; ?></td>
                <td><?php echo $frdo['venda_elastica']; ?></td>
                <td><?php echo $frdo['venda_elastica_fv']; ?></td>
                <td><?php echo $frdo['micropore']; ?></td>
                <td><?php echo $frdo['micropore_fv']; ?></td>
                <td><?php echo $frdo['curas']; ?></td>
                <td><?php echo $frdo['curas_fv']; ?></td>
                <td><?php echo $frdo['bajalenguas']; ?></td>
                <td><?php echo $frdo['bajalenguas_fv']; ?></td>
                <td><?php echo $frdo['guantes_latex']; ?></td>
                <td><?php echo $frdo['guantes_fv']; ?></td>
                <td><?php echo $frdo['copitos']; ?></td>
                <td><?php echo $frdo['copitos_fv']; ?></td>
                <td><?php echo $frdo['pito_botiquin']; ?></td>
                <td><?php echo $frdo['bolsas_rojas']; ?></td>
                <td><?php echo $frdo['suero']; ?></td>
                <td><?php echo $frdo['suero_fv']; ?></td>
                <!--<td><?php echo $frdo['antiseptico']; ?></td>
                <td><?php echo $frdo['antiseptico_fv']; ?></td>-->
                <td><?php echo $frdo['tijeras']; ?></td>
                <td><?php echo $frdo['tijeras_fv']; ?></td>
                <td><?php echo $frdo['aseo_personal']; ?></td>
                <td><?php echo $frdo['sistema_comunicacion']; ?></td>
                <td><?php echo $frdo['gps']; ?></td>
                <td><?php echo $frdo['rutero']; ?></td>
                <td><?php echo $frdo['aseo_interno']; ?></td>
                <td><?php echo $frdo['aseo_externo']; ?></td>
                <td><?php echo $frdo['luces']; ?></td>
                <td><?php echo $frdo['luces_obs']; ?></td>
                <td><?php echo $frdo['direccionales']; ?></td>
                <td><?php echo $frdo['direccionales_obs']; ?></td>
                <td><?php echo $frdo['panoramico']; ?></td>
                <td><?php echo $frdo['panoramico_obs']; ?></td>
                <td><?php echo $frdo['limpiabrisas']; ?></td>
                <td><?php echo $frdo['limpiabrisas_obs']; ?></td>
                <td><?php echo $frdo['stops']; ?></td>
                <td><?php echo $frdo['stops_obs']; ?></td>
                <td><?php echo $frdo['luces_internas']; ?></td>
                <td><?php echo $frdo['luces_internas_obs']; ?></td>
                <td><?php echo $frdo['luces_tablero']; ?></td>
                <td><?php echo $frdo['luces_tablero_obs']; ?></td>
                <td><?php echo $frdo['aire_acondicionado']; ?></td>
                <td><?php echo $frdo['aire_acondicionado_obs']; ?></td>
                <td><?php echo $frdo['radio']; ?></td>
                <td><?php echo $frdo['radio_obs']; ?></td>
                <td><?php echo $frdo['televisor']; ?></td>
                <td><?php echo $frdo['televisor_obs']; ?></td>
                <td><?php echo $frdo['boceles']; ?></td>
                <td><?php echo $frdo['boceles_obs']; ?></td>
                <td><?php echo $frdo['antenas']; ?></td>
                <td><?php echo $frdo['antenas_obs']; ?></td>
                <td><?php echo $frdo['rines']; ?></td>
                <td><?php echo $frdo['rines_obs']; ?></td>
                <td><?php echo $frdo['airbag']; ?></td>
                <td><?php echo $frdo['airbag_obs']; ?></td>
                <td><?php echo $frdo['tapiceria']; ?></td>
                <td><?php echo $frdo['tapiceria_obs']; ?></td>
                <td><?php echo $frdo['silleteria']; ?></td>
                <td><?php echo $frdo['silleteria_obs']; ?></td>
                <td><?php echo $frdo['disp_velocidad']; ?></td>
                <td><?php echo $frdo['disp_velocidad_obs']; ?></td>
                <td><?php echo $frdo['cinturon_seguridad']; ?></td>
                <td><?php echo $frdo['cinturon_seguridad_obs']; ?></td>
                <td><?php echo $frdo['cortinas']; ?></td>
                <td><?php echo $frdo['cortinas_obs']; ?></td>
                <td><?php echo $frdo['salida_emergencia']; ?></td>
                <td><?php echo $frdo['salida_emergencia_obs']; ?></td>
                <td><?php echo $frdo['martillos']; ?></td>
                <td><?php echo $frdo['martillos_obs']; ?></td>
                <td><?php echo $frdo['estado_bano']; ?></td>
                <td><?php echo $frdo['estado_bano_obs']; ?></td>
                <td><?php echo $frdo['vidrios']; ?></td>
                <td><?php echo $frdo['vidrios_obs']; ?></td>
                <td><?php echo $frdo['llantas']; ?></td>
                <td><?php echo $frdo['llantas_obs']; ?></td>
                <td><?php echo $frdo['repuesto']; ?></td>
                <td><?php echo $frdo['repuesto_obs']; ?></td>
                <td><?php echo $frdo['tapetes']; ?></td>
                <td><?php echo $frdo['tapetes_obs']; ?></td>
                <td><?php echo $frdo['encendedor']; ?></td>
                <td><?php echo $frdo['encendedor_obs']; ?></td>
                <td><?php echo $frdo['latoneria']; ?></td>
                <td><?php echo $frdo['latoneria_obs']; ?></td>
                <td><?php echo $frdo['distintivos']; ?></td>
                <td><?php echo $frdo['distintivos_obs']; ?></td>
                <td><?php echo $frdo['bodegas']; ?></td>
                <td><?php echo $frdo['bodegas_obs']; ?></td>
                <td><?php echo $frdo['fluidos']; ?></td>
                <td><?php echo $frdo['fluidos_obs']; ?></td>
                <td><?php echo $frdo['palomeras']; ?></td>
                <td><?php echo $frdo['palomeras_obs']; ?></td>
                <td><?php echo $frdo['calcomania']; ?></td>
                <td><?php echo $frdo['calcomania_obs']; ?></td>
                <td><?php echo $frdo['como_conduzco']; ?></td>
                <td><?php echo $frdo['como_conduzco_obs']; ?></td>
                <td><?php echo $frdo['cierre_puertas']; ?></td>
                <td><?php echo $frdo['cierre_puertas_obs']; ?></td>
                <td><?php echo $frdo['frenos']; ?></td>
                <td><?php echo $frdo['frenos_obs']; ?></td>
                <td><?php echo $frdo['embrague']; ?></td>
                <td><?php echo $frdo['embrague_obs']; ?></td>
                <td><?php echo $frdo['suspension']; ?></td>
                <td><?php echo $frdo['suspension_obs']; ?></td>
                <td><?php echo $frdo['cambios']; ?></td>
                <td><?php echo $frdo['cambios_obs']; ?></td>
                <td><?php echo $frdo['pito']; ?></td>
                <td><?php echo $frdo['pito_obs']; ?></td>
                <td><?php echo $frdo['bateria']; ?></td>
                <td><?php echo $frdo['bateria_obs']; ?></td>
                <td><?php echo $frdo['freno_mano']; ?></td>
                <td><?php echo $frdo['freno_mano_obs']; ?></td>
                <td><?php echo $frdo['direccion']; ?></td>
                <td><?php echo $frdo['direccion_obs']; ?></td>
                <td><?php echo $frdo['descripcion_danos_observados']; ?></td>
                <td><?php echo $frdo['observaciones']; ?></td>
                <td><?php echo $frdo['entregado_por']; ?></td>
                <td><?php echo $frdo['recibido_por']; ?></td>
                <td><?php echo $frdo['observaciones_entrega']; ?></td>
                <td>
                    <?php 
                        $datos_usu = $usuario->listarUsuarioPorId($frdo['id_usuario_registro']);
                        echo $datos_usu[0]['nombre']; 
                    ?>
                </td>
                <td><?php echo $frdo['fecha_registro']; ?></td>
                
            </tr>
        <?php } ?>
    </tbody>
</table>