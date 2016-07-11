<?php

App::import('Model', 'Invoice');

class UpdateInvoiceTotalsShell extends Shell {
	function main() {
		$Invoice = new Invoice;
		$Invoice->recursive = 0;
		$invoices =  $Invoice->find('all',array('conditions id>0'));
		foreach ($invoices as $invoice)
		{
			print $invoice['Invoice']['id'];
			$Invoice->updateTotal($invoice['Invoice']['id']);
		}
	}
}
?>