<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");

$idv = $_GET['idv'];

$vehiculo = new vehiculo();
$datoV = $vehiculo->listarPorId($idv);

$usuario = new usuario();
$listaConductores = $usuario->listarPorPerfil(3);
$listaMonitores = $usuario->listarPorPerfil(4);

$cliente = new cliente();
$listaColegios = $cliente->listarClientePorIdSegmento(3);

$datosActuales = $vehiculo->rutaAsignada($idv);
$cant = count($datosActuales);
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
            <form method="POST" action="../Controlador/asignarRuta.php" class="p-4">
                    <input type="hidden" value="<?php echo $idv; ?>" name="idv" id="idv">
                    <!-- NOMBRE -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Placa</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" name="placa" id="placa" class="form-control" value="<?php echo $datoV[0]['placa'];?>" readonly="true">
                        </div>
                    </div>

                    <!-- CORREO ELECTRONICO -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Marca</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" name="correo_electronico" id="correo_electronico" class="form-control" value="<?php echo $datoV[0]['marca'];?>" readonly="true">
                        </div>
                    </div>

                    <!-- USUARIO -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Modelo</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" name="nombre_usu" id="nombre_usu"  class="form-control" value="<?php echo $datoV[0]['modelo'];?>" readonly="true">
                        </div>
                    </div>

                    <!-- COLEGIO -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Colegio</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control selectpicker" name="colegio" id="colegio" required="required">
                                <option value="" >Seleccione Colegio</option>
                                <?php foreach ($listaColegios as $lc){ ?>
                                  <option value="<?php echo $lc['id_cliente'] ?>" <?php if (($cant > 0)and($datosActuales[0]['id_cliente'] == $lc['id_cliente'])){ ?> selected="selected" <?php } ?> >
                                    <?php echo $lc['razon_social'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- CONDUCTOR -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Conductor</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control selectpicker" name="conductor" id="conductor" required="required">
                                  <option value="" >Seleccione Conductor</option>
                                <?php foreach ($listaConductores as $lc){ ?>
                                  <option value="<?php echo $lc['id_usuario'] ?>" <?php if (($cant > 0)and($datosActuales[0]['id_conductor'] == $lc['id_usuario'])){ ?> selected="selected" <?php } ?> >
                                    <?php echo $lc['nombre'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- MONITOR -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Monitor</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control selectpicker" name="monitor" id="monitor" required="required">
                                  <option value="">Seleccione Monitor</option>
                                <?php foreach ($listaMonitores as $lc){ ?>
                                  <option value="<?php echo $lc['id_usuario'] ?>" <?php if (($cant > 0)and($datosActuales[0]['id_monitor'] == $lc['id_usuario'])){ ?> selected="selected" <?php } ?> >
                                    <?php echo $lc['nombre'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="row d-flex justify-content-center mt-4">
                      <div class="col-3">
                         <a type="submit" href="asignar_ruta.php" class="btn btn-danger btn-block">Cancelar</a>
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
  <?php include("Template/scripts.php"); ?>
  <script src="../Resources/js/bootstrap-select.min.js"></script>
  <script type="text/javascript">

$('select').selectpicker();
  </script>
  
</body>
</html>