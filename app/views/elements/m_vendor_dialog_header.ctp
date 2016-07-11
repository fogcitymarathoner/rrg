
<div data-role="header">
    <h3>Vendor</h3>

    <div id='buttons'>
        <a href="<?php echo $this->webroot?>m/vendors/edit/<?php echo $vendor['id']?>" data-rel="dialog"  data-role="button" data-inline="true" data-icon="pencil_16x16">Edit</a>
        <a href="<?php echo $this->webroot?>m/vendors/delete/<?php echo $vendor['id']?>" rel='external' data-role="button" data-inline="true" data-icon="delete" onclick="return confirm('Are you sure you want to delete #<?php echo $vendor['id']?>?');">Delete</a>
    </div>
</div>

