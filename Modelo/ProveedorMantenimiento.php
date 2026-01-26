<?php 

require_once("Conexion/conexionBD.php");
/**
 * 
 */
class ProveedorMantenimiento
{
	 public function listar(){
	 	$listar = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM proveedor_mantenimiento");
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listar[] = $filas;
        }

        return $listar;
	 }

	  public function listarPorId($id_empresa){
	 	$listarPorId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM proveedor_mantenimiento WHERE id_proveedor = ?");
        $sql->bindParam(1, $id_empresa);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
        	$listarPorId[] = $filas;
        }

        return $listarPorId;
	 }

     public function listarPorEstado($estadp){
        $listarPorId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM proveedor_mantenimiento WHERE estado = ?");
        $sql->bindParam(1, $estado);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarPorId[] = $filas;
        }

        return $listarPorId;
     }

	 public function registrar($nombre_empresa, $nit_empresa, $direccion, $telefono, $email){
            try {
                    $con = Conexion::conectar();
                    $sql = $con->prepare("INSERT INTO proveedor_mantenimiento (razon_social, nit, direccion, telefono, email,estado) VALUES (:nombre_empresa, :nit_empresa, :direccion, :telefono, :email, 'A');");

                    $sql->bindParam(":nombre_empresa", $nombre_empresa);
                    $sql->bindParam(":nit_empresa", $nit_empresa);
                    $sql->bindParam(":direccion", $direccion);
                    $sql->bindParam(":telefono", $telefono);
                    $sql->bindParam(":email", $email);

                    //echo "INSERT INTO proveedor_mantenimiento (razon_social, nit, direccion, telefono, email,estado) VALUES ('$nombre_empresa', '$nit_empresa', '$direccion', '$telefono', '$email', 'A');";

                    $sql->execute();    
                    
                    return $id_empresa = $con->lastInsertId();

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        
	 }

	public function actualizar($id, $nombre_empresa, $nit_empresa, $direccion, $telefono, $email, $estado){
	 	try {
	 		$con = Conexion::conectar();
	 	    $sql = $con->prepare("UPDATE proveedor_mantenimiento SET razon_social = :nombre_empresa, nit = :nit_empresa, direccion = :direccion, telefono = :telefono, email = :email, estado = :estado WHERE id_proveedor = :id");

	 	    $sql->bindParam(":nombre_empresa", $nombre_empresa);
            $sql->bindParam(":nit_empresa", $nit_empresa);
            $sql->bindParam(":direccion", $direccion);
            $sql->bindParam(":telefono", $telefono);
            $sql->bindParam(":email", $email);
            $sql->bindParam(":estado", $estado);
            $sql->bindParam(":id", $id);

            $sql->execute();	

	 	} catch (Exception $e) {
	 		echo $e->getMessage();
	 	}
	 	
	}

	 public function bloquear($id_empresa){

	 	$con = Conexion::conectar();
	 	$sql = $con->prepare("UPDATE proveedor_mantenimiento SET estado = 'I' WHERE id_proveedor = ? ");
	 	$sql->bindParam(1, $id_empresa);
	 	$sql->execute();

	 	if ($sql) {
	 		header("Location: ../Vista/proveedores_mantenimiento.php");
	 	}
	 }

    public function desbloquear($id_empresa){

	 	$con = Conexion::conectar();
	 	$sql = $con->prepare("UPDATE proveedor_mantenimiento SET estado = 'A' WHERE id_proveedor = ? ");
	 	$sql->bindParam(1, $id_empresa);
	 	$sql->execute();

	 	if ($sql) {
	 		header("Location: ../Vista/proveedores_mantenimiento.php");
	 	}
	}

    public function registrarSubcategoriaPorProveedor($id_proveedor, $id_subcategoria, $costo){
        $con = Conexion::conectar();
        $sql = $con->prepare("INSERT INTO subcategoria_proveedor(id_proveedor, id_subcategoria, costo) VALUES(:id_proveedor, :id_subcategoria, :costo)");
        $sql->bindParam(":id_proveedor", $id_proveedor);
        $sql->bindParam(":id_subcategoria", $id_subcategoria);
        $sql->bindParam(":costo", $costo);

        $sql->execute();
    }

    public function listarsubcategoriaPorProveedores($id_proveedor){
        $listarSP = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM subcategoria_proveedor WHERE id_proveedor = :id_proveedor");
        $sql->bindParam(":id_proveedor", $id_proveedor);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarSP[] = $filas;
        }

        return $listarSP;
     }

     public function listarSPPorId($id){
        $listarId = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM subcategoria_proveedor WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarId[] = $filas;
        }

        return $listarId;
     }

    public function validarCantSubsPorProveedor($id_proveedor, $id_subcategoria){
        $listarValidacion = array();
        $con = Conexion::conectar();
        $sql = $con->prepare("SELECT * FROM subcategoria_proveedor WHERE id_proveedor = :id_proveedor AND id_subcategoria = :id_subcategoria");
        $sql->bindParam(":id_proveedor", $id_proveedor);
        $sql->bindParam(":id_subcategoria", $id_subcategoria);

        $sql->execute();

        while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
            $listarValidacion[] = $filas;
        }

        return $listarValidacion;
    }
}
 ?>