<?php

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


class XmlComponent
{

    public function __construct() {

        $this->dirComp = new FixtureDirectoriesComponent;

        $this->hu = new HashUtilsComponent;
        $this->commsComp = new CommissionsComponent;
        $this->dsComp = new DatasourcesComponent;

    }
    /*
     * serialize_employeeS - used to create xml fixtures for active and inactive employees.
     * presumably used  in UI
     */
    public function serialize_employees($actives)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */

        // setup document root 'employees'

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        $root = $doc->createElement('employees');
        $root = $doc->appendChild($root);

        foreach ($actives['employees'] as $emp)
        {
            $employee = $doc->createElement('employee');
            $employee->setAttribute('name',$emp['name']);
            $employeenode =  $root->appendChild($employee);
            //$employee->appendChild($employeenode);
            $text = $doc->createTextNode( (string) $emp['id']);
            $employeenode->appendChild($text);
        }
        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $dategenerated->appendChild($text);
        return $doc->saveXML();
    }
    /*
     * add_field adds a field to a parent node
     */
    private function add_field($doc, $root, $field_name, $data)
    {
        $new_element = $doc->createElement($field_name);
        $root->appendChild($new_element);


        $text = $doc->createTextNode( (string) $data);
        $text = $new_element->appendChild($text);

    }
    private function add_id_list_to_element($doc,$new_element, $list)
    {
        if(!empty($list))
        {
            foreach($list as $data)
            {
                $this->add_field($doc, $new_element, 'id', $data);
            }
        }
    }
    /*
     * serialize_employee - serializes all employees individally
     */
    public function serialize_employee($emp)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */

        // setup document root 'employees'

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        $root = $doc->createElement('employee');
        $doc->appendChild($root);

        $this->add_field($doc, $root, 'id', $emp['Employee']['id']);
        $this->add_field($doc, $root, 'slug', $emp['Employee']['slug']);
        $this->add_field($doc, $root, 'username', $emp['Employee']['username']);

        $this->add_field($doc, $root, 'firstname', $emp['Employee']['firstname']);
        $this->add_field($doc, $root, 'lastname', $emp['Employee']['lastname']);
        $this->add_field($doc, $root, 'mi', $emp['Employee']['mi']);
        $this->add_field($doc, $root, 'nickname', $emp['Employee']['nickname']);
        $this->add_field($doc, $root, 'ssn_crypto', $emp['Employee']['ssn_crypto']);
        $this->add_field($doc, $root, 'dob', $emp['Employee']['dob']);

        $this->add_field($doc, $root, 'enddate', $emp['Employee']['enddate']);

        $this->add_field($doc, $root, 'startdate', $emp['Employee']['startdate']);

        $this->add_field($doc, $root, 'street1', $emp['Employee']['street1']);
        $this->add_field($doc, $root, 'street2', $emp['Employee']['street2']);
        $this->add_field($doc, $root, 'city', $emp['Employee']['city']);
        $this->add_field($doc, $root, 'state_id', $emp['Employee']['state_id']);
        $this->add_field($doc, $root, 'zip', $emp['Employee']['zip']);
        $this->add_field($doc, $root, 'bankaccountnumber_crypto', $emp['Employee']['bankaccountnumber_crypto']);


        $this->add_field($doc, $root, 'bankaccounttype', $emp['Employee']['bankaccounttype']);


        $this->add_field($doc, $root, 'bankname', $emp['Employee']['bankname']);


        $this->add_field($doc, $root, 'bankroutingnumber_crypto', $emp['Employee']['bankroutingnumber_crypto']);


        $this->add_field($doc, $root, 'directdeposit', $emp['Employee']['directdeposit']);

        $this->add_field($doc, $root, 'allowancefederal', $emp['Employee']['allowancefederal']);

        $this->add_field($doc, $root, 'allowancestate', $emp['Employee']['allowancestate']);
        $this->add_field($doc, $root, 'extradeductionfed', $emp['Employee']['extradeductionfed']);
        $this->add_field($doc, $root, 'extradeductionstate', $emp['Employee']['extradeductionstate']);
        $this->add_field($doc, $root, 'maritalstatusfed', $emp['Employee']['maritalstatusfed']);
        $this->add_field($doc, $root, 'maritalstatusstate', $emp['Employee']['maritalstatusstate']);
        $this->add_field($doc, $root, 'usworkstatus', $emp['Employee']['usworkstatus']);
        $this->add_field($doc, $root, 'notes', $emp['Employee']['notes']);
        $this->add_field($doc, $root, 'tcard', $emp['Employee']['tcard']);
        $this->add_field($doc, $root, 'active', $emp['Employee']['active']);
        $this->add_field($doc, $root, 'voided', $emp['Employee']['voided']);
        $this->add_field($doc, $root, 'w4', $emp['Employee']['w4']);
        $this->add_field($doc, $root, 'de34', $emp['Employee']['de34']);
        $this->add_field($doc, $root, 'i9', $emp['Employee']['i9']);

        $this->add_field($doc, $root, 'medical', $emp['Employee']['medical']);
        $this->add_field($doc, $root, 'indust', $emp['Employee']['indust']);
        $this->add_field($doc, $root, 'info', $emp['Employee']['info']);
        $this->add_field($doc, $root, 'phone', $emp['Employee']['phone']);

        $this->add_field($doc, $root, 'salesforce', $emp['Employee']['salesforce']);

        $this->add_field($doc, $root, 'created_date', $emp['Employee']['created_date']);

        $this->add_field($doc, $root, 'modified_date', $emp['Employee']['modified_date']);

        $this->add_field($doc, $root, 'created_user_id', $emp['Employee']['created_user_id']);
        $this->add_field($doc, $root, 'modified_user_id', $emp['Employee']['modified_user_id']);
        $this->add_field($doc, $root, 'last_sync_time', $emp['Employee']['last_sync_time']);

        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $dategenerated->appendChild($text);


        $new_element = $doc->createElement('profile');
        $this->add_field($doc, $new_element, 'id', $emp['Profile']['id']);
        $root->appendChild($new_element);

        $new_element = $doc->createElement('contracts');
        $this->add_id_list_to_element($doc,$new_element, $emp['ClientsContract']);
        $root->appendChild($new_element);
        $new_element = $doc->createElement('letters');
        $this->add_id_list_to_element($doc,$new_element, $emp['EmployeesLetter']);
        $root->appendChild($new_element);
        $new_element = $doc->createElement('memos');
        $this->add_id_list_to_element($doc,$new_element, $emp['EmployeesMemo']);
        $root->appendChild($new_element);
        $new_element = $doc->createElement('payments');
        $this->add_id_list_to_element($doc,$new_element, $emp['EmployeesPayment']);
        $root->appendChild($new_element);
        $new_element = $doc->createElement('emails');

        $this->add_id_list_to_element($doc,$new_element, $emp['EmployeesEmail']);

        $root->appendChild($new_element);
        $new_element = $doc->createElement('commissions-payments');
        $this->add_id_list_to_element($doc,$new_element, $emp['CommissionsPayment']);
        $root->appendChild($new_element);
        $new_element = $doc->createElement('notes');
        $this->add_id_list_to_element($doc,$new_element, $emp['Note']);
        $root->appendChild($new_element);
        $new_element = $doc->createElement('notes-payments');
        $this->add_id_list_to_element($doc,$new_element, $emp['NotesPayment']);
        $root->appendChild($new_element);
        $new_element = $doc->createElement('expenses');
        $this->add_id_list_to_element($doc,$new_element, $emp['Expense']);
        $root->appendChild($new_element);
        $new_element = $doc->createElement('commissions');
        $this->add_id_list_to_element($doc,$new_element, $emp['InvoicesItemsCommissionsItem']);
        $root->appendChild($new_element);

        return $doc->saveXML();
    }
    public function employee_dropdown()
    {
        /* read cached employee xml file constructs dropdown of active employees */

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // We don't want to bother with white spaces
        $doc->preserveWhiteSpace = false;

        $this->xml_home = Configure::read('xml_home');
        $xml = $doc->load($this->xml_home.'employees/actives.xml');
        $xpath = new DOMXPath($doc);
        // We starts from the root element
        $query = "/employees/employee";

        $employees = $xpath->query($query);
        $empRes = array();

        foreach( $employees as $employee)
        {
            $key = (int)$employee->nodeValue;
            $value = (string)$employee->getAttribute('name');
            $empRes[$key] =  $value;
        }
        return $empRes;
    }



    public function serialize_ar($ar)
    {

        // setup document root 'client'

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        $invs = $doc->createElement('invoices');
        $doc->appendChild($invs);

        $invs = $doc->createElement('all');
        $doc->appendChild($invs);

        foreach ($ar['all'] as $inv)
        {
            $id = $doc->createElement('id');
            $idnode =  $invs->appendChild($id);
            $text = $doc->createTextNode( (string) $inv);
            $text = $idnode->appendChild($text);
        }


        $invs = $doc->createElement('open');
        $invs = $doc->appendChild($invs);

        foreach ($ar['open'] as $inv)
        {
            $id = $doc->createElement('id');
            $idnode =  $invs->appendChild($id);
            //$employee->appendChild($employeenode);
            $text = $doc->createTextNode( (string) $inv);
            $text = $idnode->appendChild($text);
        }


        $invs = $doc->createElement('pastdue');
        $invs = $doc->appendChild($invs);



        foreach ($ar['pastdue'] as $inv)
        {
            $id = $doc->createElement('id');
            $idnode =  $invs->appendChild($id);
            //$employee->appendChild($employeenode);
            $text = $doc->createTextNode( (string) $inv);
            $text = $idnode->appendChild($text);
        }



        $invs = $doc->createElement('cleared');
        $invs = $doc->appendChild($invs);

        foreach ($ar['cleared'] as $inv)
        {
            $id = $doc->createElement('id');
            $idnode =  $invs->appendChild($id);
            //$employee->appendChild($employeenode);
            $text = $doc->createTextNode( (string) $inv);
            $text = $idnode->appendChild($text);
        }
        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $doc->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);
        return $doc->saveXML();
    }

    public function serialize_invoice($invoice)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('invoice');
        $doc->appendChild($root);

        $this->add_field($doc, $root, 'id', $invoice['Invoice']['id']);


        $this->add_field($doc, $root, 'contract_id', $invoice['Invoice']['contract_id']);

        $this->add_field($doc, $root, 'date', $invoice['Invoice']['date']);

        $this->add_field($doc, $root, 'po', $invoice['Invoice']['po']);

        $this->add_field($doc, $root, 'employerexpenserate', $invoice['Invoice']['employerexpenserate']);

        $this->add_field($doc, $root, 'terms', $invoice['Invoice']['terms']);

        $this->add_field($doc, $root, 'timecard', $invoice['Invoice']['timecard']);

        $this->add_field($doc, $root, 'notes', $invoice['Invoice']['notes']);

        $this->add_field($doc, $root, 'period_start', $invoice['Invoice']['period_start']);

        $this->add_field($doc, $root, 'period_end', $invoice['Invoice']['period_end']);

        $this->add_field($doc, $root, 'posted', $invoice['Invoice']['posted']);

        $this->add_field($doc, $root, 'cleared', $invoice['Invoice']['cleared']);

        if($invoice['Invoice']['cleared'] == '1')
        {
            $this->add_field($doc, $root, 'cleared_date', $invoice['Invoice']['cleared_date']);
        } else {
            $this->add_field($doc, $root, 'cleared_date', '');
        }

        $this->add_field($doc, $root, 'prcleared', $invoice['Invoice']['prcleared']);

        $this->add_field($doc, $root, 'timecard_receipt_sent', $invoice['Invoice']['timecard_receipt_sent']);

        $this->add_field($doc, $root, 'message', $invoice['Invoice']['message']);

        $this->add_field($doc, $root, 'amount', $invoice['Invoice']['amount']);

        $this->add_field($doc, $root, 'voided', $invoice['Invoice']['voided']);

        $this->add_field($doc, $root, 'token', $invoice['Invoice']['token']);

        $this->add_field($doc, $root, 'view_count', $invoice['Invoice']['view_count']);

        $this->add_field($doc, $root, 'mock', $invoice['Invoice']['mock']);

        $this->add_field($doc, $root, 'timecard_document', $invoice['Invoice']['timecard_document']);

        $this->add_field($doc, $root, 'created_date', $invoice['Invoice']['created_date']);

        $this->add_field($doc, $root, 'modified_date', $invoice['Invoice']['modified_date']);

        $this->add_field($doc, $root, 'created_user_id', $invoice['Invoice']['created_user_id']);

        $this->add_field($doc, $root, 'modified_user_id', $invoice['Invoice']['modified_user_id']);

        $this->add_field($doc, $root, 'last_sync_time', $invoice['Invoice']['last_sync_time']);

        $this->add_field($doc, $root, 'duedate', $invoice['Invoice']['duedate']);

        $this->add_field($doc, $root, 'pdf_file_name', $invoice['Invoice']['pdf_file_name']);

        $this->add_field($doc, $root, 'employee', $invoice['Invoice']['employee']);

        $this->add_field($doc, $root, 'employee_id', $invoice['Invoice']['employee_id']);



        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);

        $new_element = $doc->createElement('invoice-items');
        $this->add_id_list_to_element($doc, $new_element, $invoice['InvoicesItem']);
        $root->appendChild($new_element);

        $new_element = $doc->createElement('invoice-payments');
        $this->add_id_list_to_element($doc, $new_element, $invoice['InvoicesPayment']);
        $root->appendChild($new_element);

        $new_element = $doc->createElement('employee-payments');
        $this->add_id_list_to_element($doc, $new_element, $invoice['EmployeesPayment']);
        $root->appendChild($new_element);

        return $doc->saveXML();
    }


    public function serialize_invoice_item($item)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('invoices-item');
        $doc->appendChild($root);

        $this->add_field($doc, $root, 'id', $item['InvoicesItem']['id']);
        $this->add_field($doc, $root, 'invoice_id', $item['InvoicesItem']['invoice_id']);

        $this->add_field($doc, $root, 'description', $item['InvoicesItem']['description']);

        $this->add_field($doc, $root, 'amount', $item['InvoicesItem']['amount']);

        $this->add_field($doc, $root, 'quantity', $item['InvoicesItem']['quantity']);

        $this->add_field($doc, $root, 'cost', $item['InvoicesItem']['cost']);

        $this->add_field($doc, $root, 'ordering', $item['InvoicesItem']['ordering']);

        $this->add_field($doc, $root, 'cleared', $item['InvoicesItem']['cleared']);



        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);

        $new_element = $doc->createElement('invoice-commissions-items');
        $items = array();
        foreach($item['InvoicesItemsCommissionsItem'] as $iitem)
        {
            $items[] = $iitem['id'];
        }

        $new_element = $doc->createElement('payments');
        $this->add_id_list_to_element($doc, $new_element, $items);
        $root->appendChild($new_element);

        return $doc->saveXML();
    }

    public function serialize_invoice_commissions_item($item)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('invoices-items-commissions-item');
        $doc->appendChild($root);
        $this->add_field($doc, $root, 'id', $item['InvoicesItemsCommissionsItem']['id']);
        $this->add_field($doc, $root, 'employee_id', $item['InvoicesItemsCommissionsItem']['employee_id']);
        $this->add_field($doc, $root, 'invoices_item_id', $item['InvoicesItemsCommissionsItem']['invoices_item_id']);
        $this->add_field($doc, $root, 'invoice_id', $item['InvoicesItem']['invoice_id']);

        $this->add_field($doc, $root, 'commissions_report_id', $item['InvoicesItem']['invoice_id']);


        $this->add_field($doc, $root, 'description', $item['InvoicesItemsCommissionsItem']['description']);
        $this->add_field($doc, $root, 'date', $item['InvoicesItemsCommissionsItem']['date']);

        $this->add_field($doc, $root, 'percent', $item['InvoicesItemsCommissionsItem']['percent']);
        $this->add_field($doc, $root, 'amount', $item['InvoicesItemsCommissionsItem']['amount']);
        $this->add_field($doc, $root, 'rel_inv_amt', $item['InvoicesItemsCommissionsItem']['rel_inv_amt']);
        $this->add_field($doc, $root, 'rel_inv_line_item_amt', $item['InvoicesItemsCommissionsItem']['rel_inv_line_item_amt']);
        $this->add_field($doc, $root, 'rel_item_amt', $item['InvoicesItemsCommissionsItem']['rel_item_amt']);
        $this->add_field($doc, $root, 'rel_item_quantity', $item['InvoicesItemsCommissionsItem']['rel_item_quantity']);
        $this->add_field($doc, $root, 'rel_item_cost', $item['InvoicesItemsCommissionsItem']['rel_item_cost']);
        $this->add_field($doc, $root, 'rel_item_amt', $item['InvoicesItemsCommissionsItem']['rel_item_amt']);
        $this->add_field($doc, $root, 'cleared', $item['InvoicesItemsCommissionsItem']['cleared']);
        $this->add_field($doc, $root, 'voided', $item['InvoicesItemsCommissionsItem']['voided']);



        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();

    }
    public function serialize_profile($item)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('profile');

        $doc->appendChild($root);
        $this->add_field($doc, $root, 'id', $item['Profile']['id']);
        $this->add_field($doc, $root, 'employee_id', $item['Profile']['employee_id']);
        $this->add_field($doc, $root, 'user_id', $item['Profile']['user_id']);
        $this->add_field($doc, $root, 'sphene_id', $item['Profile']['sphene_id']);


        $this->add_field($doc, $root, 'released_cat_id', $item['Profile']['released_cat_id']);

        $this->add_field($doc, $root, 'released_cat_thread_id', $item['Profile']['released_cat_thread_id']);


        $this->add_field($doc, $root, 'internal_cat_id', $item['Profile']['internal_cat_id']);
        $this->add_field($doc, $root, 'internal_cat_thread_id', $item['Profile']['internal_cat_thread_id']);



        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();
    }
    public function serialize_clients_check($item)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('clients-check');

        $doc->appendChild($root);
        $this->add_field($doc, $root, 'id', $item['ClientsCheck']['id']);
        $this->add_field($doc, $root, 'client_id', $item['ClientsCheck']['client_id']);
        $this->add_field($doc, $root, 'number', $item['ClientsCheck']['number']);
        $this->add_field($doc, $root, 'amount', $item['ClientsCheck']['amount']);


        $this->add_field($doc, $root, 'notes', $item['ClientsCheck']['notes']);

        $this->add_field($doc, $root, 'date', $item['ClientsCheck']['date']);


        $this->add_field($doc, $root, 'created_date', $item['ClientsCheck']['created_date']);
        $this->add_field($doc, $root, 'created_user_id', $item['ClientsCheck']['created_user_id']);
        $this->add_field($doc, $root, 'modified_date', $item['ClientsCheck']['modified_date']);
        $this->add_field($doc, $root, 'modified_user_id', $item['ClientsCheck']['modified_user_id']);



        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();
    }

    public function serialize_client($client)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */
        //debug($client);
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('client');

        $doc->appendChild($root);
        $this->add_field($doc, $root, 'id', $client['Client']['id']);
        $this->add_field($doc, $root, 'name', $client['Client']['name']);
        $this->add_field($doc, $root, 'state', $client['Client']['state_id']);
        $this->add_field($doc, $root, 'street1', $client['Client']['street1']);
        $this->add_field($doc, $root, 'street2', $client['Client']['street2']);
        $this->add_field($doc, $root, 'city', $client['Client']['city']);
        $this->add_field($doc, $root, 'zip', $client['Client']['zip']);
        $this->add_field($doc, $root, 'active', $client['Client']['active']);
        $this->add_field($doc, $root, 'terms', $client['Client']['terms']);
        $this->add_field($doc, $root, 'hq', $client['Client']['hq']);
        $this->add_field($doc, $root, 'modified_date', $client['Client']['modified_date']);
        $this->add_field($doc, $root, 'created_date', $client['Client']['created_date']);
        $this->add_field($doc, $root, 'created_user', $client['Client']['created_user']);
        $this->add_field($doc, $root, 'modified_user', $client['Client']['modified_user']);
        $this->add_field($doc, $root, 'last_sync_time', $client['Client']['last_sync_time']);

        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();
    }

    public function serialize_vendor($vendor)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */
        //debug($client);
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('vendor');

        $doc->appendChild($root);
        $this->add_field($doc, $root, 'id', $vendor['Vendor']['id']);
        $this->add_field($doc, $root, 'name', $vendor['Vendor']['name']);
        $this->add_field($doc, $root, 'purpose', $vendor['Vendor']['purpose']);
        $this->add_field($doc, $root, 'state', $vendor['Vendor']['state_id']);
        $this->add_field($doc, $root, 'street1', $vendor['Vendor']['street1']);
        $this->add_field($doc, $root, 'street2', $vendor['Vendor']['street2']);
        $this->add_field($doc, $root, 'city', $vendor['Vendor']['city']);
        $this->add_field($doc, $root, 'zip', $vendor['Vendor']['zip']);
        $this->add_field($doc, $root, 'active', $vendor['Vendor']['active']);
        $this->add_field($doc, $root, 'ssn', $vendor['Vendor']['ssn']);
        $this->add_field($doc, $root, 'apfirstname', $vendor['Vendor']['apfirstname']);
        $this->add_field($doc, $root, 'aplastname', $vendor['Vendor']['aplastname']);
        $this->add_field($doc, $root, 'apemail', $vendor['Vendor']['apemail']);
        $this->add_field($doc, $root, 'apphonetype1', $vendor['Vendor']['apphonetype1']);
        $this->add_field($doc, $root, 'apphone1', $vendor['Vendor']['apphone1']);
        $this->add_field($doc, $root, 'apphonetype2', $vendor['Vendor']['apphonetype2']);
        $this->add_field($doc, $root, 'apphone2', $vendor['Vendor']['apphone2']);
        $this->add_field($doc, $root, 'accountnumber', $vendor['Vendor']['accountnumber']);
        $this->add_field($doc, $root, 'notes', $vendor['Vendor']['notes']);
        $this->add_field($doc, $root, 'secretbits', $vendor['Vendor']['secretbits']);
        $this->add_field($doc, $root, 'modified_date', $vendor['Vendor']['modified_date']);
        $this->add_field($doc, $root, 'created_date', $vendor['Vendor']['created_date']);
        $this->add_field($doc, $root, 'created_user', $vendor['Vendor']['created_user_id']);
        $this->add_field($doc, $root, 'modified_user', $vendor['Vendor']['modified_user_id']);
        $this->add_field($doc, $root, 'last_sync_time', $vendor['Vendor']['last_sync_time']);

        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();
    }


    public function serialize_vendor_memo($doc, $memo)
    {
        // setup document root 'invoice'

        $root = $doc->getElementsByTagName('memos');
        $new_memo = $doc->createElement('memo');
        $root->item(0)->appendChild($new_memo);


        $this->add_field($doc, $new_memo, 'id', $memo['id']);
        $this->add_field($doc, $new_memo, 'vendor_id', $memo['vendor_id']);
        $this->add_field($doc, $new_memo, 'date', $memo['date']);
        $this->add_field($doc, $new_memo, 'notes', $memo['notes']);


        $this->add_field($doc, $new_memo, 'modified_date', $memo['modified_date']);
        $this->add_field($doc, $new_memo, 'created_date', $memo['created_date']);
        $this->add_field($doc, $new_memo, 'created_user', $memo['created_user_id']);
        $this->add_field($doc, $new_memo, 'modified_user', $memo['modified_user_id']);

        return ;
    }

    public function serialize_vendor_memos($vendor)
    {

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'

        $root = $doc->createElement('memos');

        $doc->appendChild($root);

        foreach($vendor['VendorsMemo'] as $memo){

            $new_memo = $doc->createElement('memo');

            $this->add_field($doc, $new_memo, 'id', $memo['id']);
            $this->add_field($doc, $new_memo, 'vendor_id', $memo['vendor_id']);
            $this->add_field($doc, $new_memo, 'date', $memo['date']);
            $this->add_field($doc, $new_memo, 'notes', $memo['notes']);

            $this->add_field($doc, $new_memo, 'modified_date', $memo['modified_date']);
            $this->add_field($doc, $new_memo, 'created_date', $memo['created_date']);
            $this->add_field($doc, $new_memo, 'created_user', $memo['created_user_id']);
            $this->add_field($doc, $new_memo, 'modified_user', $memo['modified_user_id']);
            $root->appendChild($new_memo);

        }
        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $dategenerated->appendChild($text);
        return $doc->saveXML();
    }

    public function serialize_expense($exp)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */
        //debug($client);
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('client');

        $doc->appendChild($root);
        $this->add_field($doc, $root, 'id', $exp['Expense']['id']);
        $this->add_field($doc, $root, 'amount', $exp['Expense']['amount']);
        $this->add_field($doc, $root, 'category_id', $exp['Expense']['category_id']);
        $this->add_field($doc, $root, 'employee_id', $exp['Expense']['employee_id']);
        $this->add_field($doc, $root, 'report_id', $exp['Expense']['report_id']);
        $this->add_field($doc, $root, 'cleared', $exp['Expense']['cleared']);
        $this->add_field($doc, $root, 'date', $exp['Expense']['date']);
        $this->add_field($doc, $root, 'description', $exp['Expense']['description']);
        $this->add_field($doc, $root, 'notes', $exp['Expense']['notes']);
        $this->add_field($doc, $root, 'created_date', $exp['Expense']['created_date']);
        $this->add_field($doc, $root, 'modified_date', $exp['Expense']['modified_date']);
        $this->add_field($doc, $root, 'created_user_id', $exp['Expense']['created_user_id']);
        $this->add_field($doc, $root, 'modified_user_id', $exp['Expense']['modified_user_id']);
        $this->add_field($doc, $root, 'last_sync_time', $exp['Expense']['last_sync_time']);

        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);

        return $doc->saveXML();
    }

    public function serialize_payroll($payroll)
    {
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('payroll');

        $doc->appendChild($root);

        $this->add_field($doc, $root, 'id', $payroll['Payroll']['id']);
        $this->add_field($doc, $root, 'name', $payroll['Payroll']['name']);
        $this->add_field($doc, $root, 'notes', $payroll['Payroll']['notes']);
        $this->add_field($doc, $root, 'amount', $payroll['Payroll']['amount']);
        $this->add_field($doc, $root, 'date', $payroll['Payroll']['date']);

        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        $new_element = $doc->createElement('payments');
        $list = array();
        foreach($payroll['EmployeesPayment'] as $pay)
        {
            $list[] = $pay['id'];
        }
        $this->add_id_list_to_element($doc, $new_element, $list);
        $root->appendChild($new_element);
        return $doc->saveXML();
    }


    public function serialize_employee_payment($payment)
    {

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('payment');

        $doc->appendChild($root);


        $this->add_field($doc, $root, 'id', $payment['EmployeesPayment']['id']);
        $this->add_field($doc, $root, 'employee_id', $payment['EmployeesPayment']['employee_id']);
        $this->add_field($doc, $root, 'invoice_id', $payment['EmployeesPayment']['invoice_id']);
        $this->add_field($doc, $root, 'payroll_id', $payment['EmployeesPayment']['payroll_id']);
        $this->add_field($doc, $root, 'date', $payment['EmployeesPayment']['date']);
        $this->add_field($doc, $root, 'ref', $payment['EmployeesPayment']['ref']);
        $this->add_field($doc, $root, 'amount', $payment['EmployeesPayment']['amount']);
        $this->add_field($doc, $root, 'notes', $payment['EmployeesPayment']['notes']);
        $this->add_field($doc, $root, 'securitytoken', $payment['EmployeesPayment']['securitytoken']);

        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();
    }
    public function serialize_employee_memo($memo)
    {

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('memo');

        $doc->appendChild($root);


        $this->add_field($doc, $root, 'id', $memo['EmployeesMemo']['id']);
        $this->add_field($doc, $root, 'employee_id', $memo['EmployeesMemo']['employee_id']);
        $this->add_field($doc, $root, 'date', $memo['EmployeesMemo']['date']);
        $this->add_field($doc, $root, 'notes', $memo['EmployeesMemo']['notes']);


        $this->add_field($doc, $root, 'modified_date', $memo['EmployeesMemo']['modified_date']);
        $this->add_field($doc, $root, 'created_date', $memo['EmployeesMemo']['created_date']);
        $this->add_field($doc, $root, 'created_user', $memo['EmployeesMemo']['created_user_id']);
        $this->add_field($doc, $root, 'modified_user', $memo['EmployeesMemo']['modified_user_id']);
        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();
    }
    public function serialize_client_memo($memo)
    {

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('memo');

        $doc->appendChild($root);


        $this->add_field($doc, $root, 'id', $memo['ClientsMemo']['id']);
        $this->add_field($doc, $root, 'client_id', $memo['ClientsMemo']['client_id']);
        $this->add_field($doc, $root, 'date', $memo['ClientsMemo']['date']);
        $this->add_field($doc, $root, 'notes', $memo['ClientsMemo']['notes']);

        $this->add_field($doc, $root, 'modified_date', $memo['ClientsMemo']['modified_date']);
        $this->add_field($doc, $root, 'created_date', $memo['ClientsMemo']['created_date']);
        $this->add_field($doc, $root, 'created_user', $memo['ClientsMemo']['created_user_id']);
        $this->add_field($doc, $root, 'modified_user', $memo['ClientsMemo']['modified_user_id']);

        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();
    }
    public function serialize_client_manager($manager)
    {

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'manager'
        $root = $doc->createElement('manager');

        $doc->appendChild($root);


        $this->add_field($doc, $root, 'id', $manager['ClientsManager']['id']);
        $this->add_field($doc, $root, 'client_id', $manager['ClientsManager']['client_id']);
        $this->add_field($doc, $root, 'firstname', $manager['ClientsManager']['firstname']);
        $this->add_field($doc, $root, 'lastname', $manager['ClientsManager']['lastname']);
        $this->add_field($doc, $root, 'title', $manager['ClientsManager']['title']);
        $this->add_field($doc, $root, 'email', $manager['ClientsManager']['email']);
        $this->add_field($doc, $root, 'created_date', $manager['ClientsManager']['created_date']);
        $this->add_field($doc, $root, 'modified_date', $manager['ClientsManager']['modified_date']);
        $this->add_field($doc, $root, 'created_user_id', $manager['ClientsManager']['created_user_id']);
        $this->add_field($doc, $root, 'modified_user_id', $manager['ClientsManager']['modified_user_id']);

        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();
    }
    private function start_commissions_report_document($doc, $employee, $date)
    {
        /*
         * make the starter commissions report employee_id, month_id
         */
        $root = $doc->createElement('commissions_report');
        $doc->appendChild($root);

        $domAttribute = $doc->createAttribute('employee');

        // Value for the created attribute
        $domAttribute->value = $employee['firstname'].' '.$employee['lastname'];

        // Don't GenerateTaggedCommissionsReportShellforget to append it to the element
        $root->appendChild($domAttribute);
        $domAttribute = $doc->createAttribute('employee_id');

        // Value for the created attribute
        $domAttribute->value = $employee['id'];

        // Don't forget to append it to the element
        $root->appendChild($domAttribute);

        // Don't GenerateTaggedCommissionsReportShellforget to append it to the element
        $root->appendChild($domAttribute);
        $domAttribute = $doc->createAttribute('commissions_report_id');

        // Value for the created attribute
        $datea = array();
        $datea['month'] = date("m",strtotime($date));
        $datea['year'] = date("Y",strtotime($date));

        $domAttribute->value = $this->commsComp->reportID_fromdate($datea);

        // Don't forget to append it to the element
        $root->appendChild($domAttribute);

        $domAttribute = $doc->createAttribute('month');

        $time = strtotime( $date.' 00:00:00');
        $domAttribute->value = date('F Y', $time);

        // Don't forget to append it to the element
        $root->appendChild($domAttribute);


        $ciNode = $doc->createElement('commissions_items');
        $root->appendChild($ciNode);

        $cpNode = $doc->createElement('commissions_payments');
        $root->appendChild($cpNode);
        return $doc;
    }

    private function save_xmlfile($report_file, $doc)
    {
        $f = fopen($report_file,'w');
        fwrite($f, $doc->saveXML());
        fclose($f);
    }
    public function link_comm_item($report_file, $item_id, $employee, $date)
    {
        /*
         * adds comm_item if not in report file
         * otherwise starts new report file
         *
         * sets up starter report_file, so this is called before cache commissions payments
         *
         */

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        if(file_exists($report_file))
        {
            $doc->load($report_file);
        } else {
            // setup document root 'commissions_items'
            $doc = $this->start_commissions_report_document($doc, $employee, $date);
            $this->save_xmlfile($report_file, $doc);
            return;
        }
        $xpath = new DOMXPath($doc);
        // We starts from the root element
        // look for commissions items with id = id
        $query = "/commissions_report/commissions_items[commissions_item=".$item_id."]";

        $items_found = $xpath->query($query);

        if($items_found->length == 0)
        {
            $itemNode = $doc->createElement('commissions_item');

            $text = $doc->createTextNode((string)$item_id);
            $itemNode->appendChild($text);

            $query = "/commissions_report/commissions_items";
            $items_node = $xpath->query($query);

            $items_node->item(0)->appendChild($itemNode);

            $this->save_xmlfile($report_file, $doc);

        }
    }


    public function link_comm_pay($report_file, $pay_id, $employee, $date)
    {
        /*
         * adds comm_pay if not in report file
         * otherwise starts new report file
         *
         * sets up starter report_file, so this is called before cache commissions payments
         *
         */
        $doc = new DOMDocument('1.0');

        $doc->formatOutput = true;
        $doc->preserveWhiteSpace = false;

        if(file_exists($report_file))
        {
            $doc->load($report_file);
        } else {
            // setup document root 'commissions_items'

            $doc = $this->start_commissions_report_document($doc, $employee, $date);
        }
        $xpath = new DOMXPath($doc);
        // We starts from the root element
        // look for commissions payments with id = id
        $query = "/commissions_report/commissions_payments[commissions_payment=".$pay_id."]";
        $items_found = $xpath->query($query);

        if($items_found->length == 0)
        {
            $itemNode = $doc->createElement('commissions_payment');

            $text = $doc->createTextNode((string)$pay_id);
            $itemNode->appendChild($text);


            $query = "/commissions_report/commissions_payments";
            $payments_node = $xpath->query($query);

            $payments_node->item(0)->appendChild($itemNode);

            $f = fopen($report_file,'w');
            fwrite($f, $doc->saveXML());
            fclose($f);
        }
    }


    public function serialize_commissions_pay($pay)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'commissions-payment'
        $root = $doc->createElement('commissions-payment');
        $doc->appendChild($root);
        $this->add_field($doc, $root, 'id', $pay['CommissionsPayment']['id']);
        $this->add_field($doc, $root, 'employee_id', $pay['CommissionsPayment']['employee_id']);
        $this->add_field($doc, $root, 'note_id', $pay['CommissionsPayment']['note_id']);


        $this->add_field($doc, $root, 'check_number', $pay['CommissionsPayment']['check_number']);
        $this->add_field($doc, $root, 'commissions_report_id', $pay['CommissionsPayment']['commissions_report_id']);
        $this->add_field($doc, $root, 'description', $pay['CommissionsPayment']['description']);
        $this->add_field($doc, $root, 'date', $pay['CommissionsPayment']['date']);


        $this->add_field($doc, $root, 'amount', $pay['CommissionsPayment']['amount']);

        $this->add_field($doc, $root, 'cleared', $pay['CommissionsPayment']['cleared']);
        $this->add_field($doc, $root, 'voided', $pay['CommissionsPayment']['voided']);



        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();

    }


    public function serialize_client_contract($contract)
    {

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('contract');

        $doc->appendChild($root);

        $this->add_field($doc, $root, 'id', $contract['ClientsContract']['id']);
        $this->add_field($doc, $root, 'employee_id', $contract['ClientsContract']['employee_id']);
        $this->add_field($doc, $root, 'client_id', $contract['ClientsContract']['client_id']);
        $this->add_field($doc, $root, 'enddate', $contract['ClientsContract']['enddate']);
        $this->add_field($doc, $root, 'startdate', $contract['ClientsContract']['startdate']);
        $this->add_field($doc, $root, 'terms', $contract['ClientsContract']['terms']);
        $this->add_field($doc, $root, 'invoicemessage', $contract['ClientsContract']['invoicemessage']);
        $this->add_field($doc, $root, 'po', $contract['ClientsContract']['po']);
        $this->add_field($doc, $root, 'potracking', $contract['ClientsContract']['potracking']);
        $this->add_field($doc, $root, 'employerexp', $contract['ClientsContract']['employerexp']);
        $this->add_field($doc, $root, 'notes', $contract['ClientsContract']['notes']);
        $this->add_field($doc, $root, 'active', $contract['ClientsContract']['active']);
        $this->add_field($doc, $root, 'period_id', $contract['ClientsContract']['period_id']);
        $this->add_field($doc, $root, 'title', $contract['ClientsContract']['title']);
        $this->add_field($doc, $root, 'reports_to', $contract['ClientsContract']['reports_to']);
        $this->add_field($doc, $root, 'mock_invoice_id', $contract['ClientsContract']['mock_invoice_id']);
        $this->add_field($doc, $root, 'addendum_executed', $contract['ClientsContract']['addendum_executed']);
        $this->add_field($doc, $root, 'timecard_in_invoice', $contract['ClientsContract']['timecard_in_invoice']);
        $this->add_field($doc, $root, 'created_date', $contract['ClientsContract']['created_date']);
        $this->add_field($doc, $root, 'modified_date', $contract['ClientsContract']['modified_date']);
        $this->add_field($doc, $root, 'created_user_id', $contract['ClientsContract']['created_user_id']);
        $this->add_field($doc, $root, 'modified_user_id', $contract['ClientsContract']['modified_user_id']);
        $this->add_field($doc, $root, 'last_sync_time', $contract['ClientsContract']['last_sync_time']);

        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);
        return $doc->saveXML();
    }

    public function serialize_commissions_items($taggedreport)
    {
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'commissions_items'
        $root = $doc->createElement('commissions_items');

        $doc->appendChild($root);

        foreach ($taggedreport['InvoicesItemsCommissionsItem'] as $invcommitem):
            if( $invcommitem['voided']!=1)
            {
                $item = $doc->createElement('item');
                $this->add_field($doc, $item, 'id', $invcommitem['id']);
                $root->appendChild($item);
            }
        endforeach;
        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);
        return $doc->saveXML();
    }
    public function serialize_commissions_payments($taggedreport)
    {
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'commissions_items'
        $root = $doc->createElement('commissions_payments');

        $doc->appendChild($root);

        foreach ($taggedreport['CommissionsPayment'] as $invcommitem):
            if( $invcommitem['voided']!=1)
            {
                $item = $doc->createElement('payment');
                $this->add_field($doc, $item, 'id', $invcommitem['id']);
                $root->appendChild($item);
            }
        endforeach;
        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $text = $dategenerated->appendChild($text);


        return $doc->saveXML();
    }

    public function serialize_contract($contract)
    {
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('contract');

        $doc->appendChild($root);
        $this->add_field($doc, $root, 'id', $contract['ClientsContract']['id']);
        $this->add_field($doc, $root, 'employee_id', $contract['ClientsContract']['employee_id']);
        $this->add_field($doc, $root, 'client_id', $contract['ClientsContract']['client_id']);
        $this->add_field($doc, $root, 'enddate', $contract['ClientsContract']['enddate']);
        $this->add_field($doc, $root, 'startdate', $contract['ClientsContract']['startdate']);
        $this->add_field($doc, $root, 'terms', $contract['ClientsContract']['terms']);
        $this->add_field($doc, $root, 'invoicemessage', $contract['ClientsContract']['invoicemessage']);
        $this->add_field($doc, $root, 'active', $contract['ClientsContract']['po']);
        $this->add_field($doc, $root, 'terms', $contract['ClientsContract']['terms']);
        $this->add_field($doc, $root, 'potracking', $contract['ClientsContract']['potracking']);
        $this->add_field($doc, $root, 'employerexp', $contract['ClientsContract']['employerexp']);
        $this->add_field($doc, $root, 'notes', $contract['ClientsContract']['notes']);
        $this->add_field($doc, $root, 'active', $contract['ClientsContract']['active']);
        $this->add_field($doc, $root, 'period_id', $contract['ClientsContract']['period_id']);
        $this->add_field($doc, $root, 'title', $contract['ClientsContract']['title']);
        $this->add_field($doc, $root, 'reports_to', $contract['ClientsContract']['reports_to']);
        $this->add_field($doc, $root, 'mock_invoice_id', $contract['ClientsContract']['mock_invoice_id']);
        $this->add_field($doc, $root, 'addendum_executed', $contract['ClientsContract']['addendum_executed']);
        $this->add_field($doc, $root, 'timecard_in_invoice', $contract['ClientsContract']['timecard_in_invoice']);
        $this->add_field($doc, $root, 'modified_date', $contract['ClientsContract']['modified_date']);
        $this->add_field($doc, $root, 'created_date', $contract['ClientsContract']['created_date']);
        $this->add_field($doc, $root, 'created_user', $contract['ClientsContract']['created_user_id']);
        $this->add_field($doc, $root, 'modified_user', $contract['ClientsContract']['modified_user_id']);
        $this->add_field($doc, $root, 'last_sync_time', $contract['ClientsContract']['last_sync_time']);


        return $doc->saveXML();
    }
    /*
     * serialize_states - used to create xml fixtures for states
     */
    public function serialize_states($states)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'states'
        $root = $doc->createElement('states');
        $root = $doc->appendChild($root);

        foreach ($states as $state)
        {

            $item = $doc->createElement('state');

            $this->add_field($doc, $item, 'id', $state['State']['id']);
            $this->add_field($doc, $item, 'name', $state['State']['name']);
            $this->add_field($doc, $item, 'flower', $state['State']['flower']);
            $this->add_field($doc, $item, 'post_ab', $state['State']['post_ab']);
            $this->add_field($doc, $item, 'state_no', $state['State']['state_no']);
            $this->add_field($doc, $item, 'date', $state['State']['date']);
            $this->add_field($doc, $item, 'capital', $state['State']['capital']);
            $root->appendChild($item);
        }
        return $doc->saveXML();
    }

    public function serialize_contract_items($item)
    {
        /* caches indexes of primary keys for employees
            returns xml for caller's fwrite
        */
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        // setup document root 'invoice'
        $root = $doc->createElement('contracts-item');

        $doc->appendChild($root);
        $this->add_field($doc, $root, 'id', $item['ContractsItem']['id']);
        $this->add_field($doc, $root, 'active', $item['ContractsItem']['active']);
        $this->add_field($doc, $root, 'contract_id', $item['ContractsItem']['contract_id']);
        $this->add_field($doc, $root, 'description', $item['ContractsItem']['description']);
        $this->add_field($doc, $root, 'amount', $item['ContractsItem']['amt']);
        $this->add_field($doc, $root, 'cost', $item['ContractsItem']['cost']);


        $this->add_field($doc, $root, 'notes', $item['ContractsItem']['notes']);
        $this->add_field($doc, $root, 'ordering', $item['ContractsItem']['ordering']);

        $this->add_field($doc, $root, 'created_date', $item['ContractsItem']['created_date']);
        $this->add_field($doc, $root, 'created_user_id', $item['ContractsItem']['created_user_id']);
        $this->add_field($doc, $root, 'modified_date', $item['ContractsItem']['modified_date']);
        $this->add_field($doc, $root, 'modified_user_id', $item['ContractsItem']['modified_user_id']);



        // timestamp
        $dategenerated = $doc->createElement('date_generated');
        $dategenerated = $root->appendChild($dategenerated);
        $text = $doc->createTextNode(date('D, d M Y H:i:s'));
        $dategenerated->appendChild($text);


        return $doc->saveXML();
    }

}
?>
