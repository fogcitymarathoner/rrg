<?php //debug($this->viewVars); ?>
<?php //debug($this->data); exit; ?>
<div class="invoices view">
<h2><?php  __('Invoice');?></h2>
<?php 
echo $crumb->getHtml('Invoice '.$this->data['Invoice']['id'], 'reset' ) ;  
echo '<br /><br />' ; 
echo $this->data['Invoice']['urltoken'].'<br>';
echo 'view count: ';
echo $this->data['Invoice']['view_count'].'<br>';

?>
</div>
