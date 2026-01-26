<?php
require_once("../Modelo/InspeccionVehicular.php");
$inspeccionVehicular = new InspeccionVehicular();

$id = $_POST['id'];
$nombre_entrega = $_POST['nombre_entrega'];
$dir = "../Documentos/Inspeccion/".$id."/";
$nombre_archivo = 'signature_'.time().'.png';
$file = $dir.$nombre_archivo;

if (empty($_POST['signature'])) {
  echo '<p>Error: No fue posible firmar, comuniquese con el area de soporte</p>';
} else {
  $data = trim(strip_tags($_POST['signature']));
  if (substr($data,0,15) != 'data:image/png;') { echo '<p>Error: Firma invalida</p>'; }
  else {
    $encoded_image = explode(',',$data)[1];
    $decoded_image = base64_decode($encoded_image);
    file_put_contents($file,$decoded_image) or die('<p>Error: No fue posible guardar la firma</p>');
    //echo '<p>Your signature was saved successfully as '.$file.'.</p>';
    //echo '<p><img src="'.$file.'" alt="signature"></p>';
  }
}
$image_name = $file;
$image = imagecreatefrompng($image_name);
$imgResized = imagescale($image , 400);
imagepng($imgResized, $file);

$actualizar = $inspeccionVehicular->guardarFirmaEntrega($id,$nombre_archivo,$nombre_entrega);    
if($actualizar > 0){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Firma de Entrega Realizada Correctamente, Continue Al Proceso De Firma Recibido');
    window.location.href='../Vista/firmaRecibidoInspeccionVehicular.php?id=".$actualizar."';
    </script>");
} else {
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Error al Registrar, Intente Nuevamente');
    history.back();
    </script>");
}
?>