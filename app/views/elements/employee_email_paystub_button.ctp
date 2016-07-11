<a href="mailto:
<?php echo $first_last.'<'.$employeesEmail['email'].
'>?bcc=timecardtest@fogtest.com&subject='.
$subject.'&body='.
$body;?>">
<?php 
			if(!empty($employeesEmail['email']))
			{			
				echo $employeesEmail['email'];
			} else
			{
				echo 'please enter an email for this employee';
			}
			
			?></a>
