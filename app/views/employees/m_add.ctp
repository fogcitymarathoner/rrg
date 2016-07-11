
<?php echo $this->element('m_employee_add_dialog_header',array());?>
<div data-role="content">

<?php echo $form->create('Employee'); ?>
<fieldset>
    <?php
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.firstname',array('value'=>''));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.lastname',array('value'=>''));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.street1',array('value'=>''));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.street2',array('value'=>''));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.city',array('value'=>''));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.state_id',array('label'=>'State','value'=>5));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.zip',array('value'=>''));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.ssn_crypto',array('value'=>''));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.phone',array('value'=>''));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.notes',array('value'=>''));
            echo '</div>';
            ?>
</fieldset>
<?php echo $form->end('Submit');?>
</div>