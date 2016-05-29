<?php
//limpiar el buffer de salida y deshabilitar el almacenamiento en el mismo
ob_end_clean();	
require('fpdf/fpdf.php');
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
	// Logo x, y, tamaño
	$this->Image('banner.png',5,5,200);
	// Arial bold 15
	$this->SetFont('Times','B',30);
	// Movernos a la derecha
	$this->Cell(50);
	// Título
	$this->Cell(100,10,'Usuarios de Sistema',0,0,'C');
	// Salto de línea
	$this->Ln(8);
	//subtitulo
	$this->SetFont('Times','B',15);
	$this->Cell(50);
	$this->Cell(100,10,'Reporte General',0,0,'C');
}

// Pie de página
function Footer() 
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',10);
		//$this->Cell(0,10,'Creado por Candelario Avalos Contreras',0,0,'C');
		// Número de página
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

	function TablaTitulo(){
				//This->Ln();
				//This->Ln();
				//This->Ln();
				//This->Ln(15);
			}

	function TablaDatos(){
				
				
				$this->Ln(30);
				$this->Cell(60);
				$this->Cell(30,5,"Usuario",1);
				//$this->Cell(50,5,"Contraseña",1,0);
				$this->Cell(40,5,"Privilegio",1,1);
				$this->SetFont('Times','',12);
				include_once'./conexion.php';
				$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());
				$sql = "select * from usuario Order By usuario";
				$result = pg_query($cnx, $sql) or die('error' . pg_last_error());
				while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
						$this->Cell(60);
        				$this->Cell(30,5,$line['usuario'],1); 
						//$this->Cell(50,5,$line['contrasena'],1,0);
						$this->Cell(40,5,$line['privilegio'],1,1);  
				}
				pg_close($cnx);

			}

}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
//Primera pagina
$pdf->SetY(8);$pdf->TablaTitulo();
//envio de parametros a la hoja pdf
$pdf->setY(20); $pdf->TablaDatos();
$pdf->SetFont('Times','',12);
//generación del codigo de barras
/*include('barcode/php-barcode.php');
$fontSize	= 1;
$marge		= 1;
$x 			= 170;
$y 			= 270;
$height		= 8;
$width		= .2;
$angle		= 0;
$code		= "12460278 Candelario Avalos";
$type		= 'code128';
$black		= '000000';
$cod1=Barcode::fpdf($pdf, $black, $x, $y, $angle, $type, $code, $width, $height);*/		
 
$pdf->Output();
?>
