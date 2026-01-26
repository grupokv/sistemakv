
  <script src="../Resources/js/jquery.min.js"></script>
  <script src="../Resources/js/popper.min.js"></script>
  <script src="../Resources/js/bootstrap.min.js"></script>
  <script src="../Resources/js/datatables.min.js"></script>
  <script src="../Resources/jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <script src="../Resources/chosen-1.8.7/chosen.jquery.js"></script>
  <script src="../Resources/lou-multi-select-57fb8d3/js/jquery.multi-select.js"></script>
  <script src="../Resources/clockpicker-gh-pages/dist/bootstrap-clockpicker.min.js"></script>
  <script src="../Resources/bootstrap-select-1.13.9/dist/js/bootstrap-select.min.js"></script>
  <script src="../Resources/Multiple-Dates-Picker/jquery-ui.multidatespicker.js"></script>
  <script src="../Resources/js/script.js"></script>
  <script src="../Resources/js/bootstrap-select.min.js"></script>
  <script src="../Resources/MonthPicker.js"></script>
  <script src="../Resources/yearpicker.js"></script>
  <script src="../Resources/alertifyjs/alertify.js"></script>
  <script src="../Resources/alertifyjs/alertify.min.js"></script>
  <script src="../Resources/sweetalert.js"></script>
  <script src="../Resources/chartist-js-develop/dist/chartist.min.js"></script>
  <script>
    
  function solo_letras(e){
   key = e.keyCode || e.which;
   tecla = String.fromCharCode(key).toLowerCase();
   letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
   especiales = "8-37-39-46";

   tecla_especial = false
   for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla)==-1 && !tecla_especial){
        return false;
    }
    //onKeyPress="return solo_letras(event)"
  }
  function solo_numeros(e){
    //alert(e);
  	var key = window.Event ? e.which : e.keyCode
	 return (key >= 48 && key <= 57);
	//onKeyPress="return solo_numeros(event)"
  }


  function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        //Usando la definición del DOM level 2, "return" NO funciona.
        e.preventDefault();
    }
  }

  function addCommas(nStr)
{
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  }
  return x1 + x2;
}
  </script>