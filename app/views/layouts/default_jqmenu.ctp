<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php 
	if (isset($page_title))
	{
		echo str_replace('<br>','',$page_title);
	} else 
	{
		echo 'RRG DB';
	}
?>
</title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="///ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<?php
    echo $html->css('eggplant/jquery-ui-1.8.23.custom.css');
	echo $javascript->link('jq_popup_toggle');
	echo $javascript->link('misc_jquery.js');
	echo $javascript->link('jquery.positionBy');
	echo $javascript->link('jquery.bgiframe');
    // jdMenusupport
	echo $javascript->link('open_window');
	echo $javascript->link('jquery.jdMenu');
	echo $html->css('jquery.jdMenu');

	echo $html->css('tabs');
	echo $html->css('simple_menu');

	echo $html->css('rrg')."\n";
    $calendarControllers = array('clients','reminders','expenses','expenses_categories','events','payrolls','employees','invoices');
    $bubbleControllers = array('clients','reminders','payrolls','employees','invoices');
	if (in_array($this->params['controller'],$calendarControllers))
	{
		echo $html->css('fullcalendar');
		echo $html->css('calendar');
		echo $javascript->link('fullcalendar');
		echo $javascript->link('cal');
		echo $javascript->link('date');
		echo $html->css('datepicker')."\n";
		echo $javascript->link('datepicker')."\n";
	}     		
	echo $html->meta('favicon.ico', $favico,array('type' => 'icon'));

?>
</head>
<body>
        <?php echo $this->element('main_menu',array('webroot'=>$this->webroot)); ?>
        <?php
            if ($session->check('Message.flash')): echo $session->flash(); endif; // this line displays our flash messages
            echo $content_for_layout;
        ?>
        <?php echo $this->element('sql_dump'); ?>

</body>
</html>
