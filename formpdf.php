<?php session_start( );
ini_set('display_errors','1');
error_reporting(E_ALL);
require('fpdf181/fpdf.php');

$image = 'index.jpg';
//$pdf->Image($image, 10, 10, 30);
class PHPPDF extends FPDF {
	var $col = 0, $num = 0;
	// Cell(w, h, txt, border[LTRB], ln[0:right,1:br,2:under], align[LCR], fill[T|F])
	function Header( ) {
		$PageHeading = $_POST['PageHeading'];
		$PageLinkText = $_POST['PageLinkText'];
		$PageLink = $_POST['PageLink'];
		$this->SetFont('Arial', 'B', 12);
		$w = $this->GetStringWidth($PageHeading);
		$this->SetDrawColor(180,220,220);
		$this->SetFillColor(33,33,33);
		$this->SetTextColor(180,220,220);
		$this->SetLineWidth(1);
		$this->Cell(15);
		$this->Cell($w+10,6,$PageHeading,1,0,'L',true);
		$this->SetFont('','U', 11);
		$this->Cell(0,5,'FPDF',0,1,'R',false,'http://www.fpdf.org');
		$this->Cell(0,5,$PageLinkText,0,1,'R',false,$PageLink);
		$this->SetFont('','',12);
		$this->Ln(10); 
	}
	function title($string) {
		$this->SetFont('Arial', 'B', 14);
		$w = $this->GetStringWidth($string);
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(30,50,50);
		$this->Cell($w+10,8,$string,1,1,'C',true);
	}
	function body($string) {
		$this->SetFont('Times','',11);
		$this->MultiCell(0,5,$string);
		$this->Ln( );
		$this->SetFont('','I');
		$this->Cell(0,5,'(end of excerpt)');
	}
	function SetCol($col) {
		$this->col = $col;
		$x = 10+$col*$this->w;
		$this->SetLeftMargin($x);
		$this->SetX($x);
	}
	function AcceptPageBreak( ) {
		if($this->col<$this->num) {
			$this->SetCol($this->col+1);
			$this->SetY(33);
			return false;
		} else {
			$this->SetCol(0);
			return true;
		}
	}
	function columns($num, $margin, $string) {
		$this->num = $num;
		$this->margin = $margin;
		$this->SetFont('Times','',11);
		$this->w = (210-$margin*($num+2)) / $num;
		$this->SetAutoPageBreak(true, 30);
		$this->MultiCell($this->w,5,$string);
		$this->SetAutoPageBreak(false, 30);
		$this->SetCol(0);
		$this->Ln( );
	}
	function fancyTable($columns, $tableData) {
		$lines = explode("\n", $tableData);
		$data = [ ];
		foreach($lines as $line)
			$data[] = explode(';', trim($line));
		$this->SetFont('Arial','',14);
		// Column Headers
		$this->SetFillColor(0,50,180);
		$this->SetTextColor(255);
		$this->SetDrawColor(0,25,90);
		$this->SetLineWidth(1/3);
		$this->SetFont('','B');
		$w = [ ];
		for($i=0;$i<count($columns);$i++) {
			$w[$i] = $columns[$i][1];
			$this->Cell($w[$i], 7, $columns[$i][0], 1,0, 'C', true);
		}
		$this->Ln( );

		// Each Row
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		$fill = false;
		foreach($data as $row) {
			foreach($row as $index => $string)
				$this->Cell($w[$index], 6, $string, 'LR',0,$index==0?'L':'R', $fill);
			$this->Ln( );
			$fill = !$fill;
		}
		// Close Table
		$this->Cell(array_sum($w),0,'','T');
	}
}


$phppdf = new PHPPDF('P', 'mm', 'A4');
$phppdf->AliasNbPages( );
$phppdf->AddPage( );
function paragraph($string) {
	global $phppdf;
	$phppdf->SetFont('Arial','',11);
	$w = $phppdf->GetStringWidth($string);
	$phppdf->Cell($w,5,$string,0,1,'L',false);
	$phppdf->Ln( );
}
paragraph("Hello {$_POST['Name']},");
paragraph("We're calling to correspond about your inquiry on {$_POST['Date']}.");
paragraph("Please contact us again at your earliest convenience.");
$phppdf->Output('I','demo.pdf',false);
?>
