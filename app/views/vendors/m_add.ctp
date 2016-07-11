
<?php echo $this->element('m_vendor_add_dialog_header',array());?>
<div data-role="content">

<?php echo $form->create('Vendor'); ?>
<fieldset>
    <?php
            echo $form->input('id', array('type'=>'hidden'));
            echo '<div data-role="fieldcontain">';
            echo $form->input('name');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('purpose');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('street1');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('street2');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('city');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('state_id',array('type'=>'select','label'=>'State','default'=>5));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('zip');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('ssn');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('apfirstname');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('aplastname');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('apemail');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('apphone1');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('apphone2');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('accountnumber');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('notes');
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('secretbits');
            echo '</div>';
            ?>
</fieldset>
<?php echo $form->end('Submit');?>
</div>