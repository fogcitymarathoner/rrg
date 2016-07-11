<?PHP //debug($this->webroot);
?>
    <table cellspacing="0" border="0">
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>

          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
	<tr>
            <td colspan="4">
            	<?php echo $html->image('blank.gif', array('width' => 400, 'height' => 15));?>
        </tr>
	<tr>
            <td colspan="4">
            	<?php 
				echo $html->link( 
	$html->image('RRG_LOGO_WEB.png', array('width' => 100, 'height' => 100, 'border'=>0)), 
	array('action' => 'view/'.$this->data['Invoice']['id']), 
	array(), 
	null, 
	false );?>
				</td>
            <td colspan="2"><span class="Head">Invoice</span><br>

              Date: <?PHP echo $invoice['Invoice']['date'];?><br><a href="cover.php?CategoryID=2&IntakeFormID=88" style="text-decoration:none; color:#000000" >#</a><?PHP echo $invoice['Invoice']['id'];?></td>
	</tr>
	<tr>
<td colspan="4" class="OurAddress">
	<?php
				///$settings =$this->requestAction('/settings/getsettings/'); 
?>
	   <p><?php //echo $settings['Setting']['name'] 
	   echo 'Rockets Redglare';?><br>
		  <?php //echo $settings['Setting']['street1'] ;?>
		  <?php echo '1082 View Way'; ?><br>
		  <?php echo 'Pacifica, CA 94044'; ?><br>

		  <?php //echo $settings['Setting']['city'] ?><?php //echo $settings['Setting']['state'] ?> <?php //echo $settings['Setting']['zip'] ?><br>
	      <?php //echo $settings['Setting']['phone'] ?> </p>
            </td>
            <td colspan="3">
		<?PHP echo '<br><b>'.$client['Client']['name'].'</b> '.'<br>'.
		$client['Client']['street1'].'<br>';
		if (strlen  ( $client['Client']['street2']  )>0)
		{
			$client['Client']['street2'].'<br>';			
		}
		echo $client['Client']['city'].' '.
		$client['Client']['st'].' '.
		$client['Client']['zip'].'<br>';
		?>

				
				
				</td>
	</tr>	
	
	<tr>
<td colspan="4" class="OurAddress">
	   <p><?php echo $invoice['ClientsContract']['title'];?><br>
	   <p><?php echo 'During the period of: '.$invoice['Invoice']['period_start'].' to '.$invoice['Invoice']['period_end'].'.';?><br>
           </td>
            <td colspan="3">
				
				</td>
	</tr>

		<tr class="Data">

          <td colspan="5">
          	 <?php echo $html->image('blank.gif', array('width' => 22,'height'=>1))?>
          </td>
	</tr>	
          <tr class="SubHead">

            <td colspan="2">
                Service <?php echo $html->image('blank.gif', array('width' => 360,'height'=>1))?>

            </td>
            <td> Hours</td>
            <td><?php echo $html->image('blank.gif', array('width' => 40,'height'=>1))?></td>
            <td> <div align="right">Rate </div></td>
            <td><div align="right">Subtotal</div></td>
        </tr>





	<tr>
		<?php
		$i = 0;
		$totalQuant = 0;
		foreach ($invoice['InvoicesItem'] as $InvoiceItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			$totalQuant += $InvoiceItem['quantity'];
			$quant = sprintf("%8.2f",    $InvoiceItem['quantity']); // right-justification with spaces
			$cost = sprintf("%8.2f",    $InvoiceItem['amount']); // right-justification with spaces
			$subtotal = sprintf("%8.2f",    $InvoiceItem['quantity']*$InvoiceItem['amount']); // right-justification with spaces
            if ($subtotal != 0){
		?>
    <tr>
    <td colspan="2" class="Data"><?php echo $InvoiceItem['description'];?></td>
    <td align="right"><?php echo $quant;?></td>
	
    <td></td>
    <td> <div align="right">$&nbsp;<?php echo $cost;?> </div></td>

    <td> <div align="right">$&nbsp;<?php echo $subtotal;?></div></td>
    </tr>
	<?php 
	}
	endforeach; ?>
	</tr>

    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo $html->image('blank.gif', array('width' => 300,'height'=>1))?></td>
	
        <td class="SubHead"><div align="left">Totals:</div></td>
        <td class="SubHead"><div align="right"><?php echo $totalQuant; ?></div></td>
        <td class="SubHead">&nbsp;</td>

        <td class="SubHead"><div align="right">&nbsp; </div></td>
	<td class="SubHead"><div align="right"><b>$&nbsp;<?php echo $invoice['Invoice']['amount'];?></b></div></td>
    </tr>
	<tr>
<td colspan="4" class="OurAddress">
	<?php
				///$settings =$this->requestAction('/settings/getsettings/'); 
?>
	   <p><?php echo $invoice['ClientsContract']['invoicemessage']; ?><br>
	   	   <p><?php echo $invoice['Invoice']['message'];?><br>
            </td>
            <td colspan="3">
		<?PHP //echo '<br><b>'.$client['Client']['name'].'</b> '.'<br>'.
		$client['Client']['street1'].'<br>'.
		$client['Client']['street2'].'<br>'.
		$client['Client']['city'].' '.
		$client['Client']['st'].' '.
		$client['Client']['zip'].'<br>';
		?>
	</td>
	</tr>	


		
	
	

</table>
</body></html>