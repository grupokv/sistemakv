<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vinculacion.php");

$vinculacion = new Vinculacion();
$listarSolicitudesVinculaciones = $vinculacion->listarSolicitudes();


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Solicitudes a Vinculación</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- styles -->
      <?php include("Template/styles.php") ?>
      <style type="text/css">
            .barra-principal{
              background-color: #5e99b1;
              width: auto;
            }
      </style>
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
            <li class="breadcrumb-item active" aria-current="page">Solicitudes a Vinculación</li>
         </ol>
    </div>
    
    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">

      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 titulo_principal">
      		  <h2 class="mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-car icono-principal ml-2" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Solicitudes a Vinculación</h2>
      	</div>
    </div>

    <hr style="background-color:#5e99b1;">
      <div class="mt-2 p-4 table-responsive">
    	  <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
      		<thead>
      			<tr>
                    <th>ID</th>
                    <th>SOLICITANTE</th>
                    <th>VEHICULO</th>
                    <th>PLACA</th>
                    <th>TIPO VEHICULO</th>
                    <th>MODELO</th>
                    <th>MOTIVO</th>
                    <th>FECHA DE SOLICITUD</th>
      		    </tr>
      		</thead>
    		<tbody>
                <?php foreach ($listarSolicitudesVinculaciones as $lsv){ ?>
                    <tr class="text-center">
                        <td><?php echo $lsv['id_solicitud_vinculacion'] ?></td>
                        <td><?php echo $lsv['nombres_apellidos'] ?><a onclick="informacionUsuarioVinculacion(<?php echo $lsv['id_solicitud_vinculacion']; ?>);" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-eye ml-2" style="color: green; cursor: pointer;"></span></a></td>    
                        <td><?php echo $lsv['marca'] ?></td>
                        <td><?php echo $lsv['placa'] ?></td>
                        <td><?php echo $lsv['tipo_vehiculo'] ?></td>
                        <td><?php echo $lsv['modelo'] ?></td>
                        <td><?php echo $lsv['motivo'] ?></td>
                        <td><?php echo $lsv['fecha'] ?></td>
                    </tr>
                <?php } ?>
    		</tbody>
    	</table>
    </div>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" >
                    <div class="alert alert-primary text-center" role="alert">INFORMACIÓN USUARIO</div>
                    
                    <section class="row d-flex justify-content-center" id="info">
                        
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
      
      
  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
    
        function informacionUsuarioVinculacion(id_solicitud){
            //alert(id_solicitud);
            var parametros = {
                "id_solicitud" : id_solicitud
            };
            $.ajax({
                data:  parametros,
                url:   '../Controlador/listarInfoUsuarioVinculacion.php',
                type:  'post',
                beforeSend: function () {
                    //alert('envio');
                    $("#info").html("<p>Procesando información, espere por favor...</p>");
                },
                success:  function (response) {
                    //alert(response);
                    $("#info").html(response); 
                }
            });
        }
    </script>



  
</body>
</html>