<?php
require_once("Conexion/conexionBD.php");
class CargoCliente
{

	public function listarCargos(){
		$listar = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM cargo_cliente");
                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                	$listar[] = $filas;
                }

                return $listar;
	}

    public function listarCargosPorId($id_cargo){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM cargo_cliente WHERE id_cargo = ?");
            $sql->bindParam(1, $id_cargo);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }	public function listarCargosPorCliente($id_cliente){        $listar = array();            $con = Conexion::conectar();            $sql = $con->prepare("SELECT * FROM cargo_cliente WHERE id_cliente = ?");            $sql->bindParam(1, $id_cliente);            $sql->execute();            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {                    $listar[] = $filas;            }        return $listar;    }

        public function registrarCargos($nombre_cargo, $id_cliente){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO cargo_cliente (detalle, id_cliente) VALUES(:nombre_cargo, :id_cliente)");
                $sql->bindParam(":nombre_cargo", $nombre_cargo);
                $sql->bindParam(":id_cliente", $id_cliente);

                $sql->execute();
                
                return $id_cargo = $con->lastInsertId();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
                
        }

        public function actualizarCargos($id_cargo, $nombre_cargo, $id_cliente){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE cargo_cliente SET detalle = '$nombre_cargo', id_cliente = '$id_cliente' WHERE id_cargo = '$id_cargo' ");
                $sql->bindParam(":nombre_cargo", $nombre_cargo);
                $sql->bindParam(":id_cliente", $id_cliente);
                $sql->bindParam(":id_cargo", $id_cargo);

                $sql->execute();
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }
               
        }
	
}

 ?>