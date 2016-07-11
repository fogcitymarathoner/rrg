<form action="<?php echo $this->webroot;?>m/clients/index" method="post" data-ajax="false">
    <fieldset>
    <div data-role="fieldcontain">
        <?php echo $form->input('name', array('type' => 'text')); ?>
    </div>

    <div data-role="fieldcontain">
    <input type="submit" value="Search" data-role='button' data-inline="true" data-icon='search'  data-ajax="false"/>
</form>

<a href="<?php echo $this->webroot.'m/clients/add'?>"  data-rel='dialog' data-role='button' data-inline="true" data-icon='plus'>New Client</a>

        </div>

        </fieldset>


<ul data-role="listview">

        <?php
                if (!empty($expenses))
                {
                ?>
                    <?php
                            echo $this->element('m_expenses_index',array('expenses'=>$expenses));?>
        <?php  }?>
    </ul>
