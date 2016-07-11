<h2><?php __('Missing View'); ?></h2>
<p class="error">
	<strong><?php __('Error'); ?>: </strong>
	<?php echo sprintf(__('The view for %1$s%2$s was not found.', true), "<em>" . $controller . "Controller::</em>", "<em>". $action . "()</em>");?>
</p>
<?php echo $html->image('pics/cashfinger-big.jpg',array('title'=>"Here'sssss Johnny!")); ?>		

<p class="error">
	<strong><?php __('Error'); ?>: </strong>
	<?php echo sprintf(__('Confirm you have created the file: %s', true), $file);?>
</p>
<p class="notice">
	<strong><?php __('Notice'); ?>: </strong>
	<?php echo sprintf(__('If you want to customize this error message, create %s', true), APP_DIR . DS . "views" . DS . "errors" . DS . "missing_view.ctp");?>
</p>