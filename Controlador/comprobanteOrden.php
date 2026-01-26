<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/OrdenServicio.php");
require_once("../Modelo/General.php");

echo $id = $_POST['id'];
$valor = $_POST['valor'];
$fechae = $_POST['fecha'];

$orden = new OrdenServicio();

if (!empty($_FILES['factura']['name'])) {
$fecha = date('YmdHis');
$valido = 0;
$valido = validar_archivo($_FILES['factura']['name'], $_FILES['factura']['size']);
if($valido == 1){

    $factura = quitar_simbolos($_FILES['factura']['name']);
    $factura = $fecha . '-'. $factura;                    
    //$carpeta = "E:\sistemakv\Documentos\Ordenes". '/'. $id_orden_s;
    $carpeta = "Ordenes/".$id;
    $ruta = $carpeta.'/'.$factura;                    

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }

    $ruta_temp = $_FILES['factura']['tmp_name'];
    move_uploaded_file($ruta_temp, $ruta);
    
    $act = $orden->finalizar($id,$valor,$factura,$fechae);

    echo "<script>
    alert('Orden de servicio finalizada correctamente');
    window.location.href='../Vista/ordenes_servicio.php';
    </script>";
    exit();

} else {
    echo "<script>
    alert('El tipo de archivo no es valido o el archivo excede el tamaño permitido');
    history.back();
    </script>";
    exit();
}

}else{
	echo "<script>
    alert('El archivo es obligatorio');
    history.back();
    </script>";
    exit();
}
?>