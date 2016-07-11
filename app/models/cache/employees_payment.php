<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 2/9/14
 * Time: 6:01 PM
 */
//require_once("XML/Serializer.php");
//require_once("XML/Unserializer.php");

require_once dirname(__FILE__) . '/../../XML/Serializer.php';
require_once dirname(__FILE__) . '/../../XML//Unserializer.php';
App::import('Model', 'EmployeesPayment');
App::import('Component', 'Xml');
App::import('Component', 'Json');
class EmployeesPaymentCache extends EmployeesPayment {

    private function repair_dates($pay){

        /* repair dates if there are problems */
        $paysave = array();
        $paysave['EmployeesPayment'] = $pay['EmployeesPayment'];
        if($pay['EmployeesPayment']['created_user_id']== Null)
            $paysave['EmployeesPayment']['created_user_id'] =5;
        if($pay['EmployeesPayment']['modified_user_id'] == Null)
            $paysave['EmployeesPayment']['modified_user_id'] =5;
        if($pay['EmployeesPayment']['modified_date'] == Null)
            $paysave['EmployeesPayment']['modified_date']= date('Y-m-d H:i:s');
        if($pay['EmployeesPayment']['created_date']    == Null)
            $paysave['EmployeesPayment']['created_date']= date('Y-m-d H:i:s');
        $paysave['EmployeesPayment']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($paysave);
    }
    private function sync($pay,$fixfilename)
    {
        $xmlComp = new XmlComponent;
        if($f = fopen($fixfilename,'w+'))
        {
            fwrite($f, $xmlComp->serialize_employee_payment($pay));
            fclose($f);
        } else {
            print "could not open ".$fixfilename;
        }

    }

    /*
     *  Cache All Payments
     */
    function cache_payments()
    {
        $threeWeeksBack = mktime(0, 0, 0, date("m")  , date("d")-21,date("Y"));
        ini_set('memory_limit', '-1');
        echo "Syncing all payments \n";

        $payments = $this->find('all');
        $this->xml_home = Configure::read('xml_home');
        $transdir = $this->xml_home.'employees/payments/';
        if (!file_exists($transdir)) {
            mkdir($transdir);
        }
        foreach($payments as $pay)
        {
            /*
             * repair and sync payments that were made before modified and created meta were automatically entered
             */

            $filename = $transdir.str_pad((string)$pay['EmployeesPayment']['id'], 5, "0", STR_PAD_LEFT).'.xml';
            if ($pay['EmployeesPayment']['modified_date'] == Null && $pay['EmployeesPayment']['last_sync_time'] == Null)
            {
                $this->repair_dates($pay);
                $this->sync($pay,$filename);
            }
            if (strtotime($pay['EmployeesPayment']['modified_date']) > strtotime($pay['EmployeesPayment']['last_sync_time']))
            {
                $this->sync($pay,$filename);
            }
        }
    }
}

