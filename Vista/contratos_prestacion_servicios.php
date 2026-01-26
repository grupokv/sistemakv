<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vinculacion.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");


$cliente = new Cliente();
$empresa = new Empresa();
$contrato = new Contrato();
$usuario = new Usuario();
$vinculacion = new Vinculacion();


$listarContratos = $vinculacion->listarContratos();

?>

<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <title>SistemaKV | Contratos</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <!--fin  styles -->
  
  <style type="text/css">

        .barra-principal{
          background-color: #5e99b1;
          width: auto;
        }
    
        .botones_principal{
          display: flex;
          justify-content: flex-end;
        }
        
        @media (max-width: 760px){
      
            .fa-plus{
               display: none;
            }
    
            .titulo_principal{
              text-align: center;
            }
    
            .botones_principal{
              display: flex;
              justify-content: center;
            }
            
        }

    
    </style>
    
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
            <li class="breadcrumb-item active" aria-current="page">Contratos de Prestación de Servicios </li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">
      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
      		  <h2 class="mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-book icono-principal ml-2" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Contratos de Prestación de Servicios </h2>
      	</div>
      	
      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 botones_principal">
            <!--<a href="renovarContratos.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Renovar contrato</a>-->
            <a href="registrarContratosVinculaciones.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Registrar Contrato <span class="fa fa-plus"></span></a>
        </div>
        
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr class="text-center">
                    <th>CONTRATO N°</th>
                    <th>CONTRATISTA</th>
    				<th>CONTRATANTE</th>
                    <th>TIPO CONTRATO</th>
                    <th>EMISOR</th>
                    <th>ESTADO</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php foreach($listarContratos As $lc){ ?>
    			    <tr class="text-center">
                        <td><?php echo $lc['numero_contrato']; ?></td>
                        <td><?php $listarPorId = $empresa->listarPorId($lc['id_empresa']); echo $listarPorId[0]['nombre_empresa']; ?></td>
                        <td><?php $listarClientePorId = $cliente->cliente_ID($lc['id_cliente']); echo $listarClientePorId[0]['razon_social']; ?></td>
                        <td><?php $listarTipoContrato = $contrato->listarTiposContratosId($lc['id_tipo_contrato']);  echo strtoupper(utf8_encode($listarTipoContrato[0]['tipo_contrato'])); ?></td>
                        <td><?php $listarUId = $usuario->listarUsuarioPorId($lc['creador']); echo $listarUId[0]['nombre']; ?></td>
                        <td><?php if($lc['fecha_final'] < $hoy){ echo "VENCIDO"; }else { echo "ACTIVO"; } ?></td>
        				<td>
        				    <a href="../Documentos/Vinculaciones/Contratos/<?php echo $lc['fotocopia_contrato'] ?>" target="_blank" class="btn btn-outline-info" data-toggle="tooltip" data-placement="button" title="editar area"   style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-book"></span></a>
        				</td>
        			</tr>
    			<?php } ?>
    		</tbody>
    	</table>
    </div>


    <!-- script -->
    <?php include("Template/scripts.php"); ?>




</body>
</html>