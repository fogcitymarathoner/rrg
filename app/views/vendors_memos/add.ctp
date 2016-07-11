<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Vendor', true), array('controller'=>'vendors','action'=>'view',$vendor['Vendor']['id']));?></li>
	</ul>
</div>
<div class="vendorsMemos form">
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
	$('#VendorsMemoNotes').markItUp(mySettings);
	
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

<?php  
//debug($vendor);
echo $form->create('VendorsMemo');?>
	<fieldset>
 		<legend><?php  __('Add Memo for vendor - '.$vendor['Vendor']['name']);?></legend>
	<?php
		echo $form->input('vendor_id',array('value'=>$this->params['named']['vendor_id'],'type'=>'hidden'));
		echo $form->input('date',array('value'=>date('Y-m-d')));
		echo $form->textarea('notes',array('cols'=>100,'rows'=>60));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Vendor', true), array('controller'=>'vendors','action'=>'view',$vendor['Vendor']['id']));?></li>
	</ul>
</div>
