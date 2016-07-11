
<div id="navigation">
    <ul id="menu">
    <li><a href="<?php echo $webroot.$controller ?>/view_contract/<?php echo $contract['id']?>">General Info</a></li>
    <li><a href="<?php echo $webroot.$controller ?>/view_mock_invoice/<?php echo $contract['id']?>">Mock Invoice</a></li>
    <li><a href="<?php echo $webroot.$controller ?>/view_contract_items/<?php echo $contract['id']?>">Billable Items</a></li>
    <li><a href="<?php echo $webroot.$controller ?>/view_contract_invoices/<?php echo $contract['id']?>">Invoices</a></li>
    <li><a href="<?php echo $webroot.$controller ?>/view_contract_emails/<?php echo $contract['id']?>">Invoice Email Recipients</a></li>

    </ul>
</div>