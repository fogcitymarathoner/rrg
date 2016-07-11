
<script type="text/javascript">
    $(function(){
        $("#restricting").datepicker({
            yearRange: "-70:+0", // this is the option you're looking for
            showOn: "both",
            buttonImage: "templates/images/calendar.gif",
            buttonImageOnly: true,

            changeMonth: true,
            changeYear: true,

        });

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
<input type='text' id='restricting'  />