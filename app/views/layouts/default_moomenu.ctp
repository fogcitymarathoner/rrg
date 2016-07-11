<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<?php

		//experimenting with mootools
        echo $html->css('mootools/style')."\n";
		echo $javascript->link('mootools-1.2.4-core')."\n";
        echo $javascript->link('mootools/MooDropMenu')."\n";
        echo $html->css('mootools/MooDropMenu')."\n";
        /*
        echo $javascript->link('mootools-1.3.2-more')."\n";
        echo $javascript->link('mootools/Locale.en-US.DatePicker')."\n";
        echo $javascript->link('mootools/Picker')."\n";
        echo $javascript->link('mootools/Picker.Attach')."\n";
        echo $javascript->link('mootools/Picker.Date')."\n";
        echo $javascript->link('mootools/Picker.Date.Range')."\n";
        echo $html->css('mootools/datepicker')."\n";
        //echo $html->css('Source/datepicker_dashboard/datepicker_dashboard')."\n";
        */

?>
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
		echo $html->meta(
		    'favicon.ico',
		    $favico,
		    array('type' => 'icon')
		);     
	
?>

    <script type="text/javascript">
        <!--

        window.addEvent('domready',function(){

            $('nav').MooDropMenu({
                onOpen: function(el){
                    el.fade('in')
                },
                onClose: function(el){
                    el.fade('out');
                },
                onInitialize: function(el){
                    el.fade('hide').set('tween', {duration:500});
                }
            });

        });

        // -->
    </script>
</head>
<body>
<h1>Range</h1>
	  	<?php 
			if ($session->check('Message.flash')): echo $session->flash(); endif; // this line displays our flash messages
			echo $content_for_layout;
	  	?>
	  	
</body>
</html>
