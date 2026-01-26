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

$listaAsignados = $pasajero->yaAsignados();

$id_asignados = array();
foreach($listaAsignados as $ya){
  array_push($id_asignados,$ya['id_pasajero']);
}
//print_r($id_asignados);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Asignación Pasajeros</title>
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
            <li class="breadcrumb-item " aria-current="page"><a href="asignar_pasajeros.php">Asignar Pasajeros</a></li>
            <li class="breadcrumb-item active" aria-current="page">Asignación</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="col-10 formulario mb-5">
            <div class="row" style="height: 60px; background-color: #5e99b1; ">
              <div class="col-">
                <h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-bus" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Asignación Pasajeros</h2>
              </div>
            </div>
            <hr>
            <!-- Formulario -->
            <form method="POST" action="../Controlador/asignarPasajeros.php" class="p-4">
                    <input type="hidden" value="<?php echo $idv; ?>" name="idv" id="idv">
                    <input type="hidden" value="<?php echo $id_pasajeros;?>" name="id_pasajeros" id="id_pasajeros">
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

                    <!-- CARGO -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Pasajeros</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control selectpicker" name="pasajeros[]" id="pasajeros" multiple data-live-search="true">
                                <?php foreach ($listarP as $lc){ ?>
                                  <?php $asignada = $pasajero->rutaAsignada($lc['id_pasajero'],$idv); $cant1 = count($asignada); ?>
                                  <?php if($cant1 < 1) { ?>
                                  <option value="<?php echo $lc['id_pasajero'] ?>" <?php if(in_array($lc['id_pasajero'],$id_pasajeros)) { ?> selected="selected" disabled <?php } ?> >
                                    <?php echo $lc['nombre'] ?>
                                  </option>
                                  <?php } ?>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="row d-flex justify-content-center mt-4">
                      <div class="col-3">
                         <a type="submit" href="asignar_pasajeros.php" class="btn btn-danger btn-block">Cancelar</a>
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