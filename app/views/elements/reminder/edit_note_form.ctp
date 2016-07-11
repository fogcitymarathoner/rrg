<div class="edit-note-form" id="edit-note-form">
    <?php echo $form->create('Reminders',array('action'=>'edit_notes','name'=>'invoice_form'));?>
    <fieldset>
        <legend><?php __('Edit Reminder Notes');?></legend>
        <div class="tab-index-header ">
            <?php echo '<div id="edit-notes-invoice-number" class="invoice-number inline" ></div>';?>
            <?php echo '<div id="edit-notes-period" class="period inline" ></div>';?>
            <?php echo '<div id="edit-notes-employee-name" class="employee-name inline"></div>';?>
            <?php echo '<div id="edit-notes-client-name" class="client-name inline"></div>';?>
        </div>
        <div class="edit-note-input">
       <?php
            echo $form->input('Invoice.notes',array('AUTOCOMPLETE'=>'OFF','size'=>70,'maxsize'=>100));
            echo $form->input('Invoice.id',array('type'=>'hidden'));
            $options = array(
               'label' => 'Save',
               'div' => array(
               'class' => 'edit-notes-save-button',
               'id' => 'edit-notes-save-button',
               )
            );
            echo $this->Form->end($options);

            $options = array(
               'label' => 'Cancel',
               'div' => array(
               'class' => 'edit-notes-cancel-button',
               'id' => 'edit-notes-cancel-button',
               )
            );
            echo $this->Form->end($options);
        ?>
        </div>
    </fieldset>

</div>