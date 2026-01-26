<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Encuesta.php");

$id = $_GET['id'];
$encuesta = new Encuesta();
$listado_tipos = $encuesta->listarTipos();

$datos = $encuesta->listarPorId($id);

$titulo = 'Editar Encuesta';
$redireccion = 'encuesta.php';
$icono = 'fa fa-pencil-square-o'; 
?>
<!DOCTYPE html>
<html>
<head>    
<meta charset="utf-8">	
<title>SistemaKV | Editar Encuesta</title>    
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">        
<?php include("Template/styles.php"); ?>    
<link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>

<body>    
<?php include("Template/menu.php"); ?>	
<div aria-label="breadcrumb" class="mt-1">          
<ol class="breadcrumb">            
<li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>            
<li class="breadcrumb-item " aria-current="page"><a href="encuesta.php">Encuesta</a></li>            
<li class="breadcrumb-item active" aria-current="page">Editar Encuesta</li>         
</ol>    
</div>    

<section class="form-usuarios">        
<div class="formulario mb-5">	        
<form action="../Controlador/editarEncuesta.php" method="POST">
<input type="hidden" name="id" value="<?php echo $id;?>" />      	
<?php include("Template/header-form.php"); ?>                     
<div class="row mt-3 ">                            
<div class="label">                                
<label>Nombre Encuesta</label>                            
</div>                            
<div class="input">                                
<input type="text" name="nombre" id="nombre" class="form-control" required="required" value="<?php echo $datos[0]['nombre_encuesta']; ?>">                            
</div>                        
</div>                        

<div class="row mt-3 ">                            
<div class="label">                                
<label>Descripcion</label>                            
</div>                            
<div class="input">                                
<textarea name="descripcion" id="descripcion" class="form-control"><?php echo $datos[0]['descripcion'];?></textarea>         
</div>                        
</div>                                                

<div class="row mt-3">                            
<div class="label">                                
<label>Estado</label>                            
</div>                            
<div class="input">                                
<select class="form-control" name="estado" id="estado" required="required">                                    
<option value="">Seleccionar</option>                                    
<option value="1" <?php if($datos[0]['estado'] == 1){ ?> selected="selected" <?php } ?> >Activa</option>                             
<option value="0" <?php if($datos[0]['estado'] == 0){ ?> selected="selected" <?php } ?> >Inactiva</option>                           </select>                            
</div>                        
</div>                        

<div class="row mt-3 mb-4">                            
<div class="label">                                
<label>Tipo de Encuesta</label>                            
</div>                            
<div class="input">                                
<select name="tipo" id="tipo" class="form-control selectpicker" data-live-search="true" required="required">                 
<option value="">Seleccionar</option>                                        
<?php foreach ($listado_tipos as $lt){ ?>                                            
<option value="<?php echo $lt['id_tipo_encuesta']; ?>" <?php if($lt['id_tipo_encuesta'] == $datos[0]['id_tipo_encuesta']) { ?> selected="selected" <?php } ?> >                                                
<?php echo $lt['detalle_tipo']; ?>                                            
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