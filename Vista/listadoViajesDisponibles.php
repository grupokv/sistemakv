<?php 

include ("../Controlador/Sesion/autenticar.php");

require_once ("../Modelo/Viaje.php");

require_once ("../Modelo/Usuario.php");



$viaje = new Viaje();

$usuario = new Usuario();



$datos_usuario = $usuario->listarUsuarioPorId($_SESSION['id_usuario']);

$ruta = $datos_usuario[0]['id_cargo'];



$fecha = $_POST['fecha'];

$listado = $viaje->listarViajesDisponible($ruta,$fecha);

?>

<!DOCTYPE html><html><head>  <meta charset="utf-8">  <title>SistemaKV | Listado Viajes</title>  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  <!-- styles -->  <?php include("Template/styles.php") ?>  <!--fin  styles --></head><body>    <!--MENU-->       <?php include("Template/menu.php"); ?>    <!--FIN MENU-->

    <!--**************************--->    <!-- CONTENIDO -->

    <div aria-label="breadcrumb" class="mt-1"> 

         <ol class="breadcrumb">

            <li class="breadcrumb-item " aria-current="page"><a href="inicioPasajeros.php">Inicio</a></li>
	    <li class="breadcrumb-item " aria-current="page"><a href="consultar_viajes.php">Filtro Fecha</a></li>
            <li class="breadcrumb-item active" aria-current="page">Consultar Viajes</li>

         </ol>

    </div>

    <hr style="background-color:#5e99b1; ">

    <div class="row" style="height: 60px; background-color: #5e99b1; ">

    	<div class="col-6">

    		<h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-map"  style="border: 1px solid #fff; border-radius: 50%; padding: 7px;"></span> Viajes Disponibles</h2>

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

    			<?php foreach ($listado as $la){ ?>

    				<tr>				

                        <td><?php echo $la['id_ruta']; ?></td>

                        <td><?php echo $la['fecha']; ?></td>

                        <td><?php echo $la['hora']; ?></td>		

                        <td>    				

                            <a href="sistema_sillas.php?id=<?php echo base64_encode($la['id_viaje']); ?>" class="btn btn-outline-info" data-toggle="tooltip" data-placement="button" title="consultar" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-search"></span></a>				

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