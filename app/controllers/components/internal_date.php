<?php
class InternalDateComponent extends Object {
/**
 * Finds the difference in days between two calendar dates.
 *
 * @param Date $startDate
 * @param Date $endDate
 * @return Int
 */
	function dateDiff($startDate, $endDate)
	{
	    // Parse dates for conversion
        $endArry = getdate(strtotime($endDate));

        // Convert dates to Julian Days
        // $start_date = gregoriantojd(date('m',strtotime($startArry["month"])), $startArry["mday"], $startArry["year"]);
        // $end_date = gregoriantojd(date('m',strtotime($endArry["month"])), $endArry["mday"], $endArry["year"]);

        // Return difference
	    // return round(($end_date - $start_date), 0);
		return(0);
	}	


}
?>