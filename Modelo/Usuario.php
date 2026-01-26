<?php 

require_once("Conexion/conexionBD.php");
require_once("mail/enviar.php");


class Usuario{


	public function listar(){
		$usuarios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios AS u INNER JOIN perfiles AS p ON u.id_perfil = p.id_perfil");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuarios[] = $filas;
		}

		return $usuarios;		
	}

	public function listarUsCliente(){

		$usuarios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios WHERE id_cliente != '0'");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuarios[] = $filas;
		}

		return $usuarios;		
	}

	public function listarUsuariosEmisores(){

		$usuarios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios AS u INNER JOIN roles AS r ON u.id_usuario = r.id_usuario WHERE id_modulo = 115 AND u.id_usuario != 1 ORDER BY u.nombre ASC");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuarios[] = $filas;
		}

		return $usuarios;		
	}

	

	public function listarUsuariosPermisosModOperativo(){

		$usuarios = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios AS u INNER JOIN roles AS r ON u.id_usuario = r.id_usuario WHERE id_modulo = 115 ORDER BY u.nombre ASC");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuarios[] = $filas;
		}

		return $usuarios;		
	}

	public function listarFirmasUsuarios($id_usuario){
		$firmas = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios_internos_firmas WHERE id_usuario = :id_usuario");
		$sql->bindParam(':id_usuario', $id_usuario);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$firmas[] = $filas;
		}
		return $firmas;		
	}

	public function listarUsuariosInternosEmpresa(){
		$usuariosI = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios WHERE id_perfil != 0 AND id_perfil != 2 AND id_perfil != 3 AND id_perfil != 8 AND estado = 1 ORDER BY nombre ASC ");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuariosI[] = $filas;
		}
		return $usuariosI;		
	}

	public function listarUsuariosPropietarios(){

		$afiliados = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios WHERE id_perfil = 2 ORDER BY nombre ASC ");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$afiliados[] = $filas;
		}

		return $afiliados;		
	}

	public function listarPropietariosExistentesVehiculos(){

		$usuPropVehi = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios WHERE id_perfil = 2 OR id_perfil = 8 OR id_perfil = 3 AND estado = 1 ORDER BY nombre ASC ");
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuPropVehi[] = $filas;
		}

		return $usuPropVehi;		
	}



	public function listarUsuarioPorId($id_usuario){

		$usuariosId = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
		$sql->bindParam(':id_usuario', $id_usuario);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuariosId[] = $filas;
		}
		
		return $usuariosId;		

	}

	public function listarMonitoresPorCliente($id_cliente){

		$usuariosId = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM usuarios WHERE id_cliente = :id_cliente and id_perfil = 9 and estado = 1");

		$sql->bindParam(':id_cliente', $id_cliente);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$usuariosId[] = $filas;

		}



		return $usuariosId;		



	}

	public function listarUsuarioPorCedula($num_documento){

		$usuariosId = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM usuarios WHERE usuario = ?");

		$sql->bindParam(1, $num_documento);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$usuariosId[] = $filas;

		}



		return $usuariosId;		



	}



	public function listarPropietariosPorId($id_usuario){

		$propietariosId = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM usuarios WHERE id_usuario = ? AND (id_perfil = 2 OR id_perfil = 8);");

		$sql->bindParam(1, $id_usuario);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$propietariosId[] = $filas;

		}



		return $propietariosId;		



	}







	public function listarUsuarioPorCorreo($correo){

		$usuariosCorreo = array();

		$con = Conexion::conectar();

		$sql = $con->prepare("SELECT * FROM usuarios WHERE correo_electronico = :correo");

		$sql->bindParam(":correo", $correo);

		$sql->execute();



		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

			$usuariosCorreo[] = $filas;

		}



		return $usuariosCorreo;		



	}



	public function bloquear($id_usuario){



		$con = Conexion::conectar();

		$sql = $con->prepare("UPDATE usuarios SET estado = 0 WHERE id_usuario = ? ");

		$sql->bindParam(1, $id_usuario);

		$sql->execute();



		if ($sql) {

			header("Location: ../Vista/usuarios.php");

		}

	}



	public function desbloquear($id_usuario){



		$con = Conexion::conectar();

		$sql = $con->prepare("UPDATE usuarios SET estado = 1 WHERE id_usuario = ? ");

		$sql->bindParam(1, $id_usuario);

		$sql->execute();



		if ($sql) {

			header("Location: ../Vista/usuarios.php");

		}

	}

	public function bloquearUC($id_usuario){



		$con = Conexion::conectar();

		$sql = $con->prepare("UPDATE usuarios SET estado = 0 WHERE id_usuario = ? ");

		$sql->bindParam(1, $id_usuario);

		$sql->execute();



		if ($sql) {

			header("Location: ../Vista/usuarios_clientes.php");

		}

	}



	public function desbloquearUC($id_usuario){



		$con = Conexion::conectar();

		$sql = $con->prepare("UPDATE usuarios SET estado = 1 WHERE id_usuario = ? ");

		$sql->bindParam(1, $id_usuario);

		$sql->execute();



		if ($sql) {

			header("Location: ../Vista/usuarios_clientes.php");

		}

	}



	public function registrar($nombre_usu, $clave, $id_perfil, $correo_electronico, $nombre, $id_cargo, 

							  $fecha_ultimo_ingreso){



		    $con = Conexion::conectar();

		    $sql = $con->prepare("INSERT INTO usuarios (usuario, clave, id_perfil, id_empresa, id_cliente, correo_electronico, estado, nombre, id_cargo, cant_ingresos, fecha_ultimo_ingreso) VALUES(:nombre_usu, :clave, :id_perfil, 1, 0, :correo_electronico, 1, :nombre, :id_cargo, 0, :fecha_ultimo_ingreso);");

            

            $sql->bindParam(":nombre_usu", $nombre_usu);

            $sql->bindParam(":clave", $clave);

            $sql->bindParam(":id_perfil", $id_perfil);

            $sql->bindParam(":correo_electronico", $correo_electronico);

            $sql->bindParam(":nombre", $nombre);

            $sql->bindParam(":id_cargo", $id_cargo);

            $sql->bindParam(":fecha_ultimo_ingreso", $fecha_ultimo_ingreso);



            $sql->execute();

            //echo "INSERT INTO usuarios (usuario, clave, id_perfil, id_empresa, id_cliente, correo_electronico, estado, nombre, id_cargo, cant_ingresos, fecha_ultimo_ingreso) VALUES('$nombre_usu', '$clave', '$id_perfil', 1, 0, '$correo_electronico', 1, '$nombre', '$id_cargo', 0, '$fecha_ultimo_ingreso');";

            if ($sql) {	

            	$id_usuario = $con->lastInsertId();

            	

            	header("Location: ../Vista/registrarRoles.php?us=". $id_usuario);

            }



            return $id_usuario;

	}

	public function registrarUC($nombre_usu, $clave, $id_centro_costo, $correo_electronico, $nombre, $id_cliente, $id_cargo, $fecha_ultimo_ingreso){



	    $con = Conexion::conectar();

	    $sql = $con->prepare("INSERT INTO usuarios (
usuario, clave, id_perfil, id_empresa, id_cliente, correo_electronico, estado, nombre, id_cargo, cant_ingresos, fecha_ultimo_ingreso) VALUES(:nombre_usu, :clave, :id_centro_costo, 0, :id_cliente, :correo_electronico, 1, :nombre, :id_cargo, 0, :fecha_ultimo_ingreso);");            

            $sql->bindParam(":nombre_usu", $nombre_usu);
            $sql->bindParam(":clave", $clave);
            $sql->bindParam(":id_centro_costo", $id_centro_costo);
	    $sql->bindParam(":id_cliente", $id_cliente);
            $sql->bindParam(":correo_electronico", $correo_electronico);
            $sql->bindParam(":nombre", $nombre);
            $sql->bindParam(":id_cargo", $id_cargo);
            $sql->bindParam(":fecha_ultimo_ingreso", $fecha_ultimo_ingreso);

            $sql->execute();

	}



	public function registrarPropietario($usuario, $clave, $id_perfil, $correo_electronico, $nombre, $fecha_ultimo_ingreso){



		    $con = Conexion::conectar();

		    $sql = $con->prepare("INSERT INTO usuarios (usuario, clave, id_perfil, id_empresa, id_cliente, correo_electronico, estado, nombre, id_cargo, cant_ingresos, fecha_ultimo_ingreso) VALUES(:usuario, :clave, :id_perfil, '0', '0', :correo_electronico, 1, :nombre, '0', '0', :fecha_ultimo_ingreso)");

            

            $sql->bindParam(":usuario", $usuario);

            $sql->bindParam(":clave", $clave);

            $sql->bindParam(":id_perfil", $id_perfil);

            $sql->bindParam(":correo_electronico", $correo_electronico);

            $sql->bindParam(":nombre", $nombre);

            $sql->bindParam(":fecha_ultimo_ingreso", $fecha_ultimo_ingreso);



            $sql->execute();



            echo "INSERT INTO usuarios (usuario, clave, id_perfil, id_empresa, id_cliente, correo_electronico, estado, nombre, id_cargo, cant_ingresos, fecha_ultimo_ingreso) VALUES('$usuario', '$clave', '$id_perfil', '0', '0', '$correo_electronico', 1, '$nombre', 0, 0, '$fecha_ultimo_ingreso')";



            if ($sql) {

            	return  $id_propietario = $con->lastInsertId();

            }

	}



	public function registrarConductor($usuario, $clave, $id_perfil, $correo_electronico, $nombre, $fecha_ultimo_ingreso){



		    $con = Conexion::conectar();

		    $sql = $con->prepare("INSERT INTO usuarios(usuario, clave, id_perfil, correo_electronico, estado, nombre, id_cargo, cant_ingresos, fecha_ultimo_ingreso) VALUES (:usuario, :clave, :id_perfil, :correo_electronico, 1, :nombre, 0, 0, :fecha_ultimo_ingreso)");

		    $sql->bindParam(":usuario", $usuario);

		    $sql->bindParam(":clave", $clave);

		    $sql->bindParam(":id_perfil", $id_perfil);

		    $sql->bindParam(":correo_electronico", $correo_electronico);

		    $sql->bindParam(":nombre", $nombre);

            $sql->bindParam(":fecha_ultimo_ingreso", $fecha_ultimo_ingreso);

		    

		    $sql->execute();



	}



	public function actualizar($id_usuario, $nombre_usu, $clave, $id_perfil, $correo_electronico, $estado, $nombre, $id_cargo, $cant_ingresos, $fecha_ultimo_ingreso){





            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE usuarios SET usuario = :nombre_usu, clave = :clave, id_perfil = :id_perfil, correo_electronico = :correo_electronico, estado = :estado, nombre = :nombre, id_cargo = :id_cargo, cant_ingresos = :cant_ingresos, fecha_ultimo_ingreso = :fecha_ultimo_ingreso WHERE id_usuario = :id_usuario ");



                $sql->bindParam(":id_usuario", $id_usuario);

		        $sql->bindParam(":nombre_usu", $nombre_usu);

                $sql->bindParam(":clave", $clave);

                $sql->bindParam(":id_perfil", $id_perfil);

                $sql->bindParam(":correo_electronico", $correo_electronico);

                $sql->bindParam(":estado", $estado);

                $sql->bindParam(":nombre", $nombre);

                $sql->bindParam(":id_cargo", $id_cargo);

                $sql->bindParam(":cant_ingresos", $cant_ingresos);

                $sql->bindParam(":fecha_ultimo_ingreso", $fecha_ultimo_ingreso);



                $sql->execute();

                

                if ($sql) {

            	    //header("Location: ../Vista/actualizarRoles.php?us=". $id_usuario);

                }

            } catch (Exception $e) {

            	echo $e->getMessage();

            }





	}

	
	public function actualizarUC($id_usuario, $nombre_usu, $clave, $id_perfil, $correo_electronico, $estado, $nombre, $id_cargo, $cant_ingresos, $fecha_ultimo_ingreso){





            try {

            	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE usuarios SET usuario = :nombre_usu, clave = :clave, id_perfil = :id_perfil, correo_electronico = :correo_electronico, estado = :estado, nombre = :nombre, id_cargo = :id_cargo, cant_ingresos = :cant_ingresos, fecha_ultimo_ingreso = :fecha_ultimo_ingreso WHERE id_usuario = :id_usuario ");



                $sql->bindParam(":id_usuario", $id_usuario);

		        $sql->bindParam(":nombre_usu", $nombre_usu);

                $sql->bindParam(":clave", $clave);

                $sql->bindParam(":id_perfil", $id_perfil);

                $sql->bindParam(":correo_electronico", $correo_electronico);

                $sql->bindParam(":estado", $estado);

                $sql->bindParam(":nombre", $nombre);

                $sql->bindParam(":id_cargo", $id_cargo);

                $sql->bindParam(":cant_ingresos", $cant_ingresos);

                $sql->bindParam(":fecha_ultimo_ingreso", $fecha_ultimo_ingreso);



                $sql->execute();

               
            } catch (Exception $e) {

            	echo $e->getMessage();

            }





	}



	public function actualizarPropietario($id_usuario, $nombre_usu, $clave, $id_perfil, $correo_electronico, $estado, $nombre, $id_cargo, $cant_ingresos, $fecha_ultimo_ingreso){
            try {
		        $con = Conexion::conectar();
		        $sql = $con->prepare("UPDATE usuarios SET usuario = :nombre_usu, clave = :clave, id_perfil = :id_perfil, correo_electronico = :correo_electronico, estado = :estado, nombre = :nombre, id_cargo = :id_cargo, cant_ingresos = :cant_ingresos, fecha_ultimo_ingreso = :fecha_ultimo_ingreso WHERE id_usuario = :id_usuario ");
                $sql->bindParam(":id_usuario", $id_usuario);
		        $sql->bindParam(":nombre_usu", $nombre_usu);
                $sql->bindParam(":clave", $clave);
                $sql->bindParam(":id_perfil", $id_perfil);
                $sql->bindParam(":correo_electronico", $correo_electronico);
                $sql->bindParam(":estado", $estado);
                $sql->bindParam(":nombre", $nombre);
                $sql->bindParam(":id_cargo", $id_cargo);
                $sql->bindParam(":cant_ingresos", $cant_ingresos);
                $sql->bindParam(":fecha_ultimo_ingreso", $fecha_ultimo_ingreso);
                
                $sql->execute();

                //echo("UPDATE usuarios SET usuario = '$nombre_usu', clave = '$clave', id_perfil = '$id_perfil', correo_electronico = '$correo_electronico', estado = '$estado', nombre = '$nombre', id_cargo = '$id_cargo', cant_ingresos = '$cant_ingresos', fecha_ultimo_ingreso = '$fecha_ultimo_ingreso' WHERE id_usuario = '$id_usuario'");

            } catch (Exception $e) {
            	echo $e->getMessage();
            }
	}


	public function actualizarPerfil($id_usuario, $id_perfil){



            try {    	

		        $con = Conexion::conectar();

		        $sql = $con->prepare("UPDATE usuarios SET id_perfil = :id_perfil WHERE id_usuario = :id_usuario ");



                $sql->bindParam(":id_usuario", $id_usuario);

		        $sql->bindParam(":id_perfil", $id_perfil);

                

                $sql->execute();

            

            } catch (Exception $e) {

            	echo $e->getMessage();

            }

	}



	public function actualizarCorreoConductor($id_usuario, $correo_electronico){

        try {    	
	        $con = Conexion::conectar();
	        $sql = $con->prepare("UPDATE usuarios SET correo_electronico = :correo_electronico WHERE usuario = :id_usuario ");
            $sql->bindParam(":id_usuario", $id_usuario);
	        $sql->bindParam(":correo_electronico", $correo_electronico);
	        echo "UPDATE usuarios SET correo_electronico = '$correo_electronico' WHERE usuario = '$id_usuario' ";

            $sql->execute();
        } catch (Exception $e) {
        	echo $e->getMessage();
        }
	}



	

	public function recuperarContraseña($correo, $claveE, $claveGenerada){

		try {

            $con = Conexion::conectar();

		    $sql = $con->prepare("UPDATE usuarios SET clave = :claveE WHERE correo_electronico = :correo ");

		    $sql->bindParam(":correo", $correo);

		    $sql->bindParam(":claveE", $claveE);

		    $sql->execute();



		    $this->correoRecuperacionContraseña($claveGenerada, $correo);



		} catch (Exception $e) {

			echo $e->getMessage();

		}

	}



	public function  correoRecuperacionContraseña($clave, $correo){

		try {





			if (isset($correo)) {



		        $destinatario = $correo;



		        $asunto = utf8_decode("Recuperación de contraseña");

		        $contraseña = $clave;

		        $listarU = $this->listarUsuarioPorCorreo($correo);

                $nombre_usuario = $listarU[0]['nombre'];



	            $mensaje_mail = '

	                <div align="center" style="width: 100%;">

					    <section style="height: 450px; width: 500px;">

					  		<div style="background-color: #1b2d3b; height: 40px; width: 500px; font-family: Verdana; ">

					            <span style="position: relative; left: 10px; line-height: 40px; margin:2px; color: #fed189  !important;">KING </span><span style="position: relative; right: -4px; color: #00a0df !important;"> VISION</span> 

					  		</div>

					  		<div style="background-color: #5e99b1; height: 5px; width: 500px;"></div>



					  	<section>



					  	<p style="margin: 15px; font-family: Verdana; font-size: 0.8rem;">Hola <strong> ' . $nombre_usuario . ':</strong></p><br>

					  	<p style="margin: 15px; font-family: Verdana; font-size: 0.8rem;">Se le ha asignado una nueva ' .utf8_decode('contraseña, ') .'por favor una vez ingresado en el sistema, actualicela.</p>



					  	<p style="font-family: Tahoma; position: relative; top: 10px; text-align: center; font-size: 0.9rem;">' .utf8_decode('Contraseña:') .'<strong>' . $contraseña . '</strong></p><br>



					  	<table style="width: 80%;">

					  	    <tbody>

					  	      	<tr>

					  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #c7cee8;">Asunto:  </td>

					  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #f2f2f2;">' . $asunto . '</td>

					  	        </tr>

					  	        <tr>

					  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #c7cee8;">para: </td>

					  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #f2f2f2;"><a href="">'. $correo . '</a></td>

					  	        </tr>

					  	        <tr>

					  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #c7cee8;">Fecha recibido: </td>

					  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #f2f2f2;">' . date('d-m-Y') . ' a las ' . date('H:i:s') . '</td>

					  	        </tr>

					  	    </tbody>

					  	</table>

					  	<br>	



					  	<p style="margin: 15px; font-family: Verdana; font-size: 0.8rem;"><strong>Nota: </strong>Por favor, no responda a este mensaje ya que se genero automaticamente, si tiene alguna duda comuniquese con el area de desarrollo.</p>



					  	<p style="margin: 15px; font-family: Verdana; font-size: 0.7rem;">Gracias, King Vision.</p>

					</div>



					<div align="center" style="width: 100%;">

					  	<div style="bac0kground-color: #5e99b1; height: 7px; width: 500px;"></div>

					</div>





					<div align="center" style="width: 100%;">

					  	<div style="background-color: #1b2d3b; height: 7px; width: 500px;"></div>

					</div>



		';



	            if(smtpmailer($destinatario, 'server@ortsas.com', utf8_decode('Recuperación de Contraseña'), $asunto, $mensaje_mail)){

	            	//echo '<script>alert(Envió correo exitosamente);</script>';

	            }

	            if (!empty($error)) echo $error;

            }

		} catch (Exception $e) {

			echo $e->getMessage();

		}

        

    }



/*    public function iniciarSesion($usuario, $clave){

       try {	

       	  $con = Conexion::conectar();

       	  $sql = $con->prepare("SELECT * FROM usuarios WHERE usuario = '$usuario' AND  clave = '$clave'; ");

       	  $sql->bindParam(":usuario", $usuario);

       	  $sql->bindParam(":clave", $clave);

       	  $sql->execute();    

          return $sql->fetch();	  





       } catch (Exception $e) {

       	  echo $e->getMessage();

       }

    }*/



    public function listarUsuariosPorContrato($id_contrato){

              $usuarios = array();

              $con = Conexion::conectar();

              $sql = $con->prepare("SELECT * FROM usuarios_contratos AS uc INNER JOIN usuarios AS u 

              	                    ON uc.id_usuario = u.id_usuario WHERE id_contrato = ?");

              $sql->bindParam(1, $id_contrato);



              $sql->execute();

              

              while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {

                

                 $usuarios[] = $filas;

              }



          return $usuarios;

    }



    public function actualizarUltimoIngreso($id_usuario, $cant_ingresos, $fecha_ultimo_ingreso){

    	try {

    			$con = Conexion::conectar();

             	$sql = $con->prepare("UPDATE usuarios SET cant_ingresos = :cant_ingresos, fecha_ultimo_ingreso = :fecha_ultimo_ingreso WHERE id_usuario = :id_usuario");



              	$sql->bindParam(':id_usuario', $id_usuario);

              	$sql->bindParam(':cant_ingresos', $cant_ingresos);

              	$sql->bindParam(':fecha_ultimo_ingreso', $fecha_ultimo_ingreso);



              	$sql->execute();



    	} catch (Exception $e) {

    		echo $e->getMessage();

    	}

    }



    public function buscarUsuarioPorCedula($num_documento){

    	$usuariosCorreo = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios WHERE usuario = :num_documento");
		$sql->bindParam(":num_documento", $num_documento);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuariosCorreo[] = $filas;
		}

		return $usuariosCorreo;	

    }
    
    public function usuariosPermisosFuecs(){
        $usuariosPermisos = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM usuarios as u INNER JOIN roles as r on u.id_usuario = r.id_usuario WHERE r.id_modulo = 22 AND u.estado = 1");
		$sql->bindParam(":num_documento", $num_documento);
		$sql->execute();

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$usuariosPermisos[] = $filas;
		}
		return $usuariosPermisos;	
    }

    public function consultarMensajePorUsuario($id_usuario){
		$mensajeUsuario = array();
		$con = Conexion::conectar();
		$sql = $con->prepare("SELECT * FROM mensajes_afiliados WHERE id_usuario_destinatario = :id_usuario");
		$sql->bindParam(":id_usuario", $id_usuario);
		$sql->execute();

		//echo "SELECT * FROM mensajes_afiliados WHERE id_usuario_destinatario = '$id_usuario'";

		while ($filas = $sql->fetch(PDO::FETCH_ASSOC)) {
			$mensajeUsuario[] = $filas;
		}

		return $mensajeUsuario;		
	}





}

 ?>