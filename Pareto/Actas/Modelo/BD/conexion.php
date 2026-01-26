<?php 

class Conexion
{
	
	public static function conectar()
	{
		try {
			$con = new PDO("mysql:host=localhost;dbname=uimoilmy_paretokv", "uimoilmy_us_pareto", "King*Vision2018*");
		} catch (Exception $e) {
			echo "Error al conectar con la base de datos";
			echo $e->getMessage();
		}
		return $con;
	}

}

 ?>