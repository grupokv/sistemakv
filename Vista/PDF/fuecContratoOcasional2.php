
<?php 
	
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


	$id_fuec_contrato_ocasional = $_GET['id'];

	$id_contrato_ocasional = base64_decode($id_fuec_contrato_ocasional);

	/*CONTRATO*/
	$contratoOcasional = new ContratoOcasional();
	$listarContratoPorId = $contratoOcasional->listarPorId($id_contrato_ocasional);
	/*print_r($listarContratoPorId);*/

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
/*
	print_r($listarFuecPorId);*/

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
	        // Logo

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
			$this->Cell(70,30,$this->Image("../../Resources/fpdf/img/".$logo, $this->GetX()+12, $this->GetY()+1, 40),0,1,'C');
		    // Arial bold 15
		    $this->Ln(0);
	    }

	    function Footer(){
	    	
	        // Posición: a 1,5 cm del final
	        $this->SetY(-15);
	        // Arial italic 8
	        $this->SetFont('Arial','I',8);
	        // Número de página
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

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(35,5,'OBJETO CONTRATO:',0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(155,5, 'SERVICIO DE TRANSPORTE ESPECIAL DE PASAJEROS CON GRUPO ESPECÍFICO DE USUARIOS',0,1,'L');

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(35,5,'ORIGEN - DESTINO:',0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(155,5, utf8_decode($listarCiudadOrigen[0]['ciudad']) .' - '. utf8_decode($listarCiudadDestino[0]['ciudad']),0,1,'L');

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

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,1,'','R L','1','C');
	$pdf->Cell(0,5,'CONDUCTORES','R L','1','C');
	$pdf->Cell(0,1,'','R L B','1','C');

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
	$pdf->Image('../../Resources/fuec/img/SKMBT_22319123016050_001.png',0,0,210);


	if (count($listarUsuariosPorContrato) > 0) {

		$pdf->AddPage();

		$pdf->Cell(190, 15,'', 0,'1','C');
		$pdf->Cell(190, 5,'ANEXO SERVICIO DE TRANSPORTE ESPECIAL DE PASAJEROS CON GRUPO ESPECÍFICO DE USUARIOS', 0,'1','C');
		$pdf->Cell(190, 5, utf8_decode('FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
		$pdf->Cell(190, 15,'', 0,'1','C');

		$pdf->Cell(95, 5,'NOMBRE USUARIO', 0,'0','C');
		$pdf->Cell(95, 7,utf8_decode('DOCUMENTO DE IDENTIFICACIÓN'), 0,'1','C');


		$pdf->Cell(190, 3,'', 0,'1','C');

		/*23*/

		$cant = count($listarUsuariosPorContrato);
		$restante = 23 - $cant;

			$pdf->SetFont('Arial','',9);
		if($cant > 0){
		    $i = 1;
			foreach($listarUsuariosPorContrato as $luco){
			$pdf->Cell(95,5,utf8_decode($luco['nombre_usuario']), 0,0,'C');
			$pdf->Cell(95,5,$luco['numero_documento'], 0,1,'C');

			$i++;
			}
		}

		while($restante > 0){
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(190, 5, utf8_decode(), 0,'1','C');

			$restante--;
		}
	}

	$pdf->Output();




?>