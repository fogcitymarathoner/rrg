<?php
function client_searches_view($searches,$state_id=1,$webroot)
{
$i = 0;
$res ='';

$res .= '<h3>Searches';
    if ($state_id == 1)
    {
    $res .= ' (Active)';
    }
    else
    {
    $res .= ' (Inactive)';
    }
    $res .='</h3>';


if (!empty($searches))
{
$res .= '<table cellpadding = "0" cellspacing = "0">';
    $res .= '<tr>';
        $res .= '<th>Title</th>';
        $res .= '<th>Notes</th>';
        $res .= '<th class="actions">Actions</th>';
        $res .= '</tr>';
    foreach ($searches as $clientsSearch):
    if ($clientsSearch['active']==$state_id)
    {
    $class = null;
    if ($i++ % 2 == 0) {
    $class = ' class="altrow"';
    }
    $res .= '<TR '.$class.'>';
    $res .= '<td><div style="border: solid 0 #060; border-right-width:2px; padding-right:0.5ex; border-left-width:2px; padding-left:0.5ex">';
        $res .= $clientsSearch['title'];
        $res .= '</div></td>';

    $res .= '<td><div style="border: solid 0 #060; border-right-width:2px; padding-right:0.5ex">';
        $res .= $clientsSearch['notes'];

        $res .= "</div></td>";
    $res .= '<td>';
        $res .= '<a href="'.$webroot.'clients/edit_search/'.$clientsSearch['id'].'">|edit|</a>';
        $res .= '<a href="'.$webroot.'clients/delete_search/'.$clientsSearch['id'].'" onclick="return confirm(&#039;Are you sure you want to delete # '.$clientsSearch['id'].'?&#039;);">|delete|</a></td>';
    $res .= "</td>";
    $res .= "</tr>";
    }
    endforeach;
    $res .= "</table>";
}
return $res;
}

echo client_searches_view($searches,$state_id=1,$webroot);