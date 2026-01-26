<?php 
require_once("Conexion/conexionBD.php");


class Subcategoria_Mantenimiento
{
	
	public function listar(){

		$cat = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM subcategoria_mantenimiento");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$cat[] = $filas;
		}

		return $cat;
	}

	public function listarPorId($id){

		$catPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM subcategoria_mantenimiento WHERE id_subcategoria = :id");
		$sql->bindParam("id", $id);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$catPorId[] = $filas;
		}

		return $catPorId;
	}

	public function listarPorCategoria($id){

		$catPorId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM subcategoria_mantenimiento WHERE id_categoria = :id");
		$sql->bindParam("id", $id);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$catPorId[] = $filas;
		}

		return $catPorId;
	}
		
	  public function registrar($nombre_cat,$id_cat){
	      try {
	          $con = Conexion::conectar();
	          $sql = $con->prepare("INSERT INTO subcategoria_mantenimiento(detalle_subcategoria,id_categoria) VALUES(:nombre_cat,:id_cat)");
	          $sql->bindParam(":nombre_cat", $nombre_cat);
	          $sql->bindParam(":id_cat", $id_cat);
	          $sql->execute();

	          return $id_categoria = $con->lastInsertId();

	      } catch (Exception $e) {
	          echo $e->getMessage();
	      }
	  }

	    public function actualizar($nombre_cat, $id_cat, $id_subcat){
	     	try {
		        $con = Conexion::conectar();
		        $sql = $con->prepare("UPDATE subcategoria_mantenimiento SET detalle_subcategoria = :nombre_cat, id_categoria = :id_cat WHERE id_subcategoria = :id_subcat");
		        $sql->bindParam("nombre_cat", $nombre_cat);
		        $sql->bindParam("id_cat", $id_cat);
		        $sql->bindParam("id_subcat", $id_subcat);

		        $sql->execute();
	        
	     	} catch (Exception $e) {
	            echo $e->getMessage();
	     	}
	    }

	    public function listarCategoriasPorIdSubcategoria($id_subcategoria){
	    	$listarCS = array();
	    	$con = Conexion::conectar();
	    	$sql = $con->prepare("SELECT * FROM subcategoria_mantenimiento AS sm INNER JOIN categoria_mantenimiento AS cm ON sm.id_categoria = cm.id_categoria WHERE sm.id_subcategoria = :id_subcategoria ORDER BY cm.id_categoria ASC");
	    	$sql->bindParam(":id_subcategoria", $id_subcategoria);

	    	$sql->execute();

	    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
	    		$listarCS[] = $filas;
	    	}

	    	return $listarCS;
	    }

	    public function listarCategoriasIn($id_subcategoria){
			$listarCIn = array();
			$con = Conexion::conectar();
	    	$sql = $con->prepare("SELECT * FROM subcategoria_mantenimiento AS sm INNER JOIN categoria_mantenimiento AS cm ON sm.id_categoria = cm.id_categoria WHERE sm.id_subcategoria IN ($id_subcategoria) order by cm.id_categoria");
	    	$sql->execute();

	    	//echo "SELECT * FROM subcategoria_mantenimiento AS sm INNER JOIN categoria_mantenimiento AS cm ON sm.id_categoria = cm.id_categoria WHERE sm.id_subcategoria IN ($id_subcategoria)";

	    	while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
	    		$listarCIn[] = $filas;
	    	}

	    	return $listarCIn;
	    }

 		public function listarSubcategoriaProveedor($id_proveedor){
	    	$subProveedor = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM subcategoria_proveedor WHERE id_proveedor = :id_proveedor");
			$sql->bindParam("id_proveedor", $id_proveedor);
			$sql->execute();

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				$subProveedor[] = $filas;
			}

			return $subProveedor;
	    }

	    public function listarSubcategoriaId($id_subcategoria){
	    	$subId = array();
			$con = Conexion::conectar();
			$sql = $con->prepare("SELECT * FROM subcategoria_mantenimiento WHERE id_subcategoria = :id_subcategoria");
			$sql->bindParam("id_subcategoria", $id_subcategoria);
			$sql->execute();

			while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
				$subId[] = $filas;
			}

			return $subId;
	    }



}

?>