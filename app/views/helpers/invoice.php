<?php

#App::import('Helper', 'Html');  # takes too much memory
class InvoiceHelper extends Helper {


	function search_results($invoices)
	{ 
		$html_result = '<table  border="1"  cellpadding="2" cellspacing="0">';		
		// Define $color=1
		$color="1";
	
		foreach ($invoices as $invoicedata)
		{
		    // If $color==1 table row color = #FFC600
			if($color==1){
				$html_result .= '<tr bgcolor="#FFC600"><td>';
				$html_result .= $this->searchInvoicelineout($invoicedata,$this->webroot);
				$html_result .= '</tr>';
				// Set $color==2, for switching to other color
				$color="2";
			}
			
			// When $color not equal 1, use this table row color
			else {
				$html_result .= '<tr bgcolor="#C6FF00"><td>';
				$html_result .= $this->searchInvoicelineout($invoicedata,$this->webroot);
				$html_result .= '</tr>';		
				$color="1";
			}
		}
		$html_result .= '	</table>	';
    	return $html_result;
	}

	function searchInvoicelineout($inv,$basedir)
	{
		$html_result = '<td align="left"><a href="'.$basedir.'/invoices/view/'.$inv['Invoice']['id'].'" >'.$inv['Invoice']['id'].'</a></td>';       
		$html_result .= '<td colspan="1" >'.$inv['ClientsContract']['Client']['name'].'</td>';
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
		return $html_result;	
	}
}
?>