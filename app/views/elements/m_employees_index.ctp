
<?php

        foreach ($employees as $emp):
                echo "<li>";
?>
        <a href="<?php echo $this->webroot?>m/employees/view/<?php echo $emp['emp']['id']?>"  data-rel="dialog"><?php echo __($emp['emp']['firstname'].' '.$emp['emp']['lastname'], true)?></a>
                <?php echo "</li>";
        endforeach;

?>
