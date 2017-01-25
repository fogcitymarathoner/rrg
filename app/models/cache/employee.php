<?php
/*
 *  Link opening Commissions items to Invoice items and Invoices
 *     `invoices_items_commissions_items` opening = True, ItemId = 0
 *
 * Make sure Employee delete method deletes Invoice and Invoice Item
 *
 * Make sure new Employee fills in OpeningInvoiceID
 *
 *
 */
//require_once("XML/Serializer.php");
//require_once("XML/Unserializer.php");

require_once dirname(__FILE__) . '/../../XML/Serializer.php';
require_once dirname(__FILE__) . '/../../XML//Unserializer.php';
App::import('Model', 'Employee');
App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');
class EmployeeCache extends Employee {

    //
    // replaces null employee values to zero so xml fixtures have closing tags
    // disable when hand editing is stopped
    private function zero_out_null($employee)
    {
        if (!$employee['Profile']['sphene_id'])
            $employee['Profile']['sphene_id'] = 0;
        if (!$employee['Profile']['released_cat_id'])
            $employee['Profile']['released_cat_id'] = 0;
        if (!$employee['Profile']['released_cat_thread_id'])
            $employee['Profile']['released_cat_thread_id'] = 0;
        if (!$employee['Profile']['internal_cat_id'])
            $employee['Profile']['internal_cat_id'] = 0;
        if (!$employee['Profile']['internal_cat_thread_id'])
            $employee['Profile']['internal_cat_thread_id'] = 0;
        return $employee;
    }

    /*
     * Write fixture down mark employee as synced
     */
    private function sync($employee, $fixfilename)
    {
        if($f = fopen($fixfilename,'w'))
        {
            $employee = $this->zero_out_null($employee);
            fwrite($f, $this->xmlComp->serialize_employee($employee));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }
        $empsave = array();
        $empsave['Employee'] = $employee;


        /* repair dates if there are problems */
        if($employee['Employee']['created_user_id']== Null)
            $empsave['Employee']['created_user_id'] =5;
        if($employee['Employee']['modified_user_id'] == Null)
            $empsave['Employee']['modified_user_id'] =5;
        if($employee['Employee']['modified_date'] == Null)
            $empsave['Employee']['modified_date']= date('Y-m-d H:i:s');
        if($employee['Employee']['created_date']    == Null)
            $empsave['Employee']['created_date']= date('Y-m-d H:i:s');

        $empsave['Employee']['Employee']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($empsave['Employee']);
    }
    /*
     *  cache employees -
     *  writes down employee archives, employee cache for apps the have expensive queries to get employee first and last name
     *  info.
     *  sets down work for django
     *  picks up work from django
     *
     * Miscellaneous notes:
     * caching inactives needs to be rewritten
     * if it exists, search and add primary key if it is not there.
     */
    function cache_employees() {
        Configure::write('debug',2);

        echo 'Caching employees into archive...';
        ini_set('memory_limit', '-1');
        $this->xml_home = Configure::read('xml_home');
        $employees = $this->find('all');
        $employeesJS  = array();
        $employeesJS['employees']  = array();
        $actives  = array();
        $actives['employees'] = array();
        $inactives  = array();
        $inactives['employees'] = array();
        foreach ($employees as $employee)
        {
            if( $employee['Employee']['voided']!= 1)
            {
                $emp_array = array('id' => $employee['Employee']['id'],
                    'name' => $employee['Employee']['firstname'].' '. $employee['Employee']['lastname']);
                if($employee['Employee']['active'] == 1 )
                {
                    $actives['employees'][] = $emp_array;
                } else {
                    $inactives['employees'][] = $emp_array;;
                }
                $emails = array();
                if(!empty($employee['EmployeesEmail']))
                {
                    foreach($employee['EmployeesEmail'] as $empemail)
                    {
                        $emails[]= $empemail['email'];
                    }
                }
                $employeesJS['employees'][$employee['Employee']['id']] = array('id'=>$employee['Employee']['id'],'first'=>$employee['Employee']['firstname'],'last'=>$employee['Employee']['lastname'],'active'=>$employee['Employee']['active'],'emails'=>$emails);
                $ClientsContract =$employee['ClientsContract'];
                $EmployeesLetter =$employee['EmployeesLetter'];
                $EmployeesMemo = $employee['EmployeesMemo'];
                $EmployeesPayment =$employee['EmployeesPayment'];
                $EmployeesEmail =$employee['EmployeesEmail'];
                $CommissionsReportsTag =$employee['CommissionsReportsTag'];
                $CommissionsPayment =$employee['CommissionsPayment'] ;
                $NotesPayment =$employee['NotesPayment'];
                $Note =$employee['Note'] ;
                $Expense =$employee['Expense'];
                $InvoicesItemsCommissionsItem =$employee['InvoicesItemsCommissionsItem'];
                $employee['ClientsContract'] = array();
                $employee['EmployeesLetter'] = array();
                $employee['EmployeesMemo'] = array();
                $employee['EmployeesPayment'] = array();
                $employee['EmployeesEmail'] = array();
                $employee['CommissionsReportsTag'] = array();
                $employee['CommissionsPayment'] = array();
                $employee['NotesPayment'] = array();
                $employee['Note'] = array();
                $employee['Expense'] = array();
                $employee['InvoicesItemsCommissionsItem'] = array();
                foreach($ClientsContract as $contract)
                {
                    $employee['ClientsContract'][] = $contract['id'];
                }
                foreach($EmployeesLetter as $letter)
                {
                    $employee['EmployeesLetter'][] = $letter['id'];
                }
                foreach($EmployeesMemo as $memo)
                {
                    $employee['EmployeesMemo'][] = $memo['id'];
                }
                foreach($EmployeesPayment as $pay)
                {
                    $employee['EmployeesPayment'][] = $pay['id'];
                }
                foreach($EmployeesEmail as $email)
                {
                    $employee['EmployeesEmail'][] = $email['id'];
                }
                foreach($CommissionsReportsTag as $rtag)
                {
                    $employee['CommissionsReportsTag'][] = $rtag['id'];
                }
                foreach($CommissionsPayment as $pay)
                {
                    $employee['CommissionsPayment'][] = $pay['id'];
                }
                foreach($NotesPayment as $pay)
                {
                    $employee['NotesPayment'][] = $pay['id'];
                }
                foreach($Note as $pay)
                {
                    $employee['Note'][] = $pay['id'];
                }
                foreach($Expense as $pay)
                {
                    $employee['Expense'][] = $pay['id'];
                }
                foreach($InvoicesItemsCommissionsItem as $pay)
                {
                    $employee['InvoicesItemsCommissionsItem'][] = $pay['id'];
                }
                $employee['date_generated'] = date('D, d M Y H:i:s');
                $fixfilename = $this->xml_home.'employees/'.str_pad((string)$employee['Employee']['id'], 5, "0", STR_PAD_LEFT).'.xml';
                if(!file_exists (  $fixfilename ) )
                {
                    $this->sync($employee,$fixfilename);
                }
                else
                {
                    /*
                     * Look for work from django on it's way back
                     */
                    $f = fopen($fixfilename,'r');
                    $fsize = filesize($fixfilename);
                    $userializer = &new XML_Unserializer();
                    $doc = fread($f,$fsize);
                    fclose($f);
                    $userializer->unserialize($doc);
                    $employeeTransmittal = $userializer->getUnserializedData ( );
                    /*
                     * optimize a little by skipping inactives.  should be ok if refreshes are done diligently before any record deletions
                     */

                    if (strtotime($employee['Employee']['modified_date']) > strtotime($employee['Employee']['last_sync_time']))
                    {
                        $this->sync($employee,$fixfilename);
                    }
                }
            }
        }
        //end foreach
        /*
         * record the primary keys of active and inactive employees
         */
        $actives['date_generated'] = date('D, d M Y H:i:s');
        $inactives['date_generated'] = date('D, d M Y H:i:s');
        $employeesJS['date_generated'] = date('D, d M Y H:i:s');

        $f = fopen($this->xml_home.'employees/actives.xml','w');
        fwrite($f, $this->xmlComp->serialize_employees($actives));
        fclose($f);
        $f = fopen($this->xml_home.'employees/inactives.xml','w');
        fwrite($f, $this->xmlComp->serialize_employees($inactives));
        fclose($f);
        /*
         *  Write JSON fixture for the Javascript apps
         */
        $jsonComp = new JsonComponent;

        $f = fopen($this->xml_home.'employees/employees.json','w');
        fwrite($f,$jsonComp->employees_jquery($employeesJS));
        fclose($f);
    }

    function decryptes() {
        Configure::write('debug',2);

        echo "Decrypting employees \n";
        ini_set('memory_limit', '-1');
        $employees = $this->find('all');

        foreach ($employees as $employee)
        {
            if( $employee['Employee']['voided']!= 1)
            {
                $encryptedEmployee = $this->read(null, $employee['Employee']['id']);
                $this->data = $this->decrypt($encryptedEmployee);
                debug($this->data['Employee']['firstname']);
                debug($this->data['Employee']['lastname']);
                debug($this->data['Employee']['ssn_crypto']);
                debug($this->data['Employee']['bankaccountnumber_crypto']);
                debug($this->data['Employee']['bankroutingnumber_crypto']);

                $this->data['Employee']['ssn_clear'] = $this->data['Employee']['ssn_crypto'];
                $this->data['Employee']['bankaccountnumber_clear'] = $this->data['Employee']['bankaccountnumber_crypto'];
                $this->data['Employee']['bankroutingnumber_clear'] = $this->data['Employee']['bankroutingnumber_crypto'];
                $this->save($this->data);
            }
        }
    }
}
?>
