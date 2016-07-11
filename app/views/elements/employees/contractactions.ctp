<?php
$res = '<div class="actions">';
    $res .= '<ul>	';
        $res .= '<li><a href="'.$webroot.'employees/view_contracts/'.$employee['Employee']['id'].'">Return to Employee</a> </li>
        <li><a href="'.$webroot.'employees/">Return to employee list</a> </li>';
        $res .= '</ul>';
    $res .= '</div>';
echo $res;
