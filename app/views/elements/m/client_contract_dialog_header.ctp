<?php $name = $clientD['name'];?>
<div data-role="header">
    <div id='buttons'>
        <a href="<?php echo $this->webroot?>m/clients/"  rel='external' data-role="button" data-inline="true" data-icon="left_arrow">Back to Clients</a>
        <a href="<?php echo $this->webroot?>m/clients/newInvoice/<?php echo $clientD['id']?>"  rel='external'   data-role="button" data-inline="true" data-icon="pencil_16x16">New Invoice</a>
        <a href="<?php echo $this->webroot?>m/clients/add_contract_item/<?php echo $clientsContract['ClientsContract']['id']?>"  rel='external'   data-role="button" data-inline="true" data-icon="pencil_16x16">New Billable Item</a>

        <a href="<?php echo $this->webroot?>m/clients/manage_contract_emails/<?php echo $clientsContract['ClientsContract']['id']?>"  rel='external'   data-role="button" data-inline="true" data-icon="pencil_16x16">Manage Contract Emails</a>
        <a href="<?php echo $this->webroot?>m_clients/edit_contract/<?php echo $clientsContract['ClientsContract']['id']?>"    data-role="button" data-inline="true" data-icon="pencil_16x16">Edit</a>
    </div>
</div>
