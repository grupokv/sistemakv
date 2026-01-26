<?php

	ob_start();

	require('../../Resources/fuec/fpdf.php');
	require('../../Resources/fpdf-easytable-master/exfpdf.php');
	require('../../Resources/fpdf-easytable-master/easyTable.php');
	require('../../Modelo/contratoOcasional.php');
	require('../../Modelo/UsuarioContratoOcasional.php');
	require('../../Modelo/Cliente.php');
	require('../../Modelo/Vehiculo.php');
	require('../../Modelo/EmpresaEnt.php');
	require('../../Modelo/Fuec.php');
	require('../../Modelo/Ciudad.php');
	require('../../Modelo/TipoVehiculo.php');
	require('../../Modelo/Conductor.php');


	$id_fuec_contrato_ocasional = base64_decode($_GET['id']);
	$id_contrato_ocasional = $id_fuec_contrato_ocasional;

	/*CONTRATO*/
	$contratoOcasional = new ContratoOcasional();
	$listarContratoPorId = $contratoOcasional->listarPorId($id_contrato_ocasional);
    
	/*USUARIOS CONTRATOS OCASIONALES*/
	$usuarioContratoOcasional = new UsuarioContratoOcasional();
	$listarUsuariosPorContrato = $usuarioContratoOcasional->listarUsuariosPorContrato($id_contrato_ocasional);

	/*EMPRESA*/
	$empresa = new Empresa();
	$empresaid = $empresa->listarPorId($listarContratoPorId[0]['id_empresa']);
	$logo = $empresaid[0]['logo'];
	$mintransporte = "../../Resources/fpdf/img/logo-mintransporte.png";
	$ort = "../../Resources/fpdf/img/".$logo; 

	/*CLIENTE*/
	$cliente = new Cliente();
	$clienteid = $cliente->cliente_ID($listarContratoPorId[0]['id_cliente']);

	/*FUEC*/
	$fuec = new Fuec();
	$listarFuecPorId = $fuec->listarFuecPorIdContratoOcasional($id_contrato_ocasional);
	$aprobacion = $fuec->Aprobacion($listarContratoPorId[0]['id_empresa']);

	/*CIUDAD*/
	$ciudad = new Ciudad();
	$listarCiudadOrigen = $ciudad->listarCiudadPorId($listarContratoPorId[0]['origen']);
	$listarCiudadDestino = $ciudad->listarCiudadPorId($listarContratoPorId[0]['destino']);

	/*VEHICULO*/
	$vehiculo = new Vehiculo();
	$listarVehiculoPorId = $vehiculo->listarPorId($listarFuecPorId[0]['id_vehiculo']);
	$listarConductoresPorIdVehiculo = $vehiculo->listarConductoresPorId($listarFuecPorId[0]['id_vehiculo']);

	/*TIPO VEHICULO*/
	$tipoVehiculo = new TipoVehiculo();
	$listarTipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']);


	/*CONDUCTORES*/
	$conductor = new Conductor();


	class PDF extends exFPDF{

	    function  Header(){

			$id_fuec_contrato_ocasional = $_GET['id'];
			$id_contrato_ocasional = base64_decode($id_fuec_contrato_ocasional);
	        $contratoOcasional = new ContratoOcasional();
			$listarContratoPorId = $contratoOcasional->listarPorId($id_contrato_ocasional);
	        $empresa = new Empresa();
			$empresaid = $empresa->listarPorId($listarContratoPorId[0]['id_empresa']);
			$logo = $empresaid[0]['logo'];

		    $this->Image('../../Resources/fuec/img/logo-vigilado-supertransporte.png',20,5,60);
			$this->SetFont('Arial','B',11);
			$this->Cell(0,20,'',0,1,'C');
			$this->Cell(120,30,$this->Image('../../Resources/fpdf/img/logo-mintransporte.png', $this->GetX()+5, $this->GetY()+10, 80),0,0,'C');
			
            if($listarContratoPorId[0]['id_empresa'] == 16){
                $this->Cell(70,30,$this->Image("../../Resources/fpdf/img/".$logo, $this->GetX()+12, $this->GetY()+1, 30),0,1,'C');
            }else{
                $this->Cell(70,30,$this->Image("../../Resources/fpdf/img/".$logo, $this->GetX()+12, $this->GetY()+1, 35),0,1,'C');
            }

		    $this->Ln(0);

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

	$pdf->SetFont('Arial','B',9);

	$pdf->Cell(0,1,'',0,'1','C');

	$pdf->Cell(0,5,'FORMATO UNICO DE EXTRACTO DEL CONTRATO DEL SERVICIO PUBLICO',0,'1','C');

	$pdf->Cell(0,5,'DE TRANSPORTE TERRESTRE AUTOMOTOR ESPECIAL',0,'1','C');

	$pdf->Cell(0,5,'No. '. $listarFuecPorId[0]['num_comprobante'],0,'1','C');

	$pdf->Cell(0,5,'',0,'1','C');



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(87,4,utf8_decode('RAZÓN SOCIAL DE LA EMPRESA DE TRANSPORTE ESPECIAL: '),0,0,'L');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(103,4,utf8_decode($empresaid[0]['nombre_empresa']),0,1,'L');


	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(24,4,'NIT:',0,0,'');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(166,4,$empresaid[0]['nit_empresa'],0,1,'L');


    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(24,4, utf8_decode('ID FUEC:'),0,0,'L');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(166,4, $listarFuecPorId[0]['id_fuec'],0,1,'L');


	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(24,4,'CONTRATO No:',0,0,'L');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(166,4, str_pad($listarContratoPorId[0]['id_contrato_ocasional'], 4, "0", STR_PAD_LEFT),0,1,'L');



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(24,5,'CONTRATANTE:',0,0,'L');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(166,5,utf8_decode($clienteid[0]['razon_social']),0,1,'L');





	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(24,4,'NIT/CC:',0,0,'');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(166,4,$clienteid[0]['nit_cliente'],0,1,'L');



	$table = new easyTable($pdf, '%{19,81}', 'font-size: 8; font-family:Arial;');

            $table->easyCell('OBJETO CONTRATO:', 'font-style:B;');

            $table->easyCell(utf8_decode($listarContratoPorId[0]['objeto_contrato'] ));



            $table->printRow();

    $table->endTable(0);



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(35,5,'ORIGEN - DESTINO:',0,0,'L');

	$pdf->SetFont('Arial','',8);
	if($listarCiudadOrigen[0]['ciudad'] != $listarCiudadDestino[0]['ciudad']){
	$pdf->Cell(155,5, utf8_decode($listarCiudadOrigen[0]['ciudad']) .' - '. utf8_decode($listarFuecPorId[0]['destino'].' Y VICEVERSA'),0,1,'L');
	} else {
	$pdf->Cell(155,5, utf8_decode($listarCiudadOrigen[0]['ciudad']) .' - '. utf8_decode($listarCiudadDestino[0]['destino'] .' Y VICEVERSA'),0,1,'L');
	}



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(46,5,utf8_decode('CONVENIO DE COLABORACIÓN:'),0,0,'L');

	$pdf->Cell(134,5,$listarFuecPorId[0]['con_fuec'],0,1,'L');





	/*VIGENCIA DEL CONTRATO*/

	$pdf->SetFont('Arial','B',10);

	$pdf->Cell(0,1,'',0,'1','C');

	$pdf->Cell(0,5,'VIGENCIA DEL CONTRATO',0,'1','C');

	$pdf->Cell(0,2,'',0,'1','C');



	$fechaInicialContrato = explode("-", $listarContratoPorId[0]['fecha_inicial_contrato_ocasional']);



	$anioinicio = $fechaInicialContrato[0];

	$mesinicio = $fechaInicialContrato[1];

	$diainicio = $fechaInicialContrato[2];



	$fechaFinalContrato = explode("-", $listarContratoPorId[0]['fecha_final_contrato_ocasional']);



	$aniofinal = $fechaFinalContrato[0];

	$mesfinal = $fechaFinalContrato[1];

	$diafinal = $fechaFinalContrato[2];





	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(55,5,'FECHA INICIAL','L B T',0,'L');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(45,5,$diainicio,'L B T',0,'C');

	$pdf->Cell(45,5,$mesinicio,'L B T',0,'C');

	$pdf->Cell(45,5,$anioinicio,'L B R T',1,'C');



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(55,5,'FECHA VENCIMIENTO','L B',0,'L');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(45,5,$diafinal,'L B',0,'C');

	$pdf->Cell(45,5,$mesfinal,'L B',0,'C');

	$pdf->Cell(45,5,$aniofinal,'L B R',1,'C');



	$pdf->SetFont('Arial','B',10);

	$pdf->Cell(0,3,'',0,'1','C');

	$pdf->Cell(0,5, utf8_decode('CARACTERISTICAS DEL VEHÍCULO'),0,'1','C');

	$pdf->Cell(0,3,'',0,'1','C');



	$pdf->SetFont('Arial','B',9);

	$pdf->Cell(25,5,'PLACA','L B T' ,0,'C');

	$pdf->Cell(25,5,'MODELO','L B T',0,'C');

	$pdf->Cell(70,5,'MARCA','L B T',0,'C');

	$pdf->Cell(70,5,'CLASE','L B R T',1,'C');



	$pdf->SetFont('Arial','',8);

	$pdf->Cell(25,5,$listarVehiculoPorId[0]['placa'],'L B',0,'C');

	$pdf->Cell(25,5,$listarVehiculoPorId[0]['modelo'],'L B',0,'C');

	$pdf->Cell(70,5,$listarVehiculoPorId[0]['marca'],'L B',0,'C');

	$pdf->Cell(70,5,$listarTipoVehiculoPorId[0]['nombre_tipo_vehiculo'],'L B R',1,'C');



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(50,5,'NUMERO INTERNO','L B',0,'C');

	$pdf->Cell(140,5,'NUMERO DE TARJETA DE OPERACION','L B R',1,'C');



	$pdf->SetFont('Arial','',9);

	$pdf->Cell(50,5,$listarVehiculoPorId[0]['numero_movil'],'L B',0,'C');

	$pdf->Cell(140,5,$listarVehiculoPorId[0]['num_tarjeta_operacion'],'L B R',1,'C');



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(25,5,'','L B',0,'C');

	$pdf->Cell(80,5,'NOMBRES Y APELLIDOS','L B',0,'C');

	$pdf->Cell(30,5,'No. CEDULA','L B',0,'C');

	$pdf->Cell(30,5,'LICENCIA','L B',0,'C');

	$pdf->Cell(25,5,'VIGENCIA','L B R',1,'C');



	$cant = count($listarConductoresPorIdVehiculo);

	$restante = 4 - $cant;



	if($cant > 0){

	    $i = 1;

		foreach($listarConductoresPorIdVehiculo as $cond){

		$listarConductorPorId = $conductor->listarPorId($cond['id_conductor']);

		$fechaven = date('d/m/Y',strtotime($listarConductorPorId[0]['fecha_vencimiento_licencia']));



		$pdf->SetFont('Arial','B',8);

		$pdf->Cell(25,5,'CONDUCTOR '.$i,'L B',0,'C');

		$pdf->SetFont('Arial','',8);

		$pdf->Cell(80,5,utf8_decode($listarConductorPorId[0]['nombre_conductor']),'L B',0,'C');

		$pdf->Cell(30,5,$listarConductorPorId[0]['numero_documento_conductor'],'L B',0,'C');

		$pdf->Cell(30,5,$listarConductorPorId[0]['num_licencia'],'L B',0,'C');

		$pdf->Cell(25,5,$fechaven,'L B R',1,'C');



		$i++;

		}

	}



	while($restante > 0){

		$pdf->SetFont('Arial','B',9);

		$pdf->Cell(25,5,'','L B',0,'C');

		$pdf->SetFont('Arial','',9);

		$pdf->Cell(80,5,'','L B',0,'C');

		$pdf->Cell(30,5,'','L B',0,'C');

		$pdf->Cell(30,5,'','L B',0,'C');

		$pdf->Cell(25,5,'','L B R',1,'C');

		$restante--;

	}





	$pdf->SetFont('Arial','B',10);

	$pdf->Cell(0,1,'','R L','1','C');

	$pdf->Cell(0,5,'RESPONSABLE CONTRATANTE','R L','1','C');

	$pdf->Cell(0,1,'','R L B','1','C');



	$table = new easyTable($pdf, '%{19,81}', 'font-size: 8; font-family:Arial;');





	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(20,5,'NOMBRE','B L',0,'L');

	if(strlen($listarFuecPorId[0]['responsable']) <= 45){

	$pdf->SetFont('Arial','',8);

	} else {

	$pdf->SetFont('Arial','',6);

	}

	$pdf->Cell(100,5,utf8_decode($listarFuecPorId[0]['responsable']),'B R',0,'L');

	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(20,5, utf8_decode('N° CEDULA'),'B',0,'');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(50,5,$listarFuecPorId[0]['idResponsable'],'B R',1,'L');



	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(20,5, utf8_decode('DIRECCIÓN'),'B L',0,'L');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(100,5,utf8_decode($listarFuecPorId[0]['dirResponsable']),'B R',0,'L');

	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(20,5,'TELEFONO','B',0,'');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(50,5,$listarFuecPorId[0]['telResponsable'],'B R',1,'L');



	$pdf->SetXY(10,224);

	$pdf->SetFont('Arial','B',8);

	$pdf->Cell(90,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');

	$pdf->Cell(90,4,'glpgerencia@ortsas.com','L R ',1,'C');

	$pdf->Cell(90,4,'Bogota - Colombia','L R ',1,'C');

	$codigo = $listarFuecPorId[0]['num_comprobante'];

	$codigo1 = $listarFuecPorId[0]['num_interno'];


	$qr = '../../Resources/fuec/phpqrcode/codigos/'.$codigo.'.png';
	$code39 = '../../Resources/fuec/phpbarcode39/codigos/'.$codigo1.'.gif';
	$sello = '../../Resources/fuec/img/'.$aprobacion[0]['firma_fuec'];

	$pdf->Cell(90,20,$pdf->Image($code39,$pdf->GetX()+4, $pdf->GetY()+1, 80),'B L R',1,'C');


	$pdf->SetXY(100,224);
	$pdf->Cell(30,33,$pdf->Image($qr,$pdf->GetX()+1, $pdf->GetY()+4, 28),'B R T',0,'C');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(70,5,'REPRESENTANTE LEGAL O GERENTE','R T',1,'C');
	$pdf->SetXY(130,229);
	$pdf->Cell(70,23,$pdf->Image($sello,$pdf->GetX()+8, $pdf->GetY()+3, 50),'R',1,'C');
	$pdf->SetXY(130,252);
	$pdf->Cell(2,5,'','B',0,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(66,5,'FIRMA Y SELLO','B T',0,'C');
	$pdf->Cell(2,5,'','B R',1,'C');


	$pdf->SetFont('Arial','B',9);

	$pdf->Cell(0,3,'',0,1,'C');

	$pdf->Cell(0,4,utf8_decode('* Se expide el presente FUEC, en cumplimiento de los requisitos establecidos en el artículo 8 de la Resolución 1069 de 2015,'),0,1,'L');

	$pdf->Cell(0,4,utf8_decode('la Ley 527 de 1999 y el Decreto 2364 de 2012.'),0,1,'L');



	

	$pdf->AddPage();

	/*X-Y--TAMAÑO*/

	$pdf->Image('../../Resources/fuec/img/SKMBT_22319123016050_002.png',0,0,210);



	/*USUARIOS ANEXO OCASIONALES*/


	if (count($listarUsuariosPorContrato) > 0) {

		$pdf->AddPage();

		$pdf->Cell(190, 15,'', 0,'1','C');
		$pdf->Cell(190, 5, utf8_decode('ANEXO SERVICIO DE TRANSPORTE ESPECIAL DE PASAJEROS CON GRUPO ESPECÍFICO DE USUARIOS'), 0,'1','C');
		$pdf->Cell(190, 5, utf8_decode('FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
		$pdf->Cell(190, 15,'', 0,'1','C');
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(95, 5,'NOMBRE USUARIO', 0,'0','C');
		$pdf->Cell(95, 7,utf8_decode('DOCUMENTO DE IDENTIFICACIÓN'), 0,'1','C');
		$pdf->Cell(190, 3,'', 0,'1','C');

		$cant = count($listarUsuariosPorContrato);
		$restante = 23 - $cant;

		$pdf->SetFont('Arial','',7);

		if($cant > 0){

		    $i = 1;

			foreach($listarUsuariosPorContrato as $luco){

				$pdf->Cell(95,5, utf8_decode(strtr(strtoupper($luco['nombre_usuario']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")), 0,0,'C');
				$pdf->Cell(95,5,$luco['numero_documento'], 0,1,'C');
				$i++;

			}

		}

		while($restante > 0){
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(190, 5, "", 0,'1','C');

			$restante--;
		}

	}

	/* ANEXOS RUTAS OCASIONALES*/

	if(($listarFuecPorId[0]['id_contrato_ocasional'] == 878)or($listarFuecPorId[0]['id_contrato_ocasional'] == 1039)){

		$pdf->AddPage();

	    $pdf->Cell(190, 15,'', 0,'1','C');
	    $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
	    $pdf->Cell(190, 15,'', 0,'1','C');
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira - Cajica y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira - Chia y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira - Tabio y Viceversa'), 'R,L','1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira - Cota y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira - Siberia y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira - Guaymaral y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '7', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira - Sopo y Viceversa'), 1,'1','F');


        $pdf->SetXY(10,235);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    }if(($listarFuecPorId[0]['id_contrato_ocasional'] == 3315) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 3478)){

		$pdf->AddPage();

	    $pdf->Cell(190, 15,'', 0,'1','C');
	    $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
	    $pdf->Cell(190, 15,'', 0,'1','C');
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Zipaquirá, Tunja, Paipa, Sogamoso, Villa de Leyva, Chiquinquirá, Barichara, Bucaramanga.'), 1,'1','F');


        $pdf->SetXY(10,235);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    } else if($listarFuecPorId[0]['id_contrato_ocasional'] == 1130){

		$pdf->AddPage();

	    $pdf->Cell(190, 15,'', 0,'1','C');
	    $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
	    $pdf->Cell(190, 15,'', 0,'1','C');
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota - Sopo y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota - La Calera y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota - Guatavita y Viceversa'), 'R,L','1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota - Chia y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota - Zipaquira y Viceversa'), 1,'1','F');

        $pdf->SetXY(10,235);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    } else if($listarFuecPorId[0]['id_contrato_ocasional'] == 3502){

		$pdf->AddPage();

	    $pdf->Cell(190, 15,'', 0,'1','C');
	    $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
	    $pdf->Cell(190, 15,'', 0,'1','C');
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Villavicencio - Acacias - Restrepo y Viceversa'), 1,'1','F');

        $pdf->SetXY(10,235);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    }else if($listarFuecPorId[0]['id_contrato_ocasional'] == 2646){

		$pdf->AddPage();

	    $pdf->Cell(190, 15,'', 0,'1','C');
	    $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
	    $pdf->Cell(190, 15,'', 0,'1','C');
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Traslados en Bogotá y Aeropuerto'), 1,'1','F');
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, La calera, Guasca, Tomine y Viceversa.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Mosquera, Tena La Gran Via, La Mesa, Anapoima y Viceversa.'), 'R,L','1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Autopista Norte, Chia, Tocancipa, Sesquile y Viceversa.'), 1,'1','F');

        $pdf->SetXY(10,235);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');    

    }else if($listarFuecPorId[0]['id_contrato_ocasional'] == 1181){

		$pdf->AddPage();

	    $pdf->Cell(190, 15,'', 0,'1','C');
	    $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
	    $pdf->Cell(190, 15,'', 0,'1','C');
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('SINCELEJO - YALI'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('SINCELEJO - MEDELLIN'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('SINCELEJO - BOGOTÁ'), 'R,L','1','F');

        $pdf->SetXY(10,235);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    
    } else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 1294) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1295) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1296) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1298) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1300) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1301) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1304) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1305) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1309) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1308) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1311) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1315) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1316) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1317) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1318) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1319) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1320)){

		$pdf->AddPage();

	    $pdf->Cell(190, 15,'', 0,'1','C');
	    $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
	    $pdf->Cell(190, 15,'', 0,'1','C');
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTÁ - SIBATÉ'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTÁ - MADRID'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTÁ - CHÍA'), 'R,L','1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTÁ - CAJICÁ'), 'R,L','1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTÁ - LA CALERA'), 'R,L','1','F');

        $pdf->SetXY(10,235);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    } else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 947) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 1006)){

    	

        $pdf->AddPage();



        $pdf->SetFont('Arial','B',8);

	    $pdf->Cell(190, 15,'', 0,'1','C');

	    $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');

	    $pdf->Cell(190, 15,'', 0,'1','C');



        $pdf->Cell(7, 5, '', 1,'0','C');

        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');



        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ - AEROPUERTO MONTERIA'), 1,'1','F');

        $pdf->Cell(7, 5, '2', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ - QUIMBAYA'), 1,'1','F');

        $pdf->Cell(7, 5, '3', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - AEROPUERTO LAS BRUJAS COROZAL'), 1,'1','F');

        $pdf->Cell(7, 5, '4', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - MOMPOX'), 1,'1','F');

        $pdf->Cell(7, 5, '5', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - VALLEDUPAR'), 1,'1','F');

        $pdf->Cell(7, 5, '6', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - BARICHARA'), 1,'1','F');

        $pdf->Cell(7, 5, '6', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - CARTAGENA'), 1,'1','F');

        $pdf->Cell(7, 5, '6', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - BARRANQUILLA'), 1,'1','F');

        $pdf->Cell(7, 5, '6', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - SANTA MARTA'), 1,'1','F');

        $pdf->Cell(7, 5, '6', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - RIOHACHA'), 1,'1','F');

        $pdf->Cell(7, 5, '6', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - CABO DE LA VELA'), 1,'1','F');

        $pdf->Cell(7, 5, '6', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - ARBOLETES'), 1,'1','F');

        $pdf->Cell(7, 5, '6', 1,'0','C');

        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - SANTA FÉ DE ANTIOQUIA'), 1,'1','F');



        $pdf->SetXY(10,235);

        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');

        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');

        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');

        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');



        $pdf->SetXY(120,235);

        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');

        $pdf->SetXY(120,240);

        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');

        $pdf->SetXY(120,263);

        $pdf->Cell(2,5,'','B',0,'C');

        $pdf->SetFont('Arial','',8);

        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');

        $pdf->Cell(2,5,'','B R',1,'C');

    } else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 1609)){

    	

        $pdf->AddPage();



        $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
    $pdf->Cell(7, 5, '1', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Chia, Cajica, Tenjo, Tabio, Zipaquirá, Nemocón, Suesca, Sopo, Aposentos, Neusa, Siecha, Guasca, Guatavita.'), 1,'1','F');
    $pdf->Cell(7, 5, '5', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Tocancipa, Gachancipa, Chochontá, Villapinzon, Turmequé, Ramiriqui, Samaca, Sachica, Villa de Leyva, Soraca,'), 'T,R,L','1','F');
    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Tunja, Combita, Tuta, Sotaquira, Paipa, Duitama, Nobsa, Sogamoso, Mongui, Mongua '), 'B,R,L','1','F');

    $pdf->Cell(7, 5, '3', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Bogotá, La Calera, Santa Isabel, Siecha, Guasca, Meusa, Sopo, Tocancipa, Aposentos, Chia.'), 1,'1','F');
    $pdf->Cell(7, 5, '4', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Cajica, Zipaquirá, Chochota, Tunja, Duitama, Cerinza, Susacon, Soata, Boavita, Uvita, Guacamayas, San Ignacio, El cocuy, Guican'), 1,'1','F');
    $pdf->Cell(7, 5, '6', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Tocancipa, Gachancipa, Chocontá, Sesquile, Puente de Boyacá, Tunja, Villa de Leyva.'), 1,'1','F');

    
    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA SUR', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Sur, Soacha, Viota, Granada, Silvania, Fusagasuga, Melgar, Girardot, Mosquera, Madrid, Facatativa, La gran via, La mesa,'), 'T,R,L','1','F');
    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Mesitas el colegio, Anapoima, Apulo, Tocaima, Agua de Dios, Nilo, Ricaurte, Espinal, Guamo, Saldaña, Purificación, Murillo, Natagaima, '), 'R,L','1','F');
    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('La Yeguera, Guacirco, Forcalacillas, Buziraco, Neiva.'), 'B,R,L','1','F');



    $pdf->Cell(7, 5, '2', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Calle 13, Tres Esquinas, Funza, Mosquera, Madrid, Bojaca, Facatativa, Zipacon, Cachipay, El Ocaso, La Esperanza, La Gran Via, La Mesa.'), 1,'1','F');
    $pdf->Cell(7, 5, '3', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Sur, Mondoñedo, Gran Via, El Triunfo, La Mesa, Mesitas del Colegio.'), 1,'1','F');
    
    $pdf->Cell(7, 5, '4', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Soacha, Fusagasuga, Melgar, Girardot, Espinal, Ibagué, Coello Cocora, Cajamarca, Calarca, Armenia, Circasia, Salento, Montenegro, El Meson,'), 'T,R,L','1','F');
    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Parque del café, La Tebaida, Panaca, Pueblo Tapado, Parque los Arrieros, La Paila, Bugalagrande, Andalucia, Tulua, Buga, Guacari,'), 'R,L','1','F');
    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('El Cerrito, Palmira, Yumbo, Cali.'), 'B,R,L','1','F');


    $pdf->Cell(7, 5, '5', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Soacha, Fusagasuga, Melgar, Girardot, Ibagué, Armenia, Circasia, Salento, El Manzano, La Ye, Huertas, Pereira, Dos Quebradas, La Unión, '), 'T,R,L','1','F');
    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Renacimiento, Santa Rosa de Cabal, Termales de Santa Rosa de Cabal.'), 'B,R,L','1','F');
    $pdf->Cell(7, 5, '6', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Usme, Chipaque, Puente Quetame, Guayabetal, Pirapal, Villavicencio, Restrepo, Acacias, Granada, Fuente de oro, Puerto Lopez.'), 1,'1','F');

    
    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
    $pdf->Cell(7, 5, '1', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Sobachoque, El Rosal, Alto del Vino, San Francisco, La Vega, Utica, Villeta.'), 1,'1','F');
    $pdf->Cell(7, 5, '2', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Cota, Chia, Cajica, Zipaquira. '), 1,'1','F');
    $pdf->Cell(7, 5, '3', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Calle 80, Madrid, San Franciso, La Vega, Villeta, Guaduas, Cachipai, Puerto Vargas, La Dorada, El Guamo, Puerto Boyaca, '), 'T,R,L','1','F');

    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Puerto Nare, Garrapata, Puerto Araujo, Dagota, Villa Nueva Lebrija, Bucaramanga, Rio Negro, El Playón.'), 'R,L','1','F');

    $pdf->Cell(7, 5, '4', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Cajica, Sopo, Tocancipa, El Sisga, Choconta, Villa Pinzon, Ventaquemada, Tunja, Arcabuco, Socorro, San Gil, Curiti, Aratoca, Piedecuesta,'), 'T,R,L','1','F');

    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('La Parcela, Florida Blanca, Bucaramanga, Aguachica, Pailitas San Alberto, Urumita, Barrancas Albania, La Guajira, Maicao, Riohacha.'), 'R,L','1','F');



    $pdf->Cell(7, 5, '5', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Calle 80, Siberia, Mosquera, La Mesa, Tocaima, Anapoima, Girardot, Flandes, Gualanday, Ibagué.'), 1,'1','F');


    
    $pdf->SetFont('Arial','B',8);
	
	
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');
   

    $pdf->addPage();

     $pdf->Cell(0, 15, utf8_decode(''), 0,'1','F');


    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
    $pdf->Cell(7, 5, '1', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Villeta, Guaduas, Honda, La Dorada, Puerto Boyaca, Puerto Araujo, Yarima, Barrancabermeja, San Alberto, San Martin, Los Angeles,'), 'R,L','1','F');

    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Aguachica, Pailita, San Roque, La Aurora, La Loma, Cuatro Vientos La Esperanza, Bosconia, El Copel, San Tomas Tucuringa, Guamachito,'), 'R,L','1','F');

    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('La Isabel, Gaira, Rodadero, Playa Blanca, Santa Marta, Taganga, Bahia Concha, Gairaca.'), 'R,L','1','F');

    $pdf->Cell(7, 5, '2', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Madrid, Villeta, Guaduas, La Dorada, Doradal, Rio Negro, Envigado, Guatape, Pueblito Paisa, San Rafael, San Carlos, Santa Rosa de Osos,'), 'T,R,L','1','F');

    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Yarumal, Valdivia, Monte libano, Alto Genoba, Monteria, San Pelayo, San Pues, Lorica, Sincelejo, Santiago de Tolú, San Onofre,'), 'R,L','1','F');

    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Carmen de Bolivar, San Juan, Nepomuceno, Arjona, Turbaco, Cartagena, La Boquilla, Clemencia, Luruaco, Sabana Larga, Calamar, Barranquilla,'), 'R,L','1','F');

    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Cienaga, Gaira, Minca, Buritacá, Palomino, Dibulla, Camarones, Riohacha'), 'B,R,L','1','F');


    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA ORIENTE', 1,'1','F');
    $pdf->Cell(7, 5, '1', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Patios, La Calera, Guasca, Guatavita, Sesquile.'), 1,'1','F');
    $pdf->Cell(7, 5, '2', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Avenida Circunvalar, Monserrate, Choachi, Ubaque, Fomeque'), 1,'1','F');
    $pdf->Cell(7, 5, '3', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Briceño, Sopo, Guasca, Guatavita, Sesquile.'), 1,'1','F');

    $pdf->Cell(110, 2, '', 'L,R','0','F');
    $pdf->Cell(80, 2, '', 'R','1','F');

    
    $pdf->SetFont('Arial','B',8);

    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,137);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R',1,'C');
    $pdf->SetXY(120,142);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,165);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

    } else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 1854)){

    	

        $pdf->AddPage();



        $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('Armenia, Calarca, Pereira y Santa Rosa de Cabal (Viceversa)'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

    } else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 2205)){

    	

        $pdf->AddPage();



        $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('Bogotá, Restrepo, Acacias y Villavicencio (Viceversa)'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');
    } else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 3697)){  	

        $pdf->AddPage();
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Ibagué - Bogotá.'), 'T,R,L,B','1','F');
        $pdf->Ln(1);
        $pdf->Cell(183, 5, utf8_decode('Ibagué - Melgar.'), 'T,R,L,B','1','F');
        $pdf->Ln(1);
        $pdf->Cell(183, 5, utf8_decode('Ibagué - Cajamarca.'), 'T,R,L,B','1','F');
        $pdf->Ln(1);
        $pdf->Cell(183, 5, utf8_decode('Ibagué - Castilla.'), 'T,R,L,B','1','F');
        $pdf->Ln(1);
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Ibagué.'), 'T,R,L,B','1','F');

        
        $pdf->SetFont('Arial','B',8);
        
        $pdf->SetXY(10,200);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,200);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
        $pdf->SetXY(120,205);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,228);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    } else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 1927)){

    	

        $pdf->AddPage();



        $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('Armenia, Calarca y Cajamarca (Viceversa)'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

    } else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 2257) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 2372) || ($listarFuecPorId[0]['id_contrato_ocasional'] == 2441)){

    $pdf->AddPage();

    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('Sesquilé, Nemocón, Cogua, Zipaquirá, Briceño, Bogotá y (Viceversa)'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

 } else if($listarFuecPorId[0]['id_contrato_ocasional'] == 2446){

    $pdf->AddPage();

    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('Bogotá, La vega, Villeta, Honda, Mariquita, Puerto Salgar, La dorada'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

 } else if($listarFuecPorId[0]['id_contrato_ocasional'] == 3619){

    $pdf->AddPage();

    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('Cota, Chía, Cajicá, Tabio, Tenjo, Zipaquirá, Briceño, Sopo.'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

 } else if($listarFuecPorId[0]['id_contrato_ocasional'] == 2542){

    $pdf->AddPage();

    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('Bogotá, Cota, Chía, Sopo.'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

 } else if($listarFuecPorId[0]['id_contrato_ocasional'] == 2634){

    $pdf->AddPage();

    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('Líbano, Girardot, Nilo, Melgar.'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

    } else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 2099)){

    	

        $pdf->AddPage();



        $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('BOGOTA - GRANADA - SAN JUAN DE ARAMA'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

} else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 2490)){

    	

    $pdf->AddPage();
    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('BOGOTA - ZIPAQUIRÁ - BRICEÑO'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');
    
} else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 2495)){

    	

    $pdf->AddPage();
    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('BOGOTA, SOACHA, FUNZA, MOSQUERA, COTA, CHIA.'), 'T,R,L,B','1','F');
    $pdf->SetFont('Arial','B',8);
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');  

} else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 2551)){

    $pdf->AddPage();

    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('BOGOTA, MESITAS DEL COLEGIO, VIOTA, TOCAIMA Y VICEVERSA.'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

} else if(($listarFuecPorId[0]['id_contrato_ocasional'] == 2579)){

    	

    $pdf->AddPage();
    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L,B','0','C');
    $pdf->Cell(183, 5, utf8_decode('Bogotá - zupaquira - ubate - Chiquinquira - Saboya - Puente Nacional - Barbosa y viceversa'), 'T,R,L,B','1','F');

    
    $pdf->SetFont('Arial','B',8);
	
	$pdf->SetXY(10,200);
    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R,T',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,200);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R,T',1,'C');
    $pdf->SetXY(120,205);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,228);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');

    }

$pdf->Output();
ob_end_flush();

?>