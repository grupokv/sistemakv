<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Encuesta.php");
$ide = $_GET['id'];

$encuesta = new Encuesta();
$listado_tipos = $encuesta->listarTiposPregunta();
$titulo = 'Nueva Pregunta';
$redireccion = 'preguntasEncuesta.php?id='.$ide;
$icono = 'fa fa-pencil-square-o';

$listar_preguntas = $encuesta->listarPreguntasPorIdEncuesta($ide);
$cantidad = (count($listar_preguntas)+1);
?>
<!DOCTYPE html>
<html>
<head>    
<meta charset="utf-8">	
<title>SistemaKV | Nueva Pregunta</title>    
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
<a href="preguntasEncuesta.php?id=<?php echo $ide;?>">Preguntas</a>
</li>            
<li class="breadcrumb-item active" aria-current="page">Nueva Pregunta</li>         
</ol>    
</div>    
<section class="form-usuarios">        
<div class="formulario mb-5">	        
<form action="../Controlador/registrarPregunta.php" method="POST">	  
<input type="hidden" name="id_encuesta" value="<?php echo $ide;?>">      	
<?php include("Template/header-form.php"); ?>                     

<div class="row mt-3 ">                            
<div class="label">                                
<label>Pregunta</label>                            
</div>                            
<div class="input">                                
<input type="text" name="pregunta" id="pregunta" class="form-control" required="required">                            
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
<div class="row mt-3 mb-4">                            
<div class="label">                                
<label>Tipo de Pregunta</label>                            
</div>                            
<div class="input">                                
<select name="tipo" id="tipo" class="form-control selectpicker" data-live-search="true" required="required">        
<option value="">Seleccionar</option>                                        
<?php foreach ($listado_tipos as $lt){ ?>                                            
<option value="<?php echo $lt['id_tipo_pregunta']; ?>">                                                
<?php echo $lt['detalle']; ?>                                            
</option>                                        
<?php } ?>                                
</select>                            
</div>                        
</div>                

<?php include("Template/bottom-form.php"); ?>	        
</form>        
</div>    
</section>    
<?php include("Template/scripts.php"); ?>
</body>
</html>