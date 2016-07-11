<?php
echo $client['name'];
echo '<br>';
echo $client['street1'];
echo '<br>';
if ($client['street2'])
{
    echo $client['street2'];
    echo '<br>';
}
echo $client['city'].', ';
echo $client['state'].' ';
echo $client['zip'];
echo '<br>';

echo '<a href="'.$webroot.'clients/edit/'.$client['id'].'">|edit|</a>';
