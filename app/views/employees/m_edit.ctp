
<?php echo $this->element('m_employee_dialog_header',array('employee'=>$this->data['Employee'],'type'=>$type));?>
<div data-role="content">

    <form action="<?php echo $this->webroot.'m/employees/edit'?>" data-ajax="false" method="POST">
<fieldset>
    <?php
            echo $form->input('Employee.id', array('type'=>'hidden'));
            ?>

    <?php
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.firstname',array('value'=>$this->data['Employee']['firstname']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.lastname',array('value'=>$this->data['Employee']['lastname']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.street1',array('value'=>$this->data['Employee']['street1']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.street2',array('value'=>$this->data['Employee']['street2']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.city',array('value'=>$this->data['Employee']['city']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.state_id',array('label'=>'State'));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.zip',array('value'=>$this->data['Employee']['zip']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.ssn_crypto',array('value'=>$this->data['Employee']['ssn_crypto']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.phone',array('value'=>$this->data['Employee']['phone']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.notes',array('value'=>$this->data['Employee']['notes']));
            echo '</div>';
            ?>
</fieldset>
    <div class='submit'>
        <div class="ui-body ui-body-b">
            <fieldset class="ui-grid-a">
                <div class="ui-block-b"><button type="submit" data-theme="a" data-mini="true">Submit</button></div>
            </fieldset>
        </div>
    </div>

</div>