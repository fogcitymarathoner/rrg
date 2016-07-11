<?php echo $this->element('m/client_dialog_header',array('clientD'=>$this->data['Client']));?>
<div data-role="content">
    <ul data-role="listview">
        <?php
                if (!empty($this->data['Client']))
                {
                    $Client = $this->data['Client'];
                    $State  = $this->data['State'];
                    echo "<li>";
                    echo "Company - ";
                    echo $Client['name'];
                    echo "</li>";
                    echo "<li>";
                    echo "Address - ";
                    echo   '<a href="http://maps.google.com/?q='.
                    urlencode($Client['street1']).'+'.
                    urlencode($Client['city']).'+'.
                    urlencode($State['post_ab']).'+'.
                    urlencode($Client['zip']).'+'.
                    '" class="button" target="_blank">';
                    echo  $Client['name'].'<br>';
                    echo  $Client['street1'].' '.$Client['street2'].'<br>'.$Client['city'].', ';
                    echo $State['post_ab'].' '.$Client['zip'].'</a>';
                    echo "</li>";
                    }
                ?>
        </ul>
</div>
