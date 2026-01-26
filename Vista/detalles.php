<?php 
	include ("../Controlador/Sesion/autenticar.php");
	require_once ('../Modelo/Operacion.php');
    require_once ('../Modelo/DetalleOperacion.php');
    require_once ('../Modelo/Vehiculo.php');
    require_once ('../Modelo/DetalleGastoPersonal.php');

	$operacion = new Operacion();
    $listarO = $operacion->listar();

    $vehiculo = new Vehiculo();
    $listarVehiculo = $vehiculo->listar();

    $detalleOperacion = new DetalleOperacion();
    $listarDF = $detalleOperacion->listarDetallesFinalizados();


    $detalleGastoPersonal = new DetalleGastoPersonal();
    $listarDGFinalizados = $detalleGastoPersonal->listarDGFinalizados();


    if($_POST){
        $id_vehiculo = '%%';
        if($_POST['id_vehiculo'] != ''){
            $id_vehiculo = $_POST['id_vehiculo'];
        }
        $fecha_inicio = '0000-00-00';
        if($_POST['fecha_inicio'] != ''){
            $fecha_inicio = $_POST['fecha_inicio'];
        }
        $fecha_final = '9999-12-31';
        if($_POST['fecha_final'] != ''){
            $fecha_final = $_POST['fecha_final'];
        }
        $id_operacion = '%%';
        if($_POST['id_operacion'] != ''){
            $id_operacion = $_POST['id_operacion'];
        }
      
    } else {
        $id_vehiculo = '%%';
        $fecha_inicio = '0000-00-00';
        $fecha_final = '9999-12-31';
        $id_operacion = '%%';
    }

    $filtrarDetalleConsulta = $detalleOperacion->filtrar($fecha_inicio, $fecha_final, $id_vehiculo, $id_operacion);
    $filtrarDG = $detalleGastoPersonal->filtrarDG($fecha_inicio, $fecha_final);

      /*$total = $detalleOperacion->valorTotalFiltro($fecha_inicio, $fecha_final, $id_vehiculo, $id_operacion);

      $filtrarCulminadas = $detalleOperacion->filtrarDetallesCumplidos($fecha_inicio, $fecha_final, $id_vehiculo, $id_operacion);
      $valorTotalFiltroDetallesCumplidos = $detalleOperacion->valorTotalFiltroDetallesCumplidos($fecha_inicio, $fecha_final, $id_vehiculo, $id_operacion);*/
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Consultar Detalles</title>
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
            <li class="breadcrumb-item " aria-current="page"><a href="../Vista/inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Consultar Detalles</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-clipboard"  style="border: 1px solid #fff; border-radius: 50%; padding: 7px;"></span> Consultar Detalles</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <!--PDF-->
            <button type="button" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;" data-toggle="modal" data-target="#reporte">PDF <span class="fa fa-file-pdf-o"></span></button>

            <!-- MODAL -->
                <div class="modal fade" id="reporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form method="post" action="../Vista/PDF/detalles.php" target="_blank">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Generar informe</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row"> 
                                        <div class="col-12 mb-3">
                                            <label>Informe de</label>
                                            <select name="informe_operacion" id="informe_operacion" class="form-control">
                                                <option value="0">Seleccionar</option>
                                                <option value="1">Todas las operaciones</option>
                                                <option value="2">Operaciones Personales</option>
                                                <option value="3">Operaciones Vehiculares</option>
                                                <option value="4">Operaciones Finalizadas</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label>Fecha inicial</label>
                                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                                        </div>
                                        <div class="col-6">
                                            <label>Fecha final</label>
                                            <input type="date" name="fecha_final" id="fecha_final" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <input type="submit"  class="btn btn-success" value="Generar"></input>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            <!--Registrar-->
            <a href="registrarDetalleOperaciones.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Registrar Detalle <span class="fa fa-plus"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 ml-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 96%">
        <p>FILTRAR Y CONSUTAR DETALLE</p>
    </div>
        <div class="col-12 ml-4 " style="height: 160px; width: 96%; border-radius: 4px; background-color: #fafafa; ">
            
            <form method="POST" action="">
                <div class="row mb-4 mt-2">
                    <div class="col-3">
                        <label>Fecha Inicial</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                    </div>
                    <div class="col-3">
                        <label>Fecha Final</label>
                        <input type="date" name="fecha_final" id="fecha_final" class="form-control">
                    </div>
                    <div class="col-3">
                        <label>Vehiculo</label>
                        <select class="form-control display" name="id_vehiculo">
                            <option value>Seleccione vehiculo</option>
                            <?php foreach ($listarVehiculo as $v) { ?>
                                <option value="<?php echo $v['id_vehiculo'] ?>">
                                    <?php echo $v['placa']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <label>Operación</label>
                        <select class="form-control display" name="id_operacion" >
                            <option value>Seleccione operación</option>
                            <?php foreach ($listarO as $o) { ?>
                                <option value="<?php echo $o['id_operacion'] ?>">
                                    <?php echo $o['nombre_operacion']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <hr>
                            
                <!-- operacion -->
                <section class="d-flex justify-content-center">
                    <div class="col-4">
                        <button name="consultar" class="btn btn-block mt-2" style="background-color: #1b2d3b; color: #fff;">Filtrar</button>
                    </div>
                </section>
            </form>
        </div>
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 ml-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; height: 3px; width: 96%;"></div>
        
        <div id="tabs" style="width: 95%; margin-left: 30px; margin-top: 10px;">
            <ul>
                <li><a href="#tabs-1">Operaciones Vehiculares </a></li>
                <li><a href="#tabs-2">Operaciones Personales </a></li>
                <li><a href="#tabs-3">Operaciones Finalizadas </a></li>
            </ul>

            <!-- INFORMACION BASICA-->
                <div id="tabs-1">
                    <div class="mt-2 p-4 table-responsive">
                        <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
                        		<thead>
                        			<tr>
                        				<th>VEHICULO</th>
                                        <th>OPERACIÓN REALIZADA</th>
                                        <th>FECHA EJECUCIÓN</th>
                                        <th>VALOR</th>
                        				<th>OPCIONES</th>
                        			</tr>
                        		</thead>
                        		<tbody>
                                    <?php foreach ($filtrarDetalleConsulta as $fdo){ ?>
                                    	<tr>
                                            <td><?php echo $fdo['placa']; ?><input type="hidden" name="id_detalle" id="id_detalle" value="<?php echo $fdo['id_detalle'] ?>"></td>
                                            <td><?php echo $fdo['nombre_operacion']; ?></td>
                                            <td><?php echo $fdo['fecha']; ?></td>
                                            <td>$<?php echo number_format($fdo['precio'])?></td>
                                            <td>
                                            	<!--Editar-->
                        					    <a href="actualizarDetalleOperacion.php?id_detalle=<?php echo $fdo['id_detalle']; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="button" title="Editar detalle"  style="margin: 0px; padding: 0px 4px 0px 4px; color: #fff;"><span class="fa fa-edit"></span></a>

                        					    <!--Eliminar-->
                        					    <a href="../Controlador/eliminarDetalleOperacion.php?id_detalle=<?php echo $fdo['id_detalle']; ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="button" title="Eliminar detalle"   style="margin: 0px; padding: 0px 4px 0px 4px; color: #fff;"><span class="fa fa-trash"></span></a>

                                                <!--Culminar-->
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" style="margin: 0px; padding: 0px 4px 0px 4px;  color: #fff;" onclick="modal(<?php echo $fdo['id_detalle'];?>)"><span class="fa fa-check"></span></button>


                                                    <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form method="POST" action="../Controlador/culminarDetalleOperacion.php">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">NOVEDAD DE CULMINACIÓN DEL DETALLE</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <section id="contenido_modal"></section>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                                            <button type="submit" class="btn btn-primary">Culminar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                            </td>
                                    	</tr>
                        			<?php } ?>
                        		</tbody>
                        </table>
                    </div>
                </div>

            <div id="tabs-2">
                <div class="mt-2 p-4 table-responsive">
                        <table  id="dataT2" class="table table-hover table-sm display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>DESCRIPCIÓN</th>
                                        <th>PERSONA - ENTIDAD</th>
                                        <th>FECHA DETALLE</th>
                                        <th>PRECIO</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($filtrarDG as $fdg){ ?>
                                        <tr>
                                            <td><?php echo $fdg['descripcion']; ?><input type="hidden" name="id_detalle_gasto" id="id_detalle_gasto" value="<?php echo $fdg['id_detalle_gasto'] ?>"></td>
                                            <td><?php echo $fdg['nombre_persona']; ?></td>
                                            <td><?php echo $fdg['fecha_detalle']; ?></td>
                                            <td>$<?php echo number_format($fdg['precio'])?></td>
                                            <td>
                                                <!--Editar-->
                                                    <a href="actualizarDetalleGastoPersonal.php?id_detalle_gasto=<?php echo $fdg['id_detalle_gasto']; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="button" title="Editar detalle"  style="margin: 0px; padding: 0px 4px 0px 4px; color: #fff;"><span class="fa fa-edit"></span></a>

                                                <!--Eliminar-->
                                                    <a href="../Controlador/eliminarDetalleGastoPersonal.php?id_detalle_gasto=<?php echo $fdg['id_detalle_gasto']; ?>" class="btn btn-danger"style="margin: 0px; padding: 0px 4px 0px 4px; color: #fff;"><span class="fa fa-trash"></span></a>

                                                <!--Culminar-->
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#culminarDGP" style="margin: 0px; padding: 0px 4px 0px 4px;  color: #fff;" onclick="novedadFinalizacionDGP(<?php echo $fdg['id_detalle_gasto'];?>)"><span class="fa fa-check"></span></button>


                                                    <!-- Modal -->
                                                        <div class="modal fade" id="culminarDGP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form method="POST" action="../Controlador/culminarDGP.php">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">CULMINACIÓN DE LA OPERACIÓN PERSONAL</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <section id="contenido_modal2">
                                                                                
                                                                            </section>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                                            <button type="submit" class="btn btn-primary">Culminar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                        </table>
                    </div> 
            </div>
            <div id="tabs-3">
                <div class="mt-2 p-4 table-responsive">
                        <table  id="dataT3" class="table table-hover table-sm display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>DESCRIPCIÓN - OPERACION</th>
                                        <th>PERSONA - VEHICULO</th>
                                        <th>FECHA DETALLE</th>
                                        <th>PRECIO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listarDF as $ldf){ ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    echo $ldf['nombre_operacion'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $ldf['placa']; 
                                                ?>
                                            </td>
                                            <td><?php echo $ldf['fecha']; ?></td>
                                            <td><?php echo "$" . number_format($ldf['precio']); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach ($listarDGFinalizados as $ldgf){ ?>
                                        <tr>
                                            <td><?php echo $ldgf['descripcion'];  ?></td>
                                            <td><?php echo $ldgf['nombre_persona'];  ?></td>
                                            <td><?php echo $ldgf['fecha_detalle'];  ?></td>
                                            <td><?php echo "$" . number_format($ldgf['precio']);  ?></td>
                                        </tr>
                                    <?php } ?>
                                    
                                </tbody>
                        </table>
                    </div> 
            </div>

    
    <!-- FIN CONTENIDO -->


    <!-- script -->
    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

            $( function() {
               $( "#tabs" ).tabs();
            } );



            function modal(id_detalle){
                /*alert(id_detalle);*/
                var parametros = {
                        "id_detalle" : id_detalle
                    };
                    $.ajax({
                            data:  parametros, //datos que se envian a traves de ajax
                            url:   '../Controlador/listarCampoDetalleOperacion.php', //archivo que recibe la peticion
                            type:  'POST', //método de envio
                            beforeSend: function () {
                                    $("#contenido_modal").html("Procesando, espere por favor...");
                            },
                            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                                    /*alert(response);*/
                                    $("#contenido_modal").html(response);
                            }
                    });
            }

            function novedadFinalizacionDGP(id_detalle_gasto){
                /*alert(id_detalle_gasto);*/
                var parametros = {
                        "id_detalle_gasto" : id_detalle_gasto
                    };
                    $.ajax({
                            data:  parametros, //datos que se envian a traves de ajax
                            url:   '../Controlador/listarCampoDetalleGastoPersonal.php', //archivo que recibe la peticion
                            type:  'POST', //método de envio
                            beforeSend: function () {
                                    $("#contenido_modal2").html("Procesando, espere por favor...");
                            },
                            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                                    /*alert(response);*/
                                    $("#contenido_modal2").html(response);
                            }
                    });
            }
    </script>

</body>
</html>