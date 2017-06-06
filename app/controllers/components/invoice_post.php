<?php
/*
 * giving the business logic for soap invoice post it's own fil
 */


App::import('Component', 'InvoiceFunction');

App::import('Component', 'Json');
App::import('Component', 'Employee');
App::import('Component', 'Email');
App::import('Component', 'Commissions');
App::import('Component', 'HashUtils');
App::import('Component', 'Datasources');
App::import('Component', 'Xml');
App::import('Component', 'FixtureDirectories');


App::import('Model', 'cache/invoice');
App::import('Model', 'InvoicesItemsCommissionsItem');
App::import('Model', 'CommissionsReport');
App::import('Model', 'CommissionsPayment');
App::import('Model', 'Note');
App::import('Model', 'NotesPayment');
App::import('Model', 'Invoice');

class InvoicePostComponent extends Object {
    //
    public function __construct() {

        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->empModel = new Employee;
        $this->hu = new HashUtilsComponent;
        $this->commsComp = new CommissionsComponent;
        $this->dsComp = new DatasourcesComponent;

        $this->jsonComp = new JsonComponent;
        $this->Email = new EmailComponent;

        $this->invoiceFunction = new InvoiceFunctionComponent;

        $this->xml_home = Configure::read('xml_home');
        $this->webroot = Configure::read('server');
        $this->commItemModel = new InvoicesItemsCommissionsItem;
        $this->commPayModel = new CommissionsPayment;
        $this->noteModel = new Note;
        $this->notesPaymentModel = new NotesPayment;
        $this->Invoice = new Invoice;
        parent::__construct();
    }
    public function post($id)
    {


        $invoice = $this->Invoice->mark_posted($id);

        // Contract
        $contract =  $this->Invoice->contractForInvoicing($invoice['Invoice']['contract_id']);
        // Client
        $client =  $this->Invoice->clientForInvoicing($contract['ClientsContract']['client_id']);
        // Employee
        $employee =  $this->Invoice->employeeForInvoicing($contract['ClientsContract']['employee_id']);

        $filename = 'rocketsredglare_invoice_'.$invoice['Invoice']['id'].'_'.$employee['Employee']['firstname'].'_'.$employee['Employee']['lastname'].'_'.$invoice['Invoice']['period_start'].'_to_'.$invoice['Invoice']['period_end'].'.pdf';
        $this->Invoice->generatepdf($invoice['Invoice']['id'],null, $this->xml_home);

        $this->Email->to = 'invoicetest@fogtest.com';
        $this->Email->toName = 'Invoice Tester';

        $subject = $this->invoiceFunction->email_subject($invoice, $employee);
        $filename = $this->invoiceFunction->invoiceFilename($invoice,$employee);
        $fully_qualified_filename =$this->invoiceFunction->invoiceFullyQualifiedFilename($invoice,$employee,$this->xml_home);
        $this->Email->subject = $subject;
        $this->Email->from         = 'timecards@rocketsredglare.com';
        $this->Email->fromName     = "Rockets Redglare Invoices";
        $this->Email->attach($fully_qualified_filename, $filename);

        $emailbody = $this->invoiceFunction->emailBody($invoice, $subject, $employee, $this->webroot);

        $this->Email->body = $emailbody;
        $result = $this->Email->send();
        foreach ($contract['ClientsManager'] as $email):
            $this->Email->to = $email['email'];
            $this->Email->toName = $email['firstname'].' '.$email['firstname'];
            $result = $this->Email->send();
            $this->Invoice->InvoicesPostLog->create();
            $reminderlog = array();
            $reminderlog['InvoicesPostLog']['invoice_id'] = $invoice['Invoice']['id'];
            $reminderlog['InvoicesPostLog']['email'] = $email['email'];
            $reminderlog['InvoicesPostLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
            $this->Invoice->InvoicesPostLog->save($reminderlog);
        endforeach;
        foreach ($contract['User'] as $email):
            $this->Email->toName = $email['firstname']. ' '.$email['lastname'];
            $this->Email->to = $email['email'];
            $result = $this->Email->send();
            $this->Invoice->InvoicesPostLog->create();
            $reminderlog = array();
            $reminderlog['InvoicesPostLog']['invoice_id'] = $invoice['Invoice']['id'];
            $reminderlog['InvoicesPostLog']['email'] = $email['email'];
            $reminderlog['InvoicesPostLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
            $this->Invoice->InvoicesPostLog->save($reminderlog);
        endforeach;
        //$this->redirect(array('action'=>'timecards'));


        $this->jsonComp->move_timecard_to_open($id);
    }

}