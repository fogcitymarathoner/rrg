
<?php echo $html->script('center_waiting');?>
<?php echo $html->css('urls');?>
<?php echo $this->element('urls',array());?>

<div><?php echo $html->css('employees_app');?></div>
<?php echo $this->element('employees/menu',array()); ?>
<?php echo $javascript->link('employees'); ?>
<div class="invoices index">
    <div><h2 class='employees-label-page-title'><?php __('Print these <?php echo count($employees) ?> employee labels to PDF');?></h2></div>
    <p>
        <?php echo $html->link(__('Return Employees', true), array('action'=>'index')); ?>
    </p>
    <div id='label-soap-message'>xxxx</div>
    <?php echo $form->create('Employees',array('action'=>'labels_pdf'));?>
    <input type="hidden" name="_method" value="POST" />
    <input type="radio" name="group1" value="Preview" id="preview-radio"> Preview
    <input type="radio" name="group1" value="Email" checked> Email
    <input id="employee-label-submit" type="submit" value="Preview" />
    <input TYPE=HIDDEN name="fixture-random" value="<?php echo $fixfile?>" id="fixture-random" >
    <input TYPE=HIDDEN name="user-id" value="<?php echo $currentUser?>" id="user-id" >
    <input TYPE=HIDDEN name="user_email" value="<?php echo $user['User']['email']?>" id="user_email" >
    <table>
        <tr>
            <th>Employees</th>
        </tr>
        <tr bgcolor="{cycle values="#dedede,#eeeeee"}">
        <td>
            ROW<select  name="row">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
            COLUMN<select  name="column">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        </td>
        </tr>
        <?php
$i = 0;foreach($employees as $employee):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}?>
        <tr <?php echo $class;?>">
        <td>
            <input TYPE=HIDDEN name="data[Employee][Employee][]" value="<?php echo $employee['Employee']['id']?>" id="EmployeeEmployee<?php echo $employee['Employee']['id']?>" >

            <?php echo $employee['Employee']['firstname']?> <?php echo $employee['Employee']['lastname']?>
        </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </form>