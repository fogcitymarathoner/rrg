<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 2/13/14
 * Time: 9:20 PM
 */


App::import('Model', 'CommissionsPayment');
class CommissionsPaymentCache extends CommissionsPayment {


    function cache_payments() {
        Configure::write('debug', 2);
        ini_set('memory_limit', '-1');
        echo "Caching employees commissions payments\n";

        // Cache up employees to reduce queries
        $employees = $this->Employee->find('all');
        $emp_list = array();
        foreach($employees as $employee)
        {
            $emp_list[$employee['Employee']['id']] = $employee['Employee'];
        }
        echo "Caching employee commissions payments into transactions archive...\n";


        $this->unbindModel(array('belongsTo' => array('Employee', 'CommissionsReport'),),false);
        $this->unbindModel(array('hasOne' => array('Note'),),false);
        $payments = $this->find('all');


        $transdir = $this->xml_home.'commissions_payments/';
        $report_dir = $this->xml_home.'commissions_reports/';

        // make report directory if it does not exist
        if (!file_exists($transdir)) {
            mkdir($transdir);
        }
        // make report directory if it does not exist
        if (!file_exists($report_dir)) {
            mkdir($report_dir);
        }
        foreach ($payments as $pay)
        {

            $hash = $this->hu->id_date_hash($pay['CommissionsPayment']['employee_id'], $pay['CommissionsPayment']['date']);
            //$filename = $transdir.str_pad((string)$pay['CommissionsPayment']['id'], 5, "0", STR_PAD_LEFT).'.xml';
            $filename = $this->dsComp->comm_payment_filename($pay['CommissionsPayment']['id']);
            $report_file = $report_dir.$hash.'.xml';

            // skip nonsense dates before epoch

            $epoch = Configure::read('epoch');

            if(strtotime ($pay['CommissionsPayment']['date']) >= $epoch)
            {
                // skip non-existant employees
                if(array_key_exists ($pay['CommissionsPayment']['employee_id'], $emp_list))
                    $this->xmlComp->link_comm_pay($report_file, $pay['CommissionsPayment']['id'],
                        $emp_list[$pay['CommissionsPayment']['employee_id']], $pay['CommissionsPayment']['date']);
                if($f = fopen($filename,'w'))
                {
                    fwrite($f, $this->xmlComp->serialize_commissions_pay($pay));
                    fclose($f);
                } else {
                    print "could not open ".$filename."\n";
                }
            }
        }
    }

}