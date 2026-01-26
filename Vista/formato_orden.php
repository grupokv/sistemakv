<?php

ob_start();
include("../Controlador/Sesion/autenticar.php");
require('../Resources/fuec/fpdf.php');
require('../Resources/fpdf-easytable-master/exfpdf.php');
require('../Resources/fpdf-easytable-master/easyTable.php');
require('../Modelo/Vehiculo.php');
require('../Modelo/EmpresaEnt.php');
require('../Modelo/TipoVehiculo.php');
require('../Modelo/ProveedorMantenimiento.php');
require('../Modelo/TipoServicioMantenimiento.php');
require('../Modelo/Categoria_Mantenimiento.php');
require('../Modelo/Subcategoria_Mantenimiento.php');
require('../Modelo/OrdenServicio.php');

$cod = $_GET['id'];

setlocale(LC_TIME, "C");

$orden = new OrdenServicio();
$proveedor = new ProveedorMantenimiento();
$tiposervicio = new TipoServicioMantenimiento();
$categoria = new Categoria_Mantenimiento();
$subcategoria = new Subcategoria_Mantenimiento();
$cod = base64_decode($cod);

$listar = $orden->listarPorId($cod);
$detalle = $orden->detallePorIdOrden($cod);

/*if(count($listar) < 1) {
    echo '<script type="text/javascript">'; 
    echo 'alert("Se genero un error");'; 
    echo 'window.location.href = "inicio.php";';
    echo '</script>';
}*/

$vehiculo = new Vehiculo();
$empresa = new Empresa();
$tipovehiculo = new TipoVehiculo();

$vehiculoid = $vehiculo->listarPorId($listar[0]['id_vehiculo']);
$ultimo_mto = $orden->listarPorIdVehiculo($listar[0]['id_vehiculo']);
if(count($ultimo_mto) > 0){
    $fecha_ultimo = $ultimo_mto[0]['fecha_ejecucion'];
} else {
    $fecha_ultimo = 'N/A';
}
$tipoid = $tipovehiculo->listarPorId($vehiculoid[0]['id_tipo_vehiculo']);
$tipo_serv = $tiposervicio->listarPorId($listar[0]['id_tipo_servicio']);
$proveedorid = $proveedor->listarPorId($listar[0]['id_proveedor']);
$empresaid = $empresa->listarPorId($listar[0]['id_empresa']);
$logo = $empresaid[0]['logo'];

//print_r($empresaid);

class PDF extends exFPDF
{
// Cabecera de página
function Header()
{

    // Arial bol
    // d 15
    $orden = new OrdenServicio();
    $empresa = new Empresa();
    $cod = $_GET['id'];
    $cod = base64_decode($cod);
    $listar = $orden->listarPorId($cod);

    $empresaid = $empresa->listarPorId($listar[0]['id_empresa']);
    $logo = $empresaid[0]['logo'];

    $this->SetFont('Arial','B', 9);
    $this->Cell(0,20,'',0,1,'C');
    $this->Cell(120,30,'ORDEN DE SERVICIO No.' . $cod ,1,0,'C');
    $this->Cell(70,30,$this->Image("../Resources/fpdf/img/". $logo, $this->GetX()+12, $this->GetY()+1, 45),'B T R',1,'C');
    
    $this->Ln(0);

}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-25);
    // Arial italic 8
    $this->SetFont('Arial','B',8);
    $this->Cell(0,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65',0,1,'C');
    $this->Cell(0,4,'glpgerencia@ortsas.com',0,1,'C');
    $this->Cell(0,4,'Bogota - Colombia',0,1,'C');
    // Número de página
    $this->Cell(0,10,'Pag '.$this->PageNo().'/{nb}',0,0,'C');
}
}



// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Arial','B',11);


$pdf->SetFont('Arial','B', 9);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'DATOS DE LA ORDEN','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,utf8_decode('Tipo de Servicio'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,utf8_decode($tipo_serv[0]['detalle_tipo']),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Fecha Creación'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(40,5,date('d-m-Y h:i a',strtotime($listar[0]['fecha_creacion'])),'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Válida Desde'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,date('d-m-Y',strtotime($listar[0]['fecha_inicial'])),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Válida Hasta'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,date(('d-m-Y'),strtotime($listar[0]['fecha_final'])),'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'DATOS DE LA EMPRESA','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);

$table = new easyTable($pdf, '{35,85,20,50}', 'font-size: 9; font-family:Arial; align:{L};');

    $table->easyCell(utf8_decode('Razón Social'), 'border: B,L; font-style:B;');
    $table->easyCell(utf8_decode($empresaid[0]['nombre_empresa']), 'border: B,R; font-style:N; align:L;');
    $table->easyCell('NIT', 'border:B; font-style:B; align:L;');
    $table->easyCell($empresaid[0]['nit_empresa'], 'border:B,R; font-style:N; align:L;');
    
    $table->printRow();
    
$table->endTable(0);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,utf8_decode('Dirección'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,utf8_decode($empresaid[0]['direccion']),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,utf8_decode('Teléfono'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$empresaid[0]['telefono'],'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'DATOS DEL PROVEEDOR','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','',9);
$table = new easyTable($pdf, '{35,85,20,50}', 'font-size: 9; font-family:Arial; align:{L};');

    $table->easyCell(utf8_decode('Razón Social'), 'border: B,L; font-style:B;');
    $table->easyCell(utf8_decode($proveedorid[0]['razon_social']), 'border: B,R; font-style:N; align:L;');
    $table->easyCell('NIT', 'border:B; font-style:B; align:L;');
    $table->easyCell($proveedorid[0]['nit'], 'border:B,R; font-style:N; align:L;');
    
    $table->printRow();
    
$table->endTable(0);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,utf8_decode('Dirección'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,utf8_decode($proveedorid[0]['direccion']),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,utf8_decode('Teléfono'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$proveedorid[0]['telefono'],'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'CARACTERISTICAS DEL VEHICULO','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'PLACA','L B',0,'C');
$pdf->Cell(25,5,'MODELO','L B',0,'C');
$pdf->Cell(70,5,'MARCA','L B',0,'C');
$pdf->Cell(70,5,'CLASE','L B R',1,'C');

$pdf->SetFont('Arial','',9);
$pdf->Cell(25,5,$vehiculoid[0]['placa'],'L B',0,'C');
$pdf->Cell(25,5,$vehiculoid[0]['modelo'],'L B',0,'C');
$pdf->Cell(70,5,$vehiculoid[0]['marca'],'L B',0,'C');
$pdf->Cell(70,5,$tipoid[0]['nombre_tipo_vehiculo'],'L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,5,'NUMERO INTERNO','L B',0,'C');
$pdf->Cell(70,5,'FECHA ULTIMO MANTENIMIENTO','L B',0,'C');
$pdf->Cell(70,5,'TIPO COMBUSTIBLE','L B R',1,'C');

$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$vehiculoid[0]['numero_movil'],'L B',0,'C');
$pdf->Cell(70,5,$fecha_ultimo,'L B',0,'C');
$pdf->Cell(70,5,$listar[0]['tipo_combustible'],'L B R',1,'C');


$table = new easyTable($pdf, '%{5,70,10,15}', 'font-size: 9; font-family:Arial; align:{C};');

    $table->easyCell('No.', 'border:1; font-style:B;');
    $table->easyCell('ITEM', 'border:1; font-style:B; align:C;');
    $table->easyCell('CANTIDAD', 'border:1; font-style:B; align:C;');
    $table->easyCell('VALOR APROX.', 'border:1; font-style:B; align:C;');

$table->printRow();

$a = 1;

foreach($detalle as $det){

    $det_cat = $categoria->listarPorId($det['id_categoria']);
    $det_subcat = $subcategoria->listarPorId($det['id_subcategoria']);
    $descripcion = $det_cat[0]['detalle_categoria'].' - '.$det_subcat[0]['detalle_subcategoria'];

    $table->easyCell($a,'border:1; font-size: 9');
    $table->easyCell(utf8_decode($descripcion), 'border:1; font-size:9; align:C;');
    $table->easyCell($det['cantidad'], 'border:1; font-size:9; align:C;');
    $table->easyCell('$ '.number_format($det['valor'],0,',','.'), 'border:1; align:C; font-size:9; align:C;');
    
    $table->printRow();

$a++;

}

$table->easyCell('','border:B,L; font-size: 9; font-style:B;');
$table->easyCell(utf8_decode('TOTAL'), 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell("", 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('$ '.number_format($listar[0]['valor_total'],0,',','.'), 'border:1; align:C; font-size:9; align:C;font-style:B;');
$table->printRow();
$table->endTable(1);

$table = new easyTable($pdf, '%{100}', 'font-size: 9; font-family:Arial; align:{C};font-style:B;');
$table->easyCell(utf8_decode('VALOR SUJETO A CAMBIOS SEGÚN LA REVISIÓN'), 'border:1; font-style:B;');
$table->printRow();
$table->endTable(5);

$table = new easyTable($pdf, '%{100}', 'font-size: 9; font-family:Arial; align:{C};');
$table->easyCell('OBSERVACIONES', 'border:1; font-style:B;');
$table->printRow();
$table->easyCell($listar[0]['detalle'], 'border:1;');
$table->printRow();
$table->endTable(30);

$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(90,5,'Firma y Sello','T',0,'C');
$pdf->Cell(50,5,'',0,1,'C');

$pdf->Output();

?>