<html>
<head>
<title>
<?php if (isset($page_title))
	{
		echo $page_title;
	} else 
	{
		echo 'RRG DB';
	}
?>
</title>	<?php //echo $html->css('cake.generic');?>
</head>
<body>
	<div id="container">
	<div id="content">
		<!-- The next file contains your menu data, links and menu structure etc -->

			<?php echo $content_for_layout;?>
	</div>
	</div>
</body>
</html>
