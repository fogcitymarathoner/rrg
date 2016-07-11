<ul data-role="listview">

<?php
$keys = array_keys($clientsMenu);
foreach($keys as $key) {
?>
    <li><a href="<?php echo $webroot.'m/clients/add_check/2/'.$key?>"><?php echo $clientsMenu[$key]?></a></li>
<?php } ?>
</ul>