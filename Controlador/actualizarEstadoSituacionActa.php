<?php 
require_once '../Modelo/Actas.php';

$acta = new Acta();

$id_acta = $_POST['id_acta'];
$id_situacion = $_POST['id_situacion'];

if(count($id_situacion) > 0) {
    
    for($i=0;$i<count($id_situacion);$i++){
        
        $estado = $_POST['estado_solucion_'.$id_situacion[$i]];
        $actualizar = $acta->cambiarEstadoSituacionId($id_situacion[$i],$estado);
        
    }
    
    echo ("<script LANGUAGE='JavaScript'>
	window.alert('Actualizaciones realizadas correctamente');
	window.location.href='../Vista/Actas.php';
	</script>");
    
} else {
    
    echo "<script>
		alert('Faltan campos obligatorios por diligenciar');
		history.back();
		</script>";
	exit();
	
}
?>