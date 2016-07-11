<?php
class InvoiceFunctionComponent extends Object {

	# compares payments against invoice amount to calculate balances
	function calculateBalances($invoices)
	{
		$count = 0;
		foreach ($invoices as $invoice): 
			$balance = $invoices[$count]['Invoice']['amount'];
			foreach ($invoice['InvoicesPayment'] as $pay):
				$balance -= $pay['amount'];
			endforeach; 
			$invoices[$count]['Invoice']['balance'] = $balance;
			$count++;
		endforeach; 
		return $invoices;	
		
	}
	// Given a contract array, returns list of periods, 1=weekly, 2=semiweekly, 3=monthly
	function periodarray($contract)
	{
		// weekly periods
		if($contract['ClientsContract']['period_id']==1)
		{
			$startdatearray = explode('-',$contract['ClientsContract']['startdate']);
			$startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
			$week=-1;
			$periodstart = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2]-date('w',$startdatetime)+1+(7*$week) , $startdatearray[0]);
			$periodend = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2]-date('w',$startdatetime)+7+(7*$week) , $startdatearray[0]);
			$today = mktime(0, 0, 0, date("m")  , date("d")+7, date("Y"));
			while( $periodend < $today):
				$periodpicker_pre_reverse[] = date('m/d/Y',$periodstart).'-'.date('m/d/Y',$periodend);
				$week++;				
				$periodstart = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2]-date('w',$startdatetime)+1+(7*$week) , $startdatearray[0]);
				$periodend = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2]-date('w',$startdatetime)+7+(7*$week) , $startdatearray[0]);
			endwhile;
			foreach($periodpicker_pre_reverse as $period)
			{
				$period_pop = array_pop($periodpicker_pre_reverse);
				$periodpicker[]=$period_pop;
			}
		}
		// Semi Monthly
		if($contract['ClientsContract']['period_id']==2)
		{
			$startdatearray = explode('-',$contract['ClientsContract']['startdate']);
			$startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
			$month=-1;
			$first_of_month = mktime(0, 0, 0, $startdatearray[1]+$month, 1 , $startdatearray[0]);
			$lastday_of_month = mktime(0, 0, 0, $startdatearray[1]+$month+1, 1 , $startdatearray[0])-24*60*60;
			$firstday_of_next_month = mktime(0, 0, 0, date("m")+1  , date("d"), date("Y"));
			while( $lastday_of_month < $firstday_of_next_month):
				$month++;
				$first_of_month = mktime(0, 0, 0, $startdatearray[1]+$month, 1 , $startdatearray[0]);
				$fifteenth_of_month = mktime(0, 0, 0, $startdatearray[1]+$month, 15 , $startdatearray[0]);
				$sixteenth_of_month = mktime(0, 0, 0, $startdatearray[1]+$month, 16 , $startdatearray[0]);
				$lastday_of_month = mktime(0, 0, 0, $startdatearray[1]+$month+1, 1 , $startdatearray[0])-24*60*60;
				$periodpicker_pre_reverse[] = date('m/d/Y',$first_of_month).'-'.date('m/d/Y',$fifteenth_of_month);
				$periodpicker_pre_reverse[] = date('m/d/Y',$sixteenth_of_month).'-'.date('m/d/Y',$lastday_of_month);
			endwhile;
			foreach($periodpicker_pre_reverse as $period)
			{
				$period_pop = array_pop($periodpicker_pre_reverse);
				$periodpicker[]=$period_pop;
			}
		}
		// Monthly
		if($contract['ClientsContract']['period_id']==3)
		{
			$startdatearray = explode('-',$contract['ClientsContract']['startdate']);
			$startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
			$month=-1;
			$first_of_month = mktime(0, 0, 0, $startdatearray[1]+$month, 1 , $startdatearray[0]);
			$lastday_of_month = mktime(0, 0, 0, $startdatearray[1]+$month+1, 1 , $startdatearray[0])-24*60*60;
			$firstday_of_next_month = mktime(0, 0, 0, date("m")+1  , date("d"), date("Y"));
			while( $lastday_of_month < $firstday_of_next_month):
				$month++;
				$first_of_month = mktime(0, 0, 0, $startdatearray[1]+$month, 1 , $startdatearray[0]);
				$fifteenth_of_month = mktime(0, 0, 0, $startdatearray[1]+$month, 15 , $startdatearray[0]);
				$sixteenth_of_month = mktime(0, 0, 0, $startdatearray[1]+$month, 16 , $startdatearray[0]);
				$lastday_of_month = mktime(0, 0, 0, $startdatearray[1]+$month+1, 1 , $startdatearray[0])-24*60*60;
				$periodpicker_pre_reverse[] = date('m/d/Y',$first_of_month).'-'.date('m/d/Y',$lastday_of_month);
			endwhile;
			foreach($periodpicker_pre_reverse as $period)
			{
				$period_pop = array_pop($periodpicker_pre_reverse);
				$periodpicker[]=$period_pop;
			}
		}
		return $periodpicker;
	}	
	function currentperiod($periods)
	{
		$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$period_id = 0;
		foreach($periods as $period)
		{
			$dates = explode('-',$period);
			$startarray = explode('/',$dates[0]);
			$endarray = explode('/',$dates[1]);
			$startdate = mktime(0, 0, 0, $startarray[0], $startarray[1], $startarray[2]);
			$enddate = mktime(0, 0, 0, $endarray[0]+1, $endarray[1], $endarray[2]);
			if($today >= $startdate && $today < $enddate)
				return $period_id;
			$period_id++;
		}
	}
	function invoiceFilename($invoice,$employee)
	{
		$filename = Configure::read('invoice_prefix').'invoice_'.$invoice['Invoice']['id'].'_';
		$filename .= $employee['Employee']['firstname'].'_';
		if ($employee['Employee']['nickname'])
		{
			$filename .= $employee['Employee']['nickname'].'_';
		}
		$filename .= $employee['Employee']['lastname'].'_';
		$filename .= $invoice['Invoice']['period_start'].'_to_'.$invoice['Invoice']['period_end'].'.pdf';
		return $filename;
	}
	function invoiceFullyQualifiedFilename($invoice,$employee,$xml_home)
	{
        $invoicedir = $xml_home.'invoices/';
		$filename = $invoicedir.$this->invoiceFilename($invoice,$employee);
		return $filename;
	}
	function AdjustDatesBeforeSave($invoice)
	{
		$dateex = explode('/',$invoice['Invoice']['date']);
		$invoice['Invoice']['date'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
		$dateex = explode('/',$invoice['Invoice']['period_start']);
		$invoice['Invoice']['period_start'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
		$dateex = explode('/',$invoice['Invoice']['period_end']);
		$invoice['Invoice']['period_end'] = $dateex[2].'-'.$dateex[0].'-'.$dateex[1];
		return $invoice;
	}

    function email_subject($invoice, $employee)
    {
        $subject = configure::read('co_name').' Invoice '.$invoice['Invoice']['id'].' ';

        $employee_name = $employee['Employee']['firstname'].'_';
        if ($employee['Employee']['nickname'])
        {
            $employee_name .= $employee['Employee']['nickname'].'_';
        }
        $employee_name .= $employee['Employee']['lastname'].'_';
        $subject .= $employee_name;

        $subject .= ": for the period ".date('m/d/Y', strtotime($invoice['Invoice']['period_start'])).
            ' to '.date('m/d/Y', strtotime($invoice['Invoice']['period_end']));
        return $subject;
    }

    function invoiceTokenUrl($invoice, $subject, $webroot, $employee)
    {
        $url = '<a href="https://';
        // consistently using https
        $url .= Configure::read('server');


        $url .=  'invoices_external/view/'.$invoice['Invoice']['id'].
            '/'.$invoice['Invoice']['token'].'/'.$this->invoice_slug($invoice, $employee).'">'.
            $subject.'</a>';

        return $url;
    }

    function invoice_slug($invoice, $employee)
    {
        $slug = urlencode  (str_replace(' ','_',str_replace(':','_',str_replace('/','_',$this->email_subject($invoice, $employee)))));

        return $slug;
    }
    function period_formatted($invoice)
    {
        $result = array();
        $result[] = date("m/d/Y",strtotime($invoice['Invoice']['period_start']));
        $result[] = date("m/d/Y",strtotime($invoice['Invoice']['period_end']));
        return $result;
    }

    public function emailBody($invoice,$subject,$employee, $webroot)
    {

        $emailBody = 'Hi!,<br>The invoice is available here for your review. <br>'.
            $this->invoiceTokenUrl($invoice,$subject,$webroot,$employee).
            '<br>Please forward to AP with the commentary, "APPROVED".  <br>Thanks in advance.'.
            '<br>Rockets Redglare AR Dept.';
        return $emailBody;
    }

}
?>
