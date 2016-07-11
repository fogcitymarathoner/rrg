<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marc
 * Date: 4/24/13
 * Time: 3:52 PM
 * To change this template use File | Settings | File Templates.
 */

App::import('Model', 'Employee');
class EmployeeComponent extends Object {
    function build_label_sheet_from_fixture($fixfile)
    {
        $fsize = filesize($fixfile);
        $f=fopen($fixfile,"r");
        $fixstr = fread($f,$fsize);
        fclose($f);
        $employees = $this->gather_employees_from_form_for_labels($fixstr);
        $pdf=$this->setup_label_sheet_pdf($employees);
        $fully_qualified_filename =$this->labelSheetFullyQualifiedFilename();
        $pdf->SetTitle('employees label sheet');
        $pdf->Output($fully_qualified_filename,'F');
        return $pdf;
    }

    function soap_build_label_sheet_from_fixture($fixfile)
    {
        $fsize = filesize($fixfile.'.json');
        $f=fopen($fixfile.'.json',"r");
        $fixstr = fread($f,$fsize);
        fclose($f);
        $employees = $this->gather_employees_from_form_for_labels($fixstr);
        $pdf=$this->setup_label_sheet_pdf($employees);
        $fully_qualified_filename =$this->labelSheetFullyQualifiedFilename();
        $pdf->SetTitle('employees label sheet');
        $pdf->Output($fully_qualified_filename,'F');
        return $pdf;
    }
    function setup_label_sheet_pdf($employees)
    {
        App::import('Vendor','fpdf/fpdf');
        $cellborder = 0; // for debugging
        $gridlinewidth = 0.2;  // for debugging, 0.2 is a good value
        $columnCount = 3;
        $rowCount = 10;
        $columnSpacing = 3.97 ;
        $rowSpacing = 2.29;
        $bottomMargin = 12.7   ;
        $topMargin = 12.7  +10 ;
        $rightMargin = 4.76;
        $pageWidth = 216;
        $pageHeight = 279;
        $labelHeight = 25 + .5;
        $labelWidth = 67 ;

        $leftMargin = ($pageWidth-3*$labelWidth-2*$columnSpacing)/2 -2; //debug($leftMargin);exit;
        $rightMargin = $leftMargin;
        $pdf=new FPDF();
        $pdf->SetDisplayMode('real');
        $pdf->SetLineWidth($gridlinewidth);



        $columnnumber = 0;
        $columnnumber++;
        $col1right = $leftMargin + $labelWidth;
        $col2left = $col1right + $columnSpacing;
        $columnnumber++;
        $col2right = $col2left +$labelWidth;

        $col3left = $col2right + $columnSpacing;

        $col3right = $col3left +$labelWidth;
        $columnnumber++;
        $xpos = $leftMargin + $labelWidth*$columnnumber+ $columnSpacing*$columnnumber;
        $columnnumber++;
        $xpos = $leftMargin + $labelWidth*$columnnumber+ $columnSpacing*$columnnumber;
        $colPos  = array($leftMargin,$col2left, $col3left);


        $rowPos = array();
        for ( $counter = 0; $counter < 10; $counter += 1) {
            array_push($rowPos, $topMargin + $labelHeight * $counter);
        }
        $empout = 0;
        if (count($employees) < 30)
        {
            $pageCount =1;
        } else
        {
            $pageCount =  count($employees)/($rowCount*$columnCount);
        }
        for ( $counter = 0; $counter < $pageCount; $counter += 1) {
            $pdf->AddPage();
            if ($cellborder==1)
            {
                $pdf->Line(0,$topMargin,$pageWidth,$topMargin);
                $pdf->Line($col1right,0,$col1right,$pageHeight);
                $pdf->Line($col2left,0,$col2left,$pageHeight);
                $pdf->Line($col2right,0,$col2right,$pageHeight);
                $pdf->Line($col3left,0,$col3left,$pageHeight);
                $pdf->Line($col3right,0,$col3right,$pageHeight);
                $pdf->Line($xpos,0,$xpos,$pageHeight);
                $pdf->Line($xpos,0,$xpos,$pageHeight);
                for ( $counter4 = 0; $counter4 < 10; $counter4 += 1) {
                    $pdf->Line(0,$rowPos[$counter4],$pageWidth,$rowPos[$counter4]);
                }
            }
            $leftcorrect = 2;
            $topcorrect = 2;
            $index = 0;
            for ( $counter2 = 0; $counter2 < $rowCount; $counter2 += 1) {
                for ( $counter3 = 0; $counter3 < $columnCount; $counter3 += 1) {
                    $pdf->SetXY($colPos[$counter3]+$leftcorrect, $rowPos[$counter2]+$topcorrect);
                    if ($empout<count($employees))
                    {
                        $pdf->SetFont('Arial','B',14);
                        $outstr = '';
                        if ($employees[$empout]['Employee']['firstname'] != 'BLANK' && $employees[$empout]['Employee']['lastname'] != 'BLANK')
                        {
                            $outstr = strtoupper($employees[$empout]['Employee']['firstname'].' '.$employees[$empout]['Employee']['lastname']);
                        }
                        $pdf->Cell($labelWidth-4,($labelHeight-4)/4,$outstr,$cellborder,1 );

                        $pdf->SetXY($colPos[$counter3]+$leftcorrect, $rowPos[$counter2]+($labelHeight-4)/4+$topcorrect);

                        $pdf->SetFont('Arial','B',12);
                        $pdf->Cell($labelWidth-4,($labelHeight-4)/4,
                            strtoupper($employees[$empout]['Employee']['street1']),$cellborder,0 );

                        $pdf->SetXY($colPos[$counter3]+$leftcorrect, $rowPos[$counter2]+(($labelHeight-4)/4)*2+$topcorrect);
                        if (strlen($employees[$empout]['Employee']['street2'])>0)
                        {
                            $pdf->Cell($labelWidth-4,($labelHeight-4)/4,
                                strtoupper($employees[$empout]['Employee']['street2']),$cellborder,0 );
                            $pdf->SetXY($colPos[$counter3]+$leftcorrect, $rowPos[$counter2]+(($labelHeight-4)/4)*3+$topcorrect);
                        }
                        $outstr = '';
                        if ($employees[$empout]['Employee']['firstname'] != 'BLANK' and $employees[$empout]['Employee']['lastname'] != 'BLANK')
                        {
                            $outstr = $employees[$empout]['Employee']['city'].
                                ', '.$employees[$empout]['State']['post_ab'].' '.$employees[$empout]['Employee']['zip'];
                        }
                        $pdf->Cell($labelWidth-4,($labelHeight-4)/4,strtoupper($outstr),$cellborder,0 );

                        $empout++;
                    }


                }
            }

        }
        return $pdf;
    }

    function gather_employees_from_form_for_labels($fixstr)
    {
        $fixobj = json_decode ( $fixstr);
        $row = $fixobj->{'row'};
        $column = $fixobj->{'column'};
        $blankEmployee = array('Employee'=>
        array(
            'firstname'=>'BLANK',
            'lastname'=>'BLANK',
            'street1'=>'',
            'street2'=>'',
            'city'=>'',
            'st'=>'',
            'zip'=>'',
        ));
        $employees = array();
        if ($row == 1)
        {
            for ( $counter = 0; $counter < $column-1; $counter += 1) {
                array_push($employees,$blankEmployee);
            }
        } else
        {
            for ( $counter = 0; $counter < ($row-1)*3; $counter += 1) {
                array_push($employees,$blankEmployee);
            }
            for ( $counter = 0; $counter < $column-1; $counter += 1) {
                array_push($employees,$blankEmployee);
            }
        }
        $empModel = new Employee();
        foreach ($fixobj->{'employees'} as $employee):
            $resultEmployee = $empModel->read(null, $employee->{'id'});
            $resultEmployee['Employee']['st']= $resultEmployee['State']['name'];
            array_push($employees,$resultEmployee);
        endforeach;
        return $employees;
    }

    function labelSheetFullyQualifiedFilename()
    {
        $xml_home = Configure::read('xml_home');
        $labelsdir = $xml_home.'labels/';
        $filename = $labelsdir.'employees_sheet.pdf';
        return $filename;
    }
}