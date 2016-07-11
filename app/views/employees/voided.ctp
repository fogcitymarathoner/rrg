<?php echo $javascript->link('employees');?>
<div class="employees index">
    <?php echo $this->element('employees/menu',array()); ?>
    <br>
    <h2><?php __('Employees');?></h2>
    </br>
    <p>
        <?php
echo $paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?>
    </p>
    <table cellpadding = "3" cellspacing = "3" border=1>
        <tr>
            <th><?php echo $paginator->sort('firstname');?></th>
            <th><?php echo $paginator->sort('nickname');?></th>
            <th><?php echo $paginator->sort('lastname');?></th>
            <th><?php echo $paginator->sort('phone');?></th>
            <th class="actions"><?php __('Actions');?></th>
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
            <?php echo '<h3>'.$employee['Employee']['firstname'].'</h3>'; ?>
        </td>
        <td>
            <?php echo '<h3>'.$employee['Employee']['nickname'].'</h3>'; ?>
        </td>
        <td>
            <?php echo '<h3>'.$employee['Employee']['lastname'].'</h3>'; ?>
        </td>
        <td>
            <?php echo $employee['Employee']['phone']; ?>
        </td>
        <td class="actions">
            <?php echo $html->link(__('Manage', true), array('action'=>'view', $employee['Employee']['id'])); ?>
        </td>
        </tr>

            <tr<?php echo $class;?>>
        <td colspan=4>
            <?php
				echo '<b><div id="employee-name-'.$employee['Employee']['id'].'">'.$employee['Employee']['firstname'].' '.$employee['Employee']['lastname'].'</div>';
            echo $employee['Employee']['street1'].'<br>';
            if($employee['Employee']['street2'])
            echo $employee['Employee']['street2'].'<br>';
            echo $employee['Employee']['city'].', ';
            echo $employee['State']['post_ab'].' ';
            echo $employee['Employee']['zip'].'</b><br>';
            echo '<a href="tel:'.$employee['Employee']['phone'].'">'.$employee['Employee']['phone'].'</a>';
            ?>
            <?php if (!empty($employee['EmployeesEmail'])):
					?>
            <table cellpadding = "0" cellspacing = "0">
                <tr>
                    <th><?php __('email'); ?></th>
                </tr>
                <?php
		$i = 0;
		foreach ($employee['EmployeesEmail'] as $employeesEmail):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}?>
            <tr<?php echo $class;?>>
            <td>
                <?php echo $this->element('employee/email_button', array('employeesEmail'=>$employeesEmail, 'first_last'=>$employee['Employee']['firstname'].' '.$employee['Employee']['lastname'], )); ?>
            </td>
            </tr>
        <?php endforeach;?>
            </table>
            <?php endif; ?>

        </td>
        <td class="actions"></td>
        <tr<?php echo $class;?>>
        <td colspan=5>
            <?php echo $this->element('employees/reminderbuttons',
            array( 'employee'=>$employee,
            'completelist'=>$completelist,
            'webroot'=>$this->webroot));
            ?>
        </td>
        </tr>
        <?php endforeach; ?>
        <?php
	if(empty($employee['Employee']['ssn_crypto']) || empty($employee['Employee']['city']) || empty($employee['Employee']['zip']))
	{
		echo '<tr<?php echo $class;?>>';
        if(empty($employee['Employee']['ssn_crypto']))
        {
        echo '<td>NO SNN</td>';
        }
        else
        {
        echo '<td></td>';
        }
        if(empty($employee['Employee']['city']))
        {
        echo '<td>NO CITY</td>';
        }
        else
        {
        echo '<td></td>';
        }
        if(empty($employee['Employee']['zip']))
        {
        echo '<td>NO Zip</td>';
        }
        else
        {
        echo '<td></td>';
        }
        echo '</tr>';
        }

        ?>
    </table>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
    | 	<?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
