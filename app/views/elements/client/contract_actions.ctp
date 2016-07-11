<?php
$res = '<div class="actions">';
    $res .= '<ul>	';
        $res .= '<li><a href="'.$webroot.'clients/view_active_contracts/'.$contract['client_id'].'">Return to client</a> </li>
        <li><a href="'.$webroot.'clients/">Return to client list</a> </li>';
        $res .= '</ul>';
    $res .= '</div>';
echo $res;
