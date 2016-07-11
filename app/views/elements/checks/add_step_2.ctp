<?php
if (!function_exists('json_decode')) {
    function json_decode($content, $assoc=false) {
        require_once 'classes/JSON.php';
        if ($assoc) {
            $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        }
        else {
            $json = new Services_JSON;
        }
        return $json->decode($content);
    }
}
$invs = json_decode($invoicesJson);
//debug($invoicesJson);
//debug($invs); exit;
?>
<?php echo $javascript->link('jquery.tablednd_0_5'); ?>
<script>
var client_id = <?php echo $this->data['ClientsCheck']['client_id']?>;
var invoicesJSON='<?php echo $invoicesJson?>';

// Clear the check boxes
</script>
<?php
    echo $javascript->link('add_check_app');
    echo $html->css('two-col-web-ck-label-app');
?>
<h3>Select invoices to credit for <?php echo $clientData['Client']['name'];?></h3>
<div id="wrap">
    <div id="header"></div>
    <div id="nav-checks">
        <table> <?php
            echo $form->create('ClientsCheck',array('url' => array('controller'=>'clients','action'=>'add_check/'.$this->data['ClientsCheck']['client_id'].'/3')));
            echo '<tr>';
                echo '<td>';
                    echo $form->input('client_id', array('type'=>'hidden','value'=>$this->data['ClientsCheck']['client_id']));
                    echo '</td>';
            echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo $form->input('number', array('value'=>$this->data['ClientsCheck']['number'],'size'=>12));
                echo '</td>';
            echo '</tr>';
            echo '<tr><td>';
                ?>
                <p><label for="call_date">Date</label> : <input type="text" class="w16em" id="check_date" name="data[ClientsCheck][date]" value="<?php echo $this->data['ClientsCheck']['date']; ?>" /></p>
                <script type="text/javascript">
                    // <![CDATA[
                    var opts = {
                        // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)
                        formElements:{"check_date":"m-sl-d-sl-Y"}
                    };
                    datePickerController.createDatePicker(opts);
                    // ]]>
                </script>
                <?php

                echo '</td>';
                echo '</tr>';
            echo '<tr>';
                echo '<td>';
                    echo $form->input('notes', array('value'=>$this->data['ClientsCheck']['notes'],'size'=>70));
                    echo '</td>';
                echo '</tr>';
            ?>
        <tr>
            <td colspan=4>
                <div id="ckselcount"  class="inline">0</div>
                <div class="inline">-Checks Selected Adding to $</div>
                <div id="ckseltotal" class="inline">0.00</div>
                <div class="inline"></div>
            </td>
        </tr>
        </table>
    </div>
    <div id="main">
        <div id="left_col">

        <div id="invoice-list">
            <table  cellpadding = "3" cellspacing = "3" border=1 >
                <tr>
                    <th></th>
                    <th>Inv.<br>No.</th>
                    <th>Amount</th>
                </tr>
                <?php
            $i = 0;
//debug($invoices);
            foreach ($invs as $invoice):
            //debug($invoice->amount);
                if ($invoice->amount > 0 )
                {
                $class = null;
                if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class;?>>
                <td>
                    <input type="checkbox"  name="data[Invoice][Invoice]['<?php echo $invoice->id?>']"  value="<?php echo $invoice->amount; ?>" class="ckamt" id="InvoiceInvoice<?php echo $invoice->id; ?>" />
                </td>
                <td>
                    <?php echo $invoice->id; ?>
                </td>
                <td align="right">
                    <?php echo sprintf('%8.2f',round($invoice->amount,2)); ?>
                </td>
                </tr>
                <?php
                }
            endforeach;
            ?>
            </table>
        </div>
    </div>
    </div>
    <div id="sidebar"><div id='content_col'>
        <table id="invoicetable"  cellpadding = "3" cellspacing = "3" border=1 >
            <tr>
                <th></th>
                <th>Inv.<br>No.</th>
                <th>Amount</th>
            </tr>
            <?php
        $i = 0;
        if(!empty($invs))
        {
            foreach ($invs as $invoice):
                if ($invoice->amount > 0 )
            {
            $class = ' class="hidden shadowrow"';
            if ($i++ % 2 == 0) {
            $class = ' class="altrow hidden shadowrow"';
            }
            ?>
            <tr<?php echo $class;?> id="shadowrow-<?php echo $invoice->id?>">
            <td>
                <input type="checkbox"  id="shadowinput-<?php echo $invoice->id?>"   disabled="disabled" name="data[Invoice][Invoice]['<?php echo $invoice->id?>']"  value="<?php echo $invoice->amount; ?>" class="ckamt-shadow" id="InvoiceInvoice<?php echo $invoice->id; ?>" />
            </td>
            <td>
                <?php echo $invoice->id; ?>
            </td>
            <td align="right">
                <?php echo sprintf('%8.2f',round($invoice->amount,2)); ?>
            </td>
            </tr>
            <?php
                }
            endforeach;
        } ?>
        </table>
        <?php echo $form->end('Submit',array('id'=>'save-check-button')); ?>
    </div>
    </div>
    <div id="footer"></div>
</div>
