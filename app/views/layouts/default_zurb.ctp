<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width" />

    <title>Welcome to Foundation</title>

    <!-- Included CSS Files (Uncompressed) -->
    <!--
    <link rel="stylesheet" href="stylesheets/foundation.css">
    -->

    <!-- Included CSS Files (Compressed) -->
    <!--<link rel="stylesheet" href="stylesheets/foundation.min.css"> -->
    <?php echo $html->css('foundation/stylesheets/foundation.min'); ?>
    <!--<link rel="stylesheet" href="stylesheets/app.css">-->
    <?php echo $html->css('foundation/stylesheets/app'); ?>
    <!--<script src="javascripts/modernizr.foundation.js"></script> -->
    <?php echo $html->script('foundation/javascripts/modernizr.foundation'); ?>

    <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
<?php
        if ($session->check('Message.flash')): $session->flash(); endif; // this line displays our flash messages
        echo $content_for_layout;
        ?>

<?php
        if(Configure::read('debug')==2)
            echo $this->element('sql_dump'); ?>


<!-- Included JS Files (Uncompressed) -->
<!--

<script src="javascripts/jquery.js"></script>

<script src="javascripts/jquery.foundation.mediaQueryToggle.js"></script>

<script src="javascripts/jquery.foundation.forms.js"></script>

<script src="javascripts/jquery.foundation.reveal.js"></script>

<script src="javascripts/jquery.foundation.orbit.js"></script>

<script src="javascripts/jquery.foundation.navigation.js"></script>

<script src="javascripts/jquery.foundation.buttons.js"></script>

<script src="javascripts/jquery.foundation.tabs.js"></script>

<script src="javascripts/jquery.foundation.tooltips.js"></script>

<script src="javascripts/jquery.foundation.accordion.js"></script>

<script src="javascripts/jquery.placeholder.js"></script>

<script src="javascripts/jquery.foundation.alerts.js"></script>

<script src="javascripts/jquery.foundation.topbar.js"></script>

-->

<!-- Included JS Files (Compressed) -->
<!--<script src="javascripts/jquery.js"></script> -->
<?php echo $html->script('foundation/jquery'); ?>
<!--  <script src="javascripts/foundation.min.js"></script> -->
<?php echo $html->script('foundation/javascripts/foundation.min'); ?>

<!-- Initialize JS Plugins -->
<!-- <script src="javascripts/app.js"></script> -->
<?php echo $html->script('foundation/javascripts/app'); ?>

</body>
</html>