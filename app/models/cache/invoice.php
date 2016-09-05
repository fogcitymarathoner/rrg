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