<?php
$hoy = date('Ymd_His');
$filename = $hoy.'_reporte_contratos_fijos.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

include ("../Controlador/Sesion/autenticar.php");
require_once ('../Modelo/Contrato.php');
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/EmpresaEnt.php");

$contrato = new Contrato();
$cliente = new Cliente();
$empresa = new Empresa();
$usuario = new Usuario();
$ciudad = new Ciudad();

$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];

$listado = $contrato->filtrarRangoFechas($fecha_inicial, $fecha_final);
?>

<table  id="dataT" class="table table-hover text-center table-sm display" style="width:100%">
    <thead>
        <tr>
            <th colspan="15" style="text-align:center">TOTAL CONTRATOS: <?php echo count($listado); ?> </th>
        </tr>
        <tr>
            <th>NUM INTERNO</th>
            <th>NUMERO CONTRATO</th>					
            <th>TIPO CONTRATO</th>
            <th>EMPRESA</th>
            <th>CLIENTE</th>
            <th>FECHA INICIAL</th>
            <th>FECHA FINAL</th>
            <th>FECHA CREACION</th>
            <th>CIUDAD</th>
            <th>RESPONSABLE INTERNO</th>
            <th>DOC CONTRATO</th>
            <th>NOMBRE CONTACTO</th>
            <th>NUM DOC CONTACTO</th>
            <th>DIRECCION CONTACTO</th>
            <th>TELEFONO CONTACTO</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listado as $ls){ ?>
            <tr>
                <td><?php echo $ls['id_contrato']; ?></td>
                <td><?php echo $ls['numero_contrato']; ?></td>
                <td><?php $det_tipo_contrato = $contrato->listarTiposContratosId($ls['id_tipo_contrato']); echo utf8_decode($det_tipo_contrato[0]['tipo_contrato']);?></td>					    
                <td><?php echo utf8_decode($ls['nombre_empresa']); ?></td>
                <td><?php echo utf8_decode($ls['razon_social']); ?></td>
                <td><?php echo $ls['fecha_inicial_contrato']; ?></td>
                <td><?php echo $ls['fecha_final_contrato']; ?></td>
                <td><?php echo $ls['fecha_creacion_contrato']." ".$ls['hora_creacion_contrato']; ?></td>
                <td><?php $det_ciudad = $ciudad->listarCiudadPorId($ls['id_ciudad']); echo utf8_decode($det_ciudad[0]['ciudad']);?></td>
                <td><?php $det_usuario = $usuario->listarUsuarioPorId($ls['id_responsable']); echo utf8_decode($det_usuario[0]['nombre']);?></td>
                <td>
                <?php if($ls['doc_fotocopia_contrato'] != ''){ ?>
                <a href="http://www.sistemakv.com/Documentos/Contratos/<?php echo $ls['doc_fotocopia_contrato'];?>" target="_blank"><?php echo $ls['doc_fotocopia_contrato'];?></a>
                <?php } ?>
                </td>
                <td><?php echo utf8_decode($ls['nombre_responsable']); ?></td>
                <td><?php echo $ls['numero_documento_responsable']; ?></td>
                <td><?php echo utf8_decode($ls['direccion_responsable']); ?></td>
                <td><?php echo $ls['telefono_responsable']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>