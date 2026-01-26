<?php

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");

$operativo = new Operativo();
$cliente = new Cliente();
$usuario = new Usuario();

$listadoClientes = $cliente->listar();
$listarUsuariosEmisores = $usuario->listarUsuariosPermisosModOperativo();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SistemaKV | Asignación de Permisos</title>
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
                <li class="breadcrumb-item active" aria-current="page">Asignación de Permisos</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong>
                <i class="fa fa-gears mr-3" style="font-size: 2rem;"></i>
                <b style="font-size:1.3rem;">ASIGNACIÓN DE PERMISOS</b>
            </strong>
        </div>


        <section class="form-usuarios mt-1 p-3 mb-2">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
                <form action="../Controlador/AsignacionPermisosOperativo.php" method="POST" enctype="multipart/form-data">

                    <!-- USUARIO -->
                        <div class="row mt-4">
                            <div class="label">
                                <label>Usuario(s)</label>
                            </div>
                            <div class="input">
                                <select class="form-control" data-live-search="true"
                                    name="id_usuario[]" id="id_usuario" required="required" multiple="multiple">
                                    <?php foreach ($listarUsuariosEmisores as $lue){ ?>
                                        <option value="<?php echo $lue['id_usuario'] ?>"><?php echo $lue['nombre'] ?>
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
                                    <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                                    <option value="AUDITOR">AUDITOR</option>
                                    <option value="SUPERVISOR">SUPERVISOR</option>
                                    <option value="OPERATIVO">OPERATIVO</option>
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
                                    <option value="INTERNO">INTERNO</option>
                                    <option value="EXTERNO">EXTERNO</option>
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
                                    <option value="">NINGUNO</option>
                                    <option value="ALL">TODOS</option>
                                    <?php foreach ($listadoClientes as $lc){ ?>
                                        <option value="<?php echo $lc['id_cliente']; ?>">
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
                                    <option value="S">SOLICITUD</option>
                                    <option value="SASV">SOLICITUD + ASIGNACIÓN DEL SERVICIO (SIN VALORES)</option>
                                    <option value="SACV">SOLICITUD + ASIGNACIÓN DEL SERVICIO (CON VALORES)</option>
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
                                    <option value="">SELECCIONAR</option>
                                    <option value="1">INDIVIDUAL</option>
                                    <option value="2">POR CLIENTE</option>
                                    <option value="3">POR PRODUCTO</option>
                                    <option value="4">POR MOVIL</option>
                                    <option value="5">MOVIL POR RECORRIDO</option>
                                    <option value="ALL">TODOS</option>
                                    <option value="NONE">NINGUNO</option>
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
                                    <option value="S">SOLICITUD DEL SERVICIO</option>
                                    <option value="All">SOLICITUD Y ASIGNACIÓN DEL SERVICIO</option>
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
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
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
                $("#id_usuario").chosen(); 
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