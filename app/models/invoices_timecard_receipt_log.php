<?php
class InvoicesTimecardReceiptLog extends AppModel {

	var $name = 'InvoicesTimecardReceiptLog';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Invoice' => array(
			'className' => 'Invoice',
			'foreignKey' => 'invoice_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    function delete_old_cleared()
    {
        echo 'Deleting Old Cleared Logs';
        $nintyDaysback = mktime(0, 0, 0, date("m")  , date("d")-90, date("Y"));
        $str90 = date("Y-m-d",$nintyDaysback);
        //debug('hi');
        //debug($str90);exit;
        echo $str90;
        $this->recursive = 1;
        $this->data = $this->find('all',array('conditions'=>array(
            'date < "'.$str90.'"'
        )));
        //'Invoice.date <'.$str90
        foreach($this->data as $log)
        {
            //
            if($log['Invoice']['cleared']&& $log['Invoice']['prcleared'])
            {
                $this->delete($log['InvoicesTimecardReceiptLog']['id']);
            }
        }
        //print_r($this->data);exit;
    }
}
?>