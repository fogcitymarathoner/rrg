<div class="invoices index">
<h2><?php echo $page_title;?></h2>
<p>
<?php echo $html->link(__('Return to payrolls', true), array('action'=>'index')); ?>
</p>
<form id="PostAddForm" method="post" action="select_check_directdeposit">

<input type="radio" name="data[Payroll][Paycheck][]" value="<?php echo $keys[0];?>" > <?php echo $names[0];?>
<input type="radio" name="data[Payroll][Paycheck][]" value="<?php echo $keys[1];?>" > <?php echo $names[1];?>

<input type="submit" value="Submit" />

</form>	