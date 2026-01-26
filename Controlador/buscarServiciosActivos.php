<?php session_start();
require_once("../Modelo/Vehiculo.php");
$vehiculo = new Vehiculo();
$serv = $vehiculo->buscarRuta($_SESSION['id_usuario'],$_SESSION['id_cliente']);
if(count($serv) > 0){   
	$pasajeros = $vehiculo->buscarPasajerosRuta($serv[0]['id']);      
	if(count($pasajeros) < 1){	
		echo ("<script LANGUAGE='JavaScript'>    	
		window.alert('La ruta no tiene pasajeros asignados');    	
		window.location.href='../Vista/inicioCliente.php';    	
		</script>");   
	} else {	
		$hoy = date('Y-m-d');	
		$activos = $vehiculo->buscarActivos($serv[0]['id'],$hoy);	
		if(count($activos) < 1){		
			echo ("<script LANGUAGE='JavaScript'>    		
			var r = confirm('Desea iniciar la ruta de hoy?');		
			if(r == true){			
				window.location.href='../Controlador/iniciar_recorrido.php?id=".$serv[0]['id']."';		
			} else {			
				window.location.href='../Vista/inicioCliente.php';		
			}    	
			</script>");	
		} else {		
			echo ("<script LANGUAGE='JavaScript'>    		    		
			window.location.href='../Vista/recogida_pasajeros.php?id=".$activos[0]['id_recorrido']."';    		
			</script>");	
		}
	}	   
} else {    
echo ("<script LANGUAGE='JavaScript'>    
window.alert('No tiene rutas asignadas');    
window.location.href='../Vista/inicioCliente.php';    
</script>");
}
?>