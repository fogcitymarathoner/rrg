<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marc
 * Date: 12/4/13
 * Time: 2:14 PM
 * To change this template use File | Settings | File Templates.
 */
//require_once("XML/Serializer.php");
//require_once("XML/Unserializer.php");

require_once dirname(__FILE__) . '/../../XML/Serializer.php';
require_once dirname(__FILE__) . '/../../XML//Unserializer.php';
App::import('Model', 'Employee');
App::import('Model', 'InvoicesItemsCommissionsItem');
App::import('Component', 'Json');
class InvoicesItemsCommissionsItemCache extends InvoicesItemsCommissionsItem {

    var $empModel;
    public function __construct() {

        $this->empModel = new Employee;

        parent::__construct();
    }
    private function sync($item, $filename)
    {
        if($f = fopen($filename,'w'))
        {
            fwrite($f, self::$xmlComp->serialize_invoice_commissions_item($item));
            fclose($f);
        } else {
            print "could not open ".$filename."\n";
        }

        /* repair dates if there are problems */
        $invsave = array();
        $invsave['InvoicesItemsCommissionsItem'] = $item['InvoicesItemsCommissionsItem'];
        if($item['InvoicesItemsCommissionsItem']['created_user_id']== Null)
            $item['InvoicesItemsCommissionsItem']['created_user_id'] =5;
        if($item['InvoicesItemsCommissionsItem']['modified_user_id'] == Null)
            $invsave['InvoicesItemsCommissionsItem']['modified_user_id'] =5;
        if($item['InvoicesItemsCommissionsItem']['modified_date'] == Null)
            $invsave['InvoicesItemsCommissionsItem']['modified_date']= date('Y-m-d H:i:s');
        if($item['InvoicesItemsCommissionsItem']['created_date']    == Null)
            $invsave['InvoicesItemsCommissionsItem']['created_date']= date('Y-m-d H:i:s');
        $invsave['InvoicesItemsCommissionsItem']['last_sync_time'] = date('Y-m-d H:i:s');
        $this->save($invsave);
    }
    public function protect_comm_items()
    {
        foreach($this->dsComp->inv_comm_item_files() as $f)
        {
            if(pathinfo($f, PATHINFO_EXTENSION) == 'xml')
            {
                $ff = $this->dsComp->inv_comm_item_dir.$f;
                if(filesize($ff))
                {
                    // if it's not write protected get count
                    if(substr(sprintf('%o', fileperms('/etc/passwd')), -4) != '0644')
                    {
                        $doc = new DOMDocument('1.0');
                        $doc->load($ff);

                        $id = $doc->getElementsByTagName('id');

                        // if count is zero, protect
                        if($this->find('count', array('conditions' => array('InvoicesItemsCommissionsItem.id' => (int)$id->item(0)->nodeValue))) == 0)
                        {
                            echo 'Protecting '.$ff."\n";
                            chmod($ff, 0444);
                        }
                    }
                }
            }
        }
    }
    private function get_employee_list(){

        $emp_list = array();
        $employees = $this->empModel->find('all');
        foreach($employees as $employee)
        {
            $emp_list[$employee['Employee']['id']] = $employee['Employee'];
        }
        return ($emp_list);
    }
    private function cache_bucket_of_invoiceitems ($items){

        $report_dir = self::$xml_home.'commissions_reports/';
        foreach ($items as $item)
        {
            echo '.';
            $hash = self::$hu->id_date_hash($item['InvoicesItemsCommissionsItem']['employee_id'], $item['InvoicesItemsCommissionsItem']['date']);
            $report_file = $report_dir.$hash.'.xml';
            // skip nonsense dates before epoch
            $emp_list = $this->get_employee_list();
            $epoch = Configure::read('epoch');
            $filename = self::$dsComp->inv_comm_item_filename($item['InvoicesItemsCommissionsItem']['id']);
            if(strtotime ($item['InvoicesItemsCommissionsItem']['date']) >= $epoch)
            {
                // skip non-existant employees
                if(array_key_exists ($item['InvoicesItemsCommissionsItem']['employee_id'], $emp_list))
                    self::$xmlComp->link_comm_item($report_file, $item['InvoicesItemsCommissionsItem']['id'],
                        $emp_list[$item['InvoicesItemsCommissionsItem']['employee_id']],
                        $item['InvoicesItemsCommissionsItem']['date']);

                if(!file_exists ( $filename ) )
                {
                    $this->sync($item,$filename);
                }
                else
                {
                    if (strtotime($item['InvoicesItemsCommissionsItem']['modified_date']) > strtotime($item['InvoicesItemsCommissionsItem']['last_sync_time']))
                    {
                        $this->sync($item,$filename);
                    }
                }
            }
        }
        echo "\n";
    }
    public function cache_comm_items($bucket) {
        ini_set('memory_limit', '-1');
        echo "in Model\n";
        // Cache up employees to reduce queries

        $emp_list = $this->get_employee_list();

        echo "Caching invoice commissions items into transactions archive...\n";

        $this->unbindModel(array('belongsTo' => array('Employee', 'CommissionsReport'),),false);


        switch ($bucket) {
            case '1':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id < 1000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));
                $this->cache_bucket_of_invoiceitems($items);
                break;

            case '2':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id > 999 and InvoicesItemsCommissionsItem.id < 2000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));

                $this->cache_bucket_of_invoiceitems($items);
                break;
            case '3':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id > 1999 and InvoicesItemsCommissionsItem.id < 3000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));

                $this->cache_bucket_of_invoiceitems($items);
                break;
            case '4':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id > 2999 and InvoicesItemsCommissionsItem.id < 4000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));

                $this->cache_bucket_of_invoiceitems($items);
                break;
            case '5':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id > 3999 and InvoicesItemsCommissionsItem.id < 5000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));

                $this->cache_bucket_of_invoiceitems($items);
                break;
            case '6':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id > 4999 and InvoicesItemsCommissionsItem.id < 6000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));

                $this->cache_bucket_of_invoiceitems($items);
                break;
            case '7':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id > 5999 and InvoicesItemsCommissionsItem.id < 7000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));

                $this->cache_bucket_of_invoiceitems($items);
                break;
            case '8':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id > 6999 and InvoicesItemsCommissionsItem.id < 8000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));

                $this->cache_bucket_of_invoiceitems($items);
                break;
            case '9':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id > 7999 and InvoicesItemsCommissionsItem.id < 9000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));

                $this->cache_bucket_of_invoiceitems($items);
                break;
            case '10':
                $items = $this->find('all', array('conditions' => array('InvoicesItemsCommissionsItem.id > 8999 and InvoicesItemsCommissionsItem.id < 10000'), 'order' => array('InvoicesItemsCommissionsItem.modified_date' => 'desc')));

                $this->cache_bucket_of_invoiceitems($items);
                break;
        }

    }
}