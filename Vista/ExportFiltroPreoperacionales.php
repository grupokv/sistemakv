<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/EmpresaEnt.php");

/* VARIABLES MENU*/
$titulo = 'Filtrar Reporte Preoperacional';
$redireccion = 'preoperacionales.php';
$icono = 'fa fa-file-text-o';

$contrato = new Contrato();
$empresa = new Empresa();
$cliente = new Cliente();

$hoy = date('Y-m-d');
$listadoContratos = $contrato->listarContratos();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SistemaKV | Reporte Salud</title>
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
                <li class="breadcrumb-item" aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="reporte_salud.php">Reporte Salud</a></li>
                <li class="breadcrumb-item active" aria-current="page">Filtro</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b
                    style="font-size: 1.2rem;">REPORTE PREOPERACIONAL Y DESINFECCIÓN</b></strong>
        </div>

        <section class="form-usuarios mt-1 mb-3">
            <div class="formulario mb-3">

                <!-- FORMULARIO -->
                <form method="POST" action="../Vista/informeExcelPreoperacional.php">

                    <!-- Tipo de Reporte de -->
                    <div class="row mt-4 mb-4 ">
                        <div class="label">
                            <label>Reporte de</label>
                        </div>
                        <div class="input">
                            <select class="form-control selectpicker" data-live-search="true" name="tipoReporte"
                                required="required">
                                <option value="">SELECCIONAR</option>
                                <option value="PREOPERACIONAL">PREOPERACIONAL</option>
                                <option value="DESINFECCION">PROTOCOLO DESINFECCIÓN</option>

                            </select>
                        </div>
                    </div>

                    <!-- Validación de registros -->
                    <div class="row mt-4 mb-4 ">
                        <div class="label">
                            <label>Validar Registro de la información</label>
                        </div>
                        <div class="input">
                            <select class="form-control selectpicker" data-live-search="true"
                                name="registroPreoperacional" required="required">
                                <option value="">SELECCIONAR</option>
                                <option value="S">SI</option>
                                <option value="N">NO</option>

                            </select>
                        </div>
                    </div>

                    <!-- Mes -->
                    <div class="row mt-4 mb-4 ">
                        <div class="label">
                            <label>Mes</label>
                        </div>
                        <div class="input">
                            <input type="text" name="mes" id="monthpicker" class="form-control" autocomplete="off"
                                required="required">
                        </div>
                    </div>

                    <!-- Contrato -->
                    <div class="row mt-4 mb-4 ">
                        <div class="label">
                            <label>Contrato</label>
                        </div>
                        <div class="input">
                            <select class="form-control selectpicker" data-live-search="true" name="id_contrato"
                                onchange="listado_vehiculos(this.value)" required="required">
                                <option value="">SELECCIONAR</strong></option>
                                <?php foreach ($listadoContratos as $lc){ ?>
                                <?php $datos_cliente = $cliente->cliente_ID($lc['id_cliente']);           
                                        $datos_empresa = $empresa->listarPorId($lc['id_empresa']);?>

                                    <option width="100" value="<?php echo $lc['id_contrato'];?>">
                                        <?php if($lc['fecha_final_contrato'] < $hoy){ ?>
                                            <?php echo "( VENCIDO ) - " .  $lc['id_contrato']. " | " . $datos_cliente[0]['razon_social']; ?>
                                        <?php } else if($lc['fecha_final_contrato'] > $hoy){ ?> 
                                            <?php echo "( ACTIVO ) - " .  $lc['id_contrato']. " | " . $datos_cliente[0]['razon_social']; ?>
                                        <?php } ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <section class="col-12 mt-4 mb-3 p-3 d-flex justify-content-center">
                        <a href="clientes.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                        <button type="submit" class="btn btn-outline-info col-3">Filtrar</button>
                    </section>

                </form>
            </div>
        </section>



        <?php include("Template/scripts.php"); ?>

        <script type="text/javascript">
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $(function() {
            var dateFormat = "dd/mm/yy",
                from = $("#datepicker")
                .datepicker({
                    maxDate: 0,
                    changeMonth: true,
                    changeYear: true,
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#datepicker1").datepicker({
                    maxDate: 0,
                    changeMonth: true,
                    changeYear: true,
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
        });

        $("#monthpicker").MonthPicker({
            IsRTL: true,
            i18n: {
                months: ["Enero", "Feb", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agos", "Sept", "Oct",
                    "Nov", "Dic"
                ],
                buttonText: "",
            }
        });
        </script>

</body>

</html>