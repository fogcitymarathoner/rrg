
<?php echo $this->element('m_employee_dialog_header',array('employee'=>$this->data['Employee'],'type'=>$type));?>
<div data-role="content">

    <form action="<?php echo $this->webroot.'m/employees/edit'?>" data-ajax="false" method="POST">
<fieldset>
    <?php
            echo $form->input('Employee.id', array('type'=>'hidden'));
            echo $form->input('Employee.username', array('type'=>'hidden'));
            echo $form->input('Employee.slug', array('type'=>'hidden'));

            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.firstname',array('value'=>$this->data['Employee']['firstname']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.lastname',array('value'=>$this->data['Employee']['lastname']));
            echo '</div>';

            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.tcard',array('value'=>$this->data['Employee']['tcard']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.w4',array('value'=>$this->data['Employee']['w4']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.de34',array('value'=>$this->data['Employee']['de34']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.i9',array('value'=>$this->data['Employee']['i9']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.medical',array('value'=>$this->data['Employee']['medical']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.indust',array('value'=>$this->data['Employee']['indust']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.info',array('value'=>$this->data['Employee']['info']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.salesforce',array('value'=>$this->data['Employee']['salesforce']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.voided',array('value'=>$this->data['Employee']['voided']));
            echo '</div>';

            ?>
</fieldset>
<?php echo $form->end('Submit');?>