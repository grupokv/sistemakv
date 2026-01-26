<?php 
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Contrato.php';
require_once '../Modelo/EmpresaEnt.php';
require_once '../Modelo/Cliente.php';

$hoy = date('Y-m-d');

$fechaMasDiezDias = strtotime('+ 10 Days',strtotime(date('Y-m-d')));
$fechaRangoVencimiento = date('Y-m-d',$fechaMasDiezDias);


$contrato = new Contrato();
$listarContratosVencidos = $contrato->listarContratosVencidos($hoy);

$listarContratosProximosVencer = $contrato->listarContratosProximosVencer($hoy, $fechaRangoVencimiento);

$cliente = new Cliente();


$empresa = new Empresa();

 ?>
 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Consultar Contratos Vencidos</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
  <?php include("Template/styles.php") ?>
  <style type="text/css">
     @media (max-width: 760px){

        .icono-principal{
          display: none;
        }

        .titulo-principal{
            font-size: 1.6rem;
            text-align: center;
        }

     }
  </style>
</head>
<body>

    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--***************************-->
  
    <!-- CONTENIDO -->

    <div aria-label="breadcrumb" class="mt-1"> 
      <ol class="breadcrumb">
          <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
          <li class="breadcrumb-item active" aria-current="page">Contratos Vencidos</li>
      </ol>
    </div>

    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
      <div class="col">
        <h2 class="ml-4 mt-2 titulo-principal" style="color: #fff; "><span class="fa fa-file-text-o icono-principal" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Contratos Vencidos y Proximos a vencer</h2>
      </div>
    </div>
    <hr style="background-color:#5e99b1; ">

      <div class="col-12 mt-2 p-4 table-responsive">  
        <table id="dataT" class="table table-hover table-sm display" style="width:100%">
          <form method="POST"> 
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>CLIENTE</th>               
                    <th>EMPRESA</th>
                    <th>FECHA VENCIMIENTO</th>
                    <th>TIPO CONTRATO</th>
                    <th>ESTADO</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody>

              <!-- Contratos Vencidos -->
              <?php foreach ($listarContratosVencidos as $lcv){ ?>
                  <tr class="text-center">
                      <td><?php echo $lcv['id_contrato']; ?></td>
                      <td><?php $listarClientePorContrato = $cliente->listarClientePorId($lcv['id_cliente']); echo $listarClientePorContrato[0]['razon_social']; ?></td>
                      <td><?php $listarEmpresaPorContrato = $empresa->listarPorId($lcv['id_empresa']); echo $listarEmpresaPorContrato[0]['nombre_empresa']; ?></td>
                      <td><?php echo $lcv['fecha_final_contrato']; ?></td>
                      <td><?php $listarTipoContrato = $contrato->listarTiposContratosId($lcv['id_tipo_contrato']);  echo utf8_encode($listarTipoContrato[0]['tipo_contrato']); ?></td>
                      <td><?php if($lcv['fecha_final_contrato'] <= $hoy){ echo "Vencido"; } ?></td>
                      <td>
							<?php if($_SESSION['perfil'] == 1){ ?>
                          <a href="renovarContratoPorId.php?id_contrato=<?php echo $lcv['id_contrato']; ?>" data-placement="button" title="Renovar Contrato"  class="btn btn-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-refresh"></span></a>
							<?php } ?>
							<?php if($lcv['doc_fotocopia_contrato'] != ''){ ?>
                          <a href="../Documentos/Contratos/<?php echo $lcv['doc_fotocopia_contrato'] ?>" target="_blank" class="btn btn-success" data-placement="button" title="Ver Contrato" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-search"></span></a>
							<?php } ?>
                      </td>
                  </tr>
              <?php } ?>
              
              <!-- Contratos Proximos a Vencer-->
              
              <?php foreach ($listarContratosProximosVencer as $lcpv){ ?>
                  <tr  class="text-center">
                      <td><?php echo $lcpv['id_contrato']; ?></td>
                      <td><?php $listarClientePorContrato = $cliente->listarClientePorId($lcpv['id_cliente']); echo $listarClientePorContrato[0]['razon_social']; ?></td>
                      <td><?php $listarEmpresaPorContrato = $empresa->listarPorId($lcpv['id_empresa']); echo $listarEmpresaPorContrato[0]['nombre_empresa']; ?></td>
                      <td><?php echo $lcpv['fecha_final_contrato']; ?></td>
                      <td><?php $listarTipoContrato = $contrato->listarTiposContratosId($lcv['id_tipo_contrato']);  echo utf8_encode($listarTipoContrato[0]['tipo_contrato']); ?></td>
                      <td><?php if(($lcpv['fecha_final_contrato'] > $hoy) && ($lcpv['fecha_final_contrato'] < $fechaRangoVencimiento)){ echo "Proximo a Vencer"; } ?></td>
                      <td>
                          <a href="renovarContratoPorId.php?id_contrato=<?php echo $lcpv['id_contrato']; ?>" data-placement="button" title="Renovar Contrato"  class="btn btn-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-refresh"></span></a>

                          <a href="" class="btn btn-success" data-placement="button" title="Ver Contrato" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-search"></span></a>
                      </td>
                  </tr>
              <?php } ?>


            </tbody>
          </form>
        </table>
      </div> 
    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php"); ?>
</body>
</html>