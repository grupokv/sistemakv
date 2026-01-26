<?php
if($_FILES['archivo']['tmp_name'] != ''){
		$ruta = $_POST['ruta'];
		$dir = $ruta.$_FILES['archivo']['name'];
	if (move_uploaded_file($_FILES['archivo']['tmp_name'], $dir)) {
	    echo "El fichero es válido y se subió con éxito.\n";
	} else {
	    echo "¡Posible ataque de subida de ficheros!\n";
	}
}
?>
<form method="POST" action="cargar_archivo_ruta.php" enctype="multipart/form-data">
	<input type="text" name="ruta" id="ruta" required="required"/><br/>
	<input type="file" name="archivo" id="archivo" required="required"/><br/>
	<input type="submit" value="Cargar Archivo"/>
</form>