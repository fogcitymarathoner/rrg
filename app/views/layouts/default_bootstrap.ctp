<html>
<head>
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
	<?php echo $html->css('cake.generic');?>
    <!-- bootstrap_common_header.html -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <!-- Underscore.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>

    <script src="https://cdn.rawgit.com/jprichardson/string.js/master/lib/string.min.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="///ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<?php
    echo $html->css('eggplant/jquery-ui-1.8.23.custom.css');
	echo $javascript->link('jq_popup_toggle');
	echo $javascript->link('misc_jquery.js');
	echo $javascript->link('jquery.positionBy');
	echo $javascript->link('jquery.bgiframe');
    // jdMenusupport
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
<style>
.cliente {
	margin-top:10px;
	border: #cdcdcd medium solid;
	border-radius: 10px;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
}
</style>
<body>
	<div id="container">
        <div id="content">
            <?php echo $this->element('main_menu',array('webroot'=>$this->webroot)); ?>
            <?php
                if ($session->check('Message.flash')): echo $session->flash(); endif; // this line displays our flash messages
                echo $content_for_layout;
            ?>

        </div>
	</div>
</body>
</html>
