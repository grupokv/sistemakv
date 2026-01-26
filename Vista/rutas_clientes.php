<?php 
include ("../Controlador/Sesion/autenticar.php");require_once("../Modelo/Cliente.php");
require_once '../Modelo/Usuario.php';
$usuario = new Usuario();$cliente = new Cliente();
/* VARIABLES MENU*/
$titulo = 'Rutas Clientes';
$icono = 'fa fa-bus';$listarC = $cliente->listar();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Rutas Clientes</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rutas Clientes</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Vista/listado_rutas_cliente.php" method="GET">
			  <?php include("Template/header-form.php"); ?> 
                          <div class="row mt-4 mb-4">                              <div class="label">                                      <label for="id_cliente">Cliente</label>                              </div>                              <div class="input">                                  <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente" onchange="cargarDatos(this.value)">                                      <option>Seleccionar Cliente</option>                                      <?php foreach ($listarC as $lc){ ?>                                        <option value="<?php echo $lc['id_cliente'] ?>">                                          <?php echo $lc['razon_social'] ?>                                        </option>                                      <?php } ?>                                  </select>                              </div>                          </div>
		                                        
			    <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    
</body>
</html>