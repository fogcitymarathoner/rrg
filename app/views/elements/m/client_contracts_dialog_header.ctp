<?php $name = $clientD['name'];

?>
<div data-role="header">
    <div id='buttons'>


        <a href="<?php echo $this->webroot.'m/clients/add_contract/'.$clientD['id']?>"  rel='external'  data-role='button' data-inline="true" data-icon='plus'>New Contract</a>

        <a href="<?php echo $this->webroot?>m/clients/view/<?php echo $clientD['id']?>"  rel='external' data-role="button" data-inline="true" data-icon="left_arrow">Back to <?php echo $clientD['name']?></a>
        <a href="<?php echo $this->webroot?>m/clients/contracts/<?php echo $clientD['id']?>"  rel="external" data-role="button" data-inline="true" data-icon="pencil_16x16">Contracts</a>

        <a href="<?php echo $this->webroot?>m/clients/view_invoices_pending/<?php echo $clientD['id']?>"  rel="external" data-role="button" data-inline="true" data-icon="pencil_16x16">Pending Invoices</a>
        <a href="<?php echo $this->webroot?>m/clients/view_invoices_pastdue/<?php echo $clientD['id']?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">Past Due Invoices</a>
        <a href="<?php echo $this->webroot?>m/clients/view_statement/<?php echo $clientD['id']?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">Statement</a>

        <a href="<?php echo $this->webroot?>m/clients/newInvoice/<?php echo $clientD['id']?>" rel='external'  data-role="button" data-inline="true" data-icon="pencil_16x16">New Invoice</a>
    </div>
</div>
