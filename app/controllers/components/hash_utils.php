<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 1/22/14
 * Time: 7:51 PM
 */

class HashUtilsComponent
{

    function since_epoch($id)
    {
        /*
         * returns hash list for $id-month since epoch
         */
        $epoch = Configure::read('epoch');
        $sdate = new DateTime("@$epoch");
        $edate = new DateTime();
        $startMonth = $sdate->format('m');
        $startYear = $sdate->format('Y');

        $endMonth = $edate->format('m');
        $endYear = $edate->format('Y');

        $endmonth = (($endYear - $startYear) * 12 + ($endMonth - $startMonth) + 1)-1;
        $res = array();
        for($i=0; $i<=$endmonth; $i++)
        {
            $emp_mon =  str_pad((string)$id, 5, "0", STR_PAD_LEFT).'-'.str_pad((string)$i, 5, "0", STR_PAD_LEFT);
            $res[] = hash('md5', $emp_mon);
        }
        return $res;
    }


    public function id_date_hash($id, $date)
    {
        $emp_mon =  str_pad((string)$id, 5, "0", STR_PAD_LEFT).'-'.str_pad((string)$this->epoch_month_number($date), 5, "0", STR_PAD_LEFT);

        $res = hash('md5', $emp_mon);

        return $res;
    }

    public function id_comperiod_hash($id, $commissions_report)
    {
        $emp_mon =  str_pad((string)$id, 5, "0", STR_PAD_LEFT).'-'.str_pad((string)$commissions_report, 5, "0", STR_PAD_LEFT);

        return ($this->employee_commissions_report_hash_filename(hash('md5', $emp_mon)));

    }

    public function epoch_month_number($date)
    {

        /*
         * returns hash list for $id-month since epoch
         */
        $epoch = Configure::read('epoch');
        $sdate = new DateTime("@$epoch");
        $edate = new DateTime($date);
        $startMonth = $sdate->format('m');
        $startYear = $sdate->format('Y');

        $endMonth = $edate->format('m');
        $endYear = $edate->format('Y');

        $endmonth = (($endYear - $startYear) * 12 + ($endMonth - $startMonth) + 1)-1;

        return $endmonth;
    }

    public function months_since_epoch()
    {
        /*
         * return an array of month numbers since epoch
         *
         * the current commissions report number
         */

        $epoch = Configure::read('epoch');
        $sdate = new DateTime("@$epoch");
        $edate = new DateTime();
        $startMonth = $sdate->format('m');
        $startYear = $sdate->format('Y');

        $endMonth = $edate->format('m');
        $endYear = $edate->format('Y');

        $endmonth = (($endYear - $startYear) * 12 + ($endMonth - $startMonth) + 1)-1;
        return $endmonth;
    }

    public function since_epoch_list()
    {
        /*
         * returns hash list for $id-month since epoch
         * all the commissions reports numbers
         *
         * replaces find(all in generate commissions reports tag
         */
        $epoch = Configure::read('epoch');
        $sdate = new DateTime("@$epoch");
        $edate = new DateTime();
        $startMonth = $sdate->format('m');
        $startYear = $sdate->format('Y');

        $endMonth = $edate->format('m');
        $endYear = $edate->format('Y');

        $endmonth = (($endYear - $startYear) * 12 + ($endMonth - $startMonth) + 1)-1;
        $res = array();
        for($i=0; $i<=$endmonth; $i++)
        {
            $res[] = $i;
        }
        return $res;
    }
    public function employee_commissions_report_hash_filename($hash)
    {
        $this->xml_home = Configure::read('xml_home');
        return $this->xml_home.'commissions_reports/'.$hash.'.xml';
    }
}