<?php include("../Controlador/Sesion/autenticar.php");require_once("../Modelo/Vehiculo.php");require_once("../Modelo/Usuario.php");require_once("../Modelo/Cliente.php");$id = $_GET['id'];
$vehiculo = new vehiculo();$datos = $vehiculo->listarRutaPorId($id);$id_cliente = $datos[0]['id_cliente'];
$usuario = new usuario();
$listado_veh = $vehiculo->listarActivos();$listaMonitores = $usuario->listarMonitoresPorCliente($id_cliente);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Asignación Ruta</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php"); ?>
  <link rel="stylesheet" href="../Resources/css/registrarUsuario.css">
  <link rel="stylesheet" href="../Resources/css/bootstrap-select.css" />
  

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
            <li class="breadcrumb-item " aria-current="page"><a href="asignar_ruta.php">Asignar Ruta</a></li>
            <li class="breadcrumb-item active" aria-current="page">Asignación</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="col-10 formulario mb-5">
            <div class="row" style="height: 60px; background-color: #5e99b1; ">
              <div class="col-">
                <h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-bus" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Asignación Ruta</h2>
              </div>
            </div>
            <hr>
            <!-- Formulario -->
            <form method="POST" action="../Controlador/actualizarRuta.php" class="p-4">
                    <input type="hidden" value="<?php echo $id; ?>" name="id" id="id">		    <input type="hidden" value="<?php echo $id_cliente; ?>" name="id_cliente" id="id_cliente">		     <div class="row col-12 mb-4">			<div class="col-2 text-center">			      <label>Numero Ruta</label>			</div>			<div class="col-10">			      <input type="text" name="num_ruta"  id="num_ruta" class="form-control" required="required" value="<?php echo $datos[0]['num_ruta'] ?>">			</div>      				     </div>
                    <!-- NOMBRE -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Vehiculo</label>
                        </div>
                        <div class="col-10">    
				<select class="form-control" name="id_vehiculo" id="id_vehiculo" required="required" onchange="cargar(this.value,0)"></select>                            
                        </div>
                    </div>

                
                    
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Conductor</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control" name="id_conductor" id="id_conductor" required="required"></select>
                        </div>
                    </div>

                    <!-- MONITOR -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Monitor</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control"  name="id_monitor" id="id_monitor" required="required">
                                 <option value="">Seleccione Lider Ruta</option>
                                <?php foreach ($listaMonitores as $lc){ ?>
                                  <option value="<?php echo $lc['id_usuario'] ?>" <?php if ($datos[0]['id_monitor'] == $lc['id_usuario']){ ?> selected="selected" <?php } ?> >
                                    <?php echo $lc['nombre'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="row d-flex justify-content-center mt-4">
                      <div class="col-3">
                         <a type="submit" href="listado_rutas_cliente.php?id_cliente=<?php echo $id_cliente;?>" class="btn btn-danger btn-block">Cancelar</a>
                      </div>
                      <div class="col-3">
                          <input type="submit" class="btn btn-ingresar btn-block" value="Guardar"></input>
                      </div>
                 
                  
                    </div>
            </form>
        </div>
    </section>

    
    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?><script>
function cargar(id_vehiculo,id_conductor){          if(id_vehiculo == 0){            var parametros = {              "id_vehiculo" : id_vehiculo            };            $.ajax({                data:  parametros,                url:   '../Controlador/listarTodosVehiculos.php',                type:  'post',                beforeSend: function () {                    $("#id_vehiculo").html("<option value='' disabled='disabled' selected='selected'>Seleccione un vehiculo</option>");                    $("#id_conductor").html("<option value='' selected='selected'>Seleccione</option>");                },                success:  function (response) {                                        $("#id_vehiculo").html(response);                }            });          } else{             if(id_vehiculo != ''){                var parametros = {                  "id_vehiculo" : id_vehiculo,                  "id_conductor" : id_conductor                };		$.ajax({                    data:  parametros,                    url:   '../Controlador/listarVehiculosAsignacion.php',                    type:  'post',                    beforeSend: function () {                        $("#id_vehiculo").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");                    },                    success:  function (response) {                        $("#id_vehiculo").html(response);                    }                });				$.ajax({                    data:  parametros,                    url:   '../Controlador/listarConductoresVehiculo.php',                    type:  'post',                    beforeSend: function () {                        $("#id_conductor").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");                    },                    success:  function (response) {                        $("#id_conductor").html(response);                    }                });                $.ajax({                    data:  parametros,                    url:   '../Controlador/listarConductoresVehiculo.php',                    type:  'post',                    beforeSend: function () {                        $("#id_conductor").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");                    },                    success:  function (response) {                        $("#id_conductor").html(response);                    }                });            }          }        }<?php if($datos[0]['id_vehiculo'] != ''){ $veh = $datos[0]['id_vehiculo']; } else { $veh = 0; } ?><?php if($datos[0]['id_conductor'] != ''){ $cond = $datos[0]['id_conductor']; } else { $cond = 0; } ?>cargar(<?php echo $veh;?>,<?php echo $cond;?>);</script>
  
</body>
</html>