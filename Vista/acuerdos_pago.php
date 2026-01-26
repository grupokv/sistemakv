<?php 
    include("../Controlador/Sesion/autenticar.php");
    require_once '../Modelo/Operativo.php';
    require_once '../Modelo/Usuario.php';

    $operativo = new Operativo();
    $listarAcuerdosPago = $operativo->listarAcuerdosPago();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Acuerdos de Pago</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
        <style>

            table {
                font-size: .8rem;
            }

            thead{
                background-color: #fff;
                color: #fff;
            }

            th {
                border-radius: 13px;
                border: 3px solid #fff;
                background-color: #274054;
                color: #fff;
            }

            td {
                padding: 2px;
            }

        </style>
    <!-- FIN STYLES -->

</head>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->

    <!-- CONTENIDO -->

        <section class="home_content">

            <div aria-label="breadcrumb" class="mt-1">
                <ol class="breadcrumb" style="background: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Acuerdos de Pago</li>
                </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong>
                    <i class="fa fa-handshake-o mr-3" style="font-size: 2rem;"></i>
                    <b style="font-size:1.3rem;">ACUERDOS DE PAGO</b>
                </strong>
            </div>

            <div class="mt-2 p-4 table-responsive" style="background: #fff; border-radius: 5px;">
                <table id="dataTable" class="table table-hover table-sm display text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle;">ZONA</th>
                            <th style="vertical-align: middle;">PROPIETARIO</th>
                            <th style="vertical-align: middle;">PLACA</th>
                            <th style="vertical-align: middle;">TIPO VEHÍCULO</th>
                            <th style="vertical-align: middle;">MES</th>
                            <th style="vertical-align: middle;">TIPO SERVICIO</th>
                            <th style="vertical-align: middle;">CONDUCTOR</th>
                            <th style="vertical-align: middle;">CIUDAD SERVICIO</th>
                            <th style="vertical-align: middle;">TARIFA MENSUAL</th>
                            <th style="vertical-align: middle;">BASE S.S</th>
                            <th style="vertical-align: middle;">DIAS LABORADOS CONTRATO</th>
                            <th style="vertical-align: middle;">DIAS ADICIONALES DOMINICALES</th>
                            <th style="vertical-align: middle;">SERVICIOS ADICIONALES</th>
                            <th style="vertical-align: middle;">ADICIONALES FUERA DE CIUDAD</th>
                            <th style="vertical-align: middle;">HORAS ADICIONALES</th>
                            <th style="vertical-align: middle;">TOTAL HORAS ADICIONAL</th>
                            <th style="vertical-align: middle;">BASE DESCUENTOS</th>
                            <th style="vertical-align: middle;">(%) RETEFUENTE</th>
                            <th style="vertical-align: middle;">RETEFUENTE</th>
                            <th style="vertical-align: middle;">(%) ICA</th>
                            <th style="vertical-align: middle;">RETEICA</th>
                            <th style="vertical-align: middle;">OTROS DESCUENTOS</th>
                            <th style="vertical-align: middle;">TOTAL DESCUENTOS</th>
                            <th style="vertical-align: middle;">PEAJES</th>
                            <th style="vertical-align: middle;">PARQUEADERO</th>
                            <th style="vertical-align: middle;">CANT. PERNOTADAS</th>
                            <th style="vertical-align: middle;">PERNOTADAS</th>
                            <th style="vertical-align: middle;">TOTAL REEMBOLSABLES</th>
                            <th style="vertical-align: middle;">TOTAL A PAGAR</th>
                            <th style="vertical-align: middle;">PAGOS</th>
                            <th style="vertical-align: middle;">OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listarAcuerdosPago as $lap) { ?>
                            
                            <tr>
                                <td><?php echo $lap['zona_nomina']; ?></td>
                                <td><?php echo $lap['cc_propietario'] . ' - ' . $lap['propietario']; ?></td>
                                <td><?php echo $lap['placa']; ?></td>
                                <td><?php echo $lap['tipo_vehiculo']; ?></td>
                                <td><?php echo $lap['mes']; ?></td>
                                <td><?php echo $lap['tipo_servicio']; ?></td>
                                <td><?php echo $lap['conductor']; ?></td>
                                <td><?php echo $lap['ciudad_servicio']; ?></td>
                                <td><?php echo number_format($lap['tarifa_mensual']); ?></td>
                                <td><?php echo number_format($lap['base_ss']); ?></td>
                                <td><?php echo number_format($lap['dias_laborados_contrato']); ?></td>
                                <td><?php echo number_format($lap['dias_adicionales_dominicales']); ?></td>
                                <td><?php echo number_format($lap['servicios_adicionales']); ?></td>
                                <td><?php echo number_format($lap['adicionales_fuera_ciudad']); ?></td>
                                <td><?php echo number_format($lap['horas_adicionales']); ?></td>
                                <td><?php echo number_format($lap['total_horas_adicionales']); ?></td>
                                <td><?php echo number_format($lap['base_descuentos']); ?></td>
                                <td><?php echo number_format($lap['porcentaje_retefuente']); ?></td>
                                <td><?php echo number_format($lap['retefuente']); ?></td>
                                <td><?php echo number_format($lap['porcentaje_ica']); ?></td>
                                <td><?php echo number_format($lap['reteica']); ?></td>
                                <td><?php echo number_format($lap['otros_descuentos']); ?></td>
                                <td><?php echo number_format($lap['total_descuentos']); ?></td>
                                <td><?php echo number_format($lap['peajes']); ?></td>
                                <td><?php echo number_format($lap['parqueadero']); ?></td>
                                <td><?php echo number_format($lap['cant_pernotadas']); ?></td>
                                <td><?php echo number_format($lap['pernotadas']); ?></td>
                                <td><?php echo number_format($lap['total_reembolsables']); ?></td>
                                <td width="200"><?php echo "$ " . number_format($lap['total_pagar']); ?></td>
                                <td><?php echo $lap['estado']; ?></td>
                                <td>
                                    <?php
                                        if($lap['observaciones'] == ''){
                                            echo "-";
                                        }else{
                                            echo $lap['observaciones'];
                                        }
                                    ?>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>

      </section>

    <!-- FIN CONTENIDO -->
                 
    
    <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                pageLength : 5,
                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
                scrollX: true,
            });
        });
    </script>
 
</body>
</html>
