<?php
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/NotificacionInternaAdministrativo.php';

$notiModel = new NotificacionInternaAdministrativo();
$notificaciones = $notiModel->listarPorUsuario((int)$_SESSION['id_usuario']);
function limpiarContenidoNotificacion($texto)
{
    $texto = (string)$texto;
    $texto = preg_replace('/\sel\s\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}\.?/i', '', $texto);
    return trim($texto);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Notificaciones Internas Administrativos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
</head>
<body>
<?php include("Template/header.php"); ?>
<?php include("Template/newMenu.php"); ?>
<section class="home_content">
    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-bell-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">NOTIFICACIONES INTERNAS ADMINISTRATIVOS</b></strong>
    </div>

    <div class="card p-3 mt-2" style="border:0;">
        <div class="table-responsive">
            <table id="dataT" class="table table-bordered table-sm text-center">
                <thead>
                <tr style="background:#1b2d3b;color:#fff;">
                    <th>N° de notificación</th>
                    <th>Remitente</th>
                    <th>Área</th>
                    <th>Fecha y hora</th>
                    <th>Contenido</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($notificaciones) < 1) { ?>
                    <tr><td colspan="7" class="text-muted">No hay notificaciones.</td></tr>
                <?php } else { ?>
                    <?php foreach ($notificaciones as $n) { ?>
                        <tr>
                            <td><?php echo (int)$n['id_notificacion']; ?></td>
                            <td><?php echo htmlspecialchars($n['remitente']); ?></td>
                            <td><?php echo htmlspecialchars($n['area']); ?></td>
                            <td><?php echo htmlspecialchars($n['fecha_hora']); ?></td>
                            <td class="text-left"><?php echo htmlspecialchars(limpiarContenidoNotificacion($n['contenido'])); ?></td>
                            <td>
                                <?php if ((int)$n['leido'] === 1) { ?>
                                    <span class="badge badge-success">Leído</span>
                                <?php } else { ?>
                                    <span class="badge badge-warning">No leído</span>
                                <?php } ?>
                            </td>
                           <td style="text-align:center; vertical-align:middle;">
    <a href="../Controlador/abrirNotificacionInternaAdministrativa.php?id_notificacion=<?php echo (int)$n['id_notificacion']; ?>"
       title="Abrir notificación"
       style="
           position:relative;
           display:inline-block;
           width:32px;
           height:32px;
           background:#1b2d3b;
           border-radius:6px;
           text-decoration:none;
       ">

        <i class="fa fa-bell"
           style="
           position:absolute;
           top:50%;
           left:50%;
           transform:translate(-50%, -50%);
           font-size:15px;
           color:#ffd600;
           "></i>

    </a>
</td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include("Template/scripts.php"); ?>
</body>
</html>