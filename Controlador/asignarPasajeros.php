<?php
date_default_timezone_set('America/Bogota');
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");

$idv = $_POST['idv'];
$pasajeros = $_POST['pasajeros'];

$vehiculo = new vehiculo();
$listPasajeros = $vehiculo->pasajerosAsignados($idv);
//print_r($pasajeros);

$id_pasajeros = array();
foreach($listPasajeros as $pas){
  array_push($id_pasajeros,$pas['id_pasajero']);
}
//print_r($id_pasajeros);
    
/*VARIABLES*/
$cant = count($pasajeros);

/*FECHA LOCAL*/
$fecha = date('YmdHis');

 if($cant > 0){
        
        $vehiculo = new Vehiculo();

        /*REGISTRO DE VEHICULOS*/
        for($i=0;$i<$cant;$i++){
            $registrarV = $vehiculo->asignarPasajeros($pasajeros[$i],$idv);
        }

        header("Location: ../Vista/asignar_pasajeros.php");

    } else {
        ?>

        <script type="text/javascript">
        alert("Todos los campos son obligatorios");
        window.location.href = "../Vista/asignacion_pasajeros.php?idv=<?php echo $idv;?>";
        </script>

<?php } ?>