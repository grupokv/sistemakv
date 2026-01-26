<?php 
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/EmpresaEnt.php");

$vehiculo = new vehiculo();
$listarV = $vehiculo->listar();

$empresa = new Empresa();

$usuario = new Usuario();

include("Template/styles.php"); 

?>

<table class="table">
	<caption>Documentación Vencida</caption>
	<thead>
		<tr>
			<th>PLACA</th>
			<th>N° MOVIL</th>
			<th>FECHA VENCIMIENTO TO</th>
			<th>FLOTA PROPIA</th>
			<th>EMPRESA</th>
			<th>ESTADO</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listarV as $lv){ ?>
			<tr>
				<td><?php echo $lv['placa'] ?></td>
				<td><?php echo $lv['numero_movil'] ?></td>
				<td><?php echo $lv['fecha_vencimiento_to'] ?></td>
				<td><?php if($lv['flota_propia'] == 'S'){ echo "SI"; }else{ echo "NO";} ?></td>
				<td>
					<?php 
						if($lv['numero_movil'] == 0){ 
							echo 'CONVENIO'; 
                        } else if (($lv['numero_movil'] >= 1)&&($lv['numero_movil'] <= 999)){ 
                        	echo 'ORT'; 
                        } else if (($lv['numero_movil'] >= 1000)&&($lv['numero_movil'] <= 1999)){ 
                        	echo 'LINEAS PREMIUM';
                        } 
					?>
				</td>
				<td><?php if($lv['estado'] == 0) { echo "INACTIVO"; }else{ echo "ACTIVO";} ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>


<?php include("Template/scripts.php"); ?>