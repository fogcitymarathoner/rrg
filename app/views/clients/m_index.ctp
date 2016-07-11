
<form action="<?php echo $this->webroot;?>m/clients/index" method="post" data-ajax="false">
<fieldset>
    <div data-role="fieldcontain">
        <?php echo $form->input('name', array('type' => 'text')); ?>
    </div>

<div data-role="fieldcontain">
    <input type="submit" value="Search" data-role='button' data-inline="true" data-icon='search'  data-ajax="false"/>
</form>

<a href="<?php echo $this->webroot.'m/clients/add'?>"  data-rel='dialog' data-role='button' data-inline="true" data-icon='plus'>New Client</a>


</fieldset>
    <ul data-role="listview">

        <?php
                if (!empty($clients))
                {
                ?>
                    <?php echo $this->element('m_clients_index',array('clients'=>$clients));?>
        <?php  }?>
    </ul>
