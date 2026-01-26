<?php
$hoy = date('Ymd_His');
$filename = $hoy.'_reporte_ocasionales.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

include ("../Controlador/Sesion/autenticar.php");
require_once ('../Modelo/Vehiculo.php');require_once ('../Modelo/TipoVehiculo.php');
require_once ('../Modelo/contratoOcasional.php');
require_once("../Modelo/Cliente.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Fuec.php");
require_once("../Modelo/Usuario.php");

$vehiculo = new Vehiculo();$tipo_vehiculo = new TipoVehiculo();
$contratoOcasional = new ContratoOcasional();
$cliente = new Cliente();
$empresa = new Empresa();
$fuec = new Fuec();
$usuario = new Usuario();

    $id_usuario_emisor = $_POST['id_usuario_emisor'];
    $id_contrato = $_POST['id_contrato'];
    $id_vehiculo = $_POST['id_vehiculo'];
    $fecha_inicial = $_POST['fecha_inicial'];
    $fecha_final = $_POST['fecha_final'];

$filtrarFuecsOcasionales = $fuec->filtrarFuecsOcasionales($id_usuario_emisor, $id_contrato, $id_vehiculo, $fecha_inicial, $fecha_final);
?>

<table  id="dataT" class="table table-hover text-center table-sm display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th colspan="8" style="text-align:center">TOTAL EXTRACTOS: <?php echo count($filtrarFuecsOcasionales); ?> </th>
                                    </tr>
                                    <tr>
                                        <th style="width: 10px;">ID</th>
                                        <th>VEHICULO</th>					<th>TIPO VEHICULO</th>
                                        <th>CONTRATO OCASIONAL</th>
                                        <th>ORIGEN - DESTINO</th>
					<th>FECHA INICIAL</th>
					<th>FECHA FINAL</th>
                                        <th>FECHA CREACIÓN</th>
                                        <th>EMISOR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($filtrarFuecsOcasionales as $lffo){ ?>
                                        <tr>
                                            <td><?php echo $lffo['id_fuec']; ?></td>
                                            <td>
                                                <?php 
                                                    $listarVehiculosId = $vehiculo->listarPorId($lffo['id_vehiculo']);
                                                    foreach ($listarVehiculosId as $lvi) {
                                                        echo $lvi['placa'] . ' - ' . $lvi['numero_movil'];
                                                    }
                                                ?>
                                            </td>					    <td>	                				<?php 				$listarTipoVehiculosId = $tipo_vehiculo->listarPorId($listarVehiculosId[0]['id_tipo_vehiculo']);	                                echo $listarTipoVehiculosId[0]['nombre_tipo_vehiculo'];	                				?>	            					    </td>
                                            <td>
                                                <?php 
                                                $listarContratosOcasionalesId = $contratoOcasional->listarPorId($lffo['id_contrato_ocasional']);
                                                    foreach ($listarContratosOcasionalesId as $lci) {
                                                        $emp = $empresa->listarPorId($lci['id_empresa']);
                                                        $cli = $cliente->listarClientePorId($lci['id_cliente']);
                                                        echo "No. interno ". $lci['id_contrato_ocasional'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa']; 
                                                    }
                                                

                                                ?>
                                            </td>
                                            <td><?php echo 'DE ' . $lffo['origen'] . ' A ' . $lffo['destino']; ?></td>
					    <td><?php echo $lffo['fecha_inicial_fuec']; ?></td>
					    <td><?php echo $lffo['fecha_final_fuec']; ?></td>
                                            <td><?php echo date('Y-m-d g:i a', strtotime($lffo['fecha_creacion'])); ?></td>
                                            <td>
                                                <?php  
                                                    $listarUsuariosEmi = $usuario->listarUsuarioPorId($lffo['id_usuario']);
                                                    foreach ($listarUsuariosEmi as $luef) {
                                                        echo $luef['nombre'];
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                        </table>
