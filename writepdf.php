<?php session_start( );
ini_set('display_errors','1');
error_reporting(E_ALL);
require('fpdf181/fpdf.php');

$PageHeading = 'Demo PHP-PDF Document';
$PageLinkText = 'GitHub/HorusScope';
$PageLink = 'https://github.com/horusscope/';
$ChapterOneTitle = 'Demo Chapter One';
$ChapterTwoTitle = "Chapter Two Good Morning";



$image = 'index.jpg';
//$pdf->Image($image, 10, 10, 30);
class PHPPDF extends FPDF {
	var $col = 0, $num = 0;
	// Cell(w, h, txt, border[LTRB], ln[0:right,1:br,2:under], align[LCR], fill[T|F])
	function Header( ) {
		global $PageHeading, $PageLinkText, $PageLink;
		$this->SetFont('Arial', 'B', 12);
		$w = $this->GetStringWidth($PageHeading);
		$this->SetDrawColor(180,220,220);
		$this->SetFillColor(33,33,33);
		$this->SetTextColor(180,220,220);
		$this->SetLineWidth(1);
		$this->Cell(15);
		$this->Cell($w+10,8,$PageHeading,1,0,'L',true);
		$this->SetFont('','U', 11);
		$this->Cell(60,5,'FPDF',0,0,'R',false,'http://www.fpdf.org');
		$this->Cell(60,5,$PageLinkText,0,0,'R',false,$PageLink);
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


$ChapterOneBody = <<<BODY
This is the chapter which comes first in a set of chapters. When I first started writing was right now, because I would like to write a chapter of actual thoughts rather than unintelligible gibberish, though I do fear we'll receive either way in the former regard. To speak plainly. Oh, I am so ashamed that I may have slipped my words into the opposite language, that's the strangest thing I've said plainly all day.
I'm immediately nothing, because this subject hasn't been much for my words.
Then when he came to, he was made aware that he was on the roof. He looked around, astonished that the stars were hidden, having fallen asleep under much more visible conditions.
Humbled, he looked down, noticing the slope of the roof. He wondered how he got here, he knew he had been drinking, but he couldn't remember any of the night.
Someone stirred, they were watching him. "Good morning!" She smiled and waved. He awakes.
BODY;


$ChapterTwoBody = <<<COLUMNS
This time he saw a farther star, suddenly but faintly, it appeared from such a quiet depth of sky, flickering to exposure after a long stare. He blinked, looking back upon her. "Well?" She barked high, "How'd you sleep?"

He couldn't believe she wasn't surprised herself. She kept on casual.
"Uhhmm-- Fine..., I guess." He grumbled, his tired body croaking out.
She furrowed her eyebrows for a moment, then her face relaxed into a smile.

He started down the roof, inching almost like a goat.
The wall up ahead was an easy place to jump down, it held the fence gate.
"Hey wait!"
He changed his mind, rounding onto the patio.
He climbed down the couch, over the stucco.
"What?" He asked her.
"What do you mean 'What!?'?" She stomped back at him.

He shied his face away and hurried into the other room through the second door.
She stood outside, then sat down after a while to finish her book.
He sure was suspicious, and here I took the time to watch after his drunk behind...

The house was immaculate, he looked at his behind, there was brick dust.
He got into the shower.

She got up and went into the kitchen to make food.
While she was there, she noticed a strange bottle on the counter.
She can't decide who it belongs to, and she doesn't want to get him into trouble.
She slips it under the counter, beneath the sink motor.

Her eggs were done, she slipped them onto a red ceramic plate.
Lifting the plate, she walked into her room.
She ate them watching television, the news was on.

He showered peacefully, thinking to himself about the day.
After he drank in the sports bar, he could only remember a few seconds here and there. He couldn't remember getting out of the bar at all. He did drink before, he thought, or did he?

Then she heard about it, the robbery. She had been watching him, she knew.
It wasn't him, she knew, having thought about him sleeping so pathetically in a bundle there on the rooftop. How long had I even taken my eyes off him? He did want to go down the roof.
He couldn't have ever been gone longer than an hour, she supposed.
She shook her head at her suspicious attitude, feeling shame after calculating it out.

He dried himself and went on into the living room, it was empty. The shelves were all moved and cleaned, and the carpet was vacuumed. All the smaller memorabilia was sorted into equal lines according to size and color. The documents were piled neatly into single stacks, and the pen was laid out over the desk facing the chair.
He walked into the kitchen, and his eyes grew wide.
COLUMNS;

$TableColumns = [ ['f(x)',40], ['x=1',30], ['x=2',30], ['x=3',30], ['x=5',30] ];
$TableData = <<<TABLE
x;1;2;3;5
x^2;1;4;9;25
x^2 - x;0;2;6;20
x^3 - x^2;0;4;18;100
TABLE;

$phppdf = new PHPPDF('P', 'mm', 'A4');
$phppdf->AliasNbPages( );
$phppdf->AddPage( );
$phppdf->title($ChapterOneTitle);
$phppdf->body($ChapterOneBody);
$phppdf->AddPage( );
$phppdf->title($ChapterTwoTitle);
$phppdf->columns(3,10,$ChapterTwoBody);
$phppdf->AddPage( );
$phppdf->fancyTable($TableColumns, $TableData);
$phppdf->Output('I','demo.pdf', true);
?>
