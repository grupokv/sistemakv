<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/General.php");

$detalle = mb_strtoupper($_POST['detalle']);
$cuenta = $_POST['cuentapuc'];
$contra = $_POST['contrapuc'];

if($_POST['fecha'] == ""){
    $fecha = "0000-00-00";
}else{
    $fecha = $_POST['fecha'];
}

$estado = $_POST['estado'];
$frecuencia = $_POST['frecuencia'];
$concepto = new ConceptoCobro();
$busqueda = $concepto->buscarPorDetalle($detalle);
$cant = count($busqueda);

if($cant > 0){
    echo "<script>
    alert('Ya existe un concepto con ese nombre registrado en el sistema');
    window.location.href = '../Vista/conceptos_cobro.php';
    </script>";
    exit;

}

$registrar = $concepto->registrar($detalle,$cuenta,$contra,$estado,$frecuencia,$fecha);

if($registrar != 0){
    if($frecuencia == "N"){
        echo "<script LANGUAGE='JavaScript'>    window.location.href='../Vista/conceptos_cobro.php</script>";
    }else{
        echo "<script LANGUAGE='JavaScript'>    window.location.href='../Vista/registrarValoresConcepto.php?id=".base64_encode($registrar)."';    </script>";
    }
} else {    
    echo "<script>    alert('Ocurrio un error al registrar el concepto, por favor intente nuevamente');    window.location.href = '../Vista/conceptos_cobro.php';    </script>";    
    exit;
}


?>