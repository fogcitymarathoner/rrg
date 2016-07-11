<html>
<head>
	<title>Rocketsredglare Database</title>
	<?php echo $html->css('cake.generic');?>
</head>
<body>
	<div id="container">
	<div id="content">
		<!-- The next file contains your menu data, links and menu structure etc -->

			<?php echo $content_for_layout;?>
            <?php echo $this->element('sql_dump'); ?>

	</div>
	</div>
</body>
</html>
