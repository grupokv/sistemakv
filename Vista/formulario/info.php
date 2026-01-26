<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afiliaciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <div class="formulario">
            <form action="info.php" method="post" enctype="multipart/form-data">
                <h2>Formulario registro afiliados</h2>
                <h3>Datos del comercial</h3>
                <div class="input-group">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
                    <input type="text" name="cargo" id="cargo" placeholder="Cargo" required>
                    
                </div>
                
                <div class="input-group">
                    <input type="email" name="emailcorp"  placeholder="Email Corporativo" required>
                    <input type="tel" name="telefono"  placeholder="Telefono" required>
                  
                </div>
                <h3>Datos del vinculado</h3>
                <div class="input-group">
                    <input type="text" name="placa" placeholder="Placa" required>
                    <input type="text" name="nombrep"  placeholder="Nombre del Propietario" required>
                    
                </div>
                
                <div class="input-group">
                    <input type="email" name="emailp"  placeholder="Email Propietario" required>
                    <input type="tel" name="telefono1"  placeholder="Telefono 1" multiple required>
                    
                </div>
                <div class="input-group">
                <input type="tel" name="telefono2"  placeholder="Telefono 2" multiple required>
                    <input type="text" name="cedula"  placeholder="Cedula propietario" required>
                    
                    
                </div>
                <div class="input-group">
                <input type="text" name="modelo"  placeholder="Modelo" required>
                    <input type="text" name="cilindraje" placeholder="Cilindraje" required>
                    
                    
                </div>
                <div class="input-group">
                <input type="text" name="marca" placeholder="Marca" required>
                    <input type="text" name="tipologia"  placeholder="Tipologia" required>
                    
                    
                </div>
                <div class="input-group">
                <input type="text" name="linea" placeholder="Linea" required>
                    <input type="text" name="empresaorigen" placeholder="Empresa de origen" required>
                    
                    
                </div>

                <h3>Pagos</h3>
               
                <div class="input-group">
                <input type="text" name="valorafiliacion"  placeholder="Valor afiliacion" required>
                <input type="text" name="metodopago" placeholder="Metodo de pago" required>

                
                </div>
                    
                <div class="input-group">
               
                    <input type="text" name="abono1" id="abono1" placeholder="Valor abono1" required>
                    <input type="text" name="fechapago" placeholder="fecha de pago abono1"   required>
                </div >
                
            

                <h3>Cargar Documentos</h3>

                <h4>Asegurate que los archivos no pesen mucho, si es asi comprimelos</h4>
                <div class="input-group">
                    <p>Fotocopia cedula:</p>
                <input type="file" name="archivo1" id="fotocopiacc" accept=".pdf,.doc,.docx" required >
                <p>Fotocopia tarjeta de propiedad:</p>
                <input type="file" name="archivo2" id="fotocopiaTO" accept=".pdf,.doc,.docx" required> 
                
            </div>
            
            <div class="input-group">
                <p>Referencia empresa de origen (llamar):</p>
                <input type="file" name="archivo3" id="referencia" accept=".pdf" required>
                <p>Antecedentes procuraduria:</p>
                <input type="file" name="archivo4" id="procuraduria" accept=".pdf" required> 
                
            </div>
            <div class="input-group">
                <p>Antecedentes contraloria:</p>
                <input type="file" name="archivo5" id="contraloria" accept=".pdf" required>
                <p>Antecedentes policia:</p>
                <input type="file" name="archivo6" id="policia" accept=".pdf," required> 
                
            </div>
            <div class="input-group">
                <p>Consulta RUNT:</p>
                <input type="file" name="archivo7" id="runt" accept=".pdf" required>
                <p>Consulta comparendos:</p>
                <input type="file" name="archivo8" id="comparendos" accept=".pdf" required> 
                
            </div>

            <h3>link de consulta</h3>

            <div class="input-group0">
            <a href="https://www.runt.com.co/consultaCiudadana/#/consultaVehiculo" class="enlace">RUNT  /</a>
            <a href="https://consultas.transitobogota.gov.co:8010/publico/index3.php" class="enlace">/COMPARENDOS  /</a>
            <a href="https://www.contraloria.gov.co/web/guest/persona-natural" class="enlace">/CONTRALORIA   /</a>
            <a href="https://antecedentes.policia.gov.co:7005/WebJudicial/" class="enlace">/POLICIA    /</a>
            <a href="https://www.procuraduria.gov.co/Pages/Consulta-de-Antecedentes.aspx" class="enlace">/PROCURADURIA//</a>
        </div>

        <h3>Preguntas de Diagnostico Financiero</h3>

        <div class="input-group1">
        <p>Promedio ingreso mensual:</p>
        <input type="text" name="pregunta1" class="custom-input" required>


    <p>¿Cuenta con ingresos adicionales?:</p>
    <input type="checkbox" name="pregunta2" value="si"> Si
    <input type="checkbox" name="pregunta2" value="no"> No

    </div>

    <div class="input-group1">
    <p>¿Quien maneja la economia en su hogar?:</p>
    <input type="text" name="pregunta3" class="custom-input" required>

    <p>¿Paga arriendo?:</p>
    <input type="checkbox" name="pregunta4" value="si"> Si
    <input type="checkbox" name="pregunta4" value="no"> No
    </div>


    <div class="input-group1">
    <p>Valor cuotas del vehiculo:</p>
    <input type="text" name="pregunta5" class="custom-input" required>

    <p>Cantidad de cuotas proyectadas:</p>
    <input type="text" name="pregunta6" class="custom-input" required>


</div>

            <div class="input-group0" >
            <label>
                <input type="checkbox" name="terminos" required>
                Acepto las politicas de privacidad
            </label>
        </div>

        <h4>Revisa que los datos del formulario esten diligenciados correctamente</h4>

                <input type="submit" value="Registrar" >
              
        
            </form>


        </div>
        <div class="introduccion">
            
              <h3><a href="consulta.php">Consultar afiliados</a></h3>
            
            <h2>DEBERES DEL COMERCIAL Y ACLARACIONES</h2>
            <h3>Segimiento y Administracion</h3>
            <ol>

            <li>Desarrollo comercial y administrativo del vinculado</li>
            <li>Recaudar toda la informacion solicitada para el proceso de vinculacion</li>
            <li>El comercial debe realizar el seguimiento de todas las solicitudes del vinculado y su respectiva gestion, durante TODA la vigencia de la vinculacion</li>


            </ol>
            <h3>Consulta Antecedentes</h3>
            <ol>
            <li>Generar todos los certificados solicitados y consultas solicitadas (formato pdf)</li>
            <li>Solicitar referencia (telefonicamente) a la empresa de origen de donde proviene el vinculado</li>
            <li>Realizar preguntas Diagnostico Financiero</li>

            </ol>

        
            <h3>Opciones</h3>
                    <ul>
                    <h4>Tipologia</h4>
                    <li>Microbus</li>
                    <li>Bus</li>
                    <li>Buseta</li>
                    <li>Campero</li>
                    <li>Camioneta</li>
                    <h4>Valor afiliacion</h4>
                    <li>2.500.000</li>
                    <li>4.000.000</li>
                    <li>5.000.000</li>
                    <h4>Metodos de pago </h4>
                    <li>Transferencia</li>
                    <li>Consignacion</li>
                    <li>PSE</li>
                    <li>Efectivo</li>
                </ul>

            <h3>Recaudo y Cartera</h3>
        <ol>
            <li>Solicitar pago primera cuota para generar carta de aceptacion</li>
                <li> Seguimiento de los pagos:</li>
                <ul>
                    <li>Validar que se generen las facturas de cobro por concepto de cuota y/o rodamiento</li>
                    <li>En caso de mora realizar proceso de cobro</li>

                </ul>
                    <li>Enviar soportes de pago por medio del modulo de RECAUDO ubicado en CARTERA en KV </li>
                   

                    <li>No se generaran FUEC si el vinculado no esta al dia con los pagos (cartera actualizada)</li>
            <li>Informar a los Emails mencionados, si los pagos seran realizados por medio de descuento a los pagos realizados por servicios prestados. </li>
            <li>Identificacion de los pagos: Solicitar siempre que en el area referencia de pago, diligencien el numero de la placa del vehiculo</li>

            </ol>

           
            <h4>NOTA: Todos los soportes generados por cualquier concepto deben ser enviados en formato PDF</h4>

            <h4>Importante</h4>
            <p>Si despues de 30 dias posteriores a la entrega de la carta de aceptacion, el vinculado DESISTE del proceso, se realizara la devolucion del dinero abonado y se descontara el 20% sobre el valor que haya sido aportado a la fecha</p>

            
            <h3>Formas de Pago</h3>

            <ol>
            <li>Se autoriza el pago por concepto de vinculacion en cuotas (semanales, mensuales)</li>
            <li>Estas cuotas iran desde 2 a maximo 5</li>
            <li>Como plazo estandar de pago se establecen 3 cuotas</li>
            </ol>

            <h3>Polizas</h3>
            <p>El vinculado pagara el valor correspondiente a los dias de cobertura con respecto a  la vigencia de la poliza, al momento de renovacion de la poliza se descontaran los dias de cobertura del periodo anterior.</p>
            <p>(El valor de la poliza sera caculado teniendo en cuenta como incio la fecha de vinculacion, hasta la fecha de vigencia de la poliza)</p>
            <p>Formula: Fecha vencimiento Póliza/Fecha Vinculación=DiasVigenciaPoliza; Luego; DiasVigenciaPolizaXValorDiarioPoliza=ValorDiasVigenciaPoliza </p>
           
          
        </div>
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

$conexion =mysqli_connect("localhost", "desarrollo", "AvzTMjVrQ?x&", "wwsist_sistemakv");

// Obtener la fecha y hora actual
$fechaenvio = date("Y-m-d");
 
if(isset($_POST['nombre']) && isset($_POST['cargo']) && isset($_POST['emailcorp']) && isset($_POST['telefono']) && isset($_POST['placa'])
 && isset($_POST['nombrep']) && isset($_POST['emailp']) && isset($_POST['telefono1']) && isset($_POST['telefono2']) && isset($_POST['cedula']) && isset($_POST['modelo'])
&& isset($_POST['marca']) && isset($_POST['tipologia']) && isset($_POST['linea']) && isset($_POST['cilindraje']) && isset($_POST['empresaorigen']) && isset($_POST['valorafiliacion'])
&& isset($_POST['metodopago']) && isset($_POST['abono1'] )&& isset($_POST['fechapago']) && isset($_POST['pregunta1']) && isset($_POST['pregunta2']) && isset($_POST['pregunta3']) && isset($_POST['pregunta4']) && isset($_POST['pregunta5']) && isset($_POST['pregunta6'])  ) {
   
  // Escapar los valores POST para evitar inyección de SQL
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$cargo = mysqli_real_escape_string($conexion, $_POST['cargo']);
$emailcorp = mysqli_real_escape_string($conexion, $_POST['emailcorp']);
$telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
$placa = mysqli_real_escape_string($conexion, $_POST['placa']);
$nombrep = mysqli_real_escape_string($conexion, $_POST['nombrep']);
$emailp = mysqli_real_escape_string($conexion, $_POST['emailp']);
$telefono1 = mysqli_real_escape_string($conexion, $_POST['telefono1']);
$telefono2 = mysqli_real_escape_string($conexion, $_POST['telefono2']);
$cedula = mysqli_real_escape_string($conexion, $_POST['cedula']);
$modelo = mysqli_real_escape_string($conexion, $_POST['modelo']);
$marca = mysqli_real_escape_string($conexion, $_POST['marca']);
$tipologia = mysqli_real_escape_string($conexion, $_POST['tipologia']);
$linea = mysqli_real_escape_string($conexion, $_POST['linea']);
$cilindraje = mysqli_real_escape_string($conexion, $_POST['cilindraje']);
$empresaorigen = mysqli_real_escape_string($conexion, $_POST['empresaorigen']);
$valorafiliacion = mysqli_real_escape_string($conexion, $_POST['valorafiliacion']);
$metodopago = mysqli_real_escape_string($conexion, $_POST['metodopago']);
$abono1 = mysqli_real_escape_string($conexion, $_POST['abono1']);
$fechapago = mysqli_real_escape_string($conexion, $_POST['fechapago']);
$pregunta1 = mysqli_real_escape_string($conexion, $_POST['pregunta1']);
$pregunta2 = mysqli_real_escape_string($conexion, $_POST['pregunta2']);
$pregunta3 = mysqli_real_escape_string($conexion, $_POST['pregunta3']);
$pregunta4 = mysqli_real_escape_string($conexion, $_POST['pregunta4']);
$pregunta5 = mysqli_real_escape_string($conexion, $_POST['pregunta5']);
$pregunta6 = mysqli_real_escape_string($conexion, $_POST['pregunta6']);

    $sql = "INSERT INTO `afiliados` (`fechaenvio`, `nombre`, `cargo`, `emailcorp`, `telefono`, `placa`,`nombrep`, `emailp`,`telefono1`, `telefono2`,`cedula`, `modelo`, `marca`, `tipologia`, `linea`, `cilindraje`, `empresaorigen`, `valorafiliacion`, `metodopago`, `abono1`, `fechapago`,`pregunta1`, `pregunta2`, `pregunta3`, `pregunta4`, `pregunta5`, `pregunta6` ) VALUES ('$fechaenvio', '$nombre', '$cargo', '$emailcorp', '$telefono', '$placa', '$nombrep','$emailp', '$telefono1', '$telefono2', '$cedula', '$modelo', '$marca', '$tipologia', '$linea', '$cilindraje', '$empresaorigen', '$valorafiliacion', '$metodopago', '$abono1', '$fechapago', '$pregunta1', '$pregunta2', '$pregunta3', '$pregunta4', '$pregunta5', '$pregunta6')";
    
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
         $mail->setFrom('archivoafiliados@sistemakv.com', 'ARCHIVOS AFILIADOS');
        $mail->addAddress('agerencia@kingvisiongroup.com', 'Asistente Gerencia');
        $mail->addAddress('desarrollo@ortsas.com', 'Desarrollo');
    
          $contenidocorreo = "placa: ". $placa . "\n";
$contenidocorreo .= "Responsable: " . $nombre . "\n";
$contenidocorreo .= "Fecha: " . $fechaenvio;
    
        // Configurar el asunto y el cuerpo del correo
        $mail->Subject = 'Archivos Afiliados ';
        $mail->Body = $contenidocorreo;
        
    
        // Adjuntar archivos
        for ($i = 1; $i <= 8; $i++) {
            $nombreArchivo = $_FILES['archivo' . $i]['name'];
            $rutaArchivo = $_FILES['archivo' . $i]['tmp_name'];
            if (!empty($nombreArchivo) && is_uploaded_file($rutaArchivo)) {
                $mail->addAttachment($rutaArchivo, $nombreArchivo);
            }
        }
    
        // Enviar el correo
        $mail->send();
       echo 'Archivos enviados correctamente.';
    } catch (Exception $e) {
      //echo 'Error al enviar el archivo. ' . $mail->ErrorInfo;
    }
    
    if ($conexion->query($sql) === TRUE) {
    echo "Formulario enviado correctamente.";
    
            

    } else {
        echo "Error al enviar el formulario: " . $conexion->error;
    }
}

   
?>
