<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Correspondencia.php");
require_once("../Modelo/Usuario.php");

$correspondencia = new correspondencia();
$listarV = $correspondencia->listar();

$usuario = new Usuario();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Correspondencia</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <style type="text/css">
    
    @media (max-width: 760px){
      
        .icono-principal{
          display: none;
        }

        .fa-plus{
           display: none;
        }
    }

    .barra-principal{
      background-color: #5e99b1;
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
            <li class="breadcrumb-item active" aria-current="page">Correspondencia</li>
         </ol>
    </div>
    
    <hr style="background-color:#5e99b1; ">
    <div class="row barra-principal">
    	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-6">
    		  <h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-inbox" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Correspondencia</h2>
    	</div>
    	<div class="col-lg-6 col-md-6 col-sm-4 col-xs-6 d-flex justify-content-end">
          <a href="registrarCorrespondencia.php" class="btn mr-4 boton-registro" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;"><span class="fa fa-plus ml-2 mr-2"></span>Nuevo Documento</a>
          <a href="reporteCorrespondencia.php" class="btn mr-4 boton-registro" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;"><span class="fa fa-clipboard ml-2 mr-2"></span>Reporte</a>
      </div>
    </div>

    <hr style="background-color:#5e99b1;">
      <div class="mt-2 p-4 table-responsive">
    	  <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
      		<thead>
      			<tr>
              <th>ID</th>
              <th>TIPO</th>
              <th>FECHA RECIBIDO</th>
              <th>REMITENTE</th>
              <th>USUARIO DESTINO</th>
              <th>ESTADO</th>
      				<th>OPCIONES</th>
      			</tr>
      		</thead>
    		  <tbody>
            <?php foreach ($listarV as $lv){ ?>
              <tr>
                  <td><?php echo $lv['id_doc'] ?></td>
                  <td><?php $datos_tipo = $correspondencia->listarTipoPorId($lv['id_tipo_doc']); echo $datos_tipo[0]['detalle'] ?></td>
                  <td><?php echo $lv['fecha_recibido'] ?></td>
                  <td><?php echo $lv['remitente'] ?></td>
                  <td><?php $datos_us = $usuario->listarUsuarioPorId($lv['usuario_destino']); echo $datos_us[0]['nombre']; ?></td>
                  <td>
                    <?php
                    if($lv['fecha_entrega'] != ''){ echo 'ENTREGADO'; } else { echo "PENDIENTE"; }
                    ?>
                  </td>
                  <td>
                      <?php if($lv['fecha_entrega'] == ''){ ?>
                      <!--Entregar-->
                            <a href="entregarCorrespondencia.php?id=<?php echo $lv['id_doc']; ?>" class="btn btn-outline-success" style="margin: 0px;  padding: 0px 4px 0px 4px;"><span class="fa fa-handshake-o"></span></a>
                    
                      <!-- Actualizar -->

                          <a href="actualizarCorrespondencia.php?id=<?php echo $lv['id_doc'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>

                       <!--Consultar -->
                     <?php } ?>
                          <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#info" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="modal(<?php echo $lv['id_doc'];?>)"><span class="fa fa-search"></span></button>
                  </td>
                          
              </tr>
            <?php } ?>
    		  </tbody>
    	  </table>
      </div>
    
    <!-- FIN CONTENIDO -->
<div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content f-flex justify-content-center">
      <div class="modal-header">
          <h5 class="modal-title " id="exampleModalLabel">INFORMACIÓN CORRESPONDENCIA</h5>  
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <section id="contenido_modal" name="contenido_modal">

          </section>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

  <!-- script -->
  <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

function modal(id){
  //alert(id);

   var parametros = {
                "id" : id
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/consultarCorrespondencia.php', //archivo que recibe la peticion
                type:  'POST', //método de envio
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