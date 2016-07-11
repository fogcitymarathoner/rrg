
<div data-role="navbar">
    <ul>
        <li><a href="<?php echo $this->webroot.'m/expenses/add/'?>"  data-rel='dialog' data-role='button' data-inline="true" data-icon='plus'>New Expense</a></li>

        <li><a href="<?php echo $this->webroot.'m/expenses/index_categories/'?>"  data-rel='external' data-role='button' data-inline="true" data-icon='plus'>Expense Categories</a></li>
    </ul>
</div>



    <ul data-role="listview">

<?php echo $this->element('m_expenses_categoryview',array('expenses'=>$expenses));?>

    </ul>
