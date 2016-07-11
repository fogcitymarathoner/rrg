<?php echo $javascript->link('employees');?>
<div class="employees index">
    <?php echo $this->element('employees/menu',array()); ?>
    <br>
        <h2><?php __('Employees - Sync with Sphene');?></h2>
    </br>
<?php
        echo $form->create('SpheneSync',array('url' => array('controller'=>'employees','action'=>'sync_sphene_step2/')));
?>

        <table cellpadding = "3" cellspacing = "3" border=1>
<tr>
	<th><?php echo 'Name';?></th>
    <th><?php echo 'internal Cat';?></th>
    <th><?php echo 'internal Thread';?></th>
	<th><?php echo 'released Cat';?></th>
	<th><?php echo 'released Thread';?></th>
</tr>
<?php
$i = 0;
foreach ($employees as $employee):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo '<h3><a href="'.$this->webroot.'employees/view/'.$employee['Employee']['id'].'"> '.$employee['Employee']['firstname'].' '.$employee['Employee']['lastname'].'</a></h3>'; ?>
		</td>
		<td>

            <input type="hidden" name="data[Employee][Employee][<?php echo $employee['Employee']['id']; ?>][profile_id]" value="<?php echo $employee['Profile']['id']; ?>" id="EmployeeEmployee<?php echo $employee['Employee']['id']; ?>" />

            <input type="text" name="data[Employee][Employee][<?php echo $employee['Employee']['id']; ?>][internal_cat_id]" value="<?php echo $employee['Profile']['internal_cat_id']; ?>" id="EmployeeEmployee<?php echo $employee['Employee']['id']; ?>" />

        </td>
		<td>


            <input type="text" name="data[Employee][Employee][<?php echo $employee['Employee']['id']; ?>][internal_cat_thread_id]"" value="<?php echo $employee['Profile']['internal_cat_thread_id']; ?>" id="EmployeeEmployee<?php echo $employee['Employee']['id']; ?>" />

        </td>
		<td>

            <input type="text" name="data[Employee][Employee][<?php echo $employee['Employee']['id']; ?>][released_cat_id]"" value="<?php echo $employee['Profile']['released_cat_id']; ?>" id="EmployeeEmployee<?php echo $employee['Employee']['id']; ?>" />

        </td>
		<td >

            <input type="text" name="data[Employee][Employee][<?php echo $employee['Employee']['id']; ?>][released_cat_thread_id]"" value="<?php echo $employee['Profile']['released_cat_thread_id']; ?>" id="EmployeeEmployee<?php echo $employee['Employee']['id']; ?>" />


        </td>
	</tr>

<?php endforeach;


        echo $form->end('Submit');

        ?>
</table>
</div>