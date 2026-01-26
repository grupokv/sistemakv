<?php 
include("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Fuec.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/EmpresaEnt.php");
require_once ("../Modelo/Usuario.php");

$fuec = new Fuec();
$usuario = new Usuario();
$vehiculo = new Vehiculo();
$cliente = new Cliente();
$empresa = new Empresa();
$contrato = new Contrato();

$listarTodosVehiculos = $vehiculo->listarActivos();
$listarTodosContratos = $contrato->listarTodos();
$usuariosPermisosFuecs = $usuario->usuariosPermisosFuecs();

$hoy = date('Y-m-d');
$fecha_proxima_venc = date("Y-m-d", strtotime($hoy . "+ 3 days" ));

if($_POST){

    $id_usuario = '%%';
    if($_POST['id_usuario'] != 0){
        $id_usuario = $_POST['id_usuario'];
    }

    $id_contrato = '%%';
    if($_POST['id_contrato'] != 0){
        $id_contrato = $_POST['id_contrato'];
    }

    $id_vehiculo = '%%';
    if($_POST['id_vehiculo'] != 0){
        $id_vehiculo = $_POST['id_vehiculo'];
    }

} else {
    $hoy = date('Y-m-d');
    $fecha_proxima_venc = date("Y-m-d", strtotime($hoy . "+ 3 days" ));
    $id_usuario = '%%';
    $id_contrato = '%%';
    $id_vehiculo = '%%';
}

if($_POST){
    $listarExtractosVencidos = $fuec->listarExtractosVencidos($fecha_proxima_venc, $id_usuario, $id_contrato, $id_vehiculo);
}else{
    $listarExtractosVencidos = array();
}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Extractos Vencidos </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <!--fin  styles -->

</head>
<body>
    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Extractos Vencidos</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-file-text-o" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Extractos Vencidos</h2>
    	</div>
    </div>
    <hr style="background-color:#5e99b1;">
    
    <!-- FILTRO REPORTE -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 ml-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 96%">
            <p>FILTRAR REPORTE</p>
        </div>
        
        <div class="col-lg-12 ml-4" style="height: auto; width: 96%; border-radius: 4px; background-color: #fafafa; ">
            
            <form method="POST" action="">
                <!-- EMISOR-->
                <section class="row">
                    <div class="col-4">
                        <label><strong>EMISOR</strong></label>
                        <select class="form-control selectpicker " data-live-search="true" name="id_usuario">
                            <option value="0">SELECCIONAR</option>
                            <?php foreach($usuariosPermisosFuecs As $upf){ ?>
                                <option value="<?php echo $upf['id_usuario']; ?>"> <?php echo $upf['nombre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-4">
                        <label><strong>CONTRATO</strong></label>
                        <select class="form-control selectpicker" data-live-search="true" name="id_contrato">
                            <option value="0">SELECCIONAR</option>
                            <?php foreach ($listarTodosContratos as $ltc){ ?>
	                            <option value="<?php echo $ltc['id_contrato']; ?>">
	                            	<?php
			                            $emp = $empresa->listarPorId($ltc['id_empresa']);
			                            $cli = $cliente->listarClientePorId($ltc['id_cliente']);
			                            echo "No. interno ".$ltc['id_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa']; 
			                        ?>
	                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-4">
                        <label><strong>VEHICULO</strong></label>
                        <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo">
                            <option value="0">SELECCIONAR</strong></option>
                            <?php foreach ($listarTodosVehiculos as $ltv){ ?>
								<option value="<?php echo $ltv['id_vehiculo'] ?>">
								    <?php echo $ltv['placa'] . ' - ' . $ltv['numero_movil']; ?>
								</option>
							<?php } ?>
                        </select>
                    </div>
                    
                </section>   
               
                <div class="row mt-2 d-flex justify-content-center">
                    <div class="col-4">
                        <label>&nbsp;</label>
                        <button type="submit" name="consultar" class="btn btn-block" style="background-color: #1b2d3b; color: #fff;">Filtrar</button>
			
                    </div>
                </div>
                
            </form>
        </div>
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 ml-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; height: 3px; width: 96%;"></div>
      
    <!-- °°°°°°°°°°°°°°°°° --> 
    
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr class="text-center">
    				<th>ID</th>
                    <th>NUM INTERNO</th>
                    <th>COMPROBANTE</th>
                    <th>FECHA INICIAL</th>
                    <th>FECHA FINAL</th>
    				<th>VEHICULO</th>
                    <th>CONTRATO</th>
                    <th>EMISOR</th>
                    <th>ESTADO</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php foreach ($listarExtractosVencidos as $lev){ ?>
    				<tr class="text-center">
    					<td><?php echo $lev['id_fuec'] ?></td>
                        <td><?php echo $lev['num_interno'] ?></td>
                        <td><?php echo $lev['num_comprobante'] ?></td>
                        <td><?php echo $lev['fecha_inicial_fuec']?></td>
                        <td><?php echo $lev['fecha_final_fuec'] ?></td>
                        <td><?php 
                            if($lev['id_vehiculo'] == '0'){
                                echo 'N/A';
                            } else {
                                $placa = $vehiculo->listarPorId($lev['id_vehiculo']);
                                echo $placa[0]['placa'];
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if($lev['id_contrato'] == '0'){
                                    echo 'N/A';
                                } else {
                                    $ListContratos = $contrato->listarId($lev['id_contrato']);
                                    $emp = $empresa->listarPorId($ListContratos[0]['id_empresa']);
                                    $cli = $cliente->listarClientePorId($ListContratos[0]['id_cliente']);
                                    echo "No. interno ". $ListContratos['id_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa']; 
                                    echo $numero[0]['id_contrato'];
                                }
                            ?>       
                        </td>
                        <td>
                            <?php 
                                $usuarioPorId = $usuario->listarUsuarioPorId($lev['id_usuario']);
                                echo $usuarioPorId[0]['nombre'];
                                
                            ?>
                        </td>
    					<td>
    					    <?php
    					        if ($lev['fecha_final_fuec'] <= $hoy) { 
                                        echo "VENCIDO";
                                }else if ($lev['fecha_final_fuec'] >= $hoy && $lev['fecha_final_fuec'] <= $fecha_proxima_venc) { 
                                        echo "PROXIMO A VENCER";
                                }
                            ?>
                        </td>
    				</tr>
    			<?php } ?>
    		</tbody>
    	</table>
    </div>
    
    
    <!-- FIN CONTENIDO -->

    <!-- script -->
    <?php include("Template/scripts.php"); ?>
    
    <script type="text/javascript">
		$( function() {
            $( "#datepicker" ).datepicker({ dateFormat:'yy/mm/dd'});
            $( "#datepicker2" ).datepicker({ dateFormat:'yy/mm/dd'});
            
        } );
    </script>


</body>
</html>