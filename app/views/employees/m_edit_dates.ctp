

        <?php

                $dobarr=explode('-',$this->data['Employee']['startdate']);
                $dbsyear = $dobarr[0];
                $dbsmonth = $dobarr[1];
                $dbsday = $dobarr[2];
                $dobarr=explode('-',$this->data['Employee']['enddate']);
                $dbeyear = $dobarr[0];
                $dbemonth = $dobarr[1];
                $dbeday = $dobarr[2];
                echo $this->element('m_employee_dialog_header',array('employee'=>$this->data['Employee'],'type'=>$type));?>
<div data-role="content">

    <form action="<?php echo $this->webroot.'m/employees/edit'?>" data-ajax="false" method="POST">
<fieldset>


<?php ?>
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
?>

    <style>
        div.dropdown_daycontainer {
            width:200px;
        }
        div.dropdown_monthcontainer {
            width:275px;
            position: relative;
            left: 170px;
            top: -90px;
        }
        div.dropdown_yearcontainer {
            width:200px;
            position: relative;
            left: 273px;
            top: -179px;
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

        <label for="day" class="select">Start Date:</label>
        <select name="day" >
            <?php
                    foreach($mobile->days as $day)
                    {
                    if($day == $dbsday)
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
        <select name="month" >
            <?php

                    for($i = 1; $i<=count($mobile->months); $i++)
                    {
                    if($i == $dbsmonth)
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
        <select name="year" >
            <?php
                    foreach($mobile->years_start_end as $year)
                    {
                    if($year == $dbsyear)
                    {
                    echo '<option value="'.$year.'"  selected="selected" size="2">'.$year.'</option>';
                    } else {
                    echo '<option value="'.$year.'" size="2">'.$year.'</option>';
                    }
                    }
                    ?>
        </select>
    </div>
    <div class='submit'>
        <div class="ui-body ui-body-b">
            <fieldset class="ui-grid-a">
                <div class="ui-block-b"><button type="submit" data-theme="a" data-mini="true">Submit</button></div>
            </fieldset>
        </div>
    </div>
</div>
