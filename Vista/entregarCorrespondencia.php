<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Correspondencia.php");
require_once("../Modelo/Usuario.php");

/* VARIABLES MENU*/
$titulo = 'Entregar Correspondencia';
$redireccion = 'correspondencia.php';
$icono = 'fa fa-inbox';
$id = $_GET['id'];

$correspondencia = new Correspondencia();
$tipos = $correspondencia->listarTipos();

$datos_actuales = $correspondencia->listarPorId($id);

$usuario = new Usuario();
$listadoUsuarios = $usuario->listarUsuariosInternosEmpresa();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Entregar Correspondencia</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">

    <script src="../Resources/js/jquery.min.js"></script>
	<script src="../Resources/js/signature_pad.js"></script>
</head>
<body>

    <?php include("Template/menu.php"); ?>

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="correspondencia.php">Correspondencia</a></li>
            <li class="breadcrumb-item active" aria-current="page">Entregar Correspondencia</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
            
			<div class="row mt-12">
			  <div id="signature-pad" class="signature-pad" style="margin: 0 auto; text-align: center; width: 100%" >
			    <div class="signature-pad--body" >
			      <canvas style="width: 90%; height: 420px; border: 1px black solid;" id="canvas" name="canvas" required="required" ontouchend="habilitar()"></canvas>
			    </div>
			  </div>
			</div>

		    <form id="form" action="savedraw.php" method="post" style="margin: 0 auto; text-align: center; width: 100%">
			    <input type="hidden" name="id_doc" value="<?php echo $id;?>">
			    <input type="hidden" name="base64" value="" id="base64">
			    <button id="saveandfinish" class="btn btn-success" disabled="disabled">Guardar</button>
			    <a href="entregarCorrespondencia.php?id=<?php echo $id;?>"><button id="reset" class="btn btn-info" type="button">Limpiar</button></a>
			</form>

        </div>
    </section>

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">


        $( function() {
	        $( "#fecha_recibido" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        	maxDate: 0
	        });
	    } );
    </script>
    <script type="text/javascript">

var wrapper = document.getElementById("signature-pad");

var canvas = wrapper.querySelector("canvas");
var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)'
});



function resizeCanvas() {

  var ratio =  Math.max(window.devicePixelRatio || 1, 1);

  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext("2d").scale(ratio, ratio);

  signaturePad.clear();
}

window.onresize = resizeCanvas;
resizeCanvas();

</script>
<script>

    //Event if Drawn
    $("#canvas").click(function(){
       //alert("asdada");
       document.getElementById('saveandfinish').disabled = false;
    });

    function habilitar(){
      document.getElementById('saveandfinish').disabled = false;
    }

   document.getElementById('form').addEventListener("submit",function(e){


    var ctx = document.getElementById("canvas");
      var image = ctx.toDataURL(); // data:image/png....
      document.getElementById('base64').value = image;


   },false);

</script>
</body>
</html>

