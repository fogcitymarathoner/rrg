<style>


    div.simple_menu_navigation {
        font: 10px "Trebuchet MS",sans-serif;
        position: absolute;

        width: 800px;

        height: 20px;


        font-weight: normal;

    }

    div.invoices.index {
        font-size: 12pt;
    }
</style>

<div class="invoices index">

<?php echo $this->element('reminders/menu',array());?>
<?php

        echo $javascript->link('reminders');

        ?>
<?php echo $this->element('reminders/sent_reciepts', array(
        'opens'=>$this->data,
        'webroot'=>$this->webroot,
        ));
        ?>

</div>
