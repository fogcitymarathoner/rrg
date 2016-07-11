<?php	

        function client_contracts_view($contracts,$active=1,$webroot)
        {
            $res ='';
            $res .='<h3>Contracts';
            if ($active == 1)
            {
                $res .= ' (Active)';
            }
            else
            {
                $res .= ' (Inactive)';
            }
            $res .='</h3>';
            if (!empty($contracts))
            {
                $res .='<table cellpadding = "1" cellspacing = "1" border ="1">';
                $res .='<tr>';
                $res .='<th>Employee Name</th>';
                $res .='<th>Title</th>';
                $res .='<th>Notes</th>';
                $res .='<th class="actions">Actions</th>';
                $res .='</tr>	';
                $i = 0;
                foreach ($contracts as $clientsContract):
                    if ($clientsContract['active']==$active)
                    {
                       $res .=$this->element('contract/view', array(
                                'clientsContract'=>$clientsContract,
                                'webroot'=>$webroot,
                                ));
                    }
                endforeach;
                $res .='</table>';
            }
            return $res;
        }
	
	echo '<input type="submit" value="Open Dialogue" name="tmpDialogueOpen" id="tmpDialogueOpen" /></p>';
	echo  '<div id="tmpDialogue"><input type="submit" value="Close Dialogue" name="tmpDialogueClose" id="tmpDialogueClose" /></div>';
	
	echo client_contracts_view($contracts,$active,$webroot) 
	/*
	echo $this->element('contract/view', array(
							'clientsContract'=>$clientsContract,
							'webroot'=>$this->webroot,
							));
							*/
							?>