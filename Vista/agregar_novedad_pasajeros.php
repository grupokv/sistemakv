<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Pasajero.php");

$idv = $_GET['idv'];

$vehiculo = new vehiculo();
$datoV = $vehiculo->listarPorId($idv);
$pasajeros = $vehiculo->pasajerosAsignados($idv);
//print_r($pasajeros);

$id_pasajeros = array();
foreach($pasajeros as $pas){
  array_push($id_pasajeros,$pas['id_pasajero']);
}
//print_r($id_pasajeros);

$pasajero = new pasajero();
$listarP = $pasajero->listar();

$listarR = $vehiculo->listarOtrasRutas($idv);
//print_r($listarR);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Novedad Pasajero</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php"); ?>
  <link rel="stylesheet" href="../Resources/css/registrarUsuario.css">
  <link rel="stylesheet" href="../Resources/css/bootstrap-select.css" />
  
  <script type="text/javascript">
    function tiponovedad(opcion){
      if(opcion == '2'){
          document.getElementById('rutas').style.display = 'flex';
      } else {
          document.getElementById('rutas').style.display = 'none';
      }
    }
  </script>

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
            <li class="breadcrumb-item " aria-current="page"><a href="novedades_pasajeros.php">Novedades Pasajeros</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novedad</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="col-10 formulario mb-5">
            <div class="row" style="height: 60px; background-color: #5e99b1; ">
              <div class="col-">
                <h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-bus" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Novedad Pasajero</h2>
              </div>
            </div>
            <hr>
            <!-- Formulario -->
            <form method="POST" action="../Controlador/agregarNovedadRuta.php" class="p-4">
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

                    <!-- TIPO DE NOVEDAD -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Tipo de Novedad</label>
                        </div>
                        <div class="col-10">    
                            <select class="form-control" name="tipo_novedad" id="tipo_novedad" required="required" onchange="tiponovedad(this.value);">
                                <option>Seleccione Opción</option>
                                <option value="1">Retiro</option>
                                <option value="2">Cambio Ruta</option>
                            </select>
                        </div>
                    </div>

                    <!-- PASAJERO -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Pasajeros</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control" name="pasajero" id="pasajero">
                                <?php foreach ($pasajeros as $lc){ ?>
                                  <?php $nombre = $pasajero->listarPasajeroPorId($lc['id_pasajero']); ?>
                                  <option value="<?php echo $lc['id_pasajero'] ?>" >
                                    <?php echo $nombre[0]['nombre'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- OTRAS RUTAS -->
                    <div class="row col-12 mb-4" id="rutas" style="display:none">
                        <div class="col-2 text-center">    
                            <label for="speed">Otras Rutas</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control" name="rutanueva" id="rutanueva">
                                <option >Seleccione nueva ruta</option>
                                <?php foreach ($listarR as $lr){ ?>
                                  <option value="<?php echo $lr['id_vehiculo'] ?>" >
                                    <?php echo $lr['placa'].' / '.$lr['numero_movil'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- DETALLE -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Detalle Novedad</label>
                        </div>
                        <div class="col-10">
                              <textarea class="form-control" name="detalle" id="detalle" required="required"></textarea>
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="row d-flex justify-content-center mt-4">
                      <div class="col-3">
                         <a type="submit" href="novedades_pasajeros.php" class="btn btn-danger btn-block">Cancelar</a>
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