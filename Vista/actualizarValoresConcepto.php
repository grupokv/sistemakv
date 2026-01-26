<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/TipoVehiculo.php");

$id = base64_decode($_GET['id']);

$tv = new TipoVehiculo();
$listado_tv = $tv->listar();
$cantidad = count($listado_tv);

$concepto = new ConceptoCobro();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Actualizar Valor Concepto</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
      	<link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!-- STYLES -->

</head>
<body>

	<!-- MENU -->
        <?php include("Template/header.php"); ?>
      	<?php include("Template/newMenu.php"); ?>
	<!-- FIN MENU -->

	<!-- ************************** -->

	<!-- CONTENIDO -->

        <section class="home_content"> 

            <div aria-label="breadcrumb" class="mt-1"> 
                <ol class="breadcrumb"  style="background-color: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item " aria-current="page"><a href="conceptos_cobro.php">Servicios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Registrar Valores</li>
                </ol>
            </div>
            
          	<div class="notice notice-sistemakv" style="background-color: #fff;">
              	<strong><i class="fa fa-money  mr-3" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">VALORES POR TIPO VEHICULO</b></strong>
          	</div>

            <section class="form-usuarios">
                <div class="formulario mb-5">
                    <form action="../Controlador/actualizarValoresConcepto.php" method="POST">
                        
                        <input type="hidden" name="id" value="<?php echo $id;?>"/>

                        <div class="row mt-3 mb-4">
                            <div class="col-3 mr-2 text-center" style="border-radius: 25px; background-color: #1b2d3b; padding: 10px; color: #fff;">
                                <strong>TIPO VEHICULO</strong>
                            </div>
                            <div class="col-7 text-center" style="border-radius: 25px; background-color: #1b2d3b; padding: 10px; color: #fff;">
                                <strong>VALOR</strong>
                            </div>
                        </div>

                        <?php foreach($listado_tv as $lt){ 
                            $valor = $concepto->buscarValor($id,$lt['id_tipo_vehiculo']);
                            if(count($valor) > 0){
                                $val = $valor[0]['valor'];
                            } else {
                                $val = 0;
                            }
                        ?>

                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label><?php echo $lt['nombre_tipo_vehiculo'];?></label>
                                </div>
                                <div class="row input">
                                    <input type="text" class="form-control form-control-sm col-8 mr-2" name="valor_<?php echo $lt['id_tipo_vehiculo'];?>" id="valor" required="required" value="<?php echo $val; ?>">
                                    <?php if($val != 0){ ?>
                                        <input type="text" readonly="true" class="form-control form-control-sm col-2" id="valorReal" required="required" value="$ <?php echo number_format($val + 20000); ?>">
                                    <?php } ?>
                                </div>
                            </div>

                        <?php } ?>
                        
                        <section class="col-12 mt-5 d-flex justify-content-center">
	                        	<a href="conceptos_cobro.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
	                            <button type="submit" id="buttonsKV" class="btn col-3">Actualizar</button>
	                    </section>

                    </form>

                </div>
            </section>

        </section>

	<!-- FIN CONTENIDO -->

	<!-- ************************** -->

	<!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>
	<!-- FIN SCRIPT -->

</body>
</html>