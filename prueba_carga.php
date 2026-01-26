<?php
error_reporting(E_ALL); 

$carpeta = 'D:\sistemakv\Documentos\Vehiculos'; 
if ($gestor = opendir($carpeta)) { 
    while (false !== ($archivo = readdir($gestor))) { 
        if ($archivo != "." && $archivo != "..") { 
            echo "$archivo\n"; 
        } 
    } 
    closedir($gestor); 
} 

if($_POST){
	
	if($_FILES["imagen"]["tmp_name"] != "")
	{
		$fecha = date('YmdHis');
		$namet = $_FILES['imagen']['tmp_name'];
		$carpetaimg = 'D:\sistemakv\Documentos\Vehiculos';
		$namef = $fecha.'-'.$_FILES["imagen"]["name"];
		$ruta = $carpetaimg.'/'.$namef;
		agregar_documento($namet,$ruta);
				
		echo ("<SCRIPT LANGUAGE='JavaScript'>
		alert('Imagen Agregada Correctamente');
		window.location.href='prueba_carga.php';
		</SCRIPT>");
	
	} else {
	
		echo ("<SCRIPT LANGUAGE='JavaScript'>
		alert('La Imagen Es Obligatoria');
		window.location.href='prueba_carga.php';
		</SCRIPT>");
	
	}
	
	
}

?>
<!DOCTYPE html>
<html lang="es">

    <body>
        
		
		<div id="body-container">
            <div id="body-content">
                
                
       
        <section id="my-account-security-form" class="page container">
            <form id="userSecurityForm" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="container">
					
					<div class="row">
                        <div class="span16">
                        <div class="box pattern pattern-sandstone">
                            <div class="box-header">
                                <i class="icon-list-alt"></i>
                                <h5>
                                    Nuevo Cliente
                                </h5>
                            </div>
							
                            <div id="acct-password-row" class="span7">
                            <fieldset>
								
								<div class="control-group ">
                                    <label class="control-label">Imagen<span class="required">*</span></label>
                                    <div class="controls">
                                        <input name="imagen" id="imagen" class="span11" type="file" required>
									</div>
								</div>
								
                            </fieldset>
                        </div>
							
                        </div>
						
                    </div>
                    </div>
					
					<footer id="submit-actions" class="form-actions">
                        <button id="submit-button" type="submit" class="btn btn-primary" name="action" value="CONFIRM">Guardar</button>
                        <a href="cliente.php">
							<button type="button" class="btn" name="action" value="CANCEL">Cancelar</button>
						</a>
                    </footer>
                </div>
            </form>
        </section>
    
            </div>
        </div>
		
	
	</body>
</html>
<?php
function agregar_documento($nombretemp,$rutafinal)	{
	if (isset($nombretemp))	{
		copy($nombretemp,$rutafinal);
	}
}
?>