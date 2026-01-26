<?php 
include ("../Controlador/Sesion/autenticar.php");
include("../Modelo/Pais.php");
include("../Modelo/Departamento.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Ciudad';
$redireccion = 'ciudades.php';
$icono = 'fa fa-map';

$paises = new Pais();
$listado_paises = $paises->listar();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	  <title>SistemaKV | Registrar Ciudad</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
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
                  <li class="breadcrumb-item " aria-current="page"><a href="ciudades.php">Ciudades</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Registrar Ciudad</li>
               </ol>
          </div>

          <div class="notice notice-sistemakv">
              <strong><i class="fa fa-map mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR CIUDAD</b></strong>
          </div>

          <section class="form-usuarios">
              <div class="formulario mb-3">

      	        <form action="../Controlador/registrarCiudad.php" method="POST">

                    <!-- PAIS -->
                        <div class="row mt-4 mb-4">
                            <div class="label">
                                <label>Pais</label>
                            </div>
                            <div class="input">
                                <select name="id_pais" id="id_pais" required="required" class="form-control selectpicker" data-live-search="true" onchange="cargar(this.value)">
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach($listado_paises as $lp){ ?>
                                    <option value="<?php echo $lp['id_pais'];?>"><?php echo $lp['pais'];?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>

                    <!-- DEPARTAMENTO -->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Departamento</label>
                            </div>
                            <div class="input">
                                <select name="id_departamento" id="id_departamento" required="required" class="form-control" >
                                    <option value="">SELECCIONAR</option>
                                </select>
                            </div>
                        </div>

                    <!-- CIUDAD -->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Nombre ciudad</label>
                            </div>
                            <div class="input">
                                <input type="text" name="nombre_ciudad" id="nombre_ciudad" class="form-control" required="required">
                            </div>
                        </div>

                    <!-- BOTONES -->
                    
                      <section class="col-12 mt-5 d-flex justify-content-center">
                          
                          <!-- CANCELAR REGISTRO -->
                              <a href="ciudades.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                          
                          <!-- REGISTRAR -->
                              <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Registrar</button>
                      
                      </section>

      	        </form>

              </div>
          </section>

      </section>


    <?php include("Template/scripts.php"); ?>
    <script>
        function cargar(id_pais){
          //alert(id_departamento); 
          if(id_pais != ''){
              var parametros = {
                "id_pais" : id_pais
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarDepartamentos.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_departamento").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_departamento").html(response);
                  }
              });
          }
        }        
    </script>
</body>
</html>