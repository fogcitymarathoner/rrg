<?php
//debug($this->viewVars['employee']);exit;
$filename = 'rocketsredglare_invoice_'.$invoice['Invoice']['id'].'_'.$employee['Employee']['firstname'].'_'.$employee['Employee']['lastname'].'_'.$invoice['Invoice']['period_start'].'_to_'.$invoice['Invoice']['period_end'].'.pdf';
    //$fpdf->pdfdoc($this->viewVars['invoice'],$this->viewVars['client'],$filename);  // allows us to do the page numbering
?> 