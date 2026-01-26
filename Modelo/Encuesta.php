<?php
require_once("Conexion/conexionBD.php");
class Encuesta{	

	public function listar(){		
		$listar = array();                
		$con = Conexion::conectar();                
		$sql = $con->prepare("SELECT * FROM encuesta");                
		$sql->execute();                
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                	
			$listar[] = $filas;                
		}                
		return $listar;	
	}
    
	public function listarTipos(){				
		$listar = array();                		
		$con = Conexion::conectar();                		
		$sql = $con->prepare("SELECT * FROM tipo_encuesta");                		
		$sql->execute();                		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                				
			$listar[] = $filas;                		
		}                		
		return $listar;		
	}

	public function listarTiposPregunta(){				
		$listar = array();                		
		$con = Conexion::conectar();                		
		$sql = $con->prepare("SELECT * FROM tipo_pregunta");                		
		$sql->execute();                		
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                				
			$listar[] = $filas;                		
		}                		
		return $listar;		
	}
 
	public function listarPorId($id){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta WHERE id_encuesta = ?");            
		$sql->bindParam(1, $id);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}
	
	public function listarPreguntaPorId($id){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta_pregunta WHERE id_pregunta = ?");            
		$sql->bindParam(1, $id);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}
	
	public function listarRespuestaPorId($id){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta_respuesta WHERE id_respuesta = ?");            
		$sql->bindParam(1, $id);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}
	
	public function preguntasFiltroMenor($encuesta,$min,$max){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta_pregunta WHERE id_encuesta = ? and (orden >= ? and orden < ?)");            
		$sql->bindParam(1, $encuesta);
		$sql->bindParam(2, $min);
		$sql->bindParam(3, $max);
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}
	
	public function preguntasFiltroMayor($encuesta,$min,$max){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta_pregunta WHERE id_encuesta = ? and (orden > ? and orden <= ?)");
		$sql->bindParam(1, $encuesta);
		$sql->bindParam(2, $min);
		$sql->bindParam(3, $max);
		$sql->execute();            
		echo "SELECT * FROM encuesta_pregunta WHERE id_encuesta = '$encuesta' and (orden > '$min' and orden <= '$max')";
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}
	
	public function respuestasFiltroMenor($pregunta,$min,$max){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta_respuesta WHERE id_pregunta = ? and (orden >= ? and orden < ?)");            
		$sql->bindParam(1, $pregunta);
		$sql->bindParam(2, $min);
		$sql->bindParam(3, $max);
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}
	
	public function respuestasFiltroMayor($pregunta,$min,$max){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta_respuesta WHERE id_pregunta = ? and (orden > ? and orden <= ?)");
		$sql->bindParam(1, $pregunta);
		$sql->bindParam(2, $min);
		$sql->bindParam(3, $max);
		$sql->execute();            
		echo "SELECT * FROM encuesta_pregunta WHERE id_encuesta = '$encuesta' and (orden > '$min' and orden <= '$max')";
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}
	
	public function actualizarPosicion($id, $posicion){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE encuesta_pregunta SET orden = :posicion WHERE id_pregunta = :id ");
			$sql->bindParam(":posicion", $posicion);               
			$sql->bindParam(":id", $id);                
			$sql->execute();                            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                       
	}
	
	public function actualizarPosicionRespuesta($id, $posicion){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE encuesta_respuesta SET orden = :posicion WHERE id_respuesta = :id ");
			$sql->bindParam(":posicion", $posicion);               
			$sql->bindParam(":id", $id);                
			$sql->execute();                            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                       
	}
	
	public function listarPorTipoPregunta($id){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM tipo_pregunta WHERE id_tipo_pregunta = ?");            
		$sql->bindParam(1, $id);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}

	public function listarPreguntasPorIdEncuesta($id){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta_pregunta WHERE id_encuesta = ?");            
		$sql->bindParam(1, $id);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}  
	
	public function listarRespuestasPorIdPregunta($id){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta_respuesta WHERE id_pregunta = ?");            
		$sql->bindParam(1, $id);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}  

	public function listarRespuestasPorPregunta($id){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM encuesta_respuesta WHERE id_pregunta = ?");            
		$sql->bindParam(1, $id);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}      

	public function registrar($nombre, $descripcion, $id_tipo_encuesta, $estado, $fecha){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO encuesta (nombre_encuesta, descripcion, id_tipo_encuesta, estado, fecha) VALUES(:nombre, :descripcion, :id_tipo_encuesta, :estado, :fecha)");                
			$sql->bindParam(":nombre", $nombre);                
			$sql->bindParam(":descripcion", $descripcion);                
			$sql->bindParam(":id_tipo_encuesta", $id_tipo_encuesta);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":fecha", $fecha);               
			$sql->execute();                                
			return $id = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	}   

	public function registrarPregunta($tipo, $pregunta, $orden, $id_encuesta){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO encuesta_pregunta (id_tipo_pregunta, detalle, orden, id_encuesta) VALUES(:tipo, :pregunta, :orden, :id_encuesta)");
			$sql->bindParam(":tipo", $tipo);                
			$sql->bindParam(":pregunta", $pregunta);
			$sql->bindParam(":orden", $orden);
			$sql->bindParam(":id_encuesta", $id_encuesta);               
			$sql->execute();                                
			return $id = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	} 
	
	public function registrarRespuesta($respuesta, $id_pregunta, $ampliacion, $orden){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO encuesta_respuesta (detalle, id_pregunta, ampliacion, orden) VALUES(:respuesta, :id_pregunta, :ampliacion, :orden)");
			$sql->bindParam(":respuesta", $respuesta);                
			$sql->bindParam(":id_pregunta", $id_pregunta);
			$sql->bindParam(":ampliacion", $ampliacion);
			$sql->bindParam(":orden", $orden);               
			$sql->execute();               
			//echo "INSERT INTO encuesta_respuesta (detalle, id_pregunta, ampliacion, orden) VALUES('$respuesta', '$id_pregunta', '$ampliacion', '$orden')";
			return $id = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	} 
	
	public function registrarRespuestaUsuario($encuesta, $pregunta, $respuesta, $ampliacion, $tipo_usuario, $usuario, $fecha){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO encuesta_diligenciada (id_encuesta, id_pregunta, id_respuesta, ampliacion, tipo_usuario, id_usuario, fecha) VALUES(:encuesta, :pregunta, :respuesta, :ampliacion, :tipo_usuario, :usuario, :fecha)");
			$sql->bindParam(":encuesta", $encuesta);
			$sql->bindParam(":pregunta", $pregunta);
			$sql->bindParam(":respuesta", $respuesta);                
			$sql->bindParam(":ampliacion", $ampliacion);
			$sql->bindParam(":tipo_usuario", $tipo_usuario);      
			$sql->bindParam(":usuario", $usuario);
			$sql->bindParam(":fecha", $fecha);
			$sql->execute();               
			return $id = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	} 

	public function actualizarPregunta($id, $tipo, $pregunta, $orden, $id_encuesta){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE encuesta_pregunta SET id_tipo_pregunta = :tipo, detalle = :pregunta, orden = :orden, id_encuesta = :id_encuesta WHERE id_pregunta = :id");
			$sql->bindParam(":tipo", $tipo);                
			$sql->bindParam(":pregunta", $pregunta);
			$sql->bindParam(":orden", $orden);
			$sql->bindParam(":id_encuesta", $id_encuesta);
			$sql->bindParam(":id", $id);            
			$sql->execute();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	} 
	
	public function actualizarRespuesta($id, $respuesta, $id_pregunta, $ampliacion, $orden){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE encuesta_respuesta SET detalle = :respuesta, id_pregunta = :id_pregunta, ampliacion = :ampliacion, orden = :orden WHERE id_respuesta = :id");               
			$sql->bindParam(":respuesta", $respuesta);
			$sql->bindParam(":id_pregunta", $id_pregunta);
			$sql->bindParam(":ampliacion", $ampliacion);
			$sql->bindParam(":orden", $orden);
			$sql->bindParam(":id", $id);            
			$sql->execute();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                        
	} 

	public function actualizar($id, $nombre, $descripcion, $id_tipo_encuesta, $estado, $fecha){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE encuesta SET nombre_encuesta = :nombre, descripcion = :descripcion, id_tipo_encuesta = :id_tipo_encuesta, estado = :estado, fecha = :fecha WHERE id_encuesta = :id ");
			$sql->bindParam(":nombre", $nombre);                
			$sql->bindParam(":descripcion", $descripcion);                
			$sql->bindParam(":id_tipo_encuesta", $id_tipo_encuesta);
			$sql->bindParam(":estado", $estado);
			$sql->bindParam(":fecha", $fecha);                
			$sql->bindParam(":id", $id);                
			$sql->execute();                            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                       
	}

	public function cambiarEstadoEncuesta($id, $estado){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("UPDATE encuesta SET estado = :estado WHERE id_encuesta = :id ");
			$sql->bindParam(":estado", $estado);               
			$sql->bindParam(":id", $id);                
			$sql->execute();                            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}                       
	}	

}
?>