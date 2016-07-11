<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marc
 * Date: 12/4/13
 * Time: 2:14 PM
 * To change this template use File | Settings | File Templates.
 */
// require_once("XML/Serializer.php");

require_once dirname(__FILE__) . '/../../XML/Serializer.php';

App::import('Model', 'Invoice');

if(!class_exists('InvoiceCache')) {  // Hard to fix

    class InvoiceCache extends Invoice
    {

        private function invoiceFilename($invoice, $employee)
        {
            $filename = Configure::read('invoice_prefix') . 'invoice_' . $invoice['Invoice']['id'] . '_';
            $filename .= $employee['firstname'] . '_';
            if ($employee['nickname']) {
                $filename .= $employee['nickname'] . '_';
            }
            $filename .= $employee['lastname'] . '_';
            $filename .= $invoice['Invoice']['period_start'] . '_to_' . $invoice['Invoice']['period_end'] . '.pdf';
            return $filename;
        }

        private function sync($invoice, $fixfilename)
        {
            echo "\n" . 'Syncing to ' . $fixfilename . "\n";

            /* update individual invoice xml, if necessary */
            $this->ClientsContract->unbindModel(array('hasAndBelongsToMany' => array(
                'ClientsManager',
                'User',
            ),), false);
            $this->ClientsContract->unbindModel(array('belongsTo' => array(
                'Client',
                'Period',
            ),), false);
            $this->ClientsContract->unbindModel(array('hasMany' => array(
                'Invoice',
                'ContractsItem',
            ),), false);
            $contract = $this->ClientsContract->read(null, $invoice['Invoice']['contract_id']);
            $invoice['Invoice']['pdf_file_name'] = $this->invoiceFilename($invoice, $contract['Employee']);
            $invoice['Invoice']['employee_id'] = $contract['Employee']['id'];
            $invoice['Invoice']['employee'] = $contract['Employee']['slug'];

            if ($f = fopen($fixfilename, 'w')) {
                fwrite($f, $this->xmlComp->serialize_invoice($invoice));
                fclose($f);
            } else {
                print "could not open " . $fixfilename;
            }
            /* repair dates if there are problems */
            $invsave = array();
            $invsave['Invoice'] = $invoice['Invoice'];
            if ($invoice['Invoice']['created_user_id'] == Null)
                $invsave['Invoice']['created_user_id'] = 5;
            if ($invoice['Invoice']['modified_user_id'] == Null)
                $invsave['Invoice']['modified_user_id'] = 5;
            if ($invoice['Invoice']['modified_date'] == Null)
                $invsave['Invoice']['modified_date'] = date('Y-m-d H:i:s');
            if ($invoice['Invoice']['created_date'] == Null)
                $invsave['Invoice']['created_date'] = date('Y-m-d H:i:s');
            $invsave['Invoice']['last_sync_time'] = date('Y-m-d H:i:s');
            $this->save($invsave);
        }

        private function cache_bucket_of_invoices($invoices)
        {
            $options = array(
                XML_SERIALIZER_OPTION_INDENT => '    ',
                XML_SERIALIZER_OPTION_RETURN_RESULT => true
            );
            $serializer = &new XML_Serializer($options);  // still used
            echo "\n";
            foreach ($invoices as $invoice) {
                echo '.';
                $datearray = explode('-', $invoice['Invoice']['date']);
                $duedate = mktime(0, 0, 0, $datearray[1], $datearray[2] + $invoice['Invoice']['terms'], $datearray[0]);
                $today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                $invoice['Invoice']['duedate'] = date('Y-m-d', $duedate);
                $InvoicesItems = $invoice['InvoicesItem'];
                $InvoicesPayments = $invoice['InvoicesPayment'];
                $EmployeesPayments = $invoice['EmployeesPayment'];
                if ($invoice['Invoice']['cleared'] == 1) {
                    $ar['cleared'][] = $invoice['Invoice']['id'];
                } else {
                    $ar['open'][] = $invoice['Invoice']['id'];

                    if ($duedate < $today) {
                        $ar['pastdue'][] = $invoice['Invoice']['id'];
                    }
                }
                $invoice['InvoicesItem'] = array();
                $invoice['InvoicesPayment'] = array();
                $invoice['EmployeesPayment'] = array();
                foreach ($InvoicesItems as $item) {
                    $invoice['InvoicesItem'][] = $item['id'];
                }
                foreach ($InvoicesPayments as $item) {
                    $invoice['InvoicesPayment'][] = $item['id'];
                }
                foreach ($EmployeesPayments as $item) {
                    $invoice['EmployeesPayment'][] = $item['id'];
                }


                unset($invoice['InvoicesTimecardReminderLog']);
                unset($invoice['InvoicesPostLog']);
                unset($invoice['InvoicesTimecardReceiptLog']);
                unset($invoice['ClientsContract']);
                // skip and delete items with no contract id
                if ($invoice['Invoice']['contract_id']) {
                    $filename = $this->dsComp->invoice_filename($invoice['Invoice']['id']);
                    if (!file_exists($filename)) {
                        $this->sync($invoice, $filename);
                    } else {
                        if (strtotime($invoice['Invoice']['modified_date']) > strtotime($invoice['Invoice']['last_sync_time'])) {
                            $this->sync($invoice, $filename);
                        }
                    }
                } else {
                    // delete invoice with no contract
                    $this->delete($invoice['Invoice']['id']);
                }

            }

            echo "\n";
            $ar['date_generated'] = date('D, d M Y H:i:s');
            $f = fopen($this->xml_home . 'transactions/invoices/ar.xml', 'w');
            fwrite($f, $serializer->serialize($ar));
            fclose($f);
        }

        function cache_invoices($bucket)
        {

            ini_set('memory_limit', '-1');
            echo "Caching invoices into transactions archive" . $this->dsComp->invoicedir . "\n";
            $ar = array();
            $ar['all'] = array();
            $ar['open'] = array();
            $ar['pastdue'] = array();
            $ar['cleared'] = array();


            switch ($bucket) {
                case '1':
                    $invoices = $this->find('all', array('conditions' => array('Invoice.id < 1000'), 'order' => array('Invoice.modified_date' => 'desc')));
                    $this->cache_bucket_of_invoices($invoices);
                    break;

                case '2':
                    $invoices = $this->find('all', array('conditions' => array('Invoice.id > 999 and Invoice.id < 2000'), 'order' => array('Invoice.modified_date' => 'desc')));

                    $this->cache_bucket_of_invoices($invoices);
                    break;
                case '3':
                    $invoices = $this->find('all', array('conditions' => array('Invoice.id > 1999 and Invoice.id < 3000'), 'order' => array('Invoice.modified_date' => 'desc')));

                    $this->cache_bucket_of_invoices($invoices);
                    break;
                case '4':
                    $invoices = $this->find('all', array('conditions' => array('Invoice.id > 2999 and Invoice.id < 4000'), 'order' => array('Invoice.modified_date' => 'desc')));

                    $this->cache_bucket_of_invoices($invoices);
                    break;
            }

        }

        function delete_clear_zero_items()
        {
            echo "Deleting Old zeroed Invoice Items going back 90 days\n";
            $nintyDaysback = mktime(0, 0, 0, date("m")  , date("d")-90, date("Y"));
            $str90 = date("Y-m-d",$nintyDaysback);
            echo "  Dating back to ".$str90."\n";
            $this->recursive = 1;
            $this->data = $this->find('all',array('conditions'=>array(
                'Invoice.voided'=>0,
                "Invoice.cleared" => 1,
                'Invoice.date < "'.$str90.'"'
            )));
            echo "query made \n";
            if ($this->data ){
                foreach ($this->data as $invoice):
                    foreach ($invoice['InvoicesItem'] as $item)
                    {
                        if ($item['quantity']==0)
                        {
                            echo '.';
                            $this->InvoicesItem->delete($item['id']);
                        }
                    }
                endforeach;
                echo "\n";
            }
        }
        public function delete_old_void()
        {
            echo "Deleting Old Voided Invoices going back 90 days ...\n";
            $nintyDaysback = mktime(0, 0, 0, date("m")  , date("d")-90, date("Y"));
            $str90 = date("Y-m-d",$nintyDaysback);
            echo "  Dating back to ".$str90."\n";
            $this->recursive = 1;

            $this->data = $this->find('all', array('conditions'=>array(
                'Invoice.voided'=>1,
                "Invoice.notes" => null,
                'Invoice.date < "'.$str90.'"'
            )));

            //'Invoice.date <'.$str90
            echo "query made \n";
            if($this->data)
            {
                foreach ($this->data as $invoice):

                    $this->delete($invoice['Invoice']['id']);
                    $this->InvoicesItem->recursive =2;
                    $items = $this->InvoicesItem->find('all',array('conditions'=>array('invoice_id'=>$invoice['Invoice']['id'])));
                    foreach($items as $item):

                        echo '.';
                        $this->InvoicesItem->delete($item ['InvoicesItem'] ['id']);

                        foreach ($item['InvoicesItemsCommissionsItem'] as $commitem):

                            echo '.';
                            $this->InvoicesItem->InvoicesItemsCommissionsItem->delete($commitem['id']);
                        endforeach;
                    endforeach;

                endforeach;
                echo "\n";
            }
        }

    }
} // end of import guard