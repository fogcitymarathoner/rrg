

        <?php echo $this->element('m_expense_add_dialog_header',array());


                $dbyear = date('Y');
                $dbmonth = date('m');
                $dbday = date('d');

                ?>
<div data-role="content">

    <?php echo $form->create('Expense'); ?>
    <fieldset>
        <?php
                echo '<div data-role="fieldcontain">';
                echo $form->input('amount');
                echo '</div>';
                echo '<div data-role="fieldcontain">';
                echo $form->input('category_id', array('label'=>'Category', 'options'=>$expensesCategories), null, array(), '-- Select an Expense Category --');


?>

    <style>
        div.dropdown_daycontainer {
            width:200px;
        }
        div.dropdown_monthcontainer {
            width:275px;
            position: relative;
            left: 120px;
            top: -75px;
        }
        div.dropdown_yearcontainer {
            width:200px;
            position: relative;
            left: 280px;
            top: -145px;
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
        div.desc {
            position: relative;
            top: -150px;

        }
        div.notes {
            position: relative;
            top: -150px;

        }
        div.emp{
            position: relative;
            top: -150px;

        }
    </style>
    <div data-role="fieldcontain"  class="dropdown_daycontainer">

        <label for="day" class="select">Date:</label>
        <select name="day" >
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
        <select name="month" >
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
        <select name="year" >
            <?php
                    foreach($mobile->years_start_end as $year)
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
    </div>                <?php




        echo '</div>';
                echo '<div data-role="fieldcontain" class="desc" >';
        echo $form->input('description',array('size'=>100));
                echo '</div>';
                echo '<div data-role="fieldcontain" class="notes">';
        echo $form->input('notes',array('size'=>100));
                echo '</div>';
                echo '<div data-role="fieldcontain" class="emp">';
        echo $form->input('employee_id',array('label'=>'Employee', 'options'=>$employees, 'default'=>$current_employee), null, array(), '-- Select an Employee --');
                echo '</div>';
                ?>
    </fieldset>

    <div class='submit'>
        <?php echo $form->end('Submit');?>
    </div>
</div>