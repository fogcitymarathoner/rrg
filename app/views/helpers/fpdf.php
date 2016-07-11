<?php 

App::import('Vendor','fpdf/fpdf');

if (!defined('PARAGRAPH_STRING')) define('PARAGRAPH_STRING', '~~~');

class FpdfHelper extends AppHelper {
	
	/**
	* Allows you to change the defaults set in the FPDF constructor
	*
	* @param string $orientation page orientation values: P, Portrait, L, or Landscape	(default is P)
	* @param string $unit values: pt (point 1/72 of an inch), mm, cm, in. Default is mm
	* @param string $format values: A3, A4, A5, Letter, Legal or a two element array with the width and height in unit given in $unit
	*/
	function setup ($orientation='P',$unit='mm',$format='A4') {
		$this->FPDF($orientation, $unit, $format); 
	}
	
	/**
	* Allows you to control how the pdf is returned to the user, most of the time in CakePHP you probably want the string
	*
	* @param string $name name of the file.
	* @param string $destination where to send the document values: I, D, F, S
	* @return string if the $destination is S
	*/
	function fpdfOutput ($name = 'page.pdf', $destination = 's') {
		// I: send the file inline to the browser. The plug-in is used if available. 
		//	The name given by name is used when one selects the "Save as" option on the link generating the PDF.
		// D: send to the browser and force a file download with the name given by name.
		// F: save to a local file with the name given by name.
		// S: return the document as a string. name is ignored.
		return $this->Output($name, $destination);
	}
	
    function pdfdoc($invoice,$client,$filename)
    {
    	$pdf=new FPDF();
$pdf->AddPage(); 
$pdf->Image('img/RRG_LOGO_WEB.jpg',10,8,33,'JPEG');
$pdf->SetFont('Arial','B',16);
$pdf->Cell(140,10,'',0,0);
$pdf->Cell(40,10,'Invoice '.$invoice['Invoice']['id'],0,1);
$pdf->Cell(140,10,'',0,0);
$pdf->Cell(40,10,'Date: '.$invoice['Invoice']['date'],0,1);

$pdf->Cell(40,15,'',0,1);
$pdf->Cell(110,7,'Rockets Redglare',0,0);
$pdf->Cell(40,7,substr($client['Client']['name'],0,40),0,1);


//$pdf->Cell(40,15,'','B',1);
$pdf->Cell(110,7,'1082 View Way',0,0);
$pdf->Cell(40,7,substr($client['Client']['street1'],0,40),0,1);

//$pdf->Cell(40,15,'','B',1);
$pdf->Cell(110,7,'Pacifica, CA 94044',0,0);
$pdf->Cell(40,7,
substr($client['Client']['city'],0,40).', '.
substr($client['Client']['st'],0,40).' '.
substr($client['Client']['zip'],0,40)
,0,1);
$startdatearray = explode('-',$invoice['Invoice']['period_start']);
$enddatearray = explode('-',$invoice['Invoice']['period_end']);

$pdf->Cell(40,15,'',0,1);
$pdf->MultiCell(180,10,$invoice['ClientsContract']['title'],0,1);
$pdf->Cell(180,10,'During the period of: '.$startdatearray[1].'/'.$startdatearray[2].'/'.$startdatearray[1].' to '.$enddatearray[1].'/'.$enddatearray[2].'/'.$enddatearray[1].'.',0,1);
$pdf->Cell(40,15,'',0,1);
$pdf->Cell(40,10,'',0,0);
$pdf->Cell(50,10,'Description','B',0,'C');
$pdf->Cell(20,10,'Quantity','B',0,'C');
$pdf->Cell(20,10,'Cost','B',0,'R');
$pdf->Cell(35,10,'Subtotal','B',1,'R');

		$i = 0;
		$totalQuant = 0;
		foreach ($invoice['InvoicesItem'] as $InvoiceItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			$totalQuant += $InvoiceItem['quantity'];
			$quant = sprintf("%8.2f",    $InvoiceItem['quantity']); // right-justification with spaces
			$cost = sprintf("%8.2f",    $InvoiceItem['amount']); // right-justification with spaces
			$subtotal = sprintf("%8.2f",    $InvoiceItem['quantity']*$InvoiceItem['amount']); // right-justification with spaces
            if ($subtotal != 0){
$pdf->Cell(40,10,'',0,0);
$pdf->Cell(50,10,$InvoiceItem['description'],'B',0);
$pdf->Cell(20,10,$quant,'B',0,'R');
$pdf->Cell(20,10,$cost,'B',0,'R');
$pdf->Cell(35,10,$subtotal,'B',1,'R');
            }
	endforeach; 
$pdf->Cell(40,10,'',0,0);
$pdf->Cell(50,10,'',0,0);
$pdf->Cell(20,10,sprintf("%8.2f",$totalQuant),0,0,'R');
$pdf->Cell(20,10,'',0,0,'R');
$pdf->Cell(35,10,sprintf("%8.2f",$invoice['Invoice']['amount']),0,1,'R');
	
$pdf->Ln();
$pdf->Cell(40,10,$invoice['ClientsContract']['invoicemessage']);
$pdf->Ln();
$pdf->Cell(40,10,$invoice['Invoice']['message']);

$pdf->Output('invoices/'.$filename,'F');
$pdf->Output();

    }	
}
    function pdfHeader()
    {
        //Logo
        $this->Image(WWW_ROOT.DS.'img/plaingrey.gif',10,8,33);  
        // you can use jpeg or pngs see the manual for fpdf for more info
        //Arial bold 15
        $this->SetFont('Arial','B',15);
        //Move to the right
        $this->Cell(80);
        //Title
        $this->Cell(30,10,$this->title,1,0,'C');
        //Line break
        $this->Ln(20);
    }

    //Page footer
    function Footer()
    {
        //Position at 1.5 cm from bottom
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','I',8);
        //Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function basicTable($header,$data)
    {
        //Header
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        //Data
        foreach($data as $row) {
            foreach($row as $col) {
                $this->Cell(40,6,$col,1);
            }
            $this->Ln();
        }
    } 
?>