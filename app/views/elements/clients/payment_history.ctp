



<table border=1>
    <tr>
        <th>Date</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Terms</th>
        <th>Due Date</th>
        <th>Cleared Date</th>
        <th>Performance</th>
    </tr>';
    <?php
    // Define $color=1
    $color="1";
    $totalsales = 0;
    $totalbalance = 0;

    foreach ($items as $inv)
    {
    //debug($inv);exit;
    if (isset($inv[4]) && $inv[6])
    {
        $pos = strpos($inv[1],'check');

        if($pos === False)
        {
            if (isset($inv[2]))
            ;
            //$totalbalance += $inv[2];
            if (isset($inv[2]) && $inv[2]>0)
            ;
            //$totalsales += $inv[2];
            // If $color==1 table row color = #FFC600
            if($color==1){

            if (!$print)
            {
                echo '<tr bgcolor="#FFC600">';
            } else
            {
                echo '<tr bgcolor="white">';
            }
            echo  '';
            echo  '<td>'.date('m/d/Y',strtotime($inv[0])).'</td>';
            echo  '<td >'.$inv[1].'</td>';
            echo  '<td align="right">'.
                sprintf('%8.2f',round($inv[2],2))
                .'</td>';
            echo  '<td >'.$inv[3].'</td>';
            echo  '<td >'.date('m/d/Y',strtotime($inv[5])).'</td>';
            echo  '<td >'.date('m/d/Y',strtotime($inv[6])).'</td>';

            $start_ts = strtotime($inv[6]);

            $end_ts = strtotime($inv[5]);

            $diff = $end_ts - $start_ts;

            $diff =  round($diff / 86400);
            echo  '<td >'.$diff.'</td>';
            echo  '</tr>';
            // Set $color==2, for switching to other color
            $color="2";
            }

            // When $color not equal 1, use this table row color
            else {
            if (!$print)
            {
            echo  '<tr bgcolor="#C6FF00">';
            } else
            {

            echo  '<tr bgcolor="#EFEFEF">';
            }
            echo  '';
            echo  '<td>'.date('m/d/Y',strtotime($inv[0])).'</td>';
            echo  '<td >'.$inv[1].'</td>';
            echo  '<td align="right">'.
                sprintf('%8.2f',round($inv[2],2))
                .'</td>';
            echo  '<td >'.$inv[3].'</td>';
            echo  '<td >'.date('m/d/Y',strtotime($inv[5])).'</td>';
            echo  '<td >'.date('m/d/Y',strtotime($inv[6])).'</td>';
            $start_ts = strtotime($inv[6]);

            $end_ts = strtotime($inv[5]);

            $diff = $end_ts - $start_ts;

            $diff =  round($diff / 86400);
            echo  '<td >'.$diff.'</td>';
            echo  '</tr>';
            $color="1";
            }
            }
        }
    }
    echo  '	</table><br>';
?>