<h2 class='reminders-page-title'>Timecard Timecards</h2>
<div id='timecards-index'></div>
<?php

        function timecards($timecards,$webroot)
	{
		$res = '<div style=" display: block; float:left"><h2>Timecards for Invoicing</h2>
<p>
Invoices may be found here after preview /php-apps/cake.rocketsredglare.com/biz/data/invoices/
</p>

<table cellpadding = "3" cellspacing = "3" border=1 >
    <tr>
        <th>Client</th>
        <th colspan=2>Employee</th>
        <th>Period</th>
        <th>Amount</th>
        <th></th>
    </tr>		 ';
    if (!empty($timecards))
    {
    $i = 0;
    foreach($timecards as $invoice):
    $class = null;
    if ($i++ % 2 == 0) {
    $class = ' class="altrow"';
    }
    $res .= '<tr '.$class. '>';

    $res .= '<td colspan="1" ><a href="'.$webroot.'clients/view/';
    $res .= $invoice['ClientsContract']['Client']['id'];
    $res .= '"> '.$invoice['ClientsContract']['Client']['name'].'</td> <td colspan="2" >';
        if ($invoice['ClientsContract']['employee_id'])
        {
        $res .=  '<b>'.$invoice['ClientsContract']['Employee']['firstname'].' ';
            if($invoice['ClientsContract']['Employee']['nickname']!='')
            {
            $res .=  '('.$invoice['ClientsContract']['Employee']['nickname'].') ';
            }
            $res .=  $invoice['ClientsContract']['Employee']['lastname'].'</b><br>';
        if(count($invoice['InvoicesTimecardReminderLog']))
        {
        foreach ($invoice['InvoicesTimecardReminderLog'] as $log)
        {
        $res .=  $log['email'].':<br>'.$log['timestamp'].'<br>';
        }
        } else
        {
        $res .=  'NO POST EMAILS<br>';
        }
        }

        $res .= "<b>Client Manager Distribution</b><br>";
        if(count($invoice['ClientsContract']['ClientsManager']))
        {
        foreach ($invoice['ClientsContract']['ClientsManager'] as $man)
        {
        $res .=  $man['firstname'].' ' .$man['lastname'].'<br>';
        $res .=  $man['email'].'<br>';
        }
        } else
        {
        $res .=  'NO MANAGERS TO EMAIL<br>';
        }
        $res .= "<b>Staff Distribution</b><br>";
        if(count($invoice['ClientsContract']['User']))
        {
        foreach ($invoice['ClientsContract']['User'] as $staff)
        {
        $res .=  $staff['firstname'].' ' .$staff['lastname'].'<br>';
        $res .=  $staff['email'].'<br>';
        }
        } else
        {
        $res .=  '<br>NO STAFF TO EMAIL<br>';
        }
        $res .= '</td>';
    if($invoice['Invoice']['period_start'])
    {
    $res .= '<td align="right" ><b>';
    $res .=  date('m/d/Y', strtotime($invoice['Invoice']['period_start'])).'-<br>'.date('m/d/Y', strtotime($invoice['Invoice']['period_end']));
    $res .= '</b></td>';
    } else {
    $res .= '<td align="right" ></td> ';
    }
    $res .= '<td align="right">';
    $res .= sprintf('%8.2f',round($invoice['Invoice']['amount'],2)).'</td>';
    $res .= '<td>';
    $res .= '<a href="'.$webroot.'reminders/edit_invoice/1/'.$invoice['Invoice']['id'].'">edit</a> |';
    $res .= '<a href="#" onclick="openWindow(\''.$webroot.'reminders/previewpdf/'.$invoice['Invoice']['id'].'\')">preview</a> |';
    $res .= '<form name=xx autocomplete="off" class="user_data_form">';
        if ($invoice['Invoice']['voided'] == 0)
        {
        $res .= '<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Up\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" value="Voided"> Voided
        <br>
        <input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Down\','.$invoice['Invoice']['id'].',\''.$webroot.'\')"
               value="Unvoided" checked> Unvoided';
        } else {
        $res .= '<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Up\','.$invoice['Invoice']['id'].',\''.$webroot.'\')"
                        value="Willing" checked> Voided
        <br>
        <input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Down\','.$invoice['Invoice']['id'].',\''.$webroot.'\')"
               value="Unvoided"> Unvoided';
        }
        $res .= '</form>';

    if($invoice['Invoice']['postenable'])
    {
    $res .= '<a href="'.$webroot.'reminders/post/'.$invoice['Invoice']['id'].'">post</a>';
    } else {
    $res .= 'post';
    }
    $res .= '</td>';
    $res .= '</tr>';
    $res .= '</tr>';
    $res .= '<tr>';
    $res .= '<td colspan=6>';
        $res .= $invoice['Invoice']['notes'];
        $res .= '</td></tr>';

    endforeach;
    } else {
    $res .= '<tr>
    <td colspan="2">No records</td>
</tr> 	';
    }
    $res .= '</table></div>';
return $res;

}
echo timecards($timecards,$webroot);
