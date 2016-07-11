<?php
        function sent_receipts($opens)
        {
        $res = '<div style=" display: block; float:left"><h2>Sent Timecard Receipts</h2>

        <table cellpadding = "3" cellspacing = "3" border=1 >
        <tr>
        <th>Client</th>
        <th colspan=2>Employee</th>
        <th colspan=2>Period</th>
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
        if(count($invoice['InvoicesTimecardReceiptLog']))
        {
        foreach ($invoice['InvoicesTimecardReceiptLog'] as $log)
        {
        $res .=  $log['InvoicesTimecardReceiptLog']['email'].':<br>'.$log['InvoicesTimecardReceiptLog']['timestamp'].'<br>';
        }
        } else
        {
        $res .=  'TIMECARD  RECEIPT NEVER SENT<br>';
        }

        }

        $res .= '</td>';
        if($invoice['Invoice']['period_start'])
        {
        $res .= '<td align="right"  colspan=2><b>';
        $res .=  date('m/d/Y', strtotime($invoice['Invoice']['period_start'])).'-<br>'.date('m/d/Y', strtotime($invoice['Invoice']['period_end']));
        $res .= '</b></td>';
        } else {
        $res .= '<td align="right" ></td> ';
        }
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

        echo sent_receipts($opens);
