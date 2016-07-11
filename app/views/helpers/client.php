<?php
class ClientHelper extends Helper {

    function m_clients_contracts_pending_invoices_view($invoices,$next)
    {
        $basedir = $this->webroot;
        $html_result = '<table>
		<tr>
		<th>id</th>
		<th>Employee</th>
		<th></th>
		<th>Period</th>
		<th>Date</th>
		<th>DueDate</th>
		<th>Amount</th>
		</tr>';
        // Define $color=1
        $color="1";
        foreach ($invoices as $inv)
        {
            if($inv['Invoice']['timecard']== 1 && $inv['Invoice']['posted']== 0 && $inv['Invoice']['voided']== 0)
            {
                if($color==1){
                    $html_result .= '<tr bgcolor="#FFC600">';
                    $html_result .= $this->m_invpendinglineout($inv,$basedir,$next);
                    $html_result .= '</tr>';
                    // Set $color==2, for switching to other color
                    $color="2";
                }

                // When $color not equal 1, use this table row color
                else {
                    $html_result .= '<tr bgcolor="#C6FF00">';
                    $html_result .= $this->m_invpendinglineout($inv,$basedir,$next);
                    $html_result .= '</tr>';
                    $color="1";
                }
            }
        }
        $html_result .= '	</table><br>';

        return $html_result;
    }

    function statementlineout($inv,$totalbalance,$basedir,$print,$next)
    {
        $html_result = '';
        $html_result .= '<td>'.date('m/d/Y',strtotime($inv[0])).'</td>';
        $html_result .= '<td >'.$inv[1].'</td>';
        $html_result .= '<td align="right">'.
            sprintf('%8.2f',round($inv[2],2))
            .'</td>';
        $html_result .= '<td align="right">'.
            sprintf('%8.2f',round($totalbalance,2))
            .'</td>';
        return $html_result;

    }
    function dateDiff($start, $end) {

        $start_ts = strtotime($start);

        $end_ts = strtotime($end);

        $diff = $end_ts - $start_ts;

        return round($diff / 86400);

    }

   function invindexlineout($inv,$basedir,$print,$next)
    {
        //debug($inv[0]);
            if (!$print)
            {
                $html_result = '<td align="left"><a href="'.$this->webroot.'clients/view_invoice/'.$inv['Invoice']['id'].'/next:'.$next.'" >'.$inv['Invoice']['id'].'</a></td>';
            } else
            {
                $html_result = '<td align="left"><a href="'.$this->webroot.'invoices_external/view/'.$inv['Invoice']['id'].'/'.$inv['Invoice']['token'].'/'.$inv['Invoice']['urlslug'].'" >'.$inv['Invoice']['id'].'</a></td>';
            }
        //exit;
            $html_result .= '<td colspan="2" >'; //debug($inv);exit;
            if($inv['ClientsContract']['employee_id'] != '')
            {
                $html_result .= $inv['ClientsContract']['Employee']['firstname'].' '.$inv['ClientsContract']['Employee']['lastname'];
            }
            $html_result .= '</td>';
            if($inv['Invoice']['period_start'] != '')
            {
                $html_result .= '<td align="right" >'.
                date('m/d/Y',strtotime($inv['Invoice']['period_start'])).'-'.
                date('m/d/Y',strtotime($inv['Invoice']['period_end'])).
                '</td>';
            }	else {
                $html_result .= '<td align="right" ></td> ';
            }
            $html_result .= '<td>'.date('m/d/Y',strtotime($inv['Invoice']['date'])).'</td>';
            $html_result .= '<td align=center>'.$inv['Invoice']['terms'].'</td>';
            $html_result .= '<td>'.date('m/d/Y',strtotime($inv['Invoice']['duedate'])).'</td>';
            $html_result .= '<td align="right">'.
                sprintf('%8.2f',round($inv['Invoice']['amount'],2))
            .'</td>';
            if (isset($inv['Invoice']['payments']))
            {
                $html_result .= '<td align="right">'.sprintf('%8.2f',round($inv['Invoice']['payments'],2)).'</td>';
            } else {

                $html_result .= '<td align="right">'.sprintf('%8.2f',0).'</td>';
            }
            if (isset($inv['Invoice']['balance']))
            {
                $html_result .= '<td align="right">'.sprintf('%8.2f',round($inv['Invoice']['balance'],2)).'</td>';
            } else {
                $html_result .= '<td align="right">'.sprintf('%8.2f',0).'</td>';
            }


            if (!$print)
            {
                if(empty($inv['InvoicesOpening']))
                {
                    $html_result .= '<td><a href="'.$this->webroot.'clients/edit_invoice/'.$inv['Invoice']['id'].'/next:'.$next.'" >Edit</a></td>';
                } else
                {

                    $html_result .= '<td><a href="'.$this->webroot.'clients/edit_openinginvoice/'.$inv['Invoice']['id'].'/next:'.$next.'" >Edit</a></td>';

                }

            }
            return $html_result;

            }
	function invpendinglineout($inv,$basedir,$next)
	{
			$html_result = '<td align="left"><a href="'.$this->webroot.'clients/edit_invoice/'.$inv['Invoice']['id'].'/next:'.$next.'" >'.$inv['Invoice']['id'].'</a></td>';       

			$html_result .= '<td colspan="2" >';
			if($inv['ClientsContract']['employee_id'] != '')
			{
				$html_result .= $inv['ClientsContract']['Employee']['firstname'].' '.$inv['ClientsContract']['Employee']['lastname'];
			}	
			$html_result .= '</td>';
			if($inv['Invoice']['period_start'] != '')
			{
				$html_result .= '<td align="right" >'.
				date('m/d/Y',strtotime($inv['Invoice']['period_start'])).'-'.
				date('m/d/Y',strtotime($inv['Invoice']['period_end'])).
				'</td>';        
			}	else {
				$html_result .= '<td align="right" ></td> ';       		
			}
			$html_result .= '<td>'.date('m/d/Y',strtotime($inv['Invoice']['date'])).'</td>';   
			$html_result .= '<td>'.date('m/d/Y',strtotime($inv['Invoice']['duedate'])).'</td>';   
			$html_result .= '<td align="right">'.
				sprintf('%8.2f',round($inv['Invoice']['amount'],2))
			.'</td>';    
			$html_result .= '<td><a href="'.$this->webroot.'clients/edit_invoice/'.$inv['Invoice']['id'].'/next:'.$next.'" >Edit</a></td>';   
  
			$html_result .= '<td><a href="'.$this->webroot.'clients/push_invoice_to_timecards/'.$inv['Invoice']['id'].'" >Push To Timecards</a></td>';   
			return $html_result;	
		
	}

    function m_invpendinglineout($inv,$basedir,$next)
    {
        $html_result = '<td align="left"><a href="'.$this->webroot.'clients/edit_invoice/'.$inv['Invoice']['id'].'/next:'.$next.'" >'.$inv['Invoice']['id'].'</a></td>';

        $html_result .= '<td colspan="2" >';
        if($inv['ClientsContract']['employee_id'] != '')
        {
            $html_result .= $inv['ClientsContract']['Employee']['firstname'].' '.$inv['ClientsContract']['Employee']['lastname'];
        }
        $html_result .= '</td>';
        if($inv['Invoice']['period_start'] != '')
        {
            $html_result .= '<td align="right" >'.
                date('m/d/Y',strtotime($inv['Invoice']['period_start'])).'-'.
                date('m/d/Y',strtotime($inv['Invoice']['period_end'])).
                '</td>';
        }	else {
            $html_result .= '<td align="right" ></td> ';
        }
        $html_result .= '<td>'.date('m/d/Y',strtotime($inv['Invoice']['date'])).'</td>';
        $html_result .= '<td>'.date('m/d/Y',strtotime($inv['Invoice']['duedate'])).'</td>';
        $html_result .= '<td align="right">'.
            sprintf('%8.2f',round($inv['Invoice']['amount'],2))
            .'</td>';
        $html_result .= '<td><a href="'.$this->webroot.'m/clients/edit_invoice/'.$inv['Invoice']['id'].'/next:'.$next.'" >Edit</a></td>';

        $html_result .= '<td><a href="'.$this->webroot.'m/clients/push_invoice_to_timecards/'.$inv['Invoice']['id'].'" >Push To Timecards</a></td>';
        return $html_result;

    }



}
