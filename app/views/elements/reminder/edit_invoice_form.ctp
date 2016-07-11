<div class="edit-invoice-form" id="edit-invoice-form">

    <div class="tab-index-header ">
        <?php echo '<div id="edit-invoice-invoice-number" class="invoice-number inline" ></div>';?>
        <?php echo '<div id="edit-invoice-period" class="period inline" ></div>';?>
        <?php echo '<div id="edit-invoice-employee-name" class="employee-name inline"></div>';?>
        <?php echo '<div id="edit-invoice-client-name" class="client-name inline"></div>';?>
    </div>
    <div class='invoice-form'>
<form id='edit-invoice-form-id' action='#'>
        <div id="edit-invoice-input-id">
            <?php echo $form->input('Invoice.id',array('type'=>'hidden'));?>
        </div>


        <?php
                echo $this->element('php_date_picker',array('date_name'=>'date'));
                echo $form->input('Invoice.po',array('class'=>'invoice-input', 'div' => false));
                echo $form->input('Invoice.terms',array('class'=>'invoice-input', 'div' => false));
                echo $form->input('Invoice.id',array('type'=>'hidden'));
                echo $form->input('Invoice.employerexpenserate',array('class'=>'invoice-input', 'div' => false));
                echo $form->input('Invoice.notes',array('AUTOCOMPLETE'=>'OFF','size'=>100,'class'=>'invoice-input', 'div' => false));
                ?>
        <div>
        <?php
                echo $form->input('ClientsContract.invoicemessage',array('rows'=> 5, 'cols'=>80,'disabled' => "disabled",
                'label'=>'Invoice Message From Contract',
                'value'=>'', 'class'=>'invoice-input', 'div' => false));
                ?>
        </div>
        <?php
                echo $form->input('Invoice.message',array('rows'=> 10, 'cols'=>80, 'class'=>'invoice-input', 'div' => false));
                ?>
       <?php echo $this->element('php_date_picker',array('date_name'=>'period_start')); ?>

        <?php echo $this->element('php_date_picker',array('date_name'=>'period_end')); ?>

        <div id="edit-invoice-input-items" class='invoice-items-container'>
            <div class="invoice-items">
            <h3>Invoice Items</h3>
            <ul class="item-list">
                <li class="invoice-item">
                    <div class="invoice-item-description invoice-item-header inline">Description</div>
                    <div class="invoice-item-amount  invoice-item-header inline">Amount</div>
                    <div class="invoice-item-quantity  invoice-item-header inline">Quantity</div>
                    <div class="invoice-item-total invoice-item-header inline">Running Total</div>
                </li>
                <?php
                        for($i = 0; $i <= 10; $i++)
                        {
                            echo $this->element('invoice/line_item_form', array('i'=>$i));
                        }
                ?>
                <li class="invoice-item">
                    <div class="invoice-item-description  inline"></div>
                    <div class="invoice-item-amount inline"></div>
                    <div class="invoice-item-quantity inline"></div>
                    <div  id="edit-invoice-input-total" class="invoice-item-total inline"></div>
                </li>
            </ul>
            </div>
        </div>
        <?php
                $options = array(
                        'label' => 'Save',
                        'div' => array(
                        'class' => 'edit-invoice-save-button',
                        'id' => 'edit-invoice-save-button',
                    )
                );
                echo $this->Form->end($options);

                $options = array(
                'label' => 'Cancel',
                'div' => array(
                    'class' => 'edit-invoice-cancel-button inline',
                    'id' => 'edit-invoice-cancel-button',
                )
                );
                echo $this->Form->end($options);
                ?>
    </div>
</div>