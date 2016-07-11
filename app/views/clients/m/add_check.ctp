<?php
if($step==1)
{
    echo $this->element('m/select_client_goto_add_check_step2',array('webroot'=>$this->webroot,'clientsMenu'=>$clientsMenu));
} else if ($step == 2)
{
    echo $this->element('m/select_open_invoices_add_check_step2',array('webroot'=>$this->webroot,'invoice'=>$invoice,'clientData'=>$clientData));
}
?>