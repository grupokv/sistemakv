<?php
if($_FILES['archivo']['tmp_name'] != ''){
	if (move_uploaded_file($_FILES['archivo']['tmp_name'], $_FILES['archivo']['name'])) {
	    echo "El fichero es válido y se subió con éxito.\n";
	} else {
	    echo "¡Posible ataque de subida de ficheros!\n";
	}
}
?>
<form method="POST" action="cargar_archivo.php" enctype="multipart/form-data">
	<input type="file" name="archivo" id="archivo" required="required"/><br/>
	<input type="submit" value="Cargar Archivo"/>
</form>