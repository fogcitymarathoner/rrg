<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 1/25/14
 * Time: 6:20 PM
 */


class CommissionsComponent
{
    public function reportID_fromdate($date) {
        // local epic 2009-06-01
        /*
         * $date is the date array from form helper
         */
        $startMonth = 6;
        $startYear = 2009;

        $endMonth = $date['month'];
        $endYear = $date['year'];
        $report =   (($endYear - $startYear) * 12 + ($endMonth - $startMonth) + 1);
        return ( $report  );
    }


    public function period_from_id($id)
    {
        /* returns period string from period id
        */
        $startMonth = 6;
        $startYear = 2009;
        $month = $id - 1;
        $periodstart = strtotime(date("Y-m-d", strtotime($startYear.'-'.$startMonth.'-1')) . "+".$month." months");
        $monthdays = date("t",$periodstart)-1;
        $periodend = strtotime(date("Y-m-d", $periodstart) . "+".$monthdays." days");

        return ( date('m/d/Y', $periodstart).' - '.date('m/d/Y', $periodend) );
    }
    public function get_all_periods()
    {
        /* creates array for looking up period information, having commreportid
        */
        $i = 0;

        $startMonth = 6;
        $startYear = 2009;
        $month = $i - 1;
        $periodstart = strtotime(date("Y-m-d", strtotime($startYear.'-'.$startMonth.'-1')) . "+".$month." months");
        $monthdays = date("t",$periodstart)-1;
        $periodend = strtotime(date("Y-m-d", $periodstart) . "+".$monthdays." days");
        while ($periodstart < time())
        {
            $res[$i] = array('id'=>$i+1, 'start' => date('Y-m-d H:i:s', $periodstart), 'end'=> date('Y-m-d H:i:s', $periodend));

            $i++;
            $periodstart = strtotime(date("Y-m-d", strtotime($startYear.'-'.$startMonth.'-1')) . "+".$i." months");
            $monthdays = date("t",$periodstart)-1;
            $periodend = strtotime(date("Y-m-d", $periodstart) . "+".$monthdays." days");

        }
        return $res;
    }
}