<?php 

require_once("Conexion/conexionBD.php");

/**
 * 
 */
class Correspondencia
{

	public function listar(){
		$listar = array();
                $con = Conexion::conectar();
                $sql = $con->prepare("SELECT * FROM correspondencia_docs order by id_doc Desc limit 50");
                $sql->execute();

                while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                	$listar[] = $filas;
                }

                return $listar;
	}

    public function listarTodo(){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM correspondencia_docs");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }

    public function listarPorId($id){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM correspondencia_docs WHERE id_doc = ?");
            $sql->bindParam(1, $id);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }

    public function listarPorRangoFecha($fecha1,$fecha2){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM correspondencia_docs WHERE fecha_recibido >= :fecha1 and fecha_recibido <= :fecha2");
            $sql->bindParam(":fecha1", $fecha1);
            $sql->bindParam(":fecha2", $fecha2);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }

    public function listarTipos(){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM correspondencia_tipos");
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }

    public function listarTipoPorId($id){
        $listar = array();
            $con = Conexion::conectar();
            $sql = $con->prepare("SELECT * FROM correspondencia_tipos WHERE id_tipo = ?");
            $sql->bindParam(1, $id);
            $sql->execute();

            while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $listar[] = $filas;
            }

        return $listar;
    }

        public function registrar($tipo, $detalle, $fecha_recibido, $remitente, $destino, $hoy, $usuario, $us_destino){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO correspondencia_docs(id_tipo_doc, detalle, fecha_recibido, remitente, destino, fecha_creacion, usuario_creador, usuario_destino) VALUES(:tipo, :detalle, :fecha_recibido, :remitente, :destino, :hoy, :usuario, :us_destino)");
                $sql->bindParam(":tipo", $tipo);
                $sql->bindParam(":detalle", $detalle);
                $sql->bindParam(":fecha_recibido", $fecha_recibido);
                $sql->bindParam(":remitente", $remitente);
                $sql->bindParam(":destino", $destino);
                $sql->bindParam(":hoy", $hoy);
                $sql->bindParam(":usuario", $usuario);
                $sql->bindParam(":us_destino", $us_destino);

                $sql->execute();
                
                return $id_cargo = $con->lastInsertId();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
                
        }

        public function actualizar($tipo, $detalle, $fecha_recibido, $remitente, $destino, $hoy, $usuario, $us_destino, $id_doc){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE correspondencia_docs SET id_tipo_doc = :tipo, detalle = :detalle, fecha_recibido = :fecha_recibido, remitente = :remitente, destino = :destino, fecha_creacion = :hoy, usuario_creador = :usuario, usuario_destino = :us_destino WHERE id_doc = :id_doc ");
                $sql->bindParam(":tipo", $tipo);
                $sql->bindParam(":detalle", $detalle);
                $sql->bindParam(":fecha_recibido", $fecha_recibido);
                $sql->bindParam(":remitente", $remitente);
                $sql->bindParam(":destino", $destino);
                $sql->bindParam(":hoy", $hoy);
                $sql->bindParam(":usuario", $usuario);
                $sql->bindParam(":us_destino", $us_destino);
                $sql->bindParam(":id_doc", $id_doc);

                $sql->execute();
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }
               
        }

        public function entregar($fecha_entrega, $firma, $id_doc){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("UPDATE correspondencia_docs SET fecha_entrega = :fecha_entrega, firma = :firma WHERE id_doc = :id_doc ");
                           
                $sql->bindParam(":fecha_entrega", $fecha_entrega);
                $sql->bindParam(":firma", $firma);
                $sql->bindParam(":id_doc", $id_doc);

                $sql->execute();
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }
               
        }
	
}

 ?>