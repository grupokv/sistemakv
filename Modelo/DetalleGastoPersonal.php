<?php 

require_once 'Conexion/conexionBD.php';

class DetalleGastoPersonal
{
	
	public function listar(){
		$listarTodos = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT * FROM detalle_gastos_personales');
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarTodos[] = $filas;
		}

		return $listarTodos;
	}

	public function listarDGPorId($id_detalle_gasto){
		$listarId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT * FROM detalle_gastos_personales WHERE id_detalle_gasto = :id_detalle_gasto');
		$sql->bindParam(":id_detalle_gasto", $id_detalle_gasto);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarId[] = $filas;
		}

		return $listarId;
	}

	public function listarDGFinalizados(){
		$listarF = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT * FROM detalle_gastos_personales WHERE estado = 0');
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarF[] = $filas;
		}

		return $listarF;
	}

	public function listarDGFinalizadosPDF($fecha_inicio, $fecha_final){
		$listarFPDF = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT * FROM detalle_gastos_personales WHERE fecha_detalle >= :fecha_inicio AND fecha_detalle <= :fecha_final AND estado = 0');
        $sql->bindParam(":fecha_inicio", $fecha_inicio);
        $sql->bindParam(":fecha_final", $fecha_final);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$listarFPDF[] = $filas;
		}

		return $listarFPDF;
	}

	public function filtrarDG($fecha_inicio, $fecha_final){
		$filtrar = array();
		$con = Conexion::conectar();
		$sql = $con->prepare('SELECT * FROM detalle_gastos_personales WHERE fecha_detalle >= :fecha_inicio AND fecha_detalle <= :fecha_final AND estado = 1');
		$sql->bindParam(":fecha_inicio", $fecha_inicio);
        $sql->bindParam(":fecha_final", $fecha_final);
		
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$filtrar[] = $filas;
		}

		return $filtrar;
	}

	public function registrarDG($descripcion, $nombre_persona, $fecha_detalle, $precio){

		try {
			
			$con = Conexion::conectar();
			$sql = $con->prepare('INSERT INTO detalle_gastos_personales(descripcion, nombre_persona, fecha_detalle, precio, estado) VALUES(:descripcion, :nombre_persona, :fecha_detalle, :precio, 1)');
			$sql->bindParam(':descripcion', $descripcion);
			$sql->bindParam(':nombre_persona', $nombre_persona);
			$sql->bindParam(':fecha_detalle', $fecha_detalle);
			$sql->bindParam(':precio', $precio);

			$sql->execute();

		} catch (Exception $e) {
			echo $e->getMessage();	
		}

	}

	public function actualizarDG($id_detalle_gasto, $descripcion, $nombre_persona, $fecha_detalle, $precio, $estado){

		try {
			
			$con = Conexion::conectar();
			$sql = $con->prepare('UPDATE detalle_gastos_personales SET descripcion = :descripcion, nombre_persona = :nombre_persona, fecha_detalle = :fecha_detalle, precio = :precio, estado = :estado WHERE id_detalle_gasto = :id_detalle_gasto');
			$sql->bindParam(':id_detalle_gasto', $id_detalle_gasto);
			$sql->bindParam(':descripcion', $descripcion);
			$sql->bindParam(':nombre_persona', $nombre_persona);
			$sql->bindParam(':fecha_detalle', $fecha_detalle);
			$sql->bindParam(':precio', $precio);
			$sql->bindParam(':estado', $estado);

			$sql->execute();
/*
			echo "UPDATE detalle_gastos_personales SET descripcion = '$descripcion', nombre_persona = '$nombre_persona', fecha_detalle = '$fecha_detalle', precio = '$precio', estado = '$estado' WHERE id_detalle_gasto = '$id_detalle_gasto'";
*/
		} catch (Exception $e) {
			echo $e->getMessage();	
		}

	}

	public function culminarDG($novedad_finalizacion, $id_detalle_gasto){

		try {
			$con = Conexion::conectar();
			$sql = $con->prepare('UPDATE detalle_gastos_personales SET estado = 0, novedad_finalizacion = :novedad_finalizacion WHERE id_detalle_gasto = :id_detalle_gasto');
			$sql->bindParam(':id_detalle_gasto', $id_detalle_gasto);
			$sql->bindParam(':novedad_finalizacion', $novedad_finalizacion);

			$sql->execute();
/*
			echo "UPDATE detalle_gastos_personales SET estado = 0, novedad_finalizacion = '$novedad_finalizacion' WHERE id_detalle_gasto = '$id_detalle_gasto'";*/

		} catch (Exception $e) {
			echo $e->getMessage();	
		}

	}


	 public function eliminarDG($id_detalle_gasto){
          try {
            $con = Conexion::conectar();
            $sql = $con->prepare("DELETE FROM detalle_gastos_personales WHERE id_detalle_gasto = :id_detalle_gasto");
            $sql->bindParam(':id_detalle_gasto', $id_detalle_gasto);
            $sql->execute();
    
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function filtrarDGPDF($fecha_inicio, $fecha_final){

        $filtrarActivosDGPDF = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM detalle_gastos_personales WHERE fecha_detalle >= :fecha_inicio AND fecha_detalle <= :fecha_final AND estado = 1 ");
        $sql->bindParam(":fecha_inicio", $fecha_inicio);
        $sql->bindParam(":fecha_final", $fecha_final);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $filtrarActivosDGPDF[] = $filas;
        }
           return $filtrarActivosDGPDF; 
    }

    public function valorTotalFiltroDGPDF($fecha_inicio, $fecha_final){

            $precioTotalDG = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT SUM(precio) AS total FROM detalle_gastos_personales WHERE fecha_detalle >= :fecha_inicio AND fecha_detalle <= :fecha_final AND estado = 1 ");
            $sql->bindParam(":fecha_inicio", $fecha_inicio);
            $sql->bindParam(":fecha_final", $fecha_final);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                  $precioTotalDG[] = $filas;
            }
            return $precioTotalDG; 
         
    }
}

 ?>