<?php

App::import('Component', 'Json');
App::import('Component', 'Commissions');
App::import('Component', 'Xml');
App::import('Component', 'HashUtils');
App::import('Component', 'Datasources');
App::import('Component', 'FixtureDirectories');
//App::import('Component', 'InvoiceFunction');


App::import('Model', 'InvoicesItem');
App::import('Model', 'ClientsContract');
App::import('Model', 'CommissionsReport');
App::import('Model', 'CommissionsReportsTag');
App::import('Model', 'Employee');
App::import('Model', 'InvoicesItemsCommissionsItem');



class Invoice extends AppModel {
    var $name = 'Invoice';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
            'ClientsContract' => array('className' => 'ClientsContract',
                                'foreignKey' => 'contract_id',
                                'conditions' => '',
                                'fields' => '',
                                'order' => ''
            )
    );
    var $hasMany = array(
            'InvoicesItem' => array('className' => 'InvoicesItem',
                                'foreignKey' => 'invoice_id',
                                'dependent' => true,
                                'conditions' => '',
                                'fields' => '',
                                'order' => 'ordering ASC',
                                'limit' => '',
                                'offset' => '',
                                'exclusive' => '',
                                'finderQuery' => '',
                                'counterQuery' => ''
            ),
            'InvoicesPayment' => array('className' => 'InvoicesPayment',
                                'foreignKey' => 'invoice_id',
                                'dependent' => true,
                                'conditions' => '',
                                'fields' => '',
                                'order' => '',
                                'limit' => '',
                                'offset' => '',
                                'exclusive' => '',
                                'finderQuery' => '',
                                'counterQuery' => ''
            ),
            'EmployeesPayment' => array('className' => 'EmployeesPayment',
                                'foreignKey' => 'invoice_id',
                                'dependent' => true,
                                'conditions' => '',
                                'fields' => '',
                                'order' => '',
                                'limit' => '',
                                'offset' => '',
                                'exclusive' => '',
                                'finderQuery' => '',
                                'counterQuery' => ''
            ),
            'InvoicesTimecardReminderLog' => array('className' => 'InvoicesTimecardReminderLog',
                                'foreignKey' => 'invoice_id',
                                'dependent' => true,
                                'conditions' => '',
                                'fields' => '',
                                'order' => '',
                                'limit' => '',
                                'offset' => '',
                                'exclusive' => '',
                                'finderQuery' => '',
                                'counterQuery' => ''
            ),
            'InvoicesPostLog' => array('className' => 'InvoicesPostLog',
                                'foreignKey' => 'invoice_id',
                                'dependent' => true,
                                'conditions' => '',
                                'fields' => '',
                                'order' => '',
                                'limit' => '',
                                'offset' => '',
                                'exclusive' => '',
                                'finderQuery' => '',
                                'counterQuery' => ''
                                ),
            'InvoicesTimecardReceiptLog' => array('className' => 'InvoicesTimecardReceiptLog',
                                'foreignKey' => 'invoice_id',
                                'dependent' => true,
                                'conditions' => '',
                                'fields' => '',
                                'order' => '',
                                'limit' => '',
                                'offset' => '',
                                'exclusive' => '',
                                'finderQuery' => '',
                                'counterQuery' => ''
                            ),
                    );

    public function __construct() {

        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;

        $this->invoiceFunction = new InvoiceFunctionComponent;
        $this->hu = new HashUtilsComponent;
        $this->commsComp = new CommissionsComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->dsComp = new DatasourcesComponent;
        $this->xml_home = Configure::read('xml_home');
        parent::__construct();
    }

    function determineClearStatus($invoice_id)
    {
        $this->unbindModel(array('hasMany' => array(
                                                'InvoicesTimecardReceiptLog',
                                                'EmployeesPayment',
                                                'InvoicesTimecardReminderLog',
                                                'InvoicesPostLog',
                                    ),),false);
        $this->bindModel(array('hasMany' => array(
                                                'InvoicesItem',
                                    ),),false);
        $this->InvoicesPayment->unbindModel(array('belongsTo' => array('Invoice'),),false);
        $this->InvoicesItem->unbindModel(array('belongsTo' => array('Invoice'),),false);
        $this->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
        $this->recursive=2;
        $invoice =  $this->read(null, $invoice_id);
        $paymentTotal = 0;
        foreach ($invoice['InvoicesPayment'] as $payment):
            $paymentTotal += $payment['amount'];
        endforeach;
        $balance = $invoice['Invoice']['amount']-$paymentTotal;
        if ($balance != 0)
        {
            $invoice['Invoice']['cleared']= 0;
            $invoice['Invoice']['cleared_date'] = '';
            $this->save($invoice);
        } else {
            $invoice['Invoice']['cleared']= 1;
            $invoice['Invoice']['cleared_date']= date('Y-m-d');

            //debug($invoice);
            $this->save($invoice);
            foreach ($invoice['InvoicesItem'] as $invoice_item):
                $invoice_item['cleared']=1;
                $save_item=array();
                $save_item['InvoicesItem'] = $invoice_item;
                //debug($save_item);

                $this->InvoicesItem->save($save_item);
                foreach($invoice_item['InvoicesItemsCommissionsItem'] as $commitem):
                    $commitem['cleared']  = 1;
                    $save_item=array();
                    $save_item['InvoicesItemsCommissionsItem'] = $commitem;
                    //debug($save_item);
                    $this->InvoicesItem->InvoicesItemsCommissionsItem->save($save_item);
                endforeach;
            endforeach;
            //exit;
        }
        return true;
    }
    function beforeSave() {
        $this->data['Invoice']['modified_date'] = date('Y-m-d H:m:s');
        return true;
    }
    function updateTotal($id = null) {
        if(!$this->set_invoice_clear_status($id)) # trigger to set cleared state, only recalculate if not cleared
        {
            $this->recursive = 1;
            $invoice = $this->read(null, $id);
            $invTotal = 0;
            foreach ($invoice['InvoicesItem'] as $invoiceItem):
               $exprate = $invoice['Invoice']['employerexpenserate'];
               $quantity = $invoiceItem['quantity'];
               $cost = $invoiceItem['cost'];
               $amount = $invoiceItem['amount'];
               $invTotal += $invoiceItem['quantity']*$invoiceItem['amount'];

            endforeach;
            $invoice['Invoice']['amount']= $invTotal;
            //debug($invoice) ;exit;
            $this->save($invoice['Invoice']);
        }
    }

    function updateCommTotal($id = null) {
        /*
         * fixme - make a shell for this
         */
        $this->recursive = 1;
        $invoice = $this->read(null, $id);

        foreach ($invoice['InvoicesItem'] as $invoiceItem):
            $exprate = $invoice['Invoice']['employerexpenserate'];
            $quantity = $invoiceItem['quantity'];
            $cost = $invoiceItem['cost'];
            $amount = $invoiceItem['amount'];

            $comms = $this->InvoicesItem->InvoicesItemsCommissionsItem->find('all',array('conditions'=>array('invoices_item_id'=> $invoiceItem['id'])));
            foreach ($comms as $comm):
                $commission_net_b4_employerexp = $amount	*$quantity-$cost*$quantity;
                $commission_employerexp = $commission_net_b4_employerexp*$exprate;
                $commission_undivided = $commission_net_b4_employerexp-$commission_employerexp;
                $percent = $comm['InvoicesItemsCommissionsItem']['percent'];
                $comm['InvoicesItemsCommissionsItem']['amount'] = round($commission_undivided *$percent/100,2);
                $comm['InvoicesItemsCommissionsItem']['date'] =$invoice['Invoice']['date'];


                $datea = array();
                $datea['month'] = date("m",strtotime($invoice['Invoice']['date']));
                $datea['year'] = date("Y",strtotime($invoice['Invoice']['date']));


                $comm['InvoicesItemsCommissionsItem']['commissions_report_id'] =
                        $this->commsComp->reportID_fromdate($datea);

                $comm['InvoicesItemsCommissionsItem']['commissions_reports_tag_id'] =
                        $this->CommissionsReportsTag->shell_tagID($comm['InvoicesItemsCommissionsItem']['employee_id'],$comm['InvoicesItemsCommissionsItem']['commissions_report_id']);
                $this->InvoicesItem->InvoicesItemsCommissionsItem->save($comm);
            endforeach;
        endforeach;
    }
    private function write_commissions($invoice)
    {
        /*
         * returns invoice total
         */

        $invTotal = 0;
        $this->CommissionsReport = new CommissionsReport;

        foreach ($invoice['InvoicesItem'] as $invoiceItem):
            $exprate = $invoice['Invoice']['employerexpenserate'];
            $quantity = $invoiceItem['quantity'];
            $cost = $invoiceItem['cost'];
            $amount = $invoiceItem['amount'];
            $invTotal += $invoiceItem['quantity']*$invoiceItem['amount'];
            $comms = $this->InvoicesItem->InvoicesItemsCommissionsItem->
                find('all',array('conditions'=>array('invoices_item_id'=> $invoiceItem['id'])));

            $emp = $this->ClientsContract->Employee->
                read(null, $invoice['ClientsContract']['employee_id']);

            foreach ($comms as $comm):

                $commission_net_b4_employerexp = $amount	*$quantity-$cost*$quantity;
                $commission_employerexp = $commission_net_b4_employerexp*$exprate;
                $commission_undivided = $commission_net_b4_employerexp-$commission_employerexp;
                $percent = $comm['InvoicesItemsCommissionsItem']['percent'];
                $comm['InvoicesItemsCommissionsItem']['amount'] = round($commission_undivided *$percent/100,2);
                $comm['InvoicesItemsCommissionsItem']['date'] =$invoice['Invoice']['date'];



                $datea = array();
                $datea['month'] = date("m",strtotime($invoice['Invoice']['date']));
                $datea['year'] = date("Y",strtotime($invoice['Invoice']['date']));


                $comm['InvoicesItemsCommissionsItem']['commissions_report_id'] =
                    $this->commsComp->reportID_fromdate($datea);


                $comm['InvoicesItemsCommissionsItem']['description'] = $emp['Employee']['firstname'].' '.
                    $emp['Employee']['lastname'].' - '.$invoiceItem['description'];
                $comm['InvoicesItemsCommissionsItem']['rel_inv_amt'] = $invoice['Invoice']['amount'];
                $comm['InvoicesItemsCommissionsItem']['rel_inv_line_item_amt'] =
                    $invoiceItem['quantity']*$invoiceItem['amount'];;
                $comm['InvoicesItemsCommissionsItem']['rel_item_amt'] =$invoiceItem['amount'];
                $comm['InvoicesItemsCommissionsItem']['rel_item_quantity'] =$invoiceItem['quantity'];
                $comm['InvoicesItemsCommissionsItem']['rel_item_cost'] =$invoiceItem['cost'];

                // What does shell_tagID do? Does it generate tag if one does not exist?
                // Does generate reminders setup tag?
		// fixme:
/*
                $comm['InvoicesItemsCommissionsItem']['commissions_reports_tag_id'] =
                    $this->CommissionsReportsTag->shell_tagID($comm['InvoicesItemsCommissionsItem']['employee_id'],
                        $comm['InvoicesItemsCommissionsItem']['commissions_report_id']);
*/
                $this->InvoicesItem->InvoicesItemsCommissionsItem->save($comm);
            endforeach;
        endforeach;
        return $invTotal;
    }
    function updateTotalPrepost($id = null) {
        /*
         * updates sales persons tags
         * commissions amounts
         * commissions adjustments
         * invoice amount
         *
         * called while viewing invoice
         */

        $this->recursive = 2;

        // Client
        $this->bindModel(array('hasMany' => array('InvoicesItem'),),false);
        $this->unbindModel(array('hasMany' => array('InvoicesTimecardReminderLog', 'InvoicesPostLog', 'InvoicesTimecardReceiptLog'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User'),),false);
        $this->InvoicesItem->unbindModel(array('belongsTo' => array('Invoice'),),false);

        $invoice = $this->read(null, $id);

        $invTotal = $this->write_commissions($invoice);

        $invoice['Invoice']['amount']= $invTotal;

        $this->save($invoice['Invoice']);
    }
    function generatepdf($id,$display= null,$xml_home)
    {

        /*
         * reset invoice amount in db and screen present the pdf
         */
        if (!$id) {
            $this->Session->setFlash(__('Invalid Invoice.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->updateTotalPrepost($id);
        $pdf = $this->rrg_pdf_file($id,$xml_home);
        if ($display!= null)
            $pdf->Output();

        return $pdf;
    }

    function m_generatepdf($id,$display= null, $xml_home)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Invoice.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->updateTotalPrepost($id);
        $pdf = $this->rrg_pdf_file($id,$xml_home);
        if ($display!= null)
            $invoice = $this->read(null, $id);
        $this->set('invoice', $invoice);
        // Contract
        $this->unbindContractModelForInvoicing();
        $contract =  $this->ClientsContract->read(null, $invoice['Invoice']['contract_id']);
        $client_id=$contract['ClientsContract']['client_id'];
        $employee_id=$contract['ClientsContract']['employee_id'];
        // Client
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsContract','ClientsManager','ClientsMemo','ClientsSearch'),),false);
        $client =  $this->ClientsContract->Client->read(null, $client_id); //debug($client);exit;
        // Employee
        $this->ClientsContract->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
        $employee =  $this->ClientsContract->Employee->read(null, $employee_id);

        App::import('Vendor','fpdf/fpdf');
        $datearray = explode('-',$invoice['Invoice']['date']);

        $filename =  $this->invoiceFunction->invoiceFilename($invoice,$employee);
        $file =  $this->invoiceFunction->invoiceFullyQualifiedFilename($invoice,$employee,$xml_home);


        header('Cache-Control: public'); // needed for i.e.
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename='.basename($file));


        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
    function void($id=null,$updown)
    {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Invoice', true));
            $this->redirect(array('action'=>'index'));
        }
        $commitemsave = array();
        $this->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ClientsManager'),),false);

        $this->unbindModel(array('belongsTo' => array('ClientsContract',),),false);
        $this->InvoicesItem->unbindModel(array('belongsTo' => array('Invoice',),),false);
        $inv = $this->read(null, $id);
        $inv['Invoice']['voided']   = $updown;
        $this->save($inv);
        foreach($inv['InvoicesItem'] as $item)
        {
            foreach($item['InvoicesItemsCommissionsItem'] as $commitem)
            {
                $commitemsave['InvoicesItemsCommissionsItem']['id'] = $commitem['id'];
                $commitemsave['InvoicesItemsCommissionsItem']['voided'] = $updown;
                $this->InvoicesItem->InvoicesItemsCommissionsItem->save($commitemsave);
            }
        }
        return true;
    }
    #
    # re-checks status of invoice
    #
    function set_invoice_clear_status($id = null) {
        $this->recursive = 2;
        $this->unbindModel(array('belongsTo' => array('ClientsContract',),),false);


        $this->bindModel(array('hasMany' => array('InvoicesPayment','InvoicesItem',),),false);
        $this->unbindModel(array('hasMany' => array('EmployeesPayment','InvoicesTimecardReminderLog', 'InvoicesPostLog',
            'InvoicesTimecardReceiptLog',),),false);
        $invoice = $this->read(null, $id);
        //debug($invoice); exit;
        if(isset($invoice['InvoicesItem']))
        {
            $invoice['Invoice']['amount'] = 0;
            foreach ($invoice['InvoicesItem'] as $item)
            {
                $invoice['Invoice']['amount'] += $item['quantity']*$item['amount'];
            }
            //debug($invoice);exit;
            $this->save($invoice);
        }
        if($invoice['Invoice']['posted'])
        {
            //$this->unbindModel(array('hasMany' => array('InvoicesPayment',),),false);
            $balance = $invoice['Invoice']['amount']; //debug($id);debug($invoice);exit;
            if(isset($invoice['InvoicesPayment']))
            {
                foreach ($invoice['InvoicesPayment'] as $pay):
                    $balance -= $pay['amount'];
                endforeach;
            }
            //debug(abs($balance));
            if (abs($balance) < .01)
            {
                $invoice['Invoice']['cleared'] = 1;
                $this->save($invoice); //debug($invoice);exit;
            }
        }
        return $invoice['Invoice']['cleared'];
    }
    function rrg_pdf_file($id,$xml_home)
    {
        Configure::write('debug', 2);
        $this->bindModel(array('hasMany' => array('InvoicesItem'),),false);
        $invoice = $this->read(null, $id);
        $this->set('invoice', $invoice);
        // Contract
        $this->unbindContractModelForInvoicing();
        $contract =  $this->ClientsContract->read(null, $invoice['Invoice']['contract_id']);
        $client_id=$contract['ClientsContract']['client_id'];
        $employee_id=$contract['ClientsContract']['employee_id'];
        // Client
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsContract','ClientsManager','ClientsMemo','ClientsSearch'),),false);
        $client =  $this->ClientsContract->Client->read(null, $client_id); //debug($client);exit;
        // Employee
        $this->ClientsContract->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesMemo','EmployeesPayment'),),false);
        $employee =  $this->ClientsContract->Employee->read(null, $employee_id);

        //debug($employee); debug($client); debug($invoice);
        App::import('Vendor','fpdf/fpdf');
        $datearray = explode('-',$invoice['Invoice']['date']);

        $pdf=new FPDF();

        $pdf->AddPage();
        $logofile = APP.WEBROOT_DIR.DS.'img'.DS.'RRG_LOGO_WEB.jpg';


        $pdf->Image($logofile,10,8,33,'JPEG');
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(140,10,'',0,0);
        $pdf->Cell(40,10,'Invoice '.$invoice['Invoice']['id'],0,1);
        $pdf->Cell(140,10,'',0,0);
        $pdf->Cell(30,10,'Date: '.$datearray[1].'/'.$datearray[2].'/'.$datearray[0],0,1);

        $pdf->Cell(40,15,'',0,1);
        $pdf->Cell(100,7,Configure::read('co_name'),0,0);
        $pdf->Cell(40,7,substr(strtoupper  ($client['Client']['name']),0,40),0,1);


        //$pdf->Cell(40,15,'','B',1);
        $pdf->Cell(100,7,Configure::read('co_street1'),0,0);
        $pdf->Cell(40,7,substr(strtoupper  ($client['Client']['street1']),0,40),0,1);

        //$pdf->Cell(40,15,'','B',1);
        $pdf->Cell(100,7,Configure::read('co_city').', '.Configure::read('co_state').' '.Configure::read('co_zip'),0,0);
        $pdf->Cell(40,7,
        substr(strtoupper  ($client['Client']['city']),0,40).', '.
        substr(strtoupper  ($client['State']['post_ab']),0,40).' '.
        substr(strtoupper  ($client['Client']['zip']),0,40)
        ,0,1);
        $pdf->Cell(40,10,'',0,1);
        $pdf->Cell(40,7,'Terms: NET '.$invoice['Invoice']['terms'],0,1);
        $datearray = getdate(strtotime($invoice['Invoice']['date']));
        $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))  , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
        $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $invoice['Invoice']['duedate'] = date('Y-m-d',$duedate);
        $datearray = getdate(strtotime($invoice['Invoice']['duedate']));
        $pdf->Cell(40,7,'Due Date: '.date('m',strtotime($datearray['month'])).'/'.$datearray['mday'].'/'.$datearray['year'],0,1);

        $startdatearray = explode('-',$invoice['Invoice']['period_start']);
        $enddatearray = explode('-',$invoice['Invoice']['period_end']);

        $pdf->Cell(40,15,'',0,1);
        $pdf->MultiCell(180,7,$invoice['ClientsContract']['title'],0,1);

        $pdf->Cell(40,15,'',0,1);
        $pdf->Cell(180,7,'During the period of: '.$startdatearray[1].'/'.$startdatearray[2].'/'.$startdatearray[0].' to '.$enddatearray[1].'/'.$enddatearray[2].'/'.$enddatearray[0].'.',0,1);
        $pdf->Cell(40,15,'',0,1);
        $pdf->Cell(5,7,'',0,0);
        $pdf->Cell(90,7,'Description','B',0,'C');
        $pdf->Cell(25,7,'Quantity','B',0,'C');
        $pdf->Cell(30,7,'Cost','B',0,'R');
        $pdf->Cell(35,7,'Subtotal','B',1,'R');

        $i = 0;
        $totalQuant = 0;
        foreach ($invoice['InvoicesItem'] as $InvoiceItem):
            //debug($InvoiceItem);
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            $totalQuant += $InvoiceItem['quantity'];
            $quant = sprintf("%8.2f",    $InvoiceItem['quantity']); // right-justification with spaces
            $cost = sprintf("%8.2f",    $InvoiceItem['amount']); // right-justification with spaces
            $subtotal = sprintf("%8.2f",    $InvoiceItem['quantity']*$InvoiceItem['amount']); // right-justification with spaces
            if ($subtotal != 0){
                $pdf->Cell(5,7,'',0,0);
                $pdf->Cell(90,7,$InvoiceItem['description'],'B',0);
                /*
                $pdf->Cell(20,7,$quant,'B',0,'R');
                $pdf->Cell(20,7,$cost,'B',0,'R');
                $pdf->Cell(35,7,$subtotal,'B',1,'R'); */
                $pdf->Cell(25,7,$quant,1,0,'R');
                $pdf->Cell(30,7,$cost,1,0,'R');
                $pdf->Cell(35,7,$subtotal,1,1,'R');
            }
        endforeach;
        $pdf->Cell(5,7,'',0,0);
        $pdf->Cell(90,7,'',0,0);
        $pdf->Cell(25,7,sprintf("%8.2f",$totalQuant),0,0,'R');
        $pdf->Cell(30,7,'',0,0,'R');
        $pdf->Cell(35,7,sprintf("%8.2f",$invoice['Invoice']['amount']),0,1,'R');

        $pdf->Ln();
        $pdf->MultiCell(180,7,'Reports To: '.$invoice['ClientsContract']['reports_to'].'.',0,1);
        $pdf->Ln();
        $pdf->MultiCell(180,7,$invoice['ClientsContract']['invoicemessage'],0,1);
        $pdf->Ln();
        $pdf->MultiCell(180,7,$invoice['Invoice']['message'],0,1);
        //Set font
        $pdf->SetFont('Arial','',8);

        $pdf->SetXY(40,265);$pdf->Cell(35,7,"bottom of invoice",'B',1,'R');

        $filename =  $this->invoiceFunction->invoiceFilename($invoice,$employee);
        $fully_qualified_filename =  $this->invoiceFunction->invoiceFullyQualifiedFilename($invoice,$employee,$xml_home);
        $pdf->SetTitle($filename);
        $pdf->Output($fully_qualified_filename,'F');

        return $pdf;
    }
    function rebuild_invoice($id = null)
    {
        $this->recursive = 2;
        $this->unbindContractModelForInvoiceRebuild();
        $invoice = $this->read(null, $id);
        //debug($invoice);exit;
        if(!$invoice['Invoice']['posted'])
        {
            # copy terms from contract
            $invoice['Invoice']['terms'] = $invoice['ClientsContract']['terms'];
            $invoice['Invoice']['po'] = $invoice['ClientsContract']['po'];
            $invoice['Invoice']['employerexp'] = $invoice['ClientsContract']['employerexp'];
            $this->save($invoice);
            # delete old items
            foreach ($invoice['InvoicesItem'] as $item):
                    $this->InvoicesItem->delete($item['id']);
            endforeach;
            # setup new items
                        //debug($items);exit;
            $count = 0;
            foreach ($invoice['ClientsContract']['ContractsItem'] as $item):
                if($item['active'] == 1)
                {
                    $itemResult = $this->ClientsContract->ContractsItem->read(null, $item['id']);
                    $invoicelineitem= array();
                    $invoicelineitem['InvoicesItem']['description'] = $itemResult['ContractsItem']['description'];
                    $invoicelineitem['InvoicesItem']['amount'] = $itemResult['ContractsItem']['amt'];
                    $invoicelineitem['InvoicesItem']['cost'] = $itemResult['ContractsItem']['cost'];
                    $invoicelineitem['InvoicesItem']['invoice_id'] = $id;
                    $invoicelineitem['InvoicesItem']['ordering'] = $itemResult['ContractsItem']['ordering'];

                    $this->InvoicesItem->create();
                    $this->InvoicesItem->save($invoicelineitem);
                    //debug($itemResult['ContractsItemsCommissionsItem']);exit;
                    if(!empty($itemResult['ContractsItemsCommissionsItem']))
                    {
                        foreach ($itemResult['ContractsItemsCommissionsItem'] as $citem):
                                $invlineitemcommslineitem = array();
                                $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['employee_id'] = $citem['employee_id'];
                                $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['percent'] = $citem['percent'];
                                $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['invoices_item_id'] =
                                                $this->InvoicesItem->getLastInsertID();


                                $datea = array();
                                $datea['month'] = date("m",strtotime($invoice['Invoice']['date']));
                                $datea['year'] = date("Y",strtotime($invoice['Invoice']['date']));

                                $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['commissions_report_id'] =
                                    $this->commsComp->reportID_fromdate($datea);

                                $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['commissions_reports_tag_id'] =
                                    $this->CommissionsReportsTag->shell_tagID($invlineitemcommslineitem['InvoicesItemsCommissionsItem']['employee_id'],
                                        $invlineitemcommslineitem['InvoicesItemsCommissionsItem']['commissions_report_id']);

                                $this->InvoicesItem->InvoicesItemsCommissionsItem->create();
                                $this->InvoicesItem->InvoicesItemsCommissionsItem->save($invlineitemcommslineitem);
                        endforeach;
                    }
                }
            endforeach;

            return true;
        } else {
            return false;
        }
    }
    // add invoice from javascript application
    function add_dynamic($formdata,$session) {
        if (!empty($formdata)) {

            App::import('Component', 'TokenHelper');
            $Tk = new TokenHelperComponent;
            $token = $Tk->generatePassword();			// Fill in new invoice looked up values from Clients Contracts
            $this->unbindContractModelForInvoicing();
            $clientsContract = $this->ClientsContract->find('all',
            array('conditions'=>array('ClientsContract.id'=>$formdata['Invoice']['contract_id'])));
            //debug($clientsContract[0]['ClientsContract']);
            $formdata['Invoice']['terms'] = $clientsContract[0]['ClientsContract']['terms'];
            $formdata['Invoice']['employerexpenserate'] = $clientsContract[0]['ClientsContract']['employerexp'];
            $formdata['Invoice']['po'] = $clientsContract[0]['ClientsContract']['po'];
            $formdata['Invoice']['date'] = date('Y-m-d H:m:s');
            $formdata['Invoice']['amount'] = 0;
            $formdata['Invoice']['created_date'] = date('Y-m-d');
            $formdata['Invoice']['modified_date'] = date('Y-m-d H:m:s');
            $formdata['Invoice']['token'] = $token;
            $formdata['Invoice']['view_count'] = 0;
            $formdata['Invoice']['mock'] = 0;
            foreach ($formdata['Item'] as $contractItem):
                $formdata['Invoice']['amount']+=$contractItem['amt']*$contractItem['cost'];
            endforeach;
            $this->create();
            $this->save($formdata);
            $invoiceID = $this->getLastInsertID();
            $session->setFlash(__('Invoice saved.', true));
            $invoiceID = $this->getLastInsertID();
            $this->ClientsContract->ContractsItem->unbindModel(array('hasMany' => array('ContractsItemsCommissionsItem'),),false);
            $this->ClientsContract->ContractsItem->unbindModel(array('belongsTo' => array('ClientsContract'),),false);
            $contractItems = $this->ClientsContract->ContractsItem->find('all',array('conditions'=>array('Contract_id'=>$formdata['Invoice']['contract_id'])));

            foreach ($formdata['Item'] as $contractItem):
                if($contractItem['id']!=99999)
                {
                    $item = array();
                    $this->InvoicesItem->create();
                    $item['InvoicesItem']['invoice_id']=$invoiceID;
                    $item['InvoicesItem']['amount']=$contractItem['amt'];
                    $item['InvoicesItem']['cost']=$contractItem['cost'];
                    $item['InvoicesItem']['quantity']=$contractItem['quantity'];
                    $item['InvoicesItem']['description']=$contractItem['description'];
                    $this->InvoicesItem->save($item);
                    $itemID = $this->InvoicesItem->getLastInsertID();
                    $this->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->unbindModel(array('belongsTo' => array('Employee','ContractsItems'),),false);
                    $commissionsItems = $this->ClientsContract->ContractsItem->ContractsItemsCommissionsItem->find('all',array('conditions'=>array('contracts_items_id'=>$contractItem['id'])));
                    foreach ($commissionsItems as $commissionsItem):
                        $commissionsItemInsert = array();
                        $this->InvoicesItem->InvoicesItemsCommissionsItem->create();
                        $commissionsItemInsert['InvoicesItemsCommissionsItem']['employee_id']=$commissionsItem['ContractsItemsCommissionsItem']['employee_id'];
                        $commissionsItemInsert['InvoicesItemsCommissionsItem']['invoices_item_id']=$itemID;
                        $commissionsItemInsert['InvoicesItemsCommissionsItem']['percent']=$commissionsItem['ContractsItemsCommissionsItem']['percent'];

                        $this->CommissionsReport = new CommissionsReport;
                        # if sql date format, convert to form date
                        if(substr($formdata['Invoice']['date'],4,1)=='-')
                        {
                            $date_exp = explode(' ',$formdata['Invoice']['date']);
                            $date_part = $date_exp[0];
                            $date_exp = explode('-',$date_part);
                            $commdate = array();
                            $commdate['year'] = $date_exp[0];
                            $commdate['month'] = $date_exp[1];
                            $commdate['day'] = $date_exp[2];
                        }
                        ;
                        $datea = array();
                        $datea['month'] = date("m",strtotime($commdate));
                        $datea['year'] = date("Y",strtotime($commdate));
                        $commissionsItemInsert['InvoicesItemsCommissionsItem']['commissions_report_id'] =
                            $this->commsComp->reportID_fromdate($datea);
                        $this->InvoicesItem->InvoicesItemsCommissionsItem->save($commissionsItemInsert);
                    endforeach;
                }
            endforeach;
            $this->void($invoiceID,$formdata['Invoice']['voided']) ;
            return $invoiceID;
        }
        return false;
    }
    function save_dynamic($formdata) {
        $msgs = array();
        if (!empty($formdata)) {
            $formdata['Invoice']['amount'] = 0;
            if(isset($formdata['Item']))
            {
                foreach ($formdata['Item'] as $invItem):
                    $formdata['Invoice']['amount']+=$invItem['quantity']*$invItem['amount'];
                endforeach;
            }
            $formdata['Invoice']['modified_date'] = date('Y-m-d H:m:s');

            $this->save($formdata);
            $msgs[] = 'Invoice saved.';
            if(isset($formdata['Item']))
            {
                foreach ($formdata['Item'] as $invItem):
                    $item = array();
                    $item['InvoicesItem']['invoice_id']=$formdata['Invoice']['id'];
                    $item['InvoicesItem']['id']=$invItem['id'];
                    $item['InvoicesItem']['amount']=$invItem['amount'];
                    $item['InvoicesItem']['cost']=$invItem['cost'];
                    $item['InvoicesItem']['quantity']=$invItem['quantity'];
                    $item['InvoicesItem']['description']=$invItem['description'];
                    $this->InvoicesItem->save($item);
                endforeach;
            }

            return array($formdata['Invoice']['id'], $msgs);
        }
        return array(false, Null);
    }

    function save_dynamic_ajax($formdata, $session) {

        if (!empty($formdata)) {
            $formdata['Invoice']['amount'] = 0;
            if(isset($formdata['Invoice']['InvoicesItem']['id']))
            {
                $i = 0 ;
                foreach ($formdata['Invoice']['InvoicesItem']['id'] as $invItem):
                    $formdata['Invoice']['amount']+= $formdata['Invoice']['InvoicesItem']['quantity'][$i] * $formdata['Invoice']['InvoicesItem']['amount'][$i];
                    $i++;
                endforeach;
            }
            $formdata['Invoice']['modified_date'] = date('Y-m-d H:m:s');
            $this->save($formdata);
            $session->setFlash(__('Invoice saved.', true));
            if(isset($formdata['Invoice']['InvoicesItem']['id']))
            {
                $i = 0 ;
                foreach ($formdata['Invoice']['InvoicesItem']['id'] as $invItem):
                    $item = array();
                    $item['InvoicesItem']['invoice_id']=$formdata['Invoice']['id'];
                    $item['InvoicesItem']['id']=$formdata['Invoice']['InvoicesItem']['id'][$i];
                    $item['InvoicesItem']['amount']=$formdata['Invoice']['InvoicesItem']['amount'][$i];
                    $item['InvoicesItem']['cost']=$formdata['Invoice']['InvoicesItem']['cost'][$i];
                    $item['InvoicesItem']['quantity']=$formdata['Invoice']['InvoicesItem']['quantity'][$i];
                    $item['InvoicesItem']['description']=$formdata['Invoice']['InvoicesItem']['description'][$i];
                    debug($item);
                    $this->InvoicesItem->save($item);
                    $i++;
                endforeach;
            }
            return $formdata['Invoice']['id'];
        }
        return false;
    }
    public function getInvoiceReview($id)
    {
        /*
         * called before looking at invoice, updates total and gets invoice information with minimum db hits
         */
        $this->updateTotal($id);
        $this->recursive = 1;
        $this->bindModel(array('belongsTo' => array('ClientsContract'=> array('className' => 'ClientsContract',
                                'foreignKey' => 'contract_id',
                                'conditions' => '',
                                'fields' => '',
                                'order' => ''
            )),),false);
        $this->unbindModel(array('hasMany' => array('InvoicesItem'),),false);
        $result = $this->read(null,$id);
        $this->ClientsContract->Employee->unbindModel(array('hasMany' => array('ClientsContract','EmployeesPayment','EmployeesMemo','EmployeesEmail', 'CommissionsReportsTag',
            'EmployeesLetter', 'CommissionsPayment', 'Note', 'Expense', 'NotesPayment', 'InvoicesItemsCommissionsItem', 'EmployeesMemo'),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsContract','ClientsManager','ClientsMemo','ClientsCheck','ClientsSearch'),),false);
        $result['Employee'] = $this->ClientsContract->Employee->read(null,$result['ClientsContract']['employee_id']);
        $result['Client'] = $this->ClientsContract->Client->read(null,$result['ClientsContract']['client_id']);
        //$this->InvoicesItem->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem'),),false);
        //$this->InvoicesItem->unbindModel(array('belongsTo' => array('Invoice'),),false);

        $items = $this->InvoicesItem->find('all', array('conditions' => array('invoice_id'=>$id),
                                                        'order' =>array('ordering ASC'),
                                                        )); //debug($items);exit;

        foreach($items as $item)
        {

            $result['InvoicesItem'][] = $item['InvoicesItem'];

        }

        return $result;
    }
/* delete when not in use */
    function getInvoiceOldEdit($id)
    {
        $this->recursive = 1;
        $this->bindModel(array('belongsTo' => array('ClientsContract'=> array('className' => 'ClientsContract',
                                'foreignKey' => 'contract_id',
                                'conditions' => '',
                                'fields' => '',
                                'order' => ''
            )),),false);
        $this->unbindModel(array('hasMany' => array('InvoicesItem'),),false);
        $result = $this->read(null,$id); //debug($result);exit;
        $this->ClientsContract->Employee->unbindModel(array('hasMany' => array('Note','EmployeesLetter', 'CommissionsPayment', 'NotesPayment', 'InvoicesItemsCommissionsItem', 'CommissionsReportsTag','Expense','ClientsContract','EmployeesPayment','EmployeesMemo','EmployeesEmail'),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsContract','ClientsManager','ClientsMemo','ClientsCheck','ClientsSearch'),),false);
        $result['Employee'] = $this->ClientsContract->Employee->read(null,$result['ClientsContract']['employee_id']);
        $result['Client'] = $this->ClientsContract->Client->read(null,$result['ClientsContract']['client_id']);
        $this->InvoicesItem->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem'),),false);
        $this->InvoicesItem->unbindModel(array('belongsTo' => array('Invoice'),),false);

        $items = $this->InvoicesItem->find('all', array('conditions' => array('invoice_id'=>$id),
                                                        'order' =>array('ordering ASC'),
                                                        )); //debug($items);exit;

        foreach($items as $item)
        {
            $item = $this->InvoicesItem->read(null, $item['InvoicesItem']['id']);
            $result['InvoicesItem'][] = $item['InvoicesItem'];

        }//;debug($result);exit;
        return $result;
    }
    /*
     * getInvoiceRec - returns just the basic amount of information about an invoice
     */
    function getInvoiceRec($id)
    {

        $this->unbindContractModelForInvoicing();

        $this->unbindModel(array('belongsTo' => array('ClientsContract',),),false);
        $this->unbindModel(array('hasMany' => array('InvoicesTimecardReminderLog', 'InvoicesPostLog', 'InvoicesTimecardReceiptLog',),),false);
        return($this->read(null,$id));
    }
    function open_invoices()
    {
        App::import('Component', 'DateFunction');
        App::import('Component', 'InvoiceFunction');
        $dateF = new DateFunctionComponent();
        $invF = new InvoiceFunctionComponent();
        $this->recursive = 2;
        $this->unbindContractModelForInvoicing();
        $this->unbindModel(array('hasMany' =>
                        array(
                                'InvoicesItem',
                                'InvoicesPayment',
                                'EmployeesPayment',
                                'ClientsManager'),),false);

        $this->ClientsContract->Client->unbindModel(array('hasMany' => array(
            'ClientsManager',
        ),),false);

        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array(
            'ClientsManager',
        ),),false);
        $open = $this->find('all', array(
                                                'conditions'=>array('voided'=>0,
                                                                    'cleared'=>0,
                                                                    'posted'=>1,
                                                                    'mock' => 0,
                                                                    'amount >0'),
                                                        'fields'=>array(
                                                        'Invoice.id',
                                                        'Invoice.period_start',
                                                        'Invoice.period_end',
                                                        'Invoice.date',
                                                        'Invoice.terms',
                                                        'Invoice.notes',
                                                        'Invoice.amount',
                                                        'Invoice.contract_id',
                                                        'Invoice.voided',
                                                        'ClientsContract.employee_id'),
                                                'order'=>array('Invoice.date DESC')
                                                        )
                                                    );
        $count = 0;
        foreach ($open as $invoice):
            $datearray = getdate(strtotime($invoice['Invoice']['date']));
            $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))  , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
            $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
            $open[$count]['Invoice']['duedate'] = date('Y-m-d',$duedate);
            $open[$count]['Invoice']['dayspast'] = $dateF->dateDiff(date('Y-m-d',$duedate),date('Y-m-d',$today));
            if ($duedate < mktime(0, 0, 0, date("m")  , date("d"), date("Y")))
            {
                $open[$count]['Invoice']['pastdue'] = 1;
            } else
            {
                $open[$count]['Invoice']['pastdue'] = 0;
            }
            $count++;
        endforeach;
        return $open;
    }
    function timecard_receipts($sent=0)
    {
        App::import('Component', 'DateFunction');
        App::import('Component', 'InvoiceFunction');
        $dateF = new DateFunctionComponent();
        $invF = new InvoiceFunctionComponent();
        $this->recursive = 2;
        $this->unbindContractModelForInvoicing();
        $this->unbindModel(array('hasMany' =>
                        array(
                                'InvoicesItem',
                                'InvoicesPayment',
                                'EmployeesPayment',
                                'InvoicesTimecardReminderLog',
                                'InvoicesPostLog',
                                'ClientsManager'),),false);
        $open = $this->find('all', array(
                                                'conditions'=>array('voided'=>0,
                                                                    'cleared'=>0,
                                                                    'posted'=>1,
                                                                    'timecard_receipt_sent'=>$sent,
                                                                    'prcleared'=>0,
                                                                    'amount >0'),
                                                        'fields'=>array(
                                                        'Invoice.id',
                                                        'Invoice.period_start',
                                                        'Invoice.period_end',
                                                        'Invoice.date',
                                                        'Invoice.terms',
                                                        'Invoice.notes',
                                                        'Invoice.amount',
                                                        'Invoice.contract_id',
                                                        'Invoice.voided',
                                                        'ClientsContract.employee_id'),
                                                'order'=>array('Invoice.date DESC')
                                                        )
                                                    );
        return $open;
    }
    function cleared_invoices()
    {
        $this->unbindContractModelForInvoicing();
        $this->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment','EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog','ClientsManager'),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager', ),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager',),),false);
        $cleared = $this->find('all', array(
                                                'conditions'=>array('voided'=>0,'posted'=>1,'cleared'=>1,
                                                                        'mock' => 0,),
                                                        'fields'=>array(
                                                        'Invoice.id',
                                                        'Invoice.period_start',
                                                        'Invoice.period_end',
                                                        'Invoice.date',
                                                        'Invoice.terms',
                                                        'Invoice.notes',
                                                        'Invoice.amount',
                                                        'Invoice.contract_id',
                                                        'ClientsContract.employee_id'),
                                                'order'=>array('Invoice.date ASC'),
                                                        )
                                                    );
        $count = 0;
        foreach ($cleared as $invoice):
            $datearray = getdate(strtotime($invoice['Invoice']['date']));
            $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))   , $datearray['mday']+$invoice['Invoice']['terms'], $datearray['year']);
            $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
            $cleared[$count]['Invoice']['duedate'] = date('Y-m-d',$duedate);
            $count++;
        endforeach;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $this->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment','EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'
        ,'ClientsManager'),),false);
        return $cleared;
    }

    public function unbindContractModelForCaching()
    {
        $this->unbindModel(array('hasMany' => array('InvoicesPayment','InvoicesItem','EmployeesPayment',),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('State','Period','Employee','Client',),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User',),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),),false);
        $this->InvoicesTimecardReminderLog->unbindModel(array('belongsTo' => array('Invoice',),),false);
        $this->InvoicesPostLog->unbindModel(array('belongsTo' => array('Invoice',),),false);
        $this->InvoicesTimecardReceiptLog->unbindModel(array('belongsTo' => array('Invoice',),),false);
    }

    /*
    select_reminders - supports only the Ajax caches
    */
    public function select_reminders()
    {

        $this->recursive = 2;
        $this->unbindContractModelForCaching();
        $oneYearback = mktime(0, 0, 0, date("m")  , date("d")-360, date("Y"));
        $sixtyDaysback = mktime(0, 0, 0, date("m")  , date("d")-60, date("Y"));
        $tomorrow = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
        $fortydaysahead = mktime(0, 0, 0, date("m")  , date("d")+40, date("Y"));
        /*
         * this $reminders is used for both future reminders into next period, current period, and periods past
        */
        $reminders =  $this->find('all', array('conditions'=>array(
            'and' => array(
                array('period_end <= ' => date('Y-m-d',$fortydaysahead),
                    'period_start >= ' => date('Y-m-d',$sixtyDaysback)
                ) ,
                'voided'=>0,'mock'=>0,'cleared'=>0,'posted'=>0,'timecard'=> 0, 'contract_id > 0',
            )),
            'fields'=>array(
                'Invoice.id',
                'Invoice.period_start',
                'Invoice.period_end',
                'Invoice.date',
                'Invoice.amount',
                'Invoice.notes',
                'Invoice.contract_id',
                'Invoice.timecard',
                'Invoice.voided',
                'Invoice.terms',
                'ClientsContract.id',
                'ClientsContract.employee_id',
                'ClientsContract.client_id'),
            'order'=>array('Invoice.date DESC')
        ));

        $opens =  $this->find('all', array('conditions'=>array(
            'and' => array(
                array('period_end <= ' => date('Y-m-d',$tomorrow),
                    'period_start >= ' => date('Y-m-d',$sixtyDaysback)
                ) ,
                'voided'=>0,'mock'=>0,'cleared'=>0,'amount > 0','posted'=>1, 'contract_id > 0',
            )),
            'fields'=>array(
                'Invoice.id',
                'Invoice.period_start',
                'Invoice.period_end',
                'Invoice.date',
                'Invoice.amount',
                'Invoice.notes',
                'Invoice.contract_id',
                'Invoice.timecard',
                'Invoice.voided',
                'Invoice.terms',
                'ClientsContract.id',
                'ClientsContract.employee_id',
                'ClientsContract.client_id'),
            'order'=>array('Invoice.date DESC')
        ));

        $timecards =  $this->find('all', array('conditions'=>array(
            'and' => array(
                array('period_end <= ' => date('Y-m-d',$fortydaysahead),
                    'period_start >= ' => date('Y-m-d',$sixtyDaysback)
                ) ,
                'voided'=>0,'mock'=>0,'timecard'=>1,'cleared'=>0,'posted'=>0, 'contract_id > 0',
            )),
            'fields'=>array(
                'Invoice.id',
                'Invoice.period_start',
                'Invoice.period_end',
                'Invoice.date',
                'Invoice.amount',
                'Invoice.notes',
                'Invoice.contract_id',
                'Invoice.timecard',
                'Invoice.voided',
                'Invoice.terms',
                'ClientsContract.id',
                'ClientsContract.employee_id',
                'ClientsContract.client_id'),
            'order'=>array('Invoice.date DESC')
        ));

        $voids =  $this->find('all', array('conditions'=>array(
            'and' => array(
                array('period_end <= ' => date('Y-m-d',$tomorrow),
                    'period_start >= ' => date('Y-m-d',$sixtyDaysback)
                ) ,
                'voided'=>1,'mock'=>0, 'contract_id > 0',
            )),
            'fields'=>array(
                'Invoice.id',
                'Invoice.period_start',
                'Invoice.period_end',
                'Invoice.date',
                'Invoice.amount',
                'Invoice.notes',
                'Invoice.contract_id',
                'Invoice.timecard',
                'Invoice.voided',
                'Invoice.terms',
                'ClientsContract.id',
                'ClientsContract.employee_id',
                'ClientsContract.client_id'),
            'order'=>array('Invoice.date DESC')
        ));

        $timecard_receipts_pending = $this->timecard_receipts();
        $timecard_receipts_sent = $this->timecard_receipts(1);

        return array('reminders'=>$reminders, 'timecards'=>$timecards, 'opens'=>$opens, 'voids'=>$voids,
            'timecard_receipts_pending'=>$timecard_receipts_pending, 'timecard_receipts_sent'=>$timecard_receipts_sent
        );
    }

    public function voided_invoices()
    {
        $this->recursive = 1;
        $this->unbindContractModelForInvoicing();
        $this->unbindModel(array('hasMany' =>array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager',),),false);
        $voided = $this->select_reminders(1);
        return $voided['voids'];
    }

    function timecards($reminders)
    {
        return $timecards;
    }
    function unbindEmployeeModelForInvoicing()
    {
            $this->ClientsContract->Employee->unbindModel(
                array('hasMany' => array('ClientsContract',
                                        'Expense',
                                        'EmployeesMemo',
                                        'EmployeesPayment'),),false
            );
    }
    function employeeForInvoicing($id)
    {
        $this->unbindEmployeeModelForInvoicing();
        return $this->ClientsContract->Employee->read(null, $id);
    }
    function unbindClientModelForInvoicing()
    {
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsContract','ClientsManager','ClientsMemo','ClientsSearch'),),false);
    }
    function clientForInvoicing($id)
    {
        $this->unbindClientModelForInvoicing();
        return $this->ClientsContract->Client->read(null, $id);
    }
    function unbindContractModelForInvoicing()
    {
        $this->unbindModel(array('hasMany' => array('InvoicesItem','InvoicesPayment','EmployeesPayment',),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('State','Period','Employee','Client',),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User',),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),),false);
        $this->InvoicesTimecardReceiptLog->unbindModel(array('belongsTo' => array('Invoice',),),false);
        $this->InvoicesPostLog->unbindModel(array('belongsTo' => array('Invoice',),),false);
        $this->InvoicesTimecardReceiptLog->unbindModel(array('belongsTo' => array('Invoice',),),false);
    }
    function unbindForInvoiceIndexApp()
    {
        $this->unbindModel(array('hasMany' => array('InvoicesPayment','EmployeesPayment',),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice','ContractsItem'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('State','Period','Employee','Client',),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager','User',),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsManager',),),false);
    }
    function unbindContractModelForInvoiceRebuild()
    {
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('State','Period'),),false);
    }
    function contractForInvoicing($id)
    {
        $this->unbindContractModelForInvoicing();
        $this->ClientsContract->bindModel(array('hasAndBelongsToMany' =>
            array('ClientsManager'=> array(
                'className' => 'ClientsContract',
                'joinTable' => 'contracts_managers',
                'foreignKey' => 'manager_id',
                'associationForeignKey' => 'contract_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'deleteQuery' => '',
                'insertQuery' => ''
            ))
        ,),false);
        $this->ClientsContract->bindModel(array('hasAndBelongsToMany' =>

            array('User'=>array(
                'className' => 'User',
                'joinTable' => 'contracts_users',
                'foreignKey' => 'contract_id',
                'associationForeignKey' => 'user_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'deleteQuery' => '',
                'insertQuery' => ''
            ))
        ,),false);
        return $this->ClientsContract->read(null, $id);
    }
    function clientsPendingInvoices($id)
    {
        $this->ClientsContract->Client->recursive = 2;
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('ClientsManager'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $this->unbindModel(array('hasMany' => array('InvoicesItem','EmployeesPayment','InvoicesTimecardReminderLog','InvoicesPostLog'),),false);
        $this->ClientsContract->Client->ClientsCheck->unbindModel(array('hasMany' => array('InvoicesPayment'),),false);
        $this->ClientsContract->Client->ClientsCheck->InvoicesPayment->unbindModel(array('belongsTo' => array('Invoice', 'ClientsCheck'),),false);
        $this->ClientsContract->Client->unbindModel(array('hasMany' => array('ClientsCheck','ClientsContract','ClientsManager','ClientsMemo','ClientsSearch',),),false);
        $this->ClientsContract->Client->State->unbindModel(array('hasMany' => array('Client','Employee','Vendor'),),false);
        $this->ClientsContract->unbindModel(array('belongsTo' => array('Client','Period'),),false);
        $this->ClientsContract->unbindModel(array('hasMany' => array('ContractsItem'),),false);
        $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array('User'),),false);
        $this->data = $this->ClientsContract->Client->read(null, $id);
        $this->recursive = 2;
        $invoices = $this->find('all', array('order' =>'date DESC','conditions'=>array('ClientsContract.client_id'=>$id,'Invoice.voided'=>0,'Invoice.posted'=>0,'Invoice.cleared'=>0,'Invoice.timecard'=>1)));
        return $invoices;
    }
    function paychecks_due()
    {
        $this->unbindModel(array('hasMany' => array(
        'InvoicesPayment',
        'InvoicesTimecardReminderLog',
        'InvoicesPostLog',
                ),),false);
        $this->recursive = 1;
        $invoices = $this->find('all', array(
                                                'conditions'=>array('voided'=>0,'posted'=>1,'prcleared'=>0,
                                                        ),
                                                        'fields'=>array(
                                                        'Invoice.id',
                                                        'Invoice.period_start',
                                                        'Invoice.period_end',
                                                        'Invoice.date',
                                                        'Invoice.terms',
                                                        'Invoice.amount',
                                                        'Invoice.contract_id',
                                                        'Invoice.notes',
                                                        'Invoice.prcleared ',
                                                        'ClientsContract.employee_id'),
                                                'order'=>array('Invoice.period_end ASC'),
                                                        )
                                                    ); //debug($invoices);exit;

        $paychecks = array();
        $count = 0;
        foreach ($invoices as $invoice):
            $this->prclear($invoice['Invoice']['id'],$invoice);
            $empPaymentTotal = 0;
            foreach ($invoice['EmployeesPayment'] as $empPayment):
                $empPaymentTotal +=  $empPayment['amount'];
            endforeach;
            $timecardpay = 0;
            foreach ($invoice['InvoicesItem'] as $paytype):
                $timecardpay +=  round($paytype['quantity']* $paytype['cost'],2);
            endforeach;
            $balance =  $timecardpay- $empPaymentTotal ;
            if ($balance >0 )
            {
                $this->EmployeesPayment->Employee->unbindModel(array('belongsTo' =>
                                array('State'),),false);
                $this->EmployeesPayment->Employee->unbindModel(array('hasMany' =>
                                array('ClientsContract','EmployeesMemo',
                                'EmployeesPayment','EmployeesEmail'),),false);
                $employee = $this->EmployeesPayment->Employee->find('all',
                                    array('conditions'=>array('Employee.id'=>$invoice['ClientsContract']['employee_id'])));
                //debug($invoice);exit;

                $paychecks[$count]['Paycheck'] = array(
                        'balance'=>$balance,
                        'period_start'=>$invoice['Invoice']['period_start'],
                        'period_end'=>$invoice['Invoice']['period_end'],
                        'period_end'=>$invoice['Invoice']['period_end'],
                        'invoice_id'=>$invoice['Invoice']['id'],
                        'notes'=>$invoice['Invoice']['notes'],
                'employee_id'=>$invoice['ClientsContract']['employee_id'],
                        'firstname'=>$employee[0]['Employee']['firstname'],
                        'lastname'=>$employee[0]['Employee']['lastname'],
                        'nickname'=>$employee[0]['Employee']['nickname'],
                        'direct_deposit'=>$employee[0]['Employee']['directdeposit'],
                'ssn'=>str_replace('-','',$employee[0]['Employee']['ssn_crypto']),
                'Invoice' =>$invoice['Invoice'],
                 );
                $count++;
            }
        endforeach;
        return $paychecks;
    }
    function employee_posted_invoices($employee_id)
    {
        $this->unbindModel(array('hasMany' => array(
                'InvoicesPayment',
                'InvoicesTimecardReminderLog',
                'InvoicesPostLog',
                'InvoicesTimecardReceiptLog'
                ),),false);
        $this->bindModel(array('hasMany' => array(
        'InvoicesItem',
                ),),false);
        $this->recursive = 1;
        $invoices = $this->find('all', array(
                                                'conditions'=>array('ClientsContract.employee_id'=>$employee_id,
                                                                    'Invoice.amount >0',
                                                                    'Invoice.voided'=>0,
                                                                ),
                                                        'fields'=>array(
                                                        'Invoice.id',
                                                        'Invoice.period_start',
                                                        'Invoice.period_end',
                                                        'Invoice.date',
                                                        'Invoice.terms',
                                                        'Invoice.prcleared',
                                                        'Invoice.amount',
                                                        'Invoice.contract_id',
                                                        'Invoice.notes',
                                                        'ClientsContract.employee_id'),
                                                'order'=>array('Invoice.period_end ASC'),
                                                        )
                                                    ); //debug($invoices);exit;
        return $invoices;
    }

    function get_employee_skipped_timecards($employee_id)
    {
        $this->unbindModel(array('hasMany' => array(
            'InvoicesPayment',
            'InvoicesTimecardReminderLog',
            'InvoicesPostLog',
            'InvoicesTimecardReceiptLog',
            'EmployeesPayment'
        ),),false);
        $this->bindModel(array('hasMany' => array(
            'InvoicesItem',
        ),),false);
        $this->recursive = 1;
        $invoices = $this->find('all', array(
                'conditions'=>array('ClientsContract.employee_id'=>$employee_id,
                    'Invoice.mock' =>0,
                    'Invoice.voided'=>1,
                ),
                'fields'=>array(
                    'Invoice.id',
                    'Invoice.period_start',
                    'Invoice.period_end',
                    'Invoice.date',
                    'Invoice.terms',
                    'Invoice.prcleared',
                    'Invoice.voided',
                    'Invoice.amount',
                    'Invoice.contract_id',
                    'Invoice.notes',
                    'ClientsContract.employee_id'),
                'order'=>array('Invoice.period_end ASC'),
            )
        ); //debug($invoices);exit;
        return $invoices;
    }
    function format_paycheck($invoice,$employee,$balance,$prcleared)
    {
        $payroll_id = 0;
        if(!empty($invoice['EmployeesPayment']))
        {
            $payroll_id = $invoice['EmployeesPayment'][0]['payroll_id'];
            $ref = $invoice['EmployeesPayment'][0]['ref'];
        }else {
        $ref = 'undefined';
    }
        return array(
                        'amountdue'=>$balance,
                        'prcleared'=>$prcleared,
                        'payroll_id' =>$payroll_id,
                        'balance'=>$balance,
                        'period_start'=>$invoice['Invoice']['period_start'],
                        'period_end'=>$invoice['Invoice']['period_end'],
                        'date'=>$invoice['Invoice']['date'],
                        'invoice_id'=>$invoice['Invoice']['id'],
                        'notes'=>$invoice['Invoice']['notes'],
                        'employee_id'=>$invoice['ClientsContract']['employee_id'],
                        'firstname'=>$employee['Employee']['firstname'],
                        'lastname'=>$employee['Employee']['lastname'],
                        'nickname'=>$employee['Employee']['nickname'],
                        'direct_deposit'=>$employee['Employee']['directdeposit'],
                        'ssn'=>str_replace('-','',$employee['Employee']['ssn_crypto']),
                        'ref'=>str_replace('-','',$ref),
                        'Invoice' =>$invoice['Invoice'],
            'InvoicesItem' =>$invoice['InvoicesItem'],
                 );
    }
    function employee_paychecks_due($employee_id,$employee)
    {

        $this->unbindModel(array('hasMany' =>
            array('InvoicesPostLog','InvoicesTimecardReceiptLog',
                'InvoicesTimecardReminderLog'),),false);
        $invoices = $this->find('all', array(
                                                'conditions'=>array('ClientsContract.employee_id'=>$employee_id,
                                                                    'Invoice.amount >0',
                                                                    'Invoice.voided'=>0,
                                                                ),
                                                        'fields'=>array(
                                                        'Invoice.id',
                                                        'Invoice.period_start',
                                                        'Invoice.period_end',
                                                        'Invoice.date',
                                                        'Invoice.terms',
                                                        'Invoice.prcleared',
                                                        'Invoice.amount',
                                                        'Invoice.contract_id',
                                                        'Invoice.notes',
                                                        'ClientsContract.employee_id'),
                                                'order'=>array('Invoice.period_end ASC'),
                                                        )
                                                    ); //deb

        # QUERY
        $invoices = $this->employee_posted_invoices($employee_id); //debug($invoices);exit;
        $paychecks_due = array();
        $duecount = 0;
        $paychecks_paid = array();
        $paidcount = 0;
        foreach ($invoices as $invoice):
            $empPaymentTotal = 0;
            foreach ($invoice['EmployeesPayment'] as $empPayment):
                $empPaymentTotal +=  $empPayment['amount'];
            endforeach;
            $timecardpay = 0;
            foreach ($invoice['InvoicesItem'] as $paytype):
                $timecardpay +=  round($paytype['quantity']* $paytype['cost'],2);
            endforeach;
            $balance =  $timecardpay- $empPaymentTotal ;

            $prcleared = $this->prclear($invoice['Invoice']['id'],$invoice);
            if ($balance >0 )
            {
                $paychecks_due[$duecount]['Paycheck'] = $this->format_paycheck($invoice,$employee,$balance,$prcleared);
                $duecount++;
            }
        endforeach;
        return $paychecks_due;
    }
    function employee_paychecks_paid($employee_id,$employee)
    {
        $invoices = $this->employee_posted_invoices($employee_id); //debug($invoices);exit;
        $paychecks_due = array();
        $duecount = 0;
        $paychecks_paid = array();
        $paidcount = 0;
        foreach ($invoices as $invoice):
            //debug($invoice);exit;
            if($invoice['Invoice']['prcleared'])
            {
                $empPaymentTotal = 0;
                foreach ($invoice['EmployeesPayment'] as $empPayment):
                    $empPaymentTotal +=  $empPayment['amount'];
                endforeach;
                $timecardpay = 0;
                foreach ($invoice['InvoicesItem'] as $paytype):
                    $timecardpay +=  round($paytype['quantity']* $paytype['cost'],2);
                endforeach;
                $balance =  $timecardpay- $empPaymentTotal ;
                $prcleared = $this->prclear($invoice['Invoice']['id'],$invoice);
                $paychecks_paid[$paidcount]['Paycheck'] = $this->format_paycheck($invoice,$employee,$balance,$prcleared);
                $paidcount++;
            }
        endforeach;
        return $paychecks_paid;
    }

    function employee_skipped_timecards($employee_id)
    {
        $invoices = $this->get_employee_skipped_timecards($employee_id); //debug($invoices);exit;
        $paychecks_due = array();
        $duecount = 0;
        $skipped_timecards = array();
        $skipcount = 0;
        $now = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));;
        foreach ($invoices as $invoice):

            $end_date_array = explode('-',$invoice['Invoice']['period_end']);
            $period_end = mktime(0, 0, 0, $end_date_array[1]  , $end_date_array[2], $end_date_array[0]);;

            if($invoice['Invoice']['voided'] && $now > $period_end)
            {
                $skipped_timecards[$skipcount]['Paycheck'] = $invoice;
                $skipcount++;
            }
        endforeach;
        return $skipped_timecards;
    }
    function prclear($id,$invoice)
    {
        //$invoice = $this->read(null,$id);
        if($invoice['Invoice']['prcleared']==0)
        {
            $empPaymentTotal = 0;
            foreach ($invoice['EmployeesPayment'] as $empPayment):
                $empPaymentTotal +=  $empPayment['amount'];
            endforeach;
            $timecardpay = 0;
            foreach ($invoice['InvoicesItem'] as $paytype):
                $timecardpay +=  round($paytype['quantity']* $paytype['cost'],2);
            endforeach;
            $balance =  $timecardpay- $empPaymentTotal ;
            if ($balance <= 0 )
            {
                $invoice['Invoice']['prcleared'] = 1;
                $this->save($invoice);
                return 1;
            }
            return 0;
        }
        return 1;
    }

    function wc_analysis()
    {
        $this->recursive =2;
        $this->ClientsContract->unbindModel(array('hasMany' => array('Invoice'),),false);
        $invoices = $this->find('all',array('conditions'=>array('date BETWEEN STR_TO_DATE("07-10-2013","%d-%m-%Y") AND STR_TO_DATE("07-10-2014","%d-%m-%Y")',
        'posted'=> 1, 'voided'=>0, 'mock'=>0,
        'cleared'=>1, 'prcleared'=>1)));
        $this->ClientsContract->Employee->State->unbindModel(array('hasMany' => array('Client','Vendor','Employee'),),false);
        $conA = array();
        $empA = array();
        $EMPA = array();
        $stateA = array();
        foreach( $invoices as $inv)
        { //debug($inv);exit;
            if(!in_array($inv['Invoice']['contract_id'],$conA) )
            {
                array_push($conA, $inv['Invoice']['contract_id']) ;
            }
            if(!in_array($inv['ClientsContract']['employee_id'],$empA) )
            {
                array_push($empA, $inv['ClientsContract']['employee_id']) ;
                $EMPA[$inv['ClientsContract']['employee_id']] = $inv['ClientsContract']['Employee'];
            }
            if(!in_array($inv['ClientsContract']['Employee']['state_id'],$stateA) )
            {
                array_push($stateA, $inv['ClientsContract']['Employee']['state_id']) ;
                $State = $this->ClientsContract->Employee->State->read(null,$inv['ClientsContract']['Employee']['state_id']);
                $state = $State['State'];
                $STATEA[$inv['ClientsContract']['Employee']['state_id']] = $state;
            }
        }
        /*debug($invoices);
        debug($conA);
        debug($empA);
        debug($stateA); */
        $statePRA = array();
        foreach($stateA as $state)
        {
            $statePRA[$state] = 0;
            foreach( $invoices as $inv)
            {

                if($inv['ClientsContract']['Employee']['state_id']==$state)
                {
                    $pr = 0 ;
                    foreach( $inv['InvoicesItem'] as $item)
                    {
                        $pr = $pr + $item['quantity']*$item['cost'];
                    }
                    $statePRA[$state] = $statePRA[$state] +$pr;
                }
            }
        }
        foreach($empA as $emp)
        {
            $empPR_reg = 0;
            $empPR_ot = 0;
            $empPR_dt = 0;
            $empPR = 0;
            foreach( $invoices as $inv)
            {

                if($inv['ClientsContract']['employee_id']==$emp)
                {
                    $pr = 0 ;
                    $pr_reg = 0 ;
                    $pr_ot = 0 ;
                    $pr_dt = 0 ;
                    foreach( $inv['InvoicesItem'] as $item)
                    {
debug($item['description']);
                        if ($inv['voided'] != 1)
                        {
                            if ($item['description'] == 'Regular')
                                $pr_reg = $pr + $item['quantity']*$item['cost'];
                            if ($item['description'] == 'Overtime')
                                $pr_ot = $pr + $item['quantity']*$item['cost'];
                            if ($item['description'] == 'Double')
                                $pr_dt = $pr + $item['quantity']*$item['cost'];
                        }
                    }
                    $empPR_reg = $empPR_reg+$pr_reg;
                    $empPR_ot = $empPR_ot+$pr_ot;
                    $empPR_dt = $empPR_dt+$pr_dt;
                }
            }
            $EMPA[$emp]['PR_reg'] = $empPR_reg;
            $EMPA[$emp]['PR_ot'] = $empPR_ot;
            $EMPA[$emp]['PR_dt'] = $empPR_dt;
            $EMPA[$emp]['PR'] = $EMPA[$emp]['PR_reg'] + $EMPA[$emp]['PR_ot'] + $EMPA[$emp]['PR_dt'];
        }
        /*debug($statePRA);

        debug($EMPA);
        debug($STATEA); */
        echo '<table>';
        foreach($EMPA as $emp)
        {
            echo '<tr>';
            echo '<td>'.$emp['firstname'].' '.$emp['lastname'].'</td><td>'.$emp['PR_reg'].'</td><td>'.$emp['PR_ot'].'</td><td>'.$emp['PR_dt'].'</td><td>'.$emp['PR'].'</td><td>'.$STATEA[$emp['state_id']]['name'].'</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<table>';
        foreach($STATEA as $state)
        {
            echo '<tr>';
            echo '<td>'.$STATEA[$state['id']]['name'].'</td><td>'.$statePRA[$state['id']].'</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    function invoice_slug($invoice, $employee)
    {
        $slug = urlencode  (str_replace(' ','_',str_replace(':','_',str_replace('/','_',$this->invoiceFunction->email_subject($invoice, $employee)))));
        //debug($slug);exit;
        return $slug;
    }

    function fixmockinvoice($id, $clientsContract ,$webroot)
    {
        if (! $this->data = $this->read(null, $id))
        {

            App::import('Component', 'TokenHelper');
            $Tk = new TokenHelperComponent;
            $token = $Tk->generatePassword();

            $contract = array();
            $contract['ClientsContract'] = $clientsContract['ClientsContract'];
            $invoice['Invoice']['terms'] = $contract['ClientsContract']['terms'];
            $contractID = $contract['ClientsContract']['id'];
            $invoice['Invoice']['contract_id'] = $contractID;
            $invoice['Invoice']['employerexpenserate'] = $contract['ClientsContract']['employerexp'];

            $invoice['Invoice']['date'] = date("Y-m-d");
            $invoice['Invoice']['period_start'] = date("Y-m-d");
            $invoice['Invoice']['period_end'] = date("Y-m-d");
            $invoice['Invoice']['mock'] = 1;

            $invoice['Invoice']['created_date'] = date('Y-m-d');
            $invoice['Invoice']['token'] = $token;
            $invoice['Invoice']['view_count'] = 0;
            $invoice['Invoice']['voided'] = 1;
            $user = 1;
            $invoice['Invoice']['modified_user_id'] = $contract['ClientsContract']['created_user_id'];
            $invoice['Invoice']['created_user_id'] = $contract['ClientsContract']['created_user_id'];

            $this->create();
            if ($this->save($invoice)) {

                $employee =  $this->employeeForInvoicing($this->data['ClientsContract']['employee_id']);

                $invoice['Invoice']['id'] = $this->getLastInsertID();
                $subject = $this->invoiceFunction->email_subject($invoice, $employee);
                $invoiceurltoken = $this->invoiceFunction->invoiceTokenUrl($this->data,$subject,$webroot,$employee);
                $invoice['Invoice']['urltoken'] = $invoiceurltoken;
                $this->save($invoice);
                $invID =$invoice['Invoice']['id'] ;
                $this->ClientsContract->log('The Mock Invoice '.$invID.' has been saved', 'debug');

                $contract['ClientsContract']['mock_invoice_id'] = $invID;
                $contractstrt = $contract['ClientsContract']['startdate'];

                $datearray = explode('-',$contract['ClientsContract']['startdate']);

                $contract['ClientsContract']['startdate'] = $datearray[0].'/'.$datearray[1].'/'.$datearray[2];
                if ($this->ClientsContract->save($contract)) {

                    $this->ClientsContract->log('The Mock Invoice '.$invID.'has been recorded in the contract '.$contractID, 'debug');

                } else {
                    $this->ClientsContract->log('The Mock Invoice could not be recorded in the contract', 'debug');

                }
            }
        }

    }

    function mark_posted($id)
    {
        $invoice['Invoice']['id']   = $id;
        $invoice['Invoice']['posted']   = 1;
        //$invoice['Invoice']['date']   =date('Y-m-d');
        $this->save($invoice);
        $invoice = $this->read(null, $id);
        return $invoice;
    }

}

?>
