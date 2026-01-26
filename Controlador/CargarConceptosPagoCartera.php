<?php 

include ("Sesion/autenticar.php");
require_once ("../Modelo/ConceptosCobro.php");
require_once ("../Modelo/Cartera.php");
require_once ("../Modelo/General.php");

$cartera = new Cartera();
$concepto = new ConceptoCobro();

$id_vehiculo = $_POST['id_vehiculo'];

$listarAnticiposPorVehiculo = $cartera->listarAnticiposPorVehiculo($id_vehiculo);

                
$pagos_pendientes = $concepto->pagosPendientes($id_vehiculo);
//print_r($pagos_pendientes);
$bancos = $concepto->listarBancos();
$cant_pp = count($pagos_pendientes);

$consultarAvalVehiculo = $cartera->consultarAvalVehiculo($id_vehiculo);
$cantAval = count($consultarAvalVehiculo);

$html = "";

if($cant_pp > 0){

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
        
        
        foreach($pagos_pendientes as $pp){
            $datos_c = $concepto->listarPorId($pp['id_concepto']); 
            
            $html .= '<tr align="center">';
                $html .= '<td style="border: inset 0pt">';
                    $html .= '<input type="checkbox" name="pagos[]" value="' . $pp["id_cobro"]. "|" . $pp["valor"] . '" id="checkbox_' . $pp["id_cobro"] . '" onchange="sumar(this.value,this.id)"/>';
                $html .= '</td>';
				$html .= '<td style="border: inset 0pt">' . $datos_c[0]["detalle_concepto"]. '</td>';
				
				$fecha_cobro = explode("-", $pp["fecha_cobro"]);
				$annio = $fecha_cobro[0];
				$mes = $fecha_cobro[1];
				$dia = $fecha_cobro[2];
				
				if($datos_c[0]['frecuencia'] == "A"){
				    $html .= '<td style="border: inset 0pt">' . $annio . '</td>';
				}else if($datos_c[0]['frecuencia'] == "M"){
				    $html .= '<td style="border: inset 0pt">' . strtoupper(mes($mes)) . " DE "  . $annio .'</td>';
				}else if($datos_c[0]['frecuencia'] == "N"){
                    $html .= '<td style="border: inset 0pt">' . $dia . ' DE ' . strtoupper(mes($mes)) . " DE "  . $annio .'</td>';
                }
				
                $listarAnticiposCarteraPorIdVehiculo = $cartera->listarAnticiposCarteraPorIdVehiculo($id_vehiculo, $pp['id_concepto']);
               
				if(count($listarAnticiposCarteraPorIdVehiculo) > 0){
			        if(($pp["fecha_cobro"] >= $listarAnticiposCarteraPorIdVehiculo[0]['fecha_inicial_valido']) && ($pp["fecha_cobro"] < $listarAnticiposCarteraPorIdVehiculo[0]['fecha_final_valido'])){
			            $html .= '<td style="border: inset 0pt">' . "$ ". number_format($pp["valor"] - $listarAnticiposCarteraPorIdVehiculo[0]['valor_anticipo'], 0,",",","). '</td>';
			        }
				}else{
				    $html .= '<td style="border: inset 0pt">' . "$ ". number_format($pp["valor"], 0,",",","). '</td>';
				}
            $html .= '</tr>';
            
            $a = $a + 1;
        }
        
        if(count($listarAnticiposPorVehiculo) > 0){
            foreach($listarAnticiposPorVehiculo As $lapv){
                $html .= '<tr align="center">';								
        		    $html .= '<td style="border: inset 0pt"></td>';								
        		    $html .= '<td style="border: inset 0pt"><strong>SALDO A FAVOR</strong></td>';								
        		    $html .= '<td style="border: inset 0pt"></td>';								
        		    $html .= '<td style="border: inset 0pt"><input type="text" name="valor_anticipo" id="valor_anticipo" readonly value="'  . "$ " . number_format($lapv['valor_anticipo']) . '" style="border: 0; text-align: center;" ></td>';								
        		$html .= '</tr>';
            }
        }else{
            $html .= '<tr align="center">';								
    		    $html .= '<td style="border: inset 0pt"></td>';								
    		    $html .= '<td style="border: inset 0pt"><strong>SALDO A FAVOR</strong></td>';								
    		    $html .= '<td style="border: inset 0pt"></td>';								
    		    $html .= '<td style="border: inset 0pt"><input type="text" name="valor_anticipo" id="valor_anticipo" readonly value="$ 0"  style="border: 0; text-align: center;" ></td>';								
    		$html .= '</tr>'; 
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

	    var valor_anticipo = document.getElementById('valor_anticipo').value;
	    var split2 = valor_anticipo.split(' ');
	    
	    
	    if(split2[1] != 0){
    	    valor_anticipo = split2[1].replaceAll(",", "");
	    }else{
	        valor_anticipo = split2[1];
	    }
	    
    	var total_con_anticipo = (total - valor_anticipo);
    	
	    if(valor_anticipo != 0){
    	    if(total != 0){
    	        if(total_con_anticipo < 0){
    	            document.getElementById('valor_total').innerHTML = '$ ' + new Intl.NumberFormat("es-ES").format("0");
    	        }else{
    	            document.getElementById('valor_total').innerHTML = '$ ' + new Intl.NumberFormat("es-ES").format(total_con_anticipo);
    	        }
    	        document.getElementById('valor_final').innerHTML = '<input type="hidden" name="total" id="total" class="form-control" value="' + total +'" />';
    	    }else{
    	        document.getElementById('valor_total').innerHTML = '$ ' + new Intl.NumberFormat("es-ES").format(total);
    	        document.getElementById('valor_final').innerHTML = '<input type="hidden" name="total" id="total" class="form-control" value="' + total + '" />';
    	    }
	    }else{
	        document.getElementById('valor_total').innerHTML = '$ ' + new Intl.NumberFormat("es-ES").format(total);
	        document.getElementById('valor_final').innerHTML = '<input type="hidden" name="total" id="total" class="form-control" value="' + total + '" />';
	    }
	    
	    
	    comparar();
    }
    
    
	function comparar(){
		var valor_consignado = document.getElementById('valor_pago').value;
		valor_consignado = valor_consignado.replaceAll(".", "");

	    var valor_anticipo = document.getElementById('valor_anticipo').value;
	    var split2 = valor_anticipo.split(' ');
	    
	    
	    if(split2[1] != 0){
    	    valor_anticipo = split2[1].replaceAll(",", "");
	    }else{
	        valor_anticipo = split2[1];
	    }
	    
    	var total_con_anticipo = (total - valor_anticipo);
	    
	    
		if(valor_anticipo == 0){	
    		if(valor_consignado > total){
				document.getElementById("total_diferencia").style.display = "flex";
                document.getElementById("detalle_diferencia").style.display = "flex";
                document.getElementById("valor_pago").style.borderColor = "#ced4da";
        		var diferencia = (valor_consignado - total);
        		//alert(diferencia);
        		
                $("#diferencia_valores").val(diferencia);
				$("#diferencia").val(diferencia);
        		
        	    $('#detalle').prop('required', true);
    		}else if(valor_consignado < total){ 
				document.getElementById("total_diferencia").style.display = "flex";
				document.getElementById("detalle_diferencia").style.display = "flex";
                document.getElementById("valor_pago").style.borderColor = "red";
				var diferencia = (valor_consignado - total);
        		//alert(diferencia);
        		
                $("#diferencia_valores").val(diferencia);
				$("#diferencia").val(diferencia);
        		
        	    $('#detalle').prop('required', true);
    		}else {
                document.getElementById("valor_pago").style.borderColor = "#ced4da";
                document.getElementById("detalle_diferencia").style.display = "none";
				document.getElementById("total_diferencia").style.display = "none";
        	    $('#detalle').prop("required", false);
				$("#diferencia_valores").val(diferencia);
				$("#diferencia").val('0');
    		}	
    	}else if(valor_anticipo != 0) {
    	    if(valor_consignado > total_con_anticipo){
				document.getElementById("total_diferencia").style.display = "flex";
                document.getElementById("detalle_diferencia").style.display = "flex";
                document.getElementById("valor_pago").style.borderColor = "#ced4da";
        		var diferencia = (valor_consignado - total_con_anticipo);
        		$("#diferencia_valores").val(diferencia);
				$("#diferencia").val(diferencia);
        	    $('#detalle').prop('required', true);
    		}else if(valor_consignado < total_con_anticipo){ 
				document.getElementById("total_diferencia").style.display = "flex";
                document.getElementById("valor_pago").style.borderColor = "red";
				document.getElementById("detalle_diferencia").style.display = "flex";
        		var diferencia = (valor_consignado - total_con_anticipo);
        		$("#diferencia_valores").val(diferencia);
				$("#diferencia").val(diferencia);
        	    $('#detalle').prop('required', true);
    		}else {
                document.getElementById("valor_pago").style.borderColor = "#ced4da";
                document.getElementById("detalle_diferencia").style.display = "none";
				document.getElementById("total_diferencia").style.display = "none";
				$("#diferencia_valores").val(diferencia);
        	    $('#detalle').prop("required", false);
				$("#diferencia").val('0');
    		}
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