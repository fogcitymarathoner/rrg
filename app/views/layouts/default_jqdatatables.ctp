<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if (isset($page))
	{
		echo $page;
	} else 
	{
		echo 'Marc';
	}
?>
</title>
<?php 
	// jdMenusupport
	echo $html->css('eggplant/jquery-ui-1.7.2.custom.css');
	echo $javascript->link('jquery-1.3.2.min.js'); 
	echo $javascript->link('jquery-ui-1.7.2.custom.min.js'); 
	echo $javascript->link('jquery.dataTables'); 
	echo $javascript->link('misc_jquery.js'); 
	echo $javascript->link('jquery.dimensions');
	echo $javascript->link('jquery.positionBy');
	echo $javascript->link('jquery.bgiframe');
	echo $javascript->link('jquery.jdMenu');
    echo $html->css('jquery.jdMenu');
        echo $html->css('demo_page');
        echo $html->css('demo_table');
	//echo $html->css('simple_menu');
	
    $calendarControllers = array('events', 'calls','movies');
	if (in_array($this->params['controller'],$calendarControllers))
	{
		echo $html->css('fullcalendar.css');
		echo $javascript->link('fullcalendar.js'); 
	}
	echo $html->css('datepicker')."\n";
	echo $javascript->link('datepicker.js')."\n";      		
		echo $html->meta(
		    'favicon.ico',
		    $favico,
		    array('type' => 'icon')
		);     
	
?>
    <style>
        #topmenu ul li a {
            color: #FFFFFF;
            text-decoration: none;
        }

    </style>
</head>

<body id="dt_example">
	<div id='topmenu'>
	<?php echo $papp->topmenu($this->webroot); ?>
        </div>
	  	<?php 
			if ($session->check('Message.flash')): echo $session->flash(); endif; // this line displays our flash messages
			echo $content_for_layout; 
	  	?>
	  	</div>
</body>
</html>
