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
    $pdf->Cell(150, 4, utf8_decode("REF: SOLICITUD CAPACIDAD TRANSPORTADORA"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(35, 4, utf8_decode("Cordialmente solicito la"), 0, '0','J');
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(47, 4, utf8_decode("CAPACIDAD TRANSPORTADORA"), 0, '0','J');
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(68, 4, utf8_decode(", del vehiculo que a continuación relacionamos"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("con las siguientes características:"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CLASE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": X"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MARCA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MODELO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° MOTOR"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);

    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° CHASIS"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("COMBUSTIBLE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("PROPIETARIO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXXX"), 0, '0','J');
    $pdf->Cell(120, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("NIT"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXXXX"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CAPACIDAD"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXXXXX"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("Anexamos los siguientes documentos para el trámite: Certificado de Aceptación a la compañía, fotocopia"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','', 9.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("de la Factura de Chasis, Fotocopia de factura de Carrocería, Certificado de Importación, Ficha de"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','', 9.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("homologación chasis, Ficha Homologación Carrocería."), 0, '0','J');
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
    
    $pdf->Ln(5);
    
    /*-------------------------------------------------------*/
    /*----------------------- PAGE 2 ------------------------*/
    /*-------------------------------------------------------*/

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
    
    $pdf->SetFont('Arial','', 8.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("CIUDAD BOGOTA D.C"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(11);
    
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("REF: CERTIFICADO DE ACEPTACION"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(5, 4, utf8_decode("La"), 0, '0','FJ');
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(72, 4, utf8_decode("ORGANIZACIÓN DE TRANSPORTES ORT SAS"), 'B', '0','C');
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell2(73, 4, utf8_decode("., sociedad legalmente constituida con domicilio"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(54, 4, utf8_decode("en Bogotá, con registro mercantil No."), 0, '0','FJ');
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(25, 4, utf8_decode("01166641"), 'B', '0','C');
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(10, 4, utf8_decode("Nit No "), 0, '0','FJ');
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(30, 4, utf8_decode("830.099.803-4"), 'B', '0','C');
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell2(31, 4, utf8_decode("y con resolución No."), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(15, 4, utf8_decode("005373"), 'B', '0','C');
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell2(40, 4, utf8_decode("del Ministerio de Transporte"), 0, '0','FJ');
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(13, 4, utf8_decode("ACEPTA,"), 0, '0','J');
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell2(82, 4, utf8_decode("la afiliación del siguiente vehículo, con previo cumplimiento"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("de los requisitos exigidos por parte del Ministerio de Transporte:"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CLASE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": X"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MARCA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MODELO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° MOTOR"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);

    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° CHASIS"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("COMBUSTIBLE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("PROPIETARIO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXXX"), 0, '0','J');
    $pdf->Cell(120, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("NIT"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXXXX"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CAPACIDAD"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXXXXX"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("Adicionalmente certificamos que actualmente existe un contrato de vinculación."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(7);
    
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(150, 4, utf8_decode("Agradezco de antemano su amable atención y colaboración para con nosotros."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', '', 9.5);
    $pdf->Cell(25, 4, "", 0, 0, 'C');
    $pdf->Cell2(153, 4, utf8_decode("Cordialmente,"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    
    $pdf->Ln(17);
    
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
    
    $pdf->Ln(2);
    
    /*-------------------------------------------------------*/
    /*----------------------- PAGE 3 ------------------------*/
    /*-------------------------------------------------------*/

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
    
    $pdf->SetFont('Arial','', 8.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("CIUDAD BOGOTA D.C"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(11);
    
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("REF: SOLICITUD CAPACIDAD TRANSPORTADORA"), 0, '0','FJ');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(35, 4, utf8_decode("Cordialmente solicito la"), 0, '0','J');
    $pdf->SetFont('Arial','B', 8.1);
    $pdf->Cell(47, 4, utf8_decode("CAPACIDAD TRANSPORTADORA"), 0, '0','J');
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(68, 4, utf8_decode(", del vehiculo que a continuación relacionamos"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("con las siguientes características:"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CLASE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": X"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MARCA"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("MODELO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° MOTOR"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);

    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("N° CHASIS"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("COMBUSTIBLE"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXX"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("PROPIETARIO"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXXX"), 0, '0','J');
    $pdf->Cell(120, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("NIT"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXXXX"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell2(25, 4, utf8_decode("CAPACIDAD"), 0, '0','J');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell2(25, 4, utf8_decode(": XXXXXXXXX"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial','', 9.2);
    $pdf->Cell(20, 4, "", 0, 0, 'C');
    $pdf->Cell(150, 4, utf8_decode("Anexamos los siguientes documentos para el trámite:"), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(8);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(30, 4, "", 0, 0, 'C');
    $pdf->Cell2(5, 4, utf8_encode("* "), 0, '0','J');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(135, 4, utf8_decode("Licencia de Transito."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(30, 4, "", 0, 0, 'C');
    $pdf->Cell2(5, 4, utf8_encode("* "), 0, '0','J');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(135, 4, utf8_decode("Carta de Aceptación."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    $pdf->Ln(1);
    
    $pdf->SetFont('Arial', 'B', 8.1);
    $pdf->Cell(30, 4, "", 0, 0, 'C');
    $pdf->Cell2(5, 4, utf8_encode("* "), 0, '0','J');
    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Cell2(135, 4, utf8_decode("Recibo por concepto de disponibilidad de capacidad."), 0, '0','J');
    $pdf->Cell(20, 4, "", 0, 1, 'C');
    
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', '', 9.5);
    $pdf->Cell(25, 4, "", 0, 0, 'C');
    $pdf->Cell2(153, 4, utf8_decode("Cordialmente,"), 0, '0','J');
    $pdf->Cell(17, 4, "", 0, 1, 'C');
    
    $pdf->Ln(17);
    
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
    
    
    $pdf->Output();
    
?>