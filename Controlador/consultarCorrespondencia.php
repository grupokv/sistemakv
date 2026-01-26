<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Correspondencia.php");
require_once("../Modelo/Usuario.php");

$id = $_POST['id'];

$correspondencia = new Correspondencia();
$datos = $correspondencia->listarPorId($id);

$usuario = new Usuario();

$html = '<table class="table table-hover table-sm display" style="width:100%">';

$html .= "<tr>";
$html .= "<td align='center'><b>TIPO</b></td>";
$dato_tipo = $correspondencia->listarTipoPorId($datos[0]['id_tipo_doc']);
$html .= "<td align='center'>".$dato_tipo[0]['detalle']."</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align='center'><b>DETALLE</b></td>";
$html .= "<td align='center'>".$datos[0]['detalle']."</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align='center'><b>FECHA RECIBIDO</b></td>";
$html .= "<td align='center'>".$datos[0]['fecha_recibido']."</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align='center'><b>REMITENTE</b></td>";
$html .= "<td align='center'>".$datos[0]['remitente']."</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align='center'><b>DESTINO</b></td>";
$html .= "<td align='center'>".$datos[0]['destino']."</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align='center'><b>QUIEN RECIBE</b></td>";
$datos1 = $usuario->listarUsuarioPorId($datos[0]['usuario_creador']);
$html .= "<td align='center'>".$datos1[0]['nombre']."</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align='center'><b>USUARIO DESTINO</b></td>";
$datos2 = $usuario->listarUsuarioPorId($datos[0]['usuario_destino']);
$html .= "<td align='center'>".$datos2[0]['nombre']."</td>";
$html .= "</tr>";

if($datos[0]['fecha_entrega'] != ''){

$html .= "<tr>";
$html .= "<td align='center'><b>ESTADO</b></td>";
$html .= "<td align='center'>ENTREGADO</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align='center'><b>FECHA ENTREGADO</b></td>";
$html .= "<td align='center'>".$datos[0]['fecha_entrega']."</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align='center'><b>FIRMA</b></td>";
$html .= "<td align='center'><img src='../firmas/".$datos[0]['firma']."' style='width:150px'/></td>";
$html .= "</tr>";

} else {

$html .= "<tr>";
$html .= "<td align='center'><b>ESTADO</b></td>";
$html .= "<td align='center'>PENDIENTE</td>";
$html .= "</tr>";

}
$html .= "</table>";

echo $html;
?>