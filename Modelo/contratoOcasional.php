<?php 
 require_once("Conexion/conexionBD.php");

 class ContratoOcasional
 {
 	
 	public function registrarContratoOcasional($objeto_contrato, $id_empresa, $id_cliente, $id_vehiculo, $origen, $destino, $id_ciudad, $fecha_inicial_contrato_ocasional, $fecha_final_contrato_ocasional, $fecha_creacion, $hora_creacion, $valor_contrato, $id_responsable, $estado){

            try {
            	$con = Conexion::conectar();
	          	$sql = $con->prepare("INSERT INTO contratos_ocasionales(objeto_contrato, id_empresa, id_cliente, id_vehiculo, origen, destino, id_ciudad, fecha_inicial_contrato_ocasional, fecha_final_contrato_ocasional, fecha_creacion, hora_creacion, valor_contrato, id_responsable, estado) VALUES(:objeto_contrato, :id_empresa, :id_cliente, :id_vehiculo, :origen, :destino, :id_ciudad, :fecha_inicial_contrato_ocasional, :fecha_final_contrato_ocasional, :fecha_creacion, :hora_creacion, :valor_contrato, :id_responsable, :estado)");

	          	$sql->bindParam(":objeto_contrato", $objeto_contrato);
	          	$sql->bindParam(":id_empresa", $id_empresa);
	          	$sql->bindParam(":id_cliente", $id_cliente);
	          	$sql->bindParam(":id_vehiculo", $id_vehiculo);
	          	$sql->bindParam(":origen", $origen);
	          	$sql->bindParam(":destino", $destino);
	          	$sql->bindParam(":id_ciudad", $id_ciudad);
	          	$sql->bindParam(":fecha_inicial_contrato_ocasional", $fecha_inicial_contrato_ocasional);
	          	$sql->bindParam(":fecha_final_contrato_ocasional", $fecha_final_contrato_ocasional);
	          	$sql->bindParam(":fecha_creacion", $fecha_creacion);
	          	$sql->bindParam(":hora_creacion", $hora_creacion);
              $sql->bindParam(":valor_contrato", $valor_contrato);
	          	$sql->bindParam(":id_responsable", $id_responsable);
              $sql->bindParam(":estado", $estado);

                $sql->execute();

                //echo "INSERT INTO contratos_ocasionales(objeto_contrato, id_empresa, id_cliente, id_vehiculo, origen, destino, ruta1, ruta2, id_ciudad, fecha_inicial_contrato_ocasional, fecha_final_contrato_ocasional, fecha_creacion, hora_creacion, valor_contrato, id_responsable) VALUES('$objeto_contrato', '$id_empresa', '$id_cliente', '$id_vehiculo', '$origen', '$destino', '$id_ciudad', '$fecha_inicial_contrato_ocasional', '$fecha_final_contrato_ocasional', '$fecha_creacion', '$hora_creacion', '$valor_contrato', '$id_responsable')";

	          	if ($sql) {
                    $id_contrato = $con->lastInsertId();
                    return $id_contrato;
	          	}



            } catch (Exception $e) {
            	echo $e->getMessage();
            }
          
 	}

  public function registrarContratoOcasionalPropietarios($objeto_contrato, $id_empresa, $id_cliente, $id_vehiculo, $origen, $destino, $id_ciudad, $fecha_inicial_contrato_ocasional, $fecha_final_contrato_ocasional, $fecha_creacion, $hora_creacion, $valor_contrato, $id_responsable, $estado){

            try {
                $con = Conexion::conectar();
                $sql = $con->prepare("INSERT INTO contratos_ocasionales(objeto_contrato, id_empresa, id_cliente, id_vehiculo, origen, destino, id_ciudad, fecha_inicial_contrato_ocasional, fecha_final_contrato_ocasional, fecha_creacion, hora_creacion, valor_contrato, id_responsable, estado) VALUES(:objeto_contrato, :id_empresa, :id_cliente, :id_vehiculo, :origen, :destino, :id_ciudad, :fecha_inicial_contrato_ocasional, :fecha_final_contrato_ocasional, :fecha_creacion, :hora_creacion, :valor_contrato, :id_responsable, :estado)");

                $sql->bindParam(":objeto_contrato", $objeto_contrato);
                $sql->bindParam(":id_empresa", $id_empresa);
                $sql->bindParam(":id_cliente", $id_cliente);
                $sql->bindParam(":id_vehiculo", $id_vehiculo);
                $sql->bindParam(":origen", $origen);
                $sql->bindParam(":destino", $destino);
                $sql->bindParam(":id_ciudad", $id_ciudad);
                $sql->bindParam(":fecha_inicial_contrato_ocasional", $fecha_inicial_contrato_ocasional);
                $sql->bindParam(":fecha_final_contrato_ocasional", $fecha_final_contrato_ocasional);
                $sql->bindParam(":fecha_creacion", $fecha_creacion);
                $sql->bindParam(":hora_creacion", $hora_creacion);
                $sql->bindParam(":valor_contrato", $valor_contrato);
                $sql->bindParam(":id_responsable", $id_responsable);
                $sql->bindParam(":estado", $estado);

                $sql->execute();

                //echo "INSERT INTO contratos_ocasionales(objeto_contrato, id_empresa, id_cliente, id_vehiculo, origen, destino, id_ciudad, fecha_inicial_contrato_ocasional, fecha_final_contrato_ocasional, fecha_creacion, hora_creacion, valor_contrato, id_responsable, estado) VALUES('$objeto_contrato', '$id_empresa', '$id_cliente', '$id_vehiculo', '$origen', '$destino', '$id_ciudad', '$fecha_inicial_contrato_ocasional', '$fecha_final_contrato_ocasional','$fecha_creacion', '$hora_creacion', '$valor_contrato', '$id_responsable', '$estado')";

                if ($sql) {
                    $id_contrato = $con->lastInsertId();
                    return $id_contrato;
                }

            } catch (Exception $e) {
              echo $e->getMessage();
            }
          
  }

 	public function listarPorId($id_contrato_ocasional){
           $contratosO = array();
           $con = Conexion::conectar();
           $sql = $con->prepare("SELECT * FROM contratos_ocasionales WHERE id_contrato_ocasional = ?");
           $sql->bindParam(1, $id_contrato_ocasional);

           $sql->execute();

           while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
           	  $contratosO[] = $filas;
           }

           return $contratosO;
 	}

 	public function listar($year){
 		 $listarC = array();
           $con = Conexion::conectar();
           $sql = $con->prepare("SELECT * FROM contratos_ocasionales AS co INNER JOIN empresas AS e ON co.id_empresa = e.id_empresa INNER JOIN clientes AS c ON co.id_cliente = c.id_cliente INNER JOIN ciudades AS ci ON co.id_ciudad = ci.id_ciudad WHERE YEAR(fecha_creacion) = :year AND (co.estado != 'P' AND co.estado != 'R' AND co.estado != 'E') ");
           $sql->bindParam(":year", $year);

           $sql->execute();

           while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
           	  $listarC[] = $filas;
           }

           return $listarC;
 	}

  public function listarUsuariosPorContratosOcasiones($id_contrato){
        $usuarios = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM usuarios_contratos_ocasionales  WHERE id_contrato = :id_contrato");
        $sql->bindParam(':id_contrato', $id_contrato);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = $filas;
        }

        return $usuarios;
  }

  public function listarContratosOcasionalesPorEmisor($id_usuario){
      $ocasionalesPorEmisor = array();
      $con = Conexion::conectar();
      $sql = $con->prepare("SELECT * FROM contratos_ocasionales WHERE id_responsable = :id_usuario AND estado != 'R' AND estado != 'E' ");
      $sql->bindParam(":id_usuario" ,$id_usuario);
      $sql->execute();

      while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        $ocasionalesPorEmisor[] = $filas;
      }

      return $ocasionalesPorEmisor;
  }



  public function validarVehiculosEximidosPagos($id_vehiculo, $fecha_creacion){
        $eximidosPagos = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM vehiculos_eximidos_pagos  WHERE id_vehiculo = :id_vehiculo AND (fecha_inicial_validez <= :fecha_creacion AND fecha_final_validez >= :fecha_creacion) ");
        $sql->bindParam(':id_vehiculo', $id_vehiculo);
        $sql->bindParam(':fecha_creacion', $fecha_creacion);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $eximidosPagos[] = $filas;
        }

        //echo "SELECT * FROM vehiculos_eximidos_pagos  WHERE id_vehiculo = '$id_vehiculo' AND (fecha_inicial_validez <= '$fecha_creacion' AND fecha_final_validez >= '$fecha_creacion')";

        return $eximidosPagos;
  }


  public function validarPaquetesPlusOcasionales($id_vehiculo, $fecha_creacion){
        $paquetes_plus = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM paquetes_plus_vehiculos  WHERE id_vehiculo = :id_vehiculo AND (fecha_inicial_validez <= :fecha_creacion AND fecha_final_validez >= :fecha_creacion) ");
        $sql->bindParam(':id_vehiculo', $id_vehiculo);
        $sql->bindParam(':fecha_creacion', $fecha_creacion);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $paquetes_plus[] = $filas;
        }

        return $paquetes_plus;
  }

  public function actualizarEstadoFuecOcasional($id_fuec_ocasional, $estado){
      try {

          $con = Conexion::conectar();
          $sql = $con->prepare("UPDATE fuec SET estado = :estado WHERE id_fuec = :id_fuec_ocasional");
          $sql->bindParam(":id_fuec_ocasional", $id_fuec_ocasional);
          $sql->bindParam(":estado", $estado);
          $sql->execute();


      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }


  public function actualizarEstadoContratoOcasional($id_contrato_ocasional, $estado){
      try {

          $con = Conexion::conectar();
          $sql = $con->prepare("UPDATE contratos_ocasionales SET estado = :estado WHERE id_contrato_ocasional = :id_contrato_ocasional");
          $sql->bindParam(":id_contrato_ocasional", $id_contrato_ocasional);
          $sql->bindParam(":estado", $estado);
          $sql->execute();


      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }

  public function registrarDocContratoOcasionalProp($id_contrato_ocasional, $documento){
    try {

        $con = Conexion::conectar();
        $sql = $con->prepare("INSERT INTO documento_contrato_ocasional_propietario (id_contrato_ocasional, documento) VALUES (:id_contrato_ocasional, :documento)");
        $sql->bindParam(":id_contrato_ocasional", $id_contrato_ocasional);
        $sql->bindParam(":documento", $documento);
        $sql->execute();
      
    } catch (Exception $e) {
        echo $e->getMessage();
    }
  }


}

 ?>