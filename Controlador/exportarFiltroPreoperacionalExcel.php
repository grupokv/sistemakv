<?php  

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte_FiltroPreoperacionales.xls');

require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Pre-operacionales.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/EmpresaEnt.php");

$vehiculo = new Vehiculo();
$veh_con = new Vehiculo_Contrato();
$contrato = new Contrato();
$hoy = date('Y-m-d');
$listadoContratos = $contrato->listarContratosHabiles($hoy);
$listarTodosVehiculos = $vehiculo->listarActivos();
$conductor = new Conductor();
$usuario = new Usuario();
$empresa = new Empresa();
$cliente = new Cliente();


$id_vehiculo = '';

if ($_POST['vehiculo'] != 0) {    
    $id_vehiculo = $_POST['vehiculo'];
} else {    
    $id_vehiculo = '%%';
}

$id_contrato = '';

if ($_POST['contrato'] != 0) {    
	$id_contrato = $_POST['contrato'];
}

$fecha_inicial = '0000-00-00';

if ($_POST['fechaInicial'] != '') {    
    $fecha_inicial = $_POST['fechaInicial'];
} else {    
    $fecha_inicial = '0000-00-00';
}

$fecha_final = '9999-12-31';

if ($_POST['fechaFinal'] != '') {    
    $fecha_final = $_POST['fechaFinal'];
} else {    
    $fecha_final = '9999-12-31';
}

/*echo $id_vehiculo;
echo $id_contrato;
echo $fecha_inicial;
echo $fecha_final;
*/
$preoperacional = new PreOperacionales();

if($_POST){
    if($id_contrato != ''){ 
        if($id_vehiculo == '%%'){     
            $id_vehiculo = '';    
            $listado_veh = $veh_con->listarPorContrato($id_contrato);     
            $cant = count($listado_veh);      
            $i = 1;   
            foreach($listado_veh as $lv){       
                if($i == $cant){        
                    $id_vehiculo = $id_vehiculo.''.$lv['id_vehiculo'];      
                } else {        
                    $id_vehiculo = $id_vehiculo.''.$lv['id_vehiculo']. ',';      
                }       
                $i++;     
            }   
        }   

        $listarP = $preoperacional->listarTodosPreoperacionalContrato($id_vehiculo, $fecha_inicial, $fecha_final);

    } else {    
        $listarP = $preoperacional->listarTodos($id_vehiculo, $fecha_inicial, $fecha_final);
    }
} else {
    $fecha = date('Y-m-d');
    $listarP = $preoperacional->listar($fecha);
}
/*
print_r($listarP);*/

?>

<table border="1">
    <thead>
        <tr>
            <th>VEHICULO</th>
            <th>CONDUCTOR</th>
            <th>FECHA CREACION</th>
            <th>PUERTAS</th>
            <th>ESPEJOS RETROVISORES</th>
            <th>VENTANAS</th>
            <th>VIDRIO FRONTAL</th>
            <th>LLANTAS - RINES</th>
            <th>LLANTAS REPUESTO</th>
            <th>LUCES DELANTERAS</th>
            <th>LUCES FRENO</th>
            <th>LUCES RESERVA</th>
            <th>LUCES PARQUEO DIRECCIONALES</th>
            <th>SISTEMA DE SUSPENSIÓN</th>
            <th>SISTEMA DE FRENOS</th>
            <th>SISTEMA DE DIRECCION</th>
            <th>TAPAS</th>
            <th>NIVELES DE ACEITE DEL MOTOR</th>
            <th>RADIADOR VENTILADOR DE CORREAS</th>
            <th>MANGUERAS</th>
            <th>TRANSMISION</th>
            <th>FILTRO DE AIRE</th>
            <th>FUGAS DEL MOTOR</th>
            <th>BOMBA DE FRENO CLUTCH</th>
            <th>BATERIA BORNES SOPORTE</th>
            <th>DIRECCION NIVEL ACEITE HIDRAULICO</th>
            <th>DISPOSITIVO LAVABRISAS</th>
            <th>CONEXIONES ELECTRICAS</th>
            <th>PLUMILLAS LIMPIAVIDRIOS</th>
            <th>INDICADORES DE LUCES TABLERO</th>
            <th>INDICADOR DE VELOCIDAD</th>
            <th>INDICADOR DE COMBUSTIBLE</th>
            <th>INDICADOR DE ACEITE DE MOTOR</th>
            <th>PITO</th>
            <th>FRENO DE EMERGENCIA</th>
            <th>PITO DE RESERVA</th>
            <th>BOTIQUIN</th>
            <th>EQUIPO DE CARRETERA</th>
            <th>KILOMETRAJE</th>
            <th>LAVADO DE MANOS</th>
            <th>DESINFECTANTE</th>
            <th>ELEMENTOS DE PROTECCION</th>
            <th>BAYETILLAS</th>
            <th>ESCOBA</th>
            <th>ALISTO TOALLA</th>
            <th>BALDE</th>
            <th>BOLSA</th>
            <th>PRODUCTOS</th>
            <th>TAPETES</th>
            <th>VOLANTE</th>
            <th>ZONA DE PASAJEROS</th>
            <th>ZONA DE CONDUCTOR</th>
            <th>PISO DEL VEHICULO</th>
            <th>ASPERSION</th>
            <th>DISPOSICION</th>
            <th>BODEGA</th>
            <th>HITRADACION</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">

        <?php foreach ($listarP as $lpm){ ?>
            <tr>
                <td>
                    <?php 
                        $listarVerhiculoPorId = $vehiculo->listarPorId($lpm['id_vehiculo']); 
                        echo $listarVerhiculoPorId[0]['placa']; 
                    ?>
                </td>
                        
                <td>
                	<?php 
                		$listarPorId = $conductor->listarPorId($lpm['id_conductor']); echo $listarPorId[0]['nombre_conductor'] ; 
                	?>
                </td>
                <td><?php echo $lpm['fecha_creacion']; ?></td>
                <td><?php echo $lpm['puertas']; ?></td>
                <td><?php echo $lpm['espejos_retrovisores']; ?></td>
                <td><?php echo $lpm['ventanas']; ?></td>
                <td><?php echo $lpm['vidrio_frontal']; ?></td>
                <td><?php echo $lpm['llantas_rines']; ?></td>
                <td><?php echo $lpm['llanta_repuesto']; ?></td>
                <td><?php echo $lpm['luces_delanteras']; ?></td>
                <td><?php echo $lpm['luces_freno']; ?></td>
                <td><?php echo $lpm['luces_reserva']; ?></td>
                <td><?php echo $lpm['luces_parqueo_direccionales']; ?></td>
                <td><?php echo $lpm['sistema_suspension']; ?></td>
                <td><?php echo $lpm['sistema_frenos']; ?></td>
                <td><?php echo $lpm['sistema_direccion']; ?></td>
                <td><?php echo $lpm['tapas']; ?></td>
                <td><?php echo $lpm['niveles_aceite_motor']; ?></td>
                <td><?php echo $lpm['radiador_ventilador_correas']; ?></td>
                <td><?php echo $lpm['mangueras']; ?></td>
                <td><?php echo $lpm['transmision']; ?></td>
                <td><?php echo $lpm['filtro_aire']; ?></td>
                <td><?php echo $lpm['fugas_motor']; ?></td>
                <td><?php echo $lpm['bomba_freno_clutch']; ?></td>
                <td><?php echo $lpm['bateria_bornes_soporte']; ?></td>
                <td><?php echo $lpm['direccion_nivel_aceite_hidraulico']; ?></td>
                <td><?php echo $lpm['depositivo_lavabrisas']; ?></td>
                <td><?php echo $lpm['conexiones_electricas']; ?></td>
                <td><?php echo $lpm['plumillas_limpiavidrios']; ?></td>
                <td><?php echo $lpm['indicadores_luces_tablero']; ?></td>
                <td><?php echo $lpm['indicador_velocidad']; ?></td>
                <td><?php echo $lpm['indicador_combustible']; ?></td>
                <td><?php echo $lpm['indicador_aceite_motor']; ?></td>
                <td><?php echo $lpm['pito']; ?></td>
                <td><?php echo $lpm['freno_emergencia']; ?></td>
                <td><?php echo $lpm['pito_reserva']; ?></td>
                <td><?php echo $lpm['botiquin']; ?></td>
                <td><?php echo $lpm['equipo_carretera']; ?></td>
                <td><?php echo $lpm['kilometraje']; ?></td>
                <td><?php echo $lpm['lavado_manos']; ?></td>
                <td><?php echo $lpm['desinfectante']; ?></td>
                <td><?php echo $lpm['elementos_proteccion']; ?></td>
                <td><?php echo $lpm['bayetillas']; ?></td>
                <td><?php echo $lpm['escoba']; ?></td>
                <td><?php echo $lpm['alisto_toalla']; ?></td>
                <td><?php echo $lpm['balde']; ?></td>
                <td><?php echo $lpm['bolsa']; ?></td>
                <td><?php echo $lpm['productos']; ?></td>
                <td><?php echo $lpm['tapetes']; ?></td>
                <td><?php echo $lpm['volante']; ?></td>
                <td><?php echo $lpm['zona_pasajeros']; ?></td>
                <td><?php echo $lpm['zona_conductor']; ?></td>
                <td><?php echo $lpm['piso_vehiculo']; ?></td>
                <td><?php echo $lpm['aspersion']; ?></td>
                <td><?php echo $lpm['disposicion']; ?></td>
                <td><?php echo $lpm['bodega']; ?></td>
                <td><?php echo $lpm['hidratacion']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

