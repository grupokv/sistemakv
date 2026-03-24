<?php
require_once(__DIR__ . "/../Controlador/Sesion/autenticar.php");
require_once(__DIR__ . "/../Modelo/Cliente.php");
require_once(__DIR__ . "/../Modelo/TipoVehiculo.php");
require_once(__DIR__ . "/../Modelo/EmpresaEnt.php");
require_once(__DIR__ . "/../Modelo/Ciudad.php");
require_once(__DIR__ . "/../Modelo/Segmento.php");
require_once(__DIR__ . "/../Modelo/Pais.php");

$cliente = new Cliente();
$listarClientes = $cliente->listar();

$tipoVehiculo = new TipoVehiculo();
$listarTV = $tipoVehiculo->listar();

$empresa = new Empresa();
$listarEmpresas = $empresa->listar();

$ciudad = new Ciudad();
$ciudades = $ciudad->listar();

$segmento = new Segmento();
$segmentos = $segmento->listar();

$pais = new Pais();
$paises = $pais->listar();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Registrar Reserva Ocasional</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style>
        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
            background: #1b2d3b !important;
            border: #fff;
        }
    </style>
</head>
<body>

<?php include("Template/header.php"); ?>
<?php include("Template/newMenu.php"); ?>

<section class="home_content">
    <div aria-label="breadcrumb" class="mt-1">
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="serviciosOcasionales.php">Servicios Ocasionales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Reserva Ocasional</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-calendar-plus-o mr-3" style="font-size: 2rem;"></i>REGISTRAR RESERVA OCASIONAL</strong>
    </div>

    <section class="form-usuarios mt-1 p-3 mb-2">
        <div class="formulario mt-3 mb-3" style="width: 100%;">
            <form action="../Controlador/registrarReservaOcasional.php" method="POST" id="registroReservaOcasional" enctype="multipart/form-data">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Cliente</a></li>
                        <li><a href="#tabs-2">Información Servicio</a></li>
                        <li><a href="#tabs-3">Documentos</a></li>
                        <li><a href="#tabs-4">Detalles del servicio</a></li>
                    </ul>

                    <div id="tabs-1" class="p-4">
                        <div class="row mt-3">
                            <div class="label">
                                <label>Seleccione el tipo de registro <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                            </div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true" name="opcionCliente" id="opcionCliente" onchange="validarOpcionCliente(this.value);" required="required">
                                    <option value="">SELECCIONAR</option>
                                    <option value="BA">Buscar y Anclar</option>
                                    <option value="RN">Registrar Nuevo</option>
                                </select>
                            </div>
                        </div>

                        <div id="contentExistingCliente" style="display: none;">
                            <div class="row mt-3">
                                <div class="label">
                                    <label>Cliente</label>
                                </div>
                                <div class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_cliente_existente" id="id_cliente_existente">
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($listarClientes as $lc){ ?>
                                            <option value="<?php echo $lc['id_cliente']; ?>"><?php echo $lc['razon_social'] . ' - ' . $lc['nit_cliente']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="contentNewCliente" style="display: none;">
                            <div class="row mt-3">
                                <div class="label"><label>Razón social <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input"><input type="text" name="razon_social" id="razon_social" class="form-control form-control-sm"></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Sigla</label></div>
                                <div class="input"><input type="text" name="sigla" id="sigla" class="form-control form-control-sm"></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>NIT o cédula <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input"><input type="text" name="nit_cliente" id="nit_cliente" class="form-control form-control-sm" onchange="validarNitCliente(this.value);"></div>
                            </div>

                            <section class="row d-flex justify-content-center">
                                <div class="col-10 mt-3 text-center" style="border-radius: 8px; background-color: #d9534f; display:none;" id="validarValorCliente"></div>
                            </section>

                            <div class="row mt-3">
    <div class="label"><label>Correo contacto comercial</label></div>
    <div class="input">
        <input type="email" name="correo_electronico" id="correo_electronico" class="form-control form-control-sm">
    </div>
</div>

<div class="row mt-3">
    <div class="label"><label>Correo facturación</label></div>
    <div class="input">
        <input type="email" name="correo_facturacion" id="correo_facturacion" class="form-control form-control-sm">
    </div>
</div>

                            <div class="row mt-3">
                                <div class="label"><label>Teléfono</label></div>
                                <div class="input"><input type="text" name="telefono" id="telefono" class="form-control form-control-sm"></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Dirección</label></div>
                                <div class="input"><input type="text" name="direccion" id="direccion" class="form-control form-control-sm"></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>País cliente <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input">
                                    <select name="id_pais" id="id_pais" class="form-control form-control-sm" onchange="cargar_departamentos(this.value)">
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($paises as $p){ ?>
                                            <option value="<?php echo $p['id_pais']; ?>"><?php echo $p['pais']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Departamento cliente <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input">
                                    <select name="id_departamento" id="id_departamento" class="form-control form-control-sm" onchange="cargar_ciudades(this.value)">
                                        <option value="">SELECCIONAR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Ciudad cliente <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input">
                                    <select name="id_ciudad" id="id_ciudad" class="form-control form-control-sm">
                                        <option value="">SELECCIONAR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Tipo cliente <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input">
                                    <select name="tipo_cliente" id="tipo_cliente" class="form-control form-control-sm">
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($segmentos as $sg){ ?>
                                            <option value="<?php echo $sg['id_segmento']; ?>"><?php echo $sg['detalle']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Representante legal</label></div>
                                <div class="input"><input type="text" name="nombre_rl" id="nombre_rl" class="form-control form-control-sm"></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>No. documento representante</label></div>
                                <div class="input"><input type="text" name="doc_rl" id="doc_rl" class="form-control form-control-sm"></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Fecha expedición documento</label></div>
                                <div class="input"><input type="text" name="fecha_doc_rl" id="fecha_doc_rl" class="form-control form-control-sm"></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>País representante legal</label></div>
                                <div class="input">
                                    <select name="id_pais_rl" id="id_pais_rl" class="form-control form-control-sm" onchange="cargar_departamentos_rl(this.value)">
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($paises as $prl){ ?>
                                            <option value="<?php echo $prl['id_pais']; ?>"><?php echo $prl['pais']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Departamento representante legal</label></div>
                                <div class="input">
                                    <select name="id_departamento_rl" id="id_departamento_rl" class="form-control form-control-sm" onchange="cargar_ciudades_rl(this.value)">
                                        <option value="">SELECCIONAR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Ciudad representante legal</label></div>
                                <div class="input">
                                    <select name="id_ciudad_rl" id="id_ciudad_rl" class="form-control form-control-sm">
                                        <option value="">SELECCIONAR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>País expedición documento</label></div>
                                <div class="input">
                                    <select name="id_pais_exp" id="id_pais_exp" class="form-control form-control-sm" onchange="cargar_departamentos_exp(this.value)">
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($paises as $pexp){ ?>
                                            <option value="<?php echo $pexp['id_pais']; ?>"><?php echo $pexp['pais']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Departamento expedición documento</label></div>
                                <div class="input">
                                    <select name="id_departamento_exp" id="id_departamento_exp" class="form-control form-control-sm" onchange="cargar_ciudades_exp(this.value)">
                                        <option value="">SELECCIONAR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Ciudad expedición documento</label></div>
                                <div class="input">
                                    <select name="id_ciudad_exp" id="id_ciudad_exp" class="form-control form-control-sm">
                                        <option value="">SELECCIONAR</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tabs-2" class="p-4">
                        <div class="row mt-3">
                            <div class="label"><label>Contratante (Empresa) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_empresa" id="id_empresa" required>
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarEmpresas as $le){ ?>
                                        <option value="<?php echo $le['id_empresa']; ?>"><?php echo $le['nombre_empresa']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                          <div class="row mt-3">
                            <div class="label"><label>Origen Del Servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true" name="origen" id="origen" required>
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($ciudades as $cs){ ?>
                                        <option value="<?php echo $cs['id_ciudad']; ?>"><?php echo $cs['ciudad']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                          <div class="row mt-3">
                            <div class="label"><label>Destino del Servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input">
                                <select class="form-control form-control-sm selectpicker" data-live-search="true" name="destino" id="destino" required>
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($ciudades as $cs){ ?>
                                        <option value="<?php echo $cs['id_ciudad']; ?>"><?php echo $cs['ciudad']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Tipo de servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input">
                                <select class="form-control form-control-sm" name="tipo_servicio_reserva" id="tipo_servicio_reserva" required>
                                    <option value="">SELECCIONAR</option>
                                    <option value="EMPRESARIAL">EMPRESARIAL</option>
                                    <option value="TURISTICO">TURÍSTICO</option>
                                    <option value="EVENTOS">EVENTOS</option>
                                    <option value="TRASLADO_ESPECIAL">TRASLADO ESPECIAL</option>
                                    <option value="GRUPO_ESPECIFICO">GRUPO ESPECÍFICO DE USUARIOS</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
    <div class="label"><label>Tipo de vehículo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
    <div class="input">
        <select class="form-control form-control-sm selectpicker"
                data-live-search="true"
                multiple
                name="id_tipo_vehiculo[]"
                id="id_tipo_vehiculo"
                title="SELECCIONAR"
                required>
            <?php foreach ($listarTV as $ltv){ ?>
                <option value="<?php echo $ltv['id_tipo_vehiculo']; ?>">
                    <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

                        <div class="row mt-3">
                            <div class="label"><label>Cantidad de vehículos <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="number" min="1" name="cantidad_vehiculos" id="cantidad_vehiculos" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Número de pasajeros <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="number" min="1" name="cantidad_pasajeros" id="cantidad_pasajeros" class="form-control form-control-sm" required></div>
                        </div>


                        <div class="row mt-3">
                            <div class="label"><label>Fecha inicio del servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Fecha fin del servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="date" name="fecha_fin" id="fecha_fin" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Hora inicio del servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="time" name="hora_inicio" id="hora_inicio" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Hora fin del servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="time" name="hora_fin" id="hora_fin" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Valor del servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="number" min="0" name="valor_servicio" id="valor_servicio" class="form-control form-control-sm" required></div>
                        </div>
                    </div>

                    <div id="tabs-3" class="p-4">
                        <div class="row mt-3">
                            <div class="label"><label>RUT (PDF) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="file" accept="application/pdf" name="doc_rut" id="doc_rut" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Cámara de comercio (PDF) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="file" accept="application/pdf" name="doc_camara" id="doc_camara" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Cédula representante legal (PDF) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="file" accept="application/pdf" name="doc_cedula_rl" id="doc_cedula_rl" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Aceptación del cliente (PDF) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="file" accept="application/pdf" name="doc_aceptacion" id="doc_aceptacion" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Contrato del servicio (PDF) - Opcional</label></div>
                            <div class="input"><input type="file" accept="application/pdf" name="doc_contrato" id="doc_contrato" class="form-control form-control-sm"></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Soporte primer abono 50% (PDF) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                            <div class="input"><input type="file" accept="application/pdf" name="doc_primer_abono" id="doc_primer_abono" class="form-control form-control-sm" required></div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Soporte segundo abono 50% (PDF) - Opcional</label></div>
                            <div class="input"><input type="file" accept="application/pdf" name="doc_segundo_abono" id="doc_segundo_abono" class="form-control form-control-sm"></div>
                        </div>
                    </div>

                    <div id="tabs-4" class="p-4">
                        <div class="row mt-3">
                            <div class="label"><label>Detalle del servicio</label></div>
                            <div class="input">
                                <textarea name="detalle_servicio" id="detalle_servicio" rows="4" class="form-control form-control-sm" placeholder="Escriba aquí el detalle del servicio"></textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="label"><label>Proforma (PDF)</label></div>
                            <div class="input"><input type="file" accept="application/pdf" name="doc_prefactura" id="doc_prefactura" class="form-control form-control-sm"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center mt-3 mb-2">
                    <button type="submit" class="btn btn-outline-primary mr-2">CONFIRMAR</button>
                    <a href="serviciosOcasionales.php" class="btn btn-outline-danger">CANCELAR</a>
                </div>
            </form>
        </div>
    </section>
</section>

<?php include("Template/scripts.php"); ?>
<script>
    $(function() {
        $("#tabs").tabs();
        $("#fecha_doc_rl").datepicker({ dateFormat:'yy/mm/dd' });
        validarOpcionCliente($("#opcionCliente").val());
    });

    function validarOpcionCliente(valor){
        if(valor === 'BA'){
            $('#contentExistingCliente').show();
            $('#contentNewCliente').hide();
            $('#id_cliente_existente').attr('required', 'required');
            $('#contentNewCliente').find('input,select,textarea').removeAttr('required');
        } else if(valor === 'RN'){
            $('#contentExistingCliente').hide();
            $('#contentNewCliente').show();
            $('#id_cliente_existente').removeAttr('required');
            $('#razon_social,#nit_cliente,#direccion,#telefono,#id_pais,#id_departamento,#id_ciudad,#tipo_cliente').attr('required', 'required');
        } else {
            $('#contentExistingCliente').hide();
            $('#contentNewCliente').hide();
            $('#id_cliente_existente').removeAttr('required');
            $('#contentNewCliente').find('input,select,textarea').removeAttr('required');
        }
    }

    function validarNitCliente(nit_cliente){
        if(!nit_cliente){
            $('#validarValorCliente').hide().html('');
            return;
        }

        $.ajax({
            data: {"nit_cliente": nit_cliente},
            url: '../Controlador/ValidarRegistroCliente.php',
            type: 'post',
            success: function (response) {
                $('#validarValorCliente').html(response);
                var valorVerificar = document.getElementById('valorVerificar') ? document.getElementById('valorVerificar').value : '1';
                if(valorVerificar == '2'){
                    $('#validarValorCliente').show().html("<p class='mt-2 mb-2' style='color:#fff;'>Ya existe un cliente con ese NIT/Cédula. Use 'Buscar y Anclar'.</p>");
                } else {
                    $('#validarValorCliente').hide().html('');
                }
            }
        });
    }

    function cargar_departamentos(id_pais){
        if(id_pais != ''){
            $.ajax({
                data: {"id_pais": id_pais},
                url: '../Controlador/listarDepartamentos.php',
                type: 'post',
                beforeSend: function () { $('#id_departamento').html("<option value='' selected='selected'>Cargando...</option>"); },
                success: function (response) { $('#id_departamento').html(response); }
            });
        }
        cargar_ciudades(0);
    }

    function cargar_ciudades(id_departamento){
        if(id_departamento != ''){
            $.ajax({
                data: {"id_departamento": id_departamento},
                url: '../Controlador/listarCiudades.php',
                type: 'post',
                beforeSend: function () { $('#id_ciudad').html("<option value='' selected='selected'>Cargando...</option>"); },
                success: function (response) { $('#id_ciudad').html(response); }
            });
        } else {
            $('#id_ciudad').html("<option value=''>SELECCIONAR</option>");
        }
    }

    function cargar_departamentos_rl(id_pais){
        if(id_pais != ''){
            $.ajax({
                data: {"id_pais": id_pais},
                url: '../Controlador/listarDepartamentos.php',
                type: 'post',
                beforeSend: function () { $('#id_departamento_rl').html("<option value='' selected='selected'>Cargando...</option>"); },
                success: function (response) { $('#id_departamento_rl').html(response); }
            });
        }
        cargar_ciudades_rl(0);
    }

    function cargar_ciudades_rl(id_departamento){
        if(id_departamento != ''){
            $.ajax({
                data: {"id_departamento": id_departamento},
                url: '../Controlador/listarCiudades.php',
                type: 'post',
                beforeSend: function () { $('#id_ciudad_rl').html("<option value='' selected='selected'>Cargando...</option>"); },
                success: function (response) { $('#id_ciudad_rl').html(response); }
            });
        } else {
            $('#id_ciudad_rl').html("<option value=''>SELECCIONAR</option>");
        }
    }

    function cargar_departamentos_exp(id_pais){
        if(id_pais != ''){
            $.ajax({
                data: {"id_pais": id_pais},
                url: '../Controlador/listarDepartamentos.php',
                type: 'post',
                beforeSend: function () { $('#id_departamento_exp').html("<option value='' selected='selected'>Cargando...</option>"); },
                success: function (response) { $('#id_departamento_exp').html(response); }
            });
        }
        cargar_ciudades_exp(0);
    }

    function cargar_ciudades_exp(id_departamento){
        if(id_departamento != ''){
            $.ajax({
                data: {"id_departamento": id_departamento},
                url: '../Controlador/listarCiudades.php',
                type: 'post',
                beforeSend: function () { $('#id_ciudad_exp').html("<option value='' selected='selected'>Cargando...</option>"); },
                success: function (response) { $('#id_ciudad_exp').html(response); }
            });
        } else {
            $('#id_ciudad_exp').html("<option value=''>SELECCIONAR</option>");
        }
    }
</script>

</body>
</html>