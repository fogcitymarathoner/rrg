
<script>
    var employeesJSON='<?php echo $employeesControl ?>';

    // Clear the check boxes
</script>
<?php
    echo $javascript->link('employees');
echo $html->css('two-col-web-ck-label-app');
echo $html->css('employees_app');
?>
<div class="select employees">
    <?php echo $this->element('employees/menu',array()); ?>

    <div><h2 class='employees-label-page-title'><?php __('Select Employees for Label Processing');?></h2></div>
    <p>
        <?php echo $html->link(__('Return Employees', true), array('action'=>'index')); ?>
        <?php echo $html->link(__('All Employees', true), array('action'=>'select_labels_all')); ?>
    </p>
    <input type="submit" id="select-all-employees" name="select-all-employees" value="Select All Employees" >
    <div id='employeeslist'>
        <form action="process_selection" id='setup-labels' name='setup-labels' method='post'>
            <table>

                <tr>
                    <th>Employees --- </th>
                </tr>
                <?php
	    if(!empty($employees))
	    {
$i = 0;foreach($employees as $employee):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}?>
                <tr <?php echo $class;?>">
                <td>
                    <input type="checkbox" name="data[Employee][Employee][]" value="<?php echo $employee['Employee']['id']?>" id="EmployeeEmployee<?php echo $employee['Employee']['id']?>" />
                    <label for="EmployeeEmployee<?php echo $employee['Employee']['id']?>"><?php echo $employee['Employee']['firstname']?> <?php echo $employee['Employee']['lastname']?></label>
                </td>
                </tr>
                <?php endforeach;
}
?>



            </table>
    </div>
    <input type="submit" id="setup-labels" name="setup-labels" value="Continue to setup Labels for printing" >
    </form>
    </form>