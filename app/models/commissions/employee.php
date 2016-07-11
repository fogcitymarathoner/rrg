<?php
/*
 *  Link opening Commissions items to Invoice items and Invoices
 *     `invoices_items_commissions_items` opening = True, ItemId = 0
 *
 * Make sure Employee delete method deletes Invoice and Invoice Item
 *
 * Make sure new Employee fills in OpeningInvoiceID
 *
 *
 */

App::import('Model', 'Employee');

class EmployeeCommissions extends Employee {

    private function generate_employee_commissions_tags($employee)
    {
        /*
         * generate missing employee comm report tags
         */

        $report_periods = $this->commsComp->get_all_periods();

        $this->CommissionsReportsTag->recursive = 0;
        foreach( $report_periods as $per)
        {
	    print 'period number in generator - '.$per['id'];
            print $this->commsComp->period_from_id($per['id']).' - '.$per['id']."\n";
            $count = $this->CommissionsReportsTag->find('all',array('conditions'=>array(
                'employee_id'=>$employee['Employee']['id'],
                'commissions_report_id'=>$per['id'],
            )));
            if (count($count) == 0)
            {
                print "making period tag for ".$this->commsComp->period_from_id($per['id']).' - '.$per['id']."\n";

                $taggedreport['CommissionsReportsTag']['id'] = Null;
                $taggedreport['CommissionsReportsTag']['comm_balance'] = 0;
                $taggedreport['CommissionsReportsTag']['note_balance'] = 0;
                $taggedreport['CommissionsReportsTag']['cleared'] = 0;
                $taggedreport['CommissionsReportsTag']['release'] = 0;
                $taggedreport['CommissionsReportsTag']['employee_id'] = $employee['Employee']['id'];
                $taggedreport['CommissionsReportsTag']['commissions_report_id'] = $per['id'];
                $taggedreport['CommissionsReportsTag']['name'] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
                $this->CommissionsReportsTag->save($taggedreport);
		debug( $this->CommissionsReportsTag->find('all',array('conditions'=>array(
                'employee_id'=>$employee['Employee']['id'],
                'commissions_report_id'=>$per['id'],
            ))));

            }
        }
    }

    private function generatetaggedreportsemployee($employee)
    {

        /*
         * generatetaggedreportsemployee:
         * given employee_id
         * if active and in sales force,
         * generate the monthly summary, of notes and commissions balances.
         *
         */
        $this->recursive = 2;
        if ($employee['Employee']['active'] == 1 ) // some employees have been deleted, skip
        {
            /*
             * generate missing employee comm report tags
             */
            $this->generate_employee_commissions_tags($employee);
            $this->CommissionsReportsTag->recursive = 1;
            $tagged_reports = $this->CommissionsReportsTag->find('all',
                array('conditions'=>array('employee_id'=>$employee['Employee']['id']),
                    'order'=>'commissions_report_id asc'
                ));
            $i = 0;
            foreach ($tagged_reports as $taggedreport):
                //debug($taggedreport);exit;
                print '    '.$this->commsComp->period_from_id($taggedreport['CommissionsReportsTag']['commissions_report_id'])."\n";
                //
                // skipped cleared commissions
                //
                if($taggedreport['CommissionsReportsTag']['cleared']==0)
                {
                    print '      '.'Period not cleared, calculation balances'."\n";
                    $comms = array();
                    $increaseC = 0;
                    $increaseN = 0;
                    if($i)
                    {
                        $previous_rpt_id = $tagged_reports[$i-1] ['CommissionsReportsTag']['id'];
                        $previousrpt = $this->CommissionsReportsTag->read(NULL,$previous_rpt_id);
                        $previousC = $previousrpt ['CommissionsReportsTag']['comm_balance'];
                        $previousN = $previousrpt ['CommissionsReportsTag']['note_balance'];
                    }else
                    {
                        $previousC = 0;
                        $previousN = 0;
                    }
                    $increaseC = $this->commissionIncrease($taggedreport,$employee);
                    $decreaseC = $this->commissionDecrease($taggedreport,$employee);
                    $taggedreport['CommissionsReportsTag']['comm_balance'] = $previousC+ $increaseC-$decreaseC;
                    $increaseN = $this->noteIncrease($taggedreport,$employee);
                    $decreaseN = $this->noteDecrease($taggedreport,$employee);
                    $taggedreport['CommissionsReportsTag']['note_balance'] = $previousN+ $increaseN-$decreaseN;
                    $taggedreport['CommissionsReportsTag']['name'] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
                    $this->CommissionsReportsTag->save($taggedreport);

                }
                $i++;
            endforeach;
        }
    }

    /*
     * Generates the Employee-Month 'Tag' associate record
     */
    function generatetaggedreports()
    {
        ini_set('memory_limit', '-1');
        Configure::write('debug', 2);

        print "Employee model generatetaggedreports\n";
        $this->recursive = 0;
        $employees = $this->find('all',NULL);

        foreach ($employees as $employee):
            if($employee['Employee']['salesforce'] == 1)
            {
                print "  Generating reports for ".$employee['Employee']['firstname'].' '.$employee['Employee']['lastname']."\n";
                $this->generatetaggedreportsemployee($employee);
            }
        endforeach;
    }

}
?>
