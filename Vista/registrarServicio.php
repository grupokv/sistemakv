<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicio.php");

$id_solicitud = $_GET['ids'];

$titulo = 'Registrar Servicio';
$redireccion = 'programacion_solicitudes.php';
$icono = 'fa fa-car';

$tipo_servicio = new TipoServicio();
$tipo_vehiculo = new TipoVehiculo();

$listarTiposServicios = $tipo_servicio->listarCliente();
$listarTiposVehiculos = $tipo_vehiculo->listar();



$programacion = new Programacion();
$datossolicitud = $programacion->solicitudPorId($id_solicitud);
$canttotal = $datossolicitud[0]['servicios_ida'] + $datossolicitud[0]['servicios_retorno'];

$contactos = $programacion->contactosPorCliente($datossolicitud[0]['id_cliente']);

$idas = $programacion->serviciosPorTipoIdSolicitud($id_solicitud,'IDA');
$cant1 = count($idas);
$vueltas = $programacion->serviciosPorTipoIdSolicitud($id_solicitud,'VUELTA');
$cant2 = count($vueltas);
$cantidad = $cant1 + $cant2;

if($canttotal == $cantidad){
  echo ("<script language='JavaScript'>
    alert('Todas las solicitudes ya fueron realizadas');
    window.location.href='programacion_solicitudes.php';
    </script>");
}

if($datossolicitud[0]['servicios_ida'] > $cant1){
  $tiposolicitud = 'IDA';
} else if ($datossolicitud[0]['servicios_retorno'] > $cant2){
  $tiposolicitud = 'VUELTA';
} else {
  echo ("<script language='JavaScript'>
    alert('Todas las solicitudes de servicios ya fueron realizadas');
    window.location.href='programacion_solicitudes.php';
    </script>");
}   
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Registrar servicio</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php"); ?>
  <link rel="stylesheet" href="../Resources/css/registrarUsuario.css">
  <style>

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
  max-width: 846px;
  border-radius: 25%;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>
</head>
<body>
    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="programacion_solicitudes.php">Solicitudes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Servicio</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="col-10 formulario mb-5">
            <div class="row" style="height: 60px; background-color: #5e99b1; ">
              <div class="col-">
                <h2 class="ml-4 mt-2" style="color: #fff;"><span class="<?php echo $icono;?>" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Registrar servicio</h2>
              </div>
            </div>
            <hr>
            <!-- Formulario -->
            <form method="POST" action="../Controlador/registrarServicio.php" class="p-4" enctype="multipart/form-data" autocomplete="off">
              <input type="hidden" name="id_solicitud" value="<?php echo $id_solicitud;?>">
              <input type="hidden" name="id_cliente" value="<?php echo $datossolicitud[0]['id_cliente'];?>">
                    <!-- Tipo Servicio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Tipo Servicio</label>
                        </div>
                        <div class="col-10">    
                            <?php echo $tiposolicitud;?>
                            <input type="hidden" name="tipo" id="tipo" value="<?php echo $tiposolicitud;?>">
                        </div>
                    </div>

                    <!-- Fecha Servicio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Fecha</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" name="fecha_servicio[]" id="datepicker" class="form-control" autocomplete="off" required="required">
                        </div>
                    </div>

                    <!-- Hora Servicio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Hora</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="hora_servicio" name="hora_servicio" data-target="#hora_servicio" class="form-control datetimepicker-input" data-target="#hora_servicio" data-toggle="datetimepicker" autocomplete="off" required="required" />
                        </div>
                    </div>

                    <!-- Cantidad Pasajeros -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Cantidad Pasajeros</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="cant_pax" name="cant_pax" class="form-control" onKeyPress="return solo_numeros(event)" required="required"/>
                                
                        </div>
                    </div>
                    
                    <!-- Nombre Contacto -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Nombre Contacto</label>
                        </div>
                        <div class="col-10 autocomplete">    
                                <input type="text" id="nombre_contacto" name="nombre_contacto" class="form-control" onKeyPress="return solo_letras(event)" required="required" />
                                
                        </div>
                    </div>

                    <!-- Telefono Contacto -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Teléfono Contacto</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="telefono_contacto" name="telefono_contacto" class="form-control" onKeyPress="return solo_numeros(event)" required="required" onFocus="traerTelefono()"/>
                                
                        </div>
                    </div>

                    <!-- Listado Pasajeros -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Listado Pasajeros</label>
                        </div>
                        <div class="col-10">    
                                <input type="file" id="listado_pax" name="listado_pax" class="form-control" />
                                
                        </div>
                    </div>

                    <!-- Ciudad / Municipio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Ciudad / Municipio</label>
                        </div>
                        <div class="col-10">    
                                <input type="text" id="ciudad" name="ciudad" class="form-control" required="required"/>
                                
                        </div>
                    </div>

                    <!-- Origen -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Origen</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="origen" name="origen" class="form-control" required="required"/>
                        </div>
                    </div>

                    <!-- Destino -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Destino</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="destino" name="destino" class="form-control" required="required"/>
                        </div>
                    </div>

                    <!-- Tipo Servicio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Tipo de Servicio</label>
                        </div>
                        <div class="col-10">    
                           <select class="form-control selectpicker" data-live-search="true" name="id_tiposervicio" id="id_tiposervicio" required="required">
                                <option>Seleccionar </option>
                                <?php foreach ($listarTiposServicios as $lt){ ?>
                                  <option value="<?php echo $lt['id_tipo_servicio']; ?>">
                                    <?php echo $lt['nombre_tipo_servicio']; ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <!-- Tipo Vehiculo -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label for="speed">Tipo de Vehiculo</label>
                        </div>
                        <div class="col-10">
                              <select class="form-control selectpicker" data-live-search="true" name="id_tipovehiculo" id="id_tipovehiculo" required="required">
                                <option value="">Seleccionar </option>
                                <?php foreach ($listarTiposVehiculos as $lc){ ?>
                                  <option value="<?php echo $lc['id_tipo_vehiculo']; ?>">
                                    <?php echo $lc['nombre_tipo_vehiculo']; ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>


                    <!-- Centro Costo -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Centro de Costos</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="centro_costo" name="centro_costo" class="form-control" required="required"/>
                        </div>
                    </div>

                    <!-- Solicitante -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Solicitante</label>
                        </div>
                        <div class="col-10">    
                            <input type="text" id="solicitante" name="solicitante" class="form-control" required="required"/>
                        </div>
                    </div>

                    <hr>

                    <!-- BOTONES -->
                    <div class="row d-flex justify-content-center mt-4">
                      <div class="col-3">
                         <a type="submit" href="<?php echo $redireccion;?>" class="btn btn-danger btn-block">CANCELAR</a>
                      </div>
                      <div class="col-3">
                          <input type="submit" class="btn btn-ingresar btn-block" value="Registrar"></input>
                      </div>
                    </div>
            </form>
        </div>
    </section>

    
    <!-- FIN CONTENIDO -->


  <!-- script -->
  <?php include("Template/scripts.php"); ?>
<!--INICIO INPUT HORA-->
<script type="text/javascript" src="../Resources/js/moment/moment.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<!--FIN INPUT HORA-->

  <script type="text/javascript">

        $( function() {
            $( "#datepicker" ).datepicker({
              changeMonth: true,
              changeYear: true,
              minDate: '-0D',
              dateFormat:'yy/mm/dd'
            });
        } );

        $(function () {
            $('#hora_servicio').datetimepicker({
              format: 'LT'
            });
        });
  </script>
  <script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var nombres = [<?php foreach($contactos as $ct){ ?> "<?php echo $ct['contacto'];?>", <?php } ?> ];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("nombre_contacto"), nombres);

function traerTelefono(){
    var contacto = document.getElementById('nombre_contacto').value;
    //alert(contacto)
    if(contacto != ''){
        var parametros = {
                "contacto" : contacto
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/traerTelefonoContacto.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                  },
                  success:  function (response) {
                      //alert(response);
                      document.getElementById('telefono_contacto').value = response;
                      
                  }
              });
    }
}
</script>
</body>
</html>