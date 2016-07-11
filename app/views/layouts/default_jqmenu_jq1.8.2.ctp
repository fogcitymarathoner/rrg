<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <title>
        <?php
                if (isset($page_title))
                {
                echo $page_title;
                } else
                {
                echo 'RRG DB';
                }
                ?>
    </title>

    <?php echo $html->css('eggplant/jquery-ui-1.8.23.custom');?>
    <?php echo $javascript->link('jquery-1.8.2.min'); ?>
    <?php echo $javascript->link('jquery-ui-1.8.23.custom.min'); ?>
    <?php
    echo $javascript->link('jquery.jdMenu');
    echo $javascript->link('jquery.dimensions');
    echo $javascript->link('jquery.positionBy');
    echo $javascript->link('jquery.bgiframe');
    echo $html->css('jquery.jdMenu');
    $calendarControllers = array('jqtest','clients','reminders','expenses','expenses_categories','events','payrolls','employees','invoices');

    if (in_array($this->params['controller'],$calendarControllers))
    {
        echo $html->css('datepicker')."\n";
        echo $javascript->link('datepicker')."\n";
    }
    echo $html->meta(
        'favicon.ico',
        $favico,
        array('type' => 'icon')
        );
        ?>
</head>
<body>


<?php echo $this->element('main_menu',array('webroot'=>$this->webroot)); ?>
<?php
        if ($session->check('Message.flash')): $session->flash(); endif; // this line displays our flash messages
        echo $content_for_layout;
        ?>

<div id='debug'>
    <?php echo $this->element('sql_dump'); ?>
</div>
</body>
</html>