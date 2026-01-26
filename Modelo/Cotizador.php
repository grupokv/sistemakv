<?php 
require_once("Conexion/conexionBD.php");

class Cotizador
{

	public function listarDestinos(){
		$listar = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM cotizacion_destino");
                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                	$listar[] = $filas;
                }
		return $listar;
	}

    public function listarTipoVehiculo(){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM cotizacion_concepto_vehiculo");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }

    public function listarDatosGenerales(){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM cotizacion_concepto_general");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }
    
    public function listarCostoConductor(){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM cotizacion_costo_conductor");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }
	
    public function listarDestinoPorId($id){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM cotizacion_destino WHERE id_destino = ?");
            $sql->bindParam(1, $id);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }

    public function listarTipoPorId($id){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM cotizacion_concepto_vehiculo WHERE id = ?");
            $sql->bindParam(1, $id);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }

    public function listarCostoConductorPorId($id){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM cotizacion_costo_conductor WHERE id_costo_conductor = ?");
	    $sql->bindParam(1, $id);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }
	
    public function actualizarConceptosGenerales($id, $galon, $alimentacion, $hospedaje, $utilidad){
     try {
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizacion_concepto_general SET galon_combustible = :galon, alimentacion_dia = :alimentacion, hospedaje_dia = :hospedaje, porc_pernotado = :utilidad WHERE id = :id ");
        $sql->bindParam(":galon", $galon);
        $sql->bindParam(":alimentacion", $alimentacion);
        $sql->bindParam(":hospedaje", $hospedaje);
	$sql->bindParam(":utilidad", $utilidad);
	$sql->bindParam(":id", $id);

        $sql->execute();
        
     } catch (Exception $e) {
         echo $e->getMessage();
     }
  }

	public function actualizarConceptosVehiculo($id, $tipo, $rendimiento, $peaje, $parqueadero, $lavado){
     try {
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizacion_concepto_vehiculo SET tipo_vehiculo = :tipo, rendimiento_kms = :rendimiento, valor_peaje = :peaje, valor_parqueadero = :parqueadero, valor_lavado = :lavado WHERE id = :id ");
        $sql->bindParam(":tipo", $tipo);
        $sql->bindParam(":rendimiento", $rendimiento);
        $sql->bindParam(":peaje", $peaje);
	$sql->bindParam(":parqueadero", $parqueadero);
	$sql->bindParam(":lavado", $lavado);
	$sql->bindParam(":id", $id);

        $sql->execute();
        
     } catch (Exception $e) {
         echo $e->getMessage();
     }
  }

	public function actualizarDestino($id, $ciudad, $departamento, $dias, $kilometraje, $kms, $peajes, $peaje_campero, $valor_campero, $peaje_doblecabina, $valor_doblecabina, $peaje_van, $valor_van, $peaje_microbus, $valor_microbus, $peaje_buseta, $valor_buseta, $peaje_buseton, $valor_buseton, $peaje_bus, $valor_bus){
     try {
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE cotizacion_destino SET ciudad = :ciudad, departamento = :departamento, dias = :dias, kilometros = :kilometraje, kms_ida_retorno = :kms, total_peaje_viaje = :peajes, peaje_campero = :peaje_campero, valor_campero = :valor_campero, peaje_doblecabina = :peaje_doblecabina, valor_doblecabina = :valor_doblecabina, peaje_van = :peaje_van, valor_van = :valor_van, peaje_microbus = :peaje_microbus, valor_microbus = :valor_microbus, peaje_buseta = :peaje_buseta, valor_buseta = :valor_buseta, peaje_buseton = :peaje_buseton, valor_buseton = :valor_buseton, peaje_bus = :peaje_bus, valor_bus = :valor_bus WHERE id_destino = :id ");
        $sql->bindParam(":ciudad", $ciudad);
        $sql->bindParam(":departamento", $departamento);
        $sql->bindParam(":dias", $dias);
	$sql->bindParam(":kilometraje", $kilometraje);
	$sql->bindParam(":kms", $kms);
	$sql->bindParam(":peajes", $peajes);
	$sql->bindParam(":peaje_campero", $peaje_campero);
	$sql->bindParam(":valor_campero", $valor_campero);
	$sql->bindParam(":peaje_doblecabina", $peaje_doblecabina);
	$sql->bindParam(":valor_doblecabina", $valor_doblecabina);
	$sql->bindParam(":peaje_van", $peaje_van);
	$sql->bindParam(":valor_van", $valor_van);
	$sql->bindParam(":peaje_microbus", $peaje_microbus);
	$sql->bindParam(":valor_microbus", $valor_microbus);
	$sql->bindParam(":peaje_buseta", $peaje_buseta);
	$sql->bindParam(":valor_buseta", $valor_buseta);
	$sql->bindParam(":peaje_buseton", $peaje_buseton);
	$sql->bindParam(":valor_buseton", $valor_buseton);
	$sql->bindParam(":peaje_bus", $peaje_bus);
	$sql->bindParam(":valor_bus", $valor_bus);
	$sql->bindParam(":id", $id);

        $sql->execute();
        
     } catch (Exception $e) {
         echo $e->getMessage();
     }
  }

	public function registrarDestino($ciudad, $departamento, $dias, $kilometraje, $kms, $peajes, $peaje_campero, $valor_campero, $peaje_doblecabina, $valor_doblecabina, $peaje_van, $valor_van, $peaje_microbus, $valor_microbus, $peaje_buseta, $valor_buseta, $peaje_buseton, $valor_buseton, $peaje_bus, $valor_bus){
     try {
        $con = Conexion::conectar();
        $sql = $con->prepare("INSERT INTO cotizacion_destino (ciudad, departamento, dias, kilometros, kms_ida_retorno, total_peaje_viaje, peaje_campero, valor_campero, peaje_doblecabina, valor_doblecabina, peaje_van, valor_van, peaje_microbus, valor_microbus, peaje_buseta, valor_buseta, peaje_buseton, valor_buseton, peaje_bus, valor_bus) VALUES (:ciudad, :departamento, :dias, :kilometraje, :kms, :peajes, :peaje_campero, :valor_campero, :peaje_doblecabina, :valor_doblecabina, :peaje_van, :valor_van, :peaje_microbus, :valor_microbus, :peaje_buseta, :valor_buseta, :peaje_buseton, :valor_buseton, :peaje_bus, :valor_bus)");
        $sql->bindParam(":ciudad", $ciudad);
        $sql->bindParam(":departamento", $departamento);
        $sql->bindParam(":dias", $dias);
	$sql->bindParam(":kilometraje", $kilometraje);
	$sql->bindParam(":kms", $kms);
	$sql->bindParam(":peajes", $peajes);
	$sql->bindParam(":peaje_campero", $peaje_campero);
	$sql->bindParam(":valor_campero", $valor_campero);
	$sql->bindParam(":peaje_doblecabina", $peaje_doblecabina);
	$sql->bindParam(":valor_doblecabina", $valor_doblecabina);
	$sql->bindParam(":peaje_van", $peaje_van);
	$sql->bindParam(":valor_van", $valor_van);
	$sql->bindParam(":peaje_microbus", $peaje_microbus);
	$sql->bindParam(":valor_microbus", $valor_microbus);
	$sql->bindParam(":peaje_buseta", $peaje_buseta);
	$sql->bindParam(":valor_buseta", $valor_buseta);
	$sql->bindParam(":peaje_buseton", $peaje_buseton);
	$sql->bindParam(":valor_buseton", $valor_buseton);
	$sql->bindParam(":peaje_bus", $peaje_bus);
	$sql->bindParam(":valor_bus", $valor_bus);

	//echo "INSERT INTO cotizacion_destino (ciudad, departamento, dias, kilometros, kms_ida_retorno, total_peaje_viaje, peaje_campero, valor_campero, peaje_doblecabina, valor_doblecabina, peaje_van, valor_van, peaje_microbus, valor_microbus, peaje_buseta, valor_buseta, peaje_buseton, valor_buseton, peaje_bus, valor_bus) VALUES ('$ciudad', '$departamento', '$dias', '$kilometraje', '$kms', '$peajes', '$peaje_campero', '$valor_campero', '$peaje_doblecabina', '$valor_doblecabina', '$peaje_van', '$valor_van', '$peaje_microbus', '$valor_microbus', '$peaje_buseta', '$valor_buseta', '$peaje_buseton', '$valor_buseton', '$peaje_bus', '$valor_bus')";

        $sql->execute();
        
     } catch (Exception $e) {
         echo $e->getMessage();
     }
  }

	public function borrarDestino($id){
     try {
        $con = Conexion::conectar();
        $sql = $con->prepare("DELETE FROM cotizacion_destino WHERE id_destino = :id ");
	$sql->bindParam(":id", $id);

        $sql->execute();
        
     } catch (Exception $e) {
         echo $e->getMessage();
     }
  }

}

?>