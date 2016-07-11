<html>
<head>
	<title>Rocketsredglare Database</title>
	<?php echo $javascript->link('milonic/milonic_src.js'); ?>
	<?php echo $javascript->link('milonic/mmenudom.js'); ?>
	<?php echo $javascript->link('milonic/milonic_menu_code.js'); ?>
</head>
<body>
	<div id="container">
	<div id="content">
		<!-- The next file contains your menu data, links and menu structure etc -->
			<?php echo $javascript->link('milonic/menu_data.js'); ?>
           	<?php echo $html->image('10x50.png', array('width' => 40, 'height' => 25));?>

			<?php echo $content_for_layout;?>
	</div>
	</div>
</body>
</html>
