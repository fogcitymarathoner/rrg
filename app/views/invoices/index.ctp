<script xmlns="http://www.w3.org/1999/html">
    employees = jQuery.parseJSON('<?php echo $employees; ?>');
    clients = jQuery.parseJSON('<?php echo $clients; ?>');
    invoices = jQuery.parseJSON('<?php echo $invoicesJS; ?>');
</script>
<?php echo $javascript->link('invoices');?>
<?php echo $this->element('invoices/menu', array()); ?>
<div class="invoices index">
    <h2><?php __($page_title);?></h2>
    <div class="paging">
        <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
     | 	<?php echo $paginator->numbers();?>
        <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
    </div>
    <p>
    <?php
    echo $paginator->counter(array(
    'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
    ));
    ?></p>
    <table cellpadding="1" cellspacing="1" border=1>
    <tr>
        <th><?php echo $paginator->sort('id');?></th>
        <th>Client</th>
        <th>Employee</th>
        <th><?php echo $paginator->sort('date');?></th>
        <th><?php echo $paginator->sort('begin');?></th>
        <th><?php echo $paginator->sort('end');?></th>
        <th><?php echo $paginator->sort('amount');?></th>
        <th><?php echo $paginator->sort('notes');?></th>
        <th class="actions"><?php __('Actions');?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($invoices as $invoice):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
        //debug($invoice);exit;
    ?>
        <tr<?php echo $class;?>>
            <td>
                <?php echo $invoice['Invoice']['id'];  ?>
            </td>
            <td>
                <div id="invoice-client-<?php echo $invoice['Invoice']['id']?>"></div>
            </td>
            <td>
                <div id="invoice-employee-<?php echo $invoice['Invoice']['id']?>"></div>
            </td>
            <td>
                <?php echo date('m/d/Y',strtotime($invoice['Invoice']['date'])).'|'; ?>
            </td>
            <td>
                <?php echo date('m/d/Y',strtotime($invoice['Invoice']['period_start'])).'-'; ?>
            </td>
            <td>
                <?php echo date('m/d/Y',strtotime($invoice['Invoice']['period_end'])); ?>
            </td>
            <td align="right">
                <?php echo sprintf('%8.2f',round($invoice['Invoice']['amount'],2)); ?>
            </td>
            <td>
                <?php echo $invoice['Invoice']['notes']; ?>
            </td>
            <td>
                <?php echo $html->link(__('Edit', true), array('action'=>'edit',$invoice['Invoice']['id']));?>
                <?php echo $html->link(__('View', true), array('action'=>'view',$invoice['Invoice']['id']));?>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
