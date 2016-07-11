<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php if(isset($title)){ ?>

<title><?php echo $title;?></title>
<?php }else{ ?>
<title>SF Geek</title>
<?php } ?>
<?php 
	echo $html->css('simple_menu');
?>
</head>
<body >
<div id="navigation">
	<ul id="menu">
	
		<li><?php echo $html->link(__('memos', true), array('controller'=>'posts_mobi','action'=>'search_s')); ?></li>
		<li><?php echo $html->link(__('contacts', true), array('controller'=>'contacts','action'=>'search_s')); ?></li>
		<li><?php echo $html->link(__('calls', true), array('controller'=>'calls_mobi','action'=>'index')); ?></li>
	
	</ul>
</div> 	
	<?php echo $content_for_layout;	?>
</body>
</html>
