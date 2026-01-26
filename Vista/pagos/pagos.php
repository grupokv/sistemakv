<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recaudos</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>


  <div class="container">
   
    <h1>Recaudos</h1>
    <form action="pagos.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="responsable">Responsable:</label>
        <input type="text" id="responsable" name="responsablerecaudo" required>
      </div>
      <div class="form-group">
        <label for="placa">Placa:</label>
        <input type="text" id="placa" name="placa" required>
      </div>
      <div class="form-group">
        <label for="movil">Móvil:</label>
        <input type="text" id="movil" name="movil" required>
      </div>
      
      <div class="form-group">
       <div class="input-group">
    <p>Concepto Recaudo:</p>
    <input type="radio" name="conceptorecaudo" value="Rodamiento"> Rodamiento
    <input type="radio" name="conceptorecaudo" value="Pago cuota vinculaciones"> Pago cuota vinculacion
     <input type="radio" name="conceptorecaudo" value="Pagos pendientes cartera"> Pagos pendientes cartera
   </div>

    </div>
      <div class="form-group">
        <label for="valor">Valor Recaudado:</label>
        <input type="text" id="valor" name="valorrecaudado" required>
      </div>
      <div class="form-group">
        <label for="valor">fecha pago:</label>
        <input type="text" id="valor" name="fechapago" required>
      </div>
      <div class="form-group">
        <label for="archivo">Subir Archivo:</label>
        <input type="file" id="archivo" name="archivo" accept=".pdf" required >
      </div>
      <h4>NOTA: Escribir en el soporte la placa del vehiculo antes de enviar</h4>
      
      <input type="submit" value="Registrar" >

      <h3><a href="consulta.php">Consultar Pagos</a></h3> 
      
    </form>
  </div>
  <script>
        document.getElementById('registro-form').addEventListener('submit', function(event) {
            var inputs = this.querySelectorAll('input, textarea');
            var isValid = true;
            for (var i = 0; i < inputs.length; i++) {
                if (!inputs[i].checkValidity()) {
                    isValid = false;
                    break;
                }
            }
            if (!isValid) {
                event.preventDefault();
                alert('Por favor, complete todos los campos.');
            }
        });
    </script>
</body>
</html>

<?php

// Establecer la conexión a la base de datos
$conexion = mysqli_connect("localhost", "desarrollo", "AvzTMjVrQ?x&", "wwsist_sistemakv");


 // Obtener la fecha y hora actual

 
if(isset($_POST['movil']) && isset($_POST['placa']) && isset($_POST['conceptorecaudo']) && isset($_POST['valorrecaudado']) && isset($_POST['responsablerecaudo']) ) {
   
    $movil = $_POST['movil'];
    $placa =$_POST['placa'];
    $valorrecaudado = $_POST['valorrecaudado'];
    $responsablerecaudo =$_POST['responsablerecaudo'];
    $fechapago = $_POST['fechapago'];
    $conceptorecaudo = $_POST['conceptorecaudo'];

    $sql = "INSERT INTO `pagos` (`movil`, `placa`, `fechapago`, `conceptorecaudo`, `valorrecaudado`, `responsablerecaudo`) VALUES ('$movil', '$placa', '$fechapago',  '$conceptorecaudo', '$valorrecaudado', '$responsablerecaudo')";
    
    if (mysqli_query($conexion, $sql)) {
        // La consulta se ejecutó correctamente, continúa con el envío del correo electrónico
    } else {
        // Error en la ejecución de la consulta
        echo "Error al enviar el formulario: " . $sql . "<br>" . mysqli_error($conexion);
    }

     // Cargar la biblioteca PHPMailer
     require 'class.phpmailer.php';
     require 'class.smtp.php';
     require 'PHPMailerAutoload.php';
     
     // Instanciar PHPMailer
     $mail = new PHPMailer(true);
     
     try {
         // Configurar el servidor SMTP
        $mail->isSMTP();
$mail->Host = 'localhost';
$mail->SMTPAuth = false;
$mail->SMTPAutoTLS = false; 
$mail->Port = 25; 
     
         // Configurar el remitente y el destinatario
         $mail->setFrom('archivoafiliados@sistemakv.com', 'ARCHIVO PAGO');
         $mail->addAddress('recaudos@kingvisiongroup.com', 'Asistente Gerencia');
        $mail->addAddress('desarrollo@ortsas.com', 'Desarrollo');
     
          $contenidocorreo = "placa: ". $placa . "\n";
$contenidocorreo .= "Responsable: " . $responsablerecaudo . "\n";
$contenidocorreo .= "Concepto Recaudo: " . $conceptorecaudo . "\n";
$contenidocorreo .= "Fecha: " . $fechapago;
    
        // Configurar el asunto y el cuerpo del correo
        $mail->Subject = 'Archivo Pagos ';
        $mail->Body = $contenidocorreo;
     
         // Adjuntar archivos
         
             $nombreArchivo = $_FILES['archivo']['name'];
             $rutaArchivo = $_FILES['archivo']['tmp_name'];
             if (!empty($nombreArchivo) && is_uploaded_file($rutaArchivo)) {
                 $mail->addAttachment($rutaArchivo, $nombreArchivo);
             }
         
     
         // Enviar el correo
         $mail->send();
         echo 'Formulario enviado correctamente.';
     } catch (Exception $e) {
        echo 'Error al enviar el correo' . $mail->ErrorInfo;
     }
}



// Cerrar la conexión a la base de datos
mysqli_close($conexion);


?>