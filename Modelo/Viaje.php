<?php
require_once("Conexion/conexionBD.php");

class Viaje

{

	public function listarOrigenTodos(){		
		$listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM origen");
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                	
        	$listar[] = $filas;                
        }                
        return $listar;	
    }	

    public function listarOrigenActivos(){		
    	$listar = array();                
    	$con = Conexion::conectar();                
    	$sql = $con->prepare("SELECT * FROM origen WHERE estado = '1'");                
    	$sql->execute();                
    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                	
    		$listar[] = $filas;                
	   	}                
    	return $listar;	
    }	

    public function listarOrigenPorId($id){		
    	$listar = array();                
    	$con = Conexion::conectar();                
    	$sql = $con->prepare("SELECT * FROM origen WHERE id_origen = ?");		
    	$sql->bindParam(1, $id);                
    	$sql->execute();                
    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                	
    		$listar[] = $filas;                
	   	}                
	   	return $listar;	
    }

    public function buscarOrigenPorNombre($detalle){     
        $listar = array();                
        $con = Conexion::conectar();                
        $sql = $con->prepare("SELECT * FROM origen WHERE detalle = ?");       
        $sql->bindParam(1, $detalle);                
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
            $listar[] = $filas;                
        }                
        return $listar; 
    }

	public function registrarOrigen($detalle, $estado){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO origen (detalle, estado) VALUES (:detalle, :estado)");                
			$sql->bindParam(":detalle", $detalle);                
			$sql->bindParam(":estado", $estado);                
			$sql->execute();                
			return $id = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}        
	}

    public function actualizarOrigen($id, $detalle, $estado){            
    	try {                
    		$con = Conexion::conectar();                
    		$sql = $con->prepare("UPDATE origen SET detalle = :detalle, estado = :estado WHERE id_origen = :id");                
    		$sql->bindParam(":detalle", $detalle);                
    		$sql->bindParam(":estado", $estado);
            $sql->bindParam(":id", $id);
            $sql->execute();            
        } catch (Exception $e) {                
        	echo $e->getMessage();            
        }        
    }

    public function listarDestinoTodos(){		
		$listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM destino");
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                	
        	$listar[] = $filas;                
        }                
        return $listar;	
    }	

    public function listarDestinoActivos(){		
    	$listar = array();                
    	$con = Conexion::conectar();                
    	$sql = $con->prepare("SELECT * FROM destino WHERE estado = '1'");                
    	$sql->execute();                
    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                	
    		$listar[] = $filas;                
    	}                
    	return $listar;	
    }	

    public function listarDestinoPorId($id){		
    	$listar = array();                
    	$con = Conexion::conectar();                
    	$sql = $con->prepare("SELECT * FROM destino WHERE id_destino = ?");		
    	$sql->bindParam(1, $id);                
    	$sql->execute();                
    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                	
    		$listar[] = $filas;                
	   	}                
    	return $listar;	
    }

    public function buscarDestinoPorNombre($detalle){     
        $listar = array();                
        $con = Conexion::conectar();                
        $sql = $con->prepare("SELECT * FROM destino WHERE detalle = ?");       
        $sql->bindParam(1, $detalle);                
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
            $listar[] = $filas;                
        }                
        return $listar; 
    }

	public function registrarDestino($detalle, $estado){            
		try {                
			$con = Conexion::conectar();                
			$sql = $con->prepare("INSERT INTO destino (detalle, estado) VALUES (:detalle, :estado)");                
			$sql->bindParam(":detalle", $detalle);                
			$sql->bindParam(":estado", $estado);                
			$sql->execute();                
			return $id = $con->lastInsertId();            
		} catch (Exception $e) {                
			echo $e->getMessage();            
		}        
	}

    public function actualizarDestino($id, $detalle, $estado){            
    	try {                
    		$con = Conexion::conectar();                
    		$sql = $con->prepare("UPDATE destino SET detalle = :detalle, estado = :estado WHERE id_destino = :id");                
    		$sql->bindParam(":detalle", $detalle);                
    		$sql->bindParam(":estado", $estado);
            $sql->bindParam(":id", $id);
            $sql->execute();            
        } catch (Exception $e) {                
        	echo $e->getMessage();            
        }        
    }

    public function buscarReservasActivasUsuario($usuario){     
        $listar = array();                
        $con = Conexion::conectar();                
        $sql = $con->prepare("SELECT * FROM sillas_viaje WHERE id_pasajero = ? and estado_reserva = 'A'");       
        $sql->bindParam(1, $usuario);                
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
            $listar[] = $filas;                
        }                
        return $listar; 
    }

    public function listarViajesDisponible($ruta,$fecha){
        $listar = array();                
        $con = Conexion::conectar();                
        $sql = $con->prepare("SELECT * FROM viaje WHERE fecha = ? and id_ruta = ? order by hora Asc");       
        $sql->bindParam(1, $fecha);
        $sql->bindParam(2, $ruta);                
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
            $listar[] = $filas;                
        }                
        return $listar;
    }

	public function listarViajePorId($id){
        $listar = array();                
        $con = Conexion::conectar();                
        $sql = $con->prepare("SELECT * FROM viaje WHERE id_viaje = ?");       
        $sql->bindParam(1, $id);
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
            $listar[] = $filas;                
        }                
        return $listar;
    }

	public function listarSillasViajePorId($id){
		$listar = array();                
        $con = Conexion::conectar();                
        $sql = $con->prepare("SELECT * FROM sillas_viaje WHERE id_viaje = ?");       
        $sql->bindParam(1, $id);
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
	        $listar[] = $filas;                
        }                
        return $listar;
	}

	public function listarOpcionSillaPorId($id){
		$listar = array();                
        $con = Conexion::conectar();                
        $sql = $con->prepare("SELECT * FROM sillas_viaje WHERE id = ? and estado = 'D'");       
        $sql->bindParam(1, $id);
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
            $listar[] = $filas;                
        }            
        //echo "SELECT * FROM sillas_viaje WHERE id = '$id' and estado = 'D'";
        return $listar;
	}

    public function listarOpcionPorId($id){
        $listar = array();                
        $con = Conexion::conectar();                
        $sql = $con->prepare("SELECT * FROM sillas_viaje WHERE id = ?");       
        $sql->bindParam(1, $id);
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
            $listar[] = $filas;                
        }            
        //echo "SELECT * FROM sillas_viaje WHERE id = '$id'";
        return $listar;
    }

	
	public function buscarEstadoSilla($id_viaje,$silla){
		$listar = array();                
        $con = Conexion::conectar();                
        $sql = $con->prepare("SELECT * FROM sillas_viaje WHERE id_viaje = ? and numero_silla = ?");       
        $sql->bindParam(1, $id_viaje);
        $sql->bindParam(2, $silla);   
        $sql->execute();                
        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
            $listar[] = $filas;                
        }                
        return $listar;
	}


	public function reservarSilla($id,$pasajero,$estado,$fecha){            
    	try {              
    		$con = Conexion::conectar();                
    		$sql = $con->prepare("UPDATE sillas_viaje SET estado = 'O', id_pasajero = :pasajero, estado_reserva = :estado, fecha_reserva = :fecha WHERE id = :id");    
    		$sql->bindParam(":pasajero", $pasajero);                
    		$sql->bindParam(":estado", $estado);
			$sql->bindParam(":fecha", $fecha);
            $sql->bindParam(":id", $id);
            $sql->execute();            
        } catch (Exception $e) {                
        	echo $e->getMessage();            
        }        
    }
}
?>