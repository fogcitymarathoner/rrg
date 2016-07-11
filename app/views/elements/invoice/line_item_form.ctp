
<li class="invoice-item" id="invoice-item-<?php echo $i?>">

    <?php echo $form->input('InvoicesItem[id]['.$i.']',array('type'=>'hidden')); ?>

    <input type="hidden" name="data[Invoice][InvoicesItem][id][<?php echo $i; ?>]" value="0" id="InvoicesItem-id-<?php echo $i; ?>" />

    <div class="invoice-item-description invoice-item-header inline">

        <input type="" name="data[Invoice][InvoicesItem][description][<?php echo $i; ?>]" value="0" id="InvoicesItem-description-<?php echo $i; ?>" />
    </div>
    <div class="invoice-item-amount  invoice-item-header inline">

        <input type="" name="data[Invoice][InvoicesItem][amount][<?php echo $i; ?>]" value="0" id="InvoicesItem-amount-<?php echo $i; ?>" />
    </div>
    <div class="invoice-item-quantity  invoice-item-header inline">

        <input type="" name="data[Invoice][InvoicesItem][quantity][<?php echo $i; ?>]" value="0" id="InvoicesItem-quantity-<?php echo $i; ?>" />
    </div>
    <div class="invoice-item-total invoice-item-header inline">

        <input type="" name="data[Invoice][InvoicesItem][running-total][<?php echo $i; ?>]" value="0" id="InvoicesItem-running-total-<?php echo $i; ?>" />
    </div>
</li>