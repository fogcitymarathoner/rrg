<div id='payroll-menu'>
    <?php echo $this->element('payroll/menu', array('payroll'=>$payroll['Payroll'],'webroot'=>$this->webroot,));?>
</div>
<div class="payrolls view">

    <div id='label-soap-message'>xxxx</div>
        <?php echo $form->create('Employees',array('action'=>'labels_pdf'));?>
        <input type="hidden" name="_method" value="POST" />
        <input type="radio" name="group1" value="Preview" id="preview-radio"> Preview
        <input type="radio" name="group1" value="Email" checked> Email
        <div id="label-row-column-select">
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
    </div>
    <input id="label-submit" type="submit" value="Preview" />
    </form>

</div>

    <script xmlns="http://www.w3.org/1999/html">var labelsheetdata = jQuery.parseJSON('<?php echo $employeesControl; ?>');</script>

    <?php echo $html->script('payrolls');?>




<?php echo $javascript->link('jquery.tablednd_0_5'); ?>
<?php echo $html->css('urls');?>
<?php echo $this->element('urls',array());?>
<?php echo $html->script('payrolls');?>
<?php echo $html->css('payrolls');?>
