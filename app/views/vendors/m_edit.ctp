
<?php echo $this->element('m_vendor_dialog_header',array('vendor'=>$this->data['Vendor']));?>
<div data-role="content">

    <form action="<?php echo $this->webroot.'m/vendors/edit'?>" data-ajax="false" method="POST">
<fieldset>
    <?php
            echo $form->input('Vendor.id', array('type'=>'hidden'));
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.name',array('value'=>$this->data['Vendor']['name']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.purpose',array('value'=>$this->data['Vendor']['purpose']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.street1',array('value'=>$this->data['Vendor']['street1']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.street2',array('value'=>$this->data['Vendor']['street2']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.city',array('value'=>$this->data['Vendor']['city']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.state_id',array('label'=>'State'));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.zip',array('value'=>$this->data['Vendor']['zip']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.ssn',array('value'=>$this->data['Vendor']['ssn']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.apfirstname',array('value'=>$this->data['Vendor']['apfirstname']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.aplastname',array('value'=>$this->data['Vendor']['aplastname']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.apemail',array('value'=>$this->data['Vendor']['apemail']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.apphone1',array('value'=>$this->data['Vendor']['apphone1']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.apphone2',array('value'=>$this->data['Vendor']['apphone2']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.accountnumber',array('value'=>$this->data['Vendor']['accountnumber']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.notes',array('value'=>$this->data['Vendor']['notes']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $form->input('Vendor.secretbits',array('value'=>$this->data['Vendor']['secretbits']));
            echo '</div>';
            ?>
</fieldset>
<?php echo $form->end('Submit');?>