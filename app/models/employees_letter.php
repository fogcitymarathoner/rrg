<?php
class EmployeesLetter extends AppModel {

	var $name = 'EmployeesLetter';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Employee' => array('className' => 'Employee',
								'foreignKey' => 'employee_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
	);

    function generatepdf($id,$display= null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Invoice.', true));
            $this->redirect(array('action'=>'index'));
        }
        $pdf = $this->rrg_pdf_file($id,$xml_home);
        if ($display!= null)
            $pdf->Output();

        return $pdf;
    }

    function rrg_pdf_file($id,$xml_home)
    {
        $letter = $this->read(null, $id);
        // Employee
        $this->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
        $employee =  $this->Employee->read(null, $letter['EmployeesLetter']['employee_id']);
//debug($letter);debug($employee);exit;
        App::import('Vendor','fpdf/fpdf');

        $pdf=new FPDF();

        $pdf->AddPage();
        $pdf->Cell(10,30,'',0,2);
        $pdf->Image('img/RRG_LOGO_WEB.jpg',10,8,33,'JPEG');
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(140,10,'',0,0);
        $pdf->Cell(140,10,'',0,0);

        $pdf->Cell(40,15,'',0,1);
        $pdf->Cell(100,7,Configure::read('co_name'),0,0);
        $pdf->Cell(40,7,substr(strtoupper  ($employee['Employee']['firstname'].' '.$employee['Employee']['lastname']),0,40),0,1);


        //$pdf->Cell(40,15,'','B',1);
        $pdf->Cell(100,7,Configure::read('co_street1'),0,0);
        $pdf->Cell(40,7,substr(strtoupper  ($employee['Employee']['street1']),0,40),0,1);

        //$pdf->Cell(40,15,'','B',1);
        $pdf->Cell(100,7,Configure::read('co_city').', '.Configure::read('co_state').' '.Configure::read('co_zip'),0,0);
        $pdf->Cell(40,7,
            substr(strtoupper  ($employee['Employee']['city']),0,40).', '.
                //substr(strtoupper  ($employee['Employee']['post_ab']),0,40).' '.
                substr(strtoupper  ($employee['Employee']['zip']),0,40)
            ,0,1);
        $pdf->Cell(40,10,'',0,1);
        $datearray = getdate(strtotime($letter['EmployeesLetter']['date']));
        $pdf->Cell(40,7,date('m',strtotime($datearray['month'])).'/'.$datearray['mday'].'/'.$datearray['year'],0,1);

        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(10,7,$letter['EmployeesLetter']['salutation'],0,2);
        $pdf->Cell(40,4,'',0,2);
        $pdf->MultiCell(180,7,$letter['EmployeesLetter']['para1'],0,2);


        $pdf->Cell(40,4,'',0,2);

        $pdf->MultiCell(180,7,$letter['EmployeesLetter']['para2'],0,2);


        $pdf->Cell(40,4,'',0,2);

        $pdf->MultiCell(180,7,$letter['EmployeesLetter']['para3'],0,2);


        $pdf->Cell(40,4,'',0,2);

        $pdf->MultiCell(180,7,$letter['EmployeesLetter']['para4'],0,2);


        $pdf->Cell(40,4,'',0,2);

        $pdf->MultiCell(180,7,$letter['EmployeesLetter']['para5'],0,2);

        $pdf->Cell(40,20,'',0,1);
        $pdf->Cell(100,0,'',0,0);
        $pdf->Cell(35,7,"Marc Condon",'T',1,'R');
        //Set font
        $pdf->SetFont('Arial','',8);

        $pdf->SetXY(40,265);$pdf->Cell(35,7,"bottom of letter",'B',1,'R');

        $filename = str_replace (' ','-',$letter['EmployeesLetter']['title']);
        $filename = str_replace ('\'','',$filename);
        $letterdir = $this->xml_home.'employees/letters/';


        // make letter directory if it does not exist
        if (!file_exists($letterdir)) {
            mkdir($letterdir);
        }
        $fully_qualified_filename = $letterdir.$filename;
        $pdf->SetTitle($filename);
        $pdf->Output($fully_qualified_filename,'F');
        return $pdf;
    }
}
?>