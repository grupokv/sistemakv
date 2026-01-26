<?php 	

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte-Extractos.xls');

require_once ('../Modelo/Vehiculo.php');require_once ('../Modelo/TipoVehiculo.php');
require_once ('../Modelo/Contrato.php');
require_once("../Modelo/Cliente.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Fuec.php");
require_once("../Modelo/Usuario.php");

$vehiculo = new Vehiculo();$tipo_vehiculo = new TipoVehiculo();
$contrato = new Contrato();
$cliente = new Cliente();
$empresa = new Empresa();
$fuec = new Fuec();
$usuario = new Usuario();

$listarTodosContratos = $contrato->listarTodos();
$listarTodosVehiculos = $vehiculo->listarActivos();
$listarTodosClientes = $cliente->listar();
$listarEmisoresFuec = $fuec->listarEmisoresFuec();

$id_usuario_emisor = '%%';
if($_POST['id_usuario_emisor'] != 0){
    $id_usuario_emisor = $_POST['id_usuario_emisor'];
}

$id_contrato = '%%';
if($_POST['id_contrato'] != 0){
    $id_contrato = $_POST['id_contrato'];
}

$id_vehiculo = '%%';
if($_POST['id_vehiculo'] != 0){
    $id_vehiculo = $_POST['id_vehiculo'];
}
    

$fecha_inicial = '0000-00-00';
if($_POST['fecha_inicial'] != ''){
    $fecha_inicial = $_POST['fecha_inicial'];
}


$fecha_final = '9999-12-31';
if($_POST['fecha_final'] != ''){
    $fecha_final = $_POST['fecha_final'];
}
  


$filtrarFuecs = $fuec->filtrarFuecs($id_usuario_emisor, $id_contrato, $id_vehiculo, $fecha_inicial, $fecha_final);
//print_r($filtrarFuecs);

$total = count($filtrarFuecs);


?>

<style type="text/css" media="screen">

</style>

<table style="width:100%">
    <thead>
        <tr>
            <th colspan="8" style="text-align:center">TOTAL EXTRACTOS: <?php echo $total; ?> </th>
        </tr>
        <tr style="text-align:center;">
            <th>ID</th>
            <th>VEHICULO</th>
            <th><?php echo utf8_decode("N° MOVIL"); ?></th>	    <th>TIPO VEHICULO</th>
            <th>CONTRATO</th>
            <th>TIPO EXTRACTO</th>
            <th>CON</th>
            <th>ORIGEN - DESTINO</th>
            <th>FECHA INICIAL FUEC</th>
            <th>FECHA FINAL FUEC</th>
            <th><?php echo utf8_decode("FECHA CREACIÓN"); ?></th>
            <th>EMISOR</th>
            <!-- <th>DOC FUEC</th> -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filtrarFuecs as $lff){ ?>
	        <tr style="text-align:center;">
	            <td><?php echo $lff['id_fuec']; ?></td>
	            <td>
	                <?php 
	                    $listarVehiculosId = $vehiculo->listarPorId($lff['id_vehiculo']);
	                    echo $listarVehiculosId[0]['placa'];
	                ?>
	            </td>
	            <td>
	                <?php                                         		
	                    echo $listarVehiculosId[0]['numero_movil'];
	                ?>
	            </td>		    
	            <td>	                
	            	<?php 	                    

	            		$listarTipoVehiculosId = $tipo_vehiculo->listarPorId($listarVehiculosId[0]['id_tipo_vehiculo']);	                                        			                       
	            		echo $listarTipoVehiculosId[0]['nombre_tipo_vehiculo'];	                
	            	?>	            
	           	</td>
	            <td>
	                <?php 
	                $listarContratosId = $contrato->listarId($lff['id_contrato']);
	                    foreach ($listarContratosId as $lci) {
	                        $emp = $empresa->listarPorId($lci['id_empresa']);
							$cli = $cliente->listarClientePorId($lci['id_cliente']);
							echo "No. interno ".$lci['id_contrato'] . " Entre " . utf8_decode($cli[0]['razon_social']) . " y " . utf8_decode($emp[0]['nombre_empresa']);
	                    }
	                                        	

	                ?>
	            </td>
	            <td><?php echo utf8_decode($lff['tipo_fuec']); ?></td>
	            <td><?php echo utf8_decode($lff['con_fuec']); ?></td>
	            <td><?php echo 'DE ' . utf8_decode($lff['origen']) . ' A ' . utf8_decode($lff['destino']); ?></td>
	            <td><?php echo $lff['fecha_inicial_fuec']; ?></td>
	            <td><?php echo $lff['fecha_final_fuec']; ?></td>
	            <td><?php echo date('Y-m-d g:i a', strtotime($lff['fecha_creacion'])); ?></td>
	            <td>
	                <?php  
	                    $listarUsuariosEmi = $usuario->listarUsuarioPorId($lff['id_usuario']);
	                    foreach ($listarUsuariosEmi as $luef) {
	                        echo $luef['nombre'];
	                    }
	                ?>
	            </td>
	            <!-- <td>
	            	<?php $cod = base64_encode($lff['id_fuec']); ?>

                    <a href="http://www.sistemakv.com/Vista/formato_fuec.php?id=<?php echo $cod; ?>" target="_blank" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
                         Fuec
                    </a>

	            </td> -->
	        </tr>
        <?php } ?>
    </tbody>
</table>