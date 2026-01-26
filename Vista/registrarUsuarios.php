<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Perfil.php");
require_once("../Modelo/Cargo.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Usuarios';
$redireccion = 'usuarios.php';
$icono = 'fa fa-user-o';

/**/
$perfil = new Perfil();
$listarP = $perfil->listar();

$cargo = new Cargo();
$listarC = $cargo->listarCargos();

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Registrar usuario</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->


<section class="home_content">

    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="usuarios.php">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar usuarios</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
      <strong>
        <i class="fa fa-users mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">REGISTRAR USUARIOS</b>
      </strong>
    </div>


    <section class="form-usuarios mt-1 mb-5">
      <div class="formulario mb-3">
        <form method="POST" action="../Controlador/registrarUsu.php">    

          <!-- NOMBRE -->
            <div class="row mt-4 mb-4 ">
                <div class="label">    
                    <label>Nombre</label>
                </div>
                <div class="input">    
                    <input type="text" name="nombre" id="nombre" class="form-control">
                </div>
            </div>

          <!-- CORREO ELECTRONICO -->
            <div class="row mb-4 ">
                <div class="label">    
                    <label>Correo electronico</label>
                </div>
                <div class="input">    
                    <input type="text" name="correo_electronico" id="correo_electronico" class="form-control">
                </div>
            </div>

          <!-- NUMERO DE DOCUMENTO -->
            <div class="row mb-4 ">
                <div class="label">    
                    <label>Numero de Documento</label>
                </div>
                <div class="input">    
                    <input type="text" name="numero_documento" id="numero_documento"  class="form-control">
                </div>
            </div>

          <!-- CARGO -->
            <div class="row mb-4 ">
                <div class="label">    
                    <label for="speed">Cargo</label>
                </div>
                <div class="input">
                    <select class="form-control selectpicker" data-live-search="true" name="id_cargo" id="id_cargo">
                        <option value="">SELECCIONAR</option>
                        <?php foreach ($listarC as $lc){ ?>
                          <option value="<?php echo $lc['id_cargo'] ?>">
                            <?php echo $lc['nombre_cargo'] ?>
                          </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

          <!-- PERFIL -->
            <div class="row mb-4 ">
                <div class="label">    
                    <label for="speed1">Perfil</label>
                </div>
                <div class="input">    
                    <select class="form-control selectpicker" data-live-search="true" name="id_perfil" id="id_perfil">
                        <option value="">SELECCIONAR</option>
                        <?php foreach ($listarP as $lp){ ?>
                            <option value="<?php echo $lp['id_perfil'] ?>">
                                <?php echo $lp['nombre_perfil'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>


          <section class="col-12 mt-4 mb-4 d-flex justify-content-center">
              <a href="usuarios.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
              <button type="submit" class="btn btn-outline-info col-3">Registrar</button>
          </section>
          
        </form>
      </div>
    </section>

    <?php include("Template/scripts.php"); ?>

</body>
</html>