<?php

/**
 * 
 */
class RecuperarContraseña
{
	public function plantillaRecuperarContraseña($nombre_usuario, $contraseña, $asunto, $correo_electronico){

		date_default_timezone_set('America/Bogota');

		$fecha = date('Y-m-d');
		$hora = date('H:i:s');

		$mensaje = '
		<div style="display:flex; justify-content: center;">
		    <section style="height: 400px; width: 500px;">
		  		<div style="background-color: #1b2d3b; height: 40px; width: 500px; font-family: Verdana; ">
		            <span style="position: relative; left: 10px; line-height: 40px; margin:2px; color: #fed189  !important;">KING </span><span style="position: relative; right: -4px; color: #00a0df !important;"> VISION</span> 
		  		</div>
		  		<div style="background-color: #5e99b1; height: 5px; width: 500px;"></div>

		  	<section>

		  	<p style="margin: 15px; font-family: Verdana; font-size: 0.8rem;">Hola <strong>' . ' ' . $nombre_usuario . ':</strong></p><br>
		  	<p style="margin: 15px; font-family: Verdana; font-size: 0.8rem;">Se le ha asignado una nueva contraseña, por favor una vez ingresado en el sistema, actualicela.</p>

		  	<p style="font-family: Tahoma; position: relative; top: 10px; text-align: center; font-size: 0.9rem;">Contraseña: <strong>' . $contraseña . '</strong></p><br>

		  	<table style="display: flex; justify-content: center;">
		  	    <tbody>
		  	      	<tr>
		  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #c7cee8;">Asunto:  </td>
		  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #f2f2f2;">' . $asunto . '</td>
		  	        </tr>
		  	        <tr>
		  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #c7cee8;">para: </td>
		  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #f2f2f2;"><a href="">'. $correo_electronico . '</a></td>
		  	        </tr>
		  	        <tr>
		  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #c7cee8;">Fecha recibido: </td>
		  	            <td style="font-family: Tahoma;  font-size: 0.9rem; background-color: #f2f2f2;">' . $fecha . ' a las ' . $hora . '</td>
		  	        </tr>
		  	    </tbody>
		  	</table>
		  	<br>	

		  	<p style="margin: 15px; font-family: Verdana; font-size: 0.8rem;"><strong>Nota: </strong>Por favor, no responda a este mensaje ya que se genero automaticamente, si tiene alguna duda comuniquese con el area de desarrollo.</p>

		  	<p style="margin: 15px; font-family: Verdana; font-size: 0.7rem;">Gracias, King Vision.</p>
		</div>

		<!---->

		<div style="display:flex; justify-content: center;">
		  	<div style="background-color: #5e99b1; height: 3px; width: 500px;"></div>
		</div>


		<div style="display:flex; justify-content: center;">
		  	<div style="background-color: #1b2d3b; height: 7px; width: 500px;"></div>
		</div>

		';

	}
	
}


 ?>