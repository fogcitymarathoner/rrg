
<?php echo $this->element('m_employee_dialog_header',array('employee'=>$this->data['Employee'],'type'=>$type));?>

<div data-role="content">

<form action="<?php echo $this->webroot.'m/employees/edit'?>" data-ajax="false" method="POST">
    <fieldset>


        <h3>Federal</h3>
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
                echo $form->input('allowancefederal',array('label'=>'allowance','value'=>$this->data['Employee']['allowancefederal']));
                echo '</div>';
                echo '<div data-role="fieldcontain">';
                echo $form->input('extradeductionfed',array('label'=>'extra deduction','value'=>$this->data['Employee']['extradeductionfed']));
                echo '</div>';
                echo '<div data-role="fieldcontain">';
                echo $form->input('maritalstatusfed',array('label'=>'marital status','value'=>$this->data['Employee']['maritalstatusfed']));
                echo '</div>';
                ?>

        <h3>State</h3>
        <?php
                echo '<div data-role="fieldcontain">';
                echo $form->input('allowancestate',array('label'=>'allowance','value'=>$this->data['Employee']['allowancestate']));
                echo '</div>';
                echo '<div data-role="fieldcontain">';
                echo $form->input('extradeductionstate',array('label'=>'extra deduction','value'=>$this->data['Employee']['extradeductionstate']));
                echo '</div>';
                echo '<div data-role="fieldcontain">';
                echo $form->input('maritalstatusstate',array('label'=>'marital status','value'=>$this->data['Employee']['maritalstatusstate']));
                echo '</div>';
                ?>
    </fieldset>
    <?php echo $form->end('Submit');?>