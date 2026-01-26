<?php 
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte-Cartera.xls');

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/General.php';
require_once '../Modelo/Usuario.php';

$usuario = new Usuario();

$capacidad = $_POST['capacidad_do'];
$tipo_vehiculo = $_POST['tipo_vehiculo_do'];
$modelo = $_POST['modelo_do'];
$departamento = $_POST['departamento_do'];
$ciudad = $_POST['ciudad_do'];

if ($_POST) {

    if($capacidad != ''){
        $capacidad = $capacidad;
    }else{
        $capacidad = '%%';
    }

    if($tipo_vehiculo != '0'){
        $tipo_vehiculo = $tipo_vehiculo;
    }else{
        $tipo_vehiculo = '%%';
    }

    if($modelo != ''){
        $modelo = $modelo;
    }else{
        $modelo = '%%';
    }

    if($departamento != ''){
        $departamento = $departamento;
    }else{
        $departamento = '%%';
    }

    if($ciudad != ''){
        $ciudad = $ciudad;
    }else{
        $ciudad = '%%';
    }

}else{
    $capacidad = '%%';
    $tipo_vehiculo = '%%';
    $modelo = '%%';
    $departamento = '%%';
    $ciudad = '%%';
}

$filtrarReporteDataOperativa = filtroDataOperativa($capacidad, $tipo_vehiculo, $modelo, $departamento, $ciudad);


?>


<table border="1">
    <thead>
        <tr>
            <th>DEPARTAMENTO</th>
            <th>CIUDAD</th>
            <th>NOMBRE Y APELLIDO</th>
            <th>TELEFONO CELULAR</th>
            <th>TELEFONO FIJO</th>
            <th>CORREO ELECTRONICO</th>
            <th>PROPIETARIO</th>
            <th>TIPO VEHICULO</th>
            <th>OTRO</th>
            <th>MODELO</th>
            <th>CAPACIDAD</th>
            <th>OBSERVACIONES</th>
            <th>REFERENCIADO POR</th>
            <th>FECHA DE REGISTRO</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        <?php foreach ($filtrarReporteDataOperativa as $frdo){ ?>
            <tr>
                <td><?php echo strtoupper($frdo['departamento']); ?></td>
                <td><?php echo strtoupper($frdo['ciudad']); ?></td>
                <td><?php echo strtoupper($frdo['nombres_apellidos']); ?></td>
                <td><?php echo $frdo['telefono_celular']; ?></td>
                <td><?php echo $frdo['telefono_fijo']; ?></td>
                <td><?php echo strtoupper($frdo['correo_electronico']); ?></td>
                <td><?php echo $frdo['propietario']; ?></td>
                <td><?php echo strtoupper($frdo['tipo_vehiculo']); ?></td>
                <td><?php echo strtoupper($frdo['otro']); ?></td>
                <td><?php echo $frdo['modelo']; ?></td>
                <td><?php echo $frdo['capacidad']; ?></td>
                <td><?php echo strtoupper($frdo['observaciones']); ?></td>
                <td>
                    <?php 
                        $listarUsuId = $usuario->listarUsuarioPorId($frdo['id_referenciador']);
                        echo $listarUsuId[0]['nombre']; 
                    ?>
                </td>
                <td><?php echo $frdo['fecha_registro']; ?></td>
                
            </tr>
        <?php } ?>
    </tbody>
</table>