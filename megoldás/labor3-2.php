<?php
// A TCPDF 11. példájának a segítségével
ob_start();
require_once('tcpdf/tcpdf.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

	// Load table data from file
	public function LoadData($database, $table) {
		$rows = array();
		try {
		
			$dbh = new PDO('mysql:host=127.0.0.1;dbname='.$database, 'root', '',
						array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
			$dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
		
			$sql = "SELECT * FROM ".$table;     
			$sth = $dbh->query($sql);
			$rows = $sth->fetchAll(PDO::FETCH_NUM);
		}
		catch (PDOException $e) {
		}
		return $rows;
	}

	// Colored table
	public function ColoredTable($caption, $header,$rows) {
		// Caption font and color
		$this->SetFont('helvetica', 'B', 16);
		$this->SetTextColor(0, 0, 255);
		// Caption
		$this->cell(180, 18, $caption, 0, 0, 'C', 0);
		$this->Ln();
		
		// Borders width
		$this->SetLineWidth(0.3);

		// Header font and colors
		$this->SetFont('helvetica', 'B', 10);
		$this->SetFillColor(255, 0, 0);
		$this->SetTextColor(255,255,255);
		$this->SetDrawColor(255,0,0);
		// Header
		$w = array(30,30,30,30,30,30 , 30, 30, 30,30);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 12, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();

		// Rows font and border color
		$this->SetFont('helvetica', '', 10);
		$this->SetDrawColor(0,0,255);
		// Rows
		$i = 1;
		foreach($rows as $row) {
			if($i) {
				$this->SetFillColor(255,255,255);
				$this->SetTextColor(0,0,255);
			}
			else {
				$this->SetFillColor(0,0,255);
				$this->SetTextColor(255,255,255);
			}
			$this->Cell($w[0], 14, $row[0], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
			$this->Cell($w[1], 14, $row[1], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
			$this->Cell($w[4], 14, $row[4], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
			$this->Cell($w[5], 14, $row[5], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
			$this->Cell($w[6], 14, $row[6], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
		   
			$this->MultiCell($w[9], 14, $row[9], 'LRB','L', 1, 0);
			$this->Ln();
			$i = !$i;
		}
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetTitle('FUBALLISTA');

// set default header data
$pdf->SetHeaderData("", 15, "FUTBALLISTÁK LISTÁJA", "Web-programozás II\nBEADANDÓ\n".date('Y.m.d',time()));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/hun.php')) {
	require_once(dirname(__FILE__).'/lang/hun.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$pdf->SetFont('helvetica', 'B', 10);

// add a page
$pdf->AddPage();

// table caption
$caption = 'FUTBALLISTÁK';

// column titles
$header = array('ID', 'MEZ', 'UTÓNÉV', 'VEZETÉKNÉV', 'SZÜL.', 'ÉRTÉK');

// data loading
$rows = $pdf->LoadData('nb1', 'labdarugo');

// print colored table
$pdf->ColoredTable($caption, $header, $rows);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('labor3-2.pdf', 'I');
ob_end_flush(); 