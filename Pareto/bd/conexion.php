<?php

class base_datos	{

	// +-------------------------------+

	// | Configurar las opciones de BD |

	// +-------------------------------+

	var $dbtype = "mysql";
	var $dbhost = "localhost";
	var $dbuser = "root";
	var $dbpass = "";
	var $dbname = "paretokv";

	

	var $response;

	var $link;

	var $conn;





	function connect()	{

		$this->response = "";

		// +-----------------------------------------+

		// | Configurar los motores de BD soportados |

		// +-----------------------------------------+

		if ($this->dbtype == "mysql" ) {

			$this->link = mysql_connect($this->dbhost, $this->dbuser, $this->dbpass);

			$this->conn = mysql_select_db($this->dbname);

		}



		/*if(!$this->link || (isset($this->conn) && !$this->conn))	{

			$this->response = "Fall la conexion !!";

			echo "<br>Fall la conexion !!";

		}

		else	{

			$this->response = "Conexion exitosa";

			echo "<br>Conexion exitosa";

		}*/

	}



	function query($sql)	{

		if ($this->dbtype == "mysql" ) {

            //echo "<li>" . $sql;

			return mysql_query($sql,$this->link);



		}

	}



	function fetch_row($result)	{

		if ($this->dbtype == "mysql" ) {

		    return mysql_fetch_array($result);

		}

	}

	

	function numrows($res)	{

		return mysql_num_rows($res);

	}

	

   	function close()	{

		if ($this->dbtype == "mysql" ) {

            //echo "<br>Cerrando la conexion";

			//echo $this->link . "conn " . $this->conn . "<br>";

            //mssql_close($this->link);

		}

	}



   	function error()	{

		if ($this->dbtype == "mssql" ) {

		    return mssql_get_last_message();

		}

	}

	

	function startTransaction()    {    

		mysql_query("START TRANSACTION");    

	} 

	

	function breakTransaction($str = "")    {   

		$msg = "Transaccion abortada debido a un error: ".mysql_error();   

		mysql_query("ROLLBACK");    die("alert(\"$str $msg\");\n");   

	} 

	

	function commitTransaction()    {    

		mysql_query("COMMIT");    

	}

}

?>

