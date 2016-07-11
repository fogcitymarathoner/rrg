
<?php echo $this->element('m_vendor_dialog_header',array('vendor'=>$this->data['Vendor']));?>
<div data-role="content">
    <ul data-role="listview">

        <?php
                if (!empty($this->data['Vendor']))
                {
                    $vendor = $this->data['Vendor'];
                    echo "<li>";
                    echo "Company - ";
                    echo $vendor['name'].' - '.$vendor['purpose'];
                    echo "</li>";
                    if($vendor['apfirstname']!='' || $vendor['aplastname'])
                    {
                        echo "<li>";
                        echo "Name - ";
                        echo $vendor['apfirstname'].' '. $vendor['aplastname'];
                        echo "</li>";
                    }
                    if($vendor['apphone1']!='')
                    {
                        echo "<li>";
                        echo "Phone 1 - ";
                        echo '<a href="tel:'.$vendor['apphone1'].'">'.$vendor['apphone1'].'</a>';
                        echo "</li>";
                        }
                    if($vendor['apphone2']!='')
                    {
                        echo "<li>";
                        echo "Phone 2 - ";
                        echo '<a href="tel:'.$vendor['apphone2'].'">'.$vendor['apphone2'].'</a>';
                        echo "</li>";
                    }
                    if($vendor['accountnumber']!='')
                    {
                        echo "<li>";
                        echo "Account Number - ";
                        echo $vendor['accountnumber'];
                        echo "</li>";
                    }
                    echo "<li>";
                    echo "Address - ";
                    echo   '<a href="http://maps.google.com/?q='.
                    urlencode($vendor['street1']).'+'.
                    urlencode($vendor['city']).'+'.
                    urlencode($state['State']['post_ab']).'+'.
                    urlencode($vendor['zip']).'+'.
                    '" class="button" target="_blank">';
                    echo  $vendor['street1'].' '.$vendor['street2'].' '.$vendor['city'].'<br>';
                    echo $state['State']['post_ab'].' '.$vendor['zip'].'</a>';
                    echo "</li>";
                    if($vendor['notes']!='')
                    {
                        echo "<li>";
                        echo "Notes - ";
                        echo $vendor['notes'];
                        echo "</li>";
                    }
                    if($vendor['secretbits']!='')
                    {
                        echo "<li>";
                        echo "Secret Bits - ";
                        echo $vendor['secretbits'];
                        echo "</li>";
                    }
                    }
                ?>
        <li>
        <a href="<?php echo $this->webroot?>m/vendors/edit/<?php echo $vendor['id']?>" rel='external'>Edit</a>
        </li>
        <li><a href="<?php echo $this->webroot?>m/vendors/add" rel='external' >New Vendor</a>

        </li>
        <li><a href="<?php echo $this->webroot?>m/vendors/delete/<?php echo $vendor['id']?>" rel='external' onclick="return confirm('Are you sure you want to delete #<?php echo $vendor['id']?>?');">Delete</a>

        </li>
</ul>
</div>
