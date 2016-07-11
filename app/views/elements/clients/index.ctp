<?php
        $res = '';
		$i = 0;
		$reccount = 0;
		foreach ($clients as $client):
			if ($active == $client['Client']['active'])
			{
				$reccount++;
			}
		endforeach;
		if($reccount)
		{
			$res .= '<table cellpadding="0" cellspacing="0" border=1>';
$res .= '<tr>';
    $res .= '<th>Name</th>';
    $res .= '<th class="actions"><?php __("Actions");?></th>';
    $res .= '</tr>';

foreach ($clients as $client):
if ($active == $client['Client']['active'])
{
$class = null;
if ($i++ % 2 == 0) {
$class = ' class="altrow"';
}
$res .= '<TR '.$class.'>';
$res .= '<td>';
    $res .= '<div id="client'.$client['Client']['id'].'">';


    $res .= '<a href="'.$webroot.'clients/view/'.$client['Client']['id'].'">'.$client['Client']['name'].'</a>';


    $res .= '</div>';
    $res .= "</td>";
$res .= '<td>';

    //$res .= '<a href="'.$webroot.'clients/delete/'.$client['Client']['id'].'" onclick="return confirm(&#039;Are you sure you want to delete # '.$client['Client']['id'].'?&#039;);">|delete|</a></td>';
$res .= "</td>";
$res .= "</tr>";
}
endforeach;

$res .= "</table>";
} else { $res .= 'No Clients';}
echo $res;
