<?php

	function client_managers_view($managers,$webroot)
	{
		$i = 0;
		$res ='';
		$res .='<h3>Managers</h3>';
if (!empty($managers))
{
$res .='<table cellpadding = "0" cellspacing = "0">';
    $res .='<tr>';
        $res .='<th>Name</th>';
        $res .='<th>Title</th>';
        $res .='<th>Email</th>';
        $res .='<th>Phone1</th>';
        $res .='<th>Phone2</th>';
        $res .='<th class="actions">Actions</th>';
        $res .='</tr>';
    foreach ($managers as $clientsManager):
    $class = null;
    if ($i++ % 2 == 0) {
    $class = ' class="altrow"';
    }
    $res .= '<TR '.$class.'>';
    $res .= '<td><div style="border: solid 0 #060; border-right-width:2px; padding-right:0.5ex">';
        $res .= $clientsManager['firstname'];

        $res .= ' ';
        $res .= $clientsManager['lastname'];

        $res .= "</div></td>";
    $res .= '<td><div style="border: solid 0 #060; border-right-width:2px; padding-right:0.5ex">';
        if ($clientsManager['title'])
        {
        $res .= $clientsManager['title'];
        }else
        {
        $res .= '&nbsp';

        }

        $res .= "</div></td>";
    $res .= '<td><div style="border: solid 0 #060; border-right-width:2px; padding-right:0.5ex">';
        if ($clientsManager['email'])
        {
        $res .= $clientsManager['email'];
        }else
        {
        $res .= '&nbsp';

        }

        $res .= "</div></td>";
    $res .= '<td><div style="border: solid 0 #060; border-right-width:2px; padding-right:0.5ex">';
        if ($clientsManager['phone1'])
        {
        $res .= $clientsManager['phone1'];
        }else
        {
        $res .= '&nbsp';

        }

        $res .= "</div></td>";
    $res .= '<td><div style="border: solid 0 #060; border-right-width:2px; padding-right:0.5ex">';
        if ($clientsManager['phone2'])
        {
        $res .= $clientsManager['phone2'];
        }else
        {
        $res .= '&nbsp';

        }

        $res .= "</div></td>";
    $res .= '<td>';
        $res .= '<a href="'.$webroot.'clients/edit_manager/'.$clientsManager['id'].'">|edit|</a>';
        $res .= '<a href="'.$webroot.'clients/delete_manager/'.$clientsManager['id'].'" onclick="return confirm(&#039;Are you sure you want to delete # '.$clientsManager['id'].'?&#039;);">|delete|</a></td>';
    $res .= "</td>";
    $res .= "</tr>";
    endforeach;
    $res .='</table>';
}
return $res;
}
	echo client_managers_view($managers,$webroot);