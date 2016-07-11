<div class="invoices index">

<?php echo $invoice->reminders_menu(); ?>		
<br>		
<?php 

echo $javascript->link('reminders');
echo $invoice->sent_receipt($this->data);

?>
</div>
