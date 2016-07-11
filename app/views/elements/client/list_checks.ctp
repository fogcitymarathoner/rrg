<?php

        function client_checks_view($checks,$next=null,$webroot, $print=False)
        {
        $i = 0;
        $res ='';
        $res .= '<h3>Checks</h3>';
        if(isset($checks))
        {
        if (!empty($checks))
        {
        $res .= '<table cellpadding = "0" cellspacing = "0">';
        $res .= '<tr>';
        $res .= '<th>Number</th>';
        $res .= '<th>Date</th>';
        $res .= '<th>Amount</th>';
        $res .= '<th>Notes</th>';
        if($print)
        {
        $res .= '<th class="actions">Actions</th>';
        }
        $res .= '</tr>';
        $total = 0;
        foreach ($checks as $clientsCheck):
        $class = null;
        if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
        }
        $res .= '<TR '.$class.'>';
        $res .= '<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">';
        $res .= '<a href="'.$webroot.'/clients/view_check/'.$clientsCheck['id'].'">'.$clientsCheck['number'].'</a>';
        $res .= '</div></td>';
        $res .= '<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex; border-right-width:2px; padding-right:0.5ex">';
        $res .= date('m/d/Y',strtotime($clientsCheck['date']));

        $res .= "</div></td>";
        $res .= '<td align=right ><div style="border: solid 0 #060; border-right-width:2px; padding-right:0.5ex">';
        $res .= sprintf('%01.2f',$clientsCheck['amount']);
        $res .= "</div></td>";
        $res .= '<td><div style="padding-left: 2px;">';
        $res .= $clientsCheck['notes'];
        $res .= "</div></td>";
        if($print)
        {
        $res .= '<td>';
        $res .= '<a href="'.$webroot.'clients/edit_check/'.$clientsCheck['id'].'/next:'.$next.'">|edit|</a>';
        $res .= '<a href="'.$webroot.'clients/view_check/'.$clientsCheck['id'].'">|view|</a>';
        $res .= '<a href="'.$webroot.'clients/delete_check/'.$clientsCheck['id'].'" onclick="return confirm(&#039;Are you sure you want to delete # '.$clientsCheck['id'].'?&#039;);">|delete|</a></td>';

        $res .= "</td>";
        }
        $res .= "</tr>";
        $total += $clientsCheck['amount'];
        endforeach;
        $res .= '<tr><td></td><td></td><td align=right >'.sprintf('%01.2f',$total).'</td></tr>';
        $res .= "</table>";
        }
        }
        return $res;
        }

        ?>
        <?php echo client_checks_view($checks,$next=null,$webroot); ?>
