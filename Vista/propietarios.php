<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Propietario.php");
require_once ("../Modelo/Usuario.php");
require_once ("../Modelo/General.php");

$propietario = new Propietario();
$listarPropietarios = $propietario->listarPropietarios();

$modulo = 121;
$permisos = permisos($modulo,$_SESSION['id_usuario']);
//print_r($permisos);
if(count($permisos) < 1){
	echo ("<script LANGUAGE='JavaScript'>
    window.location.href='https://www.sistemakv.com/';
    </script>");
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Propietarios</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->

    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style>

        table {
            font-size: .8rem;
        }

        thead {
            background-color: #fff;
        }

        tr {
            background-color: #fff;
        }

        th {
            border-radius: 10px;
            border: 3px solid #fff;
            background-color: #274054;
            color: #fff;
        }

        table thead th{
            border-bottom: none !important;
            border-top: none !important;
        }

        #contEstado {
            width: 20px;
            height: 20px;
            border-radius: 30%;
            cursor: pointer;
        }

        .infoVeh{
            color: #6e6e6e; 
            font-size:1rem; 
            border-radius:50%; 
            cursor:pointer;
        }
        

    </style>

  <!--FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
  
    <!-- CONTENIDO -->
  
        <section class="home_content">  
        
            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-user mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">PROPIETARIOS</b></strong>
            </div>

            <div class="notice notice-sistemakv p-2">
                <?php if($permisos[0]['agregacion'] == 1){ ?>
                    <a href="registrarPropietarios.php" type="button" class="btn" id="buttonsKV">Registrar Propietario<i class="fa fa-plus-circle ml-1"></i></a>
                <?php } ?>
            </div>

            <div class="mt-2 mb-4 table-responsive p-4" style="background-color: #fff; border-radius: 5px;">
                <table id="dataT" class="table table-hover table-sm display text-center" style="width:100%;">
                    <thead>
                        <tr class="text-center">
                            <th style="vertical-align: top;">ID</th>
                            <th style="vertical-align: top;" width="140px;">NOMBRE O RAZÓN</th>
                            <th style="vertical-align: top;">NO. IDENTIFICACIÓN</th>
                            <th style="vertical-align: top;">TELÉFONO</th>
                            <th style="vertical-align: top;">CORREO</th>
                            <th style="vertical-align: top;">CIUDAD</th>
                            <th style="vertical-align: top;">DIRECCIÓN</th>
                            <th style="vertical-align: top;"></th>
                            <th style="vertical-align: top;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($listarPropietarios as $lp) { 
	                        $listarUsuarioCreador = $usuario->listarUsuarioPorId($lp['id_usuario_registro']);
	                        $listarUsuarioModificador = $usuario->listarUsuarioPorId($lp['id_usuario_ulima_modificacion']);
                            ?>
                            <tr>
                                <td><?php echo str_pad($lp['id_propietario'], 5, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo $lp['nombre']; ?></td>
                                <td><?php echo $lp['numero_documento']; ?></td>
                                <td><?php echo $lp['telefono']; ?></td>
                                <td><?php echo $lp['correo']; ?></td>
                                <td><?php echo $lp['ciudad']; ?></td>
                                <td><?php echo $lp['direccion']; ?></td>
                                <td>
                                    <a href="actualizarPropietario.php?id_propietario=<?php echo $lp['id_propietario'] ?>" class="btn btn-outline-info" style="margin: 2px; padding: 0px 2px 0px 2px;"><i class="fa fa-edit"></i></a>
                                </td>
                                <td>
                                    <i data-bs-toggle="tooltip" data-bs-placement="left" title="Creado el: <?php echo strtoupper(date("d-m-Y g:i a", strtotime($lp['fecha_registro']))) . ' - Por: '. $listarUsuarioCreador[0]['nombre'] ?> " style="color: #6e6e6e; font-size:1rem; border-radius:50%; cursor:pointer;" class="fa fa-exclamation-circle"></i>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>

        </section>

    <!-- FIN CONTENIDO -->

    <!--**************************--->

    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>

        <script type="text/javascript">
            
        </script>
    <!-- FIN SCRIPT -->


  
</body>
</html>