<?php  

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte-ProgramacionServicios.xls');

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/Conductor.php");
require_once ("../Modelo/Usuario.php");

$programacion = new Programacion();
$vehiculo = new Vehiculo();
$conductor = new Conductor();
$usuario = new Usuario();

if ($_POST) {
    if ($_POST['fecha_inicialReport'] != '') {
        $fecha_inicial = $_POST['fecha_inicialReport'];
    }else{
        $fecha_inicial = "0000-00-00";
    }

    if ($_POST['fecha_finalReport'] != '') {
        $fecha_final = $_POST['fecha_finalReport'];
    }else{
        $fecha_final = "9999-99-99";
    }

    if ($_POST['proyectoReport'] != '') {
        $proyecto = $_POST['proyectoReport'];
    }else{
        $proyecto = "%%";
    }

    if ($_POST['unOperativaReport'] != '') {
        $unidad_operativa = $_POST['unOperativaReport'];
    }else{
        $unidad_operativa = "%%";
    }

    $listar_programaciones = $programacion->listarFiltroServicioProgramaciones($fecha_inicial, $fecha_final, $proyecto, $unidad_operativa);
}

?>

<table style="width:100%;">
    <thead>
        <tr class="text-center">
            <th style="vertical-align: top;">ID</th>
            <th style="vertical-align: top;">CODIGO</th>
            <th style="vertical-align: top;">FECHA</th>
            <th style="vertical-align: top;">PROYECTO</th>
            <th style="vertical-align: top;">UN. OPERATIVA</th>
            <th style="vertical-align: top;">LOCALIDAD</th>
            <th style="vertical-align: top;">E/S</th>
            <th style="vertical-align: top;">PUNTO INICIO</th>
            <th style="vertical-align: top;">PUNTO FINAL</th>
            <th style="vertical-align: top;">HORA</th>
            <th style="vertical-align: top;">FRECUENCIA</th>
            <th style="vertical-align: top;">OBSERVACIONES</th>
            <th style="vertical-align: top;">CAPACIDAD</th>
            <th style="vertical-align: top;">MONITORA</th>
            <th style="vertical-align: top;">CONTACTO MONITORA</th>
            <th style="vertical-align: top;">NOVEDADES</th>
            <th style="vertical-align: top;">PLACA FACT</th>
            <th style="vertical-align: top;">PLACA LIQ</th>
            <th style="vertical-align: top;">CAPACIDAD VEHICULO</th>
            <th style="vertical-align: top;">PROPIETARIO</th>
            <th style="vertical-align: top;">CONDUCTOR</th>
            <th style="vertical-align: top;">CONTACTO CONDUCTOR</th>
            <th style="vertical-align: top;">VALOR PAGAR VEHICULO</th>
            <th style="vertical-align: top;">VALOR PAGAR MONITORA</th>
            <th style="vertical-align: top;">VALOR FACTURAR</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listar_programaciones as $lps){ ?>
            
            <tr class="text-center">
                <td><strong><?php echo $lps['id_programacion']; ?></strong></td>
                <td><strong><?php echo $lps['codigo_identificativo']; ?></strong></td>
                <td><strong><?php echo $lps['fecha']; ?></strong></td>
                <td><?php echo $lps['proyecto']; ?></td>
               <td><?php $listarUnidadOperativaId = $programacion->listarUnidadOperativaId($lps['unidad_operativa']); echo $listarUnidadOperativaId[0]['unidad_operativa']; ?></td>
                <td><?php echo $lps['localidad']; ?></td>
                <td><b><?php echo $lps['entrada_salida']; ?></b></td>
                <td><?php echo strtoupper($lps['punto_inicio']); ?></td>
                <td><?php echo strtoupper($lps['punto_final']); ?></td>
                <td>
                    <?php 
                        echo strtoupper(date('g:i a', strtotime($lps['horario']))); 
                    ?>       
                </td>
                <td><?php echo $lps['frecuencia']; ?></td>
                <td><?php echo $lps['observaciones']; ?></td>
                <td><?php echo $lps['capacidad_servicio']; ?></td>
                <td><?php echo strtoupper($lps['nombre_monitora']); ?></td>
                <td><?php echo $lps['telefono_monitora']; ?></td>
                <td><?php echo $lps['novedades']; ?></td>
                <td>
                    <?php 

                        if ($lps['id_vehiculo_facturacion'] != 0){
                                $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_facturacion']);
                                echo $listarVehiculoID[0]['placa']; 
                        }
                    ?>
                    
                </td>
                <td>
                    <?php 
                        $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_liquidacion']);
                        echo $listarVehiculoID[0]['placa']; 
                    ?>
                </td>
                <td>
                    <?php 
                        $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_liquidacion']);
                        echo $listarVehiculoID[0]['cant_pasajeros']; 
                    ?>
                </td>
                <td>
                    <?php 
                        $listarVehiculoID = $vehiculo->listarPorId($lps['id_vehiculo_liquidacion']);
                        $listarUsuarioPorId = $usuario->listarUsuarioPorId($listarVehiculoID[0]['id_propietario']);
                        echo $listarUsuarioPorId[0]['nombre']; 
                    ?>
                </td>
                <td>
                    <?php 
                        $listarConductorID = $conductor->listarPorId($lps['id_conductor']);
                        echo $listarConductorID[0]['nombre_conductor']; 
                    ?>
                </td>
                <td>
                    <?php 
                        $listarConductorID = $conductor->listarPorId($lps['id_conductor']);
                        echo $listarConductorID[0]['telefono1']; 
                    ?>
                </td>
                <td><?php echo "<b>$</b> " . number_format($lps['valor_pagar']); ?></td>
                <td><?php echo "<b>$</b> " . number_format($lps['valor_pagar_monitora']); ?></td>
                <td><?php echo "<b>$</b> " . number_format($lps['valor_facturar']); ?></td>
            
                    
            </tr>

        <?php } ?>
    </tbody>
</table>