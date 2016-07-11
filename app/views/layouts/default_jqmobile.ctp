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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php echo $this->element('m/jqmobile_cdn',array());?>
    <script>
        //reset type=date inputs to text
        $( document ).bind( "mobileinit", function(){
            $.mobile.page.prototype.options.degradeInputs.date = true;
        });
    </script>
    <style>
    .ui-icon-pencil_16x16 {
    background-image: url('<?php echo $this->webroot?>img/icons/pencil-icon_16x16.png');
    }
    .ui-icon-mag_glass_16x16 {
    background-image: url('<?php echo $this->webroot?>img/icons/magnifying_glass16x16.png');
    }
    </style>

</head>
<body>
<?php echo $page_title; ?>
<div data-role="page" id="firstPage">
    <?php echo $this->element('m/header',array('title'=>$page_title));?>
    <div data-role="content">
        <?php echo $content_for_layout;?>
    </div>
    <?php echo $this->element('m/footer');?>
</div>
</body>
</html>
