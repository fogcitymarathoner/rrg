<div data-role="header">
<h1><?php echo $title ;?></h1>
<?php if ($session->check('Message.flash')){ echo $session->flash(); } // this line displays our flash messages ?>
    <?php echo $this->element('m/main_menu');?>
</div>
