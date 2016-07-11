<?php  foreach ($vendors as $vendor):?>
<li><a href="<?php echo $this->webroot?>m/vendors/view/<?php echo $vendor['Vendor']['id']?>" data-rel="dialog"><?php echo __($vendor['Vendor']['name'], true).' - '.__($vendor['Vendor']['purpose'], true)?></a></li>
<?php endforeach;?>
