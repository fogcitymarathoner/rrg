<?php

        function opens($opens,$webroot)
        {
        $res = '<div style=" display: block; float:left"><h2>Open Invoices</h2>

        <table cellpadding = "3" cellspacing = "3" border=1 >
        <tr>
        <th>ID</th>
        <th>Client</th>
        <th colspan=2>Employee</th>
        <th>Period</th>
        <th>Date</th>
        <th>Due Date</th>
        <th>Amount</th>
        <th></th>
        </tr>		 ';
        if (!empty($opens))
        {
        $i = 0;
        foreach($opens as $invoice):

        $class = null;
        if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
        }
        $res .= '<tr '.$class. '>';
        $res .= '<td colspan="1" ><a href="'.$webroot.'/invoices/view/'.$invoice['Invoice']['id'].'">'.$invoice['Invoice']['id'].'</a></td>';
        $res .= '<td colspan="1" >'.$invoice['ClientsContract']['Client']['name'].'</td>

        <td colspan="2" >';
        if ($invoice['ClientsContract']['employee_id'])
        {
        $res .=  '<b>'.$invoice['ClientsContract']['Employee']['firstname'].' ';
        if($invoice['ClientsContract']['Employee']['nickname']!='')
        {
        $res .=  '('.$invoice['ClientsContract']['Employee']['nickname'].') ';
        }
        $res .=  $invoice['ClientsContract']['Employee']['lastname'].'</b><br>';
        if(count($invoice['InvoicesPostLog']))
        {
        foreach ($invoice['InvoicesPostLog'] as $log)
        {
        $res .=  $log['email'].':<br>'.$log['timestamp'].'<br>';
        }
        } else
        {
        $res .=  'INVOICE NEVER POSTED';
        }
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
        $res .= '<td align="center">';
        $res .=  date('m/d/Y', strtotime($invoice['Invoice']['date']));
        $res .= '<td align="center">';
        $res .=  date('m/d/Y', strtotime($invoice['Invoice']['duedate']));
        $res .= '<td align="right">';
        $res .=  sprintf('%8.2f',round($invoice['Invoice']['amount'],2));
        //$res .= '<a href="'.$webroot.'reminders/transition_timecard/'.$invoice['Invoice']['id'].'">timecard</a></td>';
        $res .= '<td align="left">';
        //debug($invoice)		 ;
        $res .= '<form name=xx autocomplete="off" class="user_data_form">';
        if ($invoice['Invoice']['voided'] == 0)
        {
        $res .= '<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Up\','.$invoice['Invoice']['id'].',\''.$webroot.'\')" value="Voided"> Voided
        <input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Down\','.$invoice['Invoice']['id'].',\''.$webroot.'\')"
        value="Unvoided" checked> Unvoided';
        } else {
        $res .= '<input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Up\','.$invoice['Invoice']['id'].',\''.$webroot.'\')"
        value="Willing" checked> Voided
        <input type="radio" name="invoice_void_'.$invoice['Invoice']['id'].'" onClick="invoice_void(\'Down\','.$invoice['Invoice']['id'].',\''.$webroot.'\')"
        value="Unvoided"> Unvoided';
        }
        $res .= '</form>';
        $res .= '<a href="'.$webroot.'reminders/resend_to_staff/'.$invoice['Invoice']['id'].'">resend to staff</a>';
        $res .= '/';
        $res .= '<a href="'.$webroot.'reminders/view_open_invoice/'.$invoice['Invoice']['id'].'">radmin view</a>';
        $res .= '</td>';
        $res .= '</tr>';
        endforeach;
        } else {
        $res .= '<tr>
        <td colspan="2">No records</td>
        </tr> 	';
        }
        $res .= '</table></div>';
        return $res;

        }

        ?>
<?php echo opens($opens,$webroot) ?>