<?php 
include ("../Controlador/Sesion/autenticar.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Formatos Calidad</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
  <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->

      <section class="home_content">  
          <div aria-label="breadcrumb" class="mt-1"> 
               <ol class="breadcrumb" style="background-color: #fff;">
                  <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Formatos Calidad</li>
               </ol>
          </div>

          <div class="notice notice-sistemakv">
            <strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">FORMATOS CALIDAD</b></strong>
          </div>

          <div class="mt-2 p-4 mb-3 table-responsive" style="background-color: #fff;">
          	<iframe allow-transparency="false" src="https://drive.google.com/embeddedfolderview?id=15EF_XeZIsOr4GqXsipTfWx3mfnJvQnFN#list&authuser=0" style="width:100%; height:auto; border:0; overflow-y: hidden;"></iframe>
          </div>
      </section>
    
    <!-- FIN CONTENIDO -->

    <!--**************************--->

    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>
    <!-- FIN SCRIPT -->

</body>
</html>