<?php 

class Conexion
{
	
	public static function conectar()
	{
		try {
			$con = new PDO("mysql:host=localhost;dbname=bd_pareto", "root", "");
		} catch (Exception $e) {
			echo "Error al conectar con la base de datos";
			echo $e->getMessage();
		}
		return $con;
	}

}

 ?>