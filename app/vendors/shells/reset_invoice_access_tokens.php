<?php

App::import('Model', 'Invoice');
App::import('Component', 'TokenHelper');

#
#
#
#   THIS ACTUALLY SETS!!!!!!!!!!!!
#
#  DO NOT REUSE
#
#
class ResetinvoiceAccessTokensShell extends Shell {
	function main() {
		$Invoice = new Invoice;
		$Tk = new TokenHelperComponent;
		$Invoice->recursive = 0;
		$invoices =  $Invoice->find('all',array('conditions id>0'));
		foreach ($invoices as $invoice)
		{
			$inv['Invoice']['id'] = $invoice['Invoice']['id'];
			$inv['Invoice']['token'] = $Tk->generatePassword();;
			print $inv['Invoice']['id'];
			print $inv['Invoice']['token'];
			$Invoice->save($inv);
			//$Invoice->updateTotal($invoice['Invoice']['id']);
		}
	}
}
?>