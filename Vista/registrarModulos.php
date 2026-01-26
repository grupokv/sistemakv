<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Modulo.php");

$modulos = new Modulo();
$listarModulos = $modulos->listar();

/* VARIABLES MENU*/
$titulo = 'Registrar Modulos';
$redireccion = 'modulos.php';
$icono = 'fa fa-cubes';

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Modulo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="modulos.php">Modulos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Modulos</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarMod.php" method="POST">
	        	<?php include("Template/header-form.php"); ?> 
                    <!--NOMBRE AREA-->
                        <div class="row mt-3 ">
                            <div class="label">
                                <label>Nombre Modulo</label>
                            </div>
                            <div class="input">
                                <input type="text" name="nombre_modulo" id="nombre_modulo" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="label">
                                <label>¿Hace parte del menu principal?</label>
                            </div>
                            <div class="input">
                                <select class="form-control" name="menu" id="menu">
                                    <option value="0">Seleccionar</option>
                                    <option value="N">No</option>
                                    <option value="S">Si</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="label">
                                <label>¿Es un modulo padre?</label>
                            </div>
                            <div class="input">
                                <select class="form-control" name="modulo_padre"  id="modulo_padre" onchange="listarModulos()">
                                    <option value="0">Seleccionar</option>
                                    <option value="1">No</option>
                                    <option value="2">Si</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3 mb-4" id="padre" style="display: none;">
                            <div class="label">
                                <label>¿De que modulo dependerá?</label>
                            </div>
                            <div class="input">
                                <select name="id_padre" id="id_padre" class="form-control selectpicker" data-live-search="true">
                                        <option>Seleccionar</option>
                                        <?php foreach ($listarModulos as $lm){ ?>
                                            <option value="<?php echo $lm['id_modulo'] ?>">
                                                <?php echo ($lm['nombre_modulo']) ?>
                                            </option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3 " id="link_modulo" style="display: none;">
                            <div class="label">
                                <label>Link del Modulo</label>
                            </div>
                            <div class="input">
                                <input type="text" name="link" id="link" class="form-control">
                            </div>
                        </div>

                <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

        function listarModulos(){

            var padre = document.getElementById('modulo_padre').value;
            var menu = document.getElementById('menu').value;
            
            /*padre 1 = No ----- padre 2 = Si*/
            /*menu  S = si ----- menu N = no */
            
            if ((menu == 'S') && (padre == 2)) {
                
                document.getElementById('padre').style.display = 'none';
                document.getElementById('link_modulo').style.display = 'none';
                
            }else if ((menu == 'N') && (padre == 2)){
                
                document.getElementById('padre').style.display = 'none';
                document.getElementById('link_modulo').style.display = 'flex';
                
            }else if((menu == 'S') && (padre == 1)){
            
                document.getElementById('padre').style.display = 'flex';
                document.getElementById('link_modulo').style.display = 'flex';
                
            }else{
                
                document.getElementById('padre').style.display = 'none';
                document.getElementById('link_modulo').style.display = 'none';
            }

        }
        
        
    </script>
</body>
</html>