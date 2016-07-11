<style>
    div.simple_menu_navigation {
        font: 10px "Trebuchet MS",sans-serif;
        position: absolute;

        width: 800px;

        height: 20px;

        font-weight: normal;
    }
    div.reminder-date {
        color: green;
        text-align: center;
    }
    div.reminder-date-hyphen {
        color: purple;
        width: 50%;
        margin: 0 auto;
    }
    div.reminder-date-past {
        color: red;
    }
    a.inactive-employee {
        COLOR: red;
    }

</style>

<div class="invoices index">
    <?php echo $this->element('reminders/menu',array());?>
    <?php echo $javascript->link('reminders');?>
    <?php echo $this->element('reminders/index', array('reminders'=>$reminders,'webroot'=>$this->webroot,));?>
</div>
