
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
            echo $form->input('Employee.bankaccountnumber_crypto',array('value'=>$this->data['Employee']['bankaccountnumber_crypto']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.bankroutingnumber_crypto',array('value'=>$this->data['Employee']['bankroutingnumber_crypto']));
            echo '</div>';

            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.directdeposit',array('value'=>$this->data['Employee']['directdeposit']));
            echo '</div>';

            ?>
</fieldset>
<?php echo $form->end('Submit');?>