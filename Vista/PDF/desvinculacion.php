<?php 

require_once("../../Resources/fpdf/fpdf.php");
require("../../Modelo/General.php");


    class PDF extends FPDF{
    	
    	function Header(){
            $this->Image('../../Resources/fpdf/img/logo-ort.jpg', 10,5,30);
    		$this->Image('../../Resources/fpdf/img/logo-vigilado-supertransporte.png',150,6,45);
    		$this->SetFont('Arial','',14);	
    		$this->SetDrawColor(191, 216, 239);	
    		$this->SetLineWidth(0.4);
    		$this->Cell(0, 20,'', 'B', 1, '');
    		$this->Ln(15);
        }
        
        function Footer(){
            
            $this->Ln(3);	
            $this->SetDrawColor(191, 216, 239);
    		$this->SetLineWidth(0.4);
    		$this->Cell(0, 13,'', 'B', 1, '');
            $this->Image('../../Resources/fpdf/img/logo-ort.jpg', 10,255,30);
            $this->SetTextColor(113, 113, 113);
            $this->SetFont('Arial','',9);
            $this->Ln(2);	
            $this->Cell(32, 5, '', 0,'0','J');	
            $this->Cell(147, 5, utf8_decode('Calle 73 N. 75-55. Santa Maria del Lago'), 0,'1','J');
            $this->Cell(32, 5, '', 0,'0','J');	
            $this->Cell(147, 5, utf8_decode('Info@ortsas.com - www.ortsas.com'), 0,'1','J');
            $this->Cell(32, 5, '', 0,'0','J');	
            $this->Cell(147, 5, utf8_decode('PBX. 5559265/60/61 Ext. 100'), 0,'1','J');
            $this->Cell(32, 5, '', 0,'0','J');	
            $this->Cell(147, 5, utf8_decode('Bogotá, D.C - Colombia'), 0,'1','J');
            
    	}

    }

    $pdf = new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    $dia = date('d');
    $mes = date('m');
    $año = date('Y');

    $pdf->SetFont('Arial','', 8.5);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("BOGOTÁ ") . $dia ." DE " . strtoupper(mes($mes)) . " DEL " . $año, 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("Señores:"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("MINISTERIO DE TRANSPORTE"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("CIUDAD BOGOTA D.C"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(11);
    
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("REF: SOLICITUD DESVINCULACION POR MUTUO ACUERDO"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(70, 4, utf8_decode("ORGANIZACIÓN DE TRANSPORTES ORT SAS"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(15, 4, utf8_decode("con NIT"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(24, 4, utf8_decode("830.099.803-4"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 8.5);
    $pdf->Cell2(44, 4, utf8_decode("sociedad legalmente constituida"), 0, '0','FJ');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(153, 4, utf8_decode("con domicilio en Bogotá, informa que acepta la desvinculación del vehículo por mutuo acuerdo con las"), 0, '0','FJ');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(153, 4, utf8_decode("siguientes características."), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CLASE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": BUS"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MARCA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": HYUNDAI HD72"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MODELO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": 2009"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° MOTOR"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": D4DB8360907"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);

    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° CHASIS"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": KMFGA17BP9C900573"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("COMBUSTIBLE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": DIESEL"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CAPACIDAD"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": 32 " . "PASAJEROS"), 0, '0','J');
    $pdf->Cell(120, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("PLACA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": SMN584"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(10);
    
     	
    $pdf->SetFont('Arial', '', 9.5);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(153, 4, utf8_decode("Se anexa la documentación pertinente para realizar dicho trámite:"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    
    $pdf->Ln(8);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(30, 4, "", 0, 0, 'C');
    $pdf->Cell2(5, 4, utf8_encode("* "), 0, '0','J');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(135, 4, utf8_decode("Paz y Salvo"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(30, 4, "", 0, 0, 'C');
    $pdf->Cell2(5, 4, utf8_encode("* "), 0, '0','J');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(135, 4, utf8_decode("Licencia de Tránsito"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(30, 4, "", 0, 0, 'C');
    $pdf->Cell2(5, 4, utf8_encode("* "), 0, '0','J');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(135, 4, utf8_decode("Certificación de capacidad transportadora"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(16);
    
    
    $pdf->SetFont('Arial', '', 9.5);
    $pdf->Cell(25, 4, "", 0, 0, 'C');
    $pdf->Cell2(153, 4, utf8_decode("Cordialmente,"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    
    $pdf->Ln(20);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(75, 4, $pdf->Image("../../Resources/fuec/img/Firma_FUEC_ORT.jpg", $pdf->GetX(), $pdf->GetY() -15, 35), 0, 0, 'C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_encode("GONZALO LOPEZ PINTO"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 7.5);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_encode("REPRESENTANTE LEGAL"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    
    
    /* ---------------------------------------------------------------- */
    /* ------------------------- PAGE 2 ------------------------------- */
    /* ---------------------------------------------------------------- */
    
    $pdf->AddPage();
    
    $dia = date('d');
    $mes = date('m');
    $año = date('Y');

    $pdf->SetFont('Arial','', 8.5);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("BOGOTÁ ") . $dia ." DE " . strtoupper(mes($mes)) . " DEL " . $año, 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(6);
    
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("Señores:"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("MINISTERIO DE TRANSPORTE"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("CIUDAD BOGOTA D.C"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(6);
    
     
    $pdf->SetFont('Arial','B',8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("REF: SOLICITUD DESVINCULACION POR MUTUO ACUERDO"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(8);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(70, 4, utf8_decode("ORGANIZACIÓN DE TRANSPORTES ORT SAS"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 8.8);
    $pdf->Cell2(80, 4, utf8_decode("sociedad legalmente constituida con domicilio en Bogotá"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(18, 4, utf8_decode("con NIT N°"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(24, 4, utf8_decode("830.099.803-4"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(108, 4, utf8_decode("informa que acepta la desvinculación del vehículo por mutuo acuerdo"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("con las siguientes características."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(4);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CLASE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": BUS"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MARCA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": HYUNDAI HD72"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MODELO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": 2009"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° MOTOR"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": D4DB8360907"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);

    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° CHASIS"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": KMFGA17BP9C900573"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("COMBUSTIBLE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": DIESEL"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CAPACIDAD"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": 32 " . "PASAJEROS"), 0, '0','J');
    $pdf->Cell(120, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("PLACA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": SMN584"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(4);
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(50, 4, utf8_decode("Hacemos constar que el vehículo"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.3);
    $pdf->Cell2(33, 4, utf8_decode("SMN584"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(40, 4, utf8_decode("se encuentra a la fecha a"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.2);
    $pdf->Cell2(20, 4, utf8_decode("PAZ Y SALVO"), 0, '0','FJ');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(7, 4, utf8_decode("con"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', 'B', 8.3);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(68, 4, utf8_decode("ORGANIZACIÓN DE TRANSPORTES ORT SAS"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(14, 4, utf8_decode("a su vez"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.3);
    $pdf->Cell2(68, 4, utf8_decode("ORGANIZACIÓN DE TRANSPORTES ORT SAS"), 'B', '0','C'); 
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.3);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("se encuentra a"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.4);
    $pdf->Cell2(35, 4, utf8_decode("TOTAL PAZ Y SALVO"), 0, '0','FJ');
    $pdf->SetFont('Arial', '', 9.3);
    $pdf->Cell2(90, 4, utf8_decode("por todo concepto con el (la) (los) (las) propietario (a) (s)"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(69, 4, utf8_decode("NELSON H. VILLAMIL CASTELLANOS"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(61, 4, utf8_decode(", identificado con cédula de ciudadanía No"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.3);
    $pdf->Cell2(20, 4, utf8_decode("3.103.351"), 'B', '0','C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("por servicios en cualquier tiempo, por eventuales reclamaciones de terceros, entidad pública, privada,"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("persona natural o jurídica contra la empresa y/o propietario o tenedor del vehículo con fundamento en"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("las responsabilidades contractuales y extracontractuales o sanciones pendientes o dejadas de pagar."), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(2);
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(31, 4, utf8_decode("El(La) propietario(a),"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell2(66, 4, utf8_decode("NELSON H. VILLAMIL CASTELLANOS"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(53, 4, utf8_decode("identificado con cédula de ciudadanía"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(6, 4, utf8_decode("No."), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell2(20, 4, utf8_decode("3.103.351"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(124, 4, utf8_decode(", reembolsará a la Empresa lo que ésta tenga que pagar por los hechos relacionados"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("con el automotor y que comprometen su responsabilidad durante el tiempo que estuvo vinculado el"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("mencionado automotor a esta Empresa."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(3);
    
    $fechaExpedicion = explode("-", date('Y-m-d'));
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("Se expide a los " . convertir($fechaExpedicion[2]) . " (" . $fechaExpedicion[2] . ") días del mes de " . mes($fechaExpedicion[1]) . " (" . $fechaExpedicion[1] .") del año 2020. Valido por treinta (30) días"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(18, 4, utf8_decode("únicamente"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell2(36, 4, utf8_decode("para nueva vinculación a "), 0, '0','J');
    $pdf->Cell2(94, 4, utf8_decode("SEVITRANS S.A."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(5);
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(75, 4, "Cordialmente", 0, 0, 'C');
    $pdf->Cell(75, 4, "Propietario", 0, 0, 'C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(11);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(75, 4, $pdf->Image("../../Resources/fuec/img/Firma_FUEC_ORT.jpg", $pdf->GetX() +20, $pdf->GetY() -11, 35), 0, 0, 'C');
    $pdf->Cell(75, 4, utf8_decode(""), 0, 0, 'C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(75, 4, utf8_decode("GONZALO LÓPEZ PINTO"), 0, 0, 'C');
    $pdf->Cell(75, 4, utf8_decode("NELSON H. VILLAMIL CASTELLANOS"), 0, 0, 'C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(75, 4, utf8_decode("Representante Legal"), 0, 0, 'C');
    $pdf->Cell(75, 4, utf8_decode("C.C. 3.103.351 "), 0, 0, 'C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 8.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(75, 4, utf8_decode("ORGANIZACIÓN DE TRANSPORTES ORT SAS"), 0, 0, 'C');
    $pdf->Cell(75, 4, utf8_decode(""), 0, 0, 'C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    /* ---------------------------------------------------------------- */
    /* ------------------------- PAGE 3 ------------------------------- */
    /* ---------------------------------------------------------------- */
    
    $pdf->AddPage();
    
    $dia = date('d');
    $mes = date('m');
    $año = date('Y');

    $pdf->SetFont('Arial','', 8.5);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("BOGOTÁ ") . $dia ." DE " . strtoupper(mes($mes)) . " DEL " . $año, 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(6);
    
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("Señores:"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("MINISTERIO DE TRANSPORTE"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("CIUDAD BOGOTA D.C"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(6);
    
     
    $pdf->SetFont('Arial','B',8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("REF: SOLICITUD DESVINCULACION POR MUTUO ACUERDO"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(8);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(68, 4, utf8_decode("NELSON H. VILLAMIL CASTELLANOS"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9.1);
    $pdf->Cell2(60, 4, utf8_decode("identificado con cédula de ciudadanía No"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(22, 4, utf8_decode("3.103.351"), 'B', '0','C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("declaro de forma libre y espontánea, haciendo uso de todas mis facultades físicas y mentales, manifiesto "), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(67, 4, utf8_decode("la decisión de desvincularme de la Compañía"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.2);
    $pdf->Cell2(68, 4, utf8_decode("ORGANIZACIÓN DE TRANSPORTES ORT SAS"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(15, 4, utf8_decode("sabiendo"), 0, '0','C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(31, 4, utf8_decode("y entendiendo que el"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.2);
    $pdf->Cell2(20, 4, utf8_decode("PAZ Y SALVO"), 0, '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(99, 4, utf8_decode("expedido a la fecha para el vehículo de las características que a"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("continuación se relaciona, no implica de exoneración de la responsabilidad civil y administrativa que en"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("calidad de propietario adquirí hasta la fecha y debo asumir posteriormente la totalidad de los valores"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("de cualquier proceso jurídico y/o civil, comparendos y/o multas, impugnaciones y demás que lleguen"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("a imponerse o que hayan sido impuestas y/o se conozcan a la fecha durante el tiempo que fue"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.3);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("manejado el vehículo por una persona deferente y/o por mí mismo, estando vinculado en"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', 'B', 8.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(70, 4, utf8_decode("ORGANIZACIÓN DE TRANSPORTES ORT SAS"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(80, 4, utf8_decode("Si la empresa en mención se ve afectada, investigada"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("y/o involucrada con cualquier entidad Pública, Privada, Persona natural, Jurídica o cualquier otra;"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(49, 4, utf8_decode("tales responsabilidades por tanto"), 0, '0','J');
    $pdf->SetFont('Arial', 'B', 8.2);
    $pdf->Cell2(5, 4, utf8_decode("NO"), 0, '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(21, 4, utf8_decode("son objeto de"), 0, '0','J');
    $pdf->SetFont('Arial', 'B', 8.2);
    $pdf->Cell2(20, 4, utf8_decode("PAZ Y SALVO"), 0, '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(55, 4, utf8_decode("y se harán efectivas en el momento "), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("que los fallos judiciales y/o Administrativos que lleguen a establecerlo; por lo tanto, manifiesto"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("que dichas obligaciones serán canceladas por mí, como figura al pie de mi firma."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(6);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CLASE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": BUS"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MARCA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": HYUNDAI HD72"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MODELO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": 2009"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° MOTOR"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": D4DB8360907"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);

    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° CHASIS"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": KMFGA17BP9C900573"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("COMBUSTIBLE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": DIESEL"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CAPACIDAD"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": 32 " . "PASAJEROS"), 0, '0','J');
    $pdf->Cell(120, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("PLACA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": SMN584"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(6);
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(23, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("Cordialmente"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(2);
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(25, 4, "", 0, 0, 'C');
    $pdf->Cell2(18, 18, "", 1, '0','J');
    $pdf->Cell2(133, 17, "", 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(15);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("HUELLA DACTILAR"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(2);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(75, 4, utf8_decode("NELSON H. VILLAMIL CASTELLANOS"), 0, 0, 'J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(75, 4, utf8_decode("C.C. 3.103.351"), 0, 0, 'J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(6);
    
    /* ---------------------------------------------------------- */
    /* ------------------------ PAGE 4 -------------------------- */
    /* ---------------------------------------------------------- */
    
    $pdf->AddPage();
    
    $dia = date('d');
    $mes = date('m');
    $año = date('Y');

    $pdf->SetFont('Arial','', 8.5);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("BOGOTÁ ") . $dia ." DE " . strtoupper(mes($mes)) . " DEL " . $año, 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(6);
    
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("Señores:"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("MINISTERIO DE TRANSPORTE"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("CIUDAD BOGOTA D.C"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(6);
    
     
    $pdf->SetFont('Arial','B',8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("REF: SOLICITUD DESVINCULACION POR MUTUO ACUERDO"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(8);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(70, 4, utf8_decode("ORGANIZACIÓN DE TRANSPORTES ORT SAS"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(17, 4, utf8_decode("con NIT N°"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(23, 4, utf8_decode("830.099.803-4"), 'B', '0','C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(40, 4, utf8_decode("hace constar que el vehículo"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(88, 4, utf8_decode("que se relaciona a continuación, se encuentra a la fecha a"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.2);
    $pdf->Cell2(20, 4, utf8_decode("PAZ Y SALVO"), 0, '0','C');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(42, 4, utf8_decode("por concepto de pagos de"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("administración."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(7);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CLASE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": BUS"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MARCA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": HYUNDAI HD72"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MODELO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": 2009"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° MOTOR"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": D4DB8360907"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);

    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° CHASIS"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": KMFGA17BP9C900573"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("COMBUSTIBLE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": DIESEL"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CAPACIDAD"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": 32 " . "PASAJEROS"), 0, '0','J');
    $pdf->Cell(120, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("PLACA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": SMN584"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(7);
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("Se expide a los " . convertir($fechaExpedicion[2]) . " (" . $fechaExpedicion[2] . ") días del mes de " . mes($fechaExpedicion[1]) . " (" . $fechaExpedicion[1] .") por solicitud del propietario para nueva vinculación "), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(3, 4, utf8_decode("a"), 0, '0','FJ');
    $pdf->SetFont('Arial', 'B', 8.2);
    $pdf->Cell2(147, 4, utf8_decode("SEVITRANS S.A."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
   
    $pdf->Ln(25);
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(25, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("Cordialmente"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(20);

    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(75, 4, $pdf->Image("../../Resources/fuec/img/Firma_FUEC_ORT.jpg", $pdf->GetX(), $pdf->GetY() -15, 35), 0, 0, 'C');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("GONZALO LÓPEZ PINTO"), 0, 0, 'J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(22, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("Representante Legal"), 0, 0, 'J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->Ln(16);


    $pdf->Output();
    
?>