<?php

ob_start();
	require('../../Resources/fuec/fpdf.php');
	require('../../Resources/fpdf-easytable-master/exfpdf.php');
	require('../../Resources/fpdf-easytable-master/easyTable.php');
	require('../../Modelo/General.php');
	require('../../Modelo/Usuario.php');
	
    
    
	class PDF extends exFPDF{

	    function  Header(){

	    }

	    function Footer(){

            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0, 10,'Pag '.$this->PageNo().'/{nb}', 0, '0','C');

	    }

	}

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFont('Arial','B', 8.5);
    $pdf->Cell(53, 20, $pdf->Image('../../Resources/img/kingvision_transparente.png',$pdf->GetX()+7, $pdf->GetY()+1, 40), 'L,T,R', '0', 'C');
    $pdf->Cell(82, 20, utf8_decode('INSPECCIÓN VEHICULAR'), 'T','0','C');
    $pdf->Cell(55, 20, '',1,'1','C');
    
	$pdf->SetFont('Arial','B', 7);
    $pdf->Cell(53, 5, "", 'L,R,B', '0', 'C');
    $pdf->Cell(82, 5, "CODIGO: 29092022032400 FKV-02", 1, '0', 'C');
	$pdf->SetFont('Arial','B', 7);
    $pdf->Cell(32, 5, utf8_decode("FECHA INSPECCIÓN:"), 'B', '0', 'C');
	$pdf->SetFont('Arial','', 8.5);
    $pdf->Cell(23, 5, utf8_decode("2022-09-29"), 'R,B', '1', 'J');

    $pdf->ln(1);

    $table = new easyTable($pdf, '%{100}', 'font-size: 7; ');    
        $table->easyCell(utf8_decode("DATOS DE LA EMPRESA"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
        $table->printRow();    
    $table->endTable(0);

    $pdf->ln(1);

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(25, 4,'EMPRESA','1','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(95, 4, utf8_decode(''),'T,B,R','0','C');
	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(25, 4,'NIT','T,B,R','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(45, 4, utf8_decode(''),'T,B,R','1','C');

    $pdf->ln(1);

    $table = new easyTable($pdf, '%{100}', 'font-size: 7; ');    
        $table->easyCell(utf8_decode("DATOS DEL VEHÍCULO"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
        $table->printRow();    
    $table->endTable(0);

    $pdf->ln(1);

    /* -------------------------------------------------------- */
	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(20, 4,'PLACA ','L,B,T','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(15, 4, utf8_decode(''),'T,B,R','0','J');

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(30, 4,'NUMERO MOVIL','T,B','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(15, 4, utf8_decode(''),'T,B,R','0','J');

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(31, 4,'TIPO DE VEHICULO','T,B','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(25, 4, utf8_decode(''),'T,B,R','0','C');

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(32, 4,'FECHA PROX MTTO','T,B','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(22, 4, utf8_decode(''),'T,B,R','1','C');

    /* - */

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(32, 4,'MARCA Y CLASE','L,B','0','C');
    $pdf->Cell(65, 4, utf8_decode(''),'B,R','0','J');

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(18, 4,'MODELO','B','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(20, 4, utf8_decode(''),'B,R','0','J');

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(24, 4,'KILOMETRAJE','B','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(30, 4, utf8_decode(''),'B,R','1','J');

    
    /* - */

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(25, 5,'CAPACIDAD','L,B','0','C');
    $pdf->SetFont('Arial','', 7);
    $pdf->Cell(25, 5, utf8_decode('20 ' . 'PASAJEROS'),'B,R','0','J');

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(30, 5,'TIPO COMBUSTIBLE','B','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(40, 5, utf8_decode(''),'B,R','0','J');

	$pdf->SetFont('Arial','B', 8);
    $pdf->Cell(25, 5,'CANTIDAD','B','0','C');
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(25, 5, "",'B','0','J');
    $pdf->Cell(20, 5, $pdf->Image('../../Resources/images/icono_gasolina.PNG',$pdf->GetX()+2, $pdf->GetY()+1, 7),'B,R','1','J');
    /* -------------------------------------------------------- */

    $pdf->ln(1);

    $table = new easyTable($pdf, '%{100}', 'font-size: 7; ');    
        $table->easyCell(utf8_decode("DATOS DEL CONDUCTOR"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
        $table->printRow();    
    $table->endTable(0);

    $pdf->ln(1);

	$table = new easyTable($pdf, '{25,70,20,25,25,25}', 'font-size: 8; ');
            
        $table->easyCell("NOMBRE CONDUCTOR", 'border: T,L,R,B; font-style:"B"; align:C;');
        $table->easyCell("", 'border: T,B,R; align:C;');
        $table->easyCell("NO. DE CEDULA", 'border: T,B; font-style:"B"; align:C;');
        $table->easyCell("", 'border: T,B,R; align:C;');
        $table->easyCell(utf8_decode("NO. DE CELULAR"), 'border: T,B; font-style:"B"; align:C;');
        $table->easyCell("", 'border: T,B,R; align:C;');
    
        $table->printRow();
        
	$table->endTable(0);

	$table = new easyTable($pdf, '%{30,20,30,20}', 'font-size: 8; ');
            
        $table->easyCell("NO. DE LICENCIA DE CONDUCIR", 'border: L,B; font-style:"B"; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("FECHA VENCIMIENTO DE LICENCIA", 'border: B; font-style:"B"; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
    
        $table->printRow();
        
	$table->endTable(0);

    $pdf->ln(1);

    
    $pdf->SetFont('Arial','', 7);
    $pdf->Cell(75, 4, utf8_decode("¿La presente inspección hace parte de la entrega del vehiculo?"), '0', '0', 'J');
    $pdf->Cell(4, 4, "SI", '0', '0', 'J');
    $pdf->Cell(5, 4, "", 'B', '0', 'J');
    $pdf->Cell(4, 4, "NO", '0', '0', 'J');
    $pdf->Cell(5, 4, "", 'B', '0', 'J');
    $pdf->Cell(99, 4, "", '', '1', 'J');

    $pdf->ln(1);

    /* --------------------------------------------------------------- */
    /* --------------------------------------------------------------- */
    /* --------------------------------------------------------------- */
    /* --------------------------------------------------------------- */

    $table = new easyTable($pdf, '{40,6,6,7,1,40,6,6,7,1,50,6,7,7}', 'font-size: 8.1; ');
            
        $table->easyCell("DOCUMENTOS", 'border: T,L,B,R; font-style:"B"; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("S", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("N", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("N/A", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("", 'align:C;');
        $table->easyCell("KIT DE CARRETERA", 'border: T,B,L,R; font-style:"B"; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("C", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("N", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("N/A", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("", 'align:C;');
        $table->easyCell(utf8_decode("BOTIQUÍN"), 'border: T,B,L,R; font-style:"B"; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("C", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("N", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("N/A", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
    
        $table->printRow();
        
	$table->endTable(0);

    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(40, 4,utf8_decode('Tarjeta de Propiedad'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 4,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Gato'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 4,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Gasas Estériles'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');


    $pdf->Cell(40, 4,utf8_decode('Tarjeta de Operación'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 4,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Cruceta'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 4,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Algodón'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');


    $pdf->Cell(40, 4,utf8_decode('SOAT'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 4,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Señales de Carretera'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 4,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Venda Elástica'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');


    $pdf->Cell(40, 4,utf8_decode('Polizas Extra y Contra'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Tacos (Para el tipo de Veh)'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Micropore'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');


    $pdf->Cell(40, 4,utf8_decode('Rev. Tecnomecánica'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Linterna (Con Pilas)'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Curas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');


    $pdf->Cell(40, 4,utf8_decode('Rev. Preventiva'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Llaves Fijas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Bajalenguas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->Cell(40, 4,utf8_decode('Extracto de Contrato (FUEC)'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Alicates'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Guantes de Latex'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');
    
    $pdf->Cell(40, 4,utf8_decode('GPS'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Llave Expansiva'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Aplicadores/ Copitos'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->Cell(40, 4,utf8_decode('Dispositivo de Velocidad'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Destornillador (Pa-Est-Mix)'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Alcohol'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->Cell(60, 4,utf8_decode(''),'0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Chaleco Reflectivo'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Suero Fisiologico'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->Cell(60, 4,utf8_decode(''),'0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Martillo(s) de Frag.'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Antiséptico'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->Cell(60, 4,utf8_decode(''),'0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Cuerda'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Tijeras Anti-trauma'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->Cell(60, 4,utf8_decode(''),'0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Guantes'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Extintor Cap (Lb)'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');
    
    $pdf->Cell(60, 4,utf8_decode(''),'0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Gafas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Cuello Ortopédico'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->ln(2);

    /* --------------------------------------------------------------- */
    /* --------------------------------------------------------------- */
    /* --------------------------------------------------------------- */
    /* --------------------------------------------------------------- */

    
    $table = new easyTable($pdf, '{40,6,7,7,1,40,6,7,7,1,50,6,7,7}', 'font-size: 8; ');
            
        $table->easyCell("ELEMENTOS DEL VEHICULO", 'border: T,L,B,R; font-style:"B"; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("C", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("NC", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("N/A", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("", 'align:C;');
        $table->easyCell("NIVELES DE FLUIDOS", 'border: T,L,B,R; font-style:"B"; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("C", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("NC", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("N/A", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("", 'align:C;');
        $table->easyCell(utf8_decode("DESGASTE DE LLANTAS"), 'border: T,B,L,R; font-style:"B"; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("C", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("N", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->easyCell("%", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF; align:C; ');
    
        $table->printRow();
        
	$table->endTable(0);

    $pdf->ln(1);

    $pdf->SetFont('Arial','', 8);

    $pdf->Cell(40, 4,utf8_decode('Freno de Mano'),'1','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(7, 4,'','T,B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Aceite Motor'),'1','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(7, 4,'','T,B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Llanta Delatera Derecha (LDD)'),'1','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(7, 4,'','T,B,R','0','C');
    $pdf->Cell(7, 4,'','T,B,R','1','C');
    
    $pdf->Cell(40, 4,utf8_decode('Cortinas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Hidraulico'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Llanta Delatera Izquierda (LDI)'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');
    
    $pdf->Cell(40, 4,utf8_decode('Cierre de Bodegas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Líquido de Frenos'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Llanta Trasera Delantera (LTD)'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');
    
    $pdf->Cell(40, 4,utf8_decode('Estado del Baño'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Refrigerante'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Llanta Trasera Izquierda (LTI)'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');
    
    $pdf->Cell(40, 4,utf8_decode('Televisor'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Agua de Parabrisas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(70, 4,utf8_decode(''),'0','1','C');

    $table = new easyTable($pdf, '{40,6,6,7,1,40,6,6,7,1,50,6,7,7}', 'font-size: 8; ');
            
        $table->easyCell("Pasa Manos", 'border: L,B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'align:C;');
        $table->easyCell("Nivel de Combustible", 'border: L,B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'align:C;');
        $table->easyCell(utf8_decode("VIDRIOS - ESPEJOS"), 'border: T,B,L,R; bgcolor: #274054; font-color: #FFF; align:C;');
        $table->easyCell("C", 'border: T,B,R; bgcolor: #274054; font-color: #FFF; align:C;');
        $table->easyCell("NC", 'border: T,B,R; bgcolor: #274054; font-color: #FFF; align:C;');
        $table->easyCell("N/A", 'border: T,B,R; bgcolor: #274054; font-color: #FFF; align:C;');
    
        $table->printRow();
        
	$table->endTable(0);

    
    $pdf->Cell(40, 4,utf8_decode('Pasa Manos'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Nivel de Combustible'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Panoramicos'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');
    
    $pdf->Cell(40, 4,utf8_decode('Estado Cojineria'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Fugas de Lubricantes'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Plumillas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->Cell(40, 4,utf8_decode('Estado de las sillas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Fugas de Agua'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('L/Parabrisas Trasero'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');
    
    $pdf->Cell(40, 4,utf8_decode('Estado de la Tapiceria'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Aseo del Vehículo'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Espejo Retrovisor'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->Cell(40, 4,utf8_decode('Manijas Puertas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode(''),'0','0','C');
    $pdf->Cell(6, 4,'','0','0','C');
    $pdf->Cell(6, 4,'','0','0','C');
    $pdf->Cell(7, 4,'','0','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Espejos Laterales'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->ln(1);

    $table = new easyTable($pdf, '{40,6,7,7,1,40,6,7,7,1,50,6,7,7}', 'font-size: 8; ');
            
        $table->easyCell("CARROCERIA", 'border: T,L,B,R; align:C; bgcolor: #274054; font-color: #FFF;');
        $table->easyCell("C", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF;');
        $table->easyCell("NC", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF;');
        $table->easyCell("N/A", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF;');
        $table->easyCell("", 'align:C;');
        $table->easyCell("LUCES", 'border: T,L,B,R; align:C; bgcolor: #274054; font-color: #FFF;');
        $table->easyCell("C", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF;');
        $table->easyCell("NC", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF;');
        $table->easyCell("N/A", 'border: T,B,R; align:C; bgcolor: #274054; font-color: #FFF;');
        $table->easyCell("", 'align:C;');
        $table->easyCell(utf8_decode("PROTOCOLO DE BIOSEGURIDAD"), 'border: T,B,L,R; bgcolor: #274054; font-color: #FFF; align:C;');
        $table->easyCell("C", 'border: T,B,R; bgcolor: #274054; font-color: #FFF; align:C;');
        $table->easyCell("N", 'border: T,B,R; bgcolor: #274054; font-color: #FFF; align:C;');
        $table->easyCell("N/A", 'border: T,B,R; bgcolor: #274054; font-color: #FFF; align:C;');
    
        $table->printRow();
        
	$table->endTable(0);

    $pdf->ln(1);
    
    $pdf->Cell(40, 4,utf8_decode('Chapas de Puertas'),'1','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(7, 4,'','T,B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Bajas'),'1','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(7, 4,'','T,B,R','0','C');
    $pdf->Cell(7, 4,'','T,B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Uso de Tapabocas'),'1','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(6, 4,'','T,B,R','0','C');
    $pdf->Cell(7, 4,'','T,B,R','1','C');

    
    $pdf->Cell(40, 4,utf8_decode('Seguros Puertas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Altas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Alcohol/Gel Antiséptico'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->Cell(40, 4,utf8_decode('Elevavidrios'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Direccionales'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Ventilación Natural'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->Cell(40, 4,utf8_decode('Ajuste de las Puertas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Cocuyos'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Desinfección Permanente'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->Cell(40, 4,utf8_decode('Bocina'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Pito Reversa'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Disposición de Residuos'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->Cell(40, 4,utf8_decode('Alarma Reversa'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Luces de Freno'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Señal uso de Tapabocas'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->Cell(40, 4,utf8_decode('Instrumentos'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Luces de Cabina'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(50, 4,utf8_decode('Señal prohibido consumo alimentos'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    
    $pdf->Cell(40, 4,utf8_decode('Cinturones S. Delanteros'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(40, 4,utf8_decode('Emergencia'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(130, 4, '','0','1','C');
    
    $table = new easyTable($pdf, '{40,6,6,7,1,40,6,7,7,1,49,6,7,7}', 'font-size: 8; ');
            
        $table->easyCell("Cinturones S. Traseros", 'border: L,B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'align:C;');
        $table->easyCell("Luces de Parqueo", 'border: L,B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'border: B,R; align:C;');
        $table->easyCell("", 'align:C;');
        $table->easyCell(utf8_decode("ELEMENTOS DE TRABAJO"), 'border: T,B,L,R; bgcolor: #274054; font-color: #FFF; align:C;');
        $table->easyCell("C", 'border: T,B,R; bgcolor: #274054; font-color: #FFF; align:C;');
        $table->easyCell("NC", 'border: T,B,R; bgcolor: #274054; font-color: #FFF; align:C;');
        $table->easyCell("N/A", 'border: T,B,R; bgcolor: #274054; font-color: #FFF; align:C;');
    
        $table->printRow();
        
	$table->endTable(0);

    $pdf->Cell(40, 4,utf8_decode('Mandos Eléctricos'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(61, 4, "",'0','0','C');
    $pdf->Cell(49, 4,utf8_decode('Aseo Personal - Uniforme'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->Cell(40, 4,utf8_decode('Tablero de Controles'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(61, 4, "",'0','0','C');
    $pdf->Cell(49, 4,utf8_decode('Sistema de Comunicación'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->Cell(40, 4,utf8_decode('Aire Acondicionado'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(61, 4, "",'0','0','C');
    $pdf->Cell(49, 4,utf8_decode('Rutero - Imantados'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->Cell(40, 4,utf8_decode('Bodegas y/o Baul'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(61, 4, "",'0','0','C');
    $pdf->Cell(49, 4,utf8_decode('Aseo Interno y externo Vehiculo.'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

    $pdf->Cell(40, 4,utf8_decode('Latoneria y Pintura'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(1, 5,'','0','0','C');
    $pdf->Cell(61, 4, "",'0','0','C');
    $pdf->Cell(49, 4,utf8_decode('Carpeta SST'),'L,B,R','0','C');
    $pdf->Cell(6, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','0','C');
    $pdf->Cell(7, 4,'','B,R','1','C');

	$pdf->AddPage();

	$pdf->SetFont('Arial','B', 8.5);
    $pdf->Cell(53, 20, $pdf->Image('../../Resources/img/kingvision_transparente.png',$pdf->GetX()+7, $pdf->GetY()+1, 40), 'L,T,R', '0', 'C');
    $pdf->Cell(82, 20, utf8_decode('INSPECCIÓN VEHICULAR'), 'T','0','C');
    $pdf->Cell(55, 20, '',1,'1','C');
    
	$pdf->SetFont('Arial','B', 7);
    $pdf->Cell(53, 5, "", 'L,R,B', '0', 'C');
    $pdf->Cell(82, 5, "CODIGO: 29092022032400 FKV-02", 1, '0', 'C');
	$pdf->SetFont('Arial','B', 7);
    $pdf->Cell(32, 5, utf8_decode("FECHA INSPECCIÓN:"), 'B', '0', 'C');
	$pdf->SetFont('Arial','', 8.5);
    $pdf->Cell(23, 5, utf8_decode("2022-09-29"), 'R,B', '1', 'J');
    $pdf->ln(10);


    $table = new easyTable($pdf, '{190}', 'font-size: 7; ');    
        $table->easyCell(utf8_decode("DESCRIPCIÓN DE DAÑOS OBSERVADOS - INSPECCIÓN EXTERNA"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
        $table->printRow();    
    $table->endTable(0);

    
    $pdf->ln(1);

    $table = new easyTable($pdf, '{94,1,95}', 'font-size: 7; ');    
        $table->easyCell(utf8_decode("VEHÍCULO (BUS)"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');     
        $table->easyCell("");     
        $table->easyCell(utf8_decode("VEHÍCULO (VAN - MICROBUSES)"),'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');     
        $table->printRow();    
    $table->endTable(0);

    $pdf->ln(1);
    
    $pdf->SetFont('Arial','B', 8.5);
    $pdf->Cell(94, 60, $pdf->Image('../../Resources/images/buses_inspeccion.PNG',$pdf->GetX()+8, $pdf->GetY()+1, 80), '1', '0', 'C');
    $pdf->Cell(1, 60,'','0','0','C');
    $pdf->Cell(95, 60, $pdf->Image('../../Resources/images/van_inspeccion.PNG',$pdf->GetX()+2, $pdf->GetY()+5, 90), '1', '1', 'C');

    $pdf->ln(1);

    $table = new easyTable($pdf, '{94,1,95}', 'font-size: 7; ');    
        $table->easyCell(utf8_decode("VEHÍCULO (4 X 4)"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');     
        $table->easyCell("");     
        $table->easyCell(utf8_decode("VEHÍCULO (DUSTER)"),'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');     
        $table->printRow();    
    $table->endTable(0);

    $pdf->ln(1);
    
    $pdf->SetFont('Arial','B', 8.5);
    $pdf->Cell(94, 60, $pdf->Image('../../Resources/images/4x4_inspeccion.PNG',$pdf->GetX()+17, $pdf->GetY()+2, 60), '1', '0', 'C');
    $pdf->Cell(1, 60,'','0','0','C');
    $pdf->Cell(94, 60, $pdf->Image('../../Resources/images/duster_inspeccion.PNG',$pdf->GetX()+8, $pdf->GetY()+2, 82), '1', '1', 'C');

    $pdf->ln(1);
    

	$pdf->SetFont('Arial','', 7);
	$table = new easyTable($pdf, '{190}', 'font-size: 7.5; ');
            
        $table->easyCell("NO SE ENCONTRO NOVEDADES EN EL REGISTRO", 'border: 1; align:C;');
    
        $table->printRow();
        
	$table->endTable(0);

    $pdf->ln(5);


    $table = new easyTable($pdf, '{190}', 'font-size: 7; ');    
        $table->easyCell(utf8_decode("OBSERVACIONES (DESCRIBIR CUALQUIER CONDICIÓN ANORMAL ENCONTRADA HASTA LA FECHA)"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
        $table->printRow();    
    $table->endTable(0);

    $pdf->ln(1);

	$pdf->SetFont('Arial','', 7);
	$table = new easyTable($pdf, '{190}', 'font-size: 7.5; ');
            
        $table->easyCell("NO SE ENCONTRARON OBSERVACIONES EN EL REGISTRO", 'border: 1; align:C;');
    
        $table->printRow();
        
	$table->endTable(0);

    $pdf->AddPage();

	$pdf->SetFont('Arial','B', 8.5);
    $pdf->Cell(53, 20, $pdf->Image('../../Resources/img/kingvision_transparente.png',$pdf->GetX()+7, $pdf->GetY()+1, 40), 'L,T,R', '0', 'C');
    $pdf->Cell(82, 20, utf8_decode('INSPECCIÓN VEHICULAR'), 'T','0','C');
    $pdf->Cell(55, 20, '',1,'1','C');
    
	$pdf->SetFont('Arial','B', 7);
    $pdf->Cell(53, 5, "", 'L,R,B', '0', 'C');
    $pdf->Cell(82, 5, "CODIGO: 29092022032400 FKV-02", 1, '0', 'C');
	$pdf->SetFont('Arial','B', 7);
    $pdf->Cell(32, 5, utf8_decode("FECHA INSPECCIÓN:"), 'B', '0', 'C');
	$pdf->SetFont('Arial','', 8.5);
    $pdf->Cell(23, 5, utf8_decode("2022-09-29"), 'R,B', '1', 'J');
    $pdf->ln(10);


    $table = new easyTable($pdf, '{190}', 'font-size: 7; ');    
        $table->easyCell("", 'bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->printRow();    
    $table->endTable(0);

    $pdf->ln(1);

    $pdf->SetFont('Arial','', 7);
    $pdf->Cell(68, 4, "REVISADO POR", 'L,T,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "CARGO", 'L,T,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "FIRMA", 'L,T,R', '1', 'C');

    $pdf->Cell(68, 4, "", 'L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'L,R', '1', 'C');

    $pdf->Cell(68, 4, "", 'L,R,B', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'L,R,B', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'L,R,B', '1', 'C');

    $pdf->ln(1);

    $table = new easyTable($pdf, '{190}', 'font-size: 7; ');    
        $table->easyCell(utf8_decode("Nota: Espacio para diligenciar en entrega del vehículo"), 'bgcolor: #274054; font-color: #FFF;');
        $table->printRow();    
    $table->endTable(0);

    $pdf->ln(1);

    $pdf->SetFont('Arial','', 7);
    $pdf->Cell(68, 4, "ENTREGA A: ", 'L,T,R', '0', 'J');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "FIRMA", 'L,T,R', '0', 'J');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'L,T,R', '1', 'C');

    $pdf->Cell(68, 4, "", 'L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, utf8_decode("Doy fe que se ha realizado la inspección de"), 'L,R', '1', 'C');

    $pdf->Cell(68, 4, "", 'L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, utf8_decode("entrega del vehículo y conforme a lo descrito"), 'L,R', '1', 'C');

    $pdf->Cell(68, 4, "RECIBE DE: ", 'L,T,R', '0', 'J');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "FIRMA", 'L,T,R', '0', 'J');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, utf8_decode("recibo a conformidad."), 'L,R', '1', 'C');
    
    $pdf->Cell(68, 4, "", 'L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'L,R', '1', 'C');

    $pdf->Cell(68, 4, "", 'B,L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'B,L,R', '0', 'C');
    $pdf->Cell(1, 4, "",'0','0','C');
    $pdf->Cell(60, 4, "", 'B,L,R', '1', 'C');

    $pdf->ln(1);
    
    $pdf->SetFont('Arial','', 7);
    $pdf->Cell(190, 4, "OBSERVACIONES", 'T,L,R', '1', 'J');

	$table = new easyTable($pdf, '{190}', 'font-size: 7.5; ');
            
        $table->easyCell("No se encontraron observaciones en los registros", 'border: L,B,R; align:JL;');
    
        $table->printRow();
        
	$table->endTable(0);

    $pdf->ln(1);

    $table = new easyTable($pdf, '{190}', 'font-size: 7; ');    
        $table->easyCell("", 'bgcolor: #274054; font-color: #FFF; align:C; ');
        $table->printRow();    
    $table->endTable(0);


    $pdf->Output();

?>