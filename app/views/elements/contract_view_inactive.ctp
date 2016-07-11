<?php
//debug($clientsContract);
        //debug($clientsContract['Employee']['firstname']);//exit;
					
					echo '<TR '.$class.'>';
					echo '<td>';
					echo $clientsContract['Employee']['firstname'].' '.$clientsContract['Employee']['lastname'];					
					echo "</td>";
					echo '<td>';
					echo $clientsContract['ClientsContract']['title'];
					echo "</td>";
					echo '<td>';
					echo $clientsContract['ClientsContract']['notes'];
					echo "</td>";
					echo '<td>';
					//echo js_active_inactive($clientsContract,$webroot);
                    echo '<a href="'.$webroot.'clients/view_contract/'.$clientsContract['ClientsContract']['id'].'">|manage|</a>';
					echo '<a href="'.$webroot.'clients/delete_contract/'.$clientsContract['ClientsContract']['id'].'" onclick="return confirm(&#039;Are you sure you want to delete # '.$clientsContract['ClientsContract']['id'].'?&#039;);">|delete|</a></td>';
					echo "</td>";
					echo "</tr>";
					if (!$clientsContract['ClientsContract']['addendum_executed'] && $clientsContract['ClientsContract']['active'])
					{
						echo '<TR '.$class.'>';
						echo '<td colspan=4>';
						echo 'Contract Status: '.js_addendum($clientsContract,$webroot);
						echo "</td>";
						echo "</tr>";
					}			
					echo '<TR '.$class.'>';
					echo '<td colspan=4>';
					
					echo 'Start Date: '.date('m/d/Y',strtotime($clientsContract['ClientsContract']['startdate']));
					if ($clientsContract['ClientsContract']['enddate'])
					{
						echo ' ';
						echo 'End Date: '.date('m/d/Y',strtotime($clientsContract['ClientsContract']['enddate']));
					}
					echo "</td>";
					echo "</tr>";			
					echo '<TR '.$class.'>';
					echo '<td colspan=4>';
					echo 'Terms: '.$clientsContract['ClientsContract']['terms'];
					echo "</td>";
					echo "</tr>";

?>