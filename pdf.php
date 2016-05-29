<?php
//limpiar el buffer de salida y desabilirat el almacenamiento en el mismo
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
	$this->Cell(100,10,'Reporte de Alumnos',0,0,'C');
	// Salto de línea
	$this->Ln(8);
	//subtitulo
	$this->SetFont('Times','B',15);
	$this->Cell(50);
	$this->Cell(100,10,'Datos generales',0,0,'C');
}

// Pie de página
function Footer() 
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',10);
		//$this->Cell(0,10,'Creado por Avalos Contreras Candelario',0,0,'C');
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
				$this->Cell(5);
				//$this->Cell(10,5,"ID",1);
				$this->Cell(28,5,"A Paterno",1,0);//ancho, alto, valor, borde (0 sin borde, 1 con borde), salto de línea (0 sin salto, 1 con salto)
				$this->Cell(28,5,"A Materno",1,0);
				$this->Cell(28,5,"Nombre",1,0);
				$this->Cell(25,5,"Num Tel",1,0);
				$this->Cell(35,5,"Ciudad",1,0);
				$this->Cell(40,5,"Plantel de Proc",1,1);
				$this->SetFont('Times','',12);

				include_once'./conexion.php';
				$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());
				$query = 'select * from alumno Order By ciudad, apaterno, amaterno, nombre';
				$result = pg_query($cnx, $query) or die('error' . pg_last_error());
				while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
						$this->Cell(5);
        				//$this->Cell(10,5,$line['id'],1);
						$this->Cell(28,5,$line['apaterno'],1,0);   
						$this->Cell(28,5,$line['amaterno'],1,0);
						$this->Cell(28,5,$line['nombre'],1,0);
						$this->Cell(25,5,$line['telefono'],1,0); 
						$this->Cell(35,5,$line['ciudad'],1,0);
						$this->Cell(40,5,$line['plantelprocedencia'],1,1);     
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
$x 			= 100;
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
