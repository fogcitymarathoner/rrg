<h2><?php echo sprintf(__('Missing Method in %s', true), $controller);?></h2>
<p class="error">
	<strong><?php __('Error') ?>: </strong>
	<?php echo sprintf(__('The action %1$s is not defined in controller %2$s', true), "<em>" . $action . "</em>", "<em>" . $controller . "</em>");?>
</p>
<p class="error">
	<strong><?php __('Error') ?>: </strong>
	<?php echo sprintf(__('Create %1$s%2$s in file: %3$s.', true), "<em>" . $controller . "::</em>", "<em>" . $action . "()</em>", APP_DIR . DS . "controllers" . DS . Inflector::underscore($controller) . ".php");?>
</p>
<?php echo $html->image('pics/cashfinger-big.jpg',array('title'=>"Here'sssss Johnny!")); ?>		

<pre>
&lt;?php
class <?php echo $controller;?> extends AppController {

	var $name = '<?php echo $controllerName;?>';

<strong>
	function <?php echo $action;?>() {

	}
</strong>
}
?&gt;
</pre>
<p class="notice">
	<strong><?php __('Notice') ?>: </strong>
	<?php echo sprintf(__('If you want to customize this error message, create %s.', true), APP_DIR . DS . "views" . DS . "errors" . DS . "missing_action.ctp");?>
</p>