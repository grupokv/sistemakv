<?php 
include("../Controlador/Sesion/autenticar.php");	
require_once("../Modelo/Vehiculo.php");

$vehiculo = new vehiculo();
$listarV = $vehiculo->listarPorTipo(1);

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Asignacion Ruta</title>
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
            <li class="breadcrumb-item active" aria-current="page">Asignación Ruta</li>
         </ol>
    </div>
    
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-bus" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Asignación Ruta</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table  table-hover table-sm display ">
    		<thead>
    			<tr>
              <th>PLACA</th>
              <th>MARCA</th>
              <th>MODELO</th>
              <th>TIPO VEHICULO</th>
              <th>COLEGIO</th>
              <th>CONDUCTOR</th>
              <th>MONITOR</th>
			        <th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php foreach ($listarV as $lv){ ?>
                    <?php 
                    $datos = $vehiculo->rutaAsignada($lv['id_vehiculo']);
                    $cant = count($datos);
                    ?>
                    <tr>
                        <td><?php echo $lv['placa'] ?></td>
                        <td><?php echo $lv['marca'] ?></td>
                        <td><?php echo $lv['modelo'] ?></td>
                        <td><?php echo $lv['nombre_tipo_vehiculo'] ?></td>
                        <td>
                          <?php
                          if($cant > 0){ echo $datos[0]['id_cliente']; } else { echo 'N/A'; } 
                        	?>
                        </td>
                        <td>
                          <?php
                          if($cant > 0){ echo $datos[0]['id_conductor']; } else { echo 'N/A'; } 
                          ?>
                        </td>
                        <td>
                          <?php
                          if($cant > 0){ echo $datos[0]['id_monitor']; } else { echo 'N/A'; } 
                          ?>
                        </td>
                        <td>
                            

                            <!--Consultar-->
                             <a href="asignacion_ruta.php?idv=<?php echo $lv['id_vehiculo'];?>" class="btn btn-outline-success"  style="margin: 0px; padding: 0px 4px 0px 4px;">
                                    <span class="fa fa-plus"></span>
                            </a>
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


function modal(id_vehiculo){
  //alert(id);
   var parametros = {
                "id_vehiculo" : id_vehiculo
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/listarDocsVehiculo.php', //archivo que recibe la peticion
                type:  'post', //método de envio
                beforeSend: function () {
                        $("#contenido_modal").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        //alert(response);
                        $("#contenido_modal").html(response);
                }
        });
}

  </script>



  
</body>
</html>