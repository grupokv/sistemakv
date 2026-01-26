<?php 
  require_once ("Conexion/conexionBD.php");

  class Acta
  {

  		public function listarActas(){
  			$listar = array();
  			$con = Conexion::conectar();
  			$sql = $con->prepare("SELECT * FROM actas ORDER BY id_acta DESC");
  			$sql->execute();

  			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
  				$listar[] = $filas;
  			}

  			return $listar;
  		}
  		
  		public function listarEstadoSituacion(){
  			$listar = array();
  			$con = Conexion::conectar();
  			$sql = $con->prepare("SELECT * FROM acta_estado_situacion ORDER BY id_estado ASC");
  			$sql->execute();

  			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
  				$listar[] = $filas;
  			}

  			return $listar;
  		}
  		
      public function listarActasId($id_acta){
        $listarActaId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM actas WHERE id_acta = :id_acta");
        $sql->bindParam(":id_acta",$id_acta);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
          $listarActaId[] = $filas;
        }

        return $listarActaId;
      }

      public function listarInvitadosActaId($id_acta){
        $listarVId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM acta_invitados WHERE id_acta = :id_acta");
        $sql->bindParam(":id_acta",$id_acta);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
          $listarVId[] = $filas;
        }

        return $listarVId;
      }

      public function listarInvitadosInternosActaId($id_acta){
        $listarInternosId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM acta_invitados WHERE id_acta = :id_acta AND id_usuario_interno != '' ORDER BY id_usuario_interno ASC ");
        $sql->bindParam(":id_acta",$id_acta);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
          $listarInternosId[] = $filas;
        }

        return $listarInternosId;
      }

      public function listarIdInvitados($id_acta){
        $listarIdInvi = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT id_usuario_interno FROM acta_invitados WHERE id_acta = :id_acta");
        $sql->bindParam(":id_acta",$id_acta);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
          $listarIdInvi[] = $filas;
        }

        return $listarIdInvi;
      }

      public function eliminarInivitadoExternos($id_acta, $id_invitado){
         try {
           $con = Conexion::conectar();
           $sql = $con->prepare("DELETE FROM  acta_invitados WHERE id_acta = :id_acta AND id_invitado = :id_invitado");
           $sql->bindParam(":id_acta", $id_acta);
           $sql->bindParam(":id_invitado", $id_invitado);
           $sql->execute();

           //echo "DELETE FROM  acta_invitados WHERE id_acta =  '$id_acta' ";
         } catch (Exception $e) {
            echo $e->getMessage();
         }
      }

      public function eliminarInivitadosInternos($id_acta){
         try {
           $con = Conexion::conectar();
           $sql = $con->prepare("DELETE FROM  acta_invitados WHERE id_acta = :id_acta AND id_usuario_interno != 0 ");
           $sql->bindParam(":id_acta", $id_acta);
           $sql->execute();

           
         } catch (Exception $e) {
            echo $e->getMessage();
         }
      }

      public function listarTemaActaId($id_acta){
        $listarTemaId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM acta_agenda WHERE id_acta = :id_acta");
        $sql->bindParam(":id_acta",$id_acta);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
          $listarTemaId[] = $filas;
        }

        return $listarTemaId;
      }

      public function listarTemaId($id_agenda){
        $listarAgendaId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM acta_agenda WHERE id_agenda = :id_agenda");
        $sql->bindParam(":id_agenda",$id_agenda);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
          $listarAgendaId[] = $filas;
        }

        return $listarAgendaId;
      }

      public function listarSituacionActaId($id_acta){
        $listarSituacionId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM acta_situaciones WHERE id_acta = :id_acta");
        $sql->bindParam(":id_acta",$id_acta);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
          $listarSituacionId[] = $filas;
        }

        return $listarSituacionId;
      }
  		
      public function listarSituacionId($id_situacion){
        $listarSId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM acta_situaciones WHERE id_situacion = :id_situacion");
        $sql->bindParam(":id_situacion",$id_situacion);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
          $listarSId[] = $filas;
        }

        return $listarSId;
      }
      
      public function cambiarEstadoSituacionId($id_situacion,$estado){
        $listarSId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("UPDATE acta_situaciones SET estado_solucion = :estado WHERE id_situacion = :id_situacion");
        $sql->bindParam(":id_situacion",$id_situacion);
        $sql->bindParam(":estado",$estado);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
          $listarSId[] = $filas;
        }

        return $listarSId;
      }
      
  		public function registrarActa($cliente, $empresa, $nombre_acta, $fecha_reunion, $hora_inicial_acta, $hora_final_acta, $id_responsable, $fecha_hora_creacion){
  			try {
	  			$con = Conexion::conectar();
	  			$sql = $con->prepare("INSERT INTO actas (cliente, empresa, nombre_acta, fecha_reunion, hora_inicial_acta, hora_final_acta, id_responsable, fecha_hora_creacion) VALUES(:cliente, :empresa, :nombre_acta, :fecha_reunion, :hora_inicial_acta, :hora_final_acta, :id_responsable, :fecha_hora_creacion)");
	  			$sql->bindParam(":cliente", $cliente);
	  			$sql->bindParam(":empresa", $empresa);
          $sql->bindParam(":nombre_acta", $nombre_acta);
	  			$sql->bindParam(":fecha_reunion", $fecha_reunion);
	  			$sql->bindParam(":hora_inicial_acta", $hora_inicial_acta);
	  			$sql->bindParam(":hora_final_acta", $hora_final_acta);
	  			$sql->bindParam(":id_responsable", $id_responsable);
	  			$sql->bindParam(":fecha_hora_creacion", $fecha_hora_creacion);
	  			$sql->execute();
          
          //echo "INSERT INTO actas (cliente, nombre_acta, fecha_reunion, hora_inicial_acta, hora_final_acta, id_responsable, fecha_hora_creacion) VALUES('$cliente', '$nombre_acta', '$fecha_reunion', '$hora_inicial_acta', '$hora_final_acta', '$id_responsable', '$fecha_hora_creacion')";
          return $id_acta = $con->lastInsertId();

  			} catch (Exception $e) {
  				echo $e->getMessage();
  			}
  		}

      public function actualizarActa($id_acta, $cliente, $empresa, $nombre_acta, $fecha_reunion, $hora_inicial_acta, $hora_final_acta, $id_responsable, $fecha_hora_creacion){
        try {
          $con = Conexion::conectar();
          $sql = $con->prepare("UPDATE actas SET cliente = :cliente, empresa = :empresa, nombre_acta = :nombre_acta, fecha_reunion = :fecha_reunion, hora_inicial_acta = :hora_inicial_acta, hora_final_acta = :hora_final_acta, id_responsable = :id_responsable, fecha_hora_creacion = :fecha_hora_creacion WHERE id_acta = :id_acta");
          $sql->bindParam(":id_acta", $id_acta);
          $sql->bindParam(":cliente", $cliente);
          $sql->bindParam(":empresa", $empresa);
          $sql->bindParam(":nombre_acta", $nombre_acta);
          $sql->bindParam(":fecha_reunion", $fecha_reunion);
          $sql->bindParam(":hora_inicial_acta", $hora_inicial_acta);
          $sql->bindParam(":hora_final_acta", $hora_final_acta);
          $sql->bindParam(":id_responsable", $id_responsable);
          $sql->bindParam(":fecha_hora_creacion", $fecha_hora_creacion);
          $sql->execute();

          //echo "UPDATE actas SET cliente = '$cliente', nombre_acta = '$nombre_acta', fecha_reunion = '$fecha_reunion', hora_inicial_acta = '$hora_inicial_acta', hora_final_acta = '$hora_final_acta', id_responsable = '$id_responsable', fecha_hora_creacion = '$fecha_hora_creacion' WHERE id_acta = '$id_acta'";
          
        } catch (Exception $e) {
          echo $e->getMessage();
        }
      }

  		public function registrarInvitadosActa($nombre_usuario_externo, $numero_documento_externo, $proveniente_de, $id_usuario_interno, $id_acta){

  			try {
  				$con = Conexion::conectar();
	  			$sql = $con->prepare("INSERT INTO acta_invitados (nombre_usuario_externo, numero_documento_externo, proveniente_de, id_usuario_interno, id_acta) VALUES(:nombre_usuario_externo, :numero_documento_externo, :proveniente_de, :id_usuario_interno, :id_acta)");
	  			$sql->bindParam(":nombre_usuario_externo", $nombre_usuario_externo);
	  			$sql->bindParam(":numero_documento_externo", $numero_documento_externo);
	  			$sql->bindParam(":proveniente_de", $proveniente_de);
	  			$sql->bindParam(":id_usuario_interno", $id_usuario_interno);
	  			$sql->bindParam(":id_acta", $id_acta);
	  			$sql->execute();

          //echo "INSERT INTO acta_invitados (nombre_usuario_externo, numero_documento_externo, proveniente_de, id_usuario_interno, id_acta) VALUES('$nombre_usuario_externo', '$numero_documento_externo', '$proveniente_de', '$id_usuario_interno', '$id_acta')";
  			} catch (Exception $e) {
  				echo $e->getMessage();
  			}
  			
  		}

  		public function registrarTemaActa($id_acta, $nombre_tema, $descripcion_tema){
  			try {
  				$con = Conexion::conectar();
	  			$sql = $con->prepare("INSERT INTO acta_agenda (id_acta, nombre_tema, descripcion_tema) VALUES(:id_acta, :nombre_tema, :descripcion_tema)");
	  			$sql->bindParam(":id_acta", $id_acta);
	  			$sql->bindParam(":nombre_tema", $nombre_tema);
	  			$sql->bindParam(":descripcion_tema", $descripcion_tema);
	  			$sql->execute();
  			} catch (Exception $e) {
  				echo $e->getMessage();
  			}
  			
  		}

      public function eliminarTemaId($id_agenda){
        try {
          $con = Conexion::conectar();
          $sql = $con->prepare("DELETE FROM acta_agenda WHERE id_agenda = :id_agenda");
          $sql->bindParam(":id_agenda", $id_agenda);
          $sql->execute();
        } catch (Exception $e) {
          echo $e->getMessage();
        }
        
      }

      public function actualizarTemaActa($id_agenda, $id_acta, $nombre_tema, $descripcion_tema){
        try {
          $con = Conexion::conectar();
          $sql = $con->prepare("UPDATE acta_agenda SET id_acta = :id_acta, nombre_tema = :nombre_tema, descripcion_tema = :descripcion_tema WHERE id_agenda = :id_agenda");
          $sql->bindParam(":id_agenda", $id_agenda);
          $sql->bindParam(":id_acta", $id_acta);
          $sql->bindParam(":nombre_tema", $nombre_tema);
          $sql->bindParam(":descripcion_tema", $descripcion_tema);
          $sql->execute();
          //echo "UPDATE acta_agenda SET id_acta = '$id_acta', nombre_tema = '$nombre_tema', descripcion_tema = '$descripcion_tema' WHERE id_agenda = '$id_agenda'";
        } catch (Exception $e) {
          echo $e->getMessage();
        }
        
      }

  		public function registrarSituacionActa($id_acta, $descripcion_situacion, $solucion_situacion, $id_responsable, $estado_solucion, $id_reportar_a, $fecha_limite, $prioridad){
  			try {
  				$con = Conexion::conectar();
	  			$sql = $con->prepare("INSERT INTO acta_situaciones (id_acta, descripcion_situacion, solucion_situacion, estado_solucion, id_responsable, id_reportar_a, fecha_limite, prioridad) VALUES(:id_acta, :descripcion_situacion, :solucion_situacion, :estado_solucion, :id_responsable, :id_reportar_a, :fecha_limite, :prioridad)");
	  			$sql->bindParam(":id_acta", $id_acta);
	  			$sql->bindParam(":descripcion_situacion", $descripcion_situacion);
	  			$sql->bindParam(":solucion_situacion", $solucion_situacion);
	  			$sql->bindParam(":id_responsable", $id_responsable);
	  			$sql->bindParam(":id_reportar_a", $id_reportar_a);
	  			$sql->bindParam(":estado_solucion",$estado_solucion);
	  			$sql->bindParam(":fecha_limite", $fecha_limite);
	  			$sql->bindParam(":prioridad", $prioridad);
	  			$sql->execute();

          //echo "INSERT INTO acta_situaciones (id_acta, descripcion_situacion, solucion_situacion, id_responsable, id_reportar_a, fecha_limite, prioridad) VALUES('$id_acta', '$descripcion_situacion', '$solucion_situacion', '$id_responsable', '$id_reportar_a', '$fecha_limite', '$prioridad')";
  			} catch (Exception $e) {
  				echo $e->getMessage();
  			}
  			
  		}

      public function eliminarSituacionId($id_situacion){
        try {
          $con = Conexion::conectar();
          $sql = $con->prepare("DELETE FROM acta_situaciones WHERE id_situacion = :id_situacion");
          $sql->bindParam(":id_situacion", $id_situacion);
          $sql->execute();

        } catch (Exception $e) {
          echo $e->getMessage();
        }
        
      }


      public function actualizarSituacionActa($id_situacion, $id_acta, $descripcion_situacion, $solucion_situacion, $id_responsable, $estado, $id_reportar_a, $fecha_limite, $prioridad){
        try {
          $con = Conexion::conectar();
          $sql = $con->prepare("UPDATE acta_situaciones SET id_acta = :id_acta, descripcion_situacion = :descripcion_situacion, solucion_situacion = :solucion_situacion, id_responsable = :id_responsable, estado_solucion = :estado, id_reportar_a = :id_reportar_a, fecha_limite = :fecha_limite, prioridad = :prioridad WHERE id_situacion = :id_situacion");
          $sql->bindParam(":id_situacion", $id_situacion);
          $sql->bindParam(":id_acta", $id_acta);
          $sql->bindParam(":descripcion_situacion", $descripcion_situacion);
          $sql->bindParam(":solucion_situacion", $solucion_situacion);
          $sql->bindParam(":id_responsable", $id_responsable);
          $sql->bindParam(":estado", $estado);
          $sql->bindParam(":id_reportar_a", $id_reportar_a);
          $sql->bindParam(":fecha_limite", $fecha_limite);
          $sql->bindParam(":prioridad", $prioridad);
          $sql->execute();

        } catch (Exception $e) {
          echo $e->getMessage();
        }
        
      }
  }

?>