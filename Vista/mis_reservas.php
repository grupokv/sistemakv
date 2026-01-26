<?php
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Viaje.php");

$viaje = new Viaje();

$reservas = $viaje->buscarReservasActivasUsuario($_SESSION['id_usuario']);
$cant_pp = count($reservas);

?>

<!DOCTYPE html><html><head>  <meta charset="utf-8">  <title>SistemaKV | Mis Reservas</title>  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  <!-- styles -->  <?php include("Template/styles.php") ?>  <!--fin  styles --></head><body>    <!--MENU-->       <?php include("Template/menu.php"); ?>    <!--FIN MENU-->

    <!--**************************--->    <!-- CONTENIDO -->

    <div aria-label="breadcrumb" class="mt-1"> 

         <ol class="breadcrumb">

            <li class="breadcrumb-item " aria-current="page"><a href="inicioPasajeros.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mis Reservas</li>

         </ol>

    </div>

    <hr style="background-color:#5e99b1; ">

    <div class="row" style="height: 60px; background-color: #5e99b1; ">

    	<div class="col-6">

    		<h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-ticket"  style="border: 1px solid #fff; border-radius: 50%; padding: 7px;"></span> Mis Reservas</h2>

    	</div>

    	<div class="col-6 d-flex justify-content-end">

        </div>

    </div>

    <hr style="background-color:#5e99b1;">

    <div class="mt-2 p-4 table-responsive">

    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">

    		<thead>

    			<tr>

    			<th>RUTA</th>			

                <th>FECHA</th>

                <th>HORA</th>

    			<th>OPCIONES</th>

    			</tr>

    		</thead>

    		<tbody>

    			<?php foreach ($reservas as $la){ ?>

    				<tr>				
    					<?php $datos_viaje = $viaje->listarViajePorId($la['id_viaje']);?>
                        <td><?php echo $datos_viaje[0]['id_ruta']; ?></td>

                        <td><?php echo $datos_viaje[0]['fecha']; ?></td>

                        <td><?php echo $datos_viaje[0]['hora']; ?></td>		

                        <td>    				

                            <a href="javascript:void(0)" data-toggle="modal" data-target="#detalle" onclick="mostrar(<?php echo $la['id'];?>)" class="btn btn-outline-info" data-toggle="tooltip" data-placement="button" title="consultar" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-search"></span></a>				

                        </td>    				

                    </tr>

    			<?php } ?>

    		</tbody>

    	</table>

    </div>

    <!-- Modal DOCUMENTACION -->
        <div class="modal fade" id="detalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content f-flex justify-content-center">
              <div class="modal-header">
                  <h5 class="modal-title " id="exampleModalLabel">Detalle Reserva</h5>
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

    <!-- FIN CONTENIDO -->

    <!-- script -->

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">


function mostrar(id){

   var parametros = {
                "id" : id
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '../Controlador/detalle_reserva.php', //archivo que recibe la peticion
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