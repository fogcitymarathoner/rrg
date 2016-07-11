<?php
class InvoiceToucher extends AppModel {

	var $name = 'InvoiceToucher';
	var $uses = array('Invoice','CommissionsReport');
	var $useTable = false;
	
	/*
	 * Make sure all invoices have a create and modified
	 */
   	function touch_invoices() {
    	App::import('Model', 'Invoice');
    	$this->Invoice = new Invoice;

           Configure::write('debug', 1);
        /*
         * First Invoices without create dates
         */
           $invoices =$this->Invoice->find('all',array('conditions'=>array('Invoice.created_date'=>Null)));
           if (!empty($invoices['Invoice']))
           {
               foreach($invoices as $inv)
               {
                   //debug($inv);
                   $inv['Invoice']['created_date'] = date('Y-m-d');
                   $this->Invoice->save($inv);
               }
           }
           /*
            *  Invoices without modified dates
            */
           $invoices = $this->Invoice->find('all',array('conditions'=>array('Invoice.modified_date'=>Null)));
           if (!empty($invoices['Invoice']))
           {
               foreach($invoices['Invoice'] as $inv)
               {
                   //debug($inv);
                   $inv['Invoice']['modified_date'] = date('Y-m-d H:m:s');
                   $this->Invoice->save($inv);
               }
           }
           /*
            *  Invoices without create users
            */
           $invoices = $this->Invoice->find('all',array('conditions'=>array('Invoice.created_user_id'=>Null)));
           if (!empty($invoices['Invoice']))
           {
               foreach($invoices['Invoice'] as $inv)
               {
                   //debug($inv);
                   $inv['Invoice']['created_user_id'] = 1;
                   $this->Invoice->save($inv);
               }
           }
           /*
            *  Invoices without modified users
            */
           $invoices = $this->Invoice->find('all',array('conditions'=>array('Invoice.modified_user_id'=>Null)));
           if (!empty($invoices['Invoice']))
           {
               foreach($invoices['Invoice'] as $inv)
               {
                   //debug($inv);
                   $inv['Invoice']['modified_user_id'] = 1;
                   $this->Invoice->save($inv);
               }
           }
    }
	
}
