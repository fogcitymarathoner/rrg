<?php //debug($this->data['Employee']); exit;?>
<?php echo $this->element('m_employee_dialog_header',array('employee'=>$this->data['Employee'],'type'=>$type));?>
<div data-role="content">
    <ul data-role="listview">

        <?php
                if (!empty($this->data['Employee']))
                {
                    $Employee = $this->data['Employee'];
                    echo "<li>";
                    echo "Company - ";
                    echo $Employee['firstname'].' '. $Employee['lastname'];
                    echo "</li>";
                    if($Employee['phone']!='')
                    {
                        echo "<li>";
                        echo "Phone - ";
                        echo '<a href="tel:'.$Employee['phone'].'">'.$Employee['phone'].'</a>';
                        echo "</li>";
                        }
                    echo "<li>";

                if($emails[0]['EmployeesEmail']['email']!=null)
                {
                    echo "<h4>Email</h4>";
                    echo '<a href="mailto:'.$emails[0]['EmployeesEmail']['email'].'">'.$emails[0]['EmployeesEmail']['email'].'</a>';
                    echo "</li>";
                }
                echo "<li>";
                    echo "Address - ";
                    echo   '<a href="http://maps.google.com/?q='.
                    urlencode($Employee['street1']).'+'.
                    urlencode($Employee['city']).'+'.
                    urlencode($state['State']['post_ab']).'+'.
                    urlencode($Employee['zip']).'+'.
                    '" class="button" target="_blank">';
                    echo  $Employee['street1'].' '.$Employee['street2'].' '.$Employee['city'].'<br>';
                    echo $state['State']['post_ab'].' '.$Employee['zip'].'</a>';
                    echo "</li>";
                    if($Employee['notes']!='')
                    {
                        echo "<li>";
                        echo "Notes - ";
                        echo $Employee['notes'];
                        echo "</li>";
                    }
                    }
                ?>

    </ul>
</div>
