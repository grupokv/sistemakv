<?php include("../Controlador/Sesion/autenticar.php");	require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo.php");require_once("../Modelo/Usuario.php");require_once("../Modelo/Cliente.php");
$id_cliente = $_GET['id_cliente'];$vehiculo = new Vehiculo();$conductor = new Conductor();$usuario = new Usuario();$listado = $vehiculo->listarRutasPorCliente($id_cliente);

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
            <li class="breadcrumb-item active" aria-current="page">Rutas Cliente</li>
         </ol>
    </div>
    
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-bus" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Asignación Ruta</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
        	<a href="agregarRutaCliente.php?id=<?php echo $id_cliente;?>" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Agregar Ruta <span class="fa fa-plus"></span></a>    
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table  table-hover table-sm display ">
    		<thead>
    	       <tr>
              <th>PLACA</th>
              <th># RUTA</th>
              <th>CONDUCTOR</th>
              <th>LIDER</th>
	      <th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php foreach ($listado as $lv){ ?>
                    <tr>
                        <td><?php $det_veh = $vehiculo->listarPorId($lv['id_vehiculo']); echo $det_veh[0]['placa']; ?></td>
                        <td><?php echo $lv['num_ruta'] ?></td>
                        <td>
                          <?php			  if($lv['id_conductor'] != ''){				$det_con = $conductor->listarPorId($lv['id_conductor']);				echo $det_con[0]['nombre_conductor'];			  } else { 				echo 'SIN ASIGNAR'; 			  }
                          ?>
                        </td>
                        <td>
                          <?php			  if($lv['id_monitor'] != ''){ 				$det_mon = $usuario->listarUsuarioPorId($lv['id_monitor']);				echo $det_mon[0]['nombre'];			  } else { 				echo 'SIN ASIGNAR'; 			  }
                          ?>
                        </td>
                        <td>			    
                            <?php if(($lv['id_conductor'] == '')or($lv['id_monitor'] == '')){ ?>
                             <a href="asignacion_ruta_fija.php?id=<?php echo $lv['id'];?>" class="btn btn-outline-success"  style="margin: 0px; padding: 0px 4px 0px 4px;">				<span class="fa fa-plus"></span>                             </a>			    <?php } else { ?>			     <a href="asignacion_ruta_fija.php?id=<?php echo $lv['id'];?>" class="btn btn-outline-primary"  style="margin: 0px; padding: 0px 4px 0px 4px;">				<span class="fa fa-pencil"></span>                             </a>			    <?php } ?>
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