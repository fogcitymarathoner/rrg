<?php
        
	function client_memos_view($memos,$webroot)
	{
		$i = 0;
		$res ='';
		$res .= '<h3>Memos</h3>';
if (!empty($memos))
{
$res .= '<table cellpadding = "0" cellspacing = "0">';
    $res .= '<tr>';
        $res .= '<th>Date</th>';
        $res .= '<th>Notes</th>';
        $res .= '<th class="actions">Actions</th>';
        $res .= '</tr>';
    foreach ($memos as $clientsMemo):
    $class = null;
    if ($i++ % 2 == 0) {
    $class = ' class="altrow"';
    }
    $res .= '<TR '.$class.'>';
    $res .= '<td>';
        $res .= date('m/d/Y',strtotime($clientsMemo['date']));
        $res .= "</td>";
    $res .= '<td><div style="border: solid 0 #060; border-right-width:2px; padding-right:0.5ex; border-left-width:2px; padding-left:0.5ex">';
        $res .= $clientsMemo['notes'];
        $res .= "</div>";
        $res .= "</td>";
    $res .= '<td>';
        $res .= '<a href="'.$webroot.'clients/edit_memo/'.$clientsMemo['id'].'">|edit|</a>';
        $res .= '<a href="'.$webroot.'clients/delete_memo/'.$clientsMemo['id'].'" onclick="return confirm(&#039;Are you sure you want to delete # '.$clientsMemo['id'].'?&#039;);">|delete|</a></td>';
    $res .= "</td>";
    $res .= "</tr>";
    endforeach;
    $res .= "</table>";
}
return $res;
}
			echo client_memos_view($memos,$webroot);