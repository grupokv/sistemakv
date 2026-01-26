<?php 
require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Vehiculo_Contrato
{
	public function registrar($id_vehiculo, $id_contrato, $tipo_contrato){
			try {

				$con = Conexion::conectar();
			    $sql = $con->prepare("INSERT INTO vehiculos_contratos(id_vehiculo, id_contrato, tipo_contrato) VALUES (:id_vehiculo, :id_contrato, :tipo_contrato)");
			    $sql->bindParam(":id_vehiculo", $id_vehiculo);
			    $sql->bindParam(":id_contrato", $id_contrato);
                $sql->bindParam(":tipo_contrato", $tipo_contrato);

			    $sql->execute();
         
                //echo "INSERT INTO vehiculos_contratos(id_vehiculo, id_contrato, tipo_contrato) VALUES ('$id_vehiculo', '$id_contrato', '$tipo_contrato')";       

			} catch (Exception $e) {
				echo $e->getMessage();
			}
	}

    public function listarVehiculosPorContratoBaseApoyo($id_contrato){
        $ContratoBaseApoyo = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT DISTINCT(id_vehiculo), id_contrato, tipo_contrato FROM vehiculos_contratos WHERE id_contrato IN(:id_contrato)");
        $sql->bindParam(":id_contrato", $id_contrato);
        $sql->execute();

        //echo "SELECT DISTINCT(id_vehiculo), tipo_contrato FROM vehiculos_contratos WHERE id_contrato IN ('$id_contrato')";

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $ContratoBaseApoyo[] = $filas;
        }

        return $ContratoBaseApoyo;
    }
	
	public function listarVehiculosPorContratos($contratos){
        $ContratoBaseApoyo = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT DISTINCT(id_vehiculo) FROM vehiculos_contratos WHERE id_contrato IN(:contratos) and id_vehiculo != 0");
        $sql->bindParam(":contratos", $contratos);
        $sql->execute();

        //echo "SELECT DISTINCT(id_vehiculo) FROM vehiculos_contratos WHERE id_contrato IN ($contratos)";

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $ContratoBaseApoyo[] = $filas;
        }

        return $ContratoBaseApoyo;
    }

	public function listarPorContrato($id_contrato){
        $contratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON vc.id_vehiculo = v.id_vehiculo WHERE id_contrato = :id_contrato ORDER BY v.placa ASC");
        $sql->bindParam(":id_contrato", $id_contrato);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$contratos[] = $filas;
        }

        return $contratos;
	}

    
	public function listarPorVehiculo($id_vehiculo){
        $contratosVehiculos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM vehiculos_contratos WHERE id_vehiculo = :id_vehiculo");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$contratosVehiculos[] = $filas;
        }

        return $contratosVehiculos;
	}


    public function listarPorTipoContrato($id_contrato, $tipo_contrato){
        $tipoContratos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM vehiculos_contratos AS vc INNER JOIN vehiculos AS v ON vc.id_vehiculo = v.id_vehiculo WHERE id_contrato = :id_contrato AND tipo_contrato = :tipo_contrato ORDER BY v.placa ASC");
        $sql->bindParam(":id_contrato", $id_contrato);
        $sql->bindParam(":tipo_contrato", $tipo_contrato);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $tipoContratos[] = $filas;
        }

        return $tipoContratos;
    }

	public function actualizarContratoPorVehiculo($id, $id_vehiculo,$id_contrato, $tipo_contrato){
        $contratosPorV = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE vehiculos_contratos SET id_vehiculo = :id_vehiculo, id_contrato = :id_contrato, tipo_contrato = :tipo_contrato WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":id_contrato", $id_contrato);
        $sql->bindParam(":tipo_contrato", $tipo_contrato);
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        $sql->execute();


        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$contratosPorV[] = $filas;
        }

        return $contratosPorV;
	}

    public function listarContratosBase($id_vehiculo){
        $cBase = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM vehiculos_contratos WHERE id_vehiculo = :id_vehiculo AND tipo_contrato = 'BASE' order by id_contrato Desc");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        $sql->execute();
        //echo "SELECT * FROM vehiculos_contratos WHERE id_vehiculo = '$id_vehiculo' AND tipo_contrato = 'BASE' ";
        

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $cBase[] = $filas;
        }

        return $cBase;
    }

    public function listarContratosApoyo($id_vehiculo){
        $cApoyo = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM vehiculos_contratos WHERE id_vehiculo = :id_vehiculo AND tipo_contrato = 'APOYO' ");
        $sql->bindParam(":id_vehiculo", $id_vehiculo);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $cApoyo[] = $filas;
        }

        return $cApoyo;
    }

    public function eliminarContratosApoyoPorVehiculo($id_vehiculo){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("DELETE FROM vehiculos_contratos WHERE id_vehiculo = :id_vehiculo AND tipo_contrato = 'APOYO' ");
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function eliminarContratosBasePorVehiculo($id_vehiculo){
        try {
            $con = Conexion::conectar();
            $sql = $con->prepare("DELETE FROM vehiculos_contratos WHERE id_vehiculo = :id_vehiculo AND tipo_contrato = 'BASE' ");
            $sql->bindParam(":id_vehiculo", $id_vehiculo);
            $sql->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


}
 ?>