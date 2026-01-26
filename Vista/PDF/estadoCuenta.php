<?php

ob_start();
	require('../../Resources/fuec/fpdf.php');
	require('../../Resources/fpdf-easytable-master/exfpdf.php');
	require('../../Resources/fpdf-easytable-master/easyTable.php');
	require('../../Modelo/General.php');
	require('../../Modelo/Vehiculo.php');
	require('../../Modelo/ConceptosCobro.php');
	require('../../Modelo/Usuario.php');
	
    $id_vehiculo = $_POST['vehiculo'];
    $fecha_mes = $_POST['fechaMes'];
    $tipoReporte = $_POST['tipoReporte'];
	
    $vehiculo = new Vehiculo();
    $listarVehiculoPorId = $vehiculo->listarPorId($id_vehiculo);
    
    $usuario = new Usuario();
    $listarUsuarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']);
    
    $conceptoCobro = new ConceptoCobro();
    
    if($tipoReporte == "V"){
        $listarCobrosPorVehiculo = $conceptoCobro->listarCobrosPorVehiculo($id_vehiculo);
        //print_r($listarCobrosPorVehiculo);
    }else if($tipoReporte == "VM"){
        $listarCobrosPorVehiculo = $conceptoCobro->listarFiltroEstadoCuentaVehiculo($id_vehiculo, $fecha_mes);
        //print_r($listarCobrosPorVehiculo);
    }
    
    
    //$listarTotalCobrosPorVehiculo = $conceptoCobro->listarTotalCobrosPorVehiculo($id_vehiculo);
    //$listarConceptos = $conceptoCobro->listarActivos();
    //print_r($listarCobrosPorVehiculo);
    //print_r($listarTotalCobrosPorVehiculo);
    
    
	class PDF extends exFPDF{

	    function  Header(){

            $id_vehiculo1 = $_POST['vehiculo'];
            
            $vehiculo1 = new Vehiculo();
            $listarVehiculoPorId1 = $vehiculo1->listarPorId($id_vehiculo1);
            
            $usuario1 = new Usuario();
            $listarUsuarioPorId1 = $usuario1->listarUsuarioPorId($listarVehiculoPorId1[0]['id_propietario']);
            
            if (($listarVehiculoPorId1[0]['numero_movil'] >= 1)&&($listarVehiculoPorId1[0]['numero_movil'] <= 999)){ 
            
                // Logo
                $this->SetFont('Arial','B',11);
                $this->Cell(70,30,$this->Image("../../Resources/fpdf/img/logo-ort.jpg", $this->GetX()+12, $this->GetY()+1, 40),0,0,'J');

            } else if (($listarVehiculoPorId1[0]['numero_movil'] >= 1000) && ($listarVehiculoPorId1[0]['numero_movil'] <= 1999)){

    	        // Logo
    	        $this->SetFont('Arial','B',11);
    			$this->Cell(70,30,$this->Image("../../Resources/img/logo-lp.png", $this->GetX()+12, $this->GetY()+1, 40),0,0,'J');
            }
            
            date_default_timezone_set('America/Bogota');
            $dia = date('d');
            $mes = date('m');
            $año = date('Y');
            
	        $this->SetFont('Arial','B', 8.1);
            $this->Cell(9, 4, "", 0, 0,'J');
            $this->Cell(120, 4, utf8_decode("BOGOTÁ ") . $dia ." DE " . strtoupper(mes($mes)) . " DEL " . $año, 0, '1','J');
            
	        $this->SetFont('Arial','B', 8.1);
        	$this->Cell(79, 5,'',0,'0','C');
            $this->Cell(16, 4, utf8_decode("AFILIADO "), 0, '0','J');
	        $this->SetFont('Arial','', 8.5);
            $this->Cell(102, 4, $listarUsuarioPorId1[0]['usuario'], 0, '1','J');
		    
		    $this->Ln(4);
		    
        	$this->SetFont('Arial','B',8.2);
        	$this->Cell(80, 5,'',0,'0','C');
        	$this->Cell(100, 5, utf8_decode('INFORME DE CARTERA MOVIL N° ' . $listarVehiculoPorId1[0]['numero_movil']) ,1,'0','C');
        	$this->Cell(10, 5, '',0,'1','C');
        	
		    $this->Ln(1);
		   
        	$this->Cell(80, 5,'',0,'0','C');
        	$this->SetFont('Arial','',8);
        	$this->Cell(100, 5, '' . $listarVehiculoPorId1[0]['placa'] . ' - M' . $listarVehiculoPorId1[0]['numero_movil'],1,'0','C');
        	$this->Cell(10, 5, '',0,'1','C');
        	
		    $this->Ln(13);

	    }



	    function Footer(){
	        
            $id_vehiculo1 = $_POST['vehiculo'];
            
            $vehiculo1 = new Vehiculo();
            $listarVehiculoPorId1 = $vehiculo1->listarPorId($id_vehiculo1);
	        
	        $this->SetY(-50);
	        $this->SetX(56);
	        
    		$this->SetDrawColor(191, 216, 239);	
    		$this->SetLineWidth(0.2);
    		$this->Cell(0, 20,'', 'B', 1, '');

            $this->Ln(4);

            if (($listarVehiculoPorId1[0]['numero_movil'] >= 1)&&($listarVehiculoPorId1[0]['numero_movil'] <= 999)){ 
            
                // Posición: a 1,5 cm del final
                $this->SetY(-32);
                $this->Cell(70,30, $this->Image("../../Resources/fpdf/img/logo-ort.jpg", $this->GetX(), $this->GetY()+1, 40),0,0,'J');

            } else if (($listarVehiculoPorId1[0]['numero_movil'] >= 1000) && ($listarVehiculoPorId1[0]['numero_movil'] <= 1999)){
            
    	        // Posición: a 1,5 cm del final
    	        $this->SetY(-32);
    			$this->Cell(70,30, $this->Image("../../Resources/img/logo-lp.png", $this->GetX(), $this->GetY()+1, 40),0,0,'J');
            }
			
	        $this->SetY(-25);
	        $this->SetX(60);
	        
            $this->SetTextColor(113, 113, 113);
            $this->SetFont('Arial','',9);
        	$this->Cell(0, 4, utf8_decode('Calle 73 N. 75-55. Santa Maria del Lago'), 0,'1','J');

	        $this->SetX(60);	
            $this->Cell(0, 4, utf8_decode('Info@ortsas.com - www.ortsas.com'), 0,'1','J');
    
	        $this->SetX(60);
            $this->Cell(0, 4, utf8_decode('PBX. 5559265/60/61 Ext. 100'), 0,'1','J');
    
	        $this->SetX(60);	
            $this->Cell(0, 4, utf8_decode('Bogotá, D.C - Colombia'), 0,'1','J');
			
	        // Arial italic 8
	        $this->SetFont('Arial','I',8);

	    }

	}

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	
	$pdf->SetFont('Arial','B',9);
	
	$pdf->Cell(10, 6,'',0,'0','C');
	$pdf->Cell(70, 6, utf8_decode('SERVICIO') ,1,'0','C');
	$pdf->Cell(30, 6, utf8_decode('AÑO') ,1,'0','C');
	$pdf->Cell(35, 6, utf8_decode('MES') ,1,'0','C');
	$pdf->Cell(35, 6, utf8_decode('VALOR CARTERA') ,1,'0','C');
	$pdf->Cell(10, 6,'',0,'1','C');
	
	$pdf->Ln(1);
	
	
	$valoresCobros = array();
	$id_concepto_actual = 0;
	
	foreach($listarCobrosPorVehiculo As $lcpv){
	    array_push($valoresCobros, $lcpv['valor']);
	    
	   
	        $pdf->SetFont('Arial','',8);
        	$pdf->Cell(10, 6,'',0,'0','C');
        	$listarConceptosPorId = $conceptoCobro->listarPorId($lcpv['id_concepto']);
        	$pdf->Cell(70, 6, utf8_decode($listarConceptosPorId[0]['detalle_concepto']), 1,'0','C');
        	
        	$fechas = explode("-", $lcpv['fecha_cobro']);
        	$anio = $fechas[0];
        	$mes = $fechas[1];
        	
    	    $pdf->SetFont('Arial','',9);
        	$pdf->Cell(30, 6, $anio,1,'0','C');
    	    $pdf->SetFont('Arial','',8);
        	$pdf->Cell(35, 6, utf8_decode(strtoupper(mes($mes))),1,'0','C');
        	$pdf->Cell(35, 6, utf8_decode("$ " . number_format($lcpv['valor'])) ,1,'0','C');
        	$pdf->Cell(10, 6,'',0,'1','C');
    	    $pdf->Ln(1);
	   
	    
	}
    	
	$valorTotalCobros = array_sum($valoresCobros);
	
	
	
    /*
	$mes = ['enero','febrero','marzo','abril','mayo','junio'];
	
	$total = count($mes);
	
	$posicionTitulo = round($total / 2);
	$ultimaPosicion = $total - 1;
	
	$pdf->SetFont('Arial','',7);
	$table = new easyTable($pdf, '{10, 70, 30, 35, 35, 10}', 'font-size: 7; font-family:Arial;');
    
    
    
	$i = 0;
	
        foreach($mes As $lm){
            
            $table->easyCell('', 'align:C;');
            
            if($i == 0){
                $table->easyCell('', 'border: T-L; align:C;');
            }else if($i == ($total - 1)){
                $table->easyCell('', 'border: B-L-R; align:C;');
            }else if($i == ($posicionTitulo - 1)){
                $table->easyCell('RODAMIENTOS', 'border: L; align:C;');
            }else{
                $table->easyCell('', 'border: R-L; align:C;');
            }
            
            if($i == 0){
                $table->easyCell('', 'border: T-L; align:C;');
            }else if($i == ($total - 1)){
                $table->easyCell('', 'border: B-R; align:C;');
            }else if($i == ($posicionTitulo - 1)){
                $table->easyCell('2020', 'border: R-L; align:C;');
            }else{
                $table->easyCell('', 'border: R-; align:C;');
            }
            
            if($i == 0){
                $table->easyCell(strtoupper(utf8_decode($lm)), 'border: B-L-R-T; align:C;');
            }else{
                $table->easyCell(strtoupper(utf8_decode($lm)), 'border: B; align:C;');
            }
            if($i == 0){
                $table->easyCell(' $ ' . number_format('123456'), 'border: T-B-L-R; align:C;');
            }else{
                $table->easyCell(' $ ' . number_format('123456'), 'border: B-L-R; align:C;');
            }
            $table->easyCell('', 'align:C;');
    
            $table->printRow();
            
            $i = $i + 1;
        }
        

    $table->endTable(0);
    
	$pdf->Ln(1);
	
    $a = 0;
    
    $table = new easyTable($pdf, '{10, 70, 30, 35, 35, 10}', 'font-size: 7; font-family:Arial;');
          
            $table->easyCell('', 'align:C;');
            $table->easyCell('POLIZAS', 'border: B-L-T; align:C;');
            $table->easyCell('2020 - 2021', 'border: B-R-L-T; align:C;');
            $table->easyCell(strtoupper(utf8_decode('POLIZAS RCE-RCC')), 'border: B-R-T; align:C;');
            $table->easyCell(' $ ' . number_format('1596482'), 'border: B-L-R-T; align:C;');
            $table->easyCell('', 'align:C;');
    
            $table->printRow();
            
            $a = $a + 1;
       

    $table->endTable(0);
   */
	$pdf->Ln(1);
    
	$pdf->SetFont('Arial','B', 9);
	
	$pdf->Cell(10, 6,'',0,'0','C');
	$pdf->Cell(135, 6, utf8_decode('TOTAL') , 1,'0','C');
	$pdf->Cell(35, 6, ' $ ' . number_format($valorTotalCobros) , 'B-R-T','0','C');
	$pdf->Cell(10, 6,'',0,'1','C');
	$pdf->SetFont('Arial','B', 9);
	
	$pdf->Ln(1);
		    
	$pdf->Cell(10, 6,'',0,'0','C');
	$pdf->SetFont('Arial','', 7.2);
	$pdf->Cell(170, 6, strtr(strtoupper(utf8_decode(convertir($valorTotalCobros))),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉ ÍÓÚÇÑÄËÏÖÜ") . ' PESOS M/CTE.', 'L-B-R-T','0','C');
	$pdf->Cell(10, 6,'',0,'1','C');
					
	$pdf->Ln(35);
		    
	$pdf->SetFont('Arial','B', 8.1);
	$pdf->Cell(10, 4,'',0,'0','C');
    $pdf->Cell(163, 4, "CORDIALMENTE,", 0, '0','FJ');
	$pdf->Cell(10, 4,'',0,'1','C');
	
	
    $pdf->Ln(18);
    
    $pdf->Cell(20, 4, '', 0, '0','FJ');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(50, 4, utf8_decode("JACKELINE MAHECHA"), 0, '0','C');
    $pdf->Cell(50, 4, utf8_decode("MILENA PEREZ"), 0, '0','C');
    $pdf->Cell(50, 4, utf8_decode("YOLANDA SANTANA."), 0, '0','C');
    $pdf->Cell(20, 4, '', 0, '1','FJ');
    
    $pdf->Cell(20, 4, '', 0, '0','FJ');
    $pdf->SetFont('Arial','B',8.1);
    $pdf->Cell(50, 4, utf8_decode("CARTERA."), 0, '0','C');
    $pdf->Cell(50, 4, utf8_decode("ASISTENTE JURIDICA"), 0, '0','C');
    $pdf->Cell(50, 4, utf8_decode("TESORERIA."), 0, '0','C');
    $pdf->Cell(20, 4, '', 0, '1','FJ');
					
					

    $pdf->Output();

?>