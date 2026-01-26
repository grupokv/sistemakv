<?php
error_reporting(E_ALL);

    $from_email         = 'juanr84@live.com'; //from mail, sender email address
    $recipient_email = 'dragonkyle@gmail.com'; //recipient email address
     
    //Load POST data from HTML form
    $sender_name = "JUAN RODRIGUEZ"; //sender name
    $reply_to_email = "kyle-dragon@hotmail.com"; //sender email, it will be used in "reply-to" header
    $subject = "COTIZACION PDF SISTEMA"; //subject for the email
    $message = "Este es el contenido del mensaje"; //body of the email
 
    $name = 'cotizacionkv_20230808210206.pdf'; // get the name of the file
    $ruta = '../Documentos/CotizacionKV/'.$name;
 
    $boundary = md5("random"); // define boundary with a md5 hashed value
 
    //header
    $headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version
    $headers .= "From:".$from_email."\r\n"; // Sender Email
    $headers .= "Reply-To: ".$reply_to_email."\r\n"; // Email address to reach back
    //$headers .= "Content-Type: multipart/mixed;"; // Defining Content-Type
    //$headers .= "boundary = $boundary\r\n"; //Defining the Boundary
         
    //plain text
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($message));
         
    //attachment
    $body .= "--$boundary\r\n";
    $body .="Content-Type: application/pdf;\r\n";
    $body .="Content-Disposition: attachment; filename=".$ruta."\r\n";
    $body .="Content-Transfer-Encoding: base64\r\n";
    $body .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";
    $body .= "COTIZACION PDF"; // Attaching the encoded file with email
    
    mail($recipient_email, $subject, $body, $headers); 
     
    $sentMailResult = mail($recipient_email, $subject, $body, $headers);
 
    if($sentMailResult )
    {
    echo "<h3>File Sent Successfully.<h3>";
    // unlink($name); // delete the file after attachment sent.
    }
    else
    {
        $errorMessage = error_get_last()['message'];
        print_r(error_get_last());
    die("Sorry but the email could not be sent.
                    Please go back and try again!");
    }
?>