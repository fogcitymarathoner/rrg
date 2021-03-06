<!-- markItUp! -->
<script type="text/javascript" src="<?php echo $this->webroot ;?>js/markitup/jquery.markitup.js"></script>
<!-- markItUp! toolbar settings -->
<script type="text/javascript" src="<?php echo $this->webroot ;?>js/markitup/sets/default/set.js"></script>
<!-- markItUp! skin -->

<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ;?>css/markitup/skins/markitup/style.css" />
<!--  markItUp! toolbar skin -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ;?>css/markitup/sets/default/style.css" />

<script type="text/javascript">
<!--
$(document).ready(function()	{
	// Add markItUp! to your textarea in one line
	// $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
	$('#ClientsMemoNotes').markItUp(mySettings);
	
	// You can add content from anywhere in your page
	// $.markItUp( { Settings } );	
	$('.add').click(function() {
 		$.markItUp( { 	openWith:'<opening tag>',
						closeWith:'<\/closing tag>',
						placeHolder:"New content"
					}
				);
 		return false;
	});
	
	// And you can add/remove markItUp! whenever you want
	// $(textarea).markItUpRemove();
	$('.toggle').click(function() {
		if ($("#markItUp.markItUpEditor").length === 1) {
 			$("#markItUp").markItUpRemove();
			$("span", this).text("get markItUp! back");
		} else {
			$('#markItUp').markItUp(mySettings);
			$("span", this).text("remove markItUp!");
		}
 		return false;
	});
});
-->
</script>

<div class="clientsMemos form">
<?php echo $form->create('Clients',array('action'=>'add_memo'));?>
	<fieldset>
 		<legend><?php __('Add Memo');?></legend>
	<?php
		echo $form->input('ClientsMemo.date');
		//echo $fck->fckeditor(array('ClientsMemo', 'notes'), $html->base, ''); 
		
		echo $form->textarea('ClientsMemo.notes',array('cols'=>100,'rows'=>60));
		echo $form->input('ClientsMemo.client_id',array('type'=>'hidden','value'=>$this->data['ClientsMemo']['client_id']));
		echo $form->input('modified_user_id',array('name'=>'data[ClientsMemo][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('created_user_id',array('name'=>'data[ClientsMemo][created_user_id]','type'=>'hidden', 'value'=>$currentUser));
		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Client', true), array('action'=>'view_memos', $this->data['ClientsMemo']['client_id'])); ?> </li>
	</ul>
</div>
