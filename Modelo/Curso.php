<?php 

require_once("Conexion/conexionBD.php");

/**
 * 
 */
class Curso
{
	
	public function listar(){
		$cursos = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM curso");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$cursos[] = $filas;
		}

		return $cursos;		

	}

	public function listarCursoPorId($id_curso){
		$cursos = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM curso WHERE id_curso = ?");
		$sql->bindParam(1, $id_curso);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$cursos[] = $filas;
		}

		return $cursos;		

	}

	public function listarCursoPorIdColegio($id_colegio){
		$cursos = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM curso WHERE id_cliente = ?");
		$sql->bindParam(1, $id_colegio);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$cursos[] = $filas;
		}

		return $cursos;		

	}

	public function registrar($nombre_curso, $id_colegio){

		    $con = Conexion::conectar();
		    $sql = $con->prepare("INSERT INTO curso (nombre, id_cliente) VALUES(:nombre_curso, :id_colegio);");
            
            $sql->bindParam(":nombre_curso", $nombre_curso);
            $sql->bindParam(":id_colegio", $id_colegio);

            $sql->execute();
            


            if ($sql) {	
            	header("Location: ../Vista/cursos.php");
            }

	}

	public function actualizar($id_curso, $nombre_curso, $id_colegio){


            try {
            	
		        $con = Conexion::conectar();
		        $sql = $con->prepare("UPDATE curso SET nombre = :nombre_curso, id_cliente = :id_colegio WHERE id_curso = :id_curso");

		        $sql->bindParam(":nombre_curso", $nombre_curso);
                $sql->bindParam(":id_colegio", $id_colegio);
                $sql->bindParam(":id_curso", $id_curso);

                $sql->execute();
                
                if ($sql) {
            	    header("Location: ../Vista/cursos.php");
                }
            } catch (Exception $e) {
            	echo $e->getMessage();
            }


	}

}
 ?>