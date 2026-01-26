<?php 
//include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/InspeccionVehicular.php';
require_once '../Modelo/Usuario.php';

$inspeccion = new InspeccionVehicular();
$usuario = new Usuario();

$hoy = date('Y-m-d');
if($_POST){
    $fecha_inicial = $_POST['fecha_inicial'];
    $fecha_final = $_POST['fecha_final'];
} else {
    $fecha_inicial = $hoy;
    $fecha_final = $hoy;
}

$listado = $inspeccion->listarPorRangoFechas($fecha_inicial,$fecha_final);

?>
 
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <title>SistemaKV | Reporte Inspeccion Vehicular</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
  <!--fin  styles -->

</head>
<body>
    <!--MENU-->
       <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="inspeccionVehicular.php">Inspeccion Vehicular</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte Inspeccion</li>
         </ol>
    </div>
     <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4" style="color: #fff; line-height: 52px;"><span class="fa fa-clipboard" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Reporte de Inspecciones</h2>
    	</div>
    </div>
    <hr style="background-color:#5e99b1;">
    
      <!-- FILTRO REPORTE -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 titulo_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%">
            <p>FILTRAR REPORTE</p>
        </div>

        <div class="col-sm-12 col-md-12 mt-3 formulario_reporte" style="height: auto; width: 100%; border-radius: 4px; background-color: #fafafa; ">
            
            <form method="POST" action="">
                
                <div class="row mt-2">
                    
                    
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 formulario">
                        <label>Fecha Inicial</label>
                        <input type="date" class="form-control form-control-sm" name="fecha_inicial" value="<?php echo hoy;?>" required="required"/>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 formulario">
                        <label>Fecha Final</label>
                        <input type="date" class="form-control form-control-sm" name="fecha_final" value="<?php echo hoy;?>" required="required"/>
                    </div>
                    
                </div>
                

                <div class="row mt-2 d-flex justify-content-center">
                    <div class="col-sm-6 col-md-3">
                        <label>&nbsp;</label>
                        <button type="submit" name="consultar" class="btn btn-block" style="background-color: #1b2d3b; color: #fff;">Filtrar</button>
                    </div>
                </div>

            </form>
            
    	    <form action="reporteExportarExcelInspeccionVehicular.php" method="post" target="_blank">
        		<div class="row mt-2 d-flex justify-content-center">
                    <div class="col-3">
                	    <input type="hidden" name="fecha_inicial" id="fecha_inicial" value="<?php echo $fecha_inicial; ?>" />
    	                <input type="hidden" name="fecha_final" id="fecha_final" value="<?php echo $fecha_final; ?>" />
    	                
                        <button type="submit" class="btn mr-4 btn-block" style="background-color: #4caf50; height: 40px; margin-top: 10px; color: #fff;">Excel <span class="fa fa-file-excel-o"></span></button>
        
        		     </div>
        		</div>
    	    </form>
        </div>

    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 linea_reporte" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; height: 3px; width: 96%;"></div>
        
    
    
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
                <th colspan="7" style="text-align:center">
                    TOTAL DE INSPECCIONES: 
                    <?php echo count($listado); ?>
                </th>
          </tr>
          
          <tr>
              <th>ID</th>
              <th>EMPRESA</th>
              <th>VEHICULO</th>
              <th>CONDUCTOR</th>
              <th>FECHA DE REGISTRO</th>
              <th>REGISTRADO POR</th>
              <th>OPCIONES</th>
            </tr>
    		</thead>
    		<tbody> 
                    <?php foreach($listado as $ls){ ?>
                    <tr>
                      <td><?php echo $ls['id_inspeccion'];?></td>
                      <td><?php echo $ls['empresa'];?></td>
                      <td><?php echo $ls['placa'];?></td>
                      <td><?php echo $ls['nombre'];?></td>
                      <td><?php echo $ls['fecha_registro'];?></td>
                      <td><?php $datos_usu = $usuario->listarUsuarioPorId($ls['id_usuario_registro']); echo $datos_usu[0]['nombre'];?></td>
                      <td>
                           <a href="consultarInspeccionVehicular.php?id=<?php echo $ls['id_inspeccion']; ?>" class="btn btn-outline-success" target="_blank" style="margin: 0px; padding: 0px 2px 0px 4px;"><span class="fa fa-search"></span></a>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
    	</table>

    </div>
    
    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?>
  
</body>
</html>
