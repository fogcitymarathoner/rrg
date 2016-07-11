<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CachePayrollsShell extends Shell {
	var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {

        App::import('Model', 'Payroll');

        $payrollModel = new Payroll;

        $payrollModel->cache_payrolls();
        $payrollModel->check_for_cleared();
    	exit;
    	// Generate Reminders
    	
    	$reminderModel = new Reminder;
    	$reminderModel->generate();
    	/////
    	$commissionsReportsController = new CommissionsReportsController;
    	//$commissionsReportModel->reportID('2009-12-22 00:00:00');
    	exit;
    	$ci = new CommissionsReportsTagsItem;
    	$eo = new Employee;
		$eo->recursive = 2;
    	$employees =  $eo->find('list',null);
    	//debug($employee);exit;
    	foreach($employees as $emp):
    		//debug($emp);
    		$employee = $eo->read(null,$emp);
    		//debug($employee);exit;
    	//debug($employee[0]['CommissionsReportsTag']);exit;
	    	foreach($employee[0]['CommissionsReportsTag'] as $commreport):
	    		//debug($employee[0]['CommissionsReportsTag']);exit;
	    		//debug($commreport);exit;
	    		if($commreport['cleared']==0)
	    		{
		    		foreach($commreport['InvoicesItemsCommissionsItem'] as $commreportitem):
		    		//$eo->
		    			
		    			//debug($employee[0]['Employee']);
		    			//debug($commreportitem[0]['CommissionsItemsTag']);exit;
		    			if($employee[0]['Employee']['id']==$commreportitem['CommissionsItemsTag']['employee_id'])
		    			{
							//debug($commreportitem);
		    				$commitem = array();
			    			$commitem['CommissionsReportsTagsItem']['commissions_reports_tag_id']=$commreport['id'];
			    			
			    			$commitem['CommissionsReportsTagsItem']['invoices_items_commissions_item_id']=$commreportitem['CommissionsItemsTag']['invoices_items_commissions_items_id'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_items_commissions_item_employee_id']=$commreportitem['CommissionsItemsTag']['employee_id'];
			    			//$commitem['CommissionsReportsTagsItem']['invoices_items_commissions_item_invoices_item_id']=$commreportitem['invoices_item_id'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_items_commissions_item_commissions_report_id']=$commreportitem['commissions_report_id'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_items_commissions_item_percent']=$commreportitem['percent'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_items_commissions_item_amount']=$commreportitem['amount'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_items_commissions_item_cleared']=$commreportitem['cleared'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_items_commissions_item_voided']=$commreportitem['voided'];
			    			//debug($commreportitem);//exit;
			    			$invoiceitem = $eo->CommissionsReportsTag->InvoicesItemsCommissionsItem->InvoicesItem->find('all',array('conditions'=>array('InvoicesItem.id'=>$commreportitem['invoices_item_id'] )));
			    		
			    			//debug($invoiceitem);
			    			$commitem['CommissionsReportsTagsItem']['invoices_item_id']=$invoiceitem[0]['InvoicesItem']['id'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_id']=$invoiceitem[0]['InvoicesItem']['invoice_id'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_item_description']=$invoiceitem[0]['InvoicesItem']['description'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_item_amount']=$invoiceitem[0]['InvoicesItem']['amount'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_item_quantity']=$invoiceitem[0]['InvoicesItem']['quantity'];
			    			$commitem['CommissionsReportsTagsItem']['invoices_item_cost']=$invoiceitem[0]['InvoicesItem']['cost'];
			
			    			//debug($commitem);//exit;
			    			//$ci->create();
			    			//$ci->save($commitem);
			    			//exit;    			//debug($invoiceitem[0]['InvoicesItem']['id']);exit;
							//debug($invoiceitem);
		    			}
		    		endforeach;
	    		}
	    	endforeach;
    	endforeach;
    	exit;
        //debug($employee);exit;
        debug($eo->find('all',array('conditions'=>array('Employee.id'=>1025))));exit;
        $this->out('Demo Script');
        $this->hr();

        if (count($this->args) === 0) {
            $filename = $this->in('Please enter the filename:');
        } else {
            $filename = $this->args[0];
        }
        $this->createFile(TMP.$filename, 'Test content');
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
