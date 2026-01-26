<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Encuesta.php");

$datos = $_GET['datos'];

$explode = explode('_',$datos);

$id_encuesta = $explode[0];
$id_pregunta = $explode[1];
$tipo_pregunta = $explode[2];


$encuesta = new Encuesta();
$titulo = 'Nueva Respuesta';
$redireccion = 'respuestasEncuesta.php?datos='.$datos;
$icono = 'fa fa-pencil-square-o';

$listar_respuestas = $encuesta->listarRespuestasPorIdPregunta($id_pregunta);
$cantidad = (count($listar_respuestas)+1);
?>
<!DOCTYPE html>
<html>
<head>    
<meta charset="utf-8">	
<title>SistemaKV | Nueva Respuesta</title>    
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">        
<?php include("Template/styles.php"); ?>    
<link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

<?php include("Template/menu.php"); ?>	
<div aria-label="breadcrumb" class="mt-1">          
<ol class="breadcrumb">            
<li class="breadcrumb-item" aria-current="page">
<a href="inicio.php">Inicio</a>
</li>            
<li class="breadcrumb-item" aria-current="page">
<a href="encuesta.php">Encuesta</a>
</li> 

<li class="breadcrumb-item" aria-current="page">
<a href="preguntasEncuesta.php?id=<?php echo $id_encuesta;?>">Preguntas</a>
</li>
<li class="breadcrumb-item" aria-current="page">
<a href="respuestasEncuesta.php?datos=<?php echo $datos;?>">Respuestas</a>
</li>            
<li class="breadcrumb-item active" aria-current="page">Nueva Respuesta</li>         
</ol>    
</div>    
<section class="form-usuarios">        
<div class="formulario mb-5">	        
<form action="../Controlador/registrarRespuesta.php" method="POST">	  
<input type="hidden" name="id_encuesta" value="<?php echo $id_encuesta;?>">  
<input type="hidden" name="id_pregunta" value="<?php echo $id_pregunta;?>">  
<input type="hidden" name="tipo_pregunta" value="<?php echo $tipo_pregunta;?>">      	
<?php include("Template/header-form.php"); ?>                     

<div class="row mt-3 ">                            
<div class="label">                                
<label>Respuesta</label>                            
</div>                            
<div class="input">                                
<input type="text" name="respuesta" id="respuesta" class="form-control" required="required">                            
</div>                        
</div>                        

<div class="row mt-3 ">                            
<div class="label">                                
<label>Orden</label>                            
</div>                            
<div class="input">                           
<select name="orden" id="orden" class="form-control" required="required">
	<?php for($i=1;$i<=$cantidad;$i++){ ?>
	<option value="<?php echo $i;?>" <?php if($i == $cantidad){ ?> selected="selected" <?php } ?> ><?php echo $i;?></option>
	<?php } ?>
</select>                         
</div>                        
</div>                                                
<input type="hidden" name="posicion" value="<?php echo $cantidad;?>"/>

<?php if(($tipo_pregunta == '4')or($tipo_pregunta == '5')){ ?>
<div class="row mt-3 mb-4">                            
<div class="label">                                
<label>Ampliacion</label>                            
</div>                            
<div class="input">                                
<select name="ampliacion" id="ampliacion" class="form-control" required="required">        
<option value="">Seleccionar</option>                                                
<option value="S">SI</option>
<option value="N">NO</option>                               
</select>                            
</div>                        
</div>                
<?php } else { ?>
<input type="hidden" name="ampliacion" value="N";/>
<?php } ?>

<?php include("Template/bottom-form.php"); ?>	        
</form>        
</div>    
</section>    
<?php include("Template/scripts.php"); ?>
</body>
</html>