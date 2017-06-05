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

        foreach( $report_periods as $per)
        {
	    print 'period number in generator - '.$per['id'];
            print $this->commsComp->period_from_id($per['id']).' - '.$per['id']."\n";
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
                //
                // skipped cleared commissions
                //

                $i++;
            endforeach;
        }
    }

}
?>
