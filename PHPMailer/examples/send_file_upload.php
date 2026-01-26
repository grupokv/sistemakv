<?php
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../src/Exception.php';
require '../src/PHPMailer.php';
require '../src/SMTP.php';

$msg = '';

$uploadfile = '../../Documentos/CotizacionKV/cotizacionkv_20230808210206.pdf';
if (file_exists($uploadfile)) {
    echo "si existe archivo";
    $mail = new PHPMailer;
    
    $mail->IsSMTP();
    $mail->SMTPDebug  = 0;
    $mail->Host = "smtp-mail.outlook.com";
    $mail->Port       = 587;
    $mail->SMTPSecure = 'tls';
    // optional
    // used only when SMTP requires authentication  
    $mail->SMTPAuth = true;
    $mail->Username = 'juanr84@live.com';
    $mail->Password = '0623metallica';
    
    $mail->setFrom('dragonkyle@gmail.com', 'Remitente');
    $mail->addAddress('juanr84@live.com', 'Destino');
    $mail->Subject = 'PHPMailer file sender';
    $mail->Body = 'Prueba mensaje con adjunto';
    // Attach the uploaded file
    $mail->addAttachment($uploadfile, 'Cotizacion');
    if (!$mail->send()) {
        $msg .= "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $msg .= "Message sent!";
    }
} else {
    $msg .= 'Failed to move file to ' . $uploadfile;
}

echo $msg;
?>