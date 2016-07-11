<?php
        echo '<TR '.$class.'>';
        $classemp ='';
        if( $clientsContract['Employee']['active']==0)
            $classemp ='empinactive';
        echo '<td  class="'.$classemp.'">';
        echo '<a href="'.$webroot.'employees/view/'.$clientsContract['Employee']['id'].'">'.$clientsContract['Employee']['firstname'].' '.$clientsContract['Employee']['lastname'].'</a>';
        echo "</td>";
        echo '<td>';
        echo $clientsContract['title'];
        echo "</td>";
        echo '<td>';
        echo $clientsContract['notes'];
        echo "</td>";

        echo '<td>';
        //echo js_active_inactive($clientsContract,$webroot);
        echo '<a href="'.$webroot.'clients/view_contract/'.$clientsContract['id'].'">|manage|</a>';
        echo '<a href="'.$webroot.'clients/delete_contract/'.$clientsContract['id'].'" onclick="return confirm(&#039;Are you sure you want to delete # '.$clientsContract['id'].'?&#039;);">|delete|</a></td>';
        echo "</td>";
        echo "</tr>";
        if (!$clientsContract['addendum_executed'] && $clientsContract['active'])
        {
            echo '<TR '.$class.'>';
            echo '<td colspan=4>';
            //echo 'Contract Status: '.js_addendum($clientsContract,$webroot);
            echo "</td>";
            echo "</tr>";
        }
        echo '<TR '.$class.'>';
        echo '<td colspan=4>';

        echo 'Start Date: '.date('m/d/Y',strtotime($clientsContract['startdate']));
        if ($clientsContract['enddate'])
        {
            echo ' ';
            echo 'End Date: '.date('m/d/Y',strtotime($clientsContract['enddate']));
        }
        echo "</td>";
        echo "</tr>";
        echo '<TR '.$class.'>';
        echo '<td colspan=4>';
        echo 'Terms: '.$clientsContract['terms'];
        echo "</td>";
        echo "</tr>";
        $active = $clientsContract['active'];
        foreach ($clientsContract['ContractsItem'] as $item):
                echo '<TR '.$class.'>';
                echo '<td >';


                echo "</td>";
                echo '<td colspan=7>';
                if($item['active']==1)
                {
                    echo '<font color="BLACK" >';
            echo $item['description'].': '.
            sprintf('%8.2f',round($item['amt'],2)).': '.
            sprintf('%8.2f',round($item['cost'],2));
                                    echo "</td>";
                    echo '</font>';
                } else {
                    echo '<font color="RED" >';
            echo $item['description'].': '.
            sprintf('%8.2f',round($item['amt'],2)).': '.
            sprintf('%8.2f',round($item['cost'],2));
                                    echo "</td>";
                    echo '</font>';
                }
                echo "</td>";
                echo "</tr>";
        endforeach;
?>