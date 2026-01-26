<?php 

require_once("Conexion/conexionBD.php");
/**
 * 
 */
class Empresa
{
	 public function listar(){
	 	$listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM empresas");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	 }

	  public function listarPorId($id_empresa){
	 	$listarPorId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM empresas WHERE id_empresa = ?");
        $sql->bindParam(1, $id_empresa);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarPorId[] = $filas;
        }

        return $listarPorId;
	 }

	 public function registrar($nombre_empresa, $nit_empresa, $direccion, $telefono, $id_pais, $id_departamento, $id_ciudad, $representante_legal, $numero_documento, $fecha_expedicion, $lugar_expedicion,                      
                               $ciudad_residencia, $logo , $num_registro_mercantil , $num_resolucion_ministerio){
            try {
                    $con = Conexion::conectar();
                    $sql = $con->prepare("INSERT INTO empresas (nombre_empresa, nit_empresa, direccion, telefono, id_pais, id_departamento, id_ciudad, representante_legal, numero_documento, fecha_expedicion, lugar_expedicion, ciudad_residencia, logo, estado ,num_registro_mercantil, num_resolucion_ministerio) VALUES (:nombre_empresa, :nit_empresa, :direccion, :telefono, :id_pais, :id_departamento, :id_ciudad, :representante_legal, :numero_documento, :fecha_expedicion, :lugar_expedicion, :ciudad_residencia, :logo,  1, :num_registro_mercantil, :num_resolucion_ministerio);");

                    $sql->bindParam(":nombre_empresa", $nombre_empresa);
                    $sql->bindParam(":nit_empresa", $nit_empresa);
                    $sql->bindParam(":direccion", $direccion);
                    $sql->bindParam(":telefono", $telefono);
                    $sql->bindParam(":id_pais", $id_pais);
                    $sql->bindParam(":id_departamento", $id_departamento);
                    $sql->bindParam(":id_ciudad", $id_ciudad);
                    $sql->bindParam(":representante_legal", $representante_legal);
                    $sql->bindParam(":numero_documento", $numero_documento);
                    $sql->bindParam(":fecha_expedicion", $fecha_expedicion);
                    $sql->bindParam(":lugar_expedicion", $lugar_expedicion);
                    $sql->bindParam(":ciudad_residencia", $ciudad_residencia);
                    $sql->bindParam(":logo", $logo);
                    $sql->bindParam(":num_registro_mercantil", $num_registro_mercantil);
                    $sql->bindParam(":num_resolucion_ministerio", $num_resolucion_ministerio);

                    $sql->execute();    
                    
                    return $id_empresa = $con->lastInsertId();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
	 }

	public function actualizar($id_empresa, $nombre_empresa, $nit_empresa, $direccion, $telefono, $id_pais,                       $id_departamento, $id_ciudad, $representante_legal, $numero_documento,                       $fecha_expedicion, $lugar_expedicion, $ciudad_residencia, $logo, $estado){
	 	try {
	 		$con = Conexion::conectar();
	 	    $sql = $con->prepare("UPDATE empresas SET nombre_empresa = :nombre_empresa, nit_empresa = :nit_empresa, direccion = :direccion, telefono = :telefono, id_pais = :id_pais, id_departamento = :id_departamento, id_ciudad = :id_ciudad, representante_legal = :representante_legal, numero_documento = :numero_documento, fecha_expedicion = :fecha_expedicion, lugar_expedicion = :lugar_expedicion, ciudad_residencia = :ciudad_residencia, logo = :logo,  estado = :estado WHERE id_empresa = :id_empresa");

	 	    $sql->bindParam(":nombre_empresa", $nombre_empresa);
            $sql->bindParam(":nit_empresa", $nit_empresa);
            $sql->bindParam(":direccion", $direccion);
            $sql->bindParam(":telefono", $telefono);
            $sql->bindParam(":id_pais", $id_pais);
            $sql->bindParam(":id_departamento", $id_departamento);
            $sql->bindParam(":id_ciudad", $id_ciudad);
            $sql->bindParam(":representante_legal", $representante_legal);
            $sql->bindParam(":numero_documento", $numero_documento);
            $sql->bindParam(":fecha_expedicion", $fecha_expedicion);
            $sql->bindParam(":lugar_expedicion", $lugar_expedicion);
            $sql->bindParam(":ciudad_residencia", $ciudad_residencia);
            $sql->bindParam(":logo", $logo);
            $sql->bindParam(":estado", $estado);
            $sql->bindParam(":id_empresa", $id_empresa);

            $sql->execute();	

	 	} catch (Exception $e) {
	 		echo $e->getMessage();
	 	}
	 	
	}

	 public function bloquear($id_empresa){

	 	$con = Conexion::conectar();
	 	$sql = $con->prepare("UPDATE empresas SET estado = 0 WHERE id_empresa = ? ");
	 	$sql->bindParam(1, $id_empresa);
	 	$sql->execute();

	 	if ($sql) {
	 		header("Location: ../Vista/empresas.php");
	 	}
	 }

	public function desbloquear($id_empresa){

	 	$con = Conexion::conectar();
	 	$sql = $con->prepare("UPDATE empresas SET estado = 1 WHERE id_empresa = ? ");
	 	$sql->bindParam(1, $id_empresa);
	 	$sql->execute();

	 	if ($sql) {
	 		header("Location: ../Vista/empresas.php");
	 	}
	}

    public function listarEmpresaORTyLP(){
        $listarEmpresasOL = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM empresas WHERE id_empresa = 1 OR id_empresa = 2");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarEmpresasOL[] = $filas;
        }

        return $listarEmpresasOL;
    }



}
 ?>