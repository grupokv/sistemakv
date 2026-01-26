<?php

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");

$operativo = new Operativo();
$cliente = new Cliente();
$usuario = new Usuario();

$id = $_GET['id'];

$listadoClientes = $cliente->listar();
$listarPermisosID = $operativo->listarPermisosUsuariosOperativoID($id);
$listarUsuariosEmisores = $usuario->listarUsuariosPermisosModOperativo();
//print_r($listarPermisosID);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SistemaKV | Actualización de Permisos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

</head>

<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>

    <section class="home_content">
        <div aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="permisosUsuariosOperativo.php">Permisos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Actualización de Permisos</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong>
                <i class="fa fa-gears mr-3" style="font-size: 2rem;"></i>
                <b style="font-size:1.3rem;">ACTUALIZACIÓN DE PERMISOS</b>
            </strong>
        </div>


        <section class="form-usuarios mt-1 p-3 mb-2">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
                <form action="../Controlador/AsignacionPermisosOperativo.php" method="POST" enctype="multipart/form-data">
                    <?php foreach($listarPermisosID as $lpid){ 
                        $id_clientes = explode(",", $lpid['id_cliente']);
                        $reportes = explode(",", $lpid['lectura_reportes']);

                        ?>
                    <!-- USUARIO -->
                        <div class="row mt-4">
                            <div class="label">
                                <label>Usuario(s)</label>
                            </div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="id_usuario[]" id="id_usuario" required="required" disabled>
                                    <?php foreach ($listarUsuariosEmisores as $lue){ ?>
                                        <option value="<?php echo $lue['id_usuario'] ?>" <?php if($lpid['id_usuario'] == $lue['id_usuario']){ ?> selected <?php } ?>>
                                            <?php echo $lue['nombre'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
   
                    <!-- ROLES -->
                        <div class="row mt-4">
                            <div class="label">
                                <label>Rol</label>
                            </div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="rol" id="rol" required="required">
                                    <option value="">SELECCIONAR</option>
                                    <option value="ADMINISTRATIVO" <?php if($lpid['rol'] == 'ADMINISTRATIVO'){ ?> selected <?php } ?>>ADMINISTRATIVO</option>
                                    <option value="AUDITOR" <?php if($lpid['rol'] == 'AUDITOR'){ ?> selected <?php } ?>>AUDITOR</option>
                                    <option value="SUPERVISOR" <?php if($lpid['rol'] == 'SUPERVISOR'){ ?> selected <?php } ?>>SUPERVISOR</option>
                                    <option value="OPERATIVO" <?php if($lpid['rol'] == 'OPERATIVO'){ ?> selected <?php } ?>>OPERATIVO</option>
                                </select>
                            </div>
                        </div>
                    
                    <!-- TIPO DE USUARIO -->
                        <div class="row mt-4">
                            <div class="label">
                                <label>Tipo de Usuario</label>
                            </div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="tipo_usuario" id="tipo_usuario" required="required">
                                    <option value="">SELECCIONAR</option>
                                    <option value="INTERNO" <?php if($lpid['tipo_usuario'] == 'INTERNO'){ ?> selected <?php } ?>>INTERNO</option>
                                    <option value="EXTERNO" <?php if($lpid['tipo_usuario'] == 'EXTERNO'){ ?> selected <?php } ?>>EXTERNO</option>
                                </select>
                            </div>
                        </div>

                    <!-- CLIENTE -->
                        <div class="row mt-4">
                            <div class="label">
                                <label>Cliente(s)</label>
                            </div>
                            <div class="input">
                                <select class="form-control" data-live-search="true"
                                    name="id_cliente[]" id="id_cliente" required="required" multiple="multiple">
                                    <option value="ALL" <?php if($lpid['id_cliente'] == 'ALL'){ ?> selected <?php } ?> >TODOS</option>
                                    <?php foreach ($listadoClientes as $lc){ ?>
                                        <option value="<?php echo $lc['id_cliente']; ?>" <?php if(in_array($lc['id_cliente'], $id_clientes)){ ?> selected <?php } ?>>
                                            <?php echo $lc['razon_social'] . ' - Nit: ' . $lc['nit_cliente'];  ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    <!-- CONSULTA -->
                        <div class="row mt-4">
                            <div class="label">
                                <label>Consulta</label>
                            </div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="consulta" id="consulta" required="required" onchange="validarConsulta(this.value);">
                                    <option value="">SELECCIONAR</option>
                                    <option value="S" <?php if($lpid['consulta'] == 'S'){ ?> selected <?php } ?> >SOLICITUD</option>
                                    <option value="SASV" <?php if($lpid['consulta'] == 'SASV'){ ?> selected <?php } ?> >SOLICITUD + ASIGNACIÓN DEL SERVICIO (SIN VALORES)</option>
                                    <option value="SACV" <?php if($lpid['consulta'] == 'SACV'){ ?> selected <?php } ?> >SOLICITUD + ASIGNACIÓN DEL SERVICIO (CON VALORES)</option>
                                </select>
                            </div>
                        </div>

                    <!-- VALOR CLIENTE -->
                        <div class="row mt-4" id="ValorCliente" style="display:none;">
                            <div class="label">
                                <label>Valor Cliente <i style="color:#5e99b1;" class="fa fa-eye ml-1"></i></label>
                            </div>
                            <div class="input">
                                <input type="checkbox" name="valor_cliente" id="valor_cliente">
                            </div>
                        </div>

                    <!-- LECTURA DE REPORTES -->
                        <div class="row mt-4">
                            <div class="label">
                                <label>Lectura de Reportes (EXCEL)</label>
                            </div>
                            <div class="input">
                                <select class="form-control form-control-sm" data-live-search="true"
                                    name="lectura_reportes[]" id="lectura_reportes" required="required" multiple="multiple">
                                    <?php for ($i=0; $i < count($reportes); $i++) { ?>
                                        <option value="">SELECCIONAR</option>
                                        <option value="1" <?php if($reportes[$i] == '1'){ ?> selected <?php } ?> >INDIVIDUAL</option>
                                        <option value="2" <?php if($reportes[$i] == '2'){ ?> selected <?php } ?> >POR CLIENTE</option>
                                        <option value="3" <?php if($reportes[$i] == '3'){ ?> selected <?php } ?> >POR PRODUCTO</option>
                                        <option value="4" <?php if($reportes[$i] == '4'){ ?> selected <?php } ?> >POR MOVIL</option>
                                        <option value="5" <?php if($reportes[$i] == '5'){ ?> selected <?php } ?> >MOVIL POR RECORRIDO</option>
                                        <option value="ALL" <?php if($reportes[$i] == 'ALL'){ ?> selected <?php } ?> >TODOS</option>
                                        <option value="NONE" <?php if($reportes[$i] == 'NONE'){ ?> selected <?php } ?> >NINGUNO</option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                    <!-- REGISTRO -->
                        <div class="row mt-4">
                            <div class="label">
                                <label>Registro</label>
                            </div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="registro" id="registro" required="required">
                                    <option value="">SELECCIONAR</option>
                                    <option value="S" <?php if($lpid['registro'] == 'S'){ ?> selected <?php } ?> >SOLICITUD DEL SERVICIO</option>
                                    <option value="ALL" <?php if($lpid['registro'] == 'ALL'){ ?> selected <?php } ?> >SOLICITUD Y ASIGNACIÓN DEL SERVICIO</option>
                                </select>
                            </div>
                        </div>

                    <!-- ANULACIÓN -->
                        <div class="row mt-4">
                            <div class="label">
                                <label>Anular Servicio</label>
                            </div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="anulacion" id="anulacion" required="required">
                                    <option value="">SELECCIONAR</option>
                                    <option value="SI" <?php if($lpid['anulacion'] == 'SI'){ ?> selected <?php } ?> >SI</option>
                                    <option value="NO" <?php if($lpid['anulacion'] == 'SO'){ ?> selected <?php } ?> >NO</option>
                                </select>
                            </div>
                        </div>
                    
                    <!-- BOTONES -->
                        <section class="col-12 mt-5 d-flex justify-content-center">

                            <!-- CANCELAR REGISTRO -->
                            <a href="permisosUsuariosOperativo.php"
                                class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>

                            <!-- REGISTRAR -->
                            <button type="submit" id="Registrar"
                                class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Guardar</button>

                        </section>
                    <!-- FIN BOTONES -->

                    <?php } ?>

                </form>

                <!--FIN FORMULARIO-->

            </div>
        </section>
    </section>

    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>
        <script>
           

            $( function() {
                $("#id_cliente").chosen(); 
                $("#lectura_reportes").chosen(); 
            });

            function validarConsulta(val){
                if (val == 'SACV') {
                    document.getElementById("ValorCliente").style.display = 'flex';
                }else{
                    document.getElementById("ValorCliente").style.display = 'none';
                }
            }

            

        </script>
    <!-- FIN SCRIPT -->

</body>

</html>