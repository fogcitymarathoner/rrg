<h3>Select invoices to credit for <?php echo $clientData['Client']['name'];?></h3>
<form id="page-changerx" action="<?php echo $webroot?>m/clients/add_check_step3" method="post"  autocomplete="off">
<legend>Open Invoices:</legend>
<style>
.line-item {
    width: 150px;
    float: left;
    overflow: hidden;
    white-space: nowrap;
    display: block;
    margin-bottom: 1ex;
}
.monospaced {
    font-family: courier, monospace;
}
.proportional {
    font-family: helvetica, sans-serif;
}
.ellipsis {
    text-overflow: ellipsis;
}
:-moz-any(.force-ellipsis):before {
    background: #fff;
    content: "…";
    position: absolute;
    margin-left: -moz-calc(150px - 1em);
    width: 1em;
    height: 1em;
}
.small-text {font-size: 9px}
.big-text {font-size:20px}
.line-item
{
    font-family: "courier new",monospace;
    width: 100%;
}
</style>
<script>
$(document).ready(function() {
    $("input.ckamt").click(function () {
        // your code here
        //alert('checked')
        ckstotal = 0;
        items = [];
        items = $("input:checkbox:checked.ckamt").map(function () {
            return this.value;
        }).get();
        //alert(items);
        for (var item in items) {
            //alert('cycled item'+items[item]);
            ckstotal=ckstotal+parseFloat(items[item]);
        }
        $('#ckseltotal').html("Selected Check Total: $"+(ckstotal).toFixed(2));
    });
});
</script>
<?php
        $i = 0;
        echo '<input type="hidden" name="data[Client][Client][id]" value='.$clientData['Client']['id'].'>';
foreach ($invoices as $invoice)
{
    //debug($invoice);
    if ($invoice['Invoice']['balance'] > 0 )
    {
        echo '<div data-role="fieldcontain">';
        echo '<fieldset data-role="controlgroup">';
        $balStr = sprintf('%01.2f',$invoice['Invoice']['balance']);
        echo '<input type="checkbox" name="data[Invoice][Invoice]['.$invoice['Invoice']['id'].']" id="data[Invoice][Invoice]['.$invoice['Invoice']['id'].']" class="ckamt" value="'.$balStr.'"/>';
        echo '<div class="line-item">';
        echo '<label  for="data[Invoice][Invoice]['.$invoice['Invoice']['id'].']">#'.$invoice['Invoice']['id']
                .' | '.str_pad('$'.sprintf('%01.2f',$invoice['Invoice']['balance']),8,'+',STR_PAD_LEFT).' | '
                .date('m/d/Y',strtotime($invoice['Invoice']['date'])).' | '
                .'from: '.date('m/d/Y',strtotime($invoice['Invoice']['period_start'])).' to '.date('m/d/Y',strtotime($invoice['Invoice']['period_end']))
                .'</label>';
        echo '</div>';
        echo '</fieldset>';
        echo '</div>';
    }
}
echo $form->end('Submit');
?>
<div id="ckseltotal"></div>