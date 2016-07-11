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
	echo $html->css('emx_nav_left.css');
	echo $javascript->link('dw_menu.js');
	echo $javascript->link('jquery-1.3.2.min.js'); 
	echo $scripts_for_layout; 
	echo $html->meta(
	    'favicon.ico',
	    $favico,
	    array('type' => 'icon')
	);  
	if ($this->params['controller']=='chat_rooms')
	{
		echo $html->css('/chat/css/chat.css'); 
		echo $javascript->link('/chat/js/chat.js'); 
	}	
	        		
?>
</head>
<body onmousemove="closesubnav(event);">
<div class="skipLinks">skip to: <a href="#content">page content</a> | <a href="#pageNav">links on this page</a> | <a href="#globalNav">site navigation</a> | <a href="#siteInfo">footer (site information)</a> </div>
<div id="masthead">

  <?php if(isset($siteName)){ ?>
	<?php echo '<h1 id="siteName">'.$siteName.'</h1>';}else{ ?>
	<h1 id="siteName">SF Geek</h1>
	<?php }?>
	
	<div id="utility">
		<?php echo $dwMenu->utilityMenu($utilityMenu); ?>
	</div>

  <div id="globalNav">
	<?php echo $html->image('gblnav_left.gif', array('width' => 4, 'height' => 32, 'id'=>'gnl'));?>
	<?php echo $html->image('glbnav_right.gif', array('width' => 4, 'height' => 32, 'id'=>'gnr'));?>
    <div id="globalLink"> 
		<?php echo $dwMenu->mainMenu($mainMenu); ?>
	</div>
    <!--end globalLinks-->
    <form id="search" action="">
      <input name="searchFor" type="text" size="10" />
      <a href="">search</a>
    </form>
  </div>
  <!-- end globalNav -->
  <?php echo $dwMenu->subMenu($mainMenu); ?>
</div>
<!-- end masthead -->
<div id="pagecell1">
  <!--pagecell1-->

  <?php echo $html->image('tl_curve_white.gif', array('width' => 6, 'height' => 6, 'id'=>'tl'));?>
  <?php echo $html->image('tr_curve_white.gif', array('width' => 6, 'height' => 6, 'id'=>'tr'));?>
	<!--
  <div id="breadCrumb">   
  	<a href="#">Breadcrumb</a> / <a href="#">Breadcrumb</a> / <a href="#">Breadcrumb</a> / 
  </div>
	-->
  <div id="pageName">
    <?php if(isset($page)){ ?>
	<?php echo '<h2>'.$page.'</h2>';}else{ ?>
		<h2>Page Name</h2>
	<?php }?><br>
    <?php echo $html->image($siteSmallLogo, array('width' => 64, 'height' => 64, 'id'=>'smlogo','alt'=>'small logo')); ?>
  </div>

	<?php echo $content_for_layout;	?>

  <div id="siteInfo"> 
  	<?php echo $siteInfo;?>  
  </div>
</div>
<!--end pagecell1-->
<br />
<script type="text/javascript"><!--THIS CODE ONLY WORKS HERE -->
    <!--
    	<?php echo $dwMenu->buildJavaMenu($mainMenu); ?>
    // -->
</script>
</body>
</html>
