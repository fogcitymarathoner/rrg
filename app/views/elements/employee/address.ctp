<div> <?php echo $employee['Employee']['street1'];?></div>
        <?php  if($employee['Employee']['street2'])
                {?>
    <?php
                echo '<div>'.$employee['Employee']['street2'].'</div>'; ?>
    <?php     }
            ?>

    <div><?php echo $employee['Employee']['city'].', ';
            echo $employee['State']['post_ab'].' ';
            echo $employee['Employee']['zip'];?></div>

    <div style="position: relative; float: left">
        <?php     echo '<a href="tel:'.$employee['Employee']['phone'].'">'.$employee['Employee']['phone'].'</a>'; ?>
    </div>
