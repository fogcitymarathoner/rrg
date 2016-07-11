<?php
        //debug($this->data);
        $dobarr=explode('-',$this->data['Employee']['dob']);
        $dbyear = $dobarr[0];
        $dbmonth = $dobarr[1];
        $dbday = $dobarr[2];
        //debug($dbday);exit;
        echo $this->element('m_employee_dialog_header',array('employee'=>$this->data['Employee'],'type'=>$type));?>
<div data-role="content">

    <form action="<?php echo $this->webroot.'m/employees/edit'?>" data-ajax="false" method="POST">
<fieldset>

<?php ?>
    <?php
            echo $form->input('Employee.id', array('type'=>'hidden'));
            echo $form->input('Employee.username', array('type'=>'hidden'));
            echo $form->input('Employee.slug', array('type'=>'hidden'));
?>
            <p><?php echo 'include hyphens';?></p>
<?PHP
            echo '<div data-role="fieldcontain">';
            echo $form->input('Employee.ssn_crypto',array('type'=>'password','label'=>'SSN','size'=>11,'value'=>$this->data['Employee']['ssn_crypto']));
            echo '</div>';
            echo '<div data-role="fieldcontain">';
            echo $this->data['Employee']['ssn_crypto_display'];
            echo '</div>';
        ?>
    <p>dob DD MM YYYY</p>

    <style>
        div.dropdown_daycontainer {
            width:200px;
        }
        div.dropdown_monthcontainer {
            width:275px;
            position: relative;
            left: 185px;
            top: -90px;
        }
        div.dropdown_yearcontainer {
            width:200px;
            position: relative;
            left: 290px;
            top: -180px;
        }
        p.usstatus {
             position: relative;
             left: 30px;
             top: -140px;
         }
        div.usstatfield {
            width:600px;
            position: relative;
            left: 10px;
            top: -150px;
        }
        div.submit {
            width:600px;
            position: relative;
            left: 10px;
            top: -85px;
        }
    </style>
    </fieldset>
    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
    <div data-role="fieldcontain"  class="dropdown_daycontainer">

        <label for="day" class="select">Day of Birth:</label>
    <select name="dobday" >
            <?php
                    foreach($mobile->days as $day)
                    {
                        if($day == $dbday)
                        {
                            echo '<option value="'.$day.'" selected="selected" size="2">'.$day.'</option>';
                        } else {

                            echo '<option value="'.$day.'" size="2">'.$day.'</option>';
                        }
                    }
            ?>
        </select>
    </div>
    <div data-role="fieldcontain"  class="dropdown_monthcontainer">
            <select name="dobmonth" >
                <?php

                        for($i = 1; $i<=count($mobile->months); $i++)
                        {
                            if($i == $dbmonth)
                            {
                                echo '<option value="'.$i.'"  selected="selected"  size="2">'.$mobile->months[$i].'</option>';
                            } else {
                                echo '<option value="'.$i.'" size="2">'.$mobile->months[$i].'</option>';
                            }
                        }
                        ?>
            </select>
    </div>
    <div data-role="fieldcontain"  class="dropdown_yearcontainer">
            <select name="dobyear" >
                <?php
                        foreach($mobile->years as $year)
                        {
                            if($year == $dbyear)
                        {
                                echo '<option value="'.$year.'"  selected="selected" size="2">'.$year.'</option>';
                            } else {
                                echo '<option value="'.$year.'" size="2">'.$year.'</option>';
                            }
                        }
                        ?>
            </select>
    </div>

    </fieldset>
        <fieldset>
    <p class='usstatus'>US Work Status</p>
    <?php
            echo '<div data-role="fieldcontain" class="usstatfield">';
            echo $form->input('Employee.usworkstatus',array('options'=>$i9Options,'label'=>False));
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
