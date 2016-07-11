<script>
$(document).ready(function() {

    $('#ckformsubmit').click( function(e) {
        //e.preventDefault();
        if ($('input#checknumber').val() =='')
        {
            alert('You must type a check number');
            return false;
        }
    });

});
</script>
<h3>Verify invoices to credit for <?php echo $clientData['Client']['name'];?></h3>
<fieldset>
<form id="page-changerxx" action="<?php echo $this->webroot?>m/clients/add_check_step4/" method="post"  autocomplete="off" data-ajax="false" rel="external" data-reveal-id="ckform">

    <div data-role="fieldcontain">

        <label for="data[ClientsCheck][date]">Check Date</label>
        <input type="date"   id="date" name="data[ClientsCheck][date]" />
    </div>
<table>

<?php
        //debug($this->data);
        //echo $form->create('ClientsCheck',array('url' => array('prefix'=>'m','controller'=>'clients','action'=>'add_check_step4/')));
        echo '<tr>';
        echo '<td>';
        echo $form->input('ClientsCheck.client_id', array('type'=>'hidden','value'=>$clientData['Client']['id']));
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo "This 'Amount' is a calculation.  Replaced by the sum of the values below.";
        echo $form->input('ClientsCheck.amount', array('readonly'=>true,'value'=>sprintf('%01.2f',$this->data['ClientsCheck']['amount']),'size'=>12));
        echo '</td></tr>';
        echo '<tr>';
        echo '<td>';
        echo $form->input('ClientsCheck.number', array('size'=>12,'id'=>'checknumber'));
        echo '</td></tr>';
        echo '<tr><td>';
        ?>
<?php

        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo $form->input('ClientsCheck.notes', array('size'=>70));
        echo '</td>';
        echo '</tr>';
        ?>
</table>

<table>
<tr>
    <th>Invoice No.</th>
    <th>Date</th>
    <th>Start</th>
    <th>End</th>
    <th>Inv. Amount</th>
    <th>Balance</th>
    <th>Notes</th>
</tr>

<?php
        $i = 0;
        foreach ($this->data['ClientsCheck']['Invoice'] as $invoice)
        {
        $class = null;
        if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
        }
        ?>
<tr<?php echo $class;?>>
<td>
    <?php echo $invoice['Invoice']['id']; ?>
</td>
<td>
    <?php echo $rapp->regularDateDisplay($invoice['Invoice']['date']); ?>
</td>
<td>
    <?php echo $rapp->regularDateDisplay($invoice['Invoice']['period_start']); ?>
</td>
<td>
    <?php echo $rapp->regularDateDisplay($invoice['Invoice']['period_end']); ?>
</td>
<td align="right">
    <?php echo sprintf('%8.2f',round($invoice['Invoice']['amount'],2)); ?>
</td>
<td align="right">
    <?php
            echo $form->input('created_user_id',array('type'=>'hidden', 'value'=>$currentUser));

            //echo $form->input('Invoice.invoice_id', array(name=>'data[Invoice][Invoice][]','label'=>'','value'=>sprintf('%8.2f',round($invoice['Invoice']['balance'],2))));
            ?>
    <input  type="hidden" name="data[Invoice][InvoiceId][][id]" value="<?php echo $invoice['Invoice']['id']; ?>" id="InvoiceInvoice<?php echo $invoice['Invoice']['id']; ?>" />
    <input  name="data[Invoice][InvoiceAmount][][amount]" size=7 value="<?php echo sprintf('%8.2f',round($invoice['Invoice']['balance'],2)); ?>" id="InvoiceInvoice<?php echo $invoice['Invoice']['id']; ?>" />
</td>
<td>
    <?php echo $invoice['Invoice']['notes']; ?>
</td>
</tr>
        <?php if (!empty($invoice['InvoicesPayment']))
                {
                ?>
                <tr>
<td colspan=100%>
<table>
    <tr>
        <td colspan=100%>fff</td>
    </tr>
<tr>
<th>Check No.</th>
<th>Amount</th>
<th>Notes</th>
</tr>
        <?php
                $paymenttotal = 0;
                foreach ($invoice['InvoicesPayment'] as $payment)
                {
                ?><tr>
<td><?php echo $payment['number'];?></td>
<td align=right ><?php echo sprintf('%8.2f',round($payment['amount'],2));?></td>
<td><?php echo $payment['notes'];?></td>
        </tr>
        <?php } ?>
</table>
</td>
</tr>
        <?php } ?>
        <?php


                }?>

</table>
 <input type="submit" value="Save Check" id="ckformsubmit" />


        </fieldset>