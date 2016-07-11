<h3><?php echo $clientsContract['Client']['name']; ?> - Contract</h3>
<a href="<?php echo $this->webroot?>employees/edit_contract/<?php echo $clientsContract['ClientsContract']['id']?>">|edit|</a>Don't forget to <br>
Enter a title - "Professional IT services"<br>
Enter a message - "Reports to ... , Hired by ..."<br><?php  //debug($clientsContract['ContractsItem']['ContractsItemsCommissionsItem']);?>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Invoicemessage'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['invoicemessage']; ?>
			&nbsp;
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo '<br> Total hours worked';?>&nbsp;<?php echo $hours; ?>
			&nbsp;
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Employee'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['Employee']['firstname'].' '.$clientsContract['Employee']['lastname']; ?>
			&nbsp;
		</dd>		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Startdate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['startdate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Enddate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['enddate']; ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Terms'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['terms']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Po'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['po']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Potracking'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['potracking']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Employerexp'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['employerexp']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Reports To'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['reports_to']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mock Invoice ID'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['mock_invoice_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active/Inactive'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
			if ($clientsContract['ClientsContract']['active']==1)
				echo 'Active';
			else
				echo 'Inactive';
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contract Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
			if ($clientsContract['ClientsContract']['addendum_executed']==1)
				echo 'In Place';
			else
				echo 'Pending';
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['Period']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
