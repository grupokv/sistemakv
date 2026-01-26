<?php
require_once("Conexion/conexionBD.php");
class CentroCostoCliente
{

	public function listar(){
		$listar = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM centro_costo_cliente");
                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                	$listar[] = $filas;
                }

                return $listar;
	}

    public function listarPorId($id){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM centro_costo_cliente WHERE id_centro_costo = ?");
            $sql->bindParam(1, $id);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }	


	public function listarPorCliente($id_cliente){        
		$listar = array();            
		$con = Conexion::conectar();            
		$sql = $con->prepare("SELECT * FROM centro_costo_cliente WHERE id_cliente = ?");            
		$sql->bindParam(1, $id_cliente);            
		$sql->execute();            
		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    
			$listar[] = $filas;            
		}        
		return $listar;    
	}

        public function registrar($nombre, $id_cliente){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO centro_costo_cliente (detalle, id_cliente) VALUES(:nombre, :id_cliente)");
                $sql->bindParam(":nombre", $nombre);
                $sql->bindParam(":id_cliente", $id_cliente);

                $sql->execute();
                
                return $id_cargo = $con->lastInsertId();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
                
        }

        public function actualizar($id, $nombre, $id_cliente){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE centro_costo_cliente SET detalle = '$nombre', id_cliente = '$id_cliente' WHERE id_centro_costo = '$id' ");
                $sql->bindParam(":nombre", $nombre);
                $sql->bindParam(":id_cliente", $id_cliente);
                $sql->bindParam(":id", $id);

                $sql->execute();
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }
               
        }
	
}

 ?>