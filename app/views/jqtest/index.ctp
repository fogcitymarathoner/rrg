
<script type="text/javascript">
    $(function(){

        // Accordion
        $("#accordion").accordion({ header: "h3" });

        // Tabs
        $('#tabs').tabs();

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });

        // Dialog Link
        $('#dialog_link').click(function(){
            $('#dialog').dialog('open');
            return false;
        });

        // Datepicker
        $('#datepicker').datepicker({
            inline: true
        });

        // Slider
        $('#slider').slider({
            range: true,
            values: [17, 67]
        });

        // Progressbar
        $("#progressbar").progressbar({
            value: 20
        });

        //hover states on the static widgets
        $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
        );

    });
</script>
<style type="text/css">
    /*demo page css*/
body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
.demoHeaders { margin-top: 2em; }
#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
ul#icons {margin: 0; padding: 0;}
ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
ul#icons span.ui-icon {float: left; margin: 0 4px;}
</style>

<?php

        echo $html->link('datepicker test','datepicker_test');

        echo $html->link('menu test','menu_test');
        ?>