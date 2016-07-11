<style type="text/css">
.waiting {
    background-image: url('<?php echo $webroot; ?>img/wait.gif');
    background-repeat:no-repeat;
}
.div400x100 {
    width:400px;
    height:100px;
}

#modal-overlay {
    position: fixed;
    z-index: 10;
    background: black;
    opacity: .75;
    filter: alpha(opacity=75);
    width: 100%;
    height: 100%;
}
</style>

<div id="reminders-waiting-area" class="waiting div400x100"></div>
<div id="modal-overlay"> </div>