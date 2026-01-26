<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/UsuarioContratoOcasional.php");

$id_contrato = $_POST['id_contrato'];

$nombre = $_POST['nombre_usuario'];
$documento = $_POST['numero_documento'];


for ($i=0; $i < count($nombre); $i++) { 
	$nombre_usuario = $nombre[$i];
	$numero_documento = $documento[$i];

	$usuarioContratoOcasional = new UsuarioContratoOcasional();
	$registrar = $usuarioContratoOcasional->registrar($id_contrato, $nombre_usuario, $numero_documento);	
}	

echo "<script>alert('El contrato ocasional fue registrado correctamente.'); window.location.href='../Vista/contratosOcasionales.php';</script>";

/*
if(($_SESSION['id_perfil'] == 2) AND ($_SESSION['id_cliente'] == 0)){
	/*echo "<script>var parametros = {'cantidad_usuarios' : cantidad_usuarios};$.ajax({type:'POST', url: url, data: parametros, success: function(data){if(data.redirect){window.location.href='../Vista/formularioPagos.php';}}});</script>";*/
	
/*?>
		<script type="text/javascript">
				alert("asd");
			function redirect_by_post(purl, pparameters, in_new_tab) {
				alert("asd");
			    pparameters = (typeof pparameters == 'undefined') ? {} : pparameters;
			    in_new_tab = (typeof in_new_tab == 'undefined') ? true : in_new_tab;

			    var form = document.createElement("form");
			    $(form).attr("id", "reg-form").attr("name", "reg-form").attr("action", purl).attr("method", "post").attr("enctype", "multipart/form-data");
			    if (in_new_tab) {
			        $(form).attr("target", "_blank");
			    }
			    $.each(pparameters, function(key) {
			        $(form).append('<input type="text" name="' + key + '" value="' + this + '" />');
			    });
			    document.body.appendChild(form);
			    form.submit();
			    document.body.removeChild(form);

			    return false;
			}

			window.onload = function() {
				redirect_by_post('../Vista/formularioPagos', {'descripcion','PRUEBA'}, true);
			};
		</script>
	<?php
}else{
	echo "<script>alert('El contrato ocasional fue registrado correctamente.'); window.location.href='../Vista/contratosOcasionales.php';</script>";
}
*/

 ?>
