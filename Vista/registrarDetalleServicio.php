  <?php 
include ("../Controlador/Sesion/autenticar.php");
require_once "../Modelo/OrdenServicio.php";
require_once "../Modelo/Categoria_Mantenimiento.php";
require_once "../Modelo/ProveedorMantenimiento.php";
require_once "../Modelo/Subcategoria_Mantenimiento.php";

$id = $_GET['id'];
/* VARIABLES MENU*/
$titulo = 'Registrar Detalle Orden';
$redireccion = 'ordenes_servicio.php';
$icono = 'fa fa-wrench';

$categoria = new Categoria_Mantenimiento();
$listado_cat = $categoria->listar();

$orden = new OrdenServicio();
$detalle_orden = $orden->listarPorId($id);

$proveedor = new ProveedorMantenimiento();
$subcategoria = new Subcategoria_Mantenimiento();

$listarSubcat = $proveedor->listarsubcategoriaPorProveedores($detalle_orden[0]['id_proveedor']);
$cant = count($listarSubcat);
$a = 1;
foreach ($listarSubcat as $ls) {
    if($a != $cant){
      $idsSubcategorias .= $ls['id_subcategoria'].','; 
    } else {
      $idsSubcategorias .= $ls['id_subcategoria']; 
    }
    $a++;
}
//echo $idsSubcategorias;
$listarCategorias = $subcategoria->listarCategoriasIn($idsSubcategorias);
//echo count($listarCategorias);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Detalle Orden Servicio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
</head>
<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>


    <!-- CONTENIDO -->

      <section class="home_content">  

          <div aria-label="breadcrumb" class="mt-1"> 
              <ol class="breadcrumb" style="background: #fff;">
              <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
              <li class="breadcrumb-item " aria-current="page"><a href="ordenes_servicio.php">Ordenes</a></li>
              <li class="breadcrumb-item active" aria-current="page">Registrar orden</li>
              </ol>
          </div>
          
          <div class="notice notice-sistemakv">
              <strong><i class="fa fa-wrench mr-3" style="font-size: 2rem;"></i>REGISTRO DETALLE DE SERVICIO</strong>
          </div>

          <section class="form-usuarios">
              <div class="formulario mb-5">
      	        <form action="../Controlador/registrarDetalleOrden.php" method="POST">

                    <!-- ID ORDEN -->

                        <input type="hidden" name="id_orden" id="id_orden" value="<?php echo $id;?>"/>

                    <!-- VALOR ACTUAL -->

                        <input type="hidden" name="valor_actual" id="valor_actual" value="<?php echo $detalle_orden[0]['valor_total'];?>"/>

                    <!-- CATEGORIA -->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label><b>Categoria</b></label>
                            </div>
                            <div class="input">
                                <?php $cat = "";?>
                                <select name="categoria" id="categoria" required="required" class="form-control selectpicker" data-live-search="true" onchange="cargar(<?php echo $detalle_orden[0]['id_proveedor']?>)">
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach($listarCategorias as $lc){ ?>
                                      <?php if($cat != $lc['id_categoria']) { $cat = $lc['id_categoria']; ?>
                                      <option value="<?php echo $lc['id_categoria'];?>">
                                        <?php echo $lc['detalle_categoria'];?>
                                      </option>
                                    <?php } } ?> 
                                </select>
                            </div>
                        </div>

                    <!-- SUB CATEGORIA -->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label><b>Sub-Categoria</b></label>
                            </div>
                            <div class="input">
                                <select name="subcategoria" id="subcategoria" required="required" class="form-control" onchange="cargarDatosSubCProveedor(this.value, <?php echo $detalle_orden[0]['id_proveedor']?>)">
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="valor" id="valor" class="form-control">

                    <!-- CANTIDAD -->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label><b>Cantidad</b></label>
                            </div>
                            <div class="input">
                                <input type="text" name="cantidad" id="cantidad" class="form-control" onblur="valorTotalDetalle();">
                            </div>
                        </div>

                    <!-- VALOR -->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label><b>Valor</b></label>
                            </div>
                            <div class="input">
                                <input type="text" name="valorTotal" id="valorTotal" class="form-control" required="required">
                            </div>
                        </div>

                    <section class="col-12 mt-4 d-flex justify-content-center">
                        <a href="ordenes_servicio.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                        <button type="submit" class="btn btn-outline-info col-3">Registrar</button>
                    </section>

      	        </form>
              </div>
          </section>

      </section>


    <?php include("Template/scripts.php"); ?>
    <script>
        function cargar(id_proveedor){
          //alert(id_cat); 
          if(id_proveedor != ''){
              var parametros = {
                "id_proveedor" : id_proveedor
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarSubcategoriasMantenimiento.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#subcategoria").html("<option value='' disaebld='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#subcategoria").html(response);
                      $("#valorTotal").val("");
                      $("#cantidad").val("");
                  }
              });
          }
        }  

        function valorTotalDetalle(){
            var valor = $("#valor").val();
            var cantidad = $("#cantidad").val();

            $("#valorTotal").val(valor * cantidad);
        }




        function cargarDatosSubCProveedor(id_subcategoria, id_proveedor){
              //alert(id_subcategoria);
              //alert(id_proveedor);
            var parametros = {
              "id_subcategoria" : id_subcategoria,
              "id_proveedor" : id_proveedor
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/CargarDatosSubcateProveedor.php',
                type: 'POST',
                beforeSend: function(){
                    $("#valor").val('Cargando valor, por favor espere.');
                },
                success: function(response){
                    $("#valor").val(response);
                    $("#valorTotal").val("");
                    $("#cantidad").val("");
                }
            });
        }   

    </script>
</body>
</html>