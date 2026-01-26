<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/CentroCostoCliente.php");
require_once("../Modelo/DestinoCliente.php");
require_once("../Modelo/TipoServicioCliente.php");
$id_solicitud = '0';

$titulo = 'Registrar Servicio';
$redireccion = 'serviciosCliente.php';
$icono = 'fa fa-bus';

$tipo_servicio = new TipoServicioCliente();
$usuario = new Usuario();
$centro_costo = new CentroCostoCliente();
$destino_cliente = new DestinoCliente();
$programacion = new Programacion();
$datos_usuario = $usuario->listarUsuarioPorId($_SESSION['id_usuario']);
$datos_cc = $centro_costo->listarPorId($datos_usuario[0]['id_perfil']);

$listado_origen = $destino_cliente->listarPorCentroCosto($datos_usuario[0]['id_perfil']);
$contactos = $programacion->contactosPorCliente($_SESSION['id_cliente']);
$listado_ts = $tipo_servicio->listarPorCliente($_SESSION['id_cliente']);
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
            <li class="breadcrumb-item " aria-current="page"><a href="serviciosCliente.php">Solicitudes</a></li>
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
            <form method="POST" action="../Controlador/registrarServicioCliente.php" class="p-4" enctype="multipart/form-data" autocomplete="off">
              <input type="hidden" name="id_solicitud" value="<?php echo $id_solicitud;?>">
              <input type="hidden" name="id_cliente" value="<?php echo $_SESSION['id_cliente'];?>">
	      <input type="hidden" name="tipo" value="IDA">
	      <input type="hidden" id="ciudad" name="ciudad" value="BOGOTA"/>
	      <input type="hidden" id="solicitante" name="solicitante" value="<?php echo $datos_usuario[0]['nombre'];?>"/>
	      <input type="hidden" id="centro_costo" name="centro_costo" value="<?php echo $datos_cc[0]['detalle'];?>"/>

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

                    <!-- Origen -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Origen</label>
                        </div>
                        <div class="col-10">
			    <select name="origen" id="origen" class="form-control selectpicker" data-live-search="true" required="required">
				<option value="">Seleccione Unidad Operativa</option>
				<?php foreach($listado_origen as $lo){ ?>
				<option value="<?php echo $lo['detalle'];?>"><?php echo $lo['detalle'];?></option>
				<?php } ?>
			    </select>
                        </div>
                    </div>

                    <!-- Destino -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Destino Fuera de Bogota</label>
                        </div>
			
                        <div class="col-10">
			    <input class="form-control" value="S" type="checkbox" name="fuera_bogota" id="fuera_bogota" onclick="dest(this.id)"/>   
                            <input type="hidden" id="destino" name="destino" class="form-control" required="required" value="VARIOS" />
                        </div>
                    </div>

                    <div class="row col-12 mb-4" id="otro" style="display:none">
                        <div class="col-2 text-center">    
                            <label>Cual?</label>
                        </div>
			
                        <div class="col-10">
			    <input type="text" id="destino_otro" name="destino_otro" class="form-control" />
                        </div>
                    </div>

                    <!-- Tipo Servicio -->
                    <div class="row col-12 mb-4">
                        <div class="col-2 text-center">    
                            <label>Tipo de Servicio</label>
                        </div>
                        <div class="col-10">    
                           <select class="form-control selectpicker" data-live-search="true" name="tipo_servicio" id="tipo_servicio" required="required" onchange="tipo_servicio_c(this.value)">
                                <option value="">Seleccionar </option>
                                <?php foreach ($listado_ts as $lt){ ?>
                                  <option value="<?php echo $lt['id_tipo_servicio'].'-'.$lt['id_tipo_vehiculo']; ?>">
                                    <?php echo $lt['detalle']; ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                    </div>

                    <input type="hidden" name="id_tiposervicio" id="id_tiposervicio" value="">
		    <input type="hidden" name="id_tipovehiculo" id="id_tipovehiculo" value="">
		
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
function tipo_servicio_c(tipo){
  if(tipo != ''){
  var r = tipo.split('-');
  document.getElementById('id_tiposervicio').value = r[0];
  document.getElementById('id_tipovehiculo').value = r[1];
  } else {
  document.getElementById('id_tiposervicio').value = '';
  document.getElementById('id_tipovehiculo').value = '';
  }	
}
function dest(id){
  var checkbox = document.getElementById(id);
  var checked = checkbox.checked;
  if(checked){
    document.getElementById('otro').style.display = 'flex';
    document.getElementById('destino_otro').required = true;
  } else {
    document.getElementById('otro').style.display = 'none';
    document.getElementById('destino_otro').required = false;
  }
}
</script>
</body>
</html>