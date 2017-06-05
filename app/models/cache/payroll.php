<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 2/9/14
 * Time: 5:08 PM
 */
//require_once("XML/Serializer.php");
//require_once("XML/Unserializer.php");

require_once dirname(__FILE__) . '/../../XML/Serializer.php';
require_once dirname(__FILE__) . '/../../XML//Unserializer.php';
App::import('Model', 'Payroll');
App::import('Component', 'Xml');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');
class PayrollCache extends Payroll {


    /*
     * just cache one payroll quickly
     */
    function cache_payroll($pay, $xml_home)
    {

        $xmlComp = new XmlComponent;
        if($pay['Payroll']['id'] != Null)
        {
            $paydir = $xml_home.'payrolls/';
            $paydir = $paydir.'paystub_transmittals/';
            $pay['Payroll']['date_generated'] = date('D, d M Y H:i:s');

            $filename = $paydir.str_pad((string)$pay['Payroll']['id'], 5, "0", STR_PAD_LEFT).'.xml';
            if($f = fopen($filename,'w'))
            {
                fwrite($f, $xmlComp->serialize_payroll($pay));
                fclose($f);
            } else {
                print "could not open ".$filename;
            }
        } else {
            print 'pay id is null for cache payroll';
        }

    }

    /*
     *  Cache All Payrolls
     */
    function cache_payrolls()
    {
        $threeWeeksBack = mktime(0, 0, 0, date("m")  , date("d")-21,date("Y"));
        ini_set('memory_limit', '-1');

        echo 'Writing Paystub transmittals 3 weeks back...';
        $options = array(
            XML_SERIALIZER_OPTION_INDENT        => '    ',
            XML_SERIALIZER_OPTION_RETURN_RESULT => true
        );

        $this->xml_home = Configure::read('xml_home');
        $xml_home = $this->xml_home;
        $payrolls = $this->find('all',array(
            'conditions'=>array('date >='.date('Y-m-d',$threeWeeksBack))
        ));
        $this->EmployeesPayment->Employee->unbindModel(array('belongsTo' => array('State'),),false);
        foreach ($payrolls as $pay)
        {
            $pay = $this->add_transmittal_info_to_payment($pay);
            $this->cache_payroll($pay, $xml_home);
        }
    }
}
