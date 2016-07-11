<?php //debug($employee); ?>
<div class="employees view">
    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot, ));?>
    <br>
<h2><?php 
__($page_title);?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('Edit General Info', true), array('action'=>'edit',$employee['Employee']['id']));?></li>
	</ul>
</div>
<p>
    <?php if($employee['Employee']['strikecount'] < 100){?>
                <script>
                    jQuery(function($) {
                        $(".progressbar").progressbar({
                            value: <?php echo $employee['Employee']['strikecount']; ?>
                        }).css({marginLeft:'100px'}).prev('p').css({float:'left',
                        lineHeight:'34px'});
                    });
                </script>
                <p>Completeness</p>
                <div class="progressbar"></div>
     <?php }?>
</p>

        <?php echo $this->element('employee/mailing_label', array('employee'=>$employee, 'webroot'=>$this->webroot)); ?>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['firstname']; ?>
			<?php echo $employee['Employee']['mi']; ?>
			<?php echo $employee['Employee']['lastname']; ?>
			<?php echo $employee['Employee']['nickname']; ?>
            &nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nickname'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Slug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['slug']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ssn'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['ssn_crypto']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Dob'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('m/d/Y',strtotime($employee['Employee']['dob'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Startdate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('m/d/Y',strtotime($employee['Employee']['startdate'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Enddate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('m/d/Y',strtotime($employee['Employee']['enddate'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Street1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['street1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Street2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['street2']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['city']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($employee['State']['name'], array('controller'=> 'states', 'action'=>'view', $employee['State']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Zip'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['zip']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Voided'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['voided']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active/Inactive'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $activeOptions[$employee['Employee']['active']]; ?>
			&nbsp;
		</dd>
        <?php if ($employee['Employee']['directdeposit'])
        {
        ?>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Bankaccountnumber'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                <?php echo $employee['Employee']['bankaccountnumber']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Bankaccounttype'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                <?php echo $employee['Employee']['bankaccounttype']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Bankname'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                <?php echo $employee['Employee']['bankname']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Bankroutingnumber'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                <?php echo $employee['Employee']['bankroutingnumber']; ?>
                &nbsp;
            </dd>
        <?php
        } else
        {
        ?>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('NO DIRECT DEPOSIT'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                <?php echo $employee['Employee']['directdeposit']; ?>
                &nbsp;
            </dd>
    <?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Allowancefederal'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['allowancefederal']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Allowancestate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['allowancestate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Extradeductionfed'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['extradeductionfed']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Extradeductionstate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['extradeductionstate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Maritalstatusfed'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['maritalstatusfed']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Maritalstatusstate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['maritalstatusstate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('US Work Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $i9Options[$employee['Employee']['usworkstatus']]; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tcard'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['tcard']; ?>
			&nbsp;
		</dd>		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('W4'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['w4']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('De34'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['de34']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('I9'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['i9']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Medical'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['medical']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Indust'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['indust']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Salesforce'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['salesforce']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Info'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['info']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['phone']; ?>
			&nbsp;
		</dd>
	</dl>

<div><?php echo $this->element('employee/web_document_management_label', array('employee'=>$employee,'webroot'=>$this->webroot)); ?></div>
<div><?php echo $employee['Employee']['slug']; ?></div>
<h4>Markdown for Wiki</h4>
<div>
* [<?php echo $employee['Employee']['slug']; ?>-released](/board/reply/<?php echo $employee['Profile']['released_cat_id']?>/<?php echo $employee['Profile']['released_cat_thread_id']?>) -
[SSN](https://cake.rocketsredglare.com/rrg/socials/from_slug/<?php echo $employee['Employee']['slug']; ?>/b0569824b20f8583e9a2084aa4d925660ec3b1b5) -
[Internal](/board/reply/<?php echo $employee['Profile']['internal_cat_id']?>/<?php echo $employee['Profile']['internal_cat_thread_id']?>)
<div>
<?php if (!empty($employee['EmployeesEmail'])):	?>
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
			}
		?>
            <tr<?php echo $class;?>>
            <td>
                <?php echo $this->element('employee/email_button', array('employeesEmail'=>$employeesEmail,'first_last'=>$employee['Employee']['firstname'].' '.$employee['Employee']['lastname'],));?>
            </td>
            </tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<div>
    <h4>Profile Info</h4>
<?php if (isset($employee['Profile']))
        {
            echo 'id '.$employee['Profile']['id'].'<br>';
            echo 'user_id '.$employee['Profile']['user_id'].'<br>';
            echo 'employee_id '.$employee['Profile']['employee_id'].'<br>';
            echo 'sphene_id '.$employee['Profile']['sphene_id'].'<br>';
            echo 'released_cat_id '.$employee['Profile']['released_cat_id'].'<br>';
            echo 'released_cat_thread_id '.$employee['Profile']['released_cat_thread_id'].'<br>';
            echo 'internal_cat_id '.' '.$employee['Profile']['internal_cat_id'].'<br>';
            echo 'internal_cat_thread_id '.$employee['Profile']['internal_cat_thread_id'].'<br>';
        } else {
             echo 'NO PROFILE REDORD FOR THIS EMPLOYEE';
        }
?>
</div>

<div>
    <h4>User Info</h4>
    <?php if (isset($employee['User']))
    {
        echo 'id '.$employee['User']['id'].'<br>';
    echo 'user_id '.$employee['User']['username'].'<br>';
    } else {
    echo 'NO User REDORD FOR THIS EMPLOYEE';
    }
    ?>
</div>