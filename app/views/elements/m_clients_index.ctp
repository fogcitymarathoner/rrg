
<?php

        foreach ($clients as $client):
                echo "<li>";
?>
        <a href="<?php echo $this->webroot?>m/clients/view/<?php echo $client['Client']['id']?>"  rel="external"><?php echo __($client['Client']['name'], true)?></a>
                <?php echo "</li>";
        endforeach;

?>
