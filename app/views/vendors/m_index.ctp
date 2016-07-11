
        <form action="<?php echo $this->webroot;?>m/vendors/index" method="post" data-ajax="false">
        <fieldset>
            <div data-role="fieldcontain">
                <?php echo $form->input('name', array('type' => 'text')); ?>
            </div>
            <div data-role="fieldcontain">
                <?php echo $form->input('purpose', array('type' => 'text'));  ?>
            </div>

        <div data-role="fieldcontain">
            <input type="submit" value="Search" data-role='button' data-inline="true" data-icon='mag_glass_16x16'  data-ajax="false"/>
        </form>

        <a href="<?php echo $this->webroot.'m/vendors/add'?>"  data-rel='dialog' data-role='button' data-inline="true" data-icon='plus'>New Vendor</a>

                </div>

        </fieldset>
    <ul data-role="listview">

        <?php
                if (!empty($vendors))
                {
                ?>
                    <?php echo $this->element('m_vendors_index',array('vendors'=>$vendors));?>
        <?php  }?>
    </ul>
