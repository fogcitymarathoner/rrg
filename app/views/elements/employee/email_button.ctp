<?php
if(!empty($employeesEmail['email']))
{
    ?><a href="mailto:<?php echo $first_last.'<'.$employeesEmail['email'].'>';?>"><?php echo $employeesEmail['email'];?></a><?php
} else
{
    echo 'please enter an email for this employee';
}
?>