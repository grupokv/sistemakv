<?php
session_start();
if(!isset($_SESSION['login'])) {
	if( !isset( $_SERVER['PHP_AUTH_USER'] ) || !isset( $_SERVER['PHP_AUTH_PW'] ) )
	{
	  header("HTTP/1.0 401 Unauthorized");
	  header("WWW-authenticate: Basic realm=\"SISTEMA KV\"");
	  header("Content-type: text/html");
	  // Print HTML that a password is required
	  exit;
	}
	else
	{
	  // Validate the $_SERVER['PHP_AUTH_USER'] & $_SERVER['PHP_AUTH_PW']
	  if( $_SERVER['PHP_AUTH_USER']!='Desarrollo' || $_SERVER['PHP_AUTH_PW']!='123456' )
	  {
	    // Invalid: 401 Error & Exit
	    header("HTTP/1.0 401 Unauthorized");
	    header("WWW-authenticate: Basic realm=\"SISTEMA KV\"");
	    header("Content-type: text/html");
	    // Print HTML that a username or password is not valid
	    exit;
	  }
	  else
	  {
	    echo "<p>Hola ".$_SERVER['PHP_AUTH_USER']."</p>";
	    echo "<p>Tu ingresaste ".$_SERVER['PHP_AUTH_PW']." como tu password.</p>";
	  }
	}
}
?>