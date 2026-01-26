<?php

$message = '';

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}
$codigo = clean_text($_POST["codigo"]);
$nombre = clean_text($_POST["nombre"]);
$email = clean_text($_POST["email"]);
if(isset($_POST["submit"]))
{
	$path = 'upload/' . $_FILES["resume"]["name"];
	move_uploaded_file($_FILES["resume"]["tmp_name"], $path);
	$message = '
		<h3 align="center">Detalles del informe</h3>
		<table border="1" width="100%" cellpadding="5" cellspacing="5">
			<tr>
				<td width="30%">Codigo</td>
				<td width="70%">'.$codigo.'</td>
			</tr>
			<tr>
				<td width="30%">Nombre</td>
				<td width="70%">'.$nombre.'</td>
			</tr>
			<tr>
				<td width="30%">Email</td>
				<td width="70%">'.$email.'</td>
			</tr>
		</table>
	';
	
	require 'class/class.phpmailer.php';
	try {
    	$mail = new PHPMailer(true);
    	$mail->IsSMTP();								//Sets Mailer to send message using SMTP
    	$mail->Host = 'smtp.gmail.com';		
    	$mail->Port = '587';								//Sets the default SMTP server port
    	$mail->SMTPAuth = true;							//Sets SMTP authentication.
    	$mail->Username = 'dragonkyle@gmail.com';					//Sets SMTP username
    	$mail->Password = 'Polar*1984*';					//Sets SMTP password
    	$mail->SMTPSecure = 'tls';							//Sets connection prefix. Options are "", "ssl" or "tls"
    	$mail->From = $email;					//Sets the From email address for the message
    	$mail->FromName = $nombre;				//Sets the From name of the message
    	$mail->AddAddress('dragonkyle@gmail.com', 'JP');		//Adds a "To" address
    	$mail->WordWrap = 50;							
    	$mail->IsHTML(true);							//Sets message type to HTML
    	$mail->AddAttachment($path);					//Adds an attachment from a path on the filesystem
    	$mail->Subject = 'Enviar informe';				//Sets the Subject of the message
    	$mail->Body = $message;	                        //An HTML or plain text message body
    	if(!$mail->Send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
	} catch (phpmailerException $e) {
      echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
      echo $e->getMessage(); //Boring error messages from anything else!
    }
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>PHPMailer enviar email adjunto archivos</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script><link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12" style="margin:0 auto; float:none;">
					<br />
					<h4>PHPMailer enviar email adjunto archivos</h4>
                    <hr>
                    <div class="card">
  <h5 class="card-header">Respuesta del sistema</h5>
  <div class="card-body">

<?php echo $message; ?>
  </div>
</div>
				</div>
			</div>
		</div>
	</body>
</html>