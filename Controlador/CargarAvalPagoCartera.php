<?php 

include ("Sesion/autenticar.php");
require_once ("../Modelo/Cartera.php");
require_once ("../Modelo/General.php");

$cartera = new Cartera();

$id_vehiculo = $_POST['id_vehiculo'];

$consultarAvalVehiculo = $cartera->consultarAvalVehiculo($id_vehiculo);
//print_r($consultarAvalVehiculo);
$cantAval = count($consultarAvalVehiculo);

$html = "";

if($cantAval > 0){

$html .= '<table class="table table-hover table-sm display" width="auto" align="center" border="0">';
    $html .= '<thead style="background-color:#1b2d3b; color:#fff;">';
        $html .= '<tr align="center">';
            $html .= '<th></th>';
			$html .= '<th>SERVICIO</th>';
			$html .= '<th>FECHA</th>';
			$html .= '<th>VALOR</th>';
        $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
        $a = 0;
        
        foreach($consultarAvalVehiculo as $cav){
            
            $html .= '<tr align="center">';
                $html .= '<td style="border: inset 0pt">';
                    $html .= '<input type="checkbox" name="pagos[]" value="' . $cav['id_aval'] . "|" . $cav["valor"] . '" id="checkbox_' . $cav["id_aval"] . '" onchange="sumar(this.value,this.id)"/>';
                $html .= '</td>';
                $html .= '<td style="border: inset 0pt"> SALDO AVAL ' . strtoupper(mes($cav['mes'])) . ' ' . $cav['anio'] . '</td>';
            
                $html .= '<td style="border: inset 0pt">' . strtoupper(mes($cav['mes'])) . " DE "  . $cav['anio'] .'</td>';
                
                $html .= '<td style="border: inset 0pt">' . "$ ". number_format($cav["valor"], 0,",",","). '</td>';
            $html .= '</tr>';
            
            $a = $a + 1;
        }
        
        $html .= '<tr align="center">';								
		    $html .= '<td style="border: inset 0pt" colspan="3"><b>TOTAL</td>';								
		    $html .= '<td style="border: inset 0pt"><b id="valor_total"></b></td>';								
		$html .= '</tr>';
		
    $html .= '</body>';
$html .= '</table>';

$html .= '<div id="valor_final"></div>';


/* ------------------------------------------------------------ */
 
}


echo $html;


?>


<script type="text/javascript">
    $( function() {
        $( "#datepicker").datepicker({
        	dateFormat: "yy-mm-dd",
        	maxDate: 0
        });
    } );
	    
    var total = 0;

    function sumar(datos,id){

	    var split = datos.split('|');

	    if (document.getElementById(id).checked){
		    total = (Number(total) + Number(split[1]));
	    } else {
			if(total > 0){
				total = (Number(total) - Number(split[1]));
			}
	    }

	    
	    if(total == 0){
            document.getElementById('valor_total').innerHTML = '$ ' + new Intl.NumberFormat("es-ES").format("0");
	        document.getElementById('valor_final').innerHTML = '<input type="hidden" name="total" id="total" class="form-control" value="' + total +'" />';
	    }else{
	        document.getElementById('valor_total').innerHTML = '$ ' + new Intl.NumberFormat("es-ES").format(total);
	        document.getElementById('valor_final').innerHTML = '<input type="hidden" name="total" id="total" class="form-control" value="' + total + '" />';
	    }
	    
    }
    
    
	
    $("#valor_pago").on({
        "focus": function(event) {
            $(event.target).select();
        },
        "keyup": function(event) {
            $(event.target).val(function(index, value) {
              return value.replace(/\D/g, "").replace(/([0-9])([0-9]{0})$/, '$1$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            });
        }
    });
</script>