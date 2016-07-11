<?php
class InvoicesExternalController extends AppController {

	var $name = 'Invoicesexternal';
	
	var $uses = array('Invoice');
	var $layout= 'default';

	function index()
	{
	}
   	function view()
   	{
        Configure::write('debug', 2);
   		$id = $this->params['pass'][0];
   		$token = $this->params['pass'][1];
   		$invoice = $this->Invoice->read(null, $id);
   		$invoice['Invoice']['view_count']++;
   		$this->Invoice->save($invoice);
		$moddate = explode('-',$invoice['Invoice']['modified_date']);
		$expire_time = mktime(0, 0, 0, (int)$moddate[1]+12, (int)$moddate[2], (int)$moddate[0]);
		$nowtime = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        if ($invoice['Invoice']['cleared'])
        {
            echo "Sorry Closed Matter";
            exit;
        }
        // fixme - case insensitive comparison
   		if ((int)strcasecmp($invoice['Invoice']['token'], $token)==0 && $nowtime < $expire_time)
   		{        	
   			$this->Invoice->generatepdf($id,1,$this->xml_home);
   		}
   	}

	function beforeFilter() {
        parent::BeforeFilter();
        $this->Auth->allowedActions = array('*', );
    }	
}
?>