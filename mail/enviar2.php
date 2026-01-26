<?php
require_once('phpmailer/class.phpmailer.php');
define('GUSER', 'dragonkyle@gmail.com');
define('GPWD', 'dragonis0623');

function smtpmailer($to, $from, $from_name, $subject, $body) { 

	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP(); // Habilitar SMTP
	$mail->SMTPDebug = 2;  // debugging: 1 = Errores y Mensajes, 2 = Mensajes unicamente
	$mail->SMTPAuth = true;  // Habilitar autenticación
	$mail->SMTPSecure = 'tls'; // Habilitar TLS
	$mail->Port = 587;
	// Recuerde que si quita los comentarios de un grupo debe ponerlos en el otro

	// Parametros para cuentas de google apps	
	$mail->Host = 'smtp.gmail.com';


	// Parametros para cuentas de microsoft Live
	//$mail->Host = 'smtp.live.com';

	
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
	$mail->MsgHTML($body);
	$mail->AddAddress($to);

	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo;
		return false;
	} else {
		echo "Mensaje enviado ";
		return true;
	}

}

$to_email = 'juanr84@live.com';
$from_email = 'not-reply@server.com';
$from_name = 'Sistema KV';
$subject = 'Gmail SMTP';
$message = 'Mail through Gmail SMTP';
$email_rec = smtpmailer($to_email, $from_email, $from_name, $subject, $message);
echo $email_rec;
 
?>