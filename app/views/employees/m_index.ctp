
        <form action="<?php echo $this->webroot;?>m/employees/index" method="post" data-ajax="false">
        <fieldset>
            <div data-role="fieldcontain">
                <?php echo $form->input('name', array('type' => 'text')); ?>
            </div>

        <div data-role="fieldcontain">
            <input type="submit" value="Search" data-role='button' data-inline="true" data-icon='search'  data-ajax="false"/>
        </form>

        <a href="<?php echo $this->webroot.'m/employees/add'?>"  data-rel='dialog' data-role='button' data-inline="true" data-icon='plus'>New Employee</a>

                </div>

        </fieldset>
    <ul data-role="listview">

        <?php
                if (!empty($employees))
                {
                ?>
                    <?php echo $this->element('m_employees_index',array('employees'=>$employees));?>
        <?php  }?>
    </ul>
