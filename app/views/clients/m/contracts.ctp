
<?php  echo $this->element('m/client_contracts_dialog_header',array('clientD'=>$contracts['Client']));?>

<form action="<?php echo $this->webroot;?>m/clients/index" method="post" data-ajax="false">
    <fieldset>
    <div data-role="fieldcontain">
        <?php echo $form->input('name', array('type' => 'text')); ?>
    </div>

    <div data-role="fieldcontain">
    <input type="submit" value="Search" data-role='button' data-inline="true" data-icon='search'  data-ajax="false"/>
</form>

        </div>

        </fieldset>
<ul data-role="listview">

<?php
        if (!empty($contracts['ClientsContract']))
        {
        ?>
    <?php
            $i =0;
            foreach ($contracts['ClientsContract'] as $clientsContract):
                if ($clientsContract['active']==1)
                {
                    echo $this->element('m_contract_view', array(
                            'clientsContract'=>$clientsContract,
                            'webroot'=>$this->webroot,
                            'i'=>$i++,
                        ));
                }
            endforeach;
            ?>
<?php  }?>
</ul>
