<?php

App::import('Component', 'Email');
App::import('Model', 'Invoice');
App::import('Component', 'InvoiceFunction');

App::import('Component', 'Json');
App::import('Component', 'Employee');
App::import('Component', 'Commissions');
App::import('Component', 'HashUtils');
App::import('Component', 'Datasources');

App::import('Component', 'FixtureDirectories');


App::import('Model', 'cache/invoice');
App::import('Model', 'InvoicesItemsCommissionsItem');
App::import('Model', 'CommissionsReport');
App::import('Model', 'CommissionsPayment');
App::import('Model', 'Note');
App::import('Model', 'NotesPayment');
class TimecardReceiptComponent extends Object {

    //
    public function __construct() {

        $this->Email = new EmailComponent;
        $this->dirComp = new FixtureDirectoriesComponent;
        $this->empModel = new Employee;
        $this->hu = new HashUtilsComponent;
        $this->commsComp = new CommissionsComponent;
        $this->dsComp = new DatasourcesComponent;

        $this->invoiceFunction = new InvoiceFunctionComponent;

        $this->xml_home = Configure::read('xml_home');

        $this->server = Configure::read('server');
        $this->Invoice = new Invoice;
        $this->commItemModel = new InvoicesItemsCommissionsItem;
        $this->commPayModel = new CommissionsPayment;
        $this->noteModel = new Note;
        $this->notesPaymentModel = new NotesPayment;

        parent::__construct();
    }

    function send_timecard_receipt($id=null)
    {

        $this->Invoice->recursive = 1;
        $this->data = $this->Invoice->read(null, $id);
        $employee=$this->Invoice->ClientsContract->Employee->read(null, $this->data['ClientsContract']['employee_id']);
        $invoice['Invoice']=$this->data['Invoice'];
        $period = $this->invoiceFunction->period_formatted($invoice);
        $this->Email->subject = $employee['Employee']['firstname'].' '.
            $employee['Employee']['lastname'].": Timecard receipt for the period ".$period[0].' to '.$period[1];

        $this->Email->body = '<table cellpadding = "3" cellspacing = "3" border=1>';
        foreach ($this->data['InvoicesItem'] as $item)
        {
            if ($item['quantity'])
            {
                $this->Email->body .= "<tr>";
                $this->Email->body .= "<td>";
                $this->Email->body .= $item['description'];
                $this->Email->body .= "</td><td align=right>";
                $this->Email->body .= sprintf('%8.2f',round($item['quantity'],2));
                $this->Email->body .= "</td>";
                $this->Email->body .= "</tr>";
            }
        }
        $this->Email->body .= "</table>";
        $this->Email->body .= "<br>Thanks<br>Monica Fey";
        $this->Email->from         = 'timecards@rocketsredglare.com';
        $this->Email->fromName     = "Rockets Redglare Timecards";
        foreach ($employee['EmployeesEmail'] as $email):
            $this->Email->to = $email['email'];
            $this->Email->toName = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];

            $result = $this->Email->send();
            $this->Invoice->InvoicesTimecardReceiptLog->create();
            $reminderlog = array();
            $reminderlog['InvoicesTimecardReceiptLog']['invoice_id'] = $this->data['Invoice']['id'];
            $reminderlog['InvoicesTimecardReceiptLog']['email'] = $email['email'];
            $reminderlog['InvoicesTimecardReceiptLog']['timestamp'] = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
            $this->Invoice->InvoicesTimecardReceiptLog->save($reminderlog);

        endforeach;
        $this->Email->to = 'timecards@rocketsredglare.com';
        $result = $this->Email->send();
        $this->Email->to = 'timecardtest@fogtest.com';
        $result = $this->Email->send();
        $this->data['Invoice']['timecard_receipt_sent'] = 1;
        $this->Invoice->save($this->data);
        return ;

    }
}