<?php

App::import('Component', 'Json');
App::import('Component', 'Commissions');
App::import('Component', 'Xml');
App::import('Component', 'HashUtils');
App::import('Component', 'Datasources');
App::import('Component', 'FixtureDirectories');
App::import('Component', 'InvoiceFunction');


App::import('Model', 'ClientsContract');
App::import('Model', 'CommissionsReport');
App::import('Model', 'Employee');
App::import('Model', 'InvoicesItemsCommissionsItem');

require_once dirname(__FILE__) . '/../XML/Serializer.php';
//require_once("XML/Serializer.php");
class Payroll extends AppModel {

	var $name = 'Payroll';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'EmployeesPayment' => array(
			'className' => 'EmployeesPayment',
			'foreignKey' => 'payroll_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'ordering asc',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
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
    function payments_for_refapp($id)
    {
        $this->EmployeesPayment->recursive = 2;
        $this->EmployeesPayment->Employee->unbindModel(array('belongsTo' => array(
            'State',
            'Note',
            'InvoicesItemsCommissionsItem',
        ),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array(
            'Payroll',
        ),),false);
        $this->EmployeesPayment->Invoice->unbindModel(array('belongsTo' => array(
            'ClientsContract',
        ),),false);
        $this->EmployeesPayment->Invoice->unbindModel(array('hasMany' => array(
            'InvoicesPayment',
            'InvoicesItem',
            'InvoicesTimecardReceiptLog',
            'EmployeesPayment',
            'InvoicesTimecardReminderLog',
            'InvoicesPostLog',
        ),),false);

        $this->EmployeesPayment->Employee->unbindModel(array('hasOne' => array(
            'Profile',
        ),),false);
        $this->EmployeesPayment->Employee->unbindModel(array('hasMany' => array(
            'ClientsContract',
            'EmployeesMemo',
            'EmployeesLetter',
            'EmployeesEmail',
            'EmployeesPayment',
            'InvoicesItemsCommissionsItem',
            'CommissionsPayment',
            'NotesPayment',
            'Note',
            'Expense',
        ),),false);
        $payments = $this->EmployeesPayment->find('all',array('conditions'=>array('payroll_id'=>$id),
            'order'=>array('Employee.firstname asc')
        ));
        return $payments;
    }

    function payments_for_document_manager($id)
    {
        $this->EmployeesPayment->recursive = 2;
        $this->EmployeesPayment->Employee->unbindModel(array('belongsTo' => array(
            'State',
            'Note',
            'InvoicesItemsCommissionsItem',
        ),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array(
            'Payroll',
        ),),false);
        $this->EmployeesPayment->Invoice->unbindModel(array('belongsTo' => array(
            'ClientsContract',
        ),),false);
        $this->EmployeesPayment->Invoice->unbindModel(array('hasMany' => array(
            'InvoicesPayment',
            'InvoicesItem',
            'InvoicesTimecardReceiptLog',
            'EmployeesPayment',
            'InvoicesTimecardReminderLog',
            'InvoicesPostLog',
        ),),false);

        $this->EmployeesPayment->Employee->unbindModel(array('hasMany' => array(
            'ClientsContract',
            'EmployeesMemo',
            'EmployeesLetter',
            'EmployeesEmail',
            'EmployeesPayment',
            'InvoicesItemsCommissionsItem',
            'CommissionsPayment',
            'NotesPayment',
            'Note',
            'Expense',
        ),),false);
        $payments = $this->EmployeesPayment->find('all',array('conditions'=>array('payroll_id'=>$id),
            'order'=>array('Employee.firstname asc')
        ));
        return $payments;
    }
    function prepare_payments_for_paystub_distribution($payments)
    {
        // decrypt ssn
        $i = 0;
        foreach ($payments as $payment)
        {
            // get payment number
            $emppayments = $payment['Employee']['EmployeesPayment'];
            $employee_decrypt = $this->EmployeesPayment->Employee->decrypt($payment);
            $j=0;
            foreach ($emppayments as $pay)
            {
                $j++;
                if ($pay['payroll_id']== $payments[0]['EmployeesPayment']['payroll_id'])
                    break 1;
            }
            $payments[$i]['Employee']['ssn'] = $employee_decrypt['Employee']['ssn_crypto'];
            $payments[$i]['Employee']['payment_number'] = $j;
            $startdatearray = explode('-',$payments[$i]['Invoice']['period_start']);
            $startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
            $enddatearray = explode('-',$payments[$i]['Invoice']['period_end']);
            $enddatetime = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2], $enddatearray[0]);
            $start = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] , $startdatearray[0]);
            $end = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2] , $enddatearray[0]);
            $startstr = date("m.d.Y",$start);
            $endstr = date("m.d.Y",$end);
            $filename =  'paystub_'.str_replace(' ','_',$payments[$i]['Employee']['firstname']).'_';
            if($payments[$i]['Employee']['nickname']!='')
            {
                $filename .=  $payments[$i]['Employee']['nickname'].'_';
            }
            $filename .=  $payments[$i]['Employee']['lastname'].'_';
            $filename .= $startstr.'_to_'.$endstr.'_'.$payments[$i]['EmployeesPayment']['securitytoken'];

            $filename = str_replace(' ','_',$filename);
            $ssn = str_replace('-','',$payments[$i]['Employee']['ssn']);
            $filename = str_replace(' ','_',$filename);

            $payments[$i]['EmployeesPayment']['filename'] = $filename;
            $payments[$i]['EmployeesPayment']['Employee']['ssn'] = $ssn;

            App::import('Component', 'Payroll');
            $payrollComp = new PayrollComponent;
            $cp=' mv A_'.$payrollComp->padded_count($i+1,$payments).'.pdf '.$filename.'.pdf';


            $payments[$i]['EmployeesPayment']['cp'] = $cp;

            $encrypt='pdftk '.$filename.'.pdf output '.$filename.'_encrypt.pdf owner_pw hello user_pw '.$ssn.' allow printing compress';


            $email='cat mail_msg |mutt -a  '.$filename.'_encrypt.pdf -s "'.$filename.'_encrypt.pdf " monica@rocketsredglare.com marc@rocketsredglare.com timecardtest@fogtest.com '.$payments[$i]['Employee']['EmployeesEmail'][0]['email'];


            $payments[$i]['EmployeesPayment']['encrypt'] = $encrypt;
            $payments[$i]['EmployeesPayment']['email'] = $email;
            $i++;
        }
        return ($payments);
    }
    function encryption_step2_email($payments)
    {
        $res = array();
        foreach ($payments as $pay):
            $res[]= $pay['EmployeesPayment']['email'];
        endforeach;
        $res[] ='# date generated -'.date('D, d M Y H:i:s');
        return ($res);
    }
    function encryption_step1_splitA_encrypt($payments)
    {
        $res = array();
        $res[]= 'rm  paystub_*.pdf';
        $res[]= 'stapler split A.pdf';
        foreach ($payments as $pay):
            $res[]= $pay['EmployeesPayment']['cp'];
        endforeach;
        foreach ($payments as $pay):
            $res[] = $pay['EmployeesPayment']['encrypt'];
        endforeach;
        $res[] ='# date generated -'.date('D, d M Y H:i:s');
        return ($res);
    }
    /*
     * just cache one payroll quickly
     */
    function cache_payroll($pay,$serializer,$xml_home)
    {
        if($pay['Payroll']['id'] != Null)
        {
            $paydir = $xml_home.'payrolls/';
            $paydir = $paydir.'paystub_transmittals/';
            $pay['Payroll']['date_generated'] = date('D, d M Y H:i:s');

            $filename = $paydir.str_pad((string)$pay['Payroll']['id'], 5, "0", STR_PAD_LEFT).'.xml';

            if($f = fopen($filename,'w'))
            {
                fwrite($f, $serializer->serialize($pay));
                fclose($f);
            } else {
                print "could not open ".$filename;
            }
        } else {
            print 'pay id is null for cache payroll';
        }

    }
    function add_transmittal_info_to_payment($pay)
    {
        $i = 0;
        foreach($pay['EmployeesPayment'] as $epay)
        {
            $emp = $this->EmployeesPayment->Employee->read(null, $epay['employee_id']);
            $pay['EmployeesPayment'][$i]['Employee'] = $emp;

            $inv = $this->EmployeesPayment->Employee->ClientsContract->Invoice->read(null,$epay['invoice_id']);

            $startdatearray = explode('-',$inv['Invoice']['period_start']);
            $startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
            $enddatearray = explode('-',$inv['Invoice']['period_end']);
            $enddatetime = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2], $enddatearray[0]);
            $start = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] , $startdatearray[0]);
            $end = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2] , $enddatearray[0]);
            $startstr = date("m.d.Y",$start);
            $endstr = date("m.d.Y",$end);
            $filename =  'paystub_'.str_replace(' ','_',$emp['Employee']['firstname']).'_';
            if($emp['Employee']['nickname']!='')
            {
                $filename .=  $emp['Employee']['nickname'].'_';
            }
            $filename .=  $emp['Employee']['lastname'].'_';
            $filename .= $startstr.'_to_'.$endstr.'_'.$epay['securitytoken'];

            $filename = str_replace(' ','_',$filename);

            $pay['EmployeesPayment'][$i]['filename'] = $filename.'.pdf';
            $pay['EmployeesPayment'][$i++]['filename_crypto'] = $filename.'_encrypt.pdf';
        }

        return $pay;
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
        $serializer = &new XML_Serializer($options);
        $this->xml_home = Configure::read('xml_home');
        $xml_home = $this->xml_home;
        $payrolls = $this->find('all',array(
           'conditions'=>array('date >='.date('Y-m-d',$threeWeeksBack))
        ));

        $this->EmployeesPayment->Employee->unbindModel(array('belongsTo' => array('State'),),false);
        foreach ($payrolls as $pay)
        {
            $pay = $this->add_transmittal_info_to_payment($pay);
            $this->cache_payroll($pay,$serializer,$xml_home);
        }
    }
    function payroll_view_data($id)
    {
        $this->EmployeesPayment->recursive = 2;
        $this->EmployeesPayment->Employee->unbindModel(array('belongsTo' => array(
            'State',
        ),),false);
        $this->EmployeesPayment->Employee->unbindModel(array('hasMany' => array(
            'Note',
            'InvoicesItemsCommissionsItem',
            'EmployeesLetter',
        ),),false);
        $this->EmployeesPayment->Employee->bindModel(array('hasMany' => array(
            'EmployeesEmail',
            'EmployeesPayment',
        ),),false);
        $this->EmployeesPayment->unbindModel(array('belongsTo' => array(
            'Payroll',
        ),),false);
        $this->EmployeesPayment->Invoice->unbindModel(array('belongsTo' => array(
            'ClientsContract',
        ),),false);
        $this->EmployeesPayment->Invoice->unbindModel(array('hasMany' => array(
            'InvoicesPayment',
            'EmployeesPayment',
            'InvoicesTimecardReminderLog',
            'InvoicesPostLog',
            'InvoicesTimecardReceiptLog',
        ),),false);

        $this->EmployeesPayment->Invoice->InvoicesItem->unbindModel(array('hasMany' => array(

            'InvoicesItemsCommissionsItem',
        ),),false);

        $this->EmployeesPayment->Employee->unbindModel(array('hasMany' => array(
            'ClientsContract',
            'EmployeesMemo',
            'CommissionsPayment',
            'NotesPayment',
            'Note',
            'Expense',
            'EmployeesLetter',
            'InvoicesItemsCommissionsItem',
        ),),false);
        $payments = $this->EmployeesPayment->find('all',array('conditions'=>array('payroll_id'=>$id),
            'order'=>array('EmployeesPayment.ordering asc')
        ));
        return $payments;
    }
    function payment_document_management($id)
    {
        $payments = $this->payroll_view_data($id);
            // decrypt ssn
        $i = 0;
        foreach ($payments as $payment)
        {

            $startdatearray = explode('-',$payments[$i]['Invoice']['period_start']);
            $startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
            $enddatearray = explode('-',$payments[$i]['Invoice']['period_end']);
            $enddatetime = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2], $enddatearray[0]);
            $start = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] , $startdatearray[0]);
            $end = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2] , $enddatearray[0]);
            $startstr = date("m.d.Y",$start);
            $endstr = date("m.d.Y",$end);
            $filename =  'paystub_'.str_replace(' ','_',$payments[$i]['Employee']['firstname']).'_';
            if($payments[$i]['Employee']['nickname']!='')
            {
                $filename .=  $payments[$i]['Employee']['nickname'].'_';
            }
            $filename .=  $payments[$i]['Employee']['lastname'].'_';
            $filename .= $startstr.'_to_'.$endstr.'_'.$payments[$i]['EmployeesPayment']['securitytoken'];

            $filename = str_replace(' ','_',$filename);
            $filename = str_replace(' ','_',$filename);
            $payments[$i]['EmployeesPayment']['filename'] = $filename;
            $payments[$i]['EmployeesPayment']['filename'] = $filename.'pdf';
            $payments[$i]['EmployeesPayment']['filename_encrypt'] = $filename.'_encrypt.pdf';
            $i++;
        }
        return $payments;
    }
    function clear_paided_payrolls($invoices)
    {
        $count = 0;
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
            if ($balance > .03 )
            {
               $this->EmployeesPayment->Employee->unbindModel(array('belongsTo' =>
                array('State'),),false);
               $this->EmployeesPayment->Employee->unbindModel(array('hasMany' =>
                array('ClientsContract','EmployeesMemo',
                    'EmployeesPayment','EmployeesEmail'),),false);
                $employee =$this->EmployeesPayment->Employee->find('all',
                    array('conditions'=>array('Employee.id'=>$invoice['ClientsContract']['employee_id'])));
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
                );
                $count++;
            } else {
                $invoice['Invoice']['prcleared'] = 1;
                $this->EmployeesPayment->Invoice->save($invoice);
            }
        endforeach;
        return $paychecks;
    }
    function check_for_cleared()
    {
       $this->EmployeesPayment->Invoice->unbindModel(array('hasMany' => array(
        'InvoicesPayment',
        'InvoicesTimecardReminderLog',
        'InvoicesPostLog',
        ),),false);
       $this->EmployeesPayment->Invoice->recursive = 1;
        $invoices =$this->EmployeesPayment->Invoice->find('all', array(
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
        'ClientsContract.employee_id'),
        'order'=>array('Invoice.period_end ASC'),
        )
        );
        $paychecks = array();
        $count = 0;

        $paychecks =$this->clear_paided_payrolls($invoices);
    }
}
?>